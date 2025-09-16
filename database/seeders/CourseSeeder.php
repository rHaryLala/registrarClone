<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\YearLevel;
use App\Models\Mention;
use App\Models\Teacher;

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
            ['sigle' => 'GCOM 100', 'nom' => 'Techniques informatiques', 'credits' => 3, 'year_level_id' => 1, 'mention_id' => 1, 'teacher_id' => 5, 'besoin_labo' => true],
            ['sigle' => 'RELR 201', 'nom' => 'Méthodes de recherche', 'credits' => 4, 'year_level_id' => 1, 'mention_id' => 1, 'teacher_id' => 5],
            ['sigle' => 'RELG 201', 'nom' => 'Français théologique', 'credits' => 3, 'year_level_id' => 1, 'mention_id' => 1, 'teacher_id' => null],
            ['sigle' => 'RELB 211', 'nom' => 'Introduction à la Bible', 'credits' => 5, 'year_level_id' => 1, 'mention_id' => 1, 'teacher_id' => null],
            ['sigle' => 'RELL 231', 'nom' => 'Grec I', 'credits' => 5, 'year_level_id' => 1, 'mention_id' => 1, 'teacher_id' => 3],
            ['sigle' => 'RELT 241', 'nom' => 'Doctrines bibliques', 'credits' => 5, 'year_level_id' => 1, 'mention_id' => 1, 'teacher_id' => 6],
            ['sigle' => 'RELP 261', 'nom' => 'Colportage', 'credits' => 3, 'year_level_id' => 1, 'mention_id' => 1, 'teacher_id' => 7],
            ['sigle' => 'RELP 281', 'nom' => 'Introduction au service pastoral', 'credits' => 3, 'year_level_id' => 1, 'mention_id' => 1, 'teacher_id' => 8],
            ['sigle' => 'RELP 291', 'nom' => 'Formation spirituelle', 'credits' => 3, 'year_level_id' => 1, 'mention_id' => 1, 'teacher_id' => null],

            //Semestre 1 - L1 - Gestion
            ['sigle' => 'CGMR 201', 'nom' => 'Méthodes d\'études et de recherche', 'credits' => 4, 'year_level_id' => 1, 'mention_id' => 2, 'teacher_id' => 13],
            ['sigle' => 'CGFR 201', 'nom' => 'Français des affaires I', 'credits' => 3, 'year_level_id' => 1, 'mention_id' => 2, 'teacher_id' => 14],
            ['sigle' => 'CGAN 201', 'nom' => 'Anglais I', 'credits' => 3, 'year_level_id' => 1, 'mention_id' => 2, 'teacher_id' => null],
            ['sigle' => 'CGRE 201', 'nom' => 'Jésus, PDG', 'credits' => 3, 'year_level_id' => 1, 'mention_id' => 2, 'teacher_id' => 15],
            ['sigle' => 'CGIN 201', 'nom' => 'Informatique', 'credits' => 4, 'year_level_id' => 1, 'mention_id' => 2, 'teacher_id' => 16, 'besoin_labo' => true],
            ['sigle' => 'GECO 211', 'nom' => 'Introduction à la comptabilité I', 'credits' => 5, 'year_level_id' => 1, 'mention_id' => 2, 'teacher_id' => 9],
            ['sigle' => 'GEMG 211', 'nom' => 'Principes de management', 'credits' => 4, 'year_level_id' => 1, 'mention_id' => 2, 'teacher_id' => 12],
            ['sigle' => 'GEMA 211', 'nom' => 'Mathématiques pour la gestion I', 'credits' => 4, 'year_level_id' => 1, 'mention_id' => 2, 'teacher_id' => null],


            //Semestre 1 - l1 - Informatique
            ['sigle' => 'INAL 211', 'nom' => 'Logique et algorithmique sur Python', 'credits' => 4, 'year_level_id' => 1, 'mention_id' => 3, 'teacher_id' => 4],
            ['sigle' => 'INEL 211', 'nom' => 'Outils bureautiques et internet', 'credits' => 3, 'year_level_id' => 1, 'mention_id' => 3, 'teacher_id' => 17],
            ['sigle' => 'INEN 211', 'nom' => 'Anglais I', 'credits' => 3, 'year_level_id' => 1, 'mention_id' => 3, 'teacher_id' => null],
            ['sigle' => 'INFR 211', 'nom' => 'Français - Langue vivante', 'credits' => 3, 'year_level_id' => 1, 'mention_id' => 3, 'teacher_id' => 14],
            ['sigle' => 'INMA 211', 'nom' => 'Mathématiques générales et statistique', 'credits' => 4, 'year_level_id' => 1, 'mention_id' => 3, 'teacher_id' => null],
            ['sigle' => 'INMR 211', 'nom' => 'Méthode d\'Etude et de Recherche', 'credits' => 4, 'year_level_id' => 1, 'mention_id' => 3, 'teacher_id' => 13],
            ['sigle' => 'INRE 211', 'nom' => 'Vie et enseignement de Jésus', 'credits' => 3, 'year_level_id' => 1, 'mention_id' => 3, 'teacher_id' => 15],
            ['sigle' => 'INSE 211', 'nom' => 'Principes de fonctionnement des ordinateurs', 'credits' => 3, 'year_level_id' => 1, 'mention_id' => 3, 'teacher_id' => null],
            ['sigle' => 'INSE 211', 'nom' => 'Théories des systèmes d\'exploitation', 'credits' => 3, 'year_level_id' => 1, 'mention_id' => 3, 'teacher_id' => null],
        ];
        foreach ($courses as $course) {
            Course::firstOrCreate(
                ['sigle' => $course['sigle']],
                [
                    'nom' => $course['nom'],
                    'credits' => $course['credits'],
                    'teacher_id' => $course['teacher_id'],
                    'year_level_id' => $course['year_level_id'],
                    'mention_id' => $course['mention_id'],
                    'besoin_labo' => $course['besoin_labo'] ?? false,
                ]
            );
        }
    }
}