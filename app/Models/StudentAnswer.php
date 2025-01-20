<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class StudentAnswer extends Model
{
    /** @use HasFactory<\Database\Factories\StudentAnswerFactory> */
    use HasFactory;
    use HasUlids;
    use SoftDeletes;
    use HasJsonRelationships;


    protected $fillable = [
        'attempt_id',
        'exam_id',
        'question_bank_id',
        'question_id',
        'student_id',
        'answer_id', // multiple choice dan true false
        'answer_ids',   // Untuk multiple answer
        'text_answer', // Jawaban siswa dalam bentuk teks (untuk essay atau short answer).
        'matching_answer', // untuk jawaban dengan tipe soal matching
        'ordering_answer', // untuk jawaban dengan tipe soal ordering
        'image',
        'video',
        'audio',
        'is_correct',
        'score',
    ];

    protected $casts = [
        'answer_ids' => 'array', // Konversi JSON menjadi array
        'matching_answer' => 'array', // Cast JSON ke array
        'ordering_answer' => 'array', // Cast JSON ke array
    ];

    public function attempt()
    {
        return $this->belongsTo(StudentAttempt::class, 'attempt_id');
    }

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

    public function answers()
    {
        return $this->belongsToJson(Answer::class, 'answer_ids');        
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
