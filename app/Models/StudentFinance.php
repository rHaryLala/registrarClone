<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentFinance extends Model
{
    protected $fillable = [
        'student_id', 'course_id', 'type', 'montant', 'status', 'description', 'extra'
    ];

    protected $casts = [
        'extra' => 'array',
        'montant' => 'float',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
