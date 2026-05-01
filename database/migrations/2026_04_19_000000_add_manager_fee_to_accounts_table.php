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
            $table->decimal('manager_fee_investment_percent', 5, 2)->default(0)->after('commission_per_lot');
            $table->decimal('manager_fee_profit_percent', 5, 2)->default(0)->after('manager_fee_investment_percent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn(['manager_fee_investment_percent', 'manager_fee_profit_percent']);
        });
    }
};
