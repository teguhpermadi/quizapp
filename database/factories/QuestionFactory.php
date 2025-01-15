<?php

namespace Database\Factories;

use App\Enums\QuestionTypeEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question' => fake()->realText(),
            'question_type' => fake()->randomElement(QuestionTypeEnum::class),
            'image' => fake()->imageUrl(),
            'explanation' => fake()->realText(),
            'score' => fake()->numberBetween(1,10),
            'tag' => fake()->word(),
            'timer' => fake()->numberBetween(1000,3000),
            'level' => fake()->randomElement(['easy', 'medium', 'hard']),
            'user_id' => User::role('teacher')->get()->random()->id,
        ];
    }
}
