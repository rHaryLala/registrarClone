<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AcademicYear;

class AcademicYearSeeder extends Seeder
{
    public function run(): void
    {
        $years = [
            [
                'libelle' => '2022',
                'date_debut' => '2022-01-17',
                'date_fin' => '2023-10-30',
                'active' => false,
            ],
            [
                'libelle' => '2022-2023',
                'date_debut' => '2022-11-07',
                'date_fin' => '2023-08-13',
                'active' => false,
            ],
            [
                'libelle' => '2023-2024',
                'date_debut' => '2023-10-16',
                'date_fin' => '2024-08-04',
                'active' => false,
            ],
            [
                'libelle' => '2024-2025',
                'date_debut' => '2024-09-16',
                'date_fin' => '2025-06-22',
                'active' => false,
            ],
            [
                'libelle' => '2025-2026',
                'date_debut' => '2025-09-29',
                'date_fin' => '2026-08-02',
                'active' => true,
            ],
        ];

        foreach ($years as $year) {
            AcademicYear::firstOrCreate(['libelle' => $year['libelle']], $year);
        }
    }
}
