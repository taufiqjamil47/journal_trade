<?php

namespace Tests\Unit;

use App\Models\Account;
use App\Services\Mt5ApiClient;
use PHPUnit\Framework\TestCase;

class Mt5ApiClientTest extends TestCase
{
    public function test_build_trades_url_keeps_existing_trades_path_without_duplicate_suffix(): void
    {
        $account = new Account();
        $account->id = 7;
        $account->mt5_server = 'https://example.com/trades';
        $account->mt5_login = '33730210';

        $client = new Mt5ApiClient();
        $method = new \ReflectionMethod($client, 'buildTradesUrl');
        $method->setAccessible(true);

        $url = $method->invoke($client, $account);

        $this->assertSame('https://example.com/trades?login=33730210', $url);
    }

    public function test_build_trades_url_adds_trades_suffix_for_base_url(): void
    {
        $account = new Account();
        $account->id = 8;
        $account->mt5_server = 'https://example.com';
        $account->mt5_login = '12345';

        $client = new Mt5ApiClient();
        $method = new \ReflectionMethod($client, 'buildTradesUrl');
        $method->setAccessible(true);

        $url = $method->invoke($client, $account);

        $this->assertSame('https://example.com/trades?login=12345', $url);
    }
}
