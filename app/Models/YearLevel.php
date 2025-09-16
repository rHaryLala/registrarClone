<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Course;
use App\Models\Student;

class YearLevel extends Model
{
    protected $fillable = ['code', 'label'];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
