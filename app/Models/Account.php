<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
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
}
