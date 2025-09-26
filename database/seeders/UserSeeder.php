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
                'email' => 'uaz.dean@zurcher.edu.mg',
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
                'name' => 'Comptable Principal',
                'email' => 'accountant1@zurcher.edu.mg',
                'password' => Hash::make('accountantPass123'),
                'plain_password' => 'accountantPass123',
                'role' => 'accountant',
            ],
            [
                'name' => 'Comptable Secondaire',
                'email' => 'accountant2@zurcher.edu.mg',
                'password' => Hash::make('accountantPass456'),
                'plain_password' => 'accountantPass456',
                'role' => 'accountant',
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }
    }
}