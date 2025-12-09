<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Services\TradeAnalysisService;

class DashboardController extends Controller
{
    protected $analysisService;

    public function __construct(TradeAnalysisService $analysisService)
    {
        $this->analysisService = $analysisService;
    }

    public function index(Request $request)
    {
        // Get account and initial balance
        $account = Account::first();
        $initialBalance = $account ? $account->initial_balance : 10000;

        // Get filtered trades
        $query = $this->analysisService->getFilteredTrades($request);
        $trades = $query->get();

        // Get filter values
        $period = $request->get('period', 'all');
        $sessionFilter = $request->get('session', 'all');
        $entryFilter = $request->get('entry_type', 'all');

        // Calculate basic metrics
        $basicMetrics = $this->analysisService->calculateBasicMetrics($trades, $initialBalance);

        // Calculate summary if filters active
        $summary = $this->analysisService->calculateSummary($trades, $entryFilter, $sessionFilter);

        // Get available filters
        $availableSessions = $this->analysisService->getAvailableSessions();
        $availableEntryTypes = $this->analysisService->getAvailableEntryTypes();

        // Calculate equity data
        $equityData = $this->analysisService->calculateEquityData(
            $trades,
            $initialBalance,
            $availableSessions
        );

        // Calculate pair and entry type data (simple version for dashboard)
        $pairData = $this->analysisService->calculatePairAnalysis($trades);
        $entryTypeData = $this->analysisService->calculateEntryTypeAnalysis($trades);

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
        ]));
    }
}
