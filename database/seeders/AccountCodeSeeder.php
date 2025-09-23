<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AccountCodeSeeder extends Seeder
{
    public function run()
    {
        $csvFile = database_path('imports/BD COMPTE ETUDIANT.csv');
        $file = fopen($csvFile, 'r');

        // Skip header row
        fgetcsv($file);

        // Read and import data
        DB::beginTransaction();
        try {
            while (($data = fgetcsv($file, 0, ',')) !== false) {
                if (!empty($data[0])) { // Check if ACCT code exists
                    $accountCode = trim($data[0]); // Nettoyer le code
                    
                    // Vérifier si ce code n'existe pas déjà
                    if (!DB::table('account_codes')->where('account_code', $accountCode)->exists()) {
                        DB::table('account_codes')->insert([
                            'account_code' => $accountCode,
                            'matricule' => null, // On laisse le matricule null pour l'instant
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Error during account codes import: " . $e->getMessage());
            throw $e;
        }

        fclose($file);
    }
}
