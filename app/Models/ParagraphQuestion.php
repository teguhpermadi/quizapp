<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ParagraphQuestion extends Pivot
{
    public function paragraph()
    {
        return $this->belongsTo(Paragraph::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
