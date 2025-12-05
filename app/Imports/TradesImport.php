<?php

namespace App\Imports;

use App\Models\Trade;
use App\Models\Symbol;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class TradesImport implements ToModel, WithHeadingRow
{
    private $headings = [];

    public function headingRow(): int
    {
        return 1;
    }

    public function onHeadingRow(array $headings)
    {
        // Simpan headings untuk referensi
        $this->headings = $headings;

        // Normalize headings (lowercase, replace spaces)
        $this->headings = array_map(function ($h) {
            return strtolower(str_replace([' ', '_', '-'], '', $h));
        }, $headings);
    }

    public function model(array $row)
    {
        // Normalize row keys untuk matching
        $normalizedRow = [];
        foreach ($row as $key => $value) {
            $normalizedKey = strtolower(str_replace([' ', '_', '-'], '', $key));
            $normalizedRow[$normalizedKey] = $value;
        }

        // Cari symbol dengan berbagai kemungkinan nama kolom
        $symbolValue = null;
        $possibleSymbolKeys = ['symbol', 'symbolid', 'symbolname', 'pair', 'currencypair'];

        foreach ($possibleSymbolKeys as $key) {
            if (isset($normalizedRow[$key]) && !empty($normalizedRow[$key])) {
                $symbolValue = $normalizedRow[$key];
                break;
            }
        }

        if (!$symbolValue) {
            throw new \Exception("Symbol not found in row. Available keys: " . implode(', ', array_keys($normalizedRow)));
        }

        // Cari symbol di database
        $symbol = Symbol::where('name', $symbolValue)->first();

        if (!$symbol) {
            // Jika symbol tidak ditemukan, buat baru atau skip
            // Pilihan 1: Skip dengan error
            throw new \Exception("Symbol '{$symbolValue}' not found in database.");

            // Pilihan 2: Buat otomatis
            // $symbol = Symbol::create([
            //     'name' => $symbolValue,
            //     'pip_value' => 0.0001, // default
            //     'active' => true
            // ]);
        }

        // Convert Excel Date untuk berbagai format
        $date = $this->parseDate($normalizedRow, 'date');
        $time = $this->parseTime($normalizedRow, 'timestamp');

        // Gabung Date + Time
        $timestamp = null;
        if ($date && $time) {
            $timestamp = Carbon::parse("{$date} {$time}")->format('Y-m-d H:i:s');
        } elseif ($date) {
            $timestamp = $date . ' 00:00:00';
        }

        // Convert Yes/No to boolean
        $followRules = $this->parseBoolean($normalizedRow, 'followrules');

        return new Trade([
            'account_id'        => 1,
            'symbol_id'         => $symbol->id,
            'timestamp'         => $timestamp,
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
            'risk_usd'          => $this->getValue($normalizedRow, ['riskusd', 'risk_usd']),
            'rr'                => $this->getValue($normalizedRow, 'rr'),
            'lot_size'          => $this->getValue($normalizedRow, ['lotsize', 'lot_size']),
            'profit_loss'       => $this->getValue($normalizedRow, ['profitloss', 'profit_loss', 'pnl']),
            'entry_type'        => $this->getValue($normalizedRow, ['entrytype', 'entry_type']),
            'follow_rules'      => $followRules,
            'rules'             => $this->getValue($normalizedRow, 'rules'),
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
            // Coba parse sebagai Excel date
            if (is_numeric($value)) {
                return Carbon::instance(ExcelDate::excelToDateTimeObject($value))->format('Y-m-d');
            }

            // Coba parse sebagai string date
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
            // Coba parse sebagai Excel time (fraction of day)
            if (is_numeric($value)) {
                return Carbon::instance(ExcelDate::excelToDateTimeObject($value))->format('H:i:s');
            }

            // Coba parse sebagai string time
            return Carbon::parse($value)->format('H:i:s');
        } catch (\Exception $e) {
            return null;
        }
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
                return $row[$key];
            }
        }

        return $default;
    }
}
