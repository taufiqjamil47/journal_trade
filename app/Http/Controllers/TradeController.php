<?php

namespace App\Http\Controllers;

use App\Models\Trade;
use App\Models\Symbol;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Exports\TradesExport;
use App\Imports\TradesImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\TradingRule; // Tambahkan ini

class TradeController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = $request->get('sort_by', 'date');
        $order  = $request->get('order', 'desc');

        // Tambahkan eager loading untuk tradingRules
        $query = Trade::with('symbol', 'tradingRules'); // Update ini
        $trades = $query->orderBy($sortBy, $order)->paginate(10);

        // HITUNG WINRATE DARI SEMUA TRADE (BUKAN HANYA YANG DIPAGINATE)
        $allTrades = Trade::all();
        $totalTrades = $allTrades->count();
        $wins = $allTrades->where('hasil', 'win')->count();
        $winrate = $totalTrades > 0 ? round(($wins / $totalTrades) * 100, 2) : 0;

        return view('trades.index', compact(
            'trades',
            'sortBy',
            'order',
            'winrate'
        ));
    }

    public function create()
    {
        $symbols = Symbol::where('active', true)->get();
        $currentEquity = $this->getCurrentEquity();
        $tradingRules = TradingRule::where('is_active', true) // Tambahkan ini
            ->orderBy('order')
            ->get();

        return view('trades.create', compact('symbols', 'currentEquity', 'tradingRules'));
    }

    public function edit($id)
    {
        $account = Account::first();
        $initialBalance = $account->initial_balance;

        // PERBAIKAN: Hitung balance yang benar termasuk semua trade selesai kecuali yang sedang diedit
        $completedTrades = Trade::where('exit', '!=', null)
            ->where('id', '!=', $id) // JANGAN sertakan trade yang sedang diedit
            ->get();

        $balance = $initialBalance + $completedTrades->sum('profit_loss');

        // Tambahkan eager loading untuk tradingRules
        $trade = Trade::with('tradingRules')->findOrFail($id);
        $tradingRules = TradingRule::where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('trades.edit', compact('trade', 'balance', 'tradingRules'));
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
            'rules.*' => 'exists:trading_rules,id'
        ]);

        $trade->exit = $data['exit'];

        // Hitung Exit Pips
        $pipValue = $trade->symbol->pip_value;
        if ($trade->type === 'buy') {
            $exitPips = ($trade->exit - $trade->entry) / $pipValue;
        } else {
            $exitPips = ($trade->entry - $trade->exit) / $pipValue;
        }
        $trade->exit_pips = round($exitPips, 1);

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
        $pipWorth = 10; // default: $10 per pip per 1 lot
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

        // Hitung Profit/Loss USD
        $profitLoss = $trade->exit_pips * $trade->lot_size * $pipWorth;
        $trade->profit_loss = round($profitLoss, 2);

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
        // SYNC RULES JIKA ADA
        if ($request->has('rules')) {
            $trade->tradingRules()->sync($request->rules);

            $ruleNames = \App\Models\TradingRule::whereIn('id', $request->rules)
                ->pluck('name')
                ->toArray();

            $trade->withoutEvents(function () use ($trade, $ruleNames) {
                $trade->update(['rules' => implode(',', $ruleNames)]);
            });
        }

        $trade->save();

        // HAPUS KODE LAMA: $trade->rules = implode(',', $request->rules ?? []);

        return redirect()->route('trades.index')->with('success', 'Trade berhasil diperbarui dengan Exit, Risk%, dan Lot Size');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'symbol_id'   => 'required|exists:symbols,id',
            'timestamp'   => 'required|date',
            'date'        => 'required|date',
            'type'        => 'required|in:buy,sell',
            'entry'       => 'required|numeric',
            'stop_loss'   => 'required|numeric',
            'take_profit' => 'required|numeric',
            'rules'       => 'nullable|array', // Tambahkan validasi untuk rules
            'rules.*'     => 'exists:trading_rules,id' // Validasi ID rules
        ]);

        // ambil konfigurasi symbol
        $symbol = Symbol::findOrFail($data['symbol_id']);

        // hitung otomatis pips
        $slPips = $this->calculatePips($data['entry'], $data['stop_loss'], $data['type'], $symbol);
        $tpPips = $this->calculatePips($data['entry'], $data['take_profit'], $data['type'], $symbol);

        $data['sl_pips'] = $slPips;
        $data['tp_pips'] = $tpPips;

        // HITUNG RR RATIO - TAMBAHKAN INI
        if ($slPips > 0) {
            $data['rr'] = round($tpPips / $slPips, 2);
        } else {
            $data['rr'] = 0;
        }

        // sementara account_id fix dulu (nanti bisa pilih kalau multi akun)
        $data['account_id'] = 1;

        $trade = new Trade($data);
        $trade->account_id = 1;

        // Set session otomatis
        $trade->setSessionFromTimestamp();

        $trade->save();

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
        }

        return redirect()->route('trades.index')->with('success', 'Trade berhasil ditambahkan');
    }

    public function show($id)
    {
        $trade = Trade::with('symbol', 'account', 'tradingRules')->findOrFail($id); // Update ini

        // Generate image URLs dari TradingView links
        $beforeChartImage = $this->generateTradingViewImage($trade->before_link);
        $afterChartImage = $this->generateTradingViewImage($trade->after_link);

        return view('trades.show', compact('trade', 'beforeChartImage', 'afterChartImage'));
    }

    public function detail($id)
    {
        $trade = Trade::with('symbol', 'account', 'tradingRules')->findOrFail($id); // Update ini

        // Get rule names
        $ruleNames = $trade->tradingRules->pluck('name')->toArray();

        return response()->json([
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
            'rules' => $ruleNames, // Tambahkan rules
            'before_link' => $trade->before_link,
            'after_link' => $trade->after_link,
        ]);
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
            'after_link'      => 'nullable|url',
        ]);

        // Update field lainnya
        $trade->fill($request->except('rules'));

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

        return redirect()->route('trades.index')
            ->with('success', 'Evaluasi trade berhasil disimpan');
    }

    public function exportExcel()
    {
        return Excel::download(new TradesExport, 'trades.xlsx');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        Excel::import(new TradesImport, $request->file('file'));

        return redirect()->route('trades.index')->with('success', 'Trades imported successfully!');
    }

    private function getCurrentEquity()
    {
        $account = Account::first();
        $initialBalance = $account->initial_balance;

        // Hitung total profit/loss dari semua trade yang sudah selesai
        $completedTrades = Trade::where('exit', '!=', null)->get();
        $totalProfitLoss = $completedTrades->sum('profit_loss');

        return $initialBalance + $totalProfitLoss;
    }

    private function generateTradingViewImage($tradingViewLink)
    {
        if (!$tradingViewLink) return null;

        // Ekstrak chart ID dari TradingView link
        // Format: https://www.tradingview.com/x/UNIQUE_CHART_ID/
        preg_match('/tradingview\.com\/x\/([a-zA-Z0-9_\-]+)/', $tradingViewLink, $matches);

        if (isset($matches[1])) {
            $chartId = $matches[1];

            // TradingView image snapshot URL
            // Note: Ini adalah endpoint publik TradingView untuk snapshot chart
            return "https://www.tradingview.com/x/{$chartId}";
        }

        return null;
    }
}
