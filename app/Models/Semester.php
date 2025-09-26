<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AcademicYear;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'ordre',
        'annee',
        'date_debut',
        'date_fin',
        'duration',
        'academic_year_id',
    ];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }
}