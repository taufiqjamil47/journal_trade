<?php

use App\Models\DashNote;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SymbolController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\DashNoteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TradeReportController;
use App\Http\Controllers\TradingRuleController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {
    Route::resource('sessions', SessionController::class);
    Route::resource('trading-rules', TradingRuleController::class);
    Route::resource('symbols', SymbolController::class);
    Route::resource('notes', DashNoteController::class);

    // Semua route yang sudah ada
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/analysis', [AnalysisController::class, 'index'])->name('analysis.index');
    Route::get('/reports/calendar', [TradeReportController::class, 'calendar'])->name('reports.calendar');
    // ... route lainnya
    Route::get('/trades', [TradeController::class, 'index'])->name('trades.index');

    Route::post('/trades', [TradeController::class, 'store'])->name('trades.store');
    Route::get('/trades/create', [TradeController::class, 'create'])->name('trades.create');
    Route::post('/trades/import', [TradeController::class, 'importExcel'])->name('trades.import.excel');
    Route::get('/trades/export/excel', [TradeController::class, 'exportExcel'])->name('trades.export.excel');

    // PDF Generation Routes
    Route::get('/trades/generate-pdf', [TradeController::class, 'generatePdfReport'])->name('trades.generate.pdf');
    Route::get('/trades/preview-pdf', [TradeController::class, 'previewPdfReport'])->name('trades.preview.pdf');

    // Opsi: Route khusus untuk report per trade

    // Route::get('/trades/confirm-clear', [TradeController::class, 'confirmClear'])->name('trades.confirm-clear');
    Route::put('/trades/{id}', [TradeController::class, 'update'])->name('trades.update');
    Route::get('/trades/{id}', [TradeController::class, 'show'])->name('trades.show');
    Route::get('/trades/{id}/pdf', [TradeController::class, 'generateTradePdf'])->name('trades.single.pdf');
    Route::get('/trades/{id}/edit', [TradeController::class, 'edit'])->name('trades.edit');
    Route::get('/trades/{id}/detail', [TradeController::class, 'detail'])->name('trades.detail');
    Route::get('/trades/{id}/evaluate', [TradeController::class, 'evaluate'])->name('trades.evaluate');
    Route::post('/trades/{id}/delete', [TradeController::class, 'destroy'])->name('trades.destroy');
    Route::post('/trades/{id}/evaluate', [TradeController::class, 'saveEvaluation'])->name('trades.saveEvaluation');

    Route::delete('/trades/clear-all', [TradeController::class, 'clearAll'])->name('trades.clear-all');

    // Route::put('/trading-rules/{id}', [TradingRuleController::class, 'updateOrder'])
    //     ->name('trading-rules.update');
    Route::put('/trading-rules/{id}/order', [TradingRuleController::class, 'updateOrder'])
        ->name('trading-rules.update-order');
    Route::post('/trading-rules/reorder', [TradingRuleController::class, 'reorder'])
        ->name('trading-rules.reorder');

    Route::get('/reports/weekly', [ReportController::class, 'weeklyReport'])->name('reports.weekly');
    Route::get('/reports/weekly/pdf', [ReportController::class, 'weeklyReportPdf'])->name('reports.weekly.pdf');
});
