<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = [
            [
                'name' => 'Kancel Daniel',
                'email' => 'uaz.rector@zurcher.edu.mg',
                'telephone' => '038 07 731 38',
                'diplome' => "PhD (Sciences de l'antiquité)"
            ],
            [
                'name' => 'Andrianasolo Tantely',
                'email' => 'uaz.dean@zurcher.edu.mg',
                'telephone' => '034 18 810 86',
                'diplome' => 'MBA, PhD en cours'
            ],
            [
                'name' => 'Andriamanjato Bruno',
                'email' => 'randrianarisoa.hery@zurcher.edu.mg',
                'telephone' => '034 08 725 37',
                'diplome' => "Master en théologie, MA (finance), PhD en cours"
            ],
            [
                'name' => 'Rakotomahefa Andriamirindra',
                'email' => 'uaz.studentsaffairs@zurcher.edu.mg',
                'telephone' => '034 07 056 20',
                'diplome' => "Doctorat (Sciences cognitives et applications)"
            ],
            [
                'name' => 'Rakotoarisoa Tahina Hosea',
                'email' => 'tahinahosearak@zurcher.edu.mg ',
                'telephone' => '034 02 019 06',
                'diplome' => 'MDiv, en cours'
            ],
            [
                'name' => 'Andriamiarintsoa Laurent',
                'email' => 'laurentandriamiarintsoa@gmail.com ',
                'telephone' => '034 67 914 82',
                'diplome' => 'DMin, en cours'
            ],
            [
                'name' => 'Rajaonarison Velomanantsoa',
                'email' => 'rajaonarisonv@iou.adventist.org',
                'telephone' => '033 74 701 50',
                'diplome' => ''
            ],
            [
                'name' => 'Ratsimbason Jacques',
                'email' => 'jacques.ratsimbason@yahoo.com',
                'telephone' => '034 05 147 77',
                'diplome' => 'DMin'
            ],
            [
                'name' => 'Kancel Christelle',
                'email' => 'christelle.kancel@zurcher.edu.mg',
                'telephone' => '',
                'diplome' => 'MA (Economie)',
            ],
            [
                'name' => 'Andriatiana Mahasetra',
                'email' => 'mahasetra.a@zurcher.edu.mg',
                'telephone' => '',
                'diplome' => 'MBA (Finance et Comptabilité)',
            ],
            [
                'name' => 'Andriambahoaka Manda',
                'email' => 'andriamanda@zurcher.edu.mg',
                'telephone' => '',
                'diplome' => 'MA (Economie), PhD',
            ],
            [
                'name' => 'Ranala Antra Miary Zo',
                'email' => 'rmiaryzo@gmail.com',
                'telephone' => '',
                'diplome' => '',
            ],
            [
                'name' => 'Nomenjanahary Roger Francky',
                'email' => 'nomenjanahary.r@zurcher.edu.mg',
                'telephone' => '',
                'diplome' => '',
            ],
            [
                'name' => 'Ravaonirina Jeanne Eléonore',
                'email' => '',
                'telephone' => '',
                'diplome' => '',
            ],
            [
                'name' => 'Rabioarison Nomenjanahary Riault',
                'email' => 'rabioarison.n@zurcher.edu.mg',
                'telephone' => '034 91 519 06',
                'diplome' => '',
            ],
            [
                'name' => 'Ranaivomanoelina Herisarobidy Seth',
                'email' => 'herisarobidyseth@gmail.com',
                'telephone' => '034 89 604 63',
                'diplome' => '',
            ],
            [
                'name' => 'Rabeson Ariniaina Mamitiana ',
                'email' => 'rabeson.a@zurcher.edu.mg',
                'telephone' => '038 69 310 04',
                'diplome' => '',
            ],
            [
                'name' => 'Andrianomenjanahary Ladina Sedera',
                'email' => 'ladina.sedera@zurcher.edu.mg',
                'telephone' => '034 11 104 72',
                'diplome' => '',
            ],
            [
                'name' => 'Randrianasolo Misaela',
                'email' => 'randrianasolo.misaela@gmail.com',
                'telephone' => '034 99 729 88',
                'diplome' => '',
            ],
        ];
        foreach ($teachers as $teacher) {
            Teacher::firstOrCreate(
                ['email' => $teacher['email']],
                $teacher
            );
        }
    }
}
