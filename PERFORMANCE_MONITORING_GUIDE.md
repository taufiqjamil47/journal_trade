# Performance Monitoring Guide

## Overview

The application now includes comprehensive performance monitoring to track:

-   **Response Times**: HTTP request duration in milliseconds
-   **Query Counts**: Number of database queries per operation
-   **Memory Usage**: Current and peak memory consumption
-   **N+1 Query Patterns**: Detection of inefficient database access patterns

## Components

### 1. PerformanceMonitorService

Located at `app/Services/PerformanceMonitorService.php`

**Purpose**: Track operation performance with checkpoints and detailed metrics

**Usage**:

```php
use App\Services\PerformanceMonitorService;

$perf = (new PerformanceMonitorService)->start('MyOperation');

// Perform work...
$perf->checkpoint('step_1_complete');

// More work...
$perf->checkpoint('step_2_complete');

// Get summary and log
$summary = $perf->end('Operation complete');
```

**Key Methods**:

-   `start(string $label)`: Initialize monitoring session
-   `checkpoint(string $name)`: Mark intermediate checkpoint
-   `getElapsedMs()`: Get elapsed time in milliseconds
-   `getQueryCount()`: Get number of queries executed
-   `getQueries()`: Get all executed query details
-   `end(string $message)`: Finalize and log summary
-   `analyzeNPlusOne()`: Detect N+1 query patterns
-   `reportFull()`: Generate complete performance report

### 2. PerformanceMonitoring Middleware

Located at `app/Http/Middleware/PerformanceMonitoring.php`

**Purpose**: Automatically monitor all HTTP requests

**Features**:

-   Tracks response time, query count, and memory usage for every request
-   Logs warnings for slow requests (> 500ms)
-   Logs warnings for high query counts (> 20 queries)
-   Attaches performance headers to responses:
    -   `X-Response-Time-Ms`: Total response time
    -   `X-Query-Count`: Number of database queries
    -   `X-Memory-Peak-Mb`: Peak memory usage

**Status**: Enabled globally in `app/Http/Kernel.php`

### 3. MonitorPerformance Console Command

Located at `app/Console/Commands/MonitorPerformance.php`

**Purpose**: Developer tool for analyzing operation performance

**Usage**:

```bash
# Test the monitoring service
php artisan monitor:performance test

# Monitor trades index operation (10 iterations)
php artisan monitor:performance trades-index --iterations=10

# Monitor trade creation (20 iterations)
php artisan monitor:performance trade-create --iterations=20

# Analyze database queries for N+1 patterns
php artisan monitor:performance query-analysis
```

## Performance Targets

### HTTP Requests

-   **Good**: < 200ms
-   **Acceptable**: 200-500ms
-   **Slow**: > 500ms ⚠️

### Database Queries

-   **Good**: < 5 queries per request
-   **Acceptable**: 5-20 queries per request
-   **High**: > 20 queries per request ⚠️

### Memory Usage

-   **Good**: < 10MB per request
-   **Acceptable**: 10-50MB per request
-   **High**: > 50MB per request ⚠️

## Monitoring in Controllers

The `TradeController` includes performance monitoring in key operations:

### 1. Index Action

```php
public function index(Request $request)
{
    $perf = (new PerformanceMonitorService)->start('TradeController::index');

    // ... operation code ...
    $perf->checkpoint('trades_fetched');
    // ... more code ...

    $perf->end('Trade index rendered');
}
```

### 2. Store Action

```php
public function store(Request $request)
{
    $perf = (new PerformanceMonitorService)->start('TradeController::store');

    $perf->checkpoint('validation_passed');
    // ... validation ...

    $perf->checkpoint('trade_saved');
    // ... saving ...

    $perf->end('Trade created successfully');
}
```

### 3. Import Action

```php
public function importExcel(Request $request)
{
    $perf = (new PerformanceMonitorService)->start('TradeController::importExcel');

    $perf->checkpoint('file_validated');
    // ... import ...

    $perf->end('Trade import completed successfully');
}
```

## Interpreting Logs

### Normal Log (info level)

```
[2025-12-11 10:30:45] local.INFO: Operation complete: Trade index rendered
{
  "label": "TradeController::index",
  "message": "Trade index rendered",
  "total_time_ms": 245.67,
  "total_queries": 2,
  "avg_query_time_ms": 122.84,
  "timestamp": "2025-12-11 10:30:45"
}
```

### Warning Log (slow operation)

```
[2025-12-11 10:35:20] local.WARNING: Slow HTTP request detected
{
  "method": "GET",
  "path": "/trades",
  "duration_ms": 1234.56,
  "query_count": 45,
  "memory_used_mb": 45.23,
  "peak_memory_mb": 78.45
}
```

### High Query Count Warning

```
[2025-12-11 10:40:15] local.WARNING: High query count detected
{
  "label": "TradeController::index",
  "query_count": 42,
  "duration_ms": 567.89,
  "queries": [
    {"query": "select * from ...", "time": 12.34},
    ...
  ]
}
```

## Optimization Recommendations

### When You See High Query Counts

1. **Check for N+1 patterns**: Use `analyzeNPlusOne()` to identify repeated queries
2. **Add eager loading**: Use `with()` to load relationships
3. **Select specific columns**: Use `select()` to minimize data transfer
4. **Add database indexes**: Create indexes on frequently queried columns

Example:

```php
// ❌ Bad: N+1 queries
$trades = Trade::all();
foreach ($trades as $trade) {
    echo $trade->symbol->name; // Query per iteration
}

// ✅ Good: Eager loading
$trades = Trade::with('symbol')->get();
foreach ($trades as $trade) {
    echo $trade->symbol->name; // No additional queries
}
```

### When You See Slow Response Times

1. **Add caching**: Cache expensive queries
2. **Optimize queries**: Check query execution plans
3. **Add database indexes**: Speed up query execution
4. **Break operations into jobs**: Use queues for long-running operations

Example:

```php
// Caching expensive data
$metrics = cache()->remember('dashboard_metrics', 3600, function () {
    return $this->calculateExpensiveMetrics();
});
```

### When You See High Memory Usage

1. **Use pagination**: Avoid loading all records at once
2. **Stream data**: Use generators for large datasets
3. **Process in batches**: Process large imports in chunks

Example:

```php
// ❌ Bad: Loads entire table into memory
$allTrades = Trade::all();

// ✅ Good: Paginate data
$trades = Trade::paginate(100);

// ✅ Good: Chunk for large operations
Trade::chunk(1000, function ($trades) {
    // Process $trades
});
```

## Best Practices

1. **Always use eager loading** for relationships
2. **Select specific columns** when you don't need all fields
3. **Aim for < 5 queries per request**
4. **Aim for < 500ms response time**
5. **Monitor imports and exports** - these are typically slow
6. **Use transactions** for multi-step operations
7. **Cache frequently accessed data**
8. **Index database columns** that are used in WHERE clauses

## Disabling Monitoring

To disable performance monitoring middleware globally:

-   Comment out the line in `app/Http/Kernel.php`:

```php
// \App\Http\Middleware\PerformanceMonitoring::class,
```

To disable for specific routes:

```php
Route::middleware('except:performance-monitoring')->group(function () {
    // Routes here won't be monitored
});
```

## Future Enhancements

-   [ ] Add real-time performance dashboard
-   [ ] Store performance metrics in database for historical analysis
-   [ ] Add automated alerts for performance degradation
-   [ ] Create performance comparison reports
-   [ ] Add route-specific performance thresholds
-   [ ] Implement distributed tracing for multi-service architectures

## Related Documentation

-   [Error Handling Guide](./ERROR_HANDLING_GUIDE.md)
-   [N+1 Query Fixes](./N1_QUERY_FIXES.md)
-   [Implementation Report](./IMPLEMENTATION_REPORT.md)
