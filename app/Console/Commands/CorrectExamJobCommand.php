<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\CorrectExamJob;

class CorrectExamJobCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exam:correct {exam_id? : The ID of the exam to correct}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch a job to correct all answers for a specific exam';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $examId = $this->argument('exam_id');

        // Prompt for exam_id if not provided
        if (!$examId) {
            $examId = $this->ask('Please provide the Exam ID');
        }

        // Dispatch the CorrectExamJob
        CorrectExamJob::dispatch($examId);

        $this->info("CorrectExamJob dispatched for Exam ID: $examId");

        return Command::SUCCESS;
    }
}
