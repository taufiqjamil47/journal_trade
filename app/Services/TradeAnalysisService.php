<?php

namespace App\Services;

use App\Models\Trade;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TradeAnalysisService
{
    /**
     * Get filtered trades based on request parameters
     * Uses eager loading to prevent N+1 queries
     */
    public function getFilteredTrades(Request $request, $withRelations = true)
    {
        $query = Trade::query();

        // Eager load relationships to prevent N+1 queries
        if ($withRelations) {
            $query->with(['symbol', 'account', 'tradingRules']);
        }

        $query->orderBy('date');

        // Period filter
        $period = $request->get('period', 'all');
        if ($period === 'weekly') {
            $query->where('date', '>=', now()->subWeek());
        } elseif ($period === 'monthly') {
            $query->where('date', '>=', now()->subMonth());
        }

        // Session filter
        $sessionFilter = $request->get('session', 'all');
        if ($sessionFilter !== 'all') {
            $query->where('session', $sessionFilter);
        }

        // Entry type filter
        $entryFilter = $request->get('entry_type', 'all');
        if ($entryFilter !== 'all') {
            $query->where('entry_type', $entryFilter);
        }

        return $query;
    }

    /**
     * Calculate basic metrics for dashboard
     */
    public function calculateBasicMetrics($trades, $initialBalance)
    {
        $totalTrades = $trades->count();
        $wins = $trades->where('hasil', 'win')->count();
        $winrate = $totalTrades > 0 ? round(($wins / $totalTrades) * 100, 2) : 0;

        $winningTrades = $trades->where('hasil', 'win');
        $losingTrades = $trades->where('hasil', 'loss');

        $totalProfit = $winningTrades->sum('profit_loss');
        $totalLoss = abs($losingTrades->sum('profit_loss'));
        $netProfit = $totalProfit - $totalLoss;

        $balance = $initialBalance + $netProfit;

        $averageWin = $winningTrades->count() > 0 ?
            round($winningTrades->avg('profit_loss'), 2) : 0;
        $averageLoss = $losingTrades->count() > 0 ?
            round(abs($losingTrades->avg('profit_loss')), 2) : 0;

        $largestWin = $winningTrades->max('profit_loss') ?? 0;
        $largestLoss = $losingTrades->min('profit_loss') ?? 0;

        $averageRR = ($averageLoss > 0) ? round($averageWin / $averageLoss, 2) : 0;

        $profitFactor = ($totalLoss > 0) ?
            round($totalProfit / $totalLoss, 2) : ($totalProfit > 0 ? '∞' : 0);

        $winrateDecimal = $winrate / 100;
        $expectancy = round(
            ($winrateDecimal * $averageWin) - ((1 - $winrateDecimal) * $averageLoss),
            2
        );

        // Drawdown
        $drawdownData = $this->calculateDrawdown($trades, $initialBalance);

        // Streaks
        $streaks = $this->calculateStreaks($trades);

        return [
            'balance' => $balance,
            'equity' => $balance,
            'winrate' => $winrate,
            'totalProfit' => $totalProfit,
            'totalLoss' => $totalLoss,
            'netProfit' => $netProfit,
            'averageWin' => $averageWin,
            'averageLoss' => $averageLoss,
            'largestWin' => $largestWin,
            'largestLoss' => $largestLoss,
            'averageRR' => $averageRR,
            'profitFactor' => $profitFactor,
            'expectancy' => $expectancy,
            'maxDrawdown' => $drawdownData['max_drawdown'],
            'maxDrawdownPercentage' => $drawdownData['max_drawdown_percentage'],
            'currentDrawdown' => $drawdownData['current_drawdown'],
            'currentDrawdownPercentage' => $drawdownData['current_drawdown_percentage'],
            'longestWinStreak' => $streaks['longest_win_streak'],
            'longestLossStreak' => $streaks['longest_loss_streak'],
            'currentStreak' => $streaks['current_streak'],
            'currentStreakType' => $streaks['current_streak_type'],
        ];
    }

    /**
     * Calculate summary for active filters
     */
    public function calculateSummary($trades, $entryFilter, $sessionFilter)
    {
        if ($entryFilter === 'all') {
            return null;
        }

        $filteredTrades = $trades->where('entry_type', $entryFilter);

        if ($sessionFilter !== 'all') {
            $filteredTrades = $filteredTrades->where('session', $sessionFilter);
        }

        $total = $filteredTrades->count();
        $wins = $filteredTrades->where('hasil', 'win')->count();

        return [
            'entry_type' => $entryFilter,
            'session' => $sessionFilter !== 'all' ? $sessionFilter : 'All Sessions',
            'trades' => $total,
            'winrate' => $total > 0 ? round(($wins / $total) * 100, 2) : 0,
            'profit_loss' => $filteredTrades->sum('profit_loss')
        ];
    }

    /**
     * Calculate equity curve data per session
     */
    public function calculateEquityData($trades, $initialBalance, $availableSessions)
    {
        $equityData = [];
        $allDates = $trades->sortBy('date')->pluck('date')->unique()->values();

        foreach ($availableSessions as $session) {
            $runningBalance = $initialBalance;
            $sessionEquity = [];

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

            if (!empty($sessionEquity)) {
                $equityData[$session] = $sessionEquity;
            }
        }

        return $equityData;
    }

    /**
     * Calculate pair analysis
     */
    public function calculatePairAnalysis($trades)
    {
        // If $trades is a query builder, delegate to DB aggregation
        if ($trades instanceof \Illuminate\Database\Eloquent\Builder) {
            return $this->calculatePairAnalysisDb($trades);
        }

        return $trades->groupBy('symbol.name')->map(function ($group) {
            return $group->sum('profit_loss');
        });
    }

    /**
     * Calculate entry type analysis
     */
    public function calculateEntryTypeAnalysis($trades)
    {
        if ($trades instanceof \Illuminate\Database\Eloquent\Builder) {
            return $this->calculateEntryTypeAnalysisDb($trades);
        }

        return $trades->groupBy('entry_type')->map(function ($group) {
            $wins = $group->where('hasil', 'win')->count();
            $total = $group->count();
            return [
                'trades' => $total,
                'winrate' => $total > 0 ? round(($wins / $total) * 100, 2) : 0,
                'profit_loss' => $group->sum('profit_loss')
            ];
        });
    }

    /**
     * DB-backed pair analysis (faster for large datasets)
     */
    public function calculatePairAnalysisDb($query)
    {
        $rows = $query->select('symbols.name as symbol_name', DB::raw('SUM(trades.profit_loss) as total'))
            ->join('symbols', 'symbols.id', '=', 'trades.symbol_id')
            ->groupBy('symbols.name')
            ->get();

        return $rows->pluck('total', 'symbol_name');
    }

    /**
     * DB-backed entry type analysis
     */
    public function calculateEntryTypeAnalysisDb($query)
    {
        $rows = $query->select('entry_type', DB::raw("SUM(CASE WHEN hasil = 'win' THEN 1 ELSE 0 END) as wins"), DB::raw('COUNT(*) as total'), DB::raw('SUM(profit_loss) as total_profit'))
            ->groupBy('entry_type')
            ->get();

        $result = [];
        foreach ($rows as $row) {
            $total = (int) $row->total;
            $wins = (int) $row->wins;
            $result[$row->entry_type] = [
                'trades' => $total,
                'winrate' => $total > 0 ? round(($wins / $total) * 100, 2) : 0,
                'profit_loss' => (float) $row->total_profit
            ];
        }

        return collect($result);
    }

    /**
     * ============================================
     * ADVANCED ANALYSIS METHODS (for Analysis page)
     * ============================================
     */

    /**
     * Calculate time analysis data
     */
    public function calculateTimeAnalysis($trades)
    {
        return [
            'hourlyPerformance' => $this->calculateHourlyPerformance($trades),
            'dayOfWeekPerformance' => $this->calculateDayOfWeekPerformance($trades),
            'monthlyPerformance' => $this->calculateMonthlyPerformance($trades),
            'heatmapData' => $this->calculateHeatmapData($trades),
            'bestHour' => $this->findBestHour($trades),
            'worstHour' => $this->findWorstHour($trades),
            'busiestHour' => $this->findBusiestHour($trades),
            'tradingTimeStats' => $this->calculateTradingTimeStats($trades),
        ];
    }

    /**
     * Calculate advanced risk metrics
     */
    public function calculateAdvancedRiskMetrics($trades, $initialBalance)
    {
        // Recovery Factor
        $drawdownData = $this->calculateDrawdown($trades, $initialBalance);
        $netProfit = $trades->sum('profit_loss');
        $recoveryFactor = ($drawdownData['max_drawdown'] > 0) ?
            round($netProfit / abs($drawdownData['max_drawdown']), 2) : ($netProfit > 0 ? '∞' : 0);

        // Sharpe Ratio
        $sharpeRatio = $this->calculateSharpeRatio($trades, $initialBalance);

        // Risk/Reward Analysis
        $riskRewardAnalysis = $this->calculateRiskRewardAnalysis($trades);

        // Position Size Analysis
        $positionSizes = $this->calculatePositionSizeAnalysis($trades);

        // Risk Per Trade
        $riskPerTrade = $this->calculateRiskPerTrade($trades, $initialBalance);

        // Monthly Returns & Consistency
        $monthlyReturns = $this->calculateMonthlyReturns($trades, $initialBalance);
        $consistencyScore = $this->calculateConsistencyScore($monthlyReturns);

        return [
            'recoveryFactor' => $recoveryFactor,
            'sharpeRatio' => $sharpeRatio,
            'averageRiskReward' => $riskRewardAnalysis['average'],
            'positionSizes' => $positionSizes,
            'averageRiskPerTrade' => $riskPerTrade['average'],
            'maxRiskPerTrade' => $riskPerTrade['max'],
            'monthlyReturns' => $monthlyReturns,
            'consistencyScore' => $consistencyScore,
        ];
    }

    /**
     * Calculate session analysis
     */
    public function calculateSessionAnalysis($trades)
    {
        return $trades->groupBy('session')->map(function ($group) {
            $wins = $group->where('hasil', 'win')->count();
            $total = $group->count();
            $rrValues = $group->pluck('rr')->filter(function ($rr) {
                return $rr !== null && $rr > 0;
            });

            return [
                'trades' => $total,
                'winrate' => $total > 0 ? round(($wins / $total) * 100, 2) : 0,
                'profit_loss' => $group->sum('profit_loss'),
                'avg_profit' => $total > 0 ? round($group->avg('profit_loss'), 2) : 0,
                'avg_rr' => $rrValues->count() > 0 ? round($rrValues->avg(), 2) : 0
            ];
        });
    }

    /**
     * ============================================
     * HELPER METHODS
     * ============================================
     */

    private function calculateDrawdown($trades, $initialBalance)
    {
        $runningBalance = $initialBalance;
        $peak = $initialBalance;
        $maxDrawdown = 0;
        $maxDrawdownPercentage = 0;

        $balances = [];

        $sortedTrades = $trades->sortBy(function ($trade) {
            $date = $trade->date;

            if (is_string($date)) {
                return strtotime($date);
            }

            if ($date instanceof Carbon) {
                return $date->timestamp;
            }

            return 0;
        });

        foreach ($sortedTrades as $trade) {
            $runningBalance += $trade->profit_loss ?? 0;
            $balances[] = $runningBalance;

            if ($runningBalance > $peak) {
                $peak = $runningBalance;
            }

            $drawdown = $peak - $runningBalance;
            $drawdownPercentage = $peak > 0 ? ($drawdown / $peak) * 100 : 0;

            if ($drawdown > $maxDrawdown) {
                $maxDrawdown = $drawdown;
                $maxDrawdownPercentage = $drawdownPercentage;
            }
        }

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

    private function calculateStreaks($trades)
    {
        $currentStreak = 0;
        $currentType = '';
        $maxWinStreak = 0;
        $maxLossStreak = 0;

        foreach ($trades->sortBy('date') as $trade) {
            $result = $trade->hasil;

            if ($currentType === $result) {
                $currentStreak++;
            } else {
                if ($currentType === 'win' && $currentStreak > $maxWinStreak) {
                    $maxWinStreak = $currentStreak;
                } elseif ($currentType === 'loss' && $currentStreak > $maxLossStreak) {
                    $maxLossStreak = $currentStreak;
                }

                $currentStreak = 1;
                $currentType = $result;
            }
        }

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

    private function calculateHourlyPerformance($trades)
    {
        return $trades->groupBy(function ($trade) {
            if (!$trade->timestamp) {
                return 'Unknown';
            }

            try {
                $timestamp = $trade->timestamp;
                if (is_string($timestamp)) {
                    $timestamp = Carbon::parse($timestamp);
                }
                return $timestamp->format('H');
            } catch (\Exception $e) {
                return 'Unknown';
            }
        })->map(function ($hourTrades, $hour) {
            $total = $hourTrades->count();
            $wins = $hourTrades->where('hasil', 'win')->count();
            $profit = $hourTrades->sum('profit_loss');

            return [
                'hour' => $hour,
                'trades' => $total,
                'wins' => $wins,
                'losses' => $total - $wins,
                'winrate' => $total > 0 ? round(($wins / $total) * 100, 2) : 0,
                'profit' => $profit,
                'avg_profit' => $total > 0 ? round($profit / $total, 2) : 0
            ];
        })->sortKeys();
    }

    private function calculateDayOfWeekPerformance($trades)
    {
        return $trades->groupBy(function ($trade) {
            if (!$trade->timestamp) {
                return 'Unknown';
            }

            try {
                $timestamp = $trade->timestamp;
                if (is_string($timestamp)) {
                    $timestamp = Carbon::parse($timestamp);
                }
                return $timestamp->format('w');
            } catch (\Exception $e) {
                return 'Unknown';
            }
        })->map(function ($dayTrades, $dayNumber) {
            $dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            $total = $dayTrades->count();
            $wins = $dayTrades->where('hasil', 'win')->count();
            $profit = $dayTrades->sum('profit_loss');

            return [
                'day_number' => $dayNumber,
                'day_name' => isset($dayNames[$dayNumber]) ? $dayNames[$dayNumber] : 'Unknown',
                'short_name' => isset($dayNames[$dayNumber]) ? substr($dayNames[$dayNumber], 0, 3) : 'N/A',
                'trades' => $total,
                'wins' => $wins,
                'losses' => $total - $wins,
                'winrate' => $total > 0 ? round(($wins / $total) * 100, 2) : 0,
                'profit' => $profit,
                'avg_profit' => $total > 0 ? round($profit / $total, 2) : 0
            ];
        })->sortKeys();
    }

    private function calculateMonthlyPerformance($trades)
    {
        return $trades->groupBy(function ($trade) {
            if (!$trade->timestamp) {
                return 'Unknown';
            }

            try {
                $timestamp = $trade->timestamp;
                if (is_string($timestamp)) {
                    $timestamp = Carbon::parse($timestamp);
                }
                return $timestamp->format('Y-m');
            } catch (\Exception $e) {
                return 'Unknown';
            }
        })->map(function ($monthTrades, $month) {
            $total = $monthTrades->count();
            $wins = $monthTrades->where('hasil', 'win')->count();
            $profit = $monthTrades->sum('profit_loss');

            $monthName = 'Unknown';
            if ($month !== 'Unknown' && $monthTrades->first() && $monthTrades->first()->timestamp) {
                try {
                    $timestamp = $monthTrades->first()->timestamp;
                    if (is_string($timestamp)) {
                        $timestamp = Carbon::parse($timestamp);
                    }
                    $monthName = $timestamp->format('M Y');
                } catch (\Exception $e) {
                    $monthName = 'Unknown';
                }
            }

            return [
                'month' => $month,
                'month_name' => $monthName,
                'trades' => $total,
                'wins' => $wins,
                'losses' => $total - $wins,
                'winrate' => $total > 0 ? round(($wins / $total) * 100, 2) : 0,
                'profit' => $profit,
                'avg_profit' => $total > 0 ? round($profit / $total, 2) : 0
            ];
        })->sortKeys();
    }

    private function calculateHeatmapData($trades)
    {
        $heatmapData = [];

        // Initialize empty array
        for ($day = 0; $day < 7; $day++) {
            for ($hour = 0; $hour < 24; $hour++) {
                $heatmapData[$day][$hour] = [
                    'profit' => 0,
                    'trades' => 0,
                    'hour' => str_pad($hour, 2, '0', STR_PAD_LEFT),
                    'day' => $day
                ];
            }
        }

        // Fill with actual data
        foreach ($trades as $trade) {
            if ($trade->timestamp) {
                try {
                    $timestamp = $trade->timestamp;
                    if (is_string($timestamp)) {
                        $timestamp = Carbon::parse($timestamp);
                    }

                    $hour = (int)$timestamp->format('H');
                    $day = (int)$timestamp->format('w');

                    if (isset($heatmapData[$day][$hour])) {
                        $heatmapData[$day][$hour]['profit'] += $trade->profit_loss ?? 0;
                        $heatmapData[$day][$hour]['trades']++;
                    }
                } catch (\Exception $e) {
                    // Skip if error
                }
            }
        }

        return $heatmapData;
    }

    private function findBestHour($trades)
    {
        $hourly = $this->calculateHourlyPerformance($trades);
        return $hourly->isNotEmpty() ? $hourly->sortByDesc('profit')->first() : null;
    }

    private function findWorstHour($trades)
    {
        $hourly = $this->calculateHourlyPerformance($trades);
        return $hourly->isNotEmpty() ? $hourly->sortBy('profit')->first() : null;
    }

    private function findBusiestHour($trades)
    {
        $hourly = $this->calculateHourlyPerformance($trades);
        return $hourly->isNotEmpty() ? $hourly->sortByDesc('trades')->first() : null;
    }

    private function calculateTradingTimeStats($trades)
    {
        return [
            'total_trading_hours' => $this->calcTotalTradingHours($trades),
            'avg_trades_per_day' => $this->calcAvgTradesPerDay($trades),
            'most_active_day' => $this->findMostActiveDay($trades),
            'trading_frequency' => $this->calcTradingFrequency($trades)
        ];
    }

    private function calculateSharpeRatio($trades, $initialBalance)
    {
        if ($trades->count() < 2) return 0;

        $dailyReturns = $trades->groupBy(function ($trade) {
            $date = $trade->date;

            if (is_string($date)) {
                try {
                    $date = Carbon::parse($date);
                } catch (\Exception $e) {
                    $date = now();
                }
            }

            if ($date instanceof Carbon) {
                return $date->format('Y-m-d');
            } else {
                return substr($date, 0, 10);
            }
        })->map(function ($dayTrades) use ($initialBalance) {
            return $initialBalance > 0 ?
                round(($dayTrades->sum('profit_loss') / $initialBalance) * 100, 4) : 0;
        })->filter(function ($return) {
            return is_numeric($return);
        })->values();

        if ($dailyReturns->count() < 2) return 0;

        $averageReturn = $dailyReturns->avg();
        $stdDev = $this->calculateStandardDeviation($dailyReturns->toArray());

        if ($stdDev == 0) return 0;

        return round(($averageReturn - 0) / $stdDev, 2);
    }

    private function calculateRiskRewardAnalysis($trades)
    {
        $riskRewardRatios = $trades->map(function ($trade) {
            return $trade->rr ?? null;
        })->filter(function ($rr) {
            return $rr !== null;
        });

        $average = $riskRewardRatios->count() > 0 ?
            round($riskRewardRatios->avg(), 2) : 0;

        return [
            'average' => $average,
            'count' => $riskRewardRatios->count(),
            'data' => $riskRewardRatios
        ];
    }

    private function calculatePositionSizeAnalysis($trades)
    {
        return $trades->groupBy(function ($trade) {
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
    }

    private function calculateRiskPerTrade($trades, $initialBalance)
    {
        $riskPercentages = $trades->map(function ($trade) use ($initialBalance) {
            $equityAtTrade = $initialBalance; // Simplified
            $loss = $trade->hasil === 'loss' ? abs($trade->profit_loss) : 0;
            return $equityAtTrade > 0 ? ($loss / $equityAtTrade) * 100 : 0;
        });

        return [
            'average' => $riskPercentages->count() > 0 ?
                round($riskPercentages->avg(), 2) : 0,
            'max' => $riskPercentages->count() > 0 ?
                round($riskPercentages->max(), 2) : 0,
            'data' => $riskPercentages
        ];
    }

    private function calculateMonthlyReturns($trades, $initialBalance)
    {
        return $trades->groupBy(function ($trade) {
            $date = $trade->date;

            if (is_string($date)) {
                try {
                    $date = Carbon::parse($date);
                } catch (\Exception $e) {
                    $date = now();
                }
            }

            if ($date instanceof Carbon) {
                return $date->format('Y-m');
            } else {
                return substr($date, 0, 7);
            }
        })->map(function ($monthTrades, $month) use ($initialBalance) {
            $profit = $monthTrades->sum('profit_loss');
            $firstTrade = $monthTrades->first();
            $date = $firstTrade->date;

            if (is_string($date)) {
                try {
                    $date = Carbon::parse($date);
                } catch (\Exception $e) {
                    $date = now();
                }
            }

            $monthName = $date instanceof Carbon ?
                $date->format('M Y') :
                date('M Y', strtotime($date));

            return [
                'profit' => $profit,
                'return_percent' => $initialBalance > 0 ? round(($profit / $initialBalance) * 100, 2) : 0,
                'month' => $monthName,
                'year_month' => $date instanceof Carbon ? $date->format('Y-m') : substr($date, 0, 7)
            ];
        })->sortBy('year_month');
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

    private function calcTotalTradingHours($trades)
    {
        if ($trades->count() < 2) return 0;

        $uniqueDays = $trades->filter(function ($trade) {
            return $trade->timestamp;
        })->groupBy(function ($trade) {
            try {
                $timestamp = $trade->timestamp;
                if (is_string($timestamp)) {
                    $timestamp = Carbon::parse($timestamp);
                }
                return $timestamp->format('Y-m-d');
            } catch (\Exception $e) {
                return 'unknown';
            }
        })->count();

        return $uniqueDays * 4;
    }

    private function calcAvgTradesPerDay($trades)
    {
        $daysWithTrades = $trades->filter(function ($trade) {
            return $trade->timestamp;
        })->groupBy(function ($trade) {
            try {
                $timestamp = $trade->timestamp;
                if (is_string($timestamp)) {
                    $timestamp = Carbon::parse($timestamp);
                }
                return $timestamp->format('Y-m-d');
            } catch (\Exception $e) {
                return 'unknown';
            }
        });

        if ($daysWithTrades->count() == 0) return 0;

        return round($trades->count() / $daysWithTrades->count(), 2);
    }

    private function findMostActiveDay($trades)
    {
        $dayCounts = $trades->filter(function ($trade) {
            return $trade->timestamp;
        })->groupBy(function ($trade) {
            try {
                $timestamp = $trade->timestamp;
                if (is_string($timestamp)) {
                    $timestamp = Carbon::parse($timestamp);
                }
                return $timestamp->format('l');
            } catch (\Exception $e) {
                return 'Unknown';
            }
        })->map->count();

        if ($dayCounts->count() == 0) return ['day' => 'N/A', 'count' => 0];

        $mostActive = $dayCounts->sortDesc()->first();
        $mostActiveDay = $dayCounts->sortDesc()->keys()->first();

        return ['day' => $mostActiveDay, 'count' => $mostActive];
    }

    private function calcTradingFrequency($trades)
    {
        if ($trades->count() < 2) return 'Low';

        $validTrades = $trades->filter(function ($trade) {
            return $trade->timestamp;
        });

        if ($validTrades->count() < 2) return 'Unknown';

        $sortedTrades = $validTrades->sortBy(function ($trade) {
            try {
                $timestamp = $trade->timestamp;
                if (is_string($timestamp)) {
                    return Carbon::parse($timestamp)->timestamp;
                }
                return $timestamp->timestamp;
            } catch (\Exception $e) {
                return 0;
            }
        });

        $firstTrade = $sortedTrades->first();
        $lastTrade = $sortedTrades->last();

        try {
            $firstTimestamp = $firstTrade->timestamp;
            $lastTimestamp = $lastTrade->timestamp;

            if (is_string($firstTimestamp)) {
                $firstTimestamp = Carbon::parse($firstTimestamp);
            }
            if (is_string($lastTimestamp)) {
                $lastTimestamp = Carbon::parse($lastTimestamp);
            }

            $daysDiff = $firstTimestamp->diffInDays($lastTimestamp);
            if ($daysDiff == 0) return 'Very High';

            $tradesPerDay = $trades->count() / $daysDiff;

            if ($tradesPerDay >= 5) return 'Very High';
            if ($tradesPerDay >= 3) return 'High';
            if ($tradesPerDay >= 1) return 'Medium';
            if ($tradesPerDay >= 0.5) return 'Low';
            return 'Very Low';
        } catch (\Exception $e) {
            return 'Unknown';
        }
    }

    /**
     * Get available sessions from database
     */
    public function getAvailableSessions()
    {
        return Trade::distinct('session')
            ->whereNotNull('session')
            ->where('session', '!=', '')
            ->pluck('session')
            ->toArray();
    }

    /**
     * Get available entry types from database
     */
    public function getAvailableEntryTypes()
    {
        return Trade::distinct('entry_type')
            ->whereNotNull('entry_type')
            ->where('entry_type', '!=', '')
            ->pluck('entry_type')
            ->toArray();
    }
}
