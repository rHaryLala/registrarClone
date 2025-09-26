<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\YearLevel;

class YearLevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            ['code' => 'L1R', 'label' => 'Licence 1 (Remise à niveau)', 'track' => 'restreint'],
            ['code' => 'L1',  'label' => 'Licence 1', 'track' => 'normal'],
            ['code' => 'L2',  'label' => 'Licence 2', 'track' => 'normal'],
            ['code' => 'L3',  'label' => 'Licence 3', 'track' => 'normal'],
            ['code' => 'M1',  'label' => 'Master 1',  'track' => 'normal'],
            ['code' => 'M2',  'label' => 'Master 2',  'track' => 'normal'],
        ];

        foreach ($levels as $level) {
            YearLevel::updateOrCreate(
                ['code' => $level['code']],
                ['label' => $level['label'], 'track' => $level['track']]
            );
        }
    }
}
