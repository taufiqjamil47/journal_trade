<?php

namespace Database\Seeders;

use App\Models\TradingRule;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TradingRulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $rules = [
            ['name' => 'Time 07.00 AM (Forex) - 08.00 AM (Indexs)', 'order' => 1],
            ['name' => 'Menyentuh area POI HTF : OB / FVG / IFVG dst', 'order' => 2],
            ['name' => 'Liquidity Swept : Session High/Low, PDH/PDL, PWH/PWL, Double Top/Bottom', 'order' => 3],
            ['name' => 'Market Structure Shift with Displacement Candle', 'order' => 4],
            ['name' => 'FVG', 'order' => 5],
            ['name' => 'Order Block', 'order' => 6],
            ['name' => 'Breaker Block', 'order' => 7],
            ['name' => 'OTE', 'order' => 8],
            ['name' => 'IFVG', 'order' => 9],
            ['name' => 'CISD', 'order' => 10],
            ['name' => 'Volume Imbalance', 'order' => 11],
            ['name' => 'Rejection Block', 'order' => 12],
            ['name' => 'Liquidity Void', 'order' => 13],
            ['name' => 'Mitigation Block', 'order' => 14],
            ['name' => 'BPR', 'order' => 15],
            // ... tambahkan semua rules
        ];

        foreach ($rules as $rule) {
            TradingRule::create($rule);
        }
    }
}
