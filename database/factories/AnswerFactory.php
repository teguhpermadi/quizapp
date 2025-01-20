<?php

namespace Database\Factories;

use App\Enums\QuestionTypeEnum;
use App\Models\Answer;
use App\Models\Question;
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
        return $this->state(fn() => [
            'is_correct' => fake()->boolean(),
        ]);
    }

    public function trueFalse()
    {
        return $this->state(fn() => [
            'answer_text' => fake()->randomElement(['True', 'False']),
            'is_correct' => fake()->boolean(),
        ]);
    }

    public function matching()
    {
        return $this->afterCreating(function (Answer $answer) {
            // Periksa apakah pasangan sudah ada dan tipe metadata cocok
            if (is_null($answer->matching_pair)) {
                $expectedType = $answer->metadata['type'] === 'domain' ? 'kodomain' : 'domain';

                // Cari jawaban yang belum memiliki pasangan dan memiliki tipe metadata yang sesuai
                $unmatchedAnswer = Answer::where('question_id', $answer->question_id)
                    ->whereNull('matching_pair')
                    ->where('id', '!=', $answer->id)
                    ->where('metadata->type', $expectedType)
                    ->first();

                if ($unmatchedAnswer) {
                    // Pasangkan jawaban dengan pasangan yang ditemukan
                    $unmatchedAnswer->update(['matching_pair' => $answer->id]);
                    $answer->update(['matching_pair' => $unmatchedAnswer->id]);
                }
            }
        });
    }

    public function ordering()
    {
        return $this->state(fn() => [
            'is_correct' => true,
            'order_position' => fake()->randomDigitNotNull(),
        ]);
    }
}
