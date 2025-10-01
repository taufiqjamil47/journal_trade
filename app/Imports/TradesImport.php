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

    public function headingRow(): int
    {
        return 1; // row pertama dianggap header
    }

    public function model(array $row)
    {

        $symbol = Symbol::where('name', $row['symbol'])->first();

        // Convert Excel Date
        $date = null;
        if (!empty($row['date'])) {
            $date = Carbon::instance(ExcelDate::excelToDateTimeObject($row['date']))->format('Y-m-d');
        }

        // Convert Excel Time (fraction of day)
        $time = null;
        if (!empty($row['timestamp'])) {
            $time = Carbon::instance(ExcelDate::excelToDateTimeObject($row['timestamp']))->format('H:i:s');
        }

        // Gabung Date + Time
        $timestamp = null;
        if ($date && $time) {
            $timestamp = Carbon::parse("{$date} {$time}")->format('Y-m-d H:i:s');
        }

        // Convert Yes/No to boolean
        $followRules = null;
        if (!empty($row['follow_rules'])) {
            $value = strtolower(trim($row['follow_rules']));
            $followRules = ($value === 'yes' || $value === '1') ? 1 : 0;
        }
        return new Trade([
            'id'                => $row['no'],
            'account_id'        => 1, // or Auth::user()->account_id
            'symbol_id'         => $symbol ? $symbol->id : null, // map name → id
            'timestamp'         => $timestamp,
            'date'              => $date,
            'type'              => $row['type'],
            'entry'             => $row['entry'],
            'stop_loss'         => $row['sl'],
            'sl_pips'           => $row['slpips'],
            'take_profit'       => $row['tp'],
            'tp_pips'           => $row['tppips'],
            'exit'              => $row['exit'],
            'exit_pips'         => $row['exitpips'],
            'risk_percent'      => $row['risk_percent'],
            'risk_usd'          => $row['riskusd'],
            'rr'                => $row['rr'],
            'lot_size'          => $row['lot_size'],
            'profit_loss'       => $row['profit_loss'],
            'entry_type'        => $row['entry_type'],
            'follow_rules'      => $followRules,
            'rules'             => $row['rules'],
            'market_condition'  => $row['market_condition'],
            'entry_reason'      => $row['entry_reason'],
            'why_sl_tp'         => $row['why_sl_tp'],
            'entry_emotion'     => $row['entry_emotion'],
            'close_emotion'     => $row['close_emotion'],
            'note'              => $row['note'],
            'before_link'       => $row['before'],
            'after_link'        => $row['after'],
            'hasil'             => $row['hasil'],
            'streak_win'        => $row['streak_win'],
            'streak_loss'       => $row['streak_loss'],
            'session'           => $row['session'],
        ]);
    }
}
