<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    /** @use HasFactory<\Database\Factories\GradeFactory> */
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        'name',
        'code',
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_grades');
    }
}
