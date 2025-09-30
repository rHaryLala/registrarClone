<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Rabenamana Hary Lala ',
                'email' => 'rabenamana.h@zurcher.edu.mg',
                'password' => Hash::make('3453Student23'),
                'plain_password' => '3453Student23',
                'role' => 'superadmin',
            ],            
            [
                'name' => 'Malalanirina Daniella',
                'email' => 'daniellamalalanirina@zurcher.edu.mg',
                'password' => Hash::make('admin12345'),
                'plain_password' => 'admin12345',
                'role' => 'superadmin',
            ],
            [
                'name' => 'Nomenjanahary Roger Francky',
                'email' => 'uaz.secretaryacad@zurcher.edu.mg',
                'password' => Hash::make('franckymiddleware2025'),
                'plain_password' => 'franckymiddleware2025',
                'role' => 'superadmin',
            ],
            [
                'name' => 'Kancel Daniel',
                'email' => 'uaz.rector@zurcher.edu.mg',
                'password' => Hash::make('rectordanmiddleware2025'),
                'plain_password' => 'rectordanmiddleware2025',
                'role' => 'dean',
                'mention_id' => 1,
            ],
            //Dean
            [
                'name' => 'Kancel Christelle',
                'email' => 'christelle.kancel@zurcher.edu.mg',
                'password' => Hash::make('christellekanmiddleware2025'),
                'plain_password' => 'christellekanmiddleware2025',
                'role' => 'dean',
                'mention_id' => 2,
            ],
            [
                'name' => 'Rakotomahefa Andriamirindra',
                'email' => 'rindrarakotomahefa@zurcher.edu.mg',
                'password' => Hash::make('rindrarakmiddleware2025'),
                'plain_password' => 'rindrarakmiddleware2025',
                'role' => 'dean',
                'mention_id' => 3,
            ],
            [
                'name' => 'Ravoninjatovo Sitraka',
                'email' => 'sitrakarsio@zurcher.edu.mg',
                'password' => Hash::make('sitrakaravmiddleware2025'),
                'plain_password' => 'sitrakaravmiddleware2025',
                'role' => 'dean',
                'mention_id' => 4,
            ],
            [
                'name' => 'Education Faculty Dean',
                'email' => 'education@zurcher.edu.mg',
                'password' => Hash::make('password'),
                'plain_password' => 'password',
                'role' => 'dean',
                'mention_id' => 5,
            ],
            [
                'name' => 'Andrianasolo Eric Tantely',
                'email' => 'uaz.acaddean@zurcher.edu.mg',
                'password' => Hash::make('tantelyericmiddleware2025'),
                'plain_password' => 'tantelyericmiddleware2025',
                'role' => 'dean',
                'mention_id' => 6,
            ],
            [
                'name' => 'Rakotondrainibe Dina',
                'email' => 'dina.rakoto.fle@zurcher.edu.mg',
                'password' => Hash::make('dinarakotomiddleware2025'),
                'plain_password' => 'dinarakotomiddleware2025',
                'role' => 'dean',
                'mention_id' => 7,
            ],
            [
                'name' => 'Ramanantsialonina Malalaniaina',
                'email' => 'uaz.malalaniaina@zurcher.edu.mg',
                'password' => Hash::make('malalaniainamiddleware2025'),
                'plain_password' => 'malalaniainamiddleware2025',
                'role' => 'dean',
                'mention_id' => 8,
            ],
            // Accountants
            [
                'name' => 'Maherinotsongaina Sabati',
                'email' => 'chief-accountant@zurcher.edu.mg',
                'password' => Hash::make('chiefaccountantPass123'),
                'plain_password' => 'chiefaccountantPass123',
                'role' => 'chief_accountant',
            ],
            [
                'name' => 'Tafitarison Narindra',
                'email' => 'tafitarison@zurcher.edu.mg',
                'password' => Hash::make('narindramiddleware2025'),
                'plain_password' => 'narindramiddleware2025',
                'role' => 'chief_accountant',
            ],
            [
                'name' => 'Randrianasolotiana Mauretis',
                'email' => 'mauretis.t@zurcher.edu.mg',
                'password' => Hash::make('uazcomptablepass2025'),
                'plain_password' => 'uazcomptablepass2025',
                'role' => 'chief_accountant',
            ],
            // Accountants cashier
            [
                'name' => 'Raberanto Mirana',
                'email' => 'miranarabe@zurcher.edu.mg',
                'password' => Hash::make('accountantPass123'),
                'plain_password' => 'accountantPass123',
                'role' => 'accountant',
            ],
            [
                'name' => 'Ramiadamanana Mamisoa Samoela',
                'email' => 'ramiadamanana.m@zurcher.edu.mg',
                'password' => Hash::make('ramiadamanana2025'),
                'plain_password' => 'ramiadamanana2025',
                'role' => 'accountant',
            ],
            [
                'name' => 'Raharintsoa Verotiana',
                'email' => 'uaz.caisse@zurcher.edu.mg',
                'password' => Hash::make('accountantPass456'),
                'plain_password' => 'accountantPass456',
                'role' => 'accountant',
            ],
            // Multimedia Responsible
            [
                'name' => 'Filamatriniaina Taniah',
                'email' => 'uaz.assistante@zurcher.edu.mg',
                'password' => Hash::make('multimediaPass123'),
                'plain_password' => 'multimediaPass123',
                'role' => 'multimedia',
            ],
            [
                'name' => 'Fanomezanirina Sombiniaina Mireille',
                'email' => 'fanomezanirina.s@zurcher.edu.mg',
                'password' => Hash::make('FANOMEZANIRINA'),
                'plain_password' => 'FANOMEZANIRINA',
                'role' => 'multimedia',
            ]
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }
    }
}