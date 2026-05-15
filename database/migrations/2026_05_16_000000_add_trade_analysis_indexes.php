<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('trades', function (Blueprint $table) {
            if (! $this->indexExists('trades', 'trades_date_index')) {
                $table->index('date', 'trades_date_index');
            }
            if (! $this->indexExists('trades', 'trades_timestamp_index')) {
                $table->index('timestamp', 'trades_timestamp_index');
            }
            if (! $this->indexExists('trades', 'trades_session_index')) {
                $table->index('session', 'trades_session_index');
            }
            if (! $this->indexExists('trades', 'trades_entry_type_index')) {
                $table->index('entry_type', 'trades_entry_type_index');
            }
            if (! $this->indexExists('trades', 'trades_hasil_index')) {
                $table->index('hasil', 'trades_hasil_index');
            }
            if (! $this->indexExists('trades', 'trades_account_date_index')) {
                $table->index(['account_id', 'date'], 'trades_account_date_index');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trades', function (Blueprint $table) {
            if ($this->indexExists('trades', 'trades_date_index')) {
                $table->dropIndex('trades_date_index');
            }
            if ($this->indexExists('trades', 'trades_timestamp_index')) {
                $table->dropIndex('trades_timestamp_index');
            }
            if ($this->indexExists('trades', 'trades_session_index')) {
                $table->dropIndex('trades_session_index');
            }
            if ($this->indexExists('trades', 'trades_entry_type_index')) {
                $table->dropIndex('trades_entry_type_index');
            }
            if ($this->indexExists('trades', 'trades_hasil_index')) {
                $table->dropIndex('trades_hasil_index');
            }
            if ($this->indexExists('trades', 'trades_account_date_index')) {
                $table->dropIndex('trades_account_date_index');
            }
        });
    }

    private function indexExists(string $table, string $indexName): bool
    {
        $result = DB::select(
            'SHOW INDEX FROM `' . $table . '` WHERE Key_name = ?',
            [$indexName]
        );

        return count($result) > 0;
    }
};
