<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$status = $kernel->bootstrap();

use App\Models\AcademicFee;

$fees = AcademicFee::all();
$out = [];
foreach ($fees as $f) {
    $out[] = [
        'id' => $f->id,
        'fee_type_id' => $f->fee_type_id,
        'amount' => (string)$f->amount,
        'mention_id' => $f->mention_id,
        'level' => $f->level,
    //'is_internal' => $f->is_internal,
        'academic_year' => $f->academic_year,
        'semester' => $f->semester,
    ];
}

echo json_encode($out, JSON_PRETTY_PRINT) . PHP_EOL;
