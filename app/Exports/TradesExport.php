<?php

namespace App\Exports;

use App\Models\Trade;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TradesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Trade::with('symbol')->get();
        // return Trade::all([
        //     'id',
        //     'symbol_id',
        //     'timestamp',
        //     'date',
        //     'type',
        //     'entry',
        //     'stop_loss',
        //     'sl_pips',
        //     'take_profit',
        //     'tp_pips',
        //     'exit',
        //     'exit_pips',
        //     'risk_percent',
        //     'risk_usd',
        //     'rr',
        //     'lot_size',
        //     'profit_loss',
        //     'entry_type',
        //     'follow_rules',
        //     'rules',
        //     'market_condition',
        //     'entry_reason',
        //     'why_sl_tp',
        //     'entry_emotion',
        //     'close_emotion',
        //     'note',
        //     'before_link',
        //     'after_link',
        //     'hasil',
        //     'streak_win',
        //     'streak_loss',
        //     'session',
        // ]);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Symbol ID',
            'Timestamp',
            'Date',
            'Type',
            'Entry',
            'Stop_Loss',
            'SL_pips',
            'Take_Profit',
            'TP_pips',
            'Exit',
            'Exit_pips',
            'Risk_Percent',
            'Risk_USD',
            'R:R',
            'Lot_Size',
            'PnL',
            'Entry_Type',
            'Follow_Rules',
            'Rules',
            'Market_Condition',
            'Entry_Reason',
            'Why_sl_tp ?',
            'Entry_Emotion',
            'Close_Emotion',
            'Note',
            'Before_Link',
            'After_Link',
            'Hasil',
            'Streak_Win',
            'Streak_Loss',
            'Session',
        ];
    }

    public function map($trade): array
    {
        return [
            $trade->id,
            $trade->symbol_id ? $trade->symbol->name : '', // <-- pake nama, bukan ID
            $trade->timestamp,
            $trade->date,
            $trade->type,
            $trade->entry,
            $trade->stop_loss,
            $trade->sl_pips,
            $trade->take_profit,
            $trade->tp_pips,
            $trade->exit,
            $trade->exit_pips,
            $trade->risk_percent,
            $trade->risk_usd,
            $trade->rr,
            $trade->lot_size,
            $trade->profit_loss,
            $trade->entry_type,
            $trade->follow_rules,
            $trade->rules,
            $trade->market_condition,
            $trade->entry_reason,
            $trade->why_sl_tp,
            $trade->entry_emotion,
            $trade->close_emotion,
            $trade->note,
            $trade->before_link,
            $trade->after_link,
            $trade->hasil,
            $trade->streak_win,
            $trade->streak_loss,
            $trade->session
        ];
    }
}
