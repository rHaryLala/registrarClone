<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Semester;
use App\Models\AcademicYear;

class SemesterSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer l'année académique 2025-2026
        $year = AcademicYear::where('libelle', '2025-2026')->first();
        if (!$year) {
            return;
        }

        Semester::firstOrCreate([
            'nom' => 'Premier semestre',
            'academic_year_id' => $year->id,
        ], [
            'ordre' => 1,
            'date_debut' => '2025-09-29',
            'date_fin' => '2026-02-13',
            'academic_year_id' => $year->id,
        ]);

        Semester::firstOrCreate([
            'nom' => "Semestre d'été",
            'academic_year_id' => $year->id,
        ], [
            'ordre' => 2,
            'date_debut' => '2026-02-14',
            'date_fin' => '2026-03-08',
            'academic_year_id' => $year->id,
        ]);

        Semester::firstOrCreate([
            'nom' => 'Deuxième semestre',
            'academic_year_id' => $year->id,
        ], [
            'ordre' => 3,
            'date_debut' => '2026-03-09',
            'date_fin' => '2026-08-02',
            'academic_year_id' => $year->id,
        ]);

        Semester::firstOrCreate([
            'nom' => "Semestre d'hiver",
            'academic_year_id' => $year->id,
        ], [
            'ordre' => 4,
            'date_debut' => '2026-08-03',
            'date_fin' => '2026-10-16',
            'academic_year_id' => $year->id,
        ]);
    }
}