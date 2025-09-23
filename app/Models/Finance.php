<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
use App\Models\Semester;
use App\Models\User;
use App\Traits\TrackLastChange;

class Finance extends Model
{
    protected $table = 'finance';
    public $timestamps = false; // si pas de timestamps créés
    protected $guarded = [];

    public function student()
    {
        // clé locale 'student_id' contient la matricule, clé distante 'matricule'
        return $this->belongsTo(Student::class, 'student_id', 'matricule');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'id');
    }

    public function lastChangedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'last_change_user_id');
    }
}