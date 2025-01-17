<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuestionBank>
 */
class QuestionBankFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::role('teacher')->get()->random()->id,
            'title' => fake()->sentence(4),
            'image' => fake()->imageUrl(),
            'description' => fake()->paragraph(),
            'tag' => fake()->word(),
        ];
    }
}
