<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentAnswer extends Model
{
    /** @use HasFactory<\Database\Factories\StudentAnswerFactory> */
    use HasFactory;
    use HasUlids;
    use SoftDeletes;

    protected $fillable = [
        'exam_id',
        'question_bank_id',
        'question_id',
        'student_id',
        'answer_id',
        'text_answer', // Jawaban siswa dalam bentuk teks (untuk essay atau short answer).
        'matching_answer', // untuk jawaban dengan tipe soal matching
        'ordering_answer', // untuk jawaban dengan tipe soal ordering
        'is_correct',
    ];

    protected $casts = [
        'matching_answer' => 'array', // Cast JSON ke array
        'ordering_answer' => 'array', // Cast JSON ke array
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function questionBank()
    {
        return $this->belongsTo(QuestionBank::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
