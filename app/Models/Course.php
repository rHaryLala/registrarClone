<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Mention;
use App\Models\YearLevel;

class Course extends Model
{
    protected $fillable = [
        'sigle', 'nom', 'credits', 'teacher_id', 'mention_id', 'year_level_id'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
    
    public function students()
    {
        return $this->belongsToMany(Student::class, 'course_student', 'course_id', 'student_id');
    }
    
    public function mention()
    {
        return $this->belongsTo(Mention::class);
    }
    
    public function yearLevel()
    {
        return $this->belongsTo(YearLevel::class);
    }
}
