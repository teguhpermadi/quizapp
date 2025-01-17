<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paragraph extends Model
{
    /** @use HasFactory<\Database\Factories\ParagraphFactory> */
    use HasFactory;
    use HasUlids;
    use SoftDeletes;

    protected $fillable = [
        'paragraph',
    ];

    public function question()
    {
        return $this->belongsToMany(Question::class, 'paragraph_question');
    }
}
