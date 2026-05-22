<?php

namespace App\Services;

use App\Models\Trade;
use Illuminate\Database\Eloquent\Builder;
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

        // Filter by selected account from session
        $selectedAccountId = session('selected_account_id');
        if ($selectedAccountId) {
            $query->where('account_id', $selectedAccountId);
        }

        // Eager load relationships to prevent N+1 queries
        if ($withRelations) {
            $query->with(['symbol', 'account', 'tradingRules']);
        }

        $query->orderBy('date')->orderBy('timestamp');

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
        if ($trades instanceof Builder) {
            return $this->calculateBasicMetricsDb($trades, $initialBalance);
        }

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

    private function calculateBasicMetricsDb(Builder $query, $initialBalance)
    {
        $query = clone $query;

        $totals = $query->selectRaw(
            "COUNT(*) as total_trades,
             SUM(CASE WHEN hasil = 'win' THEN 1 ELSE 0 END) as wins,
             SUM(CASE WHEN hasil = 'loss' THEN 1 ELSE 0 END) as losses,
             SUM(CASE WHEN hasil = 'win' THEN profit_loss ELSE 0 END) as total_profit,
             SUM(CASE WHEN hasil = 'loss' THEN profit_loss ELSE 0 END) as total_loss,
             AVG(CASE WHEN hasil = 'win' THEN profit_loss ELSE NULL END) as avg_win,
             ABS(AVG(CASE WHEN hasil = 'loss' THEN profit_loss ELSE NULL END)) as avg_loss,
             MAX(CASE WHEN hasil = 'win' THEN profit_loss ELSE NULL END) as largest_win,
             MIN(CASE WHEN hasil = 'loss' THEN profit_loss ELSE NULL END) as largest_loss"
        )->first();

        $totalTrades = (int) $totals->total_trades;
        $wins = (int) $totals->wins;
        $winrate = $totalTrades > 0 ? round(($wins / $totalTrades) * 100, 2) : 0;

        $totalProfit = (float) $totals->total_profit;
        $totalLoss = abs((float) $totals->total_loss);
        $netProfit = $totalProfit - $totalLoss;
        $balance = $initialBalance + $netProfit;

        $averageWin = $totals->avg_win !== null ? round((float) $totals->avg_win, 2) : 0;
        $averageLoss = $totals->avg_loss !== null ? round((float) $totals->avg_loss, 2) : 0;
        $largestWin = $totals->largest_win !== null ? (float) $totals->largest_win : 0;
        $largestLoss = $totals->largest_loss !== null ? (float) $totals->largest_loss : 0;

        $averageRR = ($averageLoss > 0) ? round($averageWin / $averageLoss, 2) : 0;
        $profitFactor = ($totalLoss > 0) ?
            round($totalProfit / $totalLoss, 2) : ($totalProfit > 0 ? '∞' : 0);

        $winrateDecimal = $winrate / 100;
        $expectancy = round(
            ($winrateDecimal * $averageWin) - ((1 - $winrateDecimal) * $averageLoss),
            2
        );

        $tradeRows = $query->get(['date', 'timestamp', 'profit_loss', 'hasil']);
        $drawdownData = $this->calculateDrawdown($tradeRows, $initialBalance);
        $streaks = $this->calculateStreaks($tradeRows);

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

        if ($trades instanceof Builder) {
            $query = clone $trades;
            $query->where('entry_type', $entryFilter);

            if ($sessionFilter !== 'all') {
                $query->where('session', $sessionFilter);
            }

            $totals = $query->selectRaw(
                "COUNT(*) as total, SUM(CASE WHEN hasil = 'win' THEN 1 ELSE 0 END) as wins, SUM(profit_loss) as profit_loss"
            )->first();

            $total = (int) $totals->total;
            $wins = (int) $totals->wins;
            $profitLoss = $totals->profit_loss !== null ? (float) $totals->profit_loss : 0;

            return [
                'entry_type' => $entryFilter,
                'session' => $sessionFilter !== 'all' ? $sessionFilter : 'All Sessions',
                'trades' => $total,
                'winrate' => $total > 0 ? round(($wins / $total) * 100, 2) : 0,
                'profit_loss' => $profitLoss
            ];
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
            $winningTrades = $group->where('hasil', 'win');
            $losingTrades = $group->where('hasil', 'loss');
            $wins = $winningTrades->count();
            $losses = $losingTrades->count();
            $total = $group->count();

            return [
                'trades' => $total,
                'winrate' => $total > 0 ? round(($wins / $total) * 100, 2) : 0,
                'profit_loss' => $group->sum('profit_loss'),
                'wins' => $wins,
                'losses' => $losses,
                'total_profit_wins' => round($winningTrades->sum('profit_loss'), 2),
                'total_loss_losses' => round($losingTrades->sum('profit_loss'), 2)
            ];
        });
    }

    /**
     * DB-backed pair analysis (faster for large datasets)
     */
    public function calculatePairAnalysisDb($query)
    {
        $query = clone $query;

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
        $query = clone $query;

        $rows = $query->select(
            'entry_type',
            DB::raw("SUM(CASE WHEN hasil = 'win' THEN 1 ELSE 0 END) as wins"),
            DB::raw("SUM(CASE WHEN hasil = 'loss' THEN 1 ELSE 0 END) as losses"),
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(profit_loss) as total_profit'),
            DB::raw("SUM(CASE WHEN hasil = 'win' THEN profit_loss ELSE 0 END) as total_profit_wins"),
            DB::raw("SUM(CASE WHEN hasil = 'loss' THEN profit_loss ELSE 0 END) as total_loss_losses")
        )
            ->groupBy('entry_type')
            ->get();

        $result = [];
        foreach ($rows as $row) {
            $total = (int) $row->total;
            $wins = (int) $row->wins;
            $losses = (int) $row->losses;
            $result[$row->entry_type] = [
                'trades' => $total,
                'winrate' => $total > 0 ? round(($wins / $total) * 100, 2) : 0,
                'profit_loss' => (float) $row->total_profit,
                'wins' => $wins,
                'losses' => $losses,
                'total_profit_wins' => round((float) $row->total_profit_wins, 2),
                'total_loss_losses' => round((float) $row->total_loss_losses, 2)
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
        $tradeRows = $trades instanceof Builder ? $trades->get() : $trades;
        $tradeDurationAnalysis = $this->calculateTradeDurationAnalysis($tradeRows);

        $hourlyPerformance = $this->calculateHourlyPerformance($trades);
        $dayOfWeekPerformance = $this->calculateDayOfWeekPerformance($trades);
        $monthlyPerformance = $this->calculateMonthlyPerformance($trades);
        $quarterlyPerformance = $this->calculateQuarterlyPerformance($trades);
        $heatmapData = $this->calculateHeatmapData($trades);

        return [
            'hourlyPerformance' => $hourlyPerformance,
            'dayOfWeekPerformance' => $dayOfWeekPerformance,
            'monthlyPerformance' => $monthlyPerformance,
            'quarterlyPerformance' => $quarterlyPerformance,
            'heatmapData' => $heatmapData,
            'bestHour' => $this->findBestHour($trades),
            'worstHour' => $this->findWorstHour($trades),
            'busiestHour' => $this->findBusiestHour($trades),
            'fastestTradeDuration' => $tradeDurationAnalysis['fastest'] ?? null,
            'medianTradeDuration' => $tradeDurationAnalysis['median'] ?? null,
            'longestTradeDuration' => $tradeDurationAnalysis['longest'] ?? null,
            'modeTradeDuration' => $tradeDurationAnalysis['mode'] ?? null,
            'tradingTimeStats' => $this->calculateTradingTimeStats($tradeRows),
        ];
    }

    private function calculateHourlyPerformance($trades)
    {
        if ($trades instanceof Builder) {
            return $this->calculateHourlyPerformanceDb($trades);
        }

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
        if ($trades instanceof Builder) {
            return $this->calculateDayOfWeekPerformanceDb($trades);
        }

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
        if ($trades instanceof Builder) {
            return $this->calculateMonthlyPerformanceDb($trades);
        }

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

    private function calculateQuarterlyPerformance($trades)
    {
        if ($trades instanceof Builder) {
            return $this->calculateQuarterlyPerformanceDb($trades);
        }

        return $trades->groupBy(function ($trade) {
            if (!$trade->timestamp) {
                return 'Unknown';
            }

            try {
                $timestamp = $trade->timestamp;
                if (is_string($timestamp)) {
                    $timestamp = Carbon::parse($timestamp);
                }
                $year = $timestamp->format('Y');
                $quarter = ceil($timestamp->month / 3);
                return "{$year}-Q{$quarter}";
            } catch (\Exception $e) {
                return 'Unknown';
            }
        })->map(function ($quarterTrades, $quarter) {
            $total = $quarterTrades->count();
            $wins = $quarterTrades->where('hasil', 'win')->count();
            $profit = $quarterTrades->sum('profit_loss');

            $quarterName = 'Unknown';
            if ($quarter !== 'Unknown' && $quarterTrades->first() && $quarterTrades->first()->timestamp) {
                try {
                    $timestamp = $quarterTrades->first()->timestamp;
                    if (is_string($timestamp)) {
                        $timestamp = Carbon::parse($timestamp);
                    }
                    $year = $timestamp->format('Y');
                    $quarterNum = ceil($timestamp->month / 3);
                    $quarterName = "Q{$quarterNum} {$year}";
                } catch (\Exception $e) {
                    $quarterName = 'Unknown';
                }
            }

            return [
                'quarter' => $quarter,
                'quarter_name' => $quarterName,
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
        if ($trades instanceof Builder) {
            return $this->calculateHeatmapDataDb($trades);
        }

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

    private function calculateHourlyPerformanceDb(Builder $query)
    {
        $query = clone $query;

        $rows = $query->selectRaw(
            "HOUR(timestamp) as hour, COUNT(*) as trades, SUM(CASE WHEN hasil = 'win' THEN 1 ELSE 0 END) as wins, SUM(profit_loss) as profit, AVG(profit_loss) as avg_profit"
        )
            ->whereNotNull('timestamp')
            ->groupByRaw('HOUR(timestamp)')
            ->orderByRaw('HOUR(timestamp)')
            ->get();

        return $rows->map(function ($row) {
            $total = (int) $row->trades;
            $wins = (int) $row->wins;

            return [
                'hour' => str_pad($row->hour, 2, '0', STR_PAD_LEFT),
                'trades' => $total,
                'wins' => $wins,
                'losses' => $total - $wins,
                'winrate' => $total > 0 ? round(($wins / $total) * 100, 2) : 0,
                'profit' => (float) $row->profit,
                'avg_profit' => $total > 0 ? round((float) $row->avg_profit, 2) : 0
            ];
        })->sortBy(function ($item) {
            return (int) $item['hour']; // Sort berdasarkan integer hour
        })->values();
    }

    private function calculateDayOfWeekPerformanceDb(Builder $query)
    {
        $query = clone $query;
        $dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        $rows = $query->selectRaw(
            "(DAYOFWEEK(timestamp) - 1) as day_number, COUNT(*) as trades, SUM(CASE WHEN hasil = 'win' THEN 1 ELSE 0 END) as wins, SUM(profit_loss) as profit, AVG(profit_loss) as avg_profit"
        )
            ->whereNotNull('timestamp')
            ->groupByRaw('(DAYOFWEEK(timestamp) - 1)')
            ->orderByRaw('(DAYOFWEEK(timestamp) - 1)')
            ->get();

        return $rows->map(function ($row) use ($dayNames) {
            $total = (int) $row->trades;
            $wins = (int) $row->wins;

            return [
                'day_number' => (int) $row->day_number,
                'day_name' => $dayNames[(int) $row->day_number] ?? 'Unknown',
                'short_name' => isset($dayNames[(int) $row->day_number]) ? substr($dayNames[(int) $row->day_number], 0, 3) : 'N/A',
                'trades' => $total,
                'wins' => $wins,
                'losses' => $total - $wins,
                'winrate' => $total > 0 ? round(($wins / $total) * 100, 2) : 0,
                'profit' => (float) $row->profit,
                'avg_profit' => $total > 0 ? round((float) $row->avg_profit, 2) : 0
            ];
        })->keyBy('day_number');
    }

    private function calculateMonthlyPerformanceDb(Builder $query)
    {
        $query = clone $query;

        $rows = $query->selectRaw(
            "DATE_FORMAT(timestamp, '%Y-%m') as month, COUNT(*) as trades, SUM(CASE WHEN hasil = 'win' THEN 1 ELSE 0 END) as wins, SUM(profit_loss) as profit, AVG(profit_loss) as avg_profit"
        )
            ->whereNotNull('timestamp')
            ->groupByRaw("DATE_FORMAT(timestamp, '%Y-%m')")
            ->orderByRaw("DATE_FORMAT(timestamp, '%Y-%m')")
            ->get();

        return $rows->map(function ($row) {
            $total = (int) $row->trades;
            $wins = (int) $row->wins;
            $carbon = Carbon::createFromFormat('Y-m', $row->month);

            return [
                'month' => $row->month,
                'month_name' => $carbon->format('M Y'),
                'trades' => $total,
                'wins' => $wins,
                'losses' => $total - $wins,
                'winrate' => $total > 0 ? round(($wins / $total) * 100, 2) : 0,
                'profit' => (float) $row->profit,
                'avg_profit' => $total > 0 ? round((float) $row->avg_profit, 2) : 0
            ];
        })->keyBy('month');
    }

    private function calculateQuarterlyPerformanceDb(Builder $query)
    {
        $query = clone $query;

        $rows = $query->selectRaw(
            "CONCAT(YEAR(timestamp), '-Q', QUARTER(timestamp)) as quarter, COUNT(*) as trades, SUM(CASE WHEN hasil = 'win' THEN 1 ELSE 0 END) as wins, SUM(profit_loss) as profit, AVG(profit_loss) as avg_profit"
        )
            ->whereNotNull('timestamp')
            ->groupByRaw("CONCAT(YEAR(timestamp), '-Q', QUARTER(timestamp))")
            ->orderByRaw("CONCAT(YEAR(timestamp), '-Q', QUARTER(timestamp))")
            ->get();

        return $rows->map(function ($row) {
            $total = (int) $row->trades;
            $wins = (int) $row->wins;

            $parts = explode('-Q', $row->quarter);
            $year = $parts[0] ?? null;
            $quarterNum = isset($parts[1]) ? (int) $parts[1] : null;
            $quarterName = $year && $quarterNum ? "Q{$quarterNum} {$year}" : 'Unknown';

            return [
                'quarter' => $row->quarter,
                'quarter_name' => $quarterName,
                'trades' => $total,
                'wins' => $wins,
                'losses' => $total - $wins,
                'winrate' => $total > 0 ? round(($wins / $total) * 100, 2) : 0,
                'profit' => (float) $row->profit,
                'avg_profit' => $total > 0 ? round((float) $row->avg_profit, 2) : 0
            ];
        })->keyBy('quarter');
    }

    private function calculateHeatmapDataDb(Builder $query)
    {
        $query = clone $query;

        $base = [];
        for ($day = 0; $day < 7; $day++) {
            for ($hour = 0; $hour < 24; $hour++) {
                $base[$day][$hour] = [
                    'profit' => 0,
                    'trades' => 0,
                    'hour' => str_pad($hour, 2, '0', STR_PAD_LEFT),
                    'day' => $day,
                ];
            }
        }

        $rows = $query->selectRaw(
            "(DAYOFWEEK(timestamp) - 1) as day, HOUR(timestamp) as hour, SUM(profit_loss) as profit, COUNT(*) as trades"
        )
            ->whereNotNull('timestamp')
            ->groupByRaw('(DAYOFWEEK(timestamp) - 1), HOUR(timestamp)')
            ->get();

        foreach ($rows as $row) {
            if (isset($base[$row->day][$row->hour])) {
                $base[$row->day][$row->hour]['profit'] = (float) $row->profit;
                $base[$row->day][$row->hour]['trades'] = (int) $row->trades;
            }
        }

        return $base;
    }

    private function calculateSessionAnalysisDb(Builder $query)
    {
        $query = clone $query;

        $rows = $query->selectRaw(
            "session, COUNT(*) as trades, SUM(CASE WHEN hasil = 'win' THEN 1 ELSE 0 END) as wins, SUM(profit_loss) as profit, AVG(profit_loss) as avg_profit, AVG(rr) as avg_rr"
        )
            ->whereNotNull('session')
            ->where('session', '!=', '')
            ->groupBy('session')
            ->get();

        return $rows->mapWithKeys(function ($row) {
            $total = (int) $row->trades;
            $wins = (int) $row->wins;

            return [
                $row->session => [
                    'trades' => $total,
                    'winrate' => $total > 0 ? round(($wins / $total) * 100, 2) : 0,
                    'profit_loss' => (float) $row->profit,
                    'avg_profit' => $total > 0 ? round((float) $row->avg_profit, 2) : 0,
                    'avg_rr' => $total > 0 ? round((float) $row->avg_rr, 2) : 0,
                ]
            ];
        });
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
        if ($trades instanceof Builder) {
            return $this->calculateSessionAnalysisDb($trades);
        }

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

        // Gunakan sortBy yang lebih efisien
        $sortedTrades = $trades->sortBy(function ($trade) {
            // Gabungkan date dan timestamp untuk sorting yang akurat
            $date = $trade->date instanceof Carbon
                ? $trade->date->format('Y-m-d')
                : $trade->date;
            $time = $trade->timestamp
                ? ($trade->timestamp instanceof Carbon
                    ? $trade->timestamp->format('H:i:s')
                    : '00:00:00')
                : '00:00:00';
            return $date . ' ' . $time;
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
            'max_drawdown' => round($maxDrawdown, 2),
            'max_drawdown_percentage' => round($maxDrawdownPercentage, 2),
            'current_drawdown' => round($currentDrawdown, 2),
            'current_drawdown_percentage' => round($currentDrawdownPercentage, 2),
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

    private function calculateTradeDurationAnalysis($trades)
    {
        $durations = $trades->map(function ($trade) {
            if (empty($trade->timestamp) || empty($trade->exit_timestamp)) {
                return null;
            }

            try {
                $entryTimestamp = $trade->timestamp instanceof Carbon ? $trade->timestamp : Carbon::parse($trade->timestamp);
                $exitTimestamp = $trade->exit_timestamp instanceof Carbon ? $trade->exit_timestamp : Carbon::parse($trade->exit_timestamp);
            } catch (\Exception $e) {
                return null;
            }

            if ($exitTimestamp->lessThan($entryTimestamp)) {
                return null;
            }

            $durationSeconds = $exitTimestamp->diffInSeconds($entryTimestamp);

            // Skip durations of 0 or less
            if ($durationSeconds <= 0) {
                return null;
            }

            return [
                'trade' => $trade,
                'duration_seconds' => $durationSeconds,
                'duration_text' => $this->formatDuration($durationSeconds),
            ];
        })->filter()->sortBy('duration_seconds')->values();

        if ($durations->isEmpty()) {
            return [
                'fastest' => null,
                'median' => null,
                'longest' => null,
                'mode' => null,
                'count' => 0,
            ];
        }

        $count = $durations->count();
        $medianIndex = (int) floor(($count - 1) / 2);

        $fastest = $durations->first();
        $median = $durations->get($medianIndex);
        $longest = $durations->last();

        // Ensure fastest is different from median
        // If they are the same, find the next fastest that differs from median
        if ($fastest['duration_seconds'] === $median['duration_seconds'] && $count > 1) {
            $fastest = $durations->first(function ($duration) use ($median) {
                return $duration['duration_seconds'] !== $median['duration_seconds'];
            });

            // If no different duration found, use the second item
            if (!$fastest && $count > 1) {
                $fastest = $durations->get(1);
            }
        }

        $mode = $durations->groupBy('duration_seconds')->map(function ($group, $seconds) {
            return [
                'duration_seconds' => (int)$seconds,
                'count' => $group->count(),
                'duration_text' => $group->first()['duration_text'],
            ];
        })->sortBy(function ($item) {
            return [
                $item['count'] * -1,
                $item['duration_seconds'],
            ];
        })->values()->first();

        return [
            'fastest' => $fastest,
            'median' => $median,
            'longest' => $longest,
            'mode' => $mode,
            'count' => $count,
        ];
    }

    private function formatDuration($seconds)
    {
        if ($seconds < 60) {
            return $seconds . ' detik';
        } elseif ($seconds < 3600) {
            $minutes = floor($seconds / 60);
            return $minutes . ' menit';
        } elseif ($seconds < 86400) {
            $hours = floor($seconds / 3600);
            $remainingMinutes = floor(($seconds % 3600) / 60);
            if ($remainingMinutes > 0) {
                return $hours . ' jam ' . $remainingMinutes . ' menit';
            }
            return $hours . ' jam';
        } elseif ($seconds < 604800) { // less than 1 week
            $days = floor($seconds / 86400);
            $remainingHours = floor(($seconds % 86400) / 3600);
            if ($remainingHours > 0) {
                return $days . ' hari ' . $remainingHours . ' jam';
            }
            return $days . ' hari';
        } elseif ($seconds < 2592000) { // less than 1 month
            $weeks = floor($seconds / 604800);
            $remainingDays = floor(($seconds % 604800) / 86400);
            if ($remainingDays > 0) {
                return $weeks . ' minggu ' . $remainingDays . ' hari';
            }
            return $weeks . ' minggu';
        } else {
            $months = floor($seconds / 2592000);
            $remainingWeeks = floor(($seconds % 2592000) / 604800);
            if ($remainingWeeks > 0) {
                return $months . ' bulan ' . $remainingWeeks . ' minggu';
            }
            return $months . ' bulan';
        }
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

        // Hitung equity setelah setiap trade
        $runningBalance = $initialBalance;
        $dailyReturns = [];

        // Kelompokkan berdasarkan tanggal
        $tradesByDate = $trades->sortBy('date')->groupBy(function ($trade) {
            return $trade->date instanceof Carbon
                ? $trade->date->format('Y-m-d')
                : date('Y-m-d', strtotime($trade->date));
        });

        foreach ($tradesByDate as $date => $dayTrades) {
            $dayProfit = $dayTrades->sum('profit_loss');
            $equityStartOfDay = $runningBalance;
            $dailyReturn = $equityStartOfDay > 0 ? ($dayProfit / $equityStartOfDay) * 100 : 0;

            if ($dayProfit != 0 || $dayTrades->count() > 0) {
                $dailyReturns[] = $dailyReturn;
            }

            $runningBalance += $dayProfit;
        }

        if (count($dailyReturns) < 2) return 0;

        $averageReturn = array_sum($dailyReturns) / count($dailyReturns);
        $stdDev = $this->calculateStandardDeviation($dailyReturns);

        if ($stdDev == 0) return 0;

        // Annualized Sharpe (assuming 252 trading days)
        $annualizedReturn = $averageReturn * sqrt(252);
        $annualizedStdDev = $stdDev * sqrt(252);

        return $annualizedStdDev > 0
            ? round($annualizedReturn / $annualizedStdDev, 2)
            : 0;
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
            $size = $trade->lot_size ?? 0;
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
        $runningBalance = $initialBalance;
        $riskPercentages = [];

        $sortedTrades = $trades->sortBy(function ($trade) {
            // $trade->date sudah string 'Y-m-d' dari accessor
            $datePart = $trade->date;

            // Pastikan timestamp juga ditangani dengan benar
            $timePart = ($trade->timestamp instanceof \Carbon\Carbon)
                ? $trade->timestamp->format('H:i:s')
                : '00:00:00';

            return $datePart . ' ' . $timePart;
        });

        foreach ($sortedTrades as $trade) {
            // Hitung risk berdasarkan equity SEBELUM trade
            $equityAtTrade = $runningBalance;
            $loss = $trade->hasil === 'loss' ? abs($trade->profit_loss) : 0;
            $riskPercent = $equityAtTrade > 0 ? ($loss / $equityAtTrade) * 100 : 0;

            if ($loss > 0) {
                $riskPercentages[] = $riskPercent;
            }

            // Update running balance untuk trade berikutnya
            $runningBalance += $trade->profit_loss ?? 0;
        }

        return [
            'average' => !empty($riskPercentages) ? round(array_sum($riskPercentages) / count($riskPercentages), 2) : 0,
            'max' => !empty($riskPercentages) ? round(max($riskPercentages), 2) : 0,
            'data' => $riskPercentages
        ];
    }

    private function calculateMonthlyReturns($trades, $initialBalance)
    {
        $runningBalance = $initialBalance;
        $monthlyReturns = [];

        $sortedTrades = $trades->sortBy('date');

        // Kelompokkan berdasarkan bulan (Y-m)
        $tradesByMonth = $sortedTrades->groupBy(function ($trade) {
            return $trade->date instanceof Carbon
                ? $trade->date->format('Y-m')
                : substr($trade->date, 0, 7);
        });

        foreach ($tradesByMonth as $yearMonth => $monthTrades) {
            $monthProfit = $monthTrades->sum('profit_loss');
            $equityStartOfMonth = $runningBalance;
            $returnPercent = $equityStartOfMonth > 0
                ? round(($monthProfit / $equityStartOfMonth) * 100, 2)
                : 0;

            // Dapatkan nama bulan dari trade pertama
            $firstTrade = $monthTrades->first();
            $monthName = $firstTrade->date instanceof Carbon
                ? $firstTrade->date->format('M Y')
                : date('M Y', strtotime($firstTrade->date));

            $monthlyReturns[] = [
                'profit' => $monthProfit,
                'return_percent' => $returnPercent,
                'month' => $monthName,
                'year_month' => $yearMonth
            ];

            $runningBalance += $monthProfit;
        }

        return collect($monthlyReturns)->sortBy('year_month');
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

        $totalHours = 0;

        // Kelompokkan berdasarkan tanggal
        $tradesByDay = $trades->filter(function ($trade) {
            return $trade->timestamp;
        })->groupBy(function ($trade) {
            return $trade->date instanceof Carbon
                ? $trade->date->format('Y-m-d')
                : $trade->date;
        });

        foreach ($tradesByDay as $dayTrades) {
            if ($dayTrades->count() < 2) {
                // Jika hanya 1 trade di hari itu, asumsikan 1 jam
                $totalHours += 1;
                continue;
            }

            // Cari timestamp pertama dan terakhir di hari itu
            $firstTrade = $dayTrades->sortBy('timestamp')->first();
            $lastTrade = $dayTrades->sortByDesc('timestamp')->first();

            if ($firstTrade->timestamp && $lastTrade->timestamp) {
                $diffInHours = $firstTrade->timestamp->diffInHours($lastTrade->timestamp);
                // Minimal 0.5 jam, maximal 24 jam
                $totalHours += max(0.5, min(24, $diffInHours + 1));
            } else {
                $totalHours += 1;
            }
        }

        return round($totalHours, 1);
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
        $accountId = session('selected_account_id') ?: 'all';
        return cache()->remember("available_sessions_for_{$accountId}", 300, function () use ($accountId) {
            $query = Trade::distinct('session')
                ->whereNotNull('session')
                ->where('session', '!=', '');

            if ($accountId !== 'all') {
                $query->where('account_id', $accountId);
            }

            return $query->pluck('session')->toArray();
        });
    }

    /**
     * Get available entry types from database
     */
    public function getAvailableEntryTypes()
    {
        $accountId = session('selected_account_id') ?: 'all';
        return cache()->remember("available_entry_types_for_{$accountId}", 300, function () use ($accountId) {
            $query = Trade::distinct('entry_type')
                ->whereNotNull('entry_type')
                ->where('entry_type', '!=', '');

            if ($accountId !== 'all') {
                $query->where('account_id', $accountId);
            }

            return $query->pluck('entry_type')->toArray();
        });
    }

    /**
     * Calculate overall equity curve data from start to current by Time
     */
    public function calculateOverallEquityDataByTime($trades, $initialBalance)
    {
        $equityData = [];
        $runningBalance = $initialBalance;

        // Sort trades by date and time if available
        $sortedTrades = $trades->sortBy(function ($trade) {
            $date = $trade->date;
            $time = $trade->timestamp ?? '00:00:00';
            return $date . ' ' . $time;
        });

        foreach ($sortedTrades as $trade) {
            $runningBalance += $trade->profit_loss ?? 0;

            $equityData[] = [
                'date' => $trade->date,
                'time' => $trade->timestamp ?? null,
                'balance' => $runningBalance,
                'profit_loss' => $trade->profit_loss ?? 0
            ];
        }

        return $equityData;
    }

    // Calculate overall equity curve data from start to current by Date (ignore time)
    public function calculateOverallEquityData($trades, $initialBalance)
    {
        $dailyEquity = [];
        $runningBalance = $initialBalance;

        // Sort trades by date (abaikan waktu)
        $sortedTrades = $trades->sortBy('date');

        $currentDate = null;
        $lastBalanceOfDay = null;

        foreach ($sortedTrades as $trade) {
            $runningBalance += $trade->profit_loss ?? 0;

            // Jika ganti tanggal, simpan data hari sebelumnya
            if ($currentDate && $currentDate != $trade->date) {
                $dailyEquity[] = [
                    'date' => $currentDate,
                    'balance' => $lastBalanceOfDay,
                ];
            }

            $currentDate = $trade->date;
            $lastBalanceOfDay = $runningBalance;
        }

        // Tambahkan hari terakhir
        if ($currentDate) {
            $dailyEquity[] = [
                'date' => $currentDate,
                'balance' => $lastBalanceOfDay,
            ];
        }

        return $dailyEquity;
    }
}
