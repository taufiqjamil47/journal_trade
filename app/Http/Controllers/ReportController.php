<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Trade;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    // === WEEKLY REPORT ===
    public function weeklyReportPdf()
    {
        $start = Carbon::now()->startOfWeek();
        $end   = Carbon::now()->endOfWeek();

        $trades = Trade::with('symbol')
            ->betweenDates($start, $end)
            ->get();

        $summary = [
            'total'   => $trades->count(),
            'wins'    => $trades->where('hasil', 'Win')->count(),
            'losses'  => $trades->where('hasil', 'Loss')->count(),
            'profit'  => $trades->sum('profit_loss'),
            'winrate' => $trades->count() ? round($trades->where('hasil', 'Win')->count() / $trades->count() * 100, 2) : 0,
        ];

        $pdf = Pdf::loadView('reports.weekly_pdf', compact('trades', 'summary', 'start', 'end'));
        return $pdf->download('weekly-report.pdf');
    }
}
