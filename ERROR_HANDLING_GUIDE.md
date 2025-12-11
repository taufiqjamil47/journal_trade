# Error Handling Quick Reference

## Using Custom Exceptions

### TradeException

```php
use App\Exceptions\TradeException;

throw new TradeException('Insufficient balance for this trade');
```

### ValidationException

```php
use App\Exceptions\ValidationException;

throw new ValidationException('Validation failed', [
    'field_name' => ['error message']
]);
```

### DataNotFoundException

```php
use App\Exceptions\DataNotFoundException;

throw new DataNotFoundException('Trade', $tradeId);
// Output: "Trade dengan ID {id} tidak ditemukan"
```

### ImportException

```php
use App\Exceptions\ImportException;

throw new ImportException('Invalid symbol in row', 5, [
    'column' => 'symbol',
    'value' => 'INVALID'
]);
```

## Error Handling Pattern

Semua controllers sudah mengikuti pattern ini:

```php
public function store(Request $request)
{
    try {
        // 1. Validate input
        $validated = $request->validate([
            'field' => 'required|rule'
        ]);

        // 2. Business logic
        $model = Model::create($validated);

        // 3. Log success
        Log::info('Action successful', ['id' => $model->id]);

        // 4. Return success response
        return redirect()->route('index')->with('success', 'Berhasil dibuat');

    } catch (ValidationException $e) {
        // Handle validation errors
        Log::warning('Validation error', ['errors' => $e->errors()]);
        return back()->withInput()->withErrors($e->errors());

    } catch (\Exception $e) {
        // Handle all other errors
        Log::error('Unexpected error: ' . $e->getMessage());
        return back()->withInput()->with('error', 'Gagal: ' . $e->getMessage());
    }
}
```

## Viewing Logs

```bash
# Real-time log tail (Linux/Mac)
tail -f storage/logs/laravel.log

# Windows PowerShell
Get-Content storage/logs/laravel.log -Tail 50 -Wait
```

## Log Levels Digunakan

| Level     | Usage                          | Color  |
| --------- | ------------------------------ | ------ |
| `info`    | Successful operations          | Green  |
| `warning` | Validation fails, missing data | Yellow |
| `error`   | Exceptions, failures           | Red    |

## JSON Error Response Format

Untuk API/AJAX requests:

```json
{
    "success": false,
    "message": "Human readable error message",
    "errors": {
        "field_name": ["error 1", "error 2"]
    },
    "error_code": 422,
    "row_number": 5 // For import errors
}
```

## Configuration

Pastikan `.env` settings:

```env
# Development
APP_DEBUG=true
LOG_LEVEL=debug

# Production
APP_DEBUG=false
LOG_LEVEL=error
```

## Testing Error Handling

Coba buat error scenario:

```bash
# Test validation error
php artisan tinker
> App\Models\Trade::create([])  # Will throw validation error

# Test not found error
> App\Models\Trade::findOrFail(99999)  # Will throw ModelNotFoundException
```

## Files Changed

1. `app/Exceptions/Handler.php` - Main error handler
2. `app/Exceptions/TradeException.php` - NEW
3. `app/Exceptions/ValidationException.php` - NEW
4. `app/Exceptions/DataNotFoundException.php` - UPDATED
5. `app/Exceptions/ImportException.php` - UPDATED
6. `app/Http/Controllers/TradeController.php` - UPDATED
7. `app/Http/Controllers/TradingRuleController.php` - UPDATED
8. `app/Http/Controllers/SessionController.php` - UPDATED
9. `app/Http/Controllers/DashboardController.php` - UPDATED

## Best Practices

1. **Always log important operations** - Create, Update, Delete, Import/Export
2. **Provide user-friendly error messages** - Don't expose technical details
3. **Catch specific exceptions first** - ValidationException before generic Exception
4. **Include context in logs** - IDs, values, stack trace untuk debugging
5. **Test error paths** - Jangan hanya test happy path
6. **Monitor logs regularly** - Set up alerts untuk critical errors
