<?php

namespace App\Http\Controllers;

use App\Models\Trade;
use App\Models\Symbol;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Exports\TradesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TradesImport;

class TradeController extends Controller
{
    // Di method index() TradeController, tambahkan:
    public function index(Request $request)
    {
        $sortBy = $request->get('sort_by', 'date');
        $order  = $request->get('order', 'asc');

        $query = Trade::with('symbol');
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

    // Update method create() untuk kirim equity ke view
    public function create()
    {
        $symbols = Symbol::where('active', true)->get();
        $currentEquity = $this->getCurrentEquity();

        return view('trades.create', compact('symbols', 'currentEquity'));
    }

    public function edit($id)
    {
        $account = Account::first();
        $initialBalance = $account->initial_balance;

        // HITUNG BALANCE TANPA TRADE YANG SEDANG DIEDIT
        $previousTrades = Trade::where('id', '<', $id)
            ->where('exit', '!=', null) // Hanya trade yang sudah selesai
            ->get();

        $balance = $initialBalance + $previousTrades->sum('profit_loss');

        $trade = Trade::findOrFail($id);
        return view('trades.edit', compact('trade', 'balance'));
    }

    public function update(Request $request, $id)
    {
        $trade = \App\Models\Trade::with('symbol', 'account')->findOrFail($id);

        $data = $request->validate([
            'exit' => 'required|numeric',
            'lot_size' => 'nullable|numeric|min:0.01',
            'risk_percent' => 'nullable|numeric|min:0|max:100',
            'risk_usd' => 'nullable|numeric|min:0',
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

        // Hitung Risk % & Lot Size otomatis
        $pipWorth = 10; // default: $10 per pip per 1 lot
        $slPips = $trade->sl_pips ?? 0;
        $accountBalance = $trade->account->initial_balance; // nanti bisa equity

        // VARIABLE UNTUK MENYIMPAN risk_usd
        $calculatedRiskUSD = null;

        // PRIORITASKAN RISK PERCENT JIKA DIISI
        if (!empty($data['risk_percent']) && $slPips > 0) {
            $calculatedRiskUSD = $accountBalance * ($data['risk_percent'] / 100);
            $lotSize = $calculatedRiskUSD / ($slPips * $pipWorth);

            $trade->risk_percent = $data['risk_percent'];
            $trade->lot_size = round($lotSize, 2);

            // SIMPAN risk_usd YANG DIHITUNG
            $trade->risk_usd = round($calculatedRiskUSD, 2);
        } elseif (!empty($data['lot_size'])) {
            $calculatedRiskUSD = $slPips * $pipWorth * $data['lot_size'];
            $riskPercent = $accountBalance > 0 ? ($calculatedRiskUSD / $accountBalance) * 100 : 0;

            $trade->lot_size = $data['lot_size'];
            $trade->risk_percent = round($riskPercent, 2);

            // SIMPAN risk_usd YANG DIHITUNG
            $trade->risk_usd = round($calculatedRiskUSD, 2);
        } else {
            $trade->lot_size = $trade->lot_size ?? 0.01;
            $trade->risk_percent = $trade->risk_percent ?? 0;
            // JIKA risk_usd DIINPUT MANUAL, GUNAKAN ITU
            $trade->risk_usd = $data['risk_usd'] ?? $trade->risk_usd;
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
        // AKHIR DARI KODE YANG DITAMBAHKAN

        $trade->fill($data);
        $trade->setSessionFromTimestamp();
        $trade->save();

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

        // Trade::create($data);
        $trade = new Trade($data);
        $trade->account_id = 1;

        // Set session otomatis
        $trade->setSessionFromTimestamp();

        $trade->save();

        return redirect()->route('trades.index')->with('success', 'Trade berhasil ditambahkan');
    }

    public function detail($id)
    {
        $trade = Trade::with('symbol', 'account')->findOrFail($id);

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
            'streak_win' => $trade->streak_win,
            'streak_loss' => $trade->streak_loss,
            'before_link' => $trade->before_link, // TAMBAHKAN INI
            'after_link' => $trade->after_link,   // TAMBAHKAN INI
        ]);
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
        $trade = \App\Models\Trade::findOrFail($id);
        return view('trades.evaluate', compact('trade'));
    }

    public function saveEvaluation(Request $request, $id)
    {
        $trade = \App\Models\Trade::findOrFail($id);

        $data = $request->validate([
            'entry_type'      => 'nullable|string',
            'follow_rules'    => 'nullable|boolean',
            'rules'           => 'nullable|array',
            'rules.*'         => 'string',
            'market_condition' => 'nullable|string',
            'entry_reason'    => 'nullable|string',
            'why_sl_tp'       => 'nullable|string',
            'entry_emotion'   => 'nullable|string',
            'close_emotion'   => 'nullable|string',
            'note'            => 'nullable|string',
            'before_link'     => 'nullable|url',
            'after_link'      => 'nullable|url',
        ]);

        // Convert array checkbox → string "Rule1,Rule2,Rule3"
        if (!empty($data['rules'])) {
            $data['rules'] = implode(',', $data['rules']);
        }

        $trade->fill($data);
        $trade->save();

        return redirect()->route('trades.index')->with('success', 'Evaluasi trade berhasil disimpan');
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

    // Di TradeController.php, tambahkan method helper
    private function getCurrentEquity()
    {
        $account = Account::first();
        $initialBalance = $account->initial_balance;

        // Hitung total profit/loss dari semua trade yang sudah selesai
        $completedTrades = Trade::where('exit', '!=', null)->get();
        $totalProfitLoss = $completedTrades->sum('profit_loss');

        return $initialBalance + $totalProfitLoss;
    }
}
