<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'libelle', 'date_debut', 'date_fin', 'active'
    ];

    public function semestres()
    {
        return $this->hasMany(Semestre::class, 'academic_year_id');
    }
}
