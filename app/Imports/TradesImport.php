<?php

namespace App\Imports;

use App\Models\Trade;
use App\Models\Symbol;
use App\Models\TradingRule;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Illuminate\Support\Str;

class TradesImport implements ToModel, WithHeadingRow
{
    private $headings = [];
    private $symbolCache = [];  // Cache symbols to prevent N+1 queries
    private $ruleCache = [];    // Cache rules to prevent N+1 queries

    public function headingRow(): int
    {
        return 1;
    }

    public function onHeadingRow(array $headings)
    {
        $this->headings = $headings;
        $this->headings = array_map(function ($h) {
            return strtolower(str_replace([' ', '_', '-'], '', $h));
        }, $headings);
    }

    public function model(array $row)
    {
        // Normalize row keys
        $normalizedRow = [];
        foreach ($row as $key => $value) {
            $normalizedKey = strtolower(str_replace([' ', '_', '-'], '', $key));
            $normalizedRow[$normalizedKey] = $value;
        }

        // Cari symbol
        $symbolValue = null;
        $possibleSymbolKeys = ['symbol', 'symbolid', 'symbolname', 'pair', 'currencypair'];

        foreach ($possibleSymbolKeys as $key) {
            if (isset($normalizedRow[$key]) && !empty($normalizedRow[$key])) {
                $symbolValue = $normalizedRow[$key];
                break;
            }
        }

        if (!$symbolValue) {
            throw new \Exception("Symbol not found in row.");
        }

        // Use cache to avoid N+1 queries
        if (!isset($this->symbolCache[$symbolValue])) {
            $symbol = Symbol::where('name', $symbolValue)->first();
            if (!$symbol) {
                throw new \Exception("Symbol '{$symbolValue}' not found in database.");
            }
            $this->symbolCache[$symbolValue] = $symbol;
        }
        $symbol = $this->symbolCache[$symbolValue];

        // Parse date dan time
        $date = $this->parseDate($normalizedRow, 'date');
        $time = $this->parseTime($normalizedRow, 'timestamp');
        $timestamp = null;
        if ($date && $time) {
            $timestamp = Carbon::parse("{$date} {$time}")->format('Y-m-d H:i:s');
        } elseif ($date) {
            $timestamp = $date . ' 00:00:00';
        }

        // Parse boolean
        $followRules = $this->parseBoolean($normalizedRow, 'followrules');

        // Ambil nilai rules dari Excel
        $rulesString = $this->getValue($normalizedRow, 'rules');

        // Simpan trade pertama tanpa rules di pivot table
        $trade = new Trade([
            'account_id'        => 1,
            'symbol_id'         => $symbol->id,
            'timestamp'         => $timestamp,
            'exit_timestamp'    => $this->determineExitTimestamp($normalizedRow, $timestamp),
            'date'              => $date,
            'type'              => $this->getValue($normalizedRow, 'type'),
            'entry'             => $this->getValue($normalizedRow, 'entry'),
            'stop_loss'         => $this->getValue($normalizedRow, ['stoploss', 'sl']),
            'sl_pips'           => $this->getValue($normalizedRow, ['slpips', 'sl_pips']),
            'take_profit'       => $this->getValue($normalizedRow, ['takeprofit', 'tp']),
            'tp_pips'           => $this->getValue($normalizedRow, ['tppips', 'tp_pips']),
            'exit'              => $this->getValue($normalizedRow, 'exit'),
            'exit_pips'         => $this->getValue($normalizedRow, ['exitpips', 'exit_pips']),
            'risk_percent'      => $this->getValue($normalizedRow, ['riskpercent', 'risk_percent']),
            'partial_close_percent' => $this->getValue($normalizedRow, ['partialclosepercent', 'partial_close_percent']),
            'risk_usd'          => $this->getValue($normalizedRow, ['riskusd', 'risk_usd']),
            'rr'                => $this->getValue($normalizedRow, 'rr'),
            'lot_size'          => $this->getValue($normalizedRow, ['lotsize', 'lot_size']),
            'profit_loss'       => $this->getValue($normalizedRow, ['profitloss', 'profit_loss', 'pnl']),
            'entry_type'        => $this->getValue($normalizedRow, ['entrytype', 'entry_type']),
            'follow_rules'      => $followRules,
            'rules'             => $rulesString, // Simpan string asli
            'market_condition'  => $this->getValue($normalizedRow, ['marketcondition', 'market_condition']),
            'entry_reason'      => $this->getValue($normalizedRow, ['entryreason', 'entry_reason']),
            'why_sl_tp'         => $this->getValue($normalizedRow, ['whysltp', 'why_sl_tp']),
            'entry_emotion'     => $this->getValue($normalizedRow, ['entryemotion', 'entry_emotion']),
            'close_emotion'     => $this->getValue($normalizedRow, ['closeemotion', 'close_emotion']),
            'note'              => $this->getValue($normalizedRow, 'note'),
            'before_link'       => $this->getValue($normalizedRow, ['beforelink', 'before_link', 'before']),
            'after_link'        => $this->getValue($normalizedRow, ['afterlink', 'after_link', 'after']),
            'hasil'             => $this->getValue($normalizedRow, 'hasil'),
            'streak_win'        => $this->getValue($normalizedRow, ['streakwin', 'streak_win'], 0),
            'streak_loss'       => $this->getValue($normalizedRow, ['streakloss', 'streak_loss'], 0),
            'session'           => $this->getValue($normalizedRow, 'session'),
        ]);

        // Simpan trade terlebih dahulu
        $trade->save();

        // PROSES RULES DARI STRING KE PIVOT TABLE
        if (!empty($rulesString)) {
            $this->processRulesFromString($trade, $rulesString);
        }

        return $trade;
    }

    /**
     * Proses rules string dan sync ke pivot table
     */
    private function processRulesFromString(Trade $trade, string $rulesString)
    {
        $cleanedString = $this->cleanRulesText($rulesString);
        $ruleNames = array_map('trim', explode(',', $cleanedString));
        $ruleNames = array_filter($ruleNames);

        if (empty($ruleNames)) {
            return;
        }

        // Hanya cari rules yang sudah ada
        $ruleIds = TradingRule::whereIn('name', $ruleNames)
            ->pluck('id')
            ->toArray();

        if (!empty($ruleIds)) {
            $trade->tradingRules()->sync($ruleIds);

            $trade->withoutEvents(function () use ($trade, $cleanedString) {
                $trade->update(['rules' => $cleanedString]);
            });
        }
    }

    /**
     * Helper untuk parse date dari Excel
     */
    private function parseDate($row, $key)
    {
        $value = $this->getValue($row, $key);

        if (empty($value)) {
            return null;
        }

        try {
            if (is_numeric($value)) {
                return Carbon::instance(ExcelDate::excelToDateTimeObject($value))->format('Y-m-d');
            }
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Helper untuk parse time dari Excel
     */
    private function parseTime($row, $key)
    {
        $value = $this->getValue($row, $key);

        if (empty($value)) {
            return null;
        }

        try {
            if (is_numeric($value)) {
                return Carbon::instance(ExcelDate::excelToDateTimeObject($value))->format('H:i:s');
            }
            return Carbon::parse($value)->format('H:i:s');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Determine exit timestamp: use provided exit timestamp if available,
     * otherwise fallback to entry timestamp + 3 hours.
     */
    private function determineExitTimestamp(array $row, $entryTimestamp)
    {
        // Try possible keys for exit timestamp
        $possibleKeys = ['exittimestamp', 'exit_timestamp', 'exit time', 'exittime', 'exit_time', 'exitdate', 'exit_date'];

        foreach ($possibleKeys as $k) {
            $val = $this->getValue($row, $k, null);
            if ($val !== null && $val !== '') {
                try {
                    if (is_numeric($val)) {
                        return Carbon::instance(ExcelDate::excelToDateTimeObject($val))->format('Y-m-d H:i:s');
                    }
                    return Carbon::parse($val)->format('Y-m-d H:i:s');
                } catch (\Exception $e) {
                    // ignore and fallback
                }
            }
        }

        // No explicit exit timestamp; use entry timestamp + 3 hours if entry exists
        if (!empty($entryTimestamp)) {
            try {
                return Carbon::parse($entryTimestamp)->addHours(3)->format('Y-m-d H:i:s');
            } catch (\Exception $e) {
                return null;
            }
        }

        // As a last resort, try to build from date + timestamp fields
        $date = $this->parseDate($row, 'date');
        $time = $this->parseTime($row, 'timestamp');
        if ($date && $time) {
            try {
                return Carbon::parse("{$date} {$time}")->addHours(3)->format('Y-m-d H:i:s');
            } catch (\Exception $e) {
                return null;
            }
        }

        return null;
    }

    /**
     * Helper untuk parse boolean
     */
    private function parseBoolean($row, $key)
    {
        $value = $this->getValue($row, $key);

        if (empty($value)) {
            return null;
        }

        $value = strtolower(trim($value));

        if (in_array($value, ['yes', '1', 'true', 'y'])) {
            return 1;
        }

        if (in_array($value, ['no', '0', 'false', 'n'])) {
            return 0;
        }

        return null;
    }

    /**
     * Helper untuk get value dengan multiple possible keys
     */
    private function getValue($row, $keys, $default = null)
    {
        if (!is_array($keys)) {
            $keys = [$keys];
        }

        foreach ($keys as $key) {
            if (isset($row[$key]) && $row[$key] !== '') {
                $value = $row[$key];

                if (is_string($value)) {
                    $value = str_replace('_x000D_', ' ', $value);
                    $value = preg_replace('/\s+/', ' ', $value);
                    $value = trim($value);
                }

                return $value;
            }
        }

        return $default;
    }

    /**
     * Helper khusus untuk membersihkan text rules
     */
    private function cleanRulesText($text)
    {
        if (!is_string($text)) {
            return '';
        }

        // Ganti _x000D_ dengan koma dan spasi
        $text = str_replace('_x000D_', ', ', $text);

        // Hapus karakter break line lainnya
        $text = str_replace(["\r\n", "\r", "\n"], ', ', $text);

        // Hapus titik berlebih setelah "dst"
        $text = str_replace('dst..,', 'dst,', $text);
        $text = str_replace('dst..', 'dst', $text);

        // Hapus spasi berlebih
        $text = preg_replace('/\s+/', ' ', $text);

        // Hapus koma berlebih
        $text = preg_replace('/,+/', ',', $text);

        // Hapus koma di awal atau akhir
        $text = trim($text, ', ');

        // Hapus spasi sebelum koma
        $text = preg_replace('/\s+,/', ',', $text);

        // Tambahkan spasi setelah koma jika tidak ada
        $text = preg_replace('/,(\S)/', ', $1', $text);

        return $text;
    }
}
