# Multi-Account Integration Testing Checklist

## ✅ Fitur Yang Sudah Terintegrasi

### 1. **Dashboard** ✅

- [x] Account Selector di header
- [x] Filter metrics per account
- [x] Update saat switch account

### 2. **Trades Management** ✅

- [x] Account Selector di Trades Index
- [x] Account Selector di Create Trade (show current account)
- [x] Account Selector di Edit Trade
- [x] Auto-create trade di selected account
- [x] Filter trade list per account

### 3. **Analysis** ✅

- [x] Account Selector di Analysis page
- [x] Filter analysis data per account
- [x] Risk metrics per account
- [x] Pair analysis per account
- [x] Time analysis per account

### 4. **Calendar Report** ✅

- [x] Account Selector di Calendar page
- [x] Filter daily trades per account
- [x] Filter weekly summary per account
- [x] Filter monthly summary per account
- [x] Only show trades from selected account

---

## 📋 Testing Workflow

### Setup Phase

```
1. Buka "Manage Accounts"
2. Create Account 1: "Scalp Trading"
   - Initial Balance: $5000
   - Currency: USD
   - Description: For scalping 5-minute trades

3. Create Account 2: "Day Trade"
   - Initial Balance: $10000
   - Currency: USD
   - Description: For day trading 4-hour trades
```

### Test Dashboard

```
1. Buka Dashboard
2. Lihat Account Selector (gedung icon) di atas
3. Pilih "Scalp Trading"
   ✓ Dashboard update
   ✓ Metrics show "Scalp" data (initial balance $5000)

4. Klik Account Selector → Pilih "Day Trade"
   ✓ Dashboard update instantly
   ✓ Metrics show "Day Trade" data (initial balance $10000)
   ✓ Winrate recalculate dari "Day Trade" trades
```

### Test Trades

```
1. Dari Dashboard, pilih "Scalp Trading"
2. Buka Trades → Create
   ✓ Account Selector visible
   ✓ Subtitle show: "Account: Scalp Trading"

3. Create 2 trades untuk Scalp:
   - Trade 1: EURUSD, Buy
   - Trade 2: AUDUSD, Sell

4. Buka Trades Index
   ✓ Hanya 2 trades Scalp tampil
   ✓ Winrate calculate dari 2 trades saja

5. Account Selector → Pilih "Day Trade"
   ✓ Trades list kosong (belum ada trade)

6. Create 3 trades untuk Day Trade
7. Trades Index → hanya 3 trades Day Trade tampil
8. Account Selector → Pilih "Scalp Trading"
   ✓ 2 trades Scalp kembali tampil
```

### Test Analysis

```
1. Dashboard → Pilih "Scalp Trading"
2. Buka Analysis
   ✓ Account Selector di header
   ✓ Widgets show: "Scalp Trading" metrics
   ✓ Pair analysis hanya dari Scalp trades
   ✓ Risk metrics dari Scalp data

3. Account Selector → "Day Trade"
   ✓ Semua metrics update
   ✓ Charts update dengan Day Trade data
```

### Test Calendar

```
1. Dashboard → Pilih "Scalp Trading"
2. Buka Calendar
   ✓ Account Selector di header
   ✓ Calendar show profit/loss dari Scalp trades saja
   ✓ Daily totals filtered per account
   ✓ Weekly summary dari Scalp
   ✓ Monthly summary dari Scalp

3. Account Selector → "Day Trade"
   ✓ Calendar empty jika belum ada Day Trade buat
   ✓ Upload/create trade Day Trade → tampil di calendar
```

### Test Editing Trades

```
1. Dashboard → "Scalp Trading"
2. Trades Index → Open trade dari Scalp
3. Edit Trade
   ✓ Account Selector show "Scalp Trading"
   ✓ Account info di subtitle
   ✓ Update exit → masih ke account Scalp

4. Account Selector → "Day Trade"
   ✓ Trade dari Scalp tidak terlihat lagi
   ✓ Tidak bisa edit trade Scalp dari Day Trade mode
```

---

## 🔍 Database Verification

```sql
-- Check accounts table
SELECT id, name, description, initial_balance, currency FROM accounts;

-- Check trade distribution
SELECT account_id, COUNT(*) as total_trades, SUM(profit_loss) as total_pl
FROM trades
GROUP BY account_id;

-- Verify selected account in session
-- (Check browser: F12 → Application → Cookies/Storage)
-- selected_account_id should match current selection
```

---

## ⚠️ Known Behaviors

1. **Account Switch**: Session-based, perubahan langsung ke URL param `?account_id=X`
2. **Edit Trade**: Tidak bisa edit trade dari account lain (akan 404)
3. **Import Excel**: Akan import ke selected account otomatis
4. **Reports**: Semua filter by selected account

---

## ✨ Features Summary

| Feature       | Status | Location                         |
| ------------- | ------ | -------------------------------- |
| Dashboard     | ✅     | Dashboard header                 |
| Trades List   | ✅     | Trades header                    |
| Create Trade  | ✅     | Trades create                    |
| Edit Trade    | ✅     | Trades edit                      |
| Analysis      | ✅     | Analysis header                  |
| Calendar      | ✅     | Calendar header                  |
| Accounts Mgmt | ✅     | Manage Accounts link in selector |

---

## 🚀 Performance Notes

- Middleware `SetSelectedAccount` run pada setiap request
- Queries di-optimize dengan WHERE clause untuk account_id
- Session caching tidak terpengaruh (per-request filter)
- Cache invalidated saat account_id berubah (session key berbeda)

---

Last Updated: February 14, 2026
