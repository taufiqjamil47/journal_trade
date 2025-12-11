# Quick Start Guide - Error Handling Features

## 🚀 Start Using Error Handling

### 1. Check Logs (Real-Time Monitoring)

**Windows PowerShell:**

```powershell
# View last 50 lines with real-time updates
Get-Content storage/logs/laravel.log -Tail 50 -Wait

# Or with more details
Get-Content storage/logs/laravel.log | Select-Object -Last 20
```

**Linux/Mac:**

```bash
tail -f storage/logs/laravel.log
```

### 2. Test Error Handling

**Test Form Validation:**

1. Go to create/edit page
2. Try to submit empty form
3. See validation errors displayed
4. Check logs: `storage/logs/laravel.log`

**Test Import Error:**

1. Go to Trades → Import Excel
2. Upload CSV with invalid data
3. Error message shown dengan detail
4. Check logs untuk row number & column yang error

**Test Graceful Degradation:**

1. Stop MySQL server temporarily
2. Visit dashboard
3. See default metrics displayed (tidak crash)
4. Check logs untuk connection error

### 3. Monitoring Errors

**Development Setup:**

```env
APP_DEBUG=true          # Show full error details
LOG_LEVEL=debug         # Log all messages including debug info
```

**Production Setup:**

```env
APP_DEBUG=false         # Hide technical details dari users
LOG_LEVEL=error         # Only log errors & critical issues
```

### 4. Common Error Messages & Solutions

| Error                               | Cause                  | Solution                     |
| ----------------------------------- | ---------------------- | ---------------------------- |
| "Trade dengan ID X tidak ditemukan" | Trade doesn't exist    | Refresh page, use valid ID   |
| "Validation failed"                 | Required field missing | Fill all required fields     |
| "Gagal mengimpor trades: ..."       | File format invalid    | Use CSV/Excel, check columns |
| "Gagal memuat daftar rules"         | Database issue         | Check DB connection          |
| "No account found"                  | Account not configured | Create account first         |

### 5. Check Application Health

```php
// In Laravel Tinker
php artisan tinker

// Check account exists
>>> App\Models\Account::count()
1

// Check recent trades
>>> App\Models\Trade::latest()->first()

// Check logs
>>> Illuminate\Support\Facades\Log::info('Test message')
```

### 6. Common Issues & How Errors Are Now Handled

**Issue:** Import file has bad data

-   **Before:** Crash, data partially imported
-   **After:** Error message dengan row number, all-or-nothing import

**Issue:** Symbol deleted while creating trade

-   **Before:** 500 error
-   **After:** Validation error "Symbol tidak ditemukan"

**Issue:** Database connection fails

-   **Before:** White screen
-   **After:** User-friendly error message + logged untuk debugging

**Issue:** Calculate balance dari 10000 trades

-   **Before:** Might timeout
-   **After:** Partial cache + error logged + default values shown

### 7. Useful Log Commands

```bash
# Count errors in last hour
cd storage/logs && grep "ERROR" laravel.log | tail -100

# Find all trades created today
grep "Trade created successfully" laravel.log | tail -20

# Find all validation errors
grep "Validation error" laravel.log

# Find import errors specifically
grep "Import error" laravel.log

# Clear old logs (keep backup!)
# For Windows:
del storage/logs/laravel.log
# For Linux:
rm storage/logs/laravel.log
```

### 8. API Error Response Examples

**Successful Response:**

```json
HTTP 200
{
  "success": true,
  "data": {
    "id": 1,
    "symbol": "EURUSD",
    ...
  }
}
```

**Validation Error:**

```json
HTTP 422
{
  "success": false,
  "message": "Validation failed",
  "errors": {
    "symbol_id": ["Symbol tidak ditemukan"],
    "entry": ["Entry harus number"]
  }
}
```

**Not Found Error:**

```json
HTTP 404
{
  "success": false,
  "message": "Trade dengan ID 999 tidak ditemukan"
}
```

**Server Error:**

```json
HTTP 500
{
  "success": false,
  "message": "Gagal memproses permintaan Anda"
}
```

### 9. Enable Error Notifications (Optional)

Add to `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your@email.com
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@journal.test
```

Kemudian create notification untuk critical errors di `app/Notifications/`

### 10. Performance Tips

**Enable Query Logging untuk debugging:**

```php
// In controller if needed
DB::enableQueryLog();
// ... your code
dd(DB::getQueryLog());
```

**Check slowest queries:**

```bash
grep "Slow Query" storage/logs/laravel.log | sort | tail -10
```

## 📞 Troubleshooting

**Q: Logs file getting too large?**
A: Implement log rotation di `config/logging.php` atau use `php artisan tinker` untuk clear

**Q: Can't see detailed errors in production?**
A: Check `APP_DEBUG=false` setting, errors go to logs only

**Q: Want to email critical errors?**
A: Create custom notification handler di Exception Handler

**Q: How to test error handling?**
A: See "Test Error Handling" section above

## 📊 Monitoring Checklist

-   [ ] Check logs daily untuk error patterns
-   [ ] Set up log aggregation tool (optional)
-   [ ] Monitor disk space untuk log files
-   [ ] Test error scenarios regularly
-   [ ] Document custom error handling untuk team
-   [ ] Set up alerts untuk critical errors
-   [ ] Review error patterns quarterly

---

**Next:** See `ERROR_HANDLING_GUIDE.md` untuk detailed reference
