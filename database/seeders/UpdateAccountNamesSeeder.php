<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;

class UpdateAccountNamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update atau create accounts dengan nama default jika belum ada
        $account = Account::first();

        if ($account && !$account->name) {
            $account->update([
                'name' => 'Secondary Account',
                'description' => 'Secondary trading account'
            ]);
        } elseif (!$account) {
            // Create first account jika tidak ada
            Account::create([
                'name' => 'Secondary Account',
                'description' => 'Secondary trading account',
                'initial_balance' => 10000,
                'currency' => 'USD',
                'commission_per_lot' => 1.0
            ]);
        }
    }
}
