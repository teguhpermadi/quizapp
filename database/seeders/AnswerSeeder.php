<?php

namespace Database\Seeders;

use App\Enums\QuestionTypeEnum;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // multiple choice
        Question::factory()
            ->state([
                'question_type' => QuestionTypeEnum::MULTIPLE_CHOICE,
            ])
            ->has(Answer::factory()
                ->multipleChoice()
                ->count(1)
                ->state([
                    'is_correct' => true
                ]))
            ->has(Answer::factory()
                ->multipleChoice()
                ->count(3)
                ->state([
                    'is_correct' => false
                ]))
            ->count(5)
            ->create();


        // multiple answers
        Question::factory()
            ->state([
                'question_type' => QuestionTypeEnum::MULTIPLE_ANSWER,
            ])
            ->has(Answer::factory()
                ->multipleChoice()
                ->count(2)
                ->state([
                    'is_correct' => true
                ]))
            ->has(Answer::factory()
                ->multipleChoice()
                ->count(2)
                ->state([
                    'is_correct' => false
                ]))
            ->count(5)
            ->create();

        // true false
        Question::factory()
            ->has(Answer::factory()
                ->trueFalse()
                ->state([
                    'answer_text' => 'True',
                    'is_correct' => true
                ])
                ->count(1))
            ->has(Answer::factory()
                ->trueFalse()
                ->state([
                    'answer_text' => 'False',
                    'is_correct' => false
                ])
                ->count(1))
            ->count(5)
            ->create();

        // matching
        Question::factory()
            ->has(Answer::factory()
                ->matching()
                ->count(4))
            ->count(5)
            ->create();

        // ordering
        Question::factory()
            ->has(Answer::factory()
                ->ordering()
                ->count(4))
            ->count(5)
            ->create();
    }
}
