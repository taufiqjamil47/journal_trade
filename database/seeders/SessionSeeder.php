<?php

namespace Database\Seeders;

use App\Models\Session;
use Illuminate\Database\Seeder;

class SessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $sessions = [
            ['name' => 'Asia',   'start_hour' => 8, 'end_hour' => 12],
            ['name' => 'London', 'start_hour' => 14,  'end_hour' => 17],
            ['name' => 'New York', 'start_hour' => 19, 'end_hour' => 23],
            ['name' => 'Non-Session', 'start_hour' => 1, 'end_hour' => 5],
        ];

        foreach ($sessions as $s) {
            Session::create($s);
        }
    }
}
