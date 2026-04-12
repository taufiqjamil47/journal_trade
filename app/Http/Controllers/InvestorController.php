<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Investor;
use App\Services\CurrencyConverter;
use Illuminate\Http\Request;

class InvestorController extends Controller
{
    protected $currencyConverter;

    public function __construct(CurrencyConverter $currencyConverter)
    {
        $this->currencyConverter = $currencyConverter;
    }

    public function store(Request $request, Account $account)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'investment' => 'required|numeric|min:0.01',
            'join_date' => 'nullable|date',
            'note' => 'nullable|string',
        ]);

        $investment = $request->investment;

        // Konversi otomatis jika akun ber-currency USD (input Rp) => USD
        if (strtoupper($account->currency) === 'USD') {
            $investmentUsd = $this->currencyConverter->convert($investment, 'IDR', 'USD');
            $currentRate = $this->currencyConverter->getRate('IDR', 'USD');

            // simpan nilai USD sekaligus note mencatat nilai asli
            $note = trim($request->note ?? '');
            if ($note !== '') {
                $note .= ' | ';
            }
            $note .= "IDR {$investment} dikonversi ke USD {$investmentUsd} (rate 1 USD = " . number_format(1 / $currentRate, 0) . " IDR)";

            $investment = $investmentUsd;
            $request->merge(['note' => $note]);
        }

        $account->investors()->create([
            'name' => $request->name,
            'investment' => $investment,
            'join_date' => $request->join_date ?: now()->toDateString(),
            'note' => $request->note,
        ]);

        return redirect()->route('accounts.show', $account)->with('success', 'Investor berhasil ditambahkan');
    }

    public function destroy(Account $account, Investor $investor)
    {
        if ($investor->account_id !== $account->id) {
            abort(403);
        }

        $investor->delete();
        return redirect()->route('accounts.show', $account)->with('success', 'Investor berhasil dihapus');
    }

    public function assignProfitShare(Account $account)
    {
        $totalProfit = $account->trades->sum('profit_loss');
        $totalInvested = $account->totalInvestorInvestment;

        if ($totalInvested <= 0) {
            return redirect()->route('accounts.show', $account)->with('error', 'Tidak ada investasi investor untuk dihitung bagi hasil');
        }

        foreach ($account->investors as $investor) {
            $percentage = $investor->investment / $totalInvested;
            $investor->profit_share = round($percentage * $totalProfit, 2);
            $investor->save();
        }

        return redirect()->route('accounts.show', $account)->with('success', 'Bagi hasil investor berhasil dihitung dan tersimpan');
    }

    public function clearCurrencyCache()
    {
        $this->currencyConverter->clearCache();
        return redirect()->back()->with('success', 'Cache currency rates berhasil dihapus. Rate akan diambil ulang dari API.');
    }

    public function report(Account $account)
    {
        // Hitung data untuk report
        $totalInvestment = $account->investors->sum('investment');
        $totalProfit = $account->trades->sum('profit_loss');
        $roi = ($account->initial_balance > 0) ? ($totalProfit / $account->initial_balance) * 100 : 0;
        $currency = strtoupper($account->currency ?? 'IDR');

        // Data untuk grafik pie chart (distribusi investasi)
        $investorData = $account->investors->map(function ($investor) use ($totalInvestment, $totalProfit) {
            $percentage = $totalInvestment > 0 ? ($investor->investment / $totalInvestment) * 100 : 0;
            $allocatedProfit = ($percentage / 100) * $totalProfit;
            $totalValue = $investor->investment + $allocatedProfit;
            $growthPercentage = $investor->investment > 0 ? ($allocatedProfit / $investor->investment) * 100 : 0;

            // Tentukan performa badge
            $badge = 'neutral';
            if ($growthPercentage > 30) $badge = 'excellent';
            elseif ($growthPercentage > 10) $badge = 'good';
            elseif ($growthPercentage > 0) $badge = 'fair';
            elseif ($growthPercentage > -10) $badge = 'caution';
            else $badge = 'concerning';

            return [
                'name' => $investor->name,
                'investment' => $investor->investment,
                'percentage' => round($percentage, 2),
                'profit_share' => round($allocatedProfit, 2),
                'total_value' => round($totalValue, 2),
                'growth_percentage' => round($growthPercentage, 2),
                'join_date' => $investor->join_date,
                'performance_badge' => $badge,
            ];
        });

        // Data untuk grafik pertumbuhan (line chart)
        $monthlyData = [];
        $trades = $account->trades()->orderBy('date')->get();

        foreach ($trades as $trade) {
            // Konversi string ke Carbon/DateTime
            $date = \Carbon\Carbon::parse($trade->date);

            $month = $date->format('Y-m');
            if (!isset($monthlyData[$month])) {
                $monthlyData[$month] = [
                    'month' => $date->format('M Y'),
                    'profit' => 0,
                    'cumulative_profit' => 0,
                ];
            }
            $monthlyData[$month]['profit'] += $trade->profit_loss;
        }

        // Hitung cumulative profit dan convert ke array indexed untuk JavaScript
        $cumulative = 0;
        $indexedMonthlyData = [];
        foreach ($monthlyData as $key => $data) {
            $cumulative += $data['profit'];
            $monthlyData[$key]['cumulative_profit'] = $cumulative;
            $indexedMonthlyData[] = $monthlyData[$key];
        }

        // Data untuk grafik win rate
        $winTrades = $trades->where('profit_loss', '>', 0)->count();
        $totalTrades = $trades->count();
        $winRate = $totalTrades > 0 ? ($winTrades / $totalTrades) * 100 : 0;

        // Statistik tambahan
        $bestTrade = $trades->max('profit_loss') ?? 0;
        $worstTrade = $trades->min('profit_loss') ?? 0;
        $avgTrade = $totalTrades > 0 ? $trades->avg('profit_loss') : 0;

        // ==== HIGH PRIORITY ADDITIONS ====

        // 1. Executive Summary - Trend Analysis
        $performanceTrend = null;
        $performanceSentiment = 'neutral';

        if (count($indexedMonthlyData) > 0) {
            $lastMonthProfit = end($indexedMonthlyData)['profit'] ?? 0;
            $firstMonthProfit = reset($indexedMonthlyData)['profit'] ?? 0;

            if ($lastMonthProfit > $firstMonthProfit * 1.1) {
                $performanceTrend = 'up';
                $performanceSentiment = 'positive';
            } elseif ($lastMonthProfit < $firstMonthProfit * 0.9) {
                $performanceTrend = 'down';
                $performanceSentiment = $lastMonthProfit < 0 ? 'negative' : 'caution';
            } else {
                $performanceTrend = 'stable';
                $performanceSentiment = 'neutral';
            }
        }

        // Generate performance summary text
        $summaryText = $this->generateExecutiveSummary($account, $totalProfit, $roi, $winRate, $performanceTrend, $performanceSentiment);

        // 2. Profit Distribution Chart Data (per investor)
        $profitDistributionData = $investorData->map(function ($investor) {
            return [
                'name' => $investor['name'],
                'profit_share' => $investor['profit_share'],
                'growth_percentage' => $investor['growth_percentage'],
            ];
        });

        return view('accounts.investor-report', compact(
            'account',
            'investorData',
            'indexedMonthlyData',
            'totalInvestment',
            'totalProfit',
            'roi',
            'currency',
            'winRate',
            'bestTrade',
            'worstTrade',
            'avgTrade',
            'totalTrades',
            'performanceTrend',
            'performanceSentiment',
            'summaryText',
            'profitDistributionData'
        ));
    }

    /**
     * Generate executive summary text untuk investor report
     */
    private function generateExecutiveSummary($account, $totalProfit, $roi, $winRate, $trend, $sentiment)
    {
        $currency = strtoupper($account->currency ?? 'IDR');
        $trendIcon = match ($trend) {
            'up' => '📈',
            'down' => '📉',
            default => '→'
        };

        $investorCount = $account->investors->count();
        $trendText = match ($trend) {
            'up' => 'menunjukkan tren positif',
            'down' => 'menunjukkan tren menurun',
            default => 'menunjukkan performa stabil'
        };

        $sentimentGuidance = match ($sentiment) {
            'positive' => 'Strategi trading berjalan dengan baik, pertahankan momentum.',
            'negative' => 'Diperlukan evaluasi strategi untuk meningkatkan performa.',
            'caution' => 'Perlu perhatian khusus dalam performa periode ini.',
            default => 'Performa dalam kondisi normal, terus dipantau.'
        };

        $profitFormatted = number_format($totalProfit, 2);
        $roiFormatted = number_format($roi, 2);
        $winRateFormatted = number_format($winRate, 1);

        return [
            'trend_icon' => $trendIcon,
            'main_text' => "Akun {$account->name} telah menghasilkan profit {$profitFormatted} {$currency} dengan ROI {$roiFormatted}% dan win rate {$winRateFormatted}%. Dari {$investorCount} investor, perkembangan portofolio {$trendText}.",
            'sentiment' => $sentiment,
            'guidance' => $sentimentGuidance,
        ];
    }
}
