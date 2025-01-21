<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAttempt extends Model
{
    /** @use HasFactory<\Database\Factories\StudentExamAttemptFactory> */
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        'student_id',
        'exam_id',
        'attempt_number',
        'started_at',
        'ended_at',
        'is_completed',
        'is_correction',
        'score',
    ];

    /**
     * Boot method untuk model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Generate attempt_number secara otomatis
            $model->attempt_number = self::where('student_id', $model->student_id)
                ->where('exam_id', $model->exam_id)
                ->max('attempt_number') + 1;
        });
    }

    /**
     * Relasi ke model Student (User).
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Relasi ke model Exam.
     */
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function studentAnswer()
    {
        return $this->hasMany(StudentAnswer::class, 'exam_attempt_id');
    }
}
