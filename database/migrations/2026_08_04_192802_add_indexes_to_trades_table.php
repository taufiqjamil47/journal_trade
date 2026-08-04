<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trades', function (Blueprint $table) {
            $table->index(['account_id', 'mt5_ticket']);
            $table->index(['account_id', 'symbol_id', 'timestamp']);
        });
    }

    public function down(): void
    {
        Schema::table('trades', function (Blueprint $table) {
            $table->dropIndex(['account_id', 'mt5_ticket']);
            $table->dropIndex(['account_id', 'symbol_id', 'timestamp']);
        });
    }
};
