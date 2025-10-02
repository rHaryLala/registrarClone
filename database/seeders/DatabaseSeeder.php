<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Mention;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\Semester;
use App\Models\AcademicYear;
use App\Models\AccessCode;
use App\Models\Parcours;
use App\Models\YearLevel;
use App\Models\AccountCode;
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
            MentionSeeder::class,
            UserSeeder::class,
            // StudentSeeder::class,
            // TeacherSeeder::class,
            YearLevelSeeder::class,
            AcademicYearSeeder::class,
            SemesterSeeder::class,
            AccessCodeSeeder::class,
            ParcoursSeeder::class,
            // CourseSeeder::class,
            AccountCodeSeeder::class,
            \Database\Seeders\FeeTypeSeeder::class,
            \Database\Seeders\PaymentModeSeeder::class,
            \Database\Seeders\AcademicFeeSeeder::class,
        ]);
    }
}
