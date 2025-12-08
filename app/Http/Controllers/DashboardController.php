<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Trade;
use App\Models\Symbol;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // SOLUSI: Cek apakah account ada, jika tidak gunakan nilai default
        $account = Account::first();
        $initialBalance = $account ? $account->initial_balance : 10000; // Nilai default 10,000

        $period = $request->get('period', 'all');
        $query = Trade::orderBy('date');

        if ($period === 'weekly') {
            $query->where('date', '>=', now()->subWeek());
        } elseif ($period === 'monthly') {
            $query->where('date', '>=', now()->subMonth());
        }

        // Filter tambahan: session & entry type
        $sessionFilter = $request->get('session', 'all');
        $entryFilter = $request->get('entry_type', 'all');

        if ($sessionFilter !== 'all') {
            $query->where('session', $sessionFilter);
        }
        if ($entryFilter !== 'all') {
            $query->where('entry_type', $entryFilter);
        }

        $trades = $query->get();

        // TAMBAHKAN KODE SUMMARY DI SINI
        // Ambil summary sesuai filter aktif
        $summary = null;
        if ($entryFilter !== 'all') {
            $filteredTrades = $trades->where('entry_type', $entryFilter);

            if ($sessionFilter !== 'all') {
                $filteredTrades = $filteredTrades->where('session', $sessionFilter);
            }

            $total = $filteredTrades->count();
            $wins = $filteredTrades->where('hasil', 'win')->count();

            $summary = [
                'entry_type' => $entryFilter,
                'session' => $sessionFilter !== 'all' ? $sessionFilter : 'All Sessions',
                'trades' => $total,
                'winrate' => $total > 0 ? round(($wins / $total) * 100, 2) : 0,
                'profit_loss' => $filteredTrades->sum('profit_loss')
            ];
        }
        // AKHIR KODE SUMMARY

        // Balance & Equity
        $balance = $initialBalance + $trades->sum('profit_loss');
        $equity = $balance;

        // Winrate
        $totalTrades = $trades->count();
        $wins = $trades->where('hasil', 'win')->count();
        $winrate = $totalTrades > 0 ? round(($wins / $totalTrades) * 100, 2) : 0;

        $winningTrades = $trades->where('hasil', 'win');
        $losingTrades = $trades->where('hasil', 'loss');

        $totalProfit = $winningTrades->sum('profit_loss');
        $totalLoss = abs($losingTrades->sum('profit_loss'));
        $netProfit = $totalProfit - $totalLoss;

        $averageWin = $winningTrades->count() > 0 ? round($winningTrades->avg('profit_loss'), 2) : 0;
        $averageLoss = $losingTrades->count() > 0 ? round(abs($losingTrades->avg('profit_loss')), 2) : 0;

        $largestWin = $winningTrades->max('profit_loss') ?? 0;
        $largestLoss = $losingTrades->min('profit_loss') ?? 0;

        // Risk/Reward Ratio
        $averageRR = ($averageLoss > 0) ? round($averageWin / $averageLoss, 2) : 0;

        // Profit Factor
        $profitFactor = ($totalLoss > 0) ? round($totalProfit / $totalLoss, 2) : ($totalProfit > 0 ? '∞' : 0);

        // Expectancy
        $winrateDecimal = $winrate / 100;
        $expectancy = round(($winrateDecimal * $averageWin) - ((1 - $winrateDecimal) * $averageLoss), 2);

        // 1. Drawdown Calculation
        $drawdownData = $this->calculateDrawdown($trades, $initialBalance);
        $maxDrawdown = $drawdownData['max_drawdown'];
        $maxDrawdownPercentage = $drawdownData['max_drawdown_percentage'];
        $currentDrawdown = $drawdownData['current_drawdown'];
        $currentDrawdownPercentage = $drawdownData['current_drawdown_percentage'];

        // 2. Recovery Factor
        $recoveryFactor = ($maxDrawdown > 0) ? round($netProfit / abs($maxDrawdown), 2) : ($netProfit > 0 ? '∞' : 0);

        // 3. Sharpe Ratio (sederhana - menggunakan standar deviasi return harian)
        $sharpeRatio = $this->calculateSharpeRatio($trades, $initialBalance);

        // 4. Risk/Reward Ratio per Trade
        $riskRewardRatios = $trades->map(function ($trade) {
            // Asumsi: risk adalah stop loss, reward adalah take profit
            // Jika tidak ada data, gunakan average loss/win
            return [
                'trade_id' => $trade->id,
                'rr_ratio' => $trade->rr ?? null
            ];
        })->filter(function ($item) {
            return $item['rr_ratio'] !== null;
        });

        $averageRiskReward = $riskRewardRatios->count() > 0 ?
            round($riskRewardRatios->avg('rr_ratio'), 2) : 0;

        // 5. Win Rate by Position Size (jika ada data size)
        $positionSizes = $trades->groupBy(function ($trade) {
            // Kategorikan berdasarkan lot size atau volume
            $size = $trade->size ?? $trade->volume ?? 0;
            if ($size <= 0.1) return 'Micro (≤0.1)';
            elseif ($size <= 0.5) return 'Small (0.1-0.5)';
            elseif ($size <= 1.0) return 'Standard (0.5-1.0)';
            elseif ($size <= 2.0) return 'Large (1.0-2.0)';
            else return 'Extra Large (>2.0)';
        })->map(function ($group) {
            $total = $group->count();
            $wins = $group->where('hasil', 'win')->count();
            $profit = $group->sum('profit_loss');

            return [
                'trades' => $total,
                'winrate' => $total > 0 ? round(($wins / $total) * 100, 2) : 0,
                'profit' => $profit,
                'avg_profit' => $total > 0 ? round($profit / $total, 2) : 0
            ];
        });

        // 6. Risk Per Trade (dalam % equity)
        $riskPerTradeData = $trades->map(function ($trade) use ($initialBalance) {
            $equityAtTrade = $initialBalance; // Ini oversimplified, seharusnya equity saat trade
            $loss = $trade->hasil === 'loss' ? abs($trade->profit_loss) : 0;
            $riskPercent = $equityAtTrade > 0 ? ($loss / $equityAtTrade) * 100 : 0;

            return [
                'risk_percent' => $riskPercent,
                'trade_id' => $trade->id
            ];
        });

        $averageRiskPerTrade = $riskPerTradeData->count() > 0 ?
            round($riskPerTradeData->avg('risk_percent'), 2) : 0;
        $maxRiskPerTrade = $riskPerTradeData->count() > 0 ?
            round($riskPerTradeData->max('risk_percent'), 2) : 0;

        // 7. Consecutive Wins/Losses (already calculated in streaks)
        // 8. Monthly Returns for Consistency
        $monthlyReturns = $trades->groupBy(function ($trade) {
            $date = $trade->date;

            // Handle string dates
            if (is_string($date)) {
                try {
                    $date = \Carbon\Carbon::parse($date);
                } catch (\Exception $e) {
                    $date = now();
                }
            }

            // Pastikan kita punya Carbon instance
            if ($date instanceof \Carbon\Carbon) {
                return $date->format('Y-m');
            } else {
                // Jika bukan Carbon, ekstrak YYYY-MM dari string
                return substr($date, 0, 7); // Ambil YYYY-MM
            }
        })->map(function ($monthTrades) use ($initialBalance) {
            $profit = $monthTrades->sum('profit_loss');

            // Dapatkan nama bulan dan tahun
            $firstTrade = $monthTrades->first();
            $date = $firstTrade->date;

            if (is_string($date)) {
                try {
                    $date = \Carbon\Carbon::parse($date);
                } catch (\Exception $e) {
                    $date = now();
                }
            }

            $monthName = $date instanceof \Carbon\Carbon ?
                $date->format('M Y') :
                date('M Y', strtotime($date));

            return [
                'profit' => $profit,
                'return_percent' => $initialBalance > 0 ? round(($profit / $initialBalance) * 100, 2) : 0,
                'month' => $monthName,
                'year_month' => $date instanceof \Carbon\Carbon ? $date->format('Y-m') : substr($date, 0, 7)
            ];
        })->sortBy('year_month'); // Sort by year-month string

        $consistencyScore = $this->calculateConsistencyScore($monthlyReturns);

        // Win/Loss Streaks
        $streaks = $this->calculateStreaks($trades);
        $longestWinStreak = $streaks['longest_win_streak'];
        $longestLossStreak = $streaks['longest_loss_streak'];
        $currentStreak = $streaks['current_streak'];
        $currentStreakType = $streaks['current_streak_type'];

        // DAPATKAN SESSION YANG TERSEDIA SECARA DINAMIS
        $availableSessions = Trade::distinct('session')
            ->whereNotNull('session')
            ->where('session', '!=', '')
            ->pluck('session')
            ->toArray();

        // DAPATKAN ENTRY TYPE YANG TERSEDIA SECARA DINAMIS DARI DATABASE
        $availableEntryTypes = Trade::distinct('entry_type')
            ->whereNotNull('entry_type')
            ->where('entry_type', '!=', '')
            ->pluck('entry_type')
            ->toArray();

        // Equity Curve per Session - DINAMIS
        $equityData = [];
        $allDates = $trades->sortBy('date')->pluck('date')->unique()->values();

        foreach ($availableSessions as $session) {
            $runningBalance = $initialBalance;
            $sessionEquity = [];

            // Iterasi melalui semua tanggal untuk membuat kurva yang konsisten
            foreach ($allDates as $date) {
                $dailyTrades = $trades->where('date', $date)->where('session', $session);

                foreach ($dailyTrades as $trade) {
                    $runningBalance += $trade->profit_loss ?? 0;
                }

                $sessionEquity[] = [
                    'date' => $date,
                    'balance' => $runningBalance
                ];
            }

            // Hanya tambahkan session yang memiliki data
            if (!empty($sessionEquity)) {
                $equityData[$session] = $sessionEquity;
            }
        }

        // Pair Analysis
        $pairData = $trades->groupBy('symbol.name')->map(function ($group) {
            return $group->sum('profit_loss');
        });

        // Entry Type Analysis
        $entryTypeData = $trades->groupBy('entry_type')->map(function ($group) {
            $wins = $group->where('hasil', 'win')->count();
            $total = $group->count();
            return [
                'trades' => $total,
                'winrate' => $total > 0 ? round(($wins / $total) * 100, 2) : 0,
                'profit_loss' => $group->sum('profit_loss')
            ];
        });

        return view('dashboard.index', compact(
            'balance',
            'equity',
            'winrate',
            'equityData',
            'pairData',
            'entryFilter',
            'sessionFilter',
            'entryTypeData',
            'period',
            'summary',
            'availableSessions',
            'availableEntryTypes',
            // Tambahkan variabel baru
            'totalProfit',
            'totalLoss',
            'netProfit',
            'averageWin',
            'averageLoss',
            'largestWin',
            'largestLoss',
            'profitFactor',
            'expectancy',
            'averageRR',
            'longestWinStreak',
            'longestLossStreak',
            'currentStreak',
            'currentStreakType',
            'maxDrawdown',
            'maxDrawdownPercentage',
            'currentDrawdown',
            'currentDrawdownPercentage',
            'recoveryFactor',
            'sharpeRatio',
            'averageRiskReward',
            'positionSizes',
            'averageRiskPerTrade',
            'maxRiskPerTrade',
            'monthlyReturns',
            'consistencyScore'
        ));
    }

    private function calculateStreaks($trades)
    {
        $streaks = [
            'longest_win_streak' => 0,
            'longest_loss_streak' => 0,
            'current_streak' => 0,
            'current_streak_type' => 'none'
        ];

        $currentStreak = 0;
        $currentType = '';
        $maxWinStreak = 0;
        $maxLossStreak = 0;

        foreach ($trades->sortBy('date') as $trade) {
            $result = $trade->hasil;

            if ($currentType === $result) {
                $currentStreak++;
            } else {
                // Update max streaks
                if ($currentType === 'win' && $currentStreak > $maxWinStreak) {
                    $maxWinStreak = $currentStreak;
                } elseif ($currentType === 'loss' && $currentStreak > $maxLossStreak) {
                    $maxLossStreak = $currentStreak;
                }

                $currentStreak = 1;
                $currentType = $result;
            }
        }

        // Final update for last streak
        if ($currentType === 'win' && $currentStreak > $maxWinStreak) {
            $maxWinStreak = $currentStreak;
        } elseif ($currentType === 'loss' && $currentStreak > $maxLossStreak) {
            $maxLossStreak = $currentStreak;
        }

        return [
            'longest_win_streak' => $maxWinStreak,
            'longest_loss_streak' => $maxLossStreak,
            'current_streak' => $currentStreak,
            'current_streak_type' => $currentType
        ];
    }

    private function calculateDrawdown($trades, $initialBalance)
    {
        $runningBalance = $initialBalance;
        $peak = $initialBalance;
        $maxDrawdown = 0;
        $maxDrawdownPercentage = 0;

        $balances = [];

        // Sort trades by date
        $sortedTrades = $trades->sortBy(function ($trade) {
            $date = $trade->date;

            // Handle string dates
            if (is_string($date)) {
                return strtotime($date);
            }

            // Jika Carbon instance
            if ($date instanceof \Carbon\Carbon) {
                return $date->timestamp;
            }

            return 0;
        });

        foreach ($sortedTrades as $trade) {
            $runningBalance += $trade->profit_loss ?? 0;
            $balances[] = $runningBalance;

            // Update peak
            if ($runningBalance > $peak) {
                $peak = $runningBalance;
            }

            // Calculate drawdown from peak
            $drawdown = $peak - $runningBalance;
            $drawdownPercentage = $peak > 0 ? ($drawdown / $peak) * 100 : 0;

            // Update max drawdown
            if ($drawdown > $maxDrawdown) {
                $maxDrawdown = $drawdown;
                $maxDrawdownPercentage = $drawdownPercentage;
            }
        }

        // Current drawdown (from latest peak)
        $currentPeak = !empty($balances) ? max($balances) : $initialBalance;
        $currentBalance = !empty($balances) ? end($balances) : $initialBalance;
        $currentDrawdown = $currentPeak - $currentBalance;
        $currentDrawdownPercentage = $currentPeak > 0 ? ($currentDrawdown / $currentPeak) * 100 : 0;

        return [
            'max_drawdown' => $maxDrawdown,
            'max_drawdown_percentage' => $maxDrawdownPercentage,
            'current_drawdown' => $currentDrawdown,
            'current_drawdown_percentage' => $currentDrawdownPercentage,
            'balances' => $balances
        ];
    }

    private function calculateSharpeRatio($trades, $initialBalance)
    {
        if ($trades->count() < 2) return 0;

        // Group trades by day for daily returns
        $dailyReturns = $trades->groupBy(function ($trade) {
            // Pastikan date adalah Carbon instance
            $date = $trade->date;

            // Jika date adalah string, convert ke Carbon
            if (is_string($date)) {
                try {
                    $date = \Carbon\Carbon::parse($date);
                } catch (\Exception $e) {
                    // Fallback: gunakan tanggal sekarang
                    $date = now();
                }
            }

            // Pastikan kita punya Carbon instance
            if ($date instanceof \Carbon\Carbon) {
                return $date->format('Y-m-d');
            } else {
                // Jika bukan Carbon, coba format sebagai string
                return substr($date, 0, 10); // Ambil YYYY-MM-DD
            }
        })->map(function ($dayTrades) use ($initialBalance) {
            return $initialBalance > 0 ?
                round(($dayTrades->sum('profit_loss') / $initialBalance) * 100, 4) : 0;
        })->filter(function ($return) {
            // Filter out invalid returns
            return is_numeric($return);
        })->values();

        if ($dailyReturns->count() < 2) return 0;

        $averageReturn = $dailyReturns->avg();
        $stdDev = $this->calculateStandardDeviation($dailyReturns->toArray());

        // Risk-free rate diasumsikan 0% untuk simplicity
        $riskFreeRate = 0;

        if ($stdDev == 0) return 0;

        return round(($averageReturn - $riskFreeRate) / $stdDev, 2);
    }

    private function calculateStandardDeviation($array)
    {
        $n = count($array);
        if ($n <= 1) return 0;

        $mean = array_sum($array) / $n;
        $variance = 0.0;

        foreach ($array as $value) {
            $variance += pow($value - $mean, 2);
        }

        return sqrt($variance / ($n - 1));
    }

    private function calculateConsistencyScore($monthlyReturns)
    {
        if ($monthlyReturns->count() < 2) return 100;

        $positiveMonths = $monthlyReturns->filter(function ($month) {
            return $month['profit'] > 0;
        })->count();

        $totalMonths = $monthlyReturns->count();

        return round(($positiveMonths / $totalMonths) * 100, 0);
    }
}
