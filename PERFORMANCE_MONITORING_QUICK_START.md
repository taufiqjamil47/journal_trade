# Performance Monitoring - Quick Reference

## What Was Implemented

### ✅ Core Components

1. **PerformanceMonitorService** (`app/Services/PerformanceMonitorService.php`)

    - Tracks operation timing, query counts, memory usage
    - Supports checkpoints for tracking operation phases
    - Detects N+1 query patterns
    - Logs detailed performance summaries

2. **PerformanceMonitoring Middleware** (`app/Http/Middleware/PerformanceMonitoring.php`)

    - Automatically monitors all HTTP requests
    - Tracks response time, queries, memory
    - Warns on slow requests (> 500ms)
    - Warns on high query counts (> 20)
    - Adds performance headers to responses

3. **MonitorPerformance Console Command** (`app/Console/Commands/MonitorPerformance.php`)

    - Developer tool for testing and analysis
    - Multiple monitoring profiles available
    - Generates detailed reports

4. **Controller Integration**
    - `TradeController` methods now include performance monitoring
    - Key operations: `index()`, `store()`, `importExcel()`, `exportExcel()`

## Quick Start

### Test Performance Monitoring

```bash
php artisan monitor:performance test
```

### Monitor Specific Operations

```bash
php artisan monitor:performance trades-index --iterations=10
php artisan monitor:performance trade-create --iterations=20
php artisan monitor:performance query-analysis
```

### View Performance in Logs

```bash
tail -f storage/logs/laravel.log | grep -i performance
```

### Check Response Headers

Open browser DevTools → Network tab → Response Headers:

-   `X-Response-Time-Ms`: Response time in milliseconds
-   `X-Query-Count`: Number of database queries
-   `X-Memory-Peak-Mb`: Peak memory usage

## Files Modified/Created

### Created (4 files)

-   `app/Services/PerformanceMonitorService.php` - Core monitoring service
-   `app/Http/Middleware/PerformanceMonitoring.php` - Request monitoring middleware
-   `app/Console/Commands/MonitorPerformance.php` - Console testing tool
-   `PERFORMANCE_MONITORING_GUIDE.md` - Complete guide
-   `PERFORMANCE_MONITORING_REPORT.md` - Implementation report

### Modified (2 files)

-   `app/Http/Kernel.php` - Registered middleware
-   `app/Http/Controllers/TradeController.php` - Added monitoring to key methods

## Performance Targets

| Metric        | Target  | Warning    |
| ------------- | ------- | ---------- |
| Response Time | < 200ms | > 500ms ⚠️ |
| Query Count   | < 5     | > 20 ⚠️    |
| Memory Usage  | < 10MB  | > 50MB ⚠️  |

## Example Log Output

```json
{
    "label": "TradeController::index",
    "message": "Trade index rendered",
    "total_time_ms": 245.67,
    "total_queries": 2,
    "avg_query_time_ms": 122.84,
    "checkpoints": {
        "eager_load_initialized": { "elapsed_ms": 5.23, "query_count": 0 },
        "trades_fetched": { "elapsed_ms": 125.45, "query_count": 1 },
        "winrate_calculated": { "elapsed_ms": 245.67, "query_count": 2 }
    }
}
```

## Using in Your Code

```php
use App\Services\PerformanceMonitorService;

// Start monitoring
$perf = (new PerformanceMonitorService)->start('MyOperation');

// Mark progress
$perf->checkpoint('phase_1_complete');

// Do work...

$perf->checkpoint('phase_2_complete');

// Finish and log
$summary = $perf->end('Operation complete');

// Get data
echo "Response time: " . $summary['total_time_ms'] . "ms";
echo "Queries executed: " . $summary['total_queries'];
```

## Monitoring Dashboard (Browser DevTools)

Open any page in your application and check Network tab:

1. Click on any request
2. Go to Response Headers tab
3. Look for headers starting with `X-`:
    - `X-Response-Time-Ms`
    - `X-Query-Count`
    - `X-Memory-Peak-Mb`

## Syntax Validation

✅ All PHP files validated

```
✓ PerformanceMonitorService.php - No syntax errors
✓ PerformanceMonitoring.php - No syntax errors
✓ MonitorPerformance.php - No syntax errors
✓ Kernel.php - No syntax errors
✓ TradeController.php - No syntax errors
```

## Next Steps

1. Run the console command to verify:

    ```bash
    php artisan monitor:performance test
    ```

2. Check application logs for performance data:

    ```bash
    tail -f storage/logs/laravel.log
    ```

3. Monitor your HTTP requests in the browser:

    - Check DevTools → Network → Response Headers
    - Look for X-Response-Time-Ms, X-Query-Count, X-Memory-Peak-Mb

4. Use the console command to analyze specific operations:
    ```bash
    php artisan monitor:performance query-analysis
    ```

## Documentation

-   See `PERFORMANCE_MONITORING_GUIDE.md` for comprehensive guide
-   See `PERFORMANCE_MONITORING_REPORT.md` for detailed implementation report
-   Related: `ERROR_HANDLING_GUIDE.md`, `N1_QUERY_FIXES.md`

---

**Status**: ✅ Complete and validated  
**All files pass PHP syntax checks**
