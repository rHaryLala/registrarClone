<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            ['sigle' => 'GCAS 100', 'nom' => 'Français cours de soutien', 'credits' => 4],
            ['sigle' => 'MATH 101', 'nom' => 'Mathématiques Générales', 'credits' => 4],
            ['sigle' => 'INFO 110', 'nom' => 'Introduction à l’Informatique', 'credits' => 3],
            ['sigle' => 'THEO 120', 'nom' => 'Introduction à la Théologie', 'credits' => 3],
            ['sigle' => 'EDUC 130', 'nom' => 'Psychologie de l’Education', 'credits' => 3],
            ['sigle' => 'COMM 140', 'nom' => 'Communication Orale', 'credits' => 2],
            ['sigle' => 'ANGL 150', 'nom' => 'Anglais Général', 'credits' => 3],
            ['sigle' => 'DROI 160', 'nom' => 'Introduction au Droit', 'credits' => 3],
            ['sigle' => 'GEST 170', 'nom' => 'Principes de Gestion', 'credits' => 3],
            ['sigle' => 'INFIR 180', 'nom' => 'Soins Infirmiers Fondamentaux', 'credits' => 4],
            ['sigle' => 'MATH 102', 'nom' => 'Statistiques', 'credits' => 3],
            ['sigle' => 'INFO 210', 'nom' => 'Programmation I', 'credits' => 4],
            ['sigle' => 'THEO 220', 'nom' => 'Histoire de l’Eglise', 'credits' => 2],
            ['sigle' => 'EDUC 230', 'nom' => 'Méthodologie de la Recherche', 'credits' => 2],
            ['sigle' => 'COMM 240', 'nom' => 'Techniques d’Expression Ecrite', 'credits' => 2],
            ['sigle' => 'ANGL 250', 'nom' => 'Anglais Avancé', 'credits' => 3],
            ['sigle' => 'DROI 260', 'nom' => 'Droit Civil', 'credits' => 3],
            ['sigle' => 'GEST 270', 'nom' => 'Comptabilité Générale', 'credits' => 4],
            ['sigle' => 'INFIR 280', 'nom' => 'Anatomie et Physiologie', 'credits' => 4],
            ['sigle' => 'INFO 220', 'nom' => 'Bases de Données', 'credits' => 3],
        ];
        foreach ($courses as $course) {
            Course::firstOrCreate([
                'sigle' => $course['sigle'],
            ], [
                'nom' => $course['nom'],
                'credits' => $course['credits'],
                'teacher_id' => null,
            ]);
        }
    }
}
