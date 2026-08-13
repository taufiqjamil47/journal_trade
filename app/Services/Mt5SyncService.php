<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Symbol;
use App\Models\Trade;
use App\Services\Mt5ApiClient;
use App\Exceptions\Mt5SyncException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class Mt5SyncService
{
    protected Mt5ApiClient $apiClient;

    public function __construct(Mt5ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function syncAccountTradesFromMt5(Account $account): array
    {
        $payload = $this->apiClient->fetchTrades($account);
        $result = $this->syncAccountTradesFromPayload($account, ['trades' => $payload]);

        $status = empty($result['errors']) ? 'success' : 'partial';
        $this->updateAccountSyncStatus(
            $account,
            $status,
            "Created {$result['created']}, updated {$result['updated']}, errors " . count($result['errors'])
        );

        return $result;
    }

    public function syncAccountTradesFromPayload(Account $account, array $payload, bool $updateStatus = true): array
    {
        $trades = $payload['trades'] ?? $payload;
        $result = [
            'processed' => 0,
            'created' => 0,
            'updated' => 0,
            'errors' => [],
        ];

        if (!is_array($trades)) {
            throw new Mt5SyncException('Payload must contain a trades array.');
        }

        $seenTickets = [];

        foreach ($trades as $record) {
            if (!is_array($record)) {
                $result['errors'][] = 'Invalid trade record. Expected object/array.';
                continue;
            }

            $normalized = $this->normalizeArrayKeys($record);
            $ticket = $this->getValue($normalized, ['mt5ticket', 'ticket', 'orderid', 'order_id']);

            if (!empty($ticket)) {
                if (isset($seenTickets[$ticket])) {
                    $result['errors'][] = "Duplicate ticket in payload: {$ticket}.";
                    continue;
                }
                $seenTickets[$ticket] = true;
            }

            $result['processed']++;

            try {
                $trade = $this->syncTradeRecord($account, $normalized);
                if ($trade->wasRecentlyCreated) {
                    $result['created']++;
                } else {
                    $result['updated']++;
                }
            } catch (Mt5SyncException $exception) {
                Log::warning('MT5 sync validation failed for account ' . $account->id . ': ' . $exception->getMessage(), [
                    'record' => $record,
                ]);
                $result['errors'][] = $exception->getMessage();
            } catch (\Throwable $exception) {
                Log::error('MT5 sync failed for account ' . $account->id . ': ' . $exception->getMessage(), [
                    'record' => $record,
                ]);
                $result['errors'][] = $exception->getMessage();
            }
        }

        if ($updateStatus) {
            $status = empty($result['errors']) ? 'success' : 'partial';
            $this->updateAccountSyncStatus(
                $account,
                $status,
                "Created {$result['created']}, updated {$result['updated']}, errors " . count($result['errors'])
            );
        }

        return $result;
    }

    protected function updateAccountSyncStatus(Account $account, string $status, ?string $message = null): void
    {
        $account->update([
            'mt5_last_sync_at' => now(),
            'mt5_last_sync_status' => $status,
            'mt5_last_sync_message' => $message,
        ]);
    }

    public function syncTradeRecord(Account $account, array $record): Trade
    {
        $normalized = $this->normalizeArrayKeys($record);
        $symbolName = $this->getValue($normalized, ['symbol', 'symbolname', 'pair', 'currency_pair']);
        $ticket = $this->getValue($normalized, ['mt5ticket', 'ticket', 'orderid', 'order_id']);
        $isOpen = $this->parseBoolean($this->getValue($normalized, ['is_open'], false));

        if (empty($symbolName)) {
            throw new Mt5SyncException('MT5 trade record missing symbol.');
        }

        $symbol = Symbol::where('name', strtoupper(trim($symbolName)))->first();
        if (!$symbol) {
            throw new Mt5SyncException("Symbol '{$symbolName}' tidak ditemukan di database.");
        }

        $timestamp = $this->parseTimestamp($normalized);
        if (!$timestamp) {
            throw new \RuntimeException('MT5 trade record missing valid timestamp.');
        }

        $type = $this->normalizeTradeType($this->getValue($normalized, ['type', 'side']));
        if (empty($type)) {
            throw new \RuntimeException('MT5 trade record missing valid type (buy/sell).');
        }

        $date = $this->parseDate($normalized, $timestamp);

        // 🔥 AMBIL SL DAN TP DARI PAYLOAD
        $stopLoss = $this->parseNumeric($normalized, ['stop_loss', 'sl', 'stoploss']);
        $takeProfit = $this->parseNumeric($normalized, ['take_profit', 'tp', 'takeprofit']);
        $exit = $this->parseNumeric($normalized, ['exit', 'close_price', 'close']);
        $profitLoss = $this->parseNumeric($normalized, ['profit_loss', 'pnl', 'profit']);
        $lotSize = $this->parseNumeric($normalized, ['lot_size', 'lotsize', 'volume']);

        $attributes = [
            'account_id' => $account->id,
            'symbol_id' => $symbol->id,
            'timestamp' => $timestamp,
            'date' => $date,
            'type' => $type,
            'entry' => $this->parseNumeric($normalized, ['entry', 'open_price']),
            'stop_loss' => $stopLoss,      // 🔥 SL DARI PAYLOAD
            'take_profit' => $takeProfit,  // 🔥 TP DARI PAYLOAD
            'exit' => $exit,
            'mt5_ticket' => $ticket,
            'mt5_comment' => $this->getValue($normalized, ['comment', 'mt5_comment', 'order_comment']),
            'profit_loss' => $profitLoss,
            'lot_size' => $lotSize,
            'is_open' => $isOpen,          // 🔥 SIMPAN STATUS POSISI
            'rr' => $this->parseNumeric($normalized, ['rr', 'risk_reward_ratio']),
            'risk_usd' => $this->parseNumeric($normalized, ['risk_usd', 'riskusd']),
            'sl_pips' => $this->parseNumeric($normalized, ['sl_pips', 'slpips']),
            'tp_pips' => $this->parseNumeric($normalized, ['tp_pips', 'tppips']),
            'exit_pips' => $this->parseNumeric($normalized, ['exit_pips', 'exitpips']),
            'risk_percent' => $this->parseNumeric($normalized, ['risk_percent', 'riskpercent']),
            'follow_rules' => $this->parseBoolean($this->getValue($normalized, ['follow_rules', 'followrules'], true)),
            'market_condition' => $this->getValue($normalized, ['market_condition', 'marketcondition']),
            'entry_reason' => $this->getValue($normalized, ['entry_reason', 'entryreason']),
            'why_sl_tp' => $this->getValue($normalized, ['why_sl_tp', 'whysltp']),
            'entry_emotion' => $this->getValue($normalized, ['entry_emotion', 'entryemotion']),
            'close_emotion' => $this->getValue($normalized, ['close_emotion', 'closeemotion']),
            'note' => $this->getValue($normalized, ['note', 'description']),
        ];

        // 🔥 CARI TRADE BERDASARKAN MT5_TICKET
        if (!empty($ticket)) {
            $trade = Trade::where('account_id', $account->id)
                ->where('mt5_ticket', $ticket)
                ->first();
        } else {
            $trade = Trade::where('account_id', $account->id)
                ->where('symbol_id', $symbol->id)
                ->where('timestamp', $timestamp)
                ->where('type', $type)
                ->first();
        }

        if ($trade) {
            // 🔥 UPDATE TANPA MENIMPA SL/TP JIKA SUDAH ADA
            // Ini penting agar SL/TP dari posisi terbuka tidak hilang saat update dari history
            $existingStopLoss = $trade->stop_loss;
            $existingTakeProfit = $trade->take_profit;

            // Jika SL/TP sudah ada (dari posisi terbuka) dan payload memberikan 0 (dari history)
            // maka pertahankan nilai yang sudah ada
            if ($existingStopLoss != 0 && $existingStopLoss != null && ($stopLoss == 0 || $stopLoss == null)) {
                $attributes['stop_loss'] = $existingStopLoss;
            }

            if ($existingTakeProfit != 0 && $existingTakeProfit != null && ($takeProfit == 0 || $takeProfit == null)) {
                $attributes['take_profit'] = $existingTakeProfit;
            }

            // Update is_open jika ada data baru
            if ($isOpen !== null) {
                $attributes['is_open'] = $isOpen;
            }

            $trade->update($attributes);
            return $trade;
        }

        return Trade::create($attributes);
    }

    protected function normalizeArrayKeys(array $record): array
    {
        $normalized = [];
        foreach ($record as $key => $value) {
            $normalized[strtolower(str_replace([' ', '-', '.'], '_', trim($key)))] = $value;
        }
        return $normalized;
    }

    protected function getValue(array $record, array $keys, $default = null)
    {
        foreach ($keys as $key) {
            if (array_key_exists($key, $record) && $record[$key] !== null && $record[$key] !== '') {
                return $record[$key];
            }
        }
        return $default;
    }

    protected function parseTimestamp(array $record): ?string
    {
        $value = $this->getValue($record, ['timestamp', 'date_time', 'datetime', 'open_time', 'close_time', 'time']);
        if (empty($value)) {
            return null;
        }

        try {
            // 🔥 FIX: Ganti format 2026.07.14 menjadi 2026-07-14
            $value = str_replace('.', '-', $value);
            return Carbon::parse($value)->format('Y-m-d H:i:s');
        } catch (\Throwable $e) {
            // Jika masih gagal, coba format lain
            try {
                // Coba format dengan titik
                $value = str_replace('.', '-', $value);
                return Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('Y-m-d H:i:s');
            } catch (\Throwable $e2) {
                return null;
            }
        }
    }

    protected function parseDate(array $record, ?string $timestamp = null): ?string
    {
        if ($timestamp) {
            return Carbon::parse($timestamp)->format('Y-m-d');
        }

        $value = $this->getValue($record, ['date', 'trade_date', 'open_date']);
        if (empty($value)) {
            return null;
        }

        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Throwable $e) {
            return null;
        }
    }

    protected function parseNumeric(array $record, array $keys, $default = null)
    {
        $value = $this->getValue($record, $keys, $default);
        if ($value === null || $value === '') {
            return $default;
        }

        if (is_numeric($value)) {
            return $value + 0;
        }

        $cleaned = preg_replace('/[^0-9\.\-]/', '', (string) $value);
        return is_numeric($cleaned) ? $cleaned + 0 : $default;
    }

    protected function parseBoolean($value): bool
    {
        if (is_bool($value)) {
            return $value;
        }

        $normalized = strtolower(trim((string) $value));
        return in_array($normalized, ['1', 'true', 'yes', 'y', 'on'], true);
    }

    protected function normalizeTradeType($type): ?string
    {
        if (empty($type)) {
            return null;
        }

        $normalized = strtolower(trim((string) $type));
        if (in_array($normalized, ['buy', 'b'], true)) {
            return 'buy';
        }

        if (in_array($normalized, ['sell', 's'], true)) {
            return 'sell';
        }

        return null;
    }
}
