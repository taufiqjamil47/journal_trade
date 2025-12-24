<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Symbol extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'pip_value',
        'pip_position',
        'pip_worth',
        'active',
    ];

    public function trades()
    {
        return $this->hasMany(Trade::class);
    }

    // Symbol.php - tambahkan di class
    public function getPipValueAttribute($value)
    {
        // Pastikan format konsisten
        return (float) $value;
    }

    public function getPipWorthAttribute($value)
    {
        return (float) ($value ?? 10.00);
    }
}
