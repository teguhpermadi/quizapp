<?php

namespace Database\Seeders;

use App\Models\Paragraph;
use App\Models\ParagraphQuestion;
use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParagraphSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paragraphs = Paragraph::factory(3)->create();
        $paragraphs->each(function($paragraph){
            $questions = Question::get()->random(rand(1, 5))->pluck('id')->toArray();
            $paragraph->question()->attach($questions);
        });
    }
}
