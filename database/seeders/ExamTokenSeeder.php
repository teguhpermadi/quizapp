<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\ExamToken;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExamTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exams = Exam::all();

        foreach ($exams as $exam) {
            ExamToken::create([
                'exam_id' => $exam->id,
                'token' => ExamToken::generateToken(),
            ]);
        }
    }
}
