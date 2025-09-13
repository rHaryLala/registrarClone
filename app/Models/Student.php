<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course;
use App\Models\Mention;
use App\Models\Semester;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom', 'prenom', 'sexe', 'date_naissance', 'lieu_naissance', 
        'nationalite', 'religion', 'etat_civil', 'passport_status', 
        'passport_numero', 'passport_pays_emission', 'passport_date_emission', 
        'passport_date_expiration', 'nom_conjoint', 'nb_enfant', 'cin_numero', 
        'cin_date_delivrance', 'cin_lieu_delivrance', 'nom_pere', 'profession_pere', 
        'contact_pere', 'nom_mere', 'profession_mere', 'contact_mere', 
        'adresse_parents', 'telephone', 'email', 'adresse', 'region', 
        'district', 'bacc_serie', 'bacc_date_obtention', 'bursary_status', 
        'sponsor_nom', 'sponsor_prenom', 'sponsor_telephone', 'sponsor_adresse', 
        'annee_etude', 'mention_id', 'semester_id', 'matricule', 'image'
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'passport_date_emission' => 'date',
        'passport_date_expiration' => 'date',
        'cin_date_delivrance' => 'date',
        'bacc_date_obtention' => 'date',
        'passport_status' => 'boolean',
        'bursary_status' => 'boolean',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_student', 'student_id', 'course_id')
            ->withTimestamps()
            ->withPivot('deleted_at');
    }

    public function mention()
    {
        return $this->belongsTo(Mention::class);
    }
    
    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }
}