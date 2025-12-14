<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SymbolController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TradingRuleController;

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

Route::resource('sessions', SessionController::class);
Route::resource('trading-rules', TradingRuleController::class);
Route::resource('symbols', SymbolController::class);

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/analysis', [AnalysisController::class, 'index'])->name('analysis.index');

Route::get('/trades', [TradeController::class, 'index'])->name('trades.index');
Route::get('/trades/create', [TradeController::class, 'create'])->name('trades.create');
Route::post('/trades', [TradeController::class, 'store'])->name('trades.store');
Route::get('/trades/{id}/edit', [TradeController::class, 'edit'])->name('trades.edit');
Route::put('/trades/{id}', [TradeController::class, 'update'])->name('trades.update');
Route::get('/trades/{id}', [TradeController::class, 'show'])->name('trades.show');
Route::get('/trades/{id}/detail', [TradeController::class, 'detail'])->name('trades.detail');
Route::get('/trades/{id}/evaluate', [TradeController::class, 'evaluate'])->name('trades.evaluate');
Route::post('/trades/{id}/evaluate', [TradeController::class, 'saveEvaluation'])->name('trades.saveEvaluation');


// Route::put('/trading-rules/{id}', [TradingRuleController::class, 'updateOrder'])
//     ->name('trading-rules.update');
Route::put('/trading-rules/{id}/order', [TradingRuleController::class, 'updateOrder'])
    ->name('trading-rules.update-order');
Route::post('/trading-rules/reorder', [TradingRuleController::class, 'reorder'])
    ->name('trading-rules.reorder');

Route::get('/trades/export/excel', [TradeController::class, 'exportExcel'])->name('trades.export.excel');
Route::post('/trades/import', [TradeController::class, 'importExcel'])->name('trades.import.excel');

// Route::get('/trades/confirm-clear', [TradeController::class, 'confirmClear'])->name('trades.confirm-clear');
Route::delete('/trades/clear-all', [TradeController::class, 'clearAll'])->name('trades.clear-all');

Route::get('/reports/weekly', [ReportController::class, 'weeklyReport'])->name('reports.weekly');
Route::get('/reports/weekly/pdf', [ReportController::class, 'weeklyReportPdf'])->name('reports.weekly.pdf');

Route::get('/reports/calendar', [App\Http\Controllers\TradeReportController::class, 'calendar'])->name('reports.calendar');
