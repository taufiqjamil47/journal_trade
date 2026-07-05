<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Services\CurrencyConverter;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/exchange-rate', function (Request $request) {
    try {
        $from = $request->get('from', 'USD');
        $to = $request->get('to', 'IDR');

        $converter = new CurrencyConverter();
        $rate = $converter->getRate($from, $to);

        return response()->json([
            'success' => true,
            'from' => $from,
            'to' => $to,
            'rate' => $rate,
            'lastUpdate' => $converter->getLastUpdate()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to fetch exchange rate',
            'error' => $e->getMessage()
        ], 500);
    }
});
