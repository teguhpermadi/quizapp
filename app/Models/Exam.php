<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
    /** @use HasFactory<\Database\Factories\ExamFactory> */
    use HasFactory;
    use SoftDeletes;
    use HasUlids;

    protected $fillable = [
        'title',
        'description',
        'question_bank_id',
        'time_limit',
        'start_time',
        'end_time',
        'passing_score',
        'max_attempts',
        'is_active',
    ];

    public function questionBank()
    {
        return $this->belongsTo(QuestionBank::class);
    }

    public function studentAnswer()
    {
        return $this->hasMany(StudentAnswer::class);
    }

    public function examAttempt()
    {
        return $this->hasMany(ExamAttempt::class);
    }

    public function grade()
    {
        return $this->belongsToMany(Grade::class, 'exam_grades');
    }
}
