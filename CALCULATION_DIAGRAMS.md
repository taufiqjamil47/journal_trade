# 📊 Calculation Flow & Architecture Diagram

## FLOW DIAGRAM: Trade Lifecycle

```
┌─────────────────────────────────────────────────────────────────┐
│                    CREATE TRADE (FORM 1)                        │
├─────────────────────────────────────────────────────────────────┤
│  Input:                                                         │
│  - Date, Time                                                   │
│  - Symbol (EURJPY, GBPUSD, etc)                                 │
│  - Type (BUY or SELL)                                           │
│  - Entry Price                                                  │
│  - Stop Loss Price                                              │
│  - Take Profit Price                                            │
└────────────────────────────────┬────────────────────────────────┘
                                 │
                                 ▼
┌─────────────────────────────────────────────────────────────────┐
│               AUTO CALCULATE PIPS (Immediate)                   │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  SL_PIPS = |Entry - Stop_Loss| ÷ Pip_Value                      │
│                                                                 │
│  Example EURJPY (pip_value = 0.01):                             │
│  SL_PIPS = |160.50 - 160.00| ÷ 0.01 = 50 pips                   │
│                                                                 │
│  TP_PIPS = |Entry - Take_Profit| ÷ Pip_Value                    │
│  TP_PIPS = |160.50 - 161.50| ÷ 0.01 = 100 pips                  │
│                                                                 │
│  RR_RATIO = TP_PIPS ÷ SL_PIPS = 100 ÷ 50 = 2.0                  │
│                                                                 │
│  ✅ Stored in Database: sl_pips, tp_pips, rr                    │
└────────────────────────────────┬────────────────────────────────┘
                                 │
                                 ▼
┌─────────────────────────────────────────────────────────────────┐
│                  EDIT TRADE (FORM 2: Close Trade)                │
├─────────────────────────────────────────────────────────────────┤
│  Input Exit Price (when trade closed)                            │
│                                                                    │
│  Also Input ONE OF:                                              │
│  - Risk % (calculates lot size)                                 │
│  - Lot Size Manual (calculates risk%)                           │
│  - Risk USD (calculates both)                                   │
│                                                                    │
│  Optional: Partial Close %                                       │
└────────────────────────────────┬────────────────────────────────┘
                                 │
                                 ▼
┌─────────────────────────────────────────────────────────────────┐
│           AUTO CALCULATE: EXIT PIPS & LOT SIZE                   │
├─────────────────────────────────────────────────────────────────┤
│                                                                    │
│  EXIT_PIPS = |Exit - Entry| ÷ Pip_Value                        │
│                                                                    │
│  IF Risk % Input:                                                │
│    Risk_USD = Account_Balance × (Risk% ÷ 100)                  │
│    Lot_Size = Risk_USD ÷ (SL_PIPS × Pip_Worth)               │
│                                                                    │
│  IF Lot Size Input:                                              │
│    Risk_USD = SL_PIPS × Pip_Worth × Lot_Size                  │
│    Risk% = (Risk_USD ÷ Account_Balance) × 100                 │
│                                                                    │
│  ✅ Stored: exit_pips, lot_size, risk_usd, risk_percent         │
└────────────────────────────────┬────────────────────────────────┘
                                 │
                                 ▼
┌─────────────────────────────────────────────────────────────────┐
│         AUTO CALCULATE: NET P/L (Final Result)                   │
├─────────────────────────────────────────────────────────────────┤
│                                                                    │
│  GROSS_PNL = EXIT_PIPS × Lot_Size × Pip_Worth                  │
│                                                                    │
│  Example:                                                        │
│  EXIT_PIPS = +50                                                 │
│  Lot_Size = 0.5                                                  │
│  Pip_Worth = 10                                                  │
│                                                                    │
│  GROSS_PNL = 50 × 0.5 × 10 = $250                             │
│                                                                    │
│  NET_PNL = GROSS_PNL - (Commission_Per_Lot × Lot_Size)        │
│  NET_PNL = 250 - (5 × 0.5) = $247.50                          │
│                                                                    │
│  Determine Result:                                              │
│  IF NET_PNL > 0 → hasil = 'WIN'  ✅                            │
│  IF NET_PNL < 0 → hasil = 'LOSS' ❌                            │
│  IF NET_PNL = 0 → hasil = 'BE'   ⚪                             │
│                                                                    │
│  ✅ Stored: profit_loss, hasil                                    │
└─────────────────────────────────────────────────────────────────┘
```

---

## SYMBOL CONFIGURATION IMPACT

```
┌──────────────────────────────────────────────────────────────────────┐
│                      Symbol Configuration                            │
├──────────────────────────────────────────────────────────────────────┤
│                                                                        │
│  EURJPY:                                    │  GBPUSD:              │
│  ┌────────────────────────────────┐        │  ┌──────────────────┐ │
│  │ pip_value = 0.01               │        │  │ pip_value = 0.0001
│  │ pip_worth = 10                 │        │  │ pip_worth = 10   │ │
│  │ (JPY pair, larger price pts)   │        │  │ (Major, standard)
│  └────────────────────────────────┘        │  └──────────────────┘ │
│                │                           │         │              │
│                ▼                           │         ▼              │
│  Entry: 160.50                             │  Entry: 1.3050        │
│  SL:    160.00                             │  SL:    1.3000        │
│  Pips = |0.50| ÷ 0.01 = 50 pips          │  Pips = |0.0050| ÷ 0.0001 = 50 pips
│                │                           │         │              │
│                ▼                           │         ▼              │
│  Risk(1.0 lot) = 50 × 10 × 1 = $500       │  Risk(1.0 lot) = 50 × 10 × 1 = $500
│  (Same risk exposure despite different     │  (Automatically normalized!)
│   price scales!)                           │                        │
│                                             │                        │
└─────────────────────────────────────────────┴────────────────────────┘
```

---

## MULTIPLE ACCOUNTS ISOLATION

```
┌─────────────────────────────────────────────────────────────────────┐
│                   Multi-Account Setup Example                       │
├─────────────────────────────────────────────────────────────────────┤
│                                                                       │
│  Account 1: "Scalping"                Account 2: "Swing Trading"   │
│  ┌─────────────────────────────┐     ┌─────────────────────────────┐
│  │ Initial: $5,000             │     │ Initial: $20,000            │
│  │                             │     │                             │
│  │ Trades:                     │     │ Trades:                     │
│  │ • EURJPY (2026-02-15) +50   │     │ • GBPUSD (2026-02-10) +100  │
│  │ • EURJPY (2026-02-16) -30   │     │ • AUDUSD (2026-02-12) -50   │
│  │ • EURJPY (2026-02-17) +40   │     │ • EURUSD (2026-02-15) +80   │
│  │                             │     │                             │
│  │ Balance: $5,000 + 60 = $5,060  │ │ Balance: $20,000 + 130 = $20,130
│  │ Winrate: 66.67% (2W, 1L)    │     │ Winrate: 66.67% (2W, 1L)   │
│  │                             │     │                             │
│  └─────────────────────────────┘     └─────────────────────────────┘
│         (Risk calc uses $5,000)         (Risk calc uses $20,000)    │
│         (Trades tracked separate)       (Trades tracked separate)   │
│                                                                       │
│  ✅ Completely isolated calculations!                              │
│  ✅ Each account has independent balance & risk management         │
│  ✅ Can mix different pairs per account                            │
│                                                                       │
└─────────────────────────────────────────────────────────────────────┘
```

---

## PAIR SCALABILITY MATRIX

```
┌─────────────────────────────────────────────────────────────────────┐
│            Supporting Different Pairs in 1 Account                  │
├──────────────────┬──────────────┬──────────────┬───────────────────┤
│ Pair             │ Pip Value    │ Pip Worth    │ Risk USD (1 lot,  │
│                  │              │              │ 50 pips, 2% risk) │
├──────────────────┼──────────────┼──────────────┼───────────────────┤
│ EURUSD           │ 0.0001       │ 10           │ $500              │
│ EURJPY           │ 0.01         │ 10           │ $500              │
│ GBPUSD           │ 0.0001       │ 10           │ $500              │
│ AUDUSD           │ 0.0001       │ 10           │ $500              │
│ NZDUSD           │ 0.0001       │ 10           │ $500              │
│ XAUUSD (Gold)    │ 0.01         │ 1            │ $50               │
│ BTCUSD           │ 1            │ 0.01         │ $50               │
└──────────────────┴──────────────┴──────────────┴───────────────────┘

✅ Formula auto-normalizes! All can be in same account without issues.
```

---

## DATABASE SCHEMA (Relevant Parts)

```
┌─────────────────────────────────────────────────────────────────────┐
│                        SYMBOLS TABLE                                 │
├─────────────────────────────────────────────────────────────────────┤
│ id  │ name     │ pip_value │ pip_position │ pip_worth │ active │     │
├─────┼──────────┼───────────┼──────────────┼───────────┼────────┤     │
│ 1   │ EURUSD   │ 0.0001    │ 4            │ 10        │ true   │     │
│ 2   │ EURJPY   │ 0.01      │ 2            │ 10        │ true   │     │
│ 3   │ GBPUSD   │ 0.0001    │ 4            │ 10        │ true   │     │
│ 4   │ XAUUSD   │ 0.01      │ 2            │ 1         │ true   │     │
└─────┴──────────┴───────────┴──────────────┴───────────┴────────┘     │
           ▲ Referenced by trades.symbol_id           │                 │
           │        (Foreign Key)                      │                 │
           └──────────────────────────────────────────┘
                                                                        │
├─────────────────────────────────────────────────────────────────────┤
│                         TRADES TABLE                                 │
├─────────────────────────────────────────────────────────────────────┤
│ id  │ account_id │ symbol_id │ entry │ sl │ tp │ exit │ exit_pips●..│
├─────┼────────────┼───────────┼───────┼────┼────┼──────┼───────────┤  │
│ 100 │ 1          │ 1         │ 1.305 │... │... │ 1.310 │ +50       │  │
│ 101 │ 1          │ 2         │ 160.5 │... │... │ 161.0 │ +50       │  │
│ 102 │ 2          │ 1         │ 1.305 │... │... │ 1.300 │ -50       │  │
│ 103 │ 2          │ 4         │ 2050  │... │... │ 2045  │ -500      │  │
└─────┴────────────┴───────────┴───────┴────┴────┴──────┴───────────┘  │
                                                       ▲                 │
                    ┌──────────────────────────────────┘                │
                    │ Joins with symbols to lookup pip_value, pip_worth
```

---

## CALCULATION PRECISION FLOW

```
┌─────────────────────────────────────────────────────────────────┐
│                    Precision Handling                            │
├─────────────────────────────────────────────────────────────────┤
│                                                                   │
│  Input Values (User):                                           │
│  - Entry: 1.30500      (database: 15,5 decimal)                │
│  - Exit:  1.31002      (database: 15,5 decimal)                │
│  - SL:    1.30000      (database: 15,5 decimal)               │
│                                                                  │
│  Calculation (High Precision):                                 │
│  exit_diff = 1.31002 - 1.30500 = 0.00502                     │
│  exit_pips = 0.00502 / 0.0001 = 50.2                         │
│  exit_pips_rounded = round(50.2, 4) = 50.2000               │
│                                                                  │
│  PnL Calculation (Using High Precision):                       │
│  gross_pnl = 50.2 × 0.5 × 10 = 251.0                        │
│  commission = 5 × 0.5 = 2.5                                   │
│  net_pnl = 251.0 - 2.5 = 248.5                               │
│  profit_loss = round(248.5, 2) = 248.50                       │
│                                                                  │
│  Final (2 decimals for USD):                                   │
│  ✅ profit_loss = $248.50                                       │
│                                                                  │
│  Rounding Loss: 248.50 - 248.50 = $0.00 (None! Optimal!)     │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

---

## ANALYTICS AGGREGATION (Multiple Pairs)

```
┌─────────────────────────────────────────────────────────────────┐
│              Pair Analysis Dashboard Query                       │
├─────────────────────────────────────────────────────────────────┤
│                                                                   │
│  SELECT s.name as pair,                                         │
│         COUNT(*) as trades,                                     │
│         SUM(CASE WHEN t.hasil='win' THEN 1 END) as wins,      │
│         SUM(t.profit_loss) as total_pnl,                        │
│         AVG(t.profit_loss) as avg_pnl                           │
│  FROM trades t                                                   │
│  JOIN symbols s ON t.symbol_id = s.id                          │
│  WHERE t.account_id = 1                                         │
│  GROUP BY s.name                                                │
│                                                                  │
│  Result:                                                         │
│  ┌──────────┬────────┬──────┬──────────────┬──────────┐        │
│  │ pair     │ trades │ wins │ total_pnl    │ avg_pnl  │        │
│  ├──────────┼────────┼──────┼──────────────┼──────────┤        │
│  │ EURUSD   │ 5      │ 3    │ $450.25      │ $90.05   │        │
│  │ EURJPY   │ 8      │ 5    │ $620.50      │ $77.56   │        │
│  │ GBPUSD   │ 3      │ 2    │ $210.00      │ $70.00   │        │
│  │ XAUUSD   │ 2      │ 1    │ -$25.00      │ -$12.50  │        │
│  ├──────────┼────────┼──────┼──────────────┼──────────┤        │
│  │ TOTAL    │ 18     │ 11   │ $1,255.75    │ $69.76   │        │
│  └──────────┴────────┴──────┴──────────────┴──────────┘        │
│                                                                   │
│  ✅ Works with any number of pairs!                            │
│  ✅ Database query optimized with GROUP BY                     │
│  ✅ No additional code needed for new pairs                    │
│                                                                   │
└─────────────────────────────────────────────────────────────────┘
```

---

## PERFORMANCE IMPACT

```
┌─────────────────────────────────────────────────────────────────┐
│               Scalability with Added Pairs                       │
├──────────────┬──────────┬──────────┬──────────┬────────────────┤
│ Pairs Count  │ DB Size  │ Query    │ Dashboard│ Expected P95   │
│              │ Impact   │ Speed    │ Load     │ Page Load Time │
├──────────────┼──────────┼──────────┼──────────┼────────────────┤
│ 1-5 pairs    │ +5 MB    │ <100ms   │ <200ms   │ <500ms         │
│ 6-20 pairs   │ +20 MB   │ <150ms   │ <300ms   │ <700ms         │
│ 21-50 pairs  │ +50 MB   │ <200ms   │ <400ms   │ <1sec          │
│ 50+ pairs    │ +100 MB  │ <300ms   │ <500ms   │ <1.5sec        │
│                                                 ↓               │
│                                         (Still acceptable)     │
│                                                                 │
│ ✅ Horizontal scaling possible:                               │
│    - Add database indexing on symbol_id                        │
│    - Implement query caching                                   │
│    - Use materialized views for reports                        │
└──────────────┴──────────┴──────────┴──────────┴────────────────┘
```

---

## QUICK DECISION TREE

```
                      Adding New Pair?
                           │
                    ┌──────┴──────┐
                    ▼             ▼
              Is it active?   Do you have pip_value?
              (Y/N)           (Y/N)
                │               │
        ┌───────┴────────┐      └─→ Look it up:
        ▼                ▼          - EURJPY: 0.01
    INSERT INTO       ← No:         - GBPUSD: 0.0001
    symbols table     Deactivate    - XAUUSD: 0.01

         ▼

    Set pip_worth
    (usually 10)
         │
         ▼
    Test 1 trade
    (verify pips)
         │
         ▼
    Close & verify PnL
         │         ▼
        ✅        Correct!
   Ready to use
```

---

**Last Updated**: Februari 20, 2026
