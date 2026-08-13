<?php

namespace Tests\Unit;

use App\Services\Mt5ApiClient;
use App\Services\Mt5SyncService;
use PHPUnit\Framework\TestCase;

class Mt5SyncServiceTest extends TestCase
{
    public function test_calculate_pips_for_buy_trade(): void
    {
        $service = new Mt5SyncService(new Mt5ApiClient());

        $this->assertSame(100.0, $service->calculatePips(1.1000, 1.0900, 'buy', 0.0001));
        $this->assertSame(50.0, $service->calculatePips(1.1000, 1.0950, 'buy', 0.0001));
    }

    public function test_calculate_pips_for_sell_trade(): void
    {
        $service = new Mt5SyncService(new Mt5ApiClient());

        $this->assertSame(100.0, $service->calculatePips(1.1000, 1.0900, 'sell', 0.0001));
    }
}
