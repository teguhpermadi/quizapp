<?php

namespace Database\Factories;

use App\Models\Exam;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentExamAttempt>
 */
class ExamAttemptFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::role('student')->get()->random()->id,
            'exam_id' => Exam::get()->random()->id,
            'attempt_number' => null,
            'started_at' => now(),
            'ended_at' => null,
            'is_completed' => fake()->boolean(),
        ];
    }
}
