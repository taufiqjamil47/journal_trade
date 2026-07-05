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
        $value = (float) $value;

        if ($this->isCommoditySymbol()) {
            return 1.0;
        }

        return $value;
    }

    public function getPipWorthAttribute($value)
    {
        $value = (float) ($value ?? 10.00);

        if ($this->isCommoditySymbol()) {
            return 100.0;
        }

        return $value;
    }

    protected function isCommoditySymbol(): bool
    {
        $name = strtoupper((string) ($this->attributes['name'] ?? ''));

        return str_contains($name, 'XAU')
            || str_contains($name, 'XAG')
            || str_contains($name, 'XPT')
            || str_contains($name, 'XPD')
            || str_contains($name, 'BTC');
    }
}
