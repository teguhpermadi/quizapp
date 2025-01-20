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
        Schema::create('exam_tokens', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('exam_id')->constrained('exams')->cascadeOnDelete();
            $table->string('token', 6)->unique(); // Token ujian
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_tokens');
    }
};
