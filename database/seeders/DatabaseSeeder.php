<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('accounts')->insert([
            'initial_balance' => 10000.00,
            'currency' => 'USD',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('symbols')->insert([
            'name' => 'GBPUSD',
            'pip_value' => 0.0001,
            'pip_position' => 4,
            'active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('sessions')->insert([
            ['name' => 'Asia',   'start_hour' => 8, 'end_hour' => 12],
            ['name' => 'London', 'start_hour' => 14,  'end_hour' => 17],
            ['name' => 'New York', 'start_hour' => 19, 'end_hour' => 23],
            ['name' => 'Non-Session', 'start_hour' => 1, 'end_hour' => 5],
        ]);
    }
}
