<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = [
            ['name' => 'Rakoto Andrianina', 'email' => 'rakoto.andrianina@zurcher.edu.mg'],
            ['name' => 'Rasoanaivo Fanja', 'email' => 'rasoanaivo.fanja@zurcher.edu.mg'],
            ['name' => 'Randrianarisoa Hery', 'email' => 'randrianarisoa.hery@zurcher.edu.mg'],
            ['name' => 'Ramanantsoa Lova', 'email' => 'ramanantsoa.lova@zurcher.edu.mg'],
            ['name' => 'Ravelojaona Mamy', 'email' => 'ravelojaona.mamy@zurcher.edu.mg'],
            ['name' => 'Ratsimbazafy Tiana', 'email' => 'ratsimbazafy.tiana@zurcher.edu.mg'],
            ['name' => 'Raharison Zo', 'email' => 'raharison.zo@zurcher.edu.mg'],
            ['name' => 'Rabe Jean', 'email' => 'rabe.jean@zurcher.edu.mg'],
        ];
        foreach ($teachers as $teacher) {
            Teacher::firstOrCreate(['email' => $teacher['email']], $teacher);
        }
    }
}
