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
        Schema::create('paragraph_question', function (Blueprint $table) {
            $table->foreignUlid('paragraph_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid('question_id')->constrained()->cascadeOnDelete();
            $table->primary(['paragraph_id', 'question_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paragraph_question');
    }
};
