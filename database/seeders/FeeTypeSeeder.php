<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FeeType;

class FeeTypeSeeder extends Seeder
{
    public function run()
    {
        $types = [
            'Frais Généraux', 'Écolage', 'Cantine', 'Dortoir', 'Laboratoire Informatique', 'Laboratoire Communication', 'Laboratoire Langue', 'Voyage d\'étude','Colloque', 'Costume', 'Graduation'
        ];

        foreach ($types as $t) {
            FeeType::firstOrCreate(['name' => $t], ['slug' => strtolower(str_replace(' ', '_', $t))]);
        }
    }
}
