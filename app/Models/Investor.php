<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investor extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'name',
        'investment',
        'join_date',
        'profit_share',
        'note',
    ];

    protected $casts = [
        'investment' => 'float',
        'profit_share' => 'float',
        'join_date' => 'date',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function getPercentageAttribute()
    {
        if (!$this->account || !$this->account->investors->sum('investment')) {
            return 0;
        }

        return round(($this->investment / $this->account->investors->sum('investment')) * 100, 2);
    }

    public function getAllocatedProfitAttribute()
    {
        $totalProfit = $this->account ? $this->account->trades->sum('profit_loss') : 0;
        return round(($this->percentage / 100) * $totalProfit, 2);
    }
}
