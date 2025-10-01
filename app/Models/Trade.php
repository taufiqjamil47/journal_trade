<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Trade extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'symbol_id',
        'timestamp',
        'date',
        'type',
        'entry',
        'stop_loss',
        'take_profit',
        'exit',
        'sl_pips',
        'tp_pips',
        'exit_pips',
        'risk_usd',
        'rr',
        'profit_loss',
        'risk_percent',
        'lot_size',
        'entry_type',
        'follow_rules',
        'rules',
        'market_condition',
        'entry_reason',
        'why_sl_tp',
        'entry_emotion',
        'close_emotion',
        'note',
        'before_link',
        'after_link',
        'hasil',
        'streak_win',
        'streak_loss',
        'session',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function symbol()
    {
        return $this->belongsTo(Symbol::class);
    }

    public function setSessionFromTimestamp()
    {
        $nyTime = Carbon::parse($this->timestamp)->timezone('UTC');
        $hour = (int) $nyTime->format('H');

        foreach (Session::all() as $s) {
            if ($s->start_hour < $s->end_hour) {
                // Range normal (ex: 7–12)
                if ($hour >= $s->start_hour && $hour < $s->end_hour) {
                    $this->session = $s->name;
                    return;
                }
            } else {
                // Range crossing midnight (ex: 20–2)
                if ($hour >= $s->start_hour || $hour < $s->end_hour) {
                    $this->session = $s->name;
                    return;
                }
            }
        }

        $this->session = 'Non-Session';
    }
}
