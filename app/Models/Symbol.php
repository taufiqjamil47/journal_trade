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

    public function getPipValueAttribute($value)
    {
        $value = (float) $value;

        // Pertahankan hardcode hanya untuk Emas/Metal tradisional jika dirasa perlu
        if ($this->isMetalSymbol()) {
            return 1.0;
        }

        // Untuk BTCUSD dan Forex, biarkan menggunakan nilai asli dari database (BTCUSD = 0.1)
        return $value;
    }

    public function getPipWorthAttribute($value)
    {
        // Jika di database null, beri default 10.00 (standar forex)
        $value = (float) ($value ?? 10.00);

        if ($this->isMetalSymbol()) {
            return 100.0;
        }

        // Untuk BTCUSD, biarkan menggunakan nilai asli database (BTCUSD = 0.1)
        return $value;
    }

    /**
     * Khusus untuk rumpun Metal (Emas, Perak, Platina) yang menggunakan standar kontrak komoditas
     */
    protected function isMetalSymbol(): bool
    {
        $name = strtoupper((string) ($this->attributes['name'] ?? ''));

        return str_contains($name, 'XAU')
            || str_contains($name, 'XAG')
            || str_contains($name, 'XPT')
            || str_contains($name, 'XPD');
    }
}
