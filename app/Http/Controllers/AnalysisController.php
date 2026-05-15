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

        // Dapatkan transaksi yang difilter sebagai query builder
        $query = $this->analysisService->getFilteredTrades($request, false);

        // Dapatkan nilai filter
        $period = $request->get('period', 'all');
        $sessionFilter = $request->get('session', 'all');
        $entryFilter = $request->get('entry_type', 'all');

        // Dapatkan filter yang tersedia
        $availableSessions = $this->analysisService->getAvailableSessions();
        $availableEntryTypes = $this->analysisService->getAvailableEntryTypes();

        // ===== PERFORMANCE ANALYSIS =====
        $pairData = $this->analysisService->calculatePairAnalysis($query);
        $entryTypeData = $this->analysisService->calculateEntryTypeAnalysis($query);
        $sessionAnalysis = $this->analysisService->calculateSessionAnalysis($query);

        // ===== TIME ANALYSIS =====
        $timeAnalysis = $this->analysisService->calculateTimeAnalysis($query);

        // Hitung ringkasan jika filter aktif
        $summary = $this->analysisService->calculateSummary($query, $entryFilter, $sessionFilter);

        // Hanya ambil kolom yang diperlukan untuk metrik lanjutan agar lebih ringan
        $tradeColumns = [
            'date',
            'timestamp',
            'exit_timestamp',
            'profit_loss',
            'hasil',
            'rr',
            'entry_type',
            'session',
            'lot_size',
            'risk_percent',
        ];
        $trades = (clone $query)->get($tradeColumns);

        // ===== ADVANCED RISK METRICS =====
        $riskMetrics = $this->analysisService->calculateAdvancedRiskMetrics($trades, $initialBalance);

        // ===== BASIC METRICS FOR CONTEXT =====
        $basicMetrics = $this->analysisService->calculateBasicMetrics($trades, $initialBalance);

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

    public function chartData(Request $request)
    {
        $query = $this->analysisService->getFilteredTrades($request, false);

        $timeAnalysis = $this->analysisService->calculateTimeAnalysis($query);
        $pairData = $this->analysisService->calculatePairAnalysis($query);
        $entryTypeData = $this->analysisService->calculateEntryTypeAnalysis($query);
        $sessionAnalysis = $this->analysisService->calculateSessionAnalysis($query);

        return response()->json(array_merge(
            $timeAnalysis,
            [
                'pairData' => $pairData,
                'entryTypeData' => $entryTypeData,
                'sessionAnalysis' => $sessionAnalysis,
            ]
        ));
    }
}
