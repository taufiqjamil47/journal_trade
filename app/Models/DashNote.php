<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'part_0',
        'part_1_q1',
        'part_1_q2',
        'part_1_q3',
        'part_2_q4',
        'part_2_q5',
        'part_2_q5_text',
        'part_3_q6',
        'part_3_q7',
        'part_3_q8',
        'part_3_q9',
        'part_4_q10',
        'part_4_q11',
        'part_5_text',
        'part_6_q12',
        'part_7_q13',
        'part_7_q13_text',
    ];
}
