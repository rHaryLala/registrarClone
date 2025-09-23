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
}
