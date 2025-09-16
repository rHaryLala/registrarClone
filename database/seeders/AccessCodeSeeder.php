<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccessCodeSeeder extends Seeder
{
    public function run(): void
    {
        $codes = [
            ['code' => 'UAZ2025', 'is_active' => true],
            ['code' => 'INSCRIPTION2025', 'is_active' => true],
            ['code' => 'REEGISTER2026NEWSTUDENT', 'is_active' => true],
            ['code' => 'TESTCODE', 'is_active' => true],
        ];

        foreach ($codes as $code) {
            DB::table('access_codes')->updateOrInsert(
                ['code' => strtoupper(trim($code['code']))],
                ['is_active' => $code['is_active']]
            );
        }
    }
}
