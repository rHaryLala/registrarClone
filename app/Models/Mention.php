<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Teacher;
use App\Models\Student;
use App\Traits\TracksLastChange;

class Mention extends Model
{
    use TracksLastChange;
    protected $fillable = ['nom', 'description'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function parcours()
    {
        return $this->hasMany(\App\Models\Parcours::class, 'mention_id');
    }

    // Many-to-many: courses that are shared across mentions
    public function courses()
    {
        return $this->belongsToMany(\App\Models\Course::class, 'course_mention', 'mention_id', 'course_id');
    }
}
