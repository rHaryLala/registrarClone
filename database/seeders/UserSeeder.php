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
                'name' => 'Hary Lala Rabenamana',
                'email' => 'rabenamana.h@zurcher.edu.mg',
                'password' => Hash::make('3453Student23'),
                'plain_password' => '3453Student23',
                'role' => 'superadmin',
            ],            [
                'name' => 'Daniella Malalanirina',
                'email' => 'daniellamalalanirina@zurcher.edu.mg',
                'password' => Hash::make('admin12345'),
                'plain_password' => 'admin12345',
                'role' => 'superadmin',
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'plain_password' => 'password',
                'role' => 'admin',
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

        // Optionnel: Créer des utilisateurs supplémentaires pour les tests
        $this->createAdditionalUsers();
    }

    /**
     * Créer des utilisateurs supplémentaires pour les tests
     */
    private function createAdditionalUsers(): void
    {
        // Ajouter quelques étudiants supplémentaires
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => 'Étudiant ' . $i,
                'email' => 'student' . $i . '@example.com',
                'password' => Hash::make('password'),
                'plain_password' => 'password',
                'role' => 'student',
            ]);
        }

        // Ajouter quelques enseignants supplémentaires
        for ($i = 1; $i <= 3; $i++) {
            User::create([
                'name' => 'Enseignant ' . $i,
                'email' => 'teacher' . $i . '@example.com',
                'password' => Hash::make('password'),
                'plain_password' => 'password',
                'role' => 'teacher',
            ]);
        }

        // Ajouter quelques parents supplémentaires
        for ($i = 1; $i <= 3; $i++) {
            User::create([
                'name' => 'Parent ' . $i,
                'email' => 'parent' . $i . '@example.com',
                'password' => Hash::make('password'),
                'plain_password' => 'password',
                'role' => 'parent',
            ]);
        }

        // Ajouter quelques employés supplémentaires
        for ($i = 1; $i <= 2; $i++) {
            User::create([
                'name' => 'Employé ' . $i,
                'email' => 'employe' . $i . '@example.com',
                'password' => Hash::make('password'),
                'plain_password' => 'password',
                'role' => 'employe',
            ]);
        }
    }
}