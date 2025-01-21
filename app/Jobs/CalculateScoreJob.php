<?php

namespace App\Jobs;

use App\Models\ExamAttempt;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CalculateScoreJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $examId;

    /**
     * Create a new job instance.
     */
    public function __construct($examId)
    {
        $this->examId = $examId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("CalculateScoreJob started for Exam ID: {$this->examId}");

        // ambil semua siswa yang mengikuti ujian ini
        $examAttempts = ExamAttempt::where('exam_id', $this->examId)
            ->where('is_correction', false)
            ->get();

        foreach ($examAttempts as $examAttempt) {
            $score = $examAttempt->studentAnswer->sum('score');

            $scoreMax = $examAttempt->exam->questionBank->question->sum('score');

            // calculate score
            $myScore = ($score / $scoreMax) * 100;

            // update score on examattempt
            $examAttempt->score = $myScore;
            $examAttempt->is_correction = true;
            $examAttempt->save();

            // log
            Log::info("Calculate Score", [
                'student_id' => $examAttempt->student_id,
                'exam_id' => $examAttempt->exam_id,
                'score' => $myScore,
            ]);
        }
    }
}
