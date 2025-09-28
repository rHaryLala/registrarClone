<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Models\Student;
use App\Services\InstallmentService;

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$matricule = $argv[1] ?? '40001';
$student = Student::where('matricule', $matricule)->first();
if (!$student) {
    echo "Student not found\n";
    exit(1);
}

$service = app(InstallmentService::class);
$academicYear = \App\Models\AcademicYear::where('active', true)->first();
$ay = $academicYear ? $academicYear->id : null;

$providedSemesterId = 9; // simulate incorrect provided semester

echo "Calling computeSemesterFees for student={$student->id} providedSemester={$providedSemesterId}\n";
$rec = $service->computeSemesterFees($student, $ay, $providedSemesterId, null);

echo "Result: semester_id used in upsert={$rec->semester_id} dortoir={$rec->dortoir} total_amount={$rec->total_amount}\n";
