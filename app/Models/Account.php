<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'initial_balance',
        'currency',
        'commission_per_lot',
        'manager_fee_investment_percent',
        'manager_fee_profit_percent',
        'mt5_sync_enabled',
        'mt5_server',
        'mt5_login',
        'mt5_api_token',
        'mt5_last_sync_at',
        'mt5_last_sync_status',
        'mt5_last_sync_message',
    ];

    protected $casts = [
        'mt5_sync_enabled' => 'boolean',
        'mt5_last_sync_at' => 'datetime',
    ];

    public function trades()
    {
        return $this->hasMany(Trade::class);
    }

    public function metrics()
    {
        return $this->hasMany(Metric::class);
    }

    public function investors()
    {
        return $this->hasMany(Investor::class);
    }

    public function getTotalInvestorInvestmentAttribute()
    {
        return $this->investors->sum('investment');
    }

    public function getTotalProfitAttribute()
    {
        return $this->trades->sum('profit_loss');
    }
}
