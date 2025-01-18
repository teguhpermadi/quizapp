<?php

namespace Database\Factories;

use App\Models\QuestionBank;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exam>
 */
class ExamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'question_bank_id' => QuestionBank::get()->random()->id,
            'time_limit' => $this->faker->numberBetween(600, 3600), // 10 min to 1 hour
            'start_time' => now()->addDays($this->faker->numberBetween(1, 7)),
            'end_time' => now()->addDays($this->faker->numberBetween(8, 14)),
            'passing_score' => $this->faker->numberBetween(50, 100),
            'max_attempts' => $this->faker->numberBetween(1, 3),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
