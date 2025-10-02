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
            ['name' => 'Asia',   'start_hour' => 20, 'end_hour' => 2],
            ['name' => 'London', 'start_hour' => 2,  'end_hour' => 7],
            ['name' => 'New York', 'start_hour' => 7, 'end_hour' => 12],
            ['name' => 'Non-Session', 'start_hour' => 13, 'end_hour' => 19],
        ];

        foreach ($sessions as $s) {
            Session::create($s);
        }
    }
}
