<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class QuestionBankQuestion extends Pivot
{
    public function questionBank()
    {
        return $this->belongsTo(QuestionBank::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
