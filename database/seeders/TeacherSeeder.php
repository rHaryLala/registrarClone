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
                'email' => 'randriamanjatob@zurcher.edu.mg ',
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
                'diplome' => 'PhD, en cours'
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
                'name' => 'Andriantiana Mahasetra',
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
            [
                'name' => 'Tafitarison Narindra',
                'email' => 'tafitarison@zurcher.edu.mg',
                'telephone' => '',
                'diplome' => '',
            ],
            [
                'name' => 'Mahafoudhou Moussa Hamadi',
                'email' => 'hamadi.m@zurcher.edu.mg',
                'telephone' => '',  
                'diplome' => '',
            ],
            [
                'name' => 'Rakotonirina Alain Barnabé',
                'email' => 'rakotoalainb@zurcher.edu.mg',
                'telephone' => '034 76 649 57',
                'diplome' => 'Doctorat en informatique',
            ],
            [
                'name' => 'Ravoninjatovo Sitraka',
                'email' => 'sitrakarsio@zurcher.edu.mg',
                'telephone' => '',
                'diplome' => 'MSN',
            ],
            [
                'name' => 'Rasoanirina Elisoa',
                'email' => 'ravoninjatovoel@zurcher.edu.mg',
                'telephone' => '',
                'diplome' => 'Master en gestion hospitalière',
            ],
            [
                'name' => 'Rabemanantsoa Holitiana',
                'email' => 'holitiana@zurcher.edu.mg',
                'telephone' => '',
                'diplome' => 'MA (Education), BSN (Sage-femme)',
            ],
            [
                'name' => 'Andriatahiananirina Sarobidy',
                'email' => 'sarobidiniaina.h@zurcher.edu.mg',
                'telephone' => '',
                'diplome' => '',
            ],
            [
                'name' => 'Ratsimbamialisoa Nasolo',
                'email' => 'ratsimbamialisoa.n@zurcher.edu.mg',
                'telephone' => '',
                'diplome' => '',
            ],
            [
                'name' => 'Rasamy Martino Brunel',
                'email' => 'rasamybrunel@gmail.com',
                'telephone' => '',
                'diplome' => 'Doctorat en médecine',
            ],
            [
                'name' => 'Rasolohery Sedra Nihoarana',
                'email' => 'email',
                'telephone' => '',
                'diplome' => 'Doctorat en médecine',
            ], 
            [
                'name' => 'Malalanirina Daniella',
                'email' => 'daniellamalalanirina@zurcher.edu.mg',
                'telephone' => '',
                'diplome' => 'Master en santé publique',
            ],
            [
                'name' => 'Ravololomanana Nirisoa Sahondra',
                'email' => 'sahondra@zurcher.edu.mg',
                'telephone' => '',
                'diplome' => 'MA (Education)',
            ],
            [
                'name' => 'Ranala Marc Arthur',
                'email' => 'marcarthurranala@gmail.com',
                'telephone' => '',
                'diplome' => 'MA (Leadership)',
            ],
            [
                'name' => 'Ramahoherilalaina Jimmy Lovasoa',
                'email' => 'herilovas@zurcher.edu.mg',
                'telephone' => '',
                'diplome' => 'Master en informatique',
            ],
            [
                'name' => 'Pritty Bairagee',
                'email' => '',
                'telephone' => '',
                'diplome' => 'PhD (Administration de l\'éducation)',
            ],
            [
                'name' => 'Robert Bairagee',
                'email' => '',
                'telephone' => '',
                'diplome' => 'PhD (Administration de l\'éducation)',
            ],
            [
                'name' => 'Rakotondrainibe Dina',
                'email' => 'dina.rakoto.fle@zurcher.edu.mg',
                'telephone' => '',
                'diplome' => 'MA (Français langue étrangère)',
            ],
            [
                'name' => 'Ranaivomanoelina Vonimboahirana Michée',
                'email' => 'vonimboahirana.mimiche@gmail.com',
                'telephone' => '',
                'diplome' => 'MA (Anglais)',
            ],
            [
                'name' => 'Ramanantsialonina Malalaniaina',
                'email' => 'uaz.malalaniaina@zurcher.edu.mg',
                'telephone' => '',
                'diplome' => 'Master en informatique',
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
