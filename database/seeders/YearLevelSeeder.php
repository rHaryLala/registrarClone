<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\YearLevel;

class YearLevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            ['code' => 'L1', 'label' => 'Licence 1'],
            ['code' => 'L2', 'label' => 'Licence 2'],
            ['code' => 'L3', 'label' => 'Licence 3'],
            ['code' => 'M1', 'label' => 'Master 1'],
            ['code' => 'M2', 'label' => 'Master 2'],
        ];
        foreach ($levels as $level) {
            YearLevel::firstOrCreate(['code' => $level['code']], $level);
        }
    }
}
