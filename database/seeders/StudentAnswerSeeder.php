<?php

namespace Database\Seeders;

use App\Enums\QuestionTypeEnum;
use App\Models\Exam;
use App\Models\Student;
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
        $students = Student::get();

        $questions = $exam->questionBank->question;

        // setiap student
        foreach ($students as $student) {
            // setiap soal
            foreach ($questions as $question) {

                $answer_id = null;
                $answer_ids = null;
                $text_answer = null;
                $matching_answer = null;
                $ordering_answer = null;

                switch ($question->question_type) {
                    case QuestionTypeEnum::MULTIPLE_CHOICE->value:
                        $answer_id = $question->answer->random()->id;
                        break;

                    case QuestionTypeEnum::MULTIPLE_ANSWER->value:
                        $answer_id = $question->answer->random()->id;
                        break;

                    case QuestionTypeEnum::ESSAY->value:
                        $text_answer = fake()->sentence(3);
                        break;

                    case QuestionTypeEnum::MATCHING->value:
                        // Ambil pasangan domain dan kodomain
                        $domains = $question->answer()
                            ->where('metadata->type', 'domain')
                            ->pluck('id')
                            ->toArray();

                        $kodomains = $question->answer()
                            ->where('metadata->type', 'kodomain')
                            ->pluck('id')
                            ->toArray();

                        // Simulasikan jawaban siswa
                        $studentMatchingAnswer = collect($domains)->mapWithKeys(function ($domain) use ($kodomains) {
                            return [
                                $domain => random_int(0, 1) ? $kodomains[array_rand($kodomains)] : null, // Benar atau salah
                            ];
                        });

                        $matching_answer = $studentMatchingAnswer;
                        break;

                    case QuestionTypeEnum::ORDERING->value:
                        $answers = $question->answer->pluck('id')->toArray();
                        shuffle($answers);
                        $ordering_answer = $answers;
                        break;

                    case QuestionTypeEnum::SHORT_ANSWER->value:
                        $text_answer = fake()->word();
                        break;

                    default:
                        # code...
                        break;
                }

                StudentAnswer::create([
                    'exam_id' => $exam->id,
                    'question_bank_id' => $exam->question_bank_id,
                    // 'exam_attempt_id' => 
                    'question_id' => $question->id,
                    'student_id' => $student->id,
                    'answer_id' => $answer_id,
                    'answer_ids' => $answer_ids,
                    'text_answer' => $text_answer,
                    'matching_answer' => $matching_answer,
                    'ordering_answer' => $ordering_answer,
                    'is_correct' => null, // Evaluasi setelah submit
                    'score' => 0,
                ]);
            }
        }
    }
}
