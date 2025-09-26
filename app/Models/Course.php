<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Mention;
use App\Models\YearLevel;
use App\Traits\TracksLastChange;

class Course extends Model
{
    use TracksLastChange;
    protected $fillable = [
        'sigle', 'nom', 'credits', 'teacher_id', 'mention_id', 'labo_info', 'categorie'
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
    
    public function yearLevels()
    {
        return $this->belongsToMany(YearLevel::class, 'course_yearlevel', 'course_id', 'year_level_id');
    }
}
