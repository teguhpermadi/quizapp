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
        Schema::create('exam_attempts', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('student_id')->constrained()->cascadeOnDelete(); // Relasi ke tabel pengguna (siswa)
            $table->foreignUlid('exam_id')->constrained('exams')->cascadeOnDelete(); // Relasi ke tabel Exams
            $table->integer('attempt_number')->default(1); // Nomor percobaan
            $table->timestamp('started_at')->nullable(); // Waktu mulai ujian
            $table->timestamp('ended_at')->nullable(); // Waktu selesai ujian
            $table->boolean('is_completed')->default(false); // Status apakah ujian selesai
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_exam_attempts');
    }
};
