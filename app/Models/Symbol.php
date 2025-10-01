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
        'active',
    ];

    public function trades()
    {
        return $this->hasMany(Trade::class);
    }
}
