<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Semester;

class SemesterSeeder extends Seeder
{
    public function run(): void
    {
        // À adapter si tu veux lier à une année académique précise
        $academicYearId = null;
        Semester::create([
            'nom' => 'Premier semestre',
            'ordre' => 1,
            'annee' => date('Y'),
            'date_debut' => date('Y') . '-01-10',
            'date_fin' => date('Y') . '-03-31',
            'academic_year_id' => $academicYearId,
        ]);
        Semester::create([
            'nom' => "Semestre d'été",
            'ordre' => 2,
            'annee' => date('Y'),
            'date_debut' => date('Y') . '-04-01',
            'date_fin' => date('Y') . '-06-30',
            'academic_year_id' => $academicYearId,
        ]);
        Semester::create([
            'nom' => 'Deuxième semestre',
            'ordre' => 3,
            'annee' => date('Y'),
            'date_debut' => date('Y') . '-07-01',
            'date_fin' => date('Y') . '-09-30',
            'academic_year_id' => $academicYearId,
        ]);
        Semester::create([
            'nom' => "Semestre d'hiver",
            'ordre' => 4,
            'annee' => date('Y'),
            'date_debut' => date('Y') . '-10-01',
            'date_fin' => date('Y') . '-12-31',
            'academic_year_id' => $academicYearId,
        ]);
    }
}
