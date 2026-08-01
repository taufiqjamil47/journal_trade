<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Symbol;
use App\Models\Trade;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Tests\CreatesApplication;

class TradeBulkDeleteTest extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ],
        ]);

        $this->app['db']->setDefaultConnection('sqlite');

        Schema::dropIfExists('trade_rule');
        Schema::dropIfExists('trades');
        Schema::dropIfExists('symbols');
        Schema::dropIfExists('accounts');
        Schema::dropIfExists('users');

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('initial_balance', 15, 2)->default(0);
            $table->string('currency')->default('USD');
            $table->decimal('commission_per_lot', 10, 2)->default(0);
            $table->decimal('manager_fee_investment_percent', 10, 2)->default(0);
            $table->decimal('manager_fee_profit_percent', 10, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('symbols', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->decimal('pip_value', 10, 6)->default(0.0001);
            $table->integer('pip_position')->default(4);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained()->cascadeOnDelete();
            $table->foreignId('symbol_id')->constrained()->cascadeOnDelete();
            $table->dateTime('timestamp');
            $table->date('date');
            $table->string('type');
            $table->decimal('entry', 15, 5);
            $table->decimal('stop_loss', 15, 5);
            $table->decimal('take_profit', 15, 5);
            $table->decimal('exit', 15, 5)->nullable();
            $table->decimal('sl_pips', 10, 2)->nullable();
            $table->decimal('tp_pips', 10, 2)->nullable();
            $table->decimal('exit_pips', 10, 2)->nullable();
            $table->decimal('risk_usd', 15, 2)->nullable();
            $table->decimal('rr', 8, 2)->nullable();
            $table->decimal('profit_loss', 15, 2)->nullable();
            $table->decimal('risk_percent', 5, 2)->nullable();
            $table->decimal('lot_size', 10, 2)->nullable();
            $table->string('entry_type')->nullable();
            $table->boolean('follow_rules')->default(true);
            $table->text('rules')->nullable();
            $table->text('market_condition')->nullable();
            $table->text('entry_reason')->nullable();
            $table->text('why_sl_tp')->nullable();
            $table->string('entry_emotion')->nullable();
            $table->string('close_emotion')->nullable();
            $table->text('note')->nullable();
            $table->string('before_link')->nullable();
            $table->string('after_link')->nullable();
            $table->string('hasil')->nullable();
            $table->integer('streak_win')->default(0);
            $table->integer('streak_loss')->default(0);
            $table->string('session')->nullable();
            $table->timestamps();
        });

        Schema::create('trade_rule', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trade_id')->constrained()->cascadeOnDelete();
            $table->foreignId('trading_rule_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function test_can_bulk_delete_selected_trades_for_current_account(): void
    {
        $user = User::create([
            'name' => 'Tester',
            'email' => 'tester@example.com',
            'password' => Hash::make('password'),
        ]);

        $account = Account::create([
            'name' => 'Demo Account',
            'initial_balance' => 1000,
            'currency' => 'USD',
        ]);

        $symbol = Symbol::create([
            'name' => 'EURUSD',
            'pip_value' => 0.0001,
            'active' => true,
        ]);

        $tradeOne = Trade::create([
            'account_id' => $account->id,
            'symbol_id' => $symbol->id,
            'timestamp' => now(),
            'date' => now()->toDateString(),
            'type' => 'buy',
            'entry' => 1.1000,
            'stop_loss' => 1.0900,
            'take_profit' => 1.1200,
            'session' => 'London',
        ]);

        $tradeTwo = Trade::create([
            'account_id' => $account->id,
            'symbol_id' => $symbol->id,
            'timestamp' => now()->subHour(),
            'date' => now()->subHour()->toDateString(),
            'type' => 'sell',
            'entry' => 1.1100,
            'stop_loss' => 1.1200,
            'take_profit' => 1.1000,
            'session' => 'New York',
        ]);

        $tradeThree = Trade::create([
            'account_id' => $account->id,
            'symbol_id' => $symbol->id,
            'timestamp' => now()->subHours(2),
            'date' => now()->subHours(2)->toDateString(),
            'type' => 'buy',
            'entry' => 1.1300,
            'stop_loss' => 1.1200,
            'take_profit' => 1.1400,
            'session' => 'London',
        ]);

        $this->actingAs($user)
            ->withSession(['selected_account_id' => $account->id])
            ->deleteJson('/trades/bulk-delete', [
                'trade_ids' => [$tradeOne->id, $tradeThree->id],
            ])
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('deleted_count', 2);

        $this->assertDatabaseMissing('trades', ['id' => $tradeOne->id]);
        $this->assertDatabaseMissing('trades', ['id' => $tradeThree->id]);
        $this->assertDatabaseHas('trades', ['id' => $tradeTwo->id]);
    }
}
