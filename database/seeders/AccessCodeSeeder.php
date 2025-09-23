<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AccessCodeSeeder extends Seeder
{
    public function run(): void
    {
        $codes ;

        // Générer 100 codes aléatoires
        for ($i = 0; $i < 400; $i++) {
            do {
                // Génère un code de 8 caractères avec lettres majuscules et chiffres
                $randomCode = strtoupper(Str::random(8));
                // Vérifie si le code existe déjà
                $exists = DB::table('access_codes')->where('code', $randomCode)->exists();
            } while ($exists);

            $codes[] = [
                'code' => $randomCode,
                'is_active' => true
            ];
        }

        foreach ($codes as $code) {
            DB::table('access_codes')->updateOrInsert(
                ['code' => strtoupper(trim($code['code']))],
                ['is_active' => $code['is_active']]
            );
        }
    }
}
