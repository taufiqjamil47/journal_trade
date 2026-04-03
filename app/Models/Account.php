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
