<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\StudentInstallment;
use App\Models\Student;
use App\Models\AcademicFee;

$items = StudentInstallment::with(['student','academicFee'])->get();
$out = [];
foreach ($items as $it) {
    $out[] = [
        'installment_id' => $it->id,
        'student_id' => $it->student_id,
        'student_matricule' => $it->student ? $it->student->matricule : null,
        'student_name' => $it->student ? ($it->student->firstname . ' ' . $it->student->lastname) : null,
        'academic_fee_id' => $it->academic_fee_id,
        'academic_fee_amount' => $it->academicFee ? (string)$it->academicFee->amount : null,
        'sequence' => $it->sequence,
        'amount_due' => (string)$it->amount_due,
        'due_at' => $it->due_at ? (is_object($it->due_at) ? $it->due_at->toDateTimeString() : (string)$it->due_at) : null,
    ];
}

echo json_encode($out, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL;
