<?php

namespace Database\Factories;

use App\Models\Answer;
use App\Models\Exam;
use App\Models\Question;
use App\Models\QuestionBank;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentAnswer>
 */
class StudentAnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'exam_id' => Exam::factory(),
            'question_bank_id' => QuestionBank::factory(),
            'question_id' => Question::factory(),
            'answer_id' => Answer::factory(),
            'student_id' => User::factory(),
            'text_answer' => $this->faker->paragraph(),
            'matching_answer' => [
                ['key' => 'A', 'value' => '1'],
                ['key' => 'B', 'value' => '2']
            ], // Contoh jawaban matching
            'ordering_answer' => [1, 2, 3, 4], // Contoh urutan jawaban ordering
            'is_correct' => $this->faker->boolean(),
        ];
    }
}
