<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;
    use HasUlids;
    
    protected $fillable = [
        'name',
        'gender',
    ];

    public function userable()
    {
        return $this->morphOne(Userable::class, 'userable')->with('userable');
    }
}
