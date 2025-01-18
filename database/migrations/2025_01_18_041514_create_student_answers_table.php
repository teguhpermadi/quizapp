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
        Schema::create('student_answers', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('exam_id')->constrained('exams')->cascadeOnDelete();
            $table->foreignUlid('question_bank_id')->constrained('question_banks')->cascadeOnDelete();
            $table->foreignUlid('question_id')->constrained('questions')->cascadeOnDelete();
            $table->foreignUlid('answer_id')->nullable()->constrained('answers')->nullOnDelete();
            $table->foreignUlid('student_id')->constrained('users')->cascadeOnDelete(); // Relasi ke tabel users
            $table->text('text_answer')->nullable(); // Jawaban teks untuk essay atau short answer
            $table->json('matching_answer')->nullable(); // Untuk matching
            $table->json('ordering_answer')->nullable(); // Untuk ordering
            $table->boolean('is_correct')->nullable(); // Apakah jawaban benar
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_answers');
    }
};
