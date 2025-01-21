<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    /** @use HasFactory<\Database\Factories\QuestionFactory> */
    use HasFactory;
    use HasUlids;
    use SoftDeletes;

    protected $fillable = [
        'question',
        'question_type',
        'image',
        'explanation',
        'score',
        'tag',
        'timer',
        'level',
        'user_id',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function answer()
    {
        return $this->hasMany(Answer::class);
    }

    public function paragraph()
    {
        return $this->belongsToMany(Paragraph::class, 'paragraph_question');
    }

    public function studentAnswers()
    {
        return $this->hasMany(StudentAnswer::class);
    }
}
