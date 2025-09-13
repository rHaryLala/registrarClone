<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mention;

class MentionSeeder extends Seeder
{
    public function run(): void
    {
        $mentions = [
            'Théologie',
            'Gestion',
            'Informatique',
            'Sciences Infirmières',
            'Education',
            'Communication',
            'Études Anglophones',
            'Droit',
        ];
        foreach ($mentions as $mention) {
            Mention::firstOrCreate([
                'nom' => $mention,
            ], [
                'description' => null
            ]);
        }
    }
}
