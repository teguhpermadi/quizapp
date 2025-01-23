<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class StudentGrade extends Pivot
{
    /**
     * Get the student that owns the grade.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function student()
    {
        return $this->belongsTo(Student::class);
    }


    /**
     * Get the grade associated with the student.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
}
