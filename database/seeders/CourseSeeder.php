<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\YearLevel;
use App\Models\Mention;
use App\Models\Teacher;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer tous les IDs des mentions
        $mentions = Mention::pluck('id', 'nom')->toArray();
        // Récupérer tous les IDs des enseignants
        $teachers = Teacher::pluck('id', 'name')->toArray();

        $courses = [
            //Semestre 1 - L1 - Théologie
            ['sigle' => 'GCOM 100', 'nom' => 'Techniques informatiques', 'credits' => 3, 'year_level_id' => 1, 'mention_id' => 1, 'teacher_id' => 5, 'labo_info' => true, 'categorie' => 'majeur'],
            ['sigle' => 'GCAS 100', 'nom' => 'Français soutien', 'credits' => 6, 'year_level_id' => 1, 'mention_id' => 1, 'teacher_id' => null, 'categorie' => 'général'],
            ['sigle' => 'RELB 110', 'nom' => 'Connaissances bibliques', 'credits' => 3, 'year_level_id' => 1, 'mention_id' => 1, 'teacher_id' => null, 'categorie' => 'général'],
            ['sigle' => 'CRAN 001', 'nom' => 'Anglais pour débutants', 'credits' => 3, 'year_level_id' => 1, 'mention_id' => 1, 'teacher_id' => null, 'categorie' => 'général'],
            ['sigle' => 'RELR 201', 'nom' => 'Méthodes de recherche', 'credits' => 4, 'year_level_ids' => [1, 2], 'mention_id' => 1, 'teacher_id' => 5, 'categorie' => 'général'],
            ['sigle' => 'RELG 201', 'nom' => 'Français théologique', 'credits' => 3, 'year_level_id' => 2, 'mention_id' => 1, 'teacher_id' => null, 'categorie' => 'général'],
            ['sigle' => 'RELB 211', 'nom' => 'Introduction à la Bible', 'credits' => 5, 'year_level_id' => 2, 'mention_id' => 1, 'teacher_id' => null, 'categorie' => 'majeur'],
            ['sigle' => 'RELL 231', 'nom' => 'Grec I', 'credits' => 5, 'year_level_id' => 2, 'mention_id' => 1, 'teacher_id' => 3, 'categorie' => 'majeur'],
            ['sigle' => 'RELT 241', 'nom' => 'Doctrines bibliques', 'credits' => 5, 'year_level_id' => 2, 'mention_id' => 1, 'teacher_id' => 6, 'categorie' => 'majeur'],
            ['sigle' => 'RELP 261', 'nom' => 'Colportage', 'credits' => 2, 'year_level_id' => 2, 'mention_id' => 1, 'teacher_id' => 7, 'categorie' => 'majeur'],
            ['sigle' => 'RELP 281', 'nom' => 'Introduction au service pastoral', 'credits' => 3, 'year_level_id' => 2, 'mention_id' => 1, 'teacher_id' => 8, 'categorie' => 'majeur'],
            ['sigle' => 'RELP 291', 'nom' => 'Formation spirituelle', 'credits' => 3, 'year_level_id' => 2, 'mention_id' => 1, 'teacher_id' => null, 'categorie' => 'majeur'],

            //Semestre 1 - L1 - Gestion
            ['sigle' => 'CGMR 201', 'nom' => 'Méthodes d\'études et de recherche', 'credits' => 4, 'year_level_ids' => [1, 2], 'mention_id' => 2, 'teacher_id' => 13, 'categorie' => 'général'],
            ['sigle' => 'CRFR 001', 'nom' => 'Cours de soutien de FRS', 'credits' => 6, 'year_level_id' => 1, 'mention_id' => 2, 'teacher_id' => null, 'categorie' => 'général'],
            ['sigle' => 'CGFR 201', 'nom' => 'Français des affaires I', 'credits' => 3, 'year_level_id' => 2, 'mention_id' => 2, 'teacher_id' => 14, 'categorie' => 'général'],
            ['sigle' => 'CGAN 201', 'nom' => 'Anglais I', 'credits' => 3, 'year_level_ids' => [1, 2], 'mention_id' => 2, 'teacher_id' => null, 'categorie' => 'général'],
            ['sigle' => 'CGRE 201', 'nom' => 'Jésus, PDG', 'credits' => 3, 'year_level_id' => 2, 'mention_id' => 2, 'teacher_id' => 15, 'categorie' => 'général'],
            ['sigle' => 'CGIN 201', 'nom' => 'Informatique', 'credits' => 4, 'year_level_ids' => [1, 2], 'mention_id' => 2, 'teacher_id' => 16, 'labo_info' => true, 'categorie' => 'majeur'],
            ['sigle' => 'GECO 211', 'nom' => 'Introduction à la comptabilité I', 'credits' => 5, 'year_level_ids' => [1, 2], 'mention_id' => 2, 'teacher_id' => 9, 'categorie' => 'majeur'],
            ['sigle' => 'GEMG 211', 'nom' => 'Principes de management', 'credits' => 4, 'year_level_id' => 2, 'mention_id' => 2, 'teacher_id' => 12, 'categorie' => 'majeur'],
            ['sigle' => 'GEMA 211', 'nom' => 'Mathématiques pour la gestion I', 'credits' => 4, 'year_level_id' => 2, 'mention_id' => 2, 'teacher_id' => null, 'categorie' => 'majeur'],


            //Semestre 1 - l1 - Informatique
            ['sigle' => 'INAL 211', 'nom' => 'Logique et algorithmique sur Python', 'credits' => 4, 'year_level_ids' => [1, 2], 'mention_id' => 3, 'teacher_id' => 4, 'labo_info' => true, 'categorie' => 'majeur'],
            ['sigle' => 'INEL 211', 'nom' => 'Outils bureautiques et internet', 'credits' => 3, 'year_level_ids' => [1, 2], 'mention_id' => 3, 'teacher_id' => 17, 'labo_info' => true, 'categorie' => 'majeur'],
            ['sigle' => 'INEN 211', 'nom' => 'Anglais I', 'credits' => 3, 'year_level_ids' => [1, 2], 'mention_id' => 3, 'teacher_id' => null, 'categorie' => 'général'],
            ['sigle' => 'CRFR 001', 'nom' => 'Cours de soutien de FRS', 'credits' => 6, 'year_level_id' => 1, 'mention_id' => 3, 'teacher_id' => null, 'categorie' => 'général'],
            ['sigle' => 'INFR 211', 'nom' => 'Français - Langue vivante', 'credits' => 3, 'year_level_id' => 2, 'mention_id' => 3, 'teacher_id' => 14, 'categorie' => 'général'],
            ['sigle' => 'INMA 211', 'nom' => 'Mathématiques générales et statistique', 'credits' => 4, 'year_level_id' => 2, 'mention_id' => 3, 'teacher_id' => null, 'categorie' => 'majeur'],
            ['sigle' => 'INMR 211', 'nom' => 'Méthode d\'Etude et de Recherche', 'credits' => 4, 'year_level_ids' => [1, 2], 'mention_id' => 3, 'teacher_id' => 13, 'categorie' => 'général'],
            ['sigle' => 'INRE 211', 'nom' => 'Vie et enseignement de Jésus', 'credits' => 3, 'year_level_ids' => [1, 2], 'mention_id' => 3, 'teacher_id' => 15, 'categorie' => 'général'],
            ['sigle' => 'INSE 211', 'nom' => 'Principes de fonctionnement des ordinateurs', 'credits' => 3, 'year_level_id' => 2, 'mention_id' => 3, 'teacher_id' => null, 'categorie' => 'majeur'],
            ['sigle' => 'INSE 212', 'nom' => 'Théories des systèmes d\'exploitation', 'credits' => 3, 'year_level_id' => 2, 'mention_id' => 3, 'teacher_id' => 22, 'categorie' => 'majeur'],


            //Semestre 1 - L1 - Sciences Infirmières
            ['sigle' => 'BIOM 4111', 'nom' => 'Structure et Fonction des biomolécules', 'credits' => 4, 'year_level_id' => 2, 'mention_id' => 4, 'teacher_id' => 13, 'categorie' => 'majeur'],
            ['sigle' => 'BIOC 4111', 'nom' => 'Tissus et Biologie cellulaire I', 'credits' => 4, 'year_level_id' => 2, 'mention_id' => 4, 'teacher_id' => 27, 'categorie' => 'majeur'],
            ['sigle' => 'PHYS 4111', 'nom' => 'Physiologie I', 'credits' => 5, 'year_level_id' => 2, 'mention_id' => 4, 'teacher_id' => null, 'categorie' => 'majeur'],
            ['sigle' => 'NRSP 4111', 'nom' => 'UE Spécifique I : Démarche de soins infirmiers I (SICM, SIP,SIGO)', 'credits' => 5, 'year_level_id' => 2, 'mention_id' => 4, 'teacher_id' => 23, 'categorie' => 'majeur'],
            ['sigle' => 'ANAT 4111', 'nom' => 'Anatomie I : Anatomie viscérale', 'credits' => 5, 'year_level_id' => 2, 'mention_id' => 4, 'teacher_id' => 27, 'categorie' => 'majeur'],
            ['sigle' => 'HYGI 4111', 'nom' => 'hygiène hospitalière', 'credits' => 2, 'year_level_ids' => [1, 2], 'mention_id' => 4, 'teacher_id' => null, 'categorie' => 'majeur'],
            ['sigle' => 'FREN 9111', 'nom' => 'Français courant', 'credits' => 2, 'year_level_id' => 2, 'mention_id' => 4, 'teacher_id' => 14, 'categorie' => 'général'],
            ['sigle' => 'FREN 4111', 'nom' => 'Français médical', 'credits' => 2, 'year_level_id' => 2, 'mention_id' => 4, 'teacher_id' => 28, 'categorie' => 'majeur'],
            ['sigle' => 'RELB 9111', 'nom' => "Vie et enseignement de Jésus", 'credits' => 1, 'year_level_ids' => [1, 2], 'mention_id' => 4, 'teacher_id' => 13, 'categorie' => 'général'],
            ['sigle' => 'INSY 9111', 'nom' => 'Informatique (TIAC)', 'credits' => 1, 'year_level_ids' => [1, 2], 'mention_id' => 4, 'teacher_id' => null, 'labo_info' => true, 'categorie' => 'général'],
            ['sigle' => 'PERD 4111', 'nom' => 'Développement personnel', 'credits' => 1, 'year_level_ids' => [1, 2], 'mention_id' => 4, 'teacher_id' => null, 'categorie' => 'majeur'],
            ['sigle' => 'CRFR 0011', 'nom' => 'Cours de soutien de FRS', 'credits' => 6, 'year_level_id' => 1, 'mention_id' => 4, 'teacher_id' => null, 'categorie' => 'général'],
            ['sigle' => 'CRAN 0011', 'nom' => 'Cours de soutien de ANG', 'credits' => 6, 'year_level_id' => 1, 'mention_id' => 4, 'teacher_id' => null, 'categorie' => 'général'],
            ['sigle' => 'CRSC 0011', 'nom' => 'Science générale', 'credits' => 6, 'year_level_id' => 1,  'mention_id' => 4, 'teacher_id' => null, 'categorie' => 'général'],


            //Semestre 1 - l1 - Communication
            ['sigle' => 'CRFR 001', 'nom' => 'Cours de soutien de FRS', 'credits' => 6, 'year_level_id' => 1, 'mention_id' => 6, 'teacher_id' => null, 'categorie' => 'général'],
            ['sigle' => 'COIJ 211', 'nom' => 'Initiation au journalisme', 'credits' => 4, 'year_level_id' => 2, 'mention_id' => 6, 'teacher_id' => null, 'categorie' => 'majeur'],
            ['sigle' => 'COMC 211', 'nom' => 'Média et culture de Madagascar', 'credits' => 3, 'year_level_id' => 2, 'mention_id' => 6, 'teacher_id' => 16, 'categorie' => 'majeur'],
            ['sigle' => 'COEN 211', 'nom' => 'Anglais: parlé et écrit', 'credits' => 4, 'year_level_ids' => [1, 2], 'mention_id' => 6, 'teacher_id' => null, 'categorie' => 'général'],
            ['sigle' => 'COMR 211', 'nom' => 'Méthodologie de travail universitaire', 'credits' => 4, 'year_level_ids' => [1, 2], 'mention_id' => 6, 'teacher_id' => null, 'categorie' => 'général'],
            ['sigle' => 'COIC 211', 'nom' => 'Introduction à la communication', 'credits' => 4, 'year_level_ids' => [1, 2], 'mention_id' => 6, 'teacher_id' => null,  'categorie' => 'majeur'],
            ['sigle' => 'COFR 211', 'nom' => 'Français: parlé et écrit', 'credits' => 4, 'year_level_id' => 2, 'mention_id' => 6, 'teacher_id' => null, 'categorie' => 'majeur'],
            ['sigle' => 'COIN 211', 'nom' => 'Informatique bureautique', 'credits' => 4, 'year_level_ids' => [1, 2], 'mention_id' => 6, 'teacher_id' => null, 'labo_info' => true, 'categorie' => 'général'],
            ['sigle' => 'CORE 211', 'nom' => 'Vie et enseignements de Jésus ', 'credits' => 3, 'year_level_ids' => [1, 2], 'mention_id' => 6, 'teacher_id' => 15, 'categorie' => 'général'],


            //Semestre 1 - L1 - Etudes anglphones
            ['sigle' => 'CRFR 001', 'nom' => 'Cours de soutien de FRS', 'credits' => 6, 'year_level_id' => 1, 'mention_id' => 7, 'teacher_id' => null, 'categorie' => 'général'],
            ['sigle' => 'GSIT 210', 'nom' => 'Fundamentals of Microcomputer+Keyboarding', 'credits' => 4, 'year_level_ids' => [1, 2], 'mention_id' => 7, 'teacher_id' => null, 'labo_info' => true, 'categorie' => 'général'],
            ['sigle' => 'GSRE 210', 'nom' => 'Study and Research Methods', 'credits' => 4, 'year_level_ids' => [1, 2], 'mention_id' => 7, 'teacher_id' => null, 'categorie' => 'général'],
            ['sigle' => 'GSRE 211', 'nom' => 'Life and Teaching of Jesus', 'credits' => 3, 'year_level_ids' => [1, 2], 'mention_id' => 7, 'teacher_id' => null, 'categorie' => 'général'],
            ['sigle' => 'FRLA 211', 'nom' => 'Intermediate French', 'credits' => 4, 'year_level_id' => 2, 'mention_id' => 7, 'teacher_id' => null, 'categorie' => 'général'],
            ['sigle' => 'ENLA 212', 'nom' => 'Use of English', 'credits' => 4, 'year_level_id' => 2, 'mention_id' => 7, 'teacher_id' => null, 'categorie' => 'général'],
            ['sigle' => 'ENLA 213', 'nom' => 'Auditory & Speaking Skills - I', 'credits' => 4, 'year_level_id' => 2, 'mention_id' => 7, 'teacher_id' => null, 'categorie' => 'majeur'],
            ['sigle' => 'ENLA 214', 'nom' => 'Introduction to phonetics and Phonology of English', 'credits' => 4, 'year_level_ids' => [1, 2], 'mention_id' => 7, 'teacher_id' => null, 'categorie' => 'majeur'],
            ['sigle' => 'ENLA 215', 'nom' => 'American Civilization', 'credits' => 3, 'year_level_ids' => [1, 2], 'mention_id' => 7, 'teacher_id' => null, 'categorie' => 'majeur'],


            //Semestre 1 - L1 - Droit
            ['sigle' => 'DRT 223', 'nom' => 'Relations internationales I', 'credits' => 4, 'year_level_id' => 2, 'mention_id' => 8, 'teacher_id' => null, 'categorie' => 'majeur'],
            ['sigle' => 'DRT 211', 'nom' => 'Droit civil I', 'credits' => 6, 'year_level_id' => 2, 'mention_id' => 8, 'teacher_id' => null, 'categorie' => 'majeur'],
            ['sigle' => 'DRT 231', 'nom' => 'Introduction à l\'étude du Droit I', 'credits' => 4, 'year_level_id' => 2, 'mention_id' => 8, 'teacher_id' => null, 'categorie' => 'majeur'],
            ['sigle' => 'DRT 221', 'nom' => 'Droit constitutionnel 1', 'credits' => 6, 'year_level_id' => 2, 'mention_id' => 8, 'teacher_id' => null, 'categorie' => 'majeur'],
            ['sigle' => 'DRT 234', 'nom' => 'Economie', 'credits' => 3, 'year_level_id' => 2, 'mention_id' => 8, 'teacher_id' => null, 'categorie' => 'majeur'],
            ['sigle' => 'DRTJ 211', 'nom' => "Vie de Jesus", 'credits' => 3, 'year_level_id' => 2, 'mention_id' => 8, 'teacher_id' => null, 'categorie' => 'général'],
            ['sigle' => 'DRF 211', 'nom' => 'Français juridique I', 'credits' => 3, 'year_level_id' => 2, 'mention_id' => 8, 'teacher_id' => null, 'categorie' => 'général'],
            ['sigle' => 'DRTI 211', 'nom' => "Informatique", 'credits' => 3, 'year_level_id' => 2, 'mention_id' => 8, 'teacher_id' => null, 'labo_info' => true,'categorie' => 'général'],
            ['sigle' => 'DRA 211', 'nom' => "Anglais I", 'credits' => 3, 'year_level_id' => 2, 'mention_id' => 8, 'teacher_id' => null, 'categorie' => 'général'],

        ];
        foreach ($courses as $course) {
            // Supporte year_level_id (int) ou year_level_ids (array)
            $yearLevelIds = null;
            if (array_key_exists('year_level_ids', $course)) {
                $yearLevelIds = $course['year_level_ids'];
                unset($course['year_level_ids']);
            } elseif (array_key_exists('year_level_id', $course)) {
                $yearLevelIds = [$course['year_level_id']];
                unset($course['year_level_id']);
            }

            // Création ou récupération du cours
            // If sigle is empty, generate a unique placeholder to avoid unique index collisions
            $rawSigle = isset($course['sigle']) ? trim($course['sigle']) : '';
            if ($rawSigle === '') {
                // Generate a unique placeholder sigle without exposing the course name
                $generated = 'NO-SIGLE-' . uniqid();
                $sigleKey = $generated;
            } else {
                $sigleKey = $rawSigle;
            }

            $courseModel = Course::firstOrCreate(
                ['sigle' => $sigleKey],
                [
                    'nom' => $course['nom'],
                    'credits' => $course['credits'],
                    'teacher_id' => $course['teacher_id'],
                    'mention_id' => $course['mention_id'],
                    'labo_info' => $course['labo_info'] ?? false,
                    'categorie' => $course['categorie'],
                ]
            );

            // Attach the mention via pivot so the course can be shared across mentions.
            if (!empty($course['mention_id'])) {
                try {
                    $courseModel->mentions()->syncWithoutDetaching([$course['mention_id']]);
                    $this->command?->info("Seeded course {$sigleKey} attached to mention_id={$course['mention_id']}");
                } catch (\Exception $e) {
                    $this->command?->error("Failed to attach mention to {$sigleKey}: {$e->getMessage()}");
                }
            }

            // Attacher le(s) niveau(x) si présent(s)
            if (!empty($yearLevelIds)) {
                // Normalize to array
                $yearLevelIds = is_array($yearLevelIds) ? $yearLevelIds : [$yearLevelIds];

                // Map values: accept numeric ids or year level codes (e.g. 'L1', 'L1R')
                $normalized = array_values(array_filter(array_map(function ($v) {
                    if (is_null($v) || $v === '') return null;
                    if (is_numeric($v)) return (int) $v;
                    $yl = YearLevel::where('code', (string) $v)->first();
                    return $yl ? $yl->id : null;
                }, $yearLevelIds)));

                // Remove duplicates
                $normalized = array_values(array_unique($normalized));

                if (count($normalized) > 0) {
                    // Keep only existing YearLevel ids
                    $existingIds = YearLevel::whereIn('id', $normalized)->pluck('id')->toArray();
                    if (count($existingIds) > 0) {
                        try {
                            $courseModel->yearLevels()->syncWithoutDetaching($existingIds);
                            $this->command?->info("Seeded course {$sigleKey} attached to year_level_ids=" . implode(',', $existingIds));
                        } catch (\Exception $e) {
                            $this->command?->error("Failed to attach year levels to {$sigleKey}: {$e->getMessage()}");
                        }
                    } else {
                        $this->command?->warn("No matching YearLevel ids found for course {$sigleKey}: requested " . implode(',', $normalized));
                    }
                }
            }
        }

        // Exemple d'attachement multiple :
        // GCOM 100 - Techniques informatiques pour L1 et L1R
        $gcom = Course::where('sigle', 'GCOM 100')->first();
        $l1 = YearLevel::where('code', 'L1')->first();
        $l1r = YearLevel::where('code', 'L1R')->first();
        if ($gcom && $l1 && $l1r) {
            $gcom->yearLevels()->syncWithoutDetaching([$l1->id, $l1r->id]);
        }
    }
}