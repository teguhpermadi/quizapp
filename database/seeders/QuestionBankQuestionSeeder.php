<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\QuestionBank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionBankQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questionBank = QuestionBank::factory(3)->create();
        $questionBank->each(function($questionBank){
            $questions = Question::factory(10)->create();
            foreach ($questions as $question) {
                $questionBank->question()->attach($question->id);
            }
        });
    }
}
