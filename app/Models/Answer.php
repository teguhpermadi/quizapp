<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    /** @use HasFactory<\Database\Factories\AnswerFactory> */
    use HasFactory;
    use HasUlids;
    use SoftDeletes;

    protected $fillable = [
        'question_id',
        'answer_text',
        'is_correct',
        'image',
        'matching_pair',
        'order_position',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array', // Pastikan metadata dikonversi menjadi array
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function studentAnswers()
    {
        return $this->hasMany(StudentAnswer::class);
    }

    // Relasi ke pasangan (jawaban yang menjadi pair)
    public function pair()
    {
        return $this->belongsTo(Answer::class, 'matching_pair');
    }

    // Relasi ke jawaban yang dipasangkan oleh pasangan lain
    public function pairedBy()
    {
        return $this->hasOne(Answer::class, 'matching_pair', 'id');
    }
}
