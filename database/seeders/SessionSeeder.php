<?php

namespace Database\Seeders;

use App\Models\Session;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $sessions = [
            ['name' => 'Asia',   'start_hour' => 20, 'end_hour' => 2],
            ['name' => 'London', 'start_hour' => 2,  'end_hour' => 7],
            ['name' => 'New York', 'start_hour' => 7, 'end_hour' => 12],
        ];

        foreach ($sessions as $s) {
            Session::create($s);
        }
    }
}
