<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            // UserSeeder::class,
            TeacherSeeder::class,
            StudentSeeder::class,
            GradeSeeder::class,
            // QuestionSeeder::class,
            // AnswerSeeder::class,
            // ParagraphSeeder::class,
            // QuestionBankSeeder::class,
            // QuestionBankQuestionSeeder::class,
            ExamSeeder::class,
            ExamTokenSeeder::class,
            // StudentAnswerSeeder::class,
            ExamAttemptSeeder::class,
        ]);
    }
}
