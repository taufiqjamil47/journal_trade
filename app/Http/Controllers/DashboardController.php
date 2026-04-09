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
            // Dapatkan akun terpilih dari sesi
            $selectedAccountId = session('selected_account_id');
            $account = Account::find($selectedAccountId);
            if (!$account) {
                Log::warning('Selected account not found in dashboard');
                $initialBalance = 10000;
            } else {
                $initialBalance = $account->initial_balance;
            }

            // Dapatkan kueri perdagangan yang difilter (jangan ambil dulu) agar kita dapat menggunakan agregasi basis data
            try {
                $query = $this->analysisService->getFilteredTrades($request, true);
                // Tambahkan eager loading untuk kasus di mana koleksi digunakan
                $query = $query->with('symbol', 'account', 'tradingRules');
            } catch (\Exception $e) {
                Log::error('Error building filtered trades query: ' . $e->getMessage());
                $query = null;
            }

            // Dapatkan nilai filter
            $period = $request->get('period', 'all');
            $sessionFilter = $request->get('session', 'all');
            $entryFilter = $request->get('entry_type', 'all');

            // Gunakan caching untuk payload dashboard untuk mengurangi perhitungan berat yang berulang
            try {
                $period = $request->get('period', 'all');
                $sessionFilter = $request->get('session', 'all');
                $entryFilter = $request->get('entry_type', 'all');

                // Gunakan timestamp pembaruan perdagangan terakhir untuk membatalkan cache ketika perdagangan berubah
                $tradesMaxUpdated = \App\Models\Trade::max('updated_at') ?: now()->toDateTimeString();
                $cacheKey = "dashboard:period={$period}:session={$sessionFilter}:entry={$entryFilter}:account={$account->id}:tmax={$tradesMaxUpdated}";

                $cached = cache()->remember($cacheKey, 60, function () use ($query, $initialBalance, $sessionFilter, $entryFilter) {
                    // Ambil koleksi hanya sekali untuk perhitungan berbasis koleksi.
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

                    // Gunakan agregasi berbasis basis data jika memungkinkan untuk kecepatan
                    $pairData = $query ? $this->analysisService->calculatePairAnalysis($query) : collect();
                    $entryTypeData = $query ? $this->analysisService->calculateEntryTypeAnalysis($query) : collect();

                    // Hitung data ekuitas keseluruhan untuk grafik baru
                    $overallEquityData = $this->analysisService->calculateOverallEquityData($trades, $initialBalance);

                    return compact('basicMetrics', 'summary', 'availableSessions', 'availableEntryTypes', 'equityData', 'pairData', 'entryTypeData', 'overallEquityData');
                });

                $basicMetrics = $cached['basicMetrics'] ?? $this->getDefaultMetrics($initialBalance);
                $summary = $cached['summary'] ?? [];
                $availableSessions = $cached['availableSessions'] ?? [];
                $availableEntryTypes = $cached['availableEntryTypes'] ?? [];
                $equityData = $cached['equityData'] ?? [];
                $pairData = $cached['pairData'] ?? collect();
                $entryTypeData = $cached['entryTypeData'] ?? collect();
                $overallEquityData = $cached['overallEquityData'] ?? [];
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

            // Gabungkan semua data
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
                'overallEquityData' => $overallEquityData,
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
     * Gunakan metrik default jika perhitungan gagal.
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
     * Dapatkan data dasbor default jika terjadi kesalahan kritis.
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
            'overallEquityData' => [],
        ]);
    }
}
