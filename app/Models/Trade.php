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
        'exit_timestamp',
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

    /**
     * Cast attributes to proper types
     */
    protected $casts = [
        'timestamp' => 'datetime',
        'exit_timestamp' => 'datetime',
        'date' => 'date',
        'profit_loss' => 'float',
        'rr' => 'float',
        'lot_size' => 'float',
        'sl_pips' => 'integer',
        'tp_pips' => 'integer',
        'exit_pips' => 'integer',
        'risk_percent' => 'float',
    ];

    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->attributes['date'])->format('d M Y');
    }

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
        // Use application timezone (configurable). Falls back to UTC.
        $appTz = config('app.timezone', 'UTC');
        $tzTime = Carbon::parse($this->timestamp)->setTimezone($appTz);
        $hour = (int) $tzTime->format('H');

        // Cache sessions to prevent N+1 queries
        $sessions = cache()->remember('trading_sessions', 3600, function () {
            return Session::all();
        });

        foreach ($sessions as $s) {
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

    public function scopeBetweenDates($query, $start, $end)
    {
        return $query->whereBetween('date', [$start, $end]);
    }

    public function tradingRules()
    {
        return $this->belongsToMany(TradingRule::class, 'trade_rule')
            ->withTimestamps();
    }

    // Tambahkan accessor untuk backward compatibility
    public function getRulesAttribute()
    {
        return $this->tradingRules ?? collect(); // Kembalikan collection kosong jika null
    }

    /**
     * METHOD UNTUK SYNC PIVOT KE COLUMN (rules)
     */
    public function syncRulesToColumn()
    {
        // Hindari infinite loop
        if ($this->isSyncingRules ?? false) {
            return;
        }

        $this->isSyncingRules = true;

        try {
            // Ambil nama rules dari pivot table
            $ruleNames = $this->tradingRules()
                ->pluck('name')
                ->toArray();

            $rulesString = !empty($ruleNames) ? implode(',', $ruleNames) : null;

            // Update kolom rules TANPA trigger event
            if ($this->rules !== $rulesString) {
                $this->withoutEvents(function () use ($rulesString) {
                    $this->update(['rules' => $rulesString]);
                });
            }
        } finally {
            $this->isSyncingRules = false;
        }

        return $this;
    }

    /**
     * METHOD UNTUK SYNC COLUMN KE PIVOT (reverse)
     */
    public function syncRulesFromColumn()
    {
        if (empty($this->rules)) {
            $this->tradingRules()->detach();
            return $this;
        }

        // Split rules string menjadi array
        $ruleNames = array_map('trim', explode(',', $this->rules));

        // Cari ID rules berdasarkan nama
        $ruleIds = \App\Models\TradingRule::whereIn('name', $ruleNames)
            ->pluck('id')
            ->toArray();

        // Sync ke pivot table
        $this->tradingRules()->sync($ruleIds);

        return $this;
    }

    /**
     * ACCESSOR UNTUK KOMPATIBILITAS
     */
    public function getRulesArrayAttribute()
    {
        if (!empty($this->rules)) {
            return array_map('trim', explode(',', $this->rules));
        }
        return [];
    }

    /**
     * MUTATOR UNTUK RULES
     */
    public function setRulesAttribute($value)
    {
        if (is_array($value)) {
            // Jika value adalah array of IDs (dari form)
            $this->attributes['rules'] = null; // temporary
            // Nanti akan di-sync di controller

        } elseif (is_string($value)) {
            // Jika value adalah string (dari import/old data)
            $this->attributes['rules'] = $value;
        }
    }
}
