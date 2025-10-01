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
        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained()->onDelete('cascade');
            $table->foreignId('symbol_id')->constrained()->onDelete('cascade');

            // Form ke-1
            $table->dateTime('timestamp');
            $table->date('date');
            $table->enum('type', ['buy', 'sell']);
            $table->decimal('entry', 15, 5);
            $table->decimal('stop_loss', 15, 5);
            $table->decimal('take_profit', 15, 5);
            $table->decimal('exit', 15, 5)->nullable();

            // Hitungan otomatis
            $table->decimal('sl_pips', 10, 2)->nullable();
            $table->decimal('tp_pips', 10, 2)->nullable();
            $table->decimal('exit_pips', 10, 2)->nullable();
            $table->decimal('risk_usd', 15, 2)->nullable();
            $table->decimal('rr', 8, 2)->nullable();

            // Form ke-2
            $table->decimal('profit_loss', 15, 2)->nullable();
            $table->decimal('risk_percent', 5, 2)->nullable();
            $table->decimal('lot_size', 10, 2)->nullable();
            $table->string('entry_type')->nullable();
            $table->boolean('follow_rules')->default(true);
            $table->text('rules')->nullable();
            $table->text('market_condition')->nullable();
            $table->text('entry_reason')->nullable();
            $table->text('why_sl_tp')->nullable();
            $table->string('entry_emotion')->nullable();
            $table->string('close_emotion')->nullable();
            $table->text('note')->nullable();
            $table->string('before_link')->nullable();
            $table->string('after_link')->nullable();
            $table->enum('hasil', ['win', 'loss', 'be'])->nullable();

            // Statistik tambahan
            $table->integer('streak_win')->default(0);
            $table->integer('streak_loss')->default(0);
            $table->string('session')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trades');
    }
};
