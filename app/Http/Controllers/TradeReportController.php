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
        // Use Indonesia timezone (Asia/Jakarta)
        $now = Carbon::now('Asia/Jakarta');
        $month = $request->input('month', $now->month);
        $year = $request->input('year', $now->year);

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

        // Kirim translation data ke view
        $monthNames = [
            1 => __('month_names.january'),
            2 => __('month_names.february'),
            3 => __('month_names.march'),
            4 => __('month_names.april'),
            5 => __('month_names.may'),
            6 => __('month_names.june'),
            7 => __('month_names.july'),
            8 => __('month_names.august'),
            9 => __('month_names.september'),
            10 => __('month_names.october'),
            11 => __('month_names.november'),
            12 => __('month_names.december'),
        ];

        $shortMonthNames = [
            1 => __('month_names.jan'),
            2 => __('month_names.feb'),
            3 => __('month_names.mar'),
            4 => __('month_names.apr'),
            5 => __('month_names.may_short'),
            6 => __('month_names.jun'),
            7 => __('month_names.jul'),
            8 => __('month_names.aug'),
            9 => __('month_names.sep'),
            10 => __('month_names.oct'),
            11 => __('month_names.nov'),
            12 => __('month_names.dec'),
        ];

        // return view('reports.calendar', compact('period', 'daily', 'trades', 'weekly', 'monthly', 'month', 'year'));
        return view('reports.calendar', [
            'period' => $period,
            'daily' => $daily,
            'trades' => $trades,
            'weekly' => $weekly,
            'monthly' => $monthly,
            'month' => $month,
            'year' => $year,
            'monthNames' => $monthNames,
            'shortMonthNames' => $shortMonthNames
        ]);
    }
}
