<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class PerformanceMonitoring
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Start monitoring
        $startTime = microtime(true);
        DB::enableQueryLog();
        $initialQueries = count(DB::getQueryLog());
        $initialMemory = memory_get_usage(true);

        // Process request
        $response = $next($request);

        // Calculate metrics
        $duration = (microtime(true) - $startTime) * 1000; // milliseconds
        $queryCount = count(DB::getQueryLog()) - $initialQueries;
        $memoryUsed = (memory_get_usage(true) - $initialMemory) / 1024 / 1024; // MB
        $peakMemory = memory_get_peak_usage(true) / 1024 / 1024; // MB

        // Log slow requests (> 500ms)
        if ($duration > 500) {
            Log::warning('Slow HTTP request detected', [
                'method' => $request->getMethod(),
                'path' => $request->getPathInfo(),
                'duration_ms' => round($duration, 2),
                'query_count' => $queryCount,
                'memory_used_mb' => round($memoryUsed, 2),
                'peak_memory_mb' => round($peakMemory, 2),
                'status_code' => $response->getStatusCode()
            ]);
        }

        // Log requests with many queries (> 20)
        if ($queryCount > 20) {
            Log::warning('High query count on HTTP request', [
                'method' => $request->getMethod(),
                'path' => $request->getPathInfo(),
                'query_count' => $queryCount,
                'duration_ms' => round($duration, 2)
            ]);
        }

        // Attach performance headers
        $response->header('X-Response-Time-Ms', round($duration, 2));
        $response->header('X-Query-Count', $queryCount);
        $response->header('X-Memory-Peak-Mb', round($peakMemory, 2));

        // Standard info log for all requests (if APP_DEBUG)
        if (config('app.debug')) {
            Log::debug('HTTP Request Performance', [
                'method' => $request->getMethod(),
                'path' => $request->getPathInfo(),
                'duration_ms' => round($duration, 2),
                'query_count' => $queryCount,
                'status_code' => $response->getStatusCode()
            ]);
        }

        DB::disableQueryLog();

        return $response;
    }
}
