<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Mention;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\Semester;
use App\Models\AcademicYear;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            // StudentSeeder::class,
            MentionSeeder::class,
            TeacherSeeder::class,
            CourseSeeder::class,
            SemesterSeeder::class,
            AcademicYearSeeder::class,
        ]);
    }
}
