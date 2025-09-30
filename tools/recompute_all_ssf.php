<?php
// tools/recompute_all_ssf.php
// Bootstrap Laravel and recompute StudentSemesterFee for all students with academic_year_id and semester_id
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Student;
use App\Services\InstallmentService;

$count = 0;
$fails = 0;
$start = microtime(true);

Student::whereNotNull('academic_year_id')->whereNotNull('semester_id')->chunk(100, function($students) use (&$count, &$fails) {
    foreach ($students as $s) {
        try {
            (new InstallmentService())->computeSemesterFees($s->fresh(), $s->academic_year_id, $s->semester_id, 1);
            $count++;
            echo "OK: {$s->id}\n";
        } catch (\Throwable $e) {
            $fails++;
            echo "ERR: {$s->id} -> {$e->getMessage()}\n";
        }
    }
});
$duration = round(microtime(true) - $start, 2);
echo "DONE processed={$count} failed={$fails} time={$duration}s\n";
