<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Services\TradeAnalysisService;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    protected $analysisService;

    public function __construct(TradeAnalysisService $analysisService)
    {
        $this->analysisService = $analysisService;
    }

    public function index(Request $request)
    {
        try {
            // Get selected account from session
            $selectedAccountId = session('selected_account_id');
            $account = Account::find($selectedAccountId);
            if (!$account) {
                Log::warning('Selected account not found in dashboard');
                $initialBalance = 10000;
            } else {
                $initialBalance = $account->initial_balance;
            }

            // Get filtered trades query (don't fetch yet) so we can use DB aggregations
            try {
                $query = $this->analysisService->getFilteredTrades($request, true);
                // Add eager loading for cases where collections are used
                $query = $query->with('symbol', 'account', 'tradingRules');
            } catch (\Exception $e) {
                Log::error('Error building filtered trades query: ' . $e->getMessage());
                $query = null;
            }

            // Get filter values
            $period = $request->get('period', 'all');
            $sessionFilter = $request->get('session', 'all');
            $entryFilter = $request->get('entry_type', 'all');

            // Use caching for dashboard payload to reduce repeated heavy calculations
            try {
                $period = $request->get('period', 'all');
                $sessionFilter = $request->get('session', 'all');
                $entryFilter = $request->get('entry_type', 'all');

                // Use last trade updated timestamp to invalidate cache when trades change
                $tradesMaxUpdated = \App\Models\Trade::max('updated_at') ?: now()->toDateTimeString();
                $cacheKey = "dashboard:period={$period}:session={$sessionFilter}:entry={$entryFilter}:account={$account->id}:tmax={$tradesMaxUpdated}";

                $cached = cache()->remember($cacheKey, 60, function () use ($query, $initialBalance, $sessionFilter, $entryFilter) {
                    // Fetch collection only once for collection-based calculations
                    $trades = $query ? $query->get() : collect();

                    $basicMetrics = $this->analysisService->calculateBasicMetrics($trades, $initialBalance);

                    // TAMBAHKAN PERHITUNGAN EQUITY CHANGE PERCENTAGE DI SINI
                    $equity = $basicMetrics['equity'] ?? $initialBalance;
                    $balance = $basicMetrics['balance'] ?? $initialBalance;

                    // Hitung persentase perubahan equity dari balance
                    if ($initialBalance > 0) {
                        $equityChangePercentage = (($equity - $initialBalance) / $initialBalance) * 100;
                    } else {
                        $equityChangePercentage = 0;
                    }

                    // Hitung persentase perubahan equity dari balance saat ini
                    if ($balance > 0) {
                        $equityVsBalancePercentage = (($equity - $balance) / $balance) * 100;
                    } else {
                        $equityVsBalancePercentage = 0;
                    }

                    // Tambahkan ke basicMetrics
                    $basicMetrics['equity_change_percentage'] = round($equityChangePercentage, 2);
                    $basicMetrics['equity_vs_balance_percentage'] = round($equityVsBalancePercentage, 2);
                    $basicMetrics['initial_balance'] = $initialBalance; // Simpan untuk referensi

                    $summary = $this->analysisService->calculateSummary($trades, $entryFilter, $sessionFilter);
                    $availableSessions = $this->analysisService->getAvailableSessions();
                    $availableEntryTypes = $this->analysisService->getAvailableEntryTypes();
                    $equityData = $this->analysisService->calculateEquityData($trades, $initialBalance, $availableSessions);

                    // Use DB-backed aggregations where possible for speed
                    $pairData = $query ? $this->analysisService->calculatePairAnalysis($query) : collect();
                    $entryTypeData = $query ? $this->analysisService->calculateEntryTypeAnalysis($query) : collect();

                    return compact('basicMetrics', 'summary', 'availableSessions', 'availableEntryTypes', 'equityData', 'pairData', 'entryTypeData');
                });

                $basicMetrics = $cached['basicMetrics'] ?? $this->getDefaultMetrics($initialBalance);
                $summary = $cached['summary'] ?? [];
                $availableSessions = $cached['availableSessions'] ?? [];
                $availableEntryTypes = $cached['availableEntryTypes'] ?? [];
                $equityData = $cached['equityData'] ?? [];
                $pairData = $cached['pairData'] ?? collect();
                $entryTypeData = $cached['entryTypeData'] ?? collect();
            } catch (\Exception $e) {
                Log::error('Error calculating dashboard payload: ' . $e->getMessage());
                $basicMetrics = $this->getDefaultMetrics($initialBalance);
                $summary = [];
                $availableSessions = [];
                $availableEntryTypes = [];
                $equityData = [];
                $pairData = collect();
                $entryTypeData = collect();
            }

            $sessionNames = [
                'Asia' => __('dashboard.asia'),
                'London' => __('dashboard.london'),
                'New York' => __('dashboard.new_york'),
                'Sydney' => __('dashboard.sydney'),
                'Non-Session' => __('dashboard.non_session'),
                'Other' => __('dashboard.other'),
            ];

            // Combine all data
            return view('dashboard.index', array_merge($basicMetrics, [
                'period' => $period,
                'sessionFilter' => $sessionFilter,
                'entryFilter' => $entryFilter,
                'summary' => $summary,
                'availableSessions' => $availableSessions,
                'availableEntryTypes' => $availableEntryTypes,
                'equityData' => $equityData,
                'pairData' => $pairData,
                'entryTypeData' => $entryTypeData,
                'sessionNames' => $sessionNames,
            ]));
        } catch (\Exception $e) {
            Log::error('Critical error in dashboard: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return view('dashboard.index', $this->getDefaultDashboardData());
        }
    }

    /**
     * Get default metrics if calculation fails
     */
    private function getDefaultMetrics($initialBalance)
    {
        return [
            'balance' => $initialBalance,
            'equity' => $initialBalance,
            'equity_change_percentage' => 0, // TAMBAHKAN
            'equity_vs_balance_percentage' => 0, // TAMBAHKAN
            'initial_balance' => $initialBalance, // TAMBAHKAN
            'winrate' => 0,
            'totalProfit' => 0,
            'totalLoss' => 0,
            'netProfit' => 0,
            'averageWin' => 0,
            'averageLoss' => 0,
            'largestWin' => 0,
            'largestLoss' => 0,
            'averageRR' => 0,
            'profitFactor' => 0,
            'expectancy' => 0,
            'maxDrawdown' => 0,
            'maxDrawdownPercentage' => 0,
            'currentDrawdown' => 0,
            'totalTrades' => 0,
            'wins' => 0,
            'losses' => 0,
            'breakEvens' => 0,
            'consecutiveWins' => 0,
            'consecutiveLosses' => 0,
        ];
    }

    /**
     * Get default dashboard data if critical error occurs
     */
    private function getDefaultDashboardData()
    {
        return array_merge($this->getDefaultMetrics(10000), [
            'period' => 'all',
            'sessionFilter' => 'all',
            'entryFilter' => 'all',
            'summary' => [],
            'availableSessions' => [],
            'availableEntryTypes' => [],
            'equityData' => [],
            'pairData' => [],
            'entryTypeData' => [],
        ]);
    }
}
