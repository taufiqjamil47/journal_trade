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
            if (!Schema::hasColumn('trades', 'mt5_ticket')) {
                $table->string('mt5_ticket')->nullable()->after('exit');
            }
            if (!Schema::hasColumn('trades', 'mt5_comment')) {
                $table->string('mt5_comment')->nullable()->after('mt5_ticket');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trades', function (Blueprint $table) {
            $table->dropColumn(['mt5_ticket', 'mt5_comment']);
        });
    }
};
