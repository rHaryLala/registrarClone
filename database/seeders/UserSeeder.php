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
                'name' => 'Enseignant',
                'email' => 'teacher@example.com',
                'password' => Hash::make('password'),
                'plain_password' => 'password',
                'role' => 'teacher',
            ],
            [
                'name' => 'Étudiant',
                'email' => 'student@example.com',
                'password' => Hash::make('password'),
                'plain_password' => 'password',
                'role' => 'student',
            ],
            [
                'name' => 'Parent',
                'email' => 'parent@example.com',
                'password' => Hash::make('password'),
                'plain_password' => 'password',
                'role' => 'parent',
            ],
            [
                'name' => 'Employé',
                'email' => 'employe@example.com',
                'password' => Hash::make('password'),
                'plain_password' => 'password',
                'role' => 'employe',
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }
    }
}