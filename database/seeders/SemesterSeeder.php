<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Semester;
use App\Models\AcademicYear;
use App\Models\Mention;

class SemesterSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer l'année académique 2025-2026
        $year = AcademicYear::where('libelle', '2025-2026')->first();
        if (!$year) {
            return;
        }

        // Prepare default semester definitions (can be customized per mention)
        $definitions = [
            [
                'nom' => 'Premier semestre',
                'ordre' => 1,
                'date_debut' => '2025-09-29',
                'date_fin' => '2026-02-13',
                'duration' => 122,
            ],
            [
                'nom' => "Semestre d'été",
                'ordre' => 2,
                'date_debut' => '2026-02-14',
                'date_fin' => '2026-03-08',
                'duration' => null,
            ],
            [
                'nom' => 'Deuxième semestre',
                'ordre' => 3,
                'date_debut' => '2026-03-09',
                'date_fin' => '2026-08-02',
                'duration' => null,
            ],
            [
                'nom' => "Semestre d'hiver",
                'ordre' => 4,
                'date_debut' => '2026-08-03',
                'date_fin' => '2026-10-16',
                'duration' => null,
            ],
        ];

        // If mentions exist, create semesters per mention so durations/dates can be customized per mention later
        $mentions = Mention::all();
        if ($mentions->isEmpty()) {
            // Fallback: create global semesters (mention_id = null)
            foreach ($definitions as $def) {
                Semester::firstOrCreate([
                    'nom' => $def['nom'],
                    'academic_year_id' => $year->id,
                    'mention_id' => null,
                ], array_merge($def, ['academic_year_id' => $year->id, 'mention_id' => null]));
            }
        } else {
            foreach ($mentions as $mention) {
                foreach ($definitions as $def) {
                    Semester::firstOrCreate([
                        'nom' => $def['nom'],
                        'academic_year_id' => $year->id,
                        'mention_id' => $mention->id,
                    ], array_merge($def, ['academic_year_id' => $year->id, 'mention_id' => $mention->id]));
                }
            }
        }
    }
}