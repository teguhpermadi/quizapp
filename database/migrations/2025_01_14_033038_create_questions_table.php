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
        Schema::create('questions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->text('question');
            $table->string('question_type');
            $table->string('image')->nullable();
            $table->integer('score')->default(1);
            $table->json('tag')->nullable();
            $table->time('timer')->default(0);
            $table->string('level')->nullable();
            $table->foreignUlid('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
