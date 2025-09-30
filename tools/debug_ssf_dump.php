<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Student;
use App\Models\StudentSemesterFee;

$students = Student::take(10)->get();
$out = [];
foreach ($students as $s) {
    $ssf = StudentSemesterFee::where('student_id', $s->id)->first();
    $out[] = [
        'student_id' => $s->id,
        'matricule' => $s->matricule,
        'academic_year_id' => $s->academic_year_id,
        'semester_id' => $s->semester_id,
        'ssf_present' => $ssf ? true : false,
        'ssf' => $ssf ? $ssf->toArray() : null
    ];
}

echo json_encode($out, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
