<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('trades', function (Blueprint $table) {
            if (!Schema::hasColumn('trades', 'rules')) {
                $table->text('rules')->nullable()->after('note');
            }
        });
    }

    public function down()
    {
        // Optional: jika ingin rollback
        Schema::table('trades', function (Blueprint $table) {
            $table->dropColumn('rules');
        });
    }
};
