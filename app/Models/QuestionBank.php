<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionBank extends Model
{
    /** @use HasFactory<\Database\Factories\QuestionBankFactory> */
    use HasFactory;
    use SoftDeletes;
    use HasUlids;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image',
        'tag',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsToMany(Question::class, 'question_bank_question');
    }
}
