<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds database indexes to optimize frequently queried columns
     * and prevent N+1 query problems
     */
    public function up(): void
    {
        // Helper: add index only if it doesn't exist
        $addIfNotExists = function (string $table, string $indexName, callable $callback) {
            $exists = DB::select("SHOW INDEX FROM `{$table}` WHERE Key_name = ?", [$indexName]);
            if (empty($exists)) {
                Schema::table($table, $callback);
            }
        };

        // Trades indexes
        $addIfNotExists('trades', 'trades_account_id_index', function (Blueprint $table) {
            $table->index('account_id');
        });
        $addIfNotExists('trades', 'trades_symbol_id_index', function (Blueprint $table) {
            $table->index('symbol_id');
        });
        $addIfNotExists('trades', 'trades_date_index', function (Blueprint $table) {
            $table->index('date');
        });
        $addIfNotExists('trades', 'trades_timestamp_index', function (Blueprint $table) {
            $table->index('timestamp');
        });
        $addIfNotExists('trades', 'trades_session_index', function (Blueprint $table) {
            $table->index('session');
        });
        $addIfNotExists('trades', 'trades_entry_type_index', function (Blueprint $table) {
            $table->index('entry_type');
        });
        $addIfNotExists('trades', 'trades_hasil_index', function (Blueprint $table) {
            $table->index('hasil');
        });
        $addIfNotExists('trades', 'trades_exit_index', function (Blueprint $table) {
            $table->index('exit');
        });

        // Composite indexes - give explicit names to avoid DB-generated name collisions
        $addIfNotExists('trades', 'trades_account_id_id_index', function (Blueprint $table) {
            $table->index(['account_id', 'id']);
        });
        $addIfNotExists('trades', 'trades_account_id_exit_index', function (Blueprint $table) {
            $table->index(['account_id', 'exit']);
        });
        $addIfNotExists('trades', 'trades_date_symbol_id_index', function (Blueprint $table) {
            $table->index(['date', 'symbol_id']);
        });

        // Symbols
        $addIfNotExists('symbols', 'symbols_active_index', function (Blueprint $table) {
            $table->index('active');
        });
        $addIfNotExists('symbols', 'symbols_name_index', function (Blueprint $table) {
            $table->index('name');
        });

        // Trading rules
        $addIfNotExists('trading_rules', 'trading_rules_is_active_index', function (Blueprint $table) {
            $table->index('is_active');
        });
        $addIfNotExists('trading_rules', 'trading_rules_order_index', function (Blueprint $table) {
            $table->index('order');
        });

        // Sessions
        $addIfNotExists('sessions', 'sessions_name_index', function (Blueprint $table) {
            $table->index('name');
        });

        // Accounts - HAPUS BAGIAN INI karena tidak ada kolom 'name'
        // $addIfNotExists('accounts', 'accounts_name_index', function (Blueprint $table) {
        //     $table->index('name');
        // });

        // Jika ingin menambahkan indeks untuk kolom yang ada di tabel accounts:
        // $addIfNotExists('accounts', 'accounts_currency_index', function (Blueprint $table) {
        //     $table->index('currency'); // Kolom ini ada berdasarkan struktur
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $dropIfExists = function (string $table, string $indexName) {
            $exists = DB::select("SHOW INDEX FROM `{$table}` WHERE Key_name = ?", [$indexName]);
            if (!empty($exists)) {
                DB::statement("ALTER TABLE `{$table}` DROP INDEX `{$indexName}`");
            }
        };

        // Trades
        $dropIfExists('trades', 'trades_account_id_index');
        $dropIfExists('trades', 'trades_symbol_id_index');
        $dropIfExists('trades', 'trades_date_index');
        $dropIfExists('trades', 'trades_timestamp_index');
        $dropIfExists('trades', 'trades_session_index');
        $dropIfExists('trades', 'trades_entry_type_index');
        $dropIfExists('trades', 'trades_hasil_index');
        $dropIfExists('trades', 'trades_exit_index');
        $dropIfExists('trades', 'trades_account_id_id_index');
        $dropIfExists('trades', 'trades_account_id_exit_index');
        $dropIfExists('trades', 'trades_date_symbol_id_index');

        // Symbols
        $dropIfExists('symbols', 'symbols_active_index');
        $dropIfExists('symbols', 'symbols_name_index');

        // Trading rules
        $dropIfExists('trading_rules', 'trading_rules_is_active_index');
        $dropIfExists('trading_rules', 'trading_rules_order_index');

        // Sessions
        $dropIfExists('sessions', 'sessions_name_index');

        // Accounts - HAPUS BAGIAN INI juga
        // $dropIfExists('accounts', 'accounts_name_index');
    }
};
