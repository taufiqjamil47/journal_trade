<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Services\TradeAnalysisService;

class AnalysisController extends Controller
{
    protected $analysisService;

    public function __construct(TradeAnalysisService $analysisService)
    {
        $this->analysisService = $analysisService;
    }

    public function index(Request $request)
    {
        // Dapatkan akun terpilih dari sesi
        $selectedAccountId = session('selected_account_id');
        $account = Account::find($selectedAccountId);
        $initialBalance = $account ? $account->initial_balance : 10000;

        // Dapatkan transaksi yang difilter
        $query = $this->analysisService->getFilteredTrades($request);
        $trades = $query->get();

        // Dapatkan nilai filter
        $period = $request->get('period', 'all');
        $sessionFilter = $request->get('session', 'all');
        $entryFilter = $request->get('entry_type', 'all');

        // Dapatkan filter yang tersedia
        $availableSessions = $this->analysisService->getAvailableSessions();
        $availableEntryTypes = $this->analysisService->getAvailableEntryTypes();

        // ===== TIME ANALYSIS =====
        $timeAnalysis = $this->analysisService->calculateTimeAnalysis($trades);

        // ===== ADVANCED RISK METRICS =====
        $riskMetrics = $this->analysisService->calculateAdvancedRiskMetrics($trades, $initialBalance);

        // ===== PERFORMANCE ANALYSIS =====
        $pairData = $this->analysisService->calculatePairAnalysis($trades); // Ganti nama variabel
        $entryTypeData = $this->analysisService->calculateEntryTypeAnalysis($trades); // Ganti nama variabel
        $sessionAnalysis = $this->analysisService->calculateSessionAnalysis($trades);

        // ===== BASIC METRICS FOR CONTEXT =====
        $basicMetrics = $this->analysisService->calculateBasicMetrics($trades, $initialBalance);

        // Hitung ringkasan jika filter aktif
        $summary = $this->analysisService->calculateSummary($trades, $entryFilter, $sessionFilter);

        // Gabungkan semua data
        return view('analysis.index', array_merge(
            [
                'period' => $period,
                'sessionFilter' => $sessionFilter,
                'entryFilter' => $entryFilter,
                'summary' => $summary,
                'availableSessions' => $availableSessions,
                'availableEntryTypes' => $availableEntryTypes,
            ],
            $basicMetrics, // Sertakan metrik dasar untuk konteks.
            $timeAnalysis,
            $riskMetrics,
            [
                'pairData' => $pairData, // Ubah jadi pairData
                'entryTypeData' => $entryTypeData, // Ubah jadi entryTypeData
                'sessionAnalysis' => $sessionAnalysis,
            ]
        ));
    }
}
