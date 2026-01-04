<?php

namespace App\Exports;

use App\Models\Trade;
use Carbon\Carbon;
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
        // PASTIKAN eager loading untuk tradingRules
        return Trade::with(['symbol', 'tradingRules'])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Symbol',
            'Timestamp',
            'Exit_Timestamp',
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
            'Partial_Close_Percent',
            'Risk_USD',
            'R:R',
            'Lot_Size',
            'PnL',
            'Entry_Type',
            'Follow_Rules',
            'Rules', // Kolom rules sebagai string
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
        // Determine exit timestamp for export
        $exitTimestamp = $trade->exit_timestamp ?? null;
        if (empty($exitTimestamp) && !empty($trade->timestamp)) {
            try {
                $exitTimestamp = Carbon::parse($trade->timestamp)->addHours(3)->format('Y-m-d H:i:s');
            } catch (\Exception $e) {
                $exitTimestamp = null;
            }
        }

        // AMBIL RULES DARI KOLOM DATABASE (bukan dari relationship)
        $rules = $trade->rules; // Ini sudah string karena kita sync

        // Atau jika kolom rules belum diisi, ambil dari relationship
        if (empty($rules) && $trade->relationLoaded('tradingRules')) {
            $rules = $trade->tradingRules->pluck('name')->implode(', ');
        }

        // Pastikan formatnya string biasa, bukan JSON
        if (is_array($rules)) {
            $rules = implode(', ', $rules);
        }

        // Decode JSON jika masih format JSON
        if (str_starts_with($rules, '[') || str_starts_with($rules, '{')) {
            $decoded = json_decode($rules, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                // Jika JSON array, ambil hanya nama rules
                if (isset($decoded[0]['name'])) {
                    $rules = collect($decoded)->pluck('name')->implode(', ');
                } elseif (is_array($decoded)) {
                    $rules = implode(', ', $decoded);
                }
            }
        }

        return [
            $trade->id,
            $trade->symbol_id ? $trade->symbol->name : '',
            $trade->timestamp,
            $exitTimestamp ?? '',
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
            $trade->partial_close_percent ?? '',
            $trade->risk_usd,
            $trade->rr,
            $trade->lot_size,
            $trade->profit_loss,
            $trade->entry_type ?? '',
            $trade->follow_rules ? 'Yes' : 'No',
            $rules ?? '', // Gunakan rules yang sudah di-format
            $trade->market_condition ?? '',
            $trade->entry_reason ?? '',
            $trade->why_sl_tp ?? '',
            $trade->entry_emotion ?? '',
            $trade->close_emotion ?? '',
            $trade->note ?? '',
            $trade->before_link ?? '',
            $trade->after_link ?? '',
            $trade->hasil ?? '',
            $trade->streak_win ?? 0,
            $trade->streak_loss ?? 0,
            $trade->session ?? ''
        ];
    }
}
