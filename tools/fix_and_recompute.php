<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Models\Student;
use App\Models\StudentSemesterFee;
use App\Services\InstallmentService;

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$matricule = $argv[1] ?? null;
$targetSemesterId = $argv[2] ?? null;
if (!$matricule || !$targetSemesterId) {
    echo "Usage: php fix_and_recompute.php <matricule> <target_semester_id>\n";
    exit(1);
}

$student = Student::where('matricule', $matricule)->first();
if (!$student) {
    echo "Student with matricule={$matricule} not found\n";
    exit(1);
}

echo "Student found id={$student->id} current_semester_id={$student->semester_id} -> setting semester_id={$targetSemesterId}\n";
    $student->semester_id = intval($targetSemesterId);
    $student->save();

$service = app(InstallmentService::class);
$ssfs = StudentSemesterFee::where('student_id', $student->id)->get();
if ($ssfs->isEmpty()) {
    $currentAcademicYear = \App\Models\AcademicYear::where('active', true)->first();
    $ay = $currentAcademicYear ? $currentAcademicYear->id : null;
    echo "No SSF found — computing for academic_year_id={$ay} semester_id={$targetSemesterId}\n";
    try {
        $rec = $service->computeSemesterFees($student, $ay, $targetSemesterId, null);
        echo "  Upserted dortoir={$rec->dortoir} total_amount={$rec->total_amount}\n";
    } catch (\Throwable $e) {
        echo "  Error during compute: {$e->getMessage()}\n";
    }
} else {
    foreach ($ssfs as $ssf) {
        echo "Recomputing SSF id={$ssf->id} academic_year_id={$ssf->academic_year_id} -> semester_id={$targetSemesterId}\n";
        try {
            $rec = $service->computeSemesterFees($student, $ssf->academic_year_id, $targetSemesterId, null);
            echo "  Updated: dortoir={$rec->dortoir} total_amount={$rec->total_amount}\n";
        } catch (\Throwable $e) {
            echo "  Error computing for ay={$ssf->academic_year_id}: {$e->getMessage()}\n";
        }
    }
}

echo "Done.\n";
