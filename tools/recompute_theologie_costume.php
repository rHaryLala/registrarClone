<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Models\Student;
use App\Models\Semester;
use App\Services\InstallmentService;

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Recomputing costume fees for Theologie (mention_id=1) first-year first-semester students...\n";

$service = app(InstallmentService::class);
$students = Student::where('mention_id', 1)->get();
$fixed = 0;
$errors = 0;

foreach ($students as $s) {
    // pick the semester corresponding to ordre=1 for this student's mention
    $sem = Semester::where('mention_id', $s->mention_id)->where('ordre', 1)->first();
    if (!$sem) {
        echo "Student id={$s->id} matricule={$s->matricule} - no ordre=1 semester for mention\n";
        continue;
    }

    try {
        $rec = $service->computeSemesterFees($s, $s->academic_year_id ?? null, $sem->id, null);
        echo "OK student_id={$s->id} matricule={$s->matricule} ssf_id={$rec->id} frais_costume={$rec->frais_costume}\n";
        $fixed++;
    } catch (\Throwable $e) {
        echo "ERR student_id={$s->id} matricule={$s->matricule} error={$e->getMessage()}\n";
        $errors++;
    }
}

echo "Done. fixed={$fixed} errors={$errors}\n";
