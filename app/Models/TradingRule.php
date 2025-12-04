<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TradingRule extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    /**
     * RELASI KE TRADES
     */
    public function trades()
    {
        return $this->belongsToMany(Trade::class, 'trade_rule')
            ->withTimestamps();
    }

    /**
     * EVENT: Update semua trades yang menggunakan rule ini
     * ketika nama rule diubah
     */
    protected static function booted()
    {
        static::updated(function ($rule) {
            if ($rule->isDirty('name')) {
                // Update semua trades yang menggunakan rule ini
                $rule->trades()->each(function ($trade) {
                    $trade->syncRulesToColumn();
                });
            }
        });
    }
}
