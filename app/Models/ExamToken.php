<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamToken extends Model
{
    /** @use HasFactory<\Database\Factories\ExamTokenFactory> */
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        'exam_id',
        'token',
    ];

    /**
     * Generate random 6-digit token.
     *
     * @return string
     */
    public static function generateToken(): string
    {
        do {
            $token = str_pad(random_int(111111, 999999), 6, '0', STR_PAD_LEFT);
        } while (self::where('token', $token)->exists());

        return $token;
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
