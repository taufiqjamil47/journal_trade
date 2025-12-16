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
        Schema::create('dash_notes', function (Blueprint $table) {
            $table->id();
            $table->text('part_0')->nullable(); // Aturan Meta
            $table->string('part_1_q1')->nullable(); // Status Internal
            $table->string('part_1_q2')->nullable();
            $table->integer('part_1_q3')->nullable();
            $table->string('part_2_q4')->nullable(); // Reaksi Market
            $table->string('part_2_q5')->nullable();
            $table->text('part_2_q5_text')->nullable();
            $table->boolean('part_3_q6')->nullable(); // Gerbang Anti-Ego
            $table->boolean('part_3_q7')->nullable();
            $table->boolean('part_3_q8')->nullable();
            $table->boolean('part_3_q9')->nullable();
            $table->string('part_4_q10')->nullable(); // Keputusan Sadar
            $table->string('part_4_q11')->nullable();
            $table->text('part_5_text')->nullable(); // Catatan Ego
            $table->boolean('part_6_q12')->nullable(); // Pembongkar Ilusi
            $table->boolean('part_7_q13')->nullable(); // Penutup Wajib
            $table->text('part_7_q13_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dash_notes');
    }
};
