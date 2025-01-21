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
            $table->foreignUlid('exam_attempt_id')->constrained('exam_attempts')->cascadeOnDelete();
            $table->foreignUlid('exam_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid('question_bank_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid('question_id')->constrained()->cascadeOnDelete();
            $table->foreignUlid('student_id')->constrained()->cascadeOnDelete(); // Relasi ke tabel student
            $table->foreignUlid('answer_id')->nullable()->constrained()->nullOnDelete(); // untuk multiple choice, true-false
            $table->json('answer_ids')->nullable();
            $table->text('text_answer')->nullable(); // untuk essay atau short answer
            $table->json('matching_answer')->nullable(); // Untuk matching
            $table->json('ordering_answer')->nullable(); // Untuk ordering
            $table->string('image')->nullable(); // siswa dapat upload image
            $table->string('video')->nullable(); // siswa dapat upload video
            $table->string('audio')->nullable(); // siswa dapat upload audio
            $table->string('is_correct')->nullable(); // Apakah jawaban benar
            $table->float('score')->default(0);
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
