<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Teacher;
use App\Models\Student;

class Mention extends Model
{
    protected $fillable = ['nom', 'description'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function parcours()
    {
        return $this->hasMany(\App\Models\Parcours::class, 'mention_id');
    }
}
