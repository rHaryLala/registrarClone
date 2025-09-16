<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mention;
use Illuminate\Support\Facades\DB;

class FinanceDetailSeeder extends Seeder
{
    public function run(): void
    {
        // Correspondance code abrégé -> nom complet de la mention
        $mentionMap = [
            'NURS' => 'Sciences Infirmières',
            'COMM' => 'Communication',
            'DROI' => 'Droit',
            'GEST' => 'Gestion',
            'THEO' => 'Théologie',
            'INFO' => 'Informatique',
            'LANG' => 'Études Anglophones',
            'EDUC' => 'Education',
        ];

        // Récupérer tous les IDs des mentions
        $mentionIds = [];
        foreach ($mentionMap as $code => $nom) {
            $mention = Mention::where('nom', $nom)->first();
            $mentionIds[$code] = $mention ? $mention->id : null;
        }

        $data = [
            // Interne
            ['statut_etudiant' => 'interne', 'mention' => 'NURS', 'frais_generaux' => 290000, 'ecolage' => 19000, 'laboratory' => 0, 'dortoir' => 3000, 'nb_jours_semestre' => 107, 'nb_jours_semestre_L2' => 80, 'nb_jours_semestre_L3' => 80, 'cafeteria' => 8000, 'fond_depot' => 80000, 'frais_graduation' => 150000, 'frais_costume' => 0, 'frais_voyage' => 100000],
            ['statut_etudiant' => 'interne', 'mention' => 'COMM', 'frais_generaux' => 210000, 'ecolage' => 19000, 'laboratory' => 35000, 'dortoir' => 3000, 'nb_jours_semestre' => 118, 'nb_jours_semestre_L2' => 118, 'nb_jours_semestre_L3' => 118, 'cafeteria' => 8000, 'fond_depot' => 80000, 'frais_graduation' => 150000, 'frais_costume' => 0, 'frais_voyage' => 100000],
            ['statut_etudiant' => 'interne', 'mention' => 'DROI', 'frais_generaux' => 210000, 'ecolage' => 19000, 'laboratory' => 0, 'dortoir' => 3000, 'nb_jours_semestre' => 118, 'nb_jours_semestre_L2' => 118, 'nb_jours_semestre_L3' => 118, 'cafeteria' => 8000, 'fond_depot' => 80000, 'frais_graduation' => 150000, 'frais_costume' => 0, 'frais_voyage' => 100000],
            ['statut_etudiant' => 'interne', 'mention' => 'GEST', 'frais_generaux' => 210000, 'ecolage' => 19000, 'laboratory' => 0, 'dortoir' => 3000, 'nb_jours_semestre' => 118, 'nb_jours_semestre_L2' => 118, 'nb_jours_semestre_L3' => 118, 'cafeteria' => 8000, 'fond_depot' => 80000, 'frais_graduation' => 150000, 'frais_costume' => 0, 'frais_voyage' => 100000],
            ['statut_etudiant' => 'interne', 'mention' => 'THEO', 'frais_generaux' => 210000, 'ecolage' => 19000, 'laboratory' => 0, 'dortoir' => 3000, 'nb_jours_semestre' => 118, 'nb_jours_semestre_L2' => 118, 'nb_jours_semestre_L3' => 118, 'cafeteria' => 8000, 'fond_depot' => 80000, 'frais_graduation' => 150000, 'frais_costume' => 150000, 'frais_voyage' => 50000],
            ['statut_etudiant' => 'interne', 'mention' => 'INFO', 'frais_generaux' => 210000, 'ecolage' => 19000, 'laboratory' => 35000, 'dortoir' => 3000, 'nb_jours_semestre' => 118, 'nb_jours_semestre_L2' => 118, 'nb_jours_semestre_L3' => 118, 'cafeteria' => 8000, 'fond_depot' => 80000, 'frais_graduation' => 150000, 'frais_costume' => 0, 'frais_voyage' => 100000],
            ['statut_etudiant' => 'interne', 'mention' => 'LANG', 'frais_generaux' => 210000, 'ecolage' => 19000, 'laboratory' => 0, 'dortoir' => 3000, 'nb_jours_semestre' => 118, 'nb_jours_semestre_L2' => 118, 'nb_jours_semestre_L3' => 118, 'cafeteria' => 8000, 'fond_depot' => 80000, 'frais_graduation' => 150000, 'frais_costume' => 0, 'frais_voyage' => 100000],
            ['statut_etudiant' => 'interne', 'mention' => 'EDUC', 'frais_generaux' => 210000, 'ecolage' => 19000, 'laboratory' => 0, 'dortoir' => 3000, 'nb_jours_semestre' => 118, 'nb_jours_semestre_L2' => 118, 'nb_jours_semestre_L3' => 118, 'cafeteria' => 8000, 'fond_depot' => 80000, 'frais_graduation' => 150000, 'frais_costume' => 0, 'frais_voyage' => 100000],
            // Bungalow
            ['statut_etudiant' => 'bungalow', 'mention' => 'NURS', 'frais_generaux' => 290000, 'ecolage' => 19000, 'laboratory' => 0, 'dortoir' => 794.392523, 'nb_jours_semestre' => 107, 'nb_jours_semestre_L2' => 80, 'nb_jours_semestre_L3' => 80, 'cafeteria' => 8000, 'fond_depot' => 0, 'frais_graduation' => 150000, 'frais_costume' => 0, 'frais_voyage' => 100000],
            ['statut_etudiant' => 'bungalow', 'mention' => 'COMM', 'frais_generaux' => 210000, 'ecolage' => 19000, 'laboratory' => 35000, 'dortoir' => 720.338983, 'nb_jours_semestre' => 118, 'nb_jours_semestre_L2' => 118, 'nb_jours_semestre_L3' => 118, 'cafeteria' => 8000, 'fond_depot' => 0, 'frais_graduation' => 150000, 'frais_costume' => 0, 'frais_voyage' => 100000],
            ['statut_etudiant' => 'bungalow', 'mention' => 'DROI', 'frais_generaux' => 210000, 'ecolage' => 19000, 'laboratory' => 0, 'dortoir' => 720.338983, 'nb_jours_semestre' => 118, 'nb_jours_semestre_L2' => 118, 'nb_jours_semestre_L3' => 118, 'cafeteria' => 8000, 'fond_depot' => 0, 'frais_graduation' => 150000, 'frais_costume' => 0, 'frais_voyage' => 100000],
            ['statut_etudiant' => 'bungalow', 'mention' => 'GEST', 'frais_generaux' => 210000, 'ecolage' => 19000, 'laboratory' => 0, 'dortoir' => 720.338983, 'nb_jours_semestre' => 118, 'nb_jours_semestre_L2' => 118, 'nb_jours_semestre_L3' => 118, 'cafeteria' => 8000, 'fond_depot' => 0, 'frais_graduation' => 150000, 'frais_costume' => 0, 'frais_voyage' => 100000],
            ['statut_etudiant' => 'bungalow', 'mention' => 'THEO', 'frais_generaux' => 210000, 'ecolage' => 19000, 'laboratory' => 0, 'dortoir' => 720.338983, 'nb_jours_semestre' => 118, 'nb_jours_semestre_L2' => 118, 'nb_jours_semestre_L3' => 118, 'cafeteria' => 8000, 'fond_depot' => 0, 'frais_graduation' => 150000, 'frais_costume' => 150000, 'frais_voyage' => 50000],
            ['statut_etudiant' => 'bungalow', 'mention' => 'INFO', 'frais_generaux' => 210000, 'ecolage' => 19000, 'laboratory' => 35000, 'dortoir' => 720.338983, 'nb_jours_semestre' => 118, 'nb_jours_semestre_L2' => 118, 'nb_jours_semestre_L3' => 118, 'cafeteria' => 8000, 'fond_depot' => 0, 'frais_graduation' => 150000, 'frais_costume' => 0, 'frais_voyage' => 100000],
            ['statut_etudiant' => 'bungalow', 'mention' => 'LANG', 'frais_generaux' => 210000, 'ecolage' => 19000, 'laboratory' => 0, 'dortoir' => 720.338983, 'nb_jours_semestre' => 118, 'nb_jours_semestre_L2' => 118, 'nb_jours_semestre_L3' => 118, 'cafeteria' => 8000, 'fond_depot' => 0, 'frais_graduation' => 150000, 'frais_costume' => 0, 'frais_voyage' => 100000],
            ['statut_etudiant' => 'bungalow', 'mention' => 'EDUC', 'frais_generaux' => 210000, 'ecolage' => 19000, 'laboratory' => 0, 'dortoir' => 720.338983, 'nb_jours_semestre' => 118, 'nb_jours_semestre_L2' => 118, 'nb_jours_semestre_L3' => 118, 'cafeteria' => 8000, 'fond_depot' => 0, 'frais_graduation' => 150000, 'frais_costume' => 0, 'frais_voyage' => 100000],
            // Externe
            ['statut_etudiant' => 'externe', 'mention' => 'NURS', 'frais_generaux' => 290000, 'ecolage' => 19000, 'laboratory' => 0, 'dortoir' => 0, 'nb_jours_semestre' => 107, 'nb_jours_semestre_L2' => 80, 'nb_jours_semestre_L3' => 80, 'cafeteria' => 8000, 'fond_depot' => 0, 'frais_graduation' => 150000, 'frais_costume' => 0, 'frais_voyage' => 100000],
            ['statut_etudiant' => 'externe', 'mention' => 'COMM', 'frais_generaux' => 210000, 'ecolage' => 19000, 'laboratory' => 35000, 'dortoir' => 0, 'nb_jours_semestre' => 118, 'nb_jours_semestre_L2' => 118, 'nb_jours_semestre_L3' => 118, 'cafeteria' => 8000, 'fond_depot' => 0, 'frais_graduation' => 150000, 'frais_costume' => 0, 'frais_voyage' => 100000],
            ['statut_etudiant' => 'externe', 'mention' => 'DROI', 'frais_generaux' => 210000, 'ecolage' => 19000, 'laboratory' => 0, 'dortoir' => 0, 'nb_jours_semestre' => 118, 'nb_jours_semestre_L2' => 118, 'nb_jours_semestre_L3' => 118, 'cafeteria' => 8000, 'fond_depot' => 0, 'frais_graduation' => 150000, 'frais_costume' => 0, 'frais_voyage' => 100000],
            ['statut_etudiant' => 'externe', 'mention' => 'GEST', 'frais_generaux' => 210000, 'ecolage' => 19000, 'laboratory' => 0, 'dortoir' => 0, 'nb_jours_semestre' => 118, 'nb_jours_semestre_L2' => 118, 'nb_jours_semestre_L3' => 118, 'cafeteria' => 8000, 'fond_depot' => 0, 'frais_graduation' => 150000, 'frais_costume' => 0, 'frais_voyage' => 100000],
            ['statut_etudiant' => 'externe', 'mention' => 'THEO', 'frais_generaux' => 210000, 'ecolage' => 19000, 'laboratory' => 0, 'dortoir' => 0, 'nb_jours_semestre' => 118, 'nb_jours_semestre_L2' => 118, 'nb_jours_semestre_L3' => 118, 'cafeteria' => 8000, 'fond_depot' => 0, 'frais_graduation' => 150000, 'frais_costume' => 150000, 'frais_voyage' => 50000],
            ['statut_etudiant' => 'externe', 'mention' => 'INFO', 'frais_generaux' => 210000, 'ecolage' => 19000, 'laboratory' => 35000, 'dortoir' => 0, 'nb_jours_semestre' => 118, 'nb_jours_semestre_L2' => 118, 'nb_jours_semestre_L3' => 118, 'cafeteria' => 8000, 'fond_depot' => 0, 'frais_graduation' => 150000, 'frais_costume' => 0, 'frais_voyage' => 100000],
            ['statut_etudiant' => 'externe', 'mention' => 'LANG', 'frais_generaux' => 210000, 'ecolage' => 19000, 'laboratory' => 0, 'dortoir' => 0, 'nb_jours_semestre' => 118, 'nb_jours_semestre_L2' => 118, 'nb_jours_semestre_L3' => 118, 'cafeteria' => 8000, 'fond_depot' => 0, 'frais_graduation' => 150000, 'frais_costume' => 0, 'frais_voyage' => 100000],
            ['statut_etudiant' => 'externe', 'mention' => 'EDUC', 'frais_generaux' => 210000, 'ecolage' => 19000, 'laboratory' => 0, 'dortoir' => 0, 'nb_jours_semestre' => 118, 'nb_jours_semestre_L2' => 118, 'nb_jours_semestre_L3' => 118, 'cafeteria' => 8000, 'fond_depot' => 0, 'frais_graduation' => 150000, 'frais_costume' => 0, 'frais_voyage' => 100000],
        ];

        foreach ($data as $row) {
            DB::table('finance_details')->updateOrInsert(
                [
                    'statut_etudiant' => strtolower($row['statut_etudiant']),
                    'mention_id' => $mentionIds[$row['mention']] ?? null,
                ],
                [
                    'frais_generaux' => $row['frais_generaux'],
                    'ecolage' => $row['ecolage'],
                    'laboratory' => $row['laboratory'],
                    'dortoir' => $row['dortoir'],
                    'nb_jours_semestre' => $row['nb_jours_semestre'],
                    'nb_jours_semestre_L2' => $row['nb_jours_semestre_L2'],
                    'nb_jours_semestre_L3' => $row['nb_jours_semestre_L3'],
                    'cafeteria' => $row['cafeteria'],
                    'fond_depot' => $row['fond_depot'],
                    'frais_graduation' => $row['frais_graduation'],
                    'frais_costume' => $row['frais_costume'],
                    'frais_voyage' => $row['frais_voyage'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
