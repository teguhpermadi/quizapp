<?php

namespace Database\Seeders;

use App\Enums\QuestionTypeEnum;
use App\Models\Exam;
use App\Models\StudentAnswer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exam = Exam::first();
        $students = User::role('student')->get();

        $questions = $exam->questionBank->question;

        // setiap student
        foreach ($students as $student) {
            // setiap soal
            foreach ($questions as $question) {
                StudentAnswer::create([
                    'exam_id' => $exam->id,
                    'question_bank_id' => $exam->question_bank_id,
                    'question_id' => $question->id,
                    'student_id' => $student->id,
                    'answer_id' => $question->question_type === QuestionTypeEnum::MULTIPLE_CHOICE
                        ? $question->answer->random()->id
                        : null,
                    'text_answer' => $question->question_type === QuestionTypeEnum::ESSAY ? 'Example essay answer' : null,
                    'matching_answer' => $question->question_type === QuestionTypeEnum::MATCHING
                        ? [['key' => 'A', 'value' => '1'], ['key' => 'B', 'value' => '2']]
                        : null,
                    'ordering_answer' => $question->question_type === QuestionTypeEnum::ORDERING
                        ? [1, 3, 2, 4]
                        : null,
                    'is_correct' => null, // Evaluasi setelah submit
                ]);
            }
        }
    }
}
