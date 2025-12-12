<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trades', function (Blueprint $table) {
            if (!Schema::hasColumn('trades', 'exit_timestamp')) {
                $table->dateTime('exit_timestamp')->nullable()->after('exit');
            }
        });
    }

    public function down(): void
    {
        Schema::table('trades', function (Blueprint $table) {
            if (Schema::hasColumn('trades', 'exit_timestamp')) {
                $table->dropColumn('exit_timestamp');
            }
        });
    }
};
