<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->boolean('mt5_sync_enabled')->default(false)->after('manager_fee_profit_percent');
            $table->string('mt5_server')->nullable()->after('mt5_sync_enabled');
            $table->string('mt5_login')->nullable()->after('mt5_server');
            $table->string('mt5_api_token')->nullable()->after('mt5_login');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn(['mt5_sync_enabled', 'mt5_server', 'mt5_login', 'mt5_api_token']);
        });
    }
};
