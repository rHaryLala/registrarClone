<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinanceDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'statut_etudiant',
        'mention_id',
        'frais_generaux',
        'ecolage',
        'laboratory',
        'dortoir',
        'nb_jours_semestre',
        'nb_jours_semestre_L2',
        'nb_jours_semestre_L3',
        'cafeteria',
        'fond_depot',
        'frais_graduation',
        'frais_costume',
        'frais_voyage',
    ];

    public function mention()
    {
        return $this->belongsTo(\App\Models\Mention::class);
    }
}
