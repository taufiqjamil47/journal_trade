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
            if (!Schema::hasColumn('accounts', 'mt5_last_sync_at')) {
                $table->timestamp('mt5_last_sync_at')->nullable()->after('mt5_api_token');
            }
            if (!Schema::hasColumn('accounts', 'mt5_last_sync_status')) {
                $table->string('mt5_last_sync_status')->nullable()->after('mt5_last_sync_at');
            }
            if (!Schema::hasColumn('accounts', 'mt5_last_sync_message')) {
                $table->text('mt5_last_sync_message')->nullable()->after('mt5_last_sync_status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn(['mt5_last_sync_at', 'mt5_last_sync_status', 'mt5_last_sync_message']);
        });
    }
};
