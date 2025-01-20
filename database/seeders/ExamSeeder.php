<?php

namespace Database\Seeders;

use App\Enums\QuestionTypeEnum;
use App\Models\Answer;
use App\Models\Exam;
use App\Models\Paragraph;
use App\Models\Question;
use App\Models\QuestionBank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questionBank = QuestionBank::factory()
            // multipleChoice
            ->has(Question::factory()
                ->state([
                    'question_type' => QuestionTypeEnum::MULTIPLE_CHOICE,
                ])
                ->has(Paragraph::factory()->count(1))
                ->has(Answer::factory()
                    ->multipleChoice()
                    ->count(1)
                    ->state([
                        'answer_text' => 'key answer',
                        'is_correct' => true
                    ]))
                ->has(Answer::factory()
                    ->multipleChoice()
                    ->count(3)
                    ->state([
                        'is_correct' => false
                    ]))
                ->count(5))

            // multiple answer
            ->has(Question::factory()
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
                ->count(5))

            // true false
            ->has(Question::factory()
                ->state([
                    'question_type' => QuestionTypeEnum::TRUE_FALSE,
                ])
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
                ->count(5))

            // matching
            ->has(Question::factory()
                ->state([
                    'question_type' => QuestionTypeEnum::MATCHING,
                ])
                // setiap generate answer harus selalu 2 pasang
                ->has(Answer::factory()
                    ->state([
                        'metadata' => ['type' => 'domain'],
                    ])
                    ->matching()
                    ->count(3))
                ->has(Answer::factory()
                    ->state([
                        'metadata' => ['type' => 'kodomain'],
                    ])
                    ->matching()
                    ->count(3))
                ->count(5))

            // ordering
            ->has(Question::factory()
                ->state([
                    'question_type' => QuestionTypeEnum::ORDERING,
                ])
                ->has(Answer::factory()
                    ->ordering()
                    ->count(4))
                ->count(5))

            // short answer
            ->has(Question::factory()
                ->state([
                    'question_type' => QuestionTypeEnum::SHORT_ANSWER,
                ])
                ->has(Answer::factory()
                    ->shortAnswer()
                    ->count(3))
                ->count(5))
            
                // create
            ->create();

        $exam = Exam::factory(1)->state([
            'question_bank_id' => $questionBank->id,
        ])->create();
    }
}
