<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PerformanceMonitorService
{
    protected $startTime;
    protected $queryCount;
    protected $initialQueries;
    protected $metrics = [];
    private $label;

    /**
     * Initialize performance monitoring session
     */
    public function start(string $label = 'Operation'): self
    {
        $this->label = $label;
        $this->startTime = microtime(true);

        // Enable query logging to count queries
        DB::enableQueryLog();

        // Get initial query count
        $this->initialQueries = count(DB::getQueryLog());

        return $this;
    }

    /**
     * Mark a checkpoint and log intermediate metrics
     */
    public function checkpoint(string $name): self
    {
        $elapsed = $this->getElapsedMs();
        $queryCount = $this->getQueryCount();

        $this->metrics[$name] = [
            'elapsed_ms' => $elapsed,
            'query_count' => $queryCount,
            'timestamp' => now()->toDateTimeString()
        ];

        Log::info("Checkpoint: {$name}", [
            'elapsed_ms' => $elapsed,
            'query_count' => $queryCount,
            'label' => $this->label ?? 'Unmarked'
        ]);

        return $this;
    }

    /**
     * Get elapsed time in milliseconds
     */
    public function getElapsedMs(): float
    {
        return round((microtime(true) - $this->startTime) * 1000, 2);
    }

    /**
     * Get number of queries executed
     */
    public function getQueryCount(): int
    {
        return count(DB::getQueryLog()) - $this->initialQueries;
    }

    /**
     * Get all executed queries
     */
    public function getQueries(): array
    {
        return array_slice(DB::getQueryLog(), $this->initialQueries);
    }

    /**
     * End monitoring and log summary
     */
    public function end(string $message = 'Operation completed'): array
    {
        $totalTime = $this->getElapsedMs();
        $totalQueries = $this->getQueryCount();

        $summary = [
            'label' => $this->label ?? 'Unmarked',
            'message' => $message,
            'total_time_ms' => $totalTime,
            'total_queries' => $totalQueries,
            'avg_query_time_ms' => $totalQueries > 0 ? round($totalTime / $totalQueries, 2) : 0,
            'checkpoints' => $this->metrics,
            'timestamp' => now()->toDateTimeString()
        ];

        // Warn if slow operation detected (> 500ms)
        $level = $totalTime > 500 ? 'warning' : 'info';
        Log::$level("Operation complete: {$message}", $summary);

        // Warn if many queries detected (> 20)
        if ($totalQueries > 20) {
            Log::warning("High query count detected", [
                'label' => $this->label,
                'query_count' => $totalQueries,
                'queries' => $this->getQueries()
            ]);
        }

        DB::disableQueryLog();

        return $summary;
    }

    /**
     * Get memory usage
     */
    public function getMemoryUsageMb(): float
    {
        return round(memory_get_usage(true) / 1024 / 1024, 2);
    }

    /**
     * Get peak memory usage
     */
    public function getPeakMemoryMb(): float
    {
        return round(memory_get_peak_usage(true) / 1024 / 1024, 2);
    }

    /**
     * Log complete performance report
     */
    public function reportFull(): array
    {
        $report = [
            'label' => $this->label ?? 'Unmarked',
            'total_time_ms' => $this->getElapsedMs(),
            'total_queries' => $this->getQueryCount(),
            'memory_usage_mb' => $this->getMemoryUsageMb(),
            'peak_memory_mb' => $this->getPeakMemoryMb(),
            'avg_query_time_ms' => $this->getQueryCount() > 0
                ? round($this->getElapsedMs() / $this->getQueryCount(), 2)
                : 0,
            'checkpoints' => $this->metrics,
            'timestamp' => now()->toDateTimeString()
        ];

        Log::info('Full Performance Report', $report);

        return $report;
    }

    /**
     * Analyze N+1 query patterns
     */
    public function analyzeNPlusOne(): array
    {
        $queries = $this->getQueries();
        $analysis = [
            'total_queries' => count($queries),
            'potential_n_plus_one' => [],
            'similar_queries' => []
        ];

        // Group similar queries
        $queryGroups = [];
        foreach ($queries as $query) {
            // Remove parameters for similarity check
            $normalizedQuery = preg_replace('/\?/', '?', $query['query']);
            $normalizedQuery = preg_replace('/\d+/', '?', $normalizedQuery);

            if (!isset($queryGroups[$normalizedQuery])) {
                $queryGroups[$normalizedQuery] = 0;
            }
            $queryGroups[$normalizedQuery]++;
        }

        // Flag potential N+1 patterns (same query > 2 times)
        foreach ($queryGroups as $query => $count) {
            if ($count > 2) {
                $analysis['potential_n_plus_one'][] = [
                    'query_pattern' => $query,
                    'count' => $count,
                    'risk' => 'High'
                ];
            }
        }

        Log::warning('Potential N+1 Patterns Detected', $analysis);

        return $analysis;
    }
}
