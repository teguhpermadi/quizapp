<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\QuestionBank;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuestionBankQuestion>
 */
class QuestionBankQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question_bank_id' => QuestionBank::get()->random()->id,
            'question_id' => Question::get()->random()->id,
        ];
    }
}
