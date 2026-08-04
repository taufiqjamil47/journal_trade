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
        Schema::table('trades', function (Blueprint $table) {
            $table->string('mt5_ticket')->nullable()->after('exit');
            $table->string('mt5_comment')->nullable()->after('mt5_ticket');
            $table->unique(['account_id', 'mt5_ticket'], 'trades_account_ticket_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trades', function (Blueprint $table) {
            $table->dropUnique('trades_account_ticket_unique');
            $table->dropColumn(['mt5_ticket', 'mt5_comment']);
        });
    }
};
