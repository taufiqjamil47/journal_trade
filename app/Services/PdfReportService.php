<?php

namespace App\Services;

use App\Models\Trade;
use App\Models\Account;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PdfReportService
{
    /**
     * Generate cover report (Summary)
     */
    public function generateCoverReport()
    {
        // Hitung statistik seperti di VBA
        $totalTrades = Trade::count();
        $winTrades = Trade::where('hasil', 'win')->count();
        $lossTrades = Trade::where('hasil', 'loss')->count();

        $account = Account::first();
        $startBalance = $account->initial_balance ?? 0;

        // Hitung current balance (initial + total profit_loss)
        $totalProfitLoss = Trade::whereNotNull('exit')->sum('profit_loss');
        $currentBalance = $startBalance + $totalProfitLoss;
        $profit = $totalProfitLoss;

        // Hitung equity growth
        $equityGrowth = $startBalance > 0 ? ($profit / $startBalance) * 100 : 0;

        // Hitung win rate
        $winRate = $totalTrades > 0 ? ($winTrades / $totalTrades) * 100 : 0;

        // Hitung average RR
        $avgRR = Trade::whereNotNull('rr')->average('rr') ?? 0;

        // Ambil bulan pertama dan terakhir
        $firstTrade = Trade::orderBy('date')->first();
        $lastTrade = Trade::orderBy('date', 'desc')->first();

        $firstMonth = $firstTrade ? Carbon::parse($firstTrade->date)->locale('id')->monthName : '-';
        $lastMonth = $lastTrade ? Carbon::parse($lastTrade->date)->locale('id')->monthName : '-';
        $tradeYear = $firstTrade ? Carbon::parse($firstTrade->date)->format('Y') : date('Y');

        // Ambil unique symbols
        $symbols = Trade::with('symbol')
            ->select('symbol_id')
            ->distinct()
            ->get()
            ->pluck('symbol.name')
            ->unique()
            ->implode(', ');

        $data = [
            'totalTrades' => $totalTrades,
            'winTrades' => $winTrades,
            'lossTrades' => $lossTrades,
            'startBalance' => number_format($startBalance, 2),
            'currentBalance' => number_format($currentBalance, 2),
            'profit' => number_format($profit, 2),
            'equityGrowth' => number_format($equityGrowth, 2) . '%',
            'avgRR' => number_format($avgRR, 2),
            'winRate' => number_format($winRate, 2) . '%',
            'tradeYear' => $tradeYear,
            'firstMonth' => $firstMonth,
            'lastMonth' => $lastMonth,
            'symbolReport' => $symbols,
            'byFX1' => 'Trader', // Bisa diganti dengan nama user
            'byFX2' => 'Trading Journal System',
            'generatedDate' => now()->format('d F Y H:i:s'),
        ];

        return Pdf::loadView('pdf.cover', $data);
    }

    /**
     * Generate single trade report
     */
    public function generateTradeReport(Trade $trade)
    {
        // Format data sesuai kebutuhan template
        $data = [
            'trade' => $trade,
            'formatted' => [
                'tradeNo' => str_pad($trade->id, 3, '0', STR_PAD_LEFT),
                'timestamp' => Carbon::parse($trade->timestamp)->format('h:i:s A'),
                'date' => Carbon::parse($trade->date)->locale('id')->translatedFormat('l, d F Y'),
                'type' => $trade->type == 'buy' ? 'Buy / Long' : 'Sell / Short',
                'entry' => $trade->entry,
                'stopLoss' => $trade->stop_loss,
                'slPips' => number_format($trade->sl_pips, 2),
                'takeProfit' => $trade->take_profit,
                'tpPips' => number_format($trade->tp_pips, 2),
                'exit' => $trade->exit ?? '-',
                'exitPips' => $trade->exit_pips ? number_format($trade->exit_pips, 2) : '-',
                'riskUSD' => $trade->risk_usd ? number_format($trade->risk_usd, 2) : '-',
                'rr' => $trade->rr ? number_format($trade->rr, 2) : '-',
                'profitLoss' => $trade->profit_loss ?? '-',
                'profitLossClass' => $this->getProfitLossClass($trade->profit_loss),
                'lotSize' => $trade->lot_size ? number_format($trade->lot_size, 2) : '-',
                'balance' => $this->calculateBalanceUpToTrade($trade),
                'riskPercent' => $trade->risk_percent ? ($trade->risk_percent * 100) . '%' : '-',
                'entryType' => $trade->entry_type ?? '-',
                'followRules' => $trade->follow_rules ?? '-',
                'marketCondition' => $trade->market_condition ?? '-',
                'entryReason' => $trade->entry_reason ?? '-',
                'whySlTp' => $trade->why_sl_tp ?? '-',
                'entryEmotion' => $trade->entry_emotion ?? '-',
                'closeEmotion' => $trade->close_emotion ?? '-',
                'note' => $trade->note ?? '-',
                'session' => $trade->session ?? '-',
                'before' => $trade->before_link ?? '-',
                'after' => $trade->after_link ?? '-',
                'hasil' => $trade->hasil ?? '-',
            ],
            'rules' => $trade->rules_array ?? [],
        ];

        return Pdf::loadView('pdf.trade-detail', $data);
    }

    /**
     * Generate all trades as single PDF
     */
    public function generateAllTradesReport($tradeIds = null)
    {
        $query = Trade::with(['symbol', 'account', 'tradingRules']);

        if ($tradeIds) {
            $query->whereIn('id', $tradeIds);
        }

        $trades = $query->orderBy('id')->get();

        $data = [
            'trades' => $trades,
            'coverData' => $this->getCoverData(), // Reuse cover data
        ];

        $pdf = Pdf::loadView('pdf.all-trades', $data);
        return $pdf;
    }

    /**
     * Generate report with cover + all trades in one PDF
     */
    public function generateCompleteReport()
    {
        // Generate cover
        $coverPdf = $this->generateCoverReport();

        // Generate all trades
        $tradesPdf = $this->generateAllTradesReport();

        // NOTE: DomPDF tidak bisa merge PDF secara native
        // Alternatif: Buat satu view besar yang include cover dan semua trades
        $trades = Trade::with(['symbol', 'account', 'tradingRules'])->orderBy('id')->get();

        $data = [
            'cover' => $this->getCoverData(),
            'trades' => $trades,
        ];

        return Pdf::loadView('pdf.complete-report', $data);
    }

    /**
     * Generate PDF for specific date range
     */
    public function generateDateRangeReport($startDate, $endDate)
    {
        $trades = Trade::with(['symbol', 'account', 'tradingRules'])
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date')
            ->get();

        // Hitung statistik untuk range tersebut
        $coverData = $this->getCoverDataForRange($startDate, $endDate);

        $data = [
            'cover' => $coverData,
            'trades' => $trades,
            'dateRange' => [
                'start' => Carbon::parse($startDate)->format('d M Y'),
                'end' => Carbon::parse($endDate)->format('d M Y'),
            ],
        ];

        $pdf = Pdf::loadView('pdf.date-range-report', $data);
        $pdf->setPaper('A4', 'portrait');

        return $pdf;
    }

    /**
     * Helper methods
     */
    private function getProfitLossClass($profitLoss)
    {
        if ($profitLoss === null) return 'neutral';
        if ($profitLoss > 0) return 'profit';
        if ($profitLoss < 0) return 'loss';
        return 'neutral';
    }

    private function calculateBalanceUpToTrade(Trade $trade)
    {
        $account = $trade->account ?? Account::first();
        if (!$account) return '0.00';

        $initialBalance = $account->initial_balance;

        // Hitung profit/loss dari trades sebelum trade ini
        $previousProfitLoss = Trade::where('account_id', $trade->account_id)
            ->where('id', '<', $trade->id)
            ->whereNotNull('exit')
            ->sum('profit_loss');

        $balance = $initialBalance + $previousProfitLoss;

        return number_format($balance, 2);
    }

    private function getCoverData()
    {
        // Reuse logic from generateCoverReport but return array
        $totalTrades = Trade::count();
        $winTrades = Trade::where('hasil', 'win')->count();
        $lossTrades = Trade::where('hasil', 'loss')->count();

        $account = Account::first();
        $startBalance = $account->initial_balance ?? 0;

        $totalProfitLoss = Trade::whereNotNull('exit')->sum('profit_loss');
        $currentBalance = $startBalance + $totalProfitLoss;
        $profit = $totalProfitLoss;

        $equityGrowth = $startBalance > 0 ? ($profit / $startBalance) * 100 : 0;
        $winRate = $totalTrades > 0 ? ($winTrades / $totalTrades) * 100 : 0;
        $avgRR = Trade::whereNotNull('rr')->average('rr') ?? 0;

        $firstTrade = Trade::orderBy('date')->first();
        $lastTrade = Trade::orderBy('date', 'desc')->first();

        return [
            'totalTrades' => $totalTrades,
            'winTrades' => $winTrades,
            'lossTrades' => $lossTrades,
            'startBalance' => number_format($startBalance, 2),
            'currentBalance' => number_format($currentBalance, 2),
            'profit' => number_format($profit, 2),
            'equityGrowth' => number_format($equityGrowth, 2),
            'avgRR' => number_format($avgRR, 2),
            'winRate' => number_format($winRate, 2),
            'tradeYear' => $firstTrade ? Carbon::parse($firstTrade->date)->format('Y') : date('Y'),
            'firstMonth' => $firstTrade ? Carbon::parse($firstTrade->date)->locale('id')->monthName : '-',
            'lastMonth' => $lastTrade ? Carbon::parse($lastTrade->date)->locale('id')->monthName : '-',
            'symbolReport' => $this->getUniqueSymbols(),
            'generatedDate' => now()->format('d F Y H:i:s'),
        ];
    }

    private function getCoverDataForRange($startDate, $endDate)
    {
        $trades = Trade::whereBetween('date', [$startDate, $endDate])->get();

        $totalTrades = $trades->count();
        $winTrades = $trades->where('hasil', 'win')->count();
        $lossTrades = $trades->where('hasil', 'loss')->count();

        $totalProfitLoss = $trades->whereNotNull('exit')->sum('profit_loss');
        $profit = $totalProfitLoss;

        // Untuk range, kita perlu initial balance sebelum range
        $account = Account::first();
        $balanceBeforeRange = $account->initial_balance ?? 0;

        // Tambahkan profit/loss dari trades sebelum range
        $profitBeforeRange = Trade::where('date', '<', $startDate)
            ->whereNotNull('exit')
            ->sum('profit_loss');

        $startBalance = $balanceBeforeRange + $profitBeforeRange;
        $currentBalance = $startBalance + $profit;

        $equityGrowth = $startBalance > 0 ? ($profit / $startBalance) * 100 : 0;
        $winRate = $totalTrades > 0 ? ($winTrades / $totalTrades) * 100 : 0;
        $avgRR = $trades->whereNotNull('rr')->avg('rr') ?? 0;

        return [
            'totalTrades' => $totalTrades,
            'winTrades' => $winTrades,
            'lossTrades' => $lossTrades,
            'startBalance' => number_format($startBalance, 2),
            'currentBalance' => number_format($currentBalance, 2),
            'profit' => number_format($profit, 2),
            'equityGrowth' => number_format($equityGrowth, 2),
            'avgRR' => number_format($avgRR, 2),
            'winRate' => number_format($winRate, 2),
            'dateRange' => [
                'start' => Carbon::parse($startDate)->format('d M Y'),
                'end' => Carbon::parse($endDate)->format('d M Y'),
            ],
            'generatedDate' => now()->format('d F Y H:i:s'),
        ];
    }

    private function getUniqueSymbols()
    {
        return Trade::with('symbol')
            ->select('symbol_id')
            ->distinct()
            ->get()
            ->pluck('symbol.name')
            ->unique()
            ->implode(', ');
    }
}
