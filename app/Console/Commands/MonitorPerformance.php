<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\PerformanceMonitorService;

class MonitorPerformance extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'monitor:performance {operation=test} {--iterations=10}';

    /**
     * The console command description.
     */
    protected $description = 'Monitor performance of key operations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $operation = $this->argument('operation');
        $iterations = $this->option('iterations');

        $this->info("Starting performance monitoring for operation: {$operation}");
        $this->info("Iterations: {$iterations}\n");

        switch ($operation) {
            case 'trades-index':
                $this->monitorTradesIndex($iterations);
                break;
            case 'trade-create':
                $this->monitorTradeCreate($iterations);
                break;
            case 'query-analysis':
                $this->analyzeQueries();
                break;
            case 'test':
            default:
                $this->testMonitoring();
                break;
        }
    }

    /**
     * Monitor trades index operation
     */
    private function monitorTradesIndex(int $iterations)
    {
        $results = [];

        for ($i = 0; $i < $iterations; $i++) {
            $perf = (new PerformanceMonitorService)->start("TradesIndex_Iteration_{$i}");

            DB::enableQueryLog();

            // Simulate index operation
            $trades = \App\Models\Trade::with('symbol', 'tradingRules')->paginate(10);
            $perf->checkpoint('trades_fetched');

            $allTrades = \App\Models\Trade::select('id', 'hasil')->get();
            $winrate = $allTrades->where('hasil', 'win')->count() / $allTrades->count() * 100;
            $perf->checkpoint('winrate_calculated');

            $summary = $perf->end("Iteration {$i} completed");
            $results[$i] = $summary;
        }

        // Calculate averages
        $avgTime = array_sum(array_column($results, 'total_time_ms')) / count($results);
        $avgQueries = array_sum(array_column($results, 'total_queries')) / count($results);

        $this->info("\n=== RESULTS ===");
        $this->table(
            ['Metric', 'Value'],
            [
                ['Average Response Time (ms)', round($avgTime, 2)],
                ['Average Query Count', round($avgQueries)],
                ['Min Response Time (ms)', min(array_column($results, 'total_time_ms'))],
                ['Max Response Time (ms)', max(array_column($results, 'total_time_ms'))],
            ]
        );

        Log::info('Trades Index Performance Summary', [
            'iterations' => $iterations,
            'avg_time_ms' => round($avgTime, 2),
            'avg_queries' => round($avgQueries),
            'results' => $results
        ]);
    }

    /**
     * Monitor trade create operation
     */
    private function monitorTradeCreate(int $iterations)
    {
        $results = [];
        $symbol = \App\Models\Symbol::where('active', true)->first();

        if (!$symbol) {
            $this->error('No active symbols found. Please create a symbol first.');
            return;
        }

        for ($i = 0; $i < $iterations; $i++) {
            $perf = (new PerformanceMonitorService)->start("TradeCreate_Iteration_{$i}");

            try {
                $data = [
                    'symbol_id' => $symbol->id,
                    'timestamp' => now(),
                    'date' => now(),
                    'type' => 'buy',
                    'entry' => 1.1000,
                    'stop_loss' => 1.0900,
                    'take_profit' => 1.1100,
                    'account_id' => 1,
                ];

                DB::transaction(function () use ($data, $perf) {
                    $trade = \App\Models\Trade::create($data);
                    $perf->checkpoint('trade_created');
                });

                $summary = $perf->end("Iteration {$i} completed");
                $results[$i] = $summary;
            } catch (\Exception $e) {
                $this->error("Iteration {$i} failed: " . $e->getMessage());
            }
        }

        if (empty($results)) {
            $this->error('No successful iterations completed.');
            return;
        }

        // Calculate averages
        $avgTime = array_sum(array_column($results, 'total_time_ms')) / count($results);
        $avgQueries = array_sum(array_column($results, 'total_queries')) / count($results);

        $this->info("\n=== RESULTS ===");
        $this->table(
            ['Metric', 'Value'],
            [
                ['Average Response Time (ms)', round($avgTime, 2)],
                ['Average Query Count', round($avgQueries)],
                ['Min Response Time (ms)', min(array_column($results, 'total_time_ms'))],
                ['Max Response Time (ms)', max(array_column($results, 'total_time_ms'))],
            ]
        );

        Log::info('Trade Create Performance Summary', [
            'iterations' => $iterations,
            'avg_time_ms' => round($avgTime, 2),
            'avg_queries' => round($avgQueries),
            'results' => $results
        ]);
    }

    /**
     * Analyze database queries
     */
    private function analyzeQueries()
    {
        $this->info("Analyzing database queries...\n");

        $perf = (new PerformanceMonitorService)->start('QueryAnalysis');

        DB::enableQueryLog();

        // Fetch various data
        $trades = \App\Models\Trade::with('symbol', 'tradingRules')->limit(20)->get();
        $perf->checkpoint('trades_fetched');

        $symbols = \App\Models\Symbol::all();
        $perf->checkpoint('symbols_fetched');

        $rules = \App\Models\TradingRule::all();
        $perf->checkpoint('rules_fetched');

        $analysis = $perf->analyzeNPlusOne();
        $perf->end('Query analysis complete');

        $this->info("=== N+1 ANALYSIS ===");
        $this->table(
            ['Query Pattern', 'Count', 'Risk Level'],
            array_map(
                fn($item) => [$item['query_pattern'], $item['count'], $item['risk']],
                $analysis['potential_n_plus_one']
            )
        );

        $this->info("\nTotal Queries: {$analysis['total_queries']}");
    }

    /**
     * Test monitoring service
     */
    private function testMonitoring()
    {
        $this->info("Testing PerformanceMonitorService...\n");

        $perf = (new PerformanceMonitorService)->start('Test Operation');

        // Simulate work
        sleep(0.1);
        $perf->checkpoint('checkpoint_1');

        sleep(0.1);
        $perf->checkpoint('checkpoint_2');

        $summary = $perf->end('Test complete');

        $this->info("✓ Elapsed Time: {$summary['total_time_ms']}ms");
        $this->info("✓ Query Count: {$summary['total_queries']}");
        $this->info("✓ Memory Usage: {$perf->getMemoryUsageMb()}MB");
        $this->info("✓ Peak Memory: {$perf->getPeakMemoryMb()}MB");

        $this->newLine();
        $this->info('Performance monitoring test passed!');
    }
}
