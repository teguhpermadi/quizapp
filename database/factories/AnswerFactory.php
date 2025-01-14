<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Answer>
 */
class AnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question_id' => null,
            'answer_text' => fake()->sentence(),
            'is_correct' => fake()->boolean(),
            'image' => fake()->imageUrl(),
            'matching_pair' => null,
            'order_position' => null,
            'metadata' => null,
        ];
    }

    public function multipleChoice()
    {
        return $this->state(fn () => [
            'is_correct' => fake()->boolean(),
        ]);
    }

    public function trueFalse()
    {
        return $this->state(fn () => [
            'answer_text' => fake()->randomElement(['True', 'False']),
            'is_correct' => fake()->boolean(),
        ]);
    }

    public function matching()
    {
        return $this->state(fn () => [
            'matching_pair' => fake()->word(),
        ]);
    }

    public function ordering()
    {
        return $this->state(fn () => [
            'order_position' => fake()->randomDigitNotNull(),
        ]);
    }
}
