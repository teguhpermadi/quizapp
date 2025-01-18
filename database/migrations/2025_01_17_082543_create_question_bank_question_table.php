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
        Schema::create('question_bank_question', function (Blueprint $table) {
            $table->foreignUlid('question_bank_id')->constrained('question_banks')->cascadeOnDelete();
            $table->foreignUlid('question_id')->constrained('questions')->cascadeOnDelete();
            $table->unique(['question_bank_id', 'question_id'], 'question_bank_question_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_bank_question');
    }
};
