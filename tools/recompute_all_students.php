<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Models\Student;
use App\Services\InstallmentService;

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Starting recompute for all students...\n";

$service = app(InstallmentService::class);

$total = 0;
$done = 0;
$skipped = 0;
$errors = 0;

// Use chunking to avoid memory spikes
Student::chunk(200, function($students) use (&$total, &$done, &$skipped, &$errors, $service) {
    foreach ($students as $s) {
        $total++;
        $sid = $s->id;
        $mat = $s->matricule ?? 'NULL';
        if (empty($s->academic_year_id) || empty($s->semester_id)) {
            echo "[$total] SKIP student_id={$sid} matricule={$mat} (no academic_year_id or semester_id)\n";
            $skipped++;
            continue;
        }

        try {
            $rec = $service->computeSemesterFees($s, $s->academic_year_id, $s->semester_id, null);
            echo "[$total] OK   student_id={$sid} matricule={$mat} ssf_id={$rec->id} semester_id={$rec->semester_id} dortoir={$rec->dortoir} total={$rec->total_amount}\n";
            $done++;
        } catch (\Throwable $e) {
            echo "[$total] ERR  student_id={$sid} matricule={$mat} error={$e->getMessage()}\n";
            $errors++;
        }
    }
});

echo "\nRecompute finished. total={$total} done={$done} skipped={$skipped} errors={$errors}\n";
