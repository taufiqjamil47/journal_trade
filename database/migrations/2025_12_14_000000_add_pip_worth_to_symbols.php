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
        Schema::table('symbols', function (Blueprint $table) {
            if (!Schema::hasColumn('symbols', 'pip_worth')) {
                $table->double('pip_worth', 8, 4)->default(10)->after('pip_value');
            }
            if (!Schema::hasColumn('symbols', 'pip_position')) {
                // ensure pip_position exists; keep nullable
                $table->string('pip_position')->nullable()->after('pip_value');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('symbols', function (Blueprint $table) {
            if (Schema::hasColumn('symbols', 'pip_worth')) {
                $table->dropColumn('pip_worth');
            }
        });
    }
};
