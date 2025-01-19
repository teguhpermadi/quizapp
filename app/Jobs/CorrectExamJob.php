<?php

namespace App\Jobs;

use App\Models\StudentAnswer;
use App\Models\Answer;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Enums\QuestionTypeEnum;
use Illuminate\Support\Facades\Log;

class CorrectExamJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $examId;

    public function __construct($examId)
    {
        $this->examId = $examId;
    }

    public function handle()
    {
        // Ambil semua jawaban siswa untuk ujian ini
        $studentAnswers = StudentAnswer::where('exam_id', $this->examId)->get();

        foreach ($studentAnswers as $studentAnswer) {
            $question = $studentAnswer->question;

            switch ($question->question_type) {
                case QuestionTypeEnum::MULTIPLE_CHOICE->value:
                    $isCorrect = $this->evaluateMultipleChoice($studentAnswer);
                    break;

                case QuestionTypeEnum::MULTIPLE_ANSWER->value:
                    $isCorrect = $this->evaluateMultipleAnswer($studentAnswer);
                    break;

                case QuestionTypeEnum::TRUE_FALSE->value:
                    $isCorrect = Answer::where('id', $studentAnswer->answer_id)
                        ->value('is_correct') ?? false;
                    break;

                case QuestionTypeEnum::SHORT_ANSWER->value:
                case QuestionTypeEnum::ESSAY->value:
                    $isCorrect = $this->evaluateTextAnswer($studentAnswer->text_answer, $question->correct_answer);
                    break;

                case QuestionTypeEnum::MATCHING->value:
                    $isCorrect = $this->evaluateMatchingAnswer($studentAnswer->matching_answer, $question);
                    break;

                case QuestionTypeEnum::ORDERING->value:
                    $isCorrect = $this->evaluateOrderingAnswer($studentAnswer->ordering_answer, $question);
                    break;

                default:
                    $isCorrect = false;
                    break;
            }

            Log::info("Correcting student answer", ['studentAnswerId' => $studentAnswer->id, 'isCorrect' => $isCorrect]);

            // Update status koreksi
            $studentAnswer->is_correct = $isCorrect;
            $studentAnswer->save();
        }
    }

    private function evaluateMultipleChoice($studentAnswer)
    {
        // Ambil jawaban yang benar untuk pertanyaan
        $correctAnswerId = Answer::where('question_id', $studentAnswer->question_id)
            ->where('is_correct', true)
            ->value('id');

        // Cocokkan jawaban siswa dengan jawaban yang benar
        return $studentAnswer->answer_id == $correctAnswerId;
    }

    private function evaluateMultipleAnswer($studentAnswer)
    {
        // Ambil semua jawaban yang benar untuk pertanyaan
        $correctAnswers = Answer::where('question_id', $studentAnswer->question_id)
            ->where('is_correct', true)
            ->pluck('id')
            ->toArray();

        // Ambil jawaban siswa (sebagai array)
        $studentAnswers = $studentAnswer->answer_ids ? json_decode($studentAnswer->answer_ids, true) : [];

        // Periksa apakah semua jawaban siswa ada di jawaban yang benar
        $isSubset = empty(array_diff($studentAnswers, $correctAnswers));

        // Periksa apakah siswa hanya memilih jawaban yang benar
        $noExtraAnswers = empty(array_diff($correctAnswers, $studentAnswers));

        return $isSubset && $noExtraAnswers;
    }

    private function evaluateTextAnswer($studentAnswer, $correctAnswer)
    {
        return strtolower(trim($studentAnswer)) === strtolower(trim($correctAnswer));
    }

    private function evaluateMatchingAnswer($studentMatching, $question)
    {
        $correctMatching = Answer::where('question_id', $question->id)
            ->pluck('matching_pair', 'id')
            ->toArray();

        return collect($studentMatching)->diffAssoc($correctMatching)->isEmpty();
    }

    private function evaluateOrderingAnswer($studentOrdering, $question)
    {
        $correctOrder = Answer::where('question_id', $question->id)
            ->orderBy('order_position')
            ->pluck('id')
            ->toArray();

        return $studentOrdering === $correctOrder;
    }
}
