<?php

namespace App\Http\Controllers;

use DatePeriod;
use DateInterval;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TradeReportController extends Controller
{
    public function calendar(Request $request)
    {
        $month = $request->input('month', \Carbon\Carbon::now()->month);
        $year = $request->input('year', \Carbon\Carbon::now()->year);

        // DAILY
        $daily = DB::table('trades')
            ->selectRaw('date, SUM(profit_loss) as total_profit, COUNT(*) as total_trades')
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        // TRADES DETAIL
        $trades = DB::table('trades')
            ->join('symbols', 'symbols.id', '=', 'trades.symbol_id')
            ->select(
                'trades.*',
                'symbols.name as symbol_name'
            )
            ->whereYear('trades.date', $year)
            ->whereMonth('trades.date', $month)
            ->orderBy('trades.date')
            ->get()
            ->groupBy('date');


        // WEEKLY SUMMARY
        $weekly = DB::table('trades')
            ->selectRaw('YEAR(date) as year, WEEK(date, 1) as week, SUM(profit_loss) as total_profit, COUNT(*) as total_trades')
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->groupBy('year', 'week')
            ->orderBy('week')
            ->get();

        // MONTHLY SUMMARY
        $monthly = DB::table('trades')
            ->selectRaw('YEAR(date) as year, MONTH(date) as month, SUM(profit_loss) as total_profit, COUNT(*) as total_trades')
            ->whereYear('date', $year)
            ->groupBy('year', 'month')
            ->orderBy('month')
            ->get();

        $start = Carbon::create($year, $month, 1)->startOfWeek(Carbon::SUNDAY);
        $end   = Carbon::create($year, $month, 1)->endOfMonth()->endOfWeek(Carbon::SATURDAY);
        $period = CarbonPeriod::create($start, $end);

        return view('reports.calendar', compact('period', 'daily', 'trades', 'weekly', 'monthly', 'month', 'year'));
    }
}
