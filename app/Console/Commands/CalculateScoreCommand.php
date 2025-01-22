<?php

namespace App\Console\Commands;

use App\Jobs\CalculateScoreJob;
use Illuminate\Console\Command;

class CalculateScoreCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exam:scoring {exam_id? : The ID of the exam to scoring}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch a job to calculate score all answers for a specific exam';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $examId = $this->argument('exam_id') ?: $this->ask('Please provide the Exam ID');

        // Dispatch the CorrectExamJob
        CalculateScoreJob::dispatch($examId);

        $this->info("CorrectExamJob dispatched for Exam ID: $examId");

        return Command::SUCCESS;
    }
}
