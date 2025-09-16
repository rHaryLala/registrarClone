<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parcours;
use App\Models\Mention;

class ParcoursSeeder extends Seeder
{
    public function run(): void
    {
        // Exemple de mentions et parcours associés
        $data = [
            ['nom' => 'Théologie biblique', 'mention_nom' => 'Théologie'],
            ['nom' => 'Théologie pastorale', 'mention_nom' => 'Théologie'],
            ['nom' => 'Management des affaires', 'mention_nom' => 'Gestion'],
            ['nom' => 'Finances et comptabilité', 'mention_nom' => 'Gestion'],
            ['nom' => 'Marketing', 'mention_nom' => 'Gestion'],
            ['nom' => 'Système d\'information et génie logiciel', 'mention_nom' => 'Informatique'],
            ['nom' => 'Maintenance et administration de réseau', 'mention_nom' => 'Informatique'],
            ['nom' => 'Infirmerie générale', 'mention_nom' => 'Sciences Infirmières'],
            ['nom' => 'Maïeutique', 'mention_nom' => 'Sciences Infirmières'],
            ['nom' => 'Administration de l\'éducation', 'mention_nom' => 'Education'],
            ['nom' => 'Education préscolaire et primaire', 'mention_nom' => 'Education'],
            ['nom' => 'Enseignement du français', 'mention_nom' => 'Education'],
            ['nom' => 'Enseignement de l\'anglais', 'mention_nom' => 'Education'],
            ['nom' => 'Enseignement des mathématiques', 'mention_nom' => 'Education'],
            ['nom' => 'Education réligieuse', 'mention_nom' => 'Education'],
            ['nom' => 'Communication en entreprise', 'mention_nom' => 'Communication'],
            ['nom' => 'Média et journalisme', 'mention_nom' => 'Communication'],
            ['nom' => 'Traduction et interprétation', 'mention_nom' => 'Études Anglophones'],
            ['nom' => 'Langue et littérature', 'mention_nom' => 'Études Anglophones'],
            ['nom' => 'Droit public', 'mention_nom' => 'Droit'],
            ['nom' => 'Droit privé', 'mention_nom' => 'Droit'],
        ];

        foreach ($data as $item) {
            $mention = Mention::where('nom', $item['mention_nom'])->first();
            if ($mention) {
                Parcours::firstOrCreate(
                    ['nom' => $item['nom'], 'mention_id' => $mention->id]
                );
            }
        }
    }
}
