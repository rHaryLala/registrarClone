<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Models\Student;
use App\Models\StudentSemesterFee;
use App\Models\Semester;
use App\Services\InstallmentService;

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$matricule = $argv[1] ?? null;
if (!$matricule) {
    echo "Usage: php run_debug_by_matricule.php <matricule>\n";
    exit(1);
}

$student = Student::where('matricule', $matricule)->first();
if (!$student) {
    echo "Student with matricule={$matricule} not found\n";
    exit(1);
}

echo "Found student id={$student->id} matricule={$student->matricule} name={$student->nom} {$student->prenom} mention_id={$student->mention_id} semester_id={$student->semester_id}\n";

$ssfs = StudentSemesterFee::where('student_id', $student->id)->get();
if ($ssfs->isEmpty()) {
    echo "No student_semester_fees for this student\n";
    // As fallback, if student has semester_id and there's an active academic year, compute for that
    $semesterId = $student->semester_id;
    $currentAcademicYear = \App\Models\AcademicYear::where('active', true)->first();
    $academicYearId = $currentAcademicYear ? $currentAcademicYear->id : null;
    echo "Attempting compute with semester_id={$semesterId} academic_year_id={$academicYearId}\n";
    try {
        $service = app(InstallmentService::class);
        $rec = $service->computeSemesterFees($student, $academicYearId, $semesterId, null);
        echo "Computed and upserted: dortoir={$rec->dortoir} total_amount={$rec->total_amount}\n";
    } catch (\Throwable $e) {
        echo "Error computing: {$e->getMessage()}\n";
    }
    exit(0);
}

$service = app(InstallmentService::class);
foreach ($ssfs as $ssf) {
    echo "SSF id={$ssf->id} academic_year_id={$ssf->academic_year_id} semester_id={$ssf->semester_id} dortoir={$ssf->dortoir} total_amount={$ssf->total_amount} computed_at={$ssf->computed_at}\n";
    $semester = Semester::find($ssf->semester_id);
    if ($semester) {
        $days = $semester->duration ?? 0;
        if (!$days && $semester->date_debut && $semester->date_fin) {
            $days = \Carbon\Carbon::parse($semester->date_debut)->diffInDays(\Carbon\Carbon::parse($semester->date_fin)) + 1;
        }
        echo "  Semester id={$semester->id} ordre={$semester->ordre} duration={$semester->duration} date_debut={$semester->date_debut} date_fin={$semester->date_fin} => computed days={$days}\n";
    } else {
        echo "  Semester id={$ssf->semester_id} not found\n";
    }

    echo "  Recomputing via InstallmentService::computeSemesterFees(...)\n";
    try {
        $rec = $service->computeSemesterFees($student, $ssf->academic_year_id, $ssf->semester_id, null);
        echo "  Updated record: dortoir={$rec->dortoir} total_amount={$rec->total_amount} computed_at={$rec->computed_at}\n";
    } catch (\Throwable $e) {
        echo "  Error during recompute: {$e->getMessage()}\n";
    }
}

echo "Done.\n";
