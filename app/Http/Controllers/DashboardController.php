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
        $account = Account::first();
        $initialBalance = $account->initial_balance;

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
            'availableEntryTypes' // TAMBAHKAN INI
        ));
    }
}
