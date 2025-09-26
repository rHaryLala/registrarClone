<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\YearLevel;
use App\Models\Mention;
use App\Models\Semester;
use App\Models\Parcours;
use App\Models\AcademicYear;
use Illuminate\Support\Str;

class StudentSeeder extends Seeder
{
    public function run()
    {
    // use default locale so common formatters like state exist
    $faker = \Faker\Factory::create();

    $yearLevels = YearLevel::pluck('id')->toArray();
    $mentions = Mention::pluck('id')->toArray();
    $parcours = Parcours::pluck('id')->toArray();

        // ensure there is at least one of each related entity; if missing, skip seeding rather than creating defaults
        if (empty($yearLevels)) {
            if ($this->command) {
                $this->command->info('StudentSeeder: no YearLevel entries found, skipping student seeding.');
            }
            return;
        }
        if (empty($mentions)) {
            $mentions = [Mention::firstOrCreate(['nom' => 'Default Mention'])->id];
        }
        // Use only the active academic year and its semesters. Do not create a default AY/semester here.
        $activeAcademicYear = AcademicYear::where('active', true)->first();
        if (!$activeAcademicYear) {
            if ($this->command) {
                $this->command->info('StudentSeeder: no active academic year found, skipping student seeding.');
            }
            return;
        }

        $semesters = Semester::where('academic_year_id', $activeAcademicYear->id)->pluck('id')->toArray();
        if (empty($semesters)) {
            if ($this->command) {
                $this->command->info('StudentSeeder: no semesters found for active academic year, skipping student seeding.');
            }
            return;
        }
        if (empty($parcours)) {
            $defaultMentionId = $mentions[0] ?? Mention::firstOrCreate(['nom' => 'Default Mention'])->id;
            $parcours = [Parcours::firstOrCreate(['nom' => 'Default Parcours', 'mention_id' => $defaultMentionId])->id];
        }
        // Ensure academicYears uses the active academic year only
        $academicYears = [$activeAcademicYear->id];

        // Create 20 sample students (adjust count as needed)
        for ($i = 0; $i < 20; $i++) {
            $mentionId = $faker->randomElement($mentions);
            $yearLevelId = $faker->randomElement($yearLevels);
            $semesterId = $faker->randomElement($semesters);
            $parcoursId = $faker->randomElement($parcours);
            $academicYearId = $faker->randomElement($academicYears);

            $plainPassword = 'Student' . $faker->randomNumber(5);

            $data = [
                'nom' => $faker->lastName,
                'prenom' => $faker->firstName,
                'sexe' => $faker->randomElement(['M', 'F']),
                'date_naissance' => $faker->date('Y-m-d', '-18 years'),
                'lieu_naissance' => $faker->city,
                'nationalite' => 'Malagasy',
                'religion' => 'Adventiste du 7ème jour',
                'etat_civil' => $faker->randomElement(['célibataire', 'marié', 'divorcé', 'veuf']),
                'passport_status' => false,
                'passport_numero' => null,
                'nom_pere' => $faker->name,
                'profession_pere' => $faker->jobTitle,
                'contact_pere' => $faker->phoneNumber,
                'nom_mere' => $faker->name,
                'profession_mere' => $faker->jobTitle,
                'contact_mere' => $faker->phoneNumber,
                'adresse_parents' => $faker->address,
                'telephone' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'adresse' => $faker->address,
                'region' => $faker->state,
                'district' => $faker->city,
                'bacc_serie' => null,
                'bacc_date_obtention' => null,
                'bursary_status' => false,
                'sponsor_nom' => null,
                'sponsor_prenom' => null,
                'sponsor_telephone' => null,
                'sponsor_adresse' => null,
                'year_level_id' => $yearLevelId,
                'mention_id' => $mentionId,
                'semester_id' => $semesterId,
                'parcours_id' => $parcoursId,
                'academic_year_id' => $academicYearId,
                'statut_interne' => $faker->randomElement(['interne', 'externe']),
                'abonne_caf' => $faker->boolean(30),
                'password' => bcrypt($plainPassword),
                'plain_password' => $plainPassword,
                'taille' => null,
            ];

            $student = Student::create($data);

            // Try to generate matricule (requires mention id)
            if ($mentionId) {
                try {
                    $student->generateMatricule($mentionId);
                } catch (\Exception $e) {
                    // fallback: simple random matricule
                    $student->matricule = strtoupper(Str::random(6));
                    $student->save();
                }
            }

            // Try to generate account code (best effort)
            try {
                $student->generateAccountCode();
            } catch (\Exception $e) {
                // ignore if generation fails
            }
        }
    }
}
