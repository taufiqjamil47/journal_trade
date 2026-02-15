<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Trade;
use App\Models\Symbol;
use App\Models\Account;
use App\Models\TradingRule;
use Illuminate\Http\Request;
use App\Exports\TradesExport;
use App\Imports\TradesImport;
use App\Services\PdfReportService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exceptions\DataNotFoundException;
use App\Services\PerformanceMonitorService;

class TradeController extends Controller
{
    public function index(Request $request)
    {
        $perf = (new PerformanceMonitorService)->start('TradeController::index');

        $sortBy = $request->get('sort_by', 'id');
        $order  = $request->get('order', 'desc');
        $selectedAccountId = session('selected_account_id');

        // Eager load relationships untuk avoid N+1 queries - FILTER BY SELECTED ACCOUNT
        $query = Trade::with('symbol', 'tradingRules')
            ->where('account_id', $selectedAccountId);
        $perf->checkpoint('eager_load_initialized');

        $trades = $query->orderBy($sortBy, $order)->paginate(10);
        $perf->checkpoint('trades_fetched');

        // HITUNG WINRATE DARI TRADE DI ACCOUNT YANG DIPILIH
        $allTrades = Trade::where('account_id', $selectedAccountId)
            ->select('id', 'hasil')
            ->get();
        $totalTrades = $allTrades->count();
        $wins = $allTrades->where('hasil', 'win')->count();
        $winrate = $totalTrades > 0 ? round(($wins / $totalTrades) * 100, 2) : 0;
        $perf->checkpoint('winrate_calculated');

        $perf->end('Trade index rendered');

        return view('trades.index', compact(
            'trades',
            'sortBy',
            'order',
            'winrate'
        ));
    }

    public function create()
    {
        try {
            $symbols = Symbol::where('active', true)
                ->get()
                ->map(function ($symbol) {
                    $symbol->formatted_pip_value = (float) $symbol->pip_value;
                    $symbol->formatted_pip_worth = (float) ($symbol->pip_worth ?? 10);
                    return $symbol;
                });
            if ($symbols->isEmpty()) {
                Log::warning('No active symbols available');
            }

            // Get selected account from session
            $selectedAccountId = session('selected_account_id');
            $selectedAccount = Account::findOrFail($selectedAccountId);
            $currentEquity = $this->getCurrentEquity($selectedAccountId);
            $tradingRules = TradingRule::where('is_active', true)
                ->orderBy('order')
                ->get();

            return view('trades.create', compact('symbols', 'currentEquity', 'tradingRules', 'selectedAccount'));
        } catch (\Exception $e) {
            Log::error('Error loading create trade form: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat form pembuatan trade');
        }
    }

    public function edit($id)
    {
        try {
            $trade = Trade::with('tradingRules', 'account')->findOrFail($id);

            $account = $trade->account;
            if (!$account) {
                Log::error('No account found for trade: ' . $id);
                throw new DataNotFoundException('Account');
            }

            $initialBalance = $account->initial_balance;

            // PERBAIKAN: Hitung balance yang benar termasuk semua trade selesai kecuali yang sedang diedit
            $completedTrades = Trade::where('exit', '!=', null)
                ->where('id', '!=', $id) // JANGAN sertakan trade yang sedang diedit
                ->where('account_id', $account->id) // Hanya trade dari account yang sama
                ->get();

            $balance = $initialBalance + $completedTrades->sum('profit_loss');

            $tradingRules = TradingRule::where('is_active', true)
                ->orderBy('order')
                ->get();

            return view('trades.edit', compact('trade', 'balance', 'tradingRules', 'account'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning("Trade not found: ID {$id}");
            return back()->with('error', "Trade dengan ID {$id} tidak ditemukan");
        } catch (\Exception $e) {
            Log::error('Error loading edit form: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat form edit trade');
        }
    }

    public function update(Request $request, $id)
    {
        $trade = \App\Models\Trade::with('symbol', 'account', 'tradingRules')->findOrFail($id);

        $data = $request->validate([
            'exit' => 'required|numeric',
            'lot_size' => 'nullable|numeric|min:0.01',
            'risk_percent' => 'nullable|numeric|min:0|max:100',
            'risk_usd' => 'nullable|numeric|min:0',
            'rules' => 'nullable|array',
            'rules.*' => 'exists:trading_rules,id',
            'partial_close_percent' => 'nullable|numeric|min:0|max:100', // ⬅️ TAMBAHKAN
            'partial_close_custom' => 'nullable|numeric|min:0|max:100', // ⬅️ TAMBAHKAN
            'use_partial_close' => 'nullable|boolean', // ⬅️ TAMBAHKAN
        ]);

        $trade->exit = $data['exit'];

        // LOGIKA PARTIAL CLOSE
        $partialPercent = 100; // default full close

        if ($request->has('use_partial_close') && $request->boolean('use_partial_close')) {
            // Gunakan custom input jika diisi, jika tidak gunakan preset
            if (!empty($data['partial_close_custom']) && $data['partial_close_custom'] > 0) {
                $partialPercent = min(100, max(0, $data['partial_close_custom']));
            } elseif (!empty($data['partial_close_percent'])) {
                $partialPercent = $data['partial_close_percent'];
            }
        }

        // Hitung Exit Pips (keep higher precision here to avoid premature rounding)
        $pipValue = $trade->symbol->pip_value;
        if ($trade->type === 'buy') {
            $rawExitPips = ($trade->exit - $trade->entry) / $pipValue;
        } else {
            $rawExitPips = ($trade->entry - $trade->exit) / $pipValue;
        }
        // Store with more precision; rounding for display can be done in view
        $trade->exit_pips = round($rawExitPips, 4);

        // PERBAIKAN: Hitung balance yang benar untuk perhitungan risk%
        $initialBalance = $trade->account->initial_balance;

        // Ambil semua trade selesai SEBELUM trade ini (dengan exit != null dan id < $id)
        $previousTrades = Trade::where('account_id', $trade->account_id)
            ->where('id', '<', $id)
            ->where('exit', '!=', null)
            ->get();

        $accountBalance = $initialBalance + $previousTrades->sum('profit_loss');

        // VARIABLE UNTUK MENYIMPAN risk_usd
        $calculatedRiskUSD = null;
        // Use symbol configured pip worth when available to match server-side P/L
        $pipWorth = $trade->symbol->pip_worth ?? 10; // default: $10 per pip per 1 lot
        $slPips = $trade->sl_pips ?? 0;

        // PRIORITASKAN RISK PERCENT JIKA DIISI
        if (!empty($data['risk_percent']) && $slPips > 0) {
            $calculatedRiskUSD = $accountBalance * ($data['risk_percent'] / 100);
            $lotSize = $calculatedRiskUSD / ($slPips * $pipWorth);

            $trade->risk_percent = $data['risk_percent'];
            $trade->lot_size = round($lotSize, 2);
            $trade->risk_usd = round($calculatedRiskUSD, 2);
        } elseif (!empty($data['lot_size'])) {
            // JIKA LOT SIZE DIISI
            $calculatedRiskUSD = $slPips * $pipWorth * $data['lot_size'];
            $riskPercent = $accountBalance > 0 ? ($calculatedRiskUSD / $accountBalance) * 100 : 0;

            $trade->lot_size = $data['lot_size'];
            $trade->risk_percent = round($riskPercent, 2);
            $trade->risk_usd = round($calculatedRiskUSD, 2);
        } elseif (!empty($data['risk_usd'])) {
            // JIKA RISK USD DIISI LANGSUNG
            $riskPercent = $accountBalance > 0 ? ($data['risk_usd'] / $accountBalance) * 100 : 0;
            $lotSize = $slPips > 0 ? $data['risk_usd'] / ($slPips * $pipWorth) : 0;

            $trade->risk_usd = $data['risk_usd'];
            $trade->risk_percent = round($riskPercent, 2);
            $trade->lot_size = $slPips > 0 ? round($lotSize, 2) : 0.01;
        } else {
            // DEFAULT JIKA TIDAK ADA INPUT
            $trade->lot_size = $trade->lot_size ?? 0.01;
            $trade->risk_percent = $trade->risk_percent ?? 0;
            $trade->risk_usd = $trade->risk_usd ?? 0;
        }

        // JIKA risk_usd DIINPUT MANUAL DAN TIDAK PAKAI RISK%, GUNAKAN YANG MANUAL
        if (!empty($data['risk_usd']) && empty($data['risk_percent'])) {
            $trade->risk_usd = $data['risk_usd'];
        }

        // APLIKASI PARTIAL CLOSE PADA LOT SIZE
        if ($partialPercent < 100) {
            $trade->lot_size = $trade->lot_size * ($partialPercent / 100);
            $trade->partial_close_percent = $partialPercent; // Simpan persentase yang digunakan
        }

        // Hitung Profit/Loss USD using high-precision pips calculation
        $grossProfitLoss = ($rawExitPips ?? $trade->exit_pips) * $trade->lot_size * $pipWorth;

        // Kurangi commission
        $commission = $trade->account->commission_per_lot * $trade->lot_size;
        $netProfitLoss = $grossProfitLoss - $commission;

        $trade->profit_loss = round($netProfitLoss, 2);

        // Tentukan hasil trade
        if ($trade->profit_loss > 0) {
            $trade->hasil = 'win';
        } elseif ($trade->profit_loss < 0) {
            $trade->hasil = 'loss';
        } else {
            $trade->hasil = 'be';
        }

        // Ambil trade terakhir sebelum ini
        $lastTrade = \App\Models\Trade::where('account_id', $trade->account_id)
            ->where('id', '<', $trade->id)
            ->orderBy('id', 'desc')
            ->first();

        if ($lastTrade) {
            if ($trade->hasil === 'win') {
                $trade->streak_win = $lastTrade->hasil === 'win' ? $lastTrade->streak_win + 1 : 1;
                $trade->streak_loss = 0;
            } elseif ($trade->hasil === 'loss') {
                $trade->streak_loss = $lastTrade->hasil === 'loss' ? $lastTrade->streak_loss + 1 : 1;
                $trade->streak_win = 0;
            } else { // be
                $trade->streak_win = $lastTrade->streak_win;
                $trade->streak_loss = $lastTrade->streak_loss;
            }
        } else {
            // trade pertama
            if ($trade->hasil === 'win') {
                $trade->streak_win = 1;
                $trade->streak_loss = 0;
            } elseif ($trade->hasil === 'loss') {
                $trade->streak_loss = 1;
                $trade->streak_win = 0;
            } else {
                $trade->streak_win = 0;
                $trade->streak_loss = 0;
            }
        }

        $trade->fill($data);
        $trade->setSessionFromTimestamp();

        // Wrap save + rule sync in transaction
        DB::transaction(function () use ($request, $trade, $partialPercent) {
            // SYNC RULES JIKA ADA
            if ($request->has('rules')) {
                $trade->tradingRules()->sync($request->rules);

                $ruleNames = \App\Models\TradingRule::whereIn('id', $request->rules)
                    ->pluck('name')
                    ->toArray();

                $trade->withoutEvents(function () use ($trade, $ruleNames) {
                    $trade->update(['rules' => implode(',', $ruleNames)]);
                });
            } else {
                // Jika tidak ada rules yang dipilih
                $trade->tradingRules()->detach();
                $trade->withoutEvents(function () use ($trade) {
                    $trade->update(['rules' => null]);
                });
            }

            // Simpan persentase partial close jika digunakan
            if ($partialPercent < 100) {
                $trade->partial_close_percent = $partialPercent;
            }

            $trade->save();
        });

        // Tampilkan pesan berdasarkan apakah partial close digunakan
        $message = $partialPercent < 100
            ? "Trade berhasil diperbarui dengan Partial Close {$partialPercent}%"
            : 'Trade berhasil diperbarui dengan Exit, Risk%, dan Lot Size';

        return redirect()->route('trades.index')->with('success', $message);
    }

    public function store(Request $request)
    {
        $perf = (new PerformanceMonitorService)->start('TradeController::store');

        try {
            $data = $request->validate([
                'symbol_id'   => 'required|exists:symbols,id',
                // accept time-only in H:i format
                'timestamp'   => 'required|date_format:H:i',
                'date'        => 'required|date_format:Y-m-d',
                'type'        => 'required|in:buy,sell',
                'entry'       => 'required|numeric',
                'stop_loss'   => 'required|numeric',
                'take_profit' => 'required|numeric',
                'before_link' => 'nullable|url', // ⬅️ TAMBAHKAN INI
                'rules'       => 'nullable|array',
                'rules.*'     => 'exists:trading_rules,id'
            ]);
            $perf->checkpoint('validation_passed');

            // Combine date + time into full timestamp (DB stores datetime)
            try {
                $combined = $data['date'] . ' ' . $data['timestamp'];
                $data['timestamp'] = Carbon::createFromFormat('Y-m-d H:i', $combined)->toDateTimeString();
            } catch (\Exception $e) {
                // fallback: parse tolerant
                $data['timestamp'] = Carbon::parse($data['date'] . ' ' . $data['timestamp'])->toDateTimeString();
            }

            // ambil konfigurasi symbol
            $symbol = Symbol::findOrFail($data['symbol_id']);

            // hitung otomatis pips
            $slPips = $this->calculatePips($data['entry'], $data['stop_loss'], $data['type'], $symbol);
            $tpPips = $this->calculatePips($data['entry'], $data['take_profit'], $data['type'], $symbol);

            $data['sl_pips'] = $slPips;
            $data['tp_pips'] = $tpPips;

            // HITUNG RR RATIO
            if ($slPips > 0) {
                $data['rr'] = round($tpPips / $slPips, 2);
            } else {
                $data['rr'] = 0;
            }

            // Get account_id dari session (selected account)
            $data['account_id'] = session('selected_account_id');

            // Jalankan transaction dan dapatkan hasilnya
            $trade = DB::transaction(function () use ($data, $request, $perf) {
                $trade = new Trade($data);
                $trade->account_id = session('selected_account_id');

                // Set session otomatis
                $trade->setSessionFromTimestamp();

                $trade->save();
                $perf->checkpoint('trade_saved');

                // SYNC RULES JIKA ADA (setelah trade dibuat)
                if ($request->has('rules')) {
                    // 1. Sync ke pivot table
                    $trade->tradingRules()->sync($request->rules);

                    // 2. Ambil nama rules untuk kolom
                    $ruleNames = \App\Models\TradingRule::whereIn('id', $request->rules)
                        ->pluck('name')
                        ->toArray();

                    // 3. Update kolom rules (tanpa trigger event)
                    $trade->withoutEvents(function () use ($trade, $ruleNames) {
                        $trade->update(['rules' => implode(',', $ruleNames)]);
                    });
                    $perf->checkpoint('rules_synced');
                }

                return $trade; // Return trade dari closure
            });

            $perf->end('Trade created successfully');
            Log::info('Trade created successfully', ['trade_id' => $trade->id, 'symbol_id' => $data['symbol_id'], 'account_id' => $data['account_id']]);
            return redirect()->route('trades.index')->with('success', 'Trade berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation error when creating trade', ['errors' => $e->errors()]);
            return back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            $perf->end('Trade creation failed');
            Log::error('Error creating trade: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return back()->withInput()->with('error', 'Gagal membuat trade: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $trade = Trade::with('symbol', 'account', 'tradingRules')->findOrFail($id);

            // Generate image URLs dari berbagai tipe link (TradingView, S3, direct images, etc)
            $beforeChartImage = $this->processImageUrl($trade->before_link);
            $afterChartImage = $this->processImageUrl($trade->after_link);

            return view('trades.show', compact('trade', 'beforeChartImage', 'afterChartImage'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning("Trade not found: ID {$id}");
            return back()->with('error', "Trade dengan ID {$id} tidak ditemukan");
        } catch (\Exception $e) {
            Log::error('Error loading trade details: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat detail trade');
        }
    }

    public function detail($id)
    {
        try {
            $trade = Trade::with('symbol', 'account', 'tradingRules')->findOrFail($id);

            // Get rule names
            $ruleNames = $trade->tradingRules->pluck('name')->toArray();

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $trade->id,
                    'symbol' => [
                        'name' => $trade->symbol->name
                    ],
                    'type' => $trade->type,
                    'session' => $trade->session,
                    'timestamp' => $trade->timestamp,
                    'entry' => $trade->entry,
                    'exit' => $trade->exit,
                    'exit_pips' => $trade->exit_pips,
                    'stop_loss' => $trade->stop_loss,
                    'take_profit' => $trade->take_profit,
                    'sl_pips' => $trade->sl_pips,
                    'tp_pips' => $trade->tp_pips,
                    'lot_size' => $trade->lot_size,
                    'risk_percent' => $trade->risk_percent,
                    'risk_usd' => $trade->risk_usd,
                    'profit_loss' => $trade->profit_loss,
                    'rr' => $trade->rr,
                    'hasil' => $trade->hasil,
                    'rules' => $ruleNames,
                    'before_link' => $trade->before_link,
                    'after_link' => $trade->after_link,
                ]
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning("Trade detail not found: ID {$id}");
            return response()->json([
                'success' => false,
                'message' => "Trade dengan ID {$id} tidak ditemukan"
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error loading trade detail: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat detail trade'
            ], 500);
        }
    }

    public function duplicate(Trade $trade)
    {
        try {
            // Clone trade data
            $newTrade = $trade->replicate();

            // Reset beberapa field yang perlu unique
            $newTrade->exit = null;
            $newTrade->exit_timestamp = null;
            $newTrade->exit_pips = null;
            $newTrade->profit_loss = null;
            $newTrade->hasil = null;
            $newTrade->streak_win = 0;
            $newTrade->streak_loss = 0;
            // $newTrade->before_link = null;
            $newTrade->after_link = null;

            // Simpan trade baru
            $newTrade->save();

            // Duplikasi hubungan dengan trading rules
            if ($trade->tradingRules()->exists()) {
                $ruleIds = $trade->tradingRules()->pluck('trading_rules.id')->toArray();
                $newTrade->tradingRules()->sync($ruleIds);

                // Update kolom rules
                $ruleNames = TradingRule::whereIn('id', $ruleIds)
                    ->pluck('name')
                    ->toArray();
                $newTrade->update(['rules' => implode(',', $ruleNames)]);
            }

            Log::info('Trade duplicated successfully', [
                'original_id' => $trade->id,
                'new_id' => $newTrade->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Trade berhasil diduplikasi',
                'data' => [
                    'new_id' => $newTrade->id,
                    'edit_url' => route('trades.edit', $newTrade->id)
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error duplicating trade: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menduplikasi trade: ' . $e->getMessage()
            ], 500);
        }
    }

    // destroy method
    public function destroy(Request $request, $id)
    {
        try {
            $trade = Trade::findOrFail($id);

            // Simpan info untuk response
            $tradeInfo = [
                'id' => $trade->id,
                'symbol' => $trade->symbol->name,
                'type' => $trade->type
            ];

            // Hapus trade
            $trade->delete();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Trade berhasil dihapus',
                    'data' => $tradeInfo
                ]);
            }

            return redirect()->route('trades.index')
                ->with('success', 'Trade berhasil dihapus');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus trade',
                    'error' => $e->getMessage()
                ], 500);
            }

            return redirect()->route('trades.index')
                ->with('error', 'Gagal menghapus trade: ' . $e->getMessage());
        }
    }

    // app/Http/Controllers/TradeController.php
    public function clearAll(Request $request)
    {
        // Debug log
        Log::info('Clear All Trades Request:', [
            'confirmation' => $request->all(),
            'ajax' => $request->ajax(),
            'expectsJson' => $request->expectsJson()
        ]);

        // Support both form submit and AJAX
        $confirmation = $request->input('confirmation') ??
            ($request->json('confirmation') ?? null);

        // Validate confirmation
        if ($confirmation !== 'DELETE_ALL_TRADES') {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => '❌ Kode konfirmasi tidak valid. Silakan ketik DELETE_ALL_TRADES.'
                ], 400);
            }

            return redirect()->route('trades.index')
                ->with('error', '❌ Kode konfirmasi tidak valid')
                ->with('icon', 'error');
        }

        try {
            // SIMPLE APPROACH - tanpa transaction (karena TRUNCATE auto-commit)

            // 1. Nonaktifkan foreign key check
            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            // 2. Hapus semua data di pivot table terlebih dahulu
            DB::table('trade_rule')->truncate();
            Log::info('Pivot table cleared');

            // 3. Hapus semua trades
            DB::table('trades')->truncate();
            Log::info('Trades table cleared');

            // 4. Reset auto increment
            DB::statement('ALTER TABLE trades AUTO_INCREMENT = 1');
            DB::statement('ALTER TABLE trade_rule AUTO_INCREMENT = 1');
            Log::info('Auto-increment reset');

            // 5. Aktifkan kembali foreign key check
            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            // 6. Clear session/cache jika ada
            session()->forget('trade_stats');
            Log::info('Session cleared');

            // Success response
            $successMessage = '✅ Semua perdagangan telah berhasil diselesaikan!';
            Log::info($successMessage);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $successMessage,
                    'count' => 0,
                    'timestamp' => now()->toDateTimeString()
                ], 200);
            }

            return redirect()->route('trades.index')
                ->with('success', $successMessage)
                ->with('icon', 'success');
        } catch (\Exception $e) {
            // ERROR HANDLING

            // Pastikan foreign key check kembali aktif jika error
            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            $errorMessage = '❌ Gagal menyelesaikan perdagangan: ' . $e->getMessage();
            Log::error('Kesalahan Hapus Semua Perdagangan: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage,
                    'error' => config('app.debug') ? $e->getMessage() : null,
                    'file' => config('app.debug') ? $e->getFile() : null,
                    'line' => config('app.debug') ? $e->getLine() : null
                ], 500);
            }

            return redirect()->route('trades.index')
                ->with('error', $errorMessage)
                ->with('icon', 'error');
        }
    }

    private function calculatePips($entry, $target, $type, $symbol)
    {
        $pipValue = $symbol->pip_value; // misal GBPUSD = 0.0001

        if ($type === 'buy') {
            return round(abs(($target - $entry) / $pipValue), 1);
        }

        if ($type === 'sell') {
            return round(abs(($entry - $target) / $pipValue), 1);
        }

        return 0;
    }

    public function evaluate($id)
    {
        $trade = Trade::with('tradingRules')->findOrFail($id); // Update ini
        $tradingRules = TradingRule::where('is_active', true) // Tambahkan ini
            ->orderBy('order')
            ->get();

        return view('trades.evaluate', compact('trade', 'tradingRules'));
    }

    public function saveEvaluation(Request $request, $id)
    {
        $trade = Trade::with('tradingRules')->findOrFail($id);

        $data = $request->validate([
            'entry_type'      => 'nullable|string',
            'follow_rules'    => 'nullable|boolean',
            'rules'           => 'nullable|array',
            'rules.*'         => 'exists:trading_rules,id',
            'market_condition' => 'nullable|string',
            'entry_reason'    => 'nullable|string',
            'why_sl_tp'       => 'nullable|string',
            'entry_emotion'   => 'nullable|string',
            'close_emotion'   => 'nullable|string',
            'note'            => 'nullable|string',
            'before_link'     => 'nullable|url',
            // 'after_link'      => 'nullable|url',
            // Exit timestamp inputs (evaluate view)
            'exit_date'       => 'nullable|date_format:Y-m-d',
            'exit_time'       => 'nullable|date_format:H:i',
        ]);

        // Update field lainnya
        $trade->fill($request->except('rules'));

        // If exit date and/or time provided, combine into exit_timestamp
        $exitDate = $request->input('exit_date');
        $exitTime = $request->input('exit_time');

        if ($exitDate || $exitTime) {
            // Default missing parts: if date missing use trade->date, if time missing use current time
            $datePart = $exitDate ?? $trade->date?->format('Y-m-d') ?? now()->format('Y-m-d');
            $timePart = $exitTime ?? now()->format('H:i');

            try {
                $combined = Carbon::parse($datePart . ' ' . $timePart);
                $trade->exit_timestamp = $combined;
            } catch (\Exception $e) {
                // If parse fails, ignore and let validation/controller handle
                Log::warning('Gagal parse exit_date/exit_time: ' . $e->getMessage(), [
                    'exit_date' => $exitDate,
                    'exit_time' => $exitTime,
                    'trade_id' => $trade->id
                ]);
            }
        }

        // Wrap evaluation save + pivot sync in transaction
        DB::transaction(function () use ($request, $trade) {
            // SYNC RULES: Pivot Table → Kolom Rules
            if ($request->has('rules')) {
                // 1. Sync ke pivot table
                $trade->tradingRules()->sync($request->rules);

                // 2. Ambil nama rules untuk kolom
                $ruleNames = \App\Models\TradingRule::whereIn('id', $request->rules)
                    ->pluck('name')
                    ->toArray();

                // 3. Update kolom rules (tanpa trigger event)
                $trade->withoutEvents(function () use ($trade, $ruleNames) {
                    $trade->update(['rules' => implode(',', $ruleNames)]);
                });
            } else {
                // Jika tidak ada rules yang dipilih
                $trade->tradingRules()->detach();
                $trade->withoutEvents(function () use ($trade) {
                    $trade->update(['rules' => null]);
                });
            }

            // Save perubahan lainnya
            $trade->save();
        });

        return redirect()->route('trades.index')
            ->with('success', 'Evaluasi trade berhasil disimpan');
    }

    // exportExcel dan importExcel methods
    public function exportExcel()
    {
        $perf = (new PerformanceMonitorService)->start('TradeController::exportExcel');

        try {
            $perf->checkpoint('export_started');
            Log::info('Exporting trades to Excel');

            // Get selected account from session
            $selectedAccountId = session('selected_account_id');
            $account = Account::find($selectedAccountId);
            $accountName = $account ? $account->name : 'Unknown';

            $fileName = 'trades_' . $accountName . '_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
            $perf->checkpoint('filename_prepared');

            $perf->end('Excel export generated');
            // Pass account ID to export class
            return Excel::download(new TradesExport($selectedAccountId), $fileName);
        } catch (\Exception $e) {
            $perf->end('Excel export failed');
            Log::error('Error exporting trades: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengekspor trades: ' . $e->getMessage());
        }
    }

    // importExcel method
    public function importExcel(Request $request)
    {
        $perf = (new PerformanceMonitorService)->start('TradeController::importExcel');

        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,csv'
            ]);
            $perf->checkpoint('file_validated');

            // Get selected account from session
            $selectedAccountId = session('selected_account_id');

            Log::info('Starting trade import', [
                'file' => $request->file('file')->getClientOriginalName(),
                'account_id' => $selectedAccountId
            ]);
            $perf->checkpoint('import_started');

            DB::transaction(function () use ($request, $perf, $selectedAccountId) {
                // Pass account ID to import class
                Excel::import(new TradesImport($selectedAccountId), $request->file('file'));
                $perf->checkpoint('excel_import_completed');
            });

            $perf->end('Trade import completed successfully');
            Log::info('Trade import completed successfully', ['account_id' => $selectedAccountId]);
            return redirect()->route('trades.index')->with('success', 'Trades berhasil diimpor ke account yang dipilih!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('File validation failed for import');
            return back()->withInput()->withErrors(['file' => 'File harus berupa Excel atau CSV']);
        } catch (\Exception $e) {
            $perf->end('Trade import failed');
            Log::error('Error importing trades: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return back()->with('error', 'Gagal mengimpor trades: ' . $e->getMessage());
        }
    }

    public function generatePdfReport(Request $request)
    {
        // Get selected account from session
        $selectedAccountId = session('selected_account_id');
        $service = new PdfReportService($selectedAccountId);

        $type = $request->get('type', 'complete');
        $tradeId = $request->get('trade_id');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        try {
            switch ($type) {
                case 'cover':
                    $pdf = $service->generateCoverReport();
                    $filename = 'trading_report_cover_' . now()->format('Y-m-d') . '.pdf';
                    break;

                case 'single':
                    if (!$tradeId) {
                        return back()->with('error', 'Trade ID diperlukan untuk laporan single');
                    }
                    $trade = Trade::findOrFail($tradeId);
                    $pdf = $service->generateTradeReport($trade);
                    $filename = 'trade_' . $trade->id . '_' . now()->format('Y-m-d') . '.pdf';
                    break;

                case 'range':
                    if (!$startDate || !$endDate) {
                        return back()->with('error', 'Start date dan end date diperlukan');
                    }
                    $pdf = $service->generateDateRangeReport($startDate, $endDate);
                    $filename = 'trading_report_' . $startDate . '_to_' . $endDate . '.pdf';
                    break;

                case 'complete':
                default:
                    $pdf = $service->generateCompleteReport();
                    $filename = 'complete_trading_report_' . now()->format('Y-m-d') . '.pdf';
                    break;
            }

            // ⚠️ PERBAIKAN: setPaper() HARUS dipanggil sebelum download()/stream()
            $pdf->setPaper('A4', 'portrait');

            // Return download
            return $pdf->download($filename);
        } catch (\Exception $e) {
            Log::error('Error generating PDF report: ' . $e->getMessage());
            return back()->with('error', 'Gagal generate PDF: ' . $e->getMessage());
        }
    }

    public function previewPdfReport(Request $request)
    {
        $service = new PdfReportService();
        $type = $request->get('type', 'cover');

        Log::info("Generating PDF type: {$type}");

        try {
            if ($type === 'cover') {
                $pdf = $service->generateCoverReport();
                Log::info("Cover PDF generated, class: " . get_class($pdf));
            } else {
                $pdf = $service->generateCompleteReport();
                Log::info("Complete PDF generated, class: " . get_class($pdf));
            }

            // Debug: cek apakah $pdf adalah instance DomPDF
            if (!$pdf instanceof \Barryvdh\DomPDF\PDF) {
                Log::error("PDF is not DomPDF instance: " . get_class($pdf));
                dd(get_class($pdf), $pdf); // Tampilkan debug
            }

            // ⚠️ PERBAIKAN: setPaper() dulu baru stream()
            $pdf->setPaper('A4', 'portrait');

            return $pdf->stream('preview_trading_report.pdf');
        } catch (\Exception $e) {
            Log::error('Error previewing PDF: ' . $e->getMessage());
            return back()->with('error', 'Gagal preview PDF');
        }
    }

    public function generateSingleTradePdf($id)
    {
        try {
            $trade = Trade::with(['symbol', 'account', 'tradingRules'])->findOrFail($id);
            $service = new PdfReportService();

            $pdf = $service->generateTradeReport($trade);
            $pdf->setPaper('A4', 'portrait');

            $filename = 'trade_' . $trade->id . '_' . $trade->symbol->name . '_' . now()->format('Y-m-d') . '.pdf';

            return $pdf->download($filename);
        } catch (\Exception $e) {
            Log::error('Error generating single trade PDF: ' . $e->getMessage());
            return back()->with('error', 'Gagal generate PDF trade');
        }
    }

    // Hitung current equity dari selected account
    private function getCurrentEquity($accountId = null)
    {
        try {
            if (!$accountId) {
                $accountId = session('selected_account_id');
            }

            $account = Account::find($accountId);
            if (!$account) {
                Log::error('Account not found when calculating current equity');
                return 0;
            }

            $initialBalance = $account->initial_balance;

            // Eager load & select specific columns to avoid N+1 queries
            $completedTrades = Trade::where('account_id', $accountId)
                ->whereNotNull('exit')
                ->select('id', 'profit_loss')
                ->get();
            $totalProfitLoss = $completedTrades->sum('profit_loss');

            return $initialBalance + $totalProfitLoss;
        } catch (\Exception $e) {
            Log::error('Error calculating current equity: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Detect image type dan return usable image URL
     * Support: TradingView links, S3 URLs, direct image URLs
     */
    private function processImageUrl($url)
    {
        if (!$url) {
            return null;
        }

        try {
            // Check if it's a TradingView link
            if (preg_match('/tradingview\.com\/x\/([a-zA-Z0-9_\-]+)/', $url)) {
                return $this->extractTradingViewImage($url);
            }

            // Check if it's a direct image URL (S3, HTTP, etc)
            if ($this->isDirectImageUrl($url)) {
                return $url;
            }

            Log::warning("Unsupported image URL type: {$url}");
            return null;
        } catch (\Exception $e) {
            Log::warning("Error processing image URL: {$url}", ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Extract TradingView chart image
     * Convert: https://www.tradingview.com/x/Ha0dhC5t/
     * To: https://www.tradingview.com/x/Ha0dhC5t
     */
    private function extractTradingViewImage($tradingViewLink)
    {
        try {
            if (!$tradingViewLink) return null;

            // Ekstrak chart ID dari TradingView link
            // Format: https://www.tradingview.com/x/UNIQUE_CHART_ID/
            preg_match('/tradingview\.com\/x\/([a-zA-Z0-9_\-]+)/', $tradingViewLink, $matches);

            if (isset($matches[1])) {
                $chartId = $matches[1];
                // Return TradingView link - browser akan otomatis load image
                return "https://www.tradingview.com/x/{$chartId}";
            }

            return null;
        } catch (\Exception $e) {
            Log::warning('Error extracting TradingView image: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Check if URL is direct image (not TradingView embed)
     * Support: S3, HTTP/HTTPS images, etc
     */
    private function isDirectImageUrl($url)
    {
        // Check common image extensions
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];

        // Get URL path without query parameters
        $urlPath = parse_url($url, PHP_URL_PATH);
        $urlPath = strtolower($urlPath);

        // Check if URL ends with image extension
        foreach ($imageExtensions as $ext) {
            if (str_ends_with($urlPath, '.' . $ext)) {
                return true;
            }
        }

        // Check if URL is from common image hosting (S3, CloudFront, etc)
        $imageHosts = ['amazonaws.com', 's3', 'cloudfront', 'imgix', 'fastly', 'cdn'];
        foreach ($imageHosts as $host) {
            if (str_contains($url, $host)) {
                return true;
            }
        }

        // Check if URL has no extension but looks like direct image (query params dengan image format)
        if (str_contains($url, '?') && preg_match('/\.(jpg|jpeg|png|gif|webp|bmp)$/i', $urlPath)) {
            return true;
        }

        return false;
    }

    // DEPRECATED: Gunakan processImageUrl() saja
    private function generateTradingViewImage($tradingViewLink)
    {
        // DEPRECATED: Use processImageUrl() instead
        return $this->processImageUrl($tradingViewLink);
    }
}
