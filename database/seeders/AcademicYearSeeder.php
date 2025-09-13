<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AcademicYear;

class AcademicYearSeeder extends Seeder
{
    public function run(): void
    {
        AcademicYear::create([
            'libelle' => '2024-2025',
            'date_debut' => '2024-10-01',
            'date_fin' => '2025-09-30',
            'active' => true,
        ]);
    }
}
