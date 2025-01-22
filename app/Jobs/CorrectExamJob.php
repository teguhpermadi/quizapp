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
use App\Enums\CorrectStatusEnum;
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
        Log::info("CorrectExamJob started for Exam ID: {$this->examId}");

        // Ambil semua jawaban siswa untuk ujian ini
        $studentAnswers = StudentAnswer::where('exam_id', $this->examId)->get();
        Log::info("data: {$studentAnswers}");

        foreach ($studentAnswers as $studentAnswer) {
            $question = $studentAnswer->question;
            $score = 0; // Default score
            $isCorrect = CorrectStatusEnum::FALSE->value; // Default correctness

            switch ($question->question_type) {
                case QuestionTypeEnum::MULTIPLE_CHOICE->value:
                    [$score, $isCorrect] = $this->evaluateMultipleChoice($studentAnswer);
                    break;

                case QuestionTypeEnum::MULTIPLE_ANSWER->value:
                    [$score, $isCorrect] = $this->evaluateMultipleAnswer($studentAnswer, $question->score);
                    break;

                case QuestionTypeEnum::TRUE_FALSE->value:
                    [$score, $isCorrect] = $this->evaluateTrueFalse($studentAnswer, $question->score);
                    break;

                case QuestionTypeEnum::SHORT_ANSWER->value:
                case QuestionTypeEnum::ESSAY->value:
                    [$score, $isCorrect] = $this->evaluateTextAnswer($studentAnswer->text_answer, $question->correct_answer, $question->score);
                    break;

                case QuestionTypeEnum::MATCHING->value:
                    [$score, $isCorrect] = $this->evaluateMatchingAnswer($studentAnswer->matching_answer, $question);
                    break;

                case QuestionTypeEnum::ORDERING->value:
                    [$score, $isCorrect] = $this->evaluateOrderingAnswer($studentAnswer->ordering_answer, $question);
                    break;

                case QuestionTypeEnum::SHORT_ANSWER->value:
                    [$score, $isCorrect] = $this->evaluateShortAnswer($studentAnswer->text_answer, $question);
                    break;

                default:
                    $score = 0;
                    $isCorrect = CorrectStatusEnum::FALSE->value;
                    break;
            }

            // Update skor dan status koreksi
            $studentAnswer->score = $score;
            $studentAnswer->is_correct = $isCorrect;
            $studentAnswer->save();

            // Log hasil koreksi untuk setiap siswa
            Log::info("Student Answer Corrected", [
                'student_id' => $studentAnswer->student_id,
                'question_id' => $studentAnswer->question_id,
                'is_correct' => $isCorrect,
                'score' => $score,
            ]);
        }

        Log::info("CorrectExamJob completed for Exam ID: {$this->examId}");
    }

    private function evaluateMultipleChoice($studentAnswer)
    {
        $correctAnswerId = Answer::where('question_id', $studentAnswer->question_id)
            ->where('is_correct', true)
            ->value('id');

        $isCorrect = $studentAnswer->answer_id == $correctAnswerId ? CorrectStatusEnum::TRUE->value : CorrectStatusEnum::FALSE->value;
        $score = $isCorrect === CorrectStatusEnum::TRUE->value ? $studentAnswer->question->score : 0;

        return [$score, $isCorrect];
    }

    private function evaluateMultipleAnswer($studentAnswer, $totalScore)
    {
        $correctAnswers = Answer::where('question_id', $studentAnswer->question_id)
            ->where('is_correct', true)
            ->pluck('id')
            ->toArray();

        $studentAnswers = $studentAnswer->answer_ids ?? [];

        // Hitung skor berdasarkan jawaban yang benar
        $correctCount = count(array_intersect($studentAnswers, $correctAnswers));
        $totalCorrect = count($correctAnswers);

        $score = ($correctCount / $totalCorrect) * $totalScore;

        if ($correctCount === $totalCorrect) {
            $isCorrect = CorrectStatusEnum::TRUE->value;
        } elseif ($correctCount > 0) {
            $isCorrect = CorrectStatusEnum::PARTIAL->value;
        } else {
            $isCorrect = CorrectStatusEnum::FALSE->value;
        }

        return [$score, $isCorrect];
    }

    private function evaluateTrueFalse($studentAnswer, $totalScore)
    {
        $isCorrect = Answer::where('id', $studentAnswer->answer_id)
            ->value('is_correct') ? CorrectStatusEnum::TRUE->value : CorrectStatusEnum::FALSE->value;

        $score = $isCorrect === CorrectStatusEnum::TRUE->value ? $totalScore : 0;

        return [$score, $isCorrect];
    }

    private function evaluateTextAnswer($studentAnswer, $correctAnswer, $totalScore)
    {
        $isCorrect = strtolower(trim($studentAnswer)) === strtolower(trim($correctAnswer)) ? CorrectStatusEnum::TRUE->value : CorrectStatusEnum::FALSE->value;
        $score = $isCorrect === CorrectStatusEnum::TRUE->value ? $totalScore : 0;

        return [$score, $isCorrect];
    }

    private function evaluateMatchingAnswer($studentMatching, $question)
    {
        // Ambil pasangan kunci jawaban dari kolom `metadata`
        $domains = Answer::where('question_id', $question->id)
            ->where('metadata->type', 'domain')
            ->pluck('matching_pair', 'id')
            ->toArray();

        $kodomains = Answer::where('question_id', $question->id)
            ->where('metadata->type', 'kodomain')
            ->pluck('id')
            ->toArray();

        // Hitung jumlah pasangan yang benar
        $correctCount = 0;
        foreach ($studentMatching as $key => $value) {
            if (isset($domains[$key]) && in_array($value, $kodomains) && $domains[$key] === $value) {
                $correctCount++;
            }
        }

        // Hitung total pasangan domain
        $totalDomains = count($domains);
        $score = ($correctCount / $totalDomains) * $question->score;

        // Tentukan status koreksi
        if ($correctCount === $totalDomains) {
            $isCorrect = CorrectStatusEnum::TRUE->value;
        } elseif ($correctCount > 0) {
            $isCorrect = CorrectStatusEnum::PARTIAL->value;
        } else {
            $isCorrect = CorrectStatusEnum::FALSE->value;
        }

        return [$score, $isCorrect];
    }

    private function evaluateOrderingAnswer($studentOrdering, $question)
    {
        $correctOrder = Answer::where('question_id', $question->id)
            ->orderBy('order_position')
            ->pluck('id')
            ->toArray();

        $correctCount = 0;
        foreach ($studentOrdering as $index => $answerId) {
            if (isset($correctOrder[$index]) && $correctOrder[$index] == $answerId) {
                $correctCount++;
            }
        }

        $totalCorrect = count($correctOrder);
        $score = ($correctCount / $totalCorrect) * $question->score;

        if ($correctCount === $totalCorrect) {
            $isCorrect = CorrectStatusEnum::TRUE->value;
        } elseif ($correctCount > 0) {
            $isCorrect = CorrectStatusEnum::PARTIAL->value;
        } else {
            $isCorrect = CorrectStatusEnum::FALSE->value;
        }

        return [$score, $isCorrect];
    }

    private function evaluateShortAnswer($studentAnswer, $question)
    {
        // Ambil semua jawaban yang benar untuk soal ini
        $correctAnswers = Answer::where('question_id', $question->id)
            ->pluck('answer_text')
            ->map(fn($text) => strtolower(trim($text)))
            ->toArray();

        // Normalisasi jawaban siswa
        $normalizedStudentAnswer = strtolower(trim($studentAnswer));

        // Periksa apakah jawaban siswa ada dalam daftar jawaban benar
        $isCorrect = in_array($normalizedStudentAnswer, $correctAnswers)
            ? CorrectStatusEnum::TRUE->value
            : CorrectStatusEnum::FALSE->value;

        // Hitung skor
        $score = $isCorrect === CorrectStatusEnum::TRUE->value ? $question->score : 0;

        return [$score, $isCorrect];
    }
}
