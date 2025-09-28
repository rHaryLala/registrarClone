<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Models\Student;
use App\Models\Semester;
use App\Services\InstallmentService;

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Starting mass fix: assign semester ordre=1 per student's mention and recompute fees\n";

$service = app(InstallmentService::class);
$students = Student::all();
$fixed = 0;
$skipped = 0;
$noSemester = 0;

foreach ($students as $s) {
    $targetSem = Semester::where('mention_id', $s->mention_id)->where('ordre', 1)->first();
    if (!$targetSem) {
        echo "No semester ordre=1 for mention_id={$s->mention_id} (student id={$s->id})\n";
        $noSemester++;
        continue;
    }

    if (intval($s->semester_id) !== intval($targetSem->id)) {
        // try to save using model to honour hook; temporarily set and save
        try {
            $old = $s->semester_id;
            $s->semester_id = $targetSem->id;
            $s->save();
            // recompute fees for active academic year or existing ssf entries
            $currentAY = \App\Models\AcademicYear::where('active', true)->first();
            $ay = $currentAY ? $currentAY->id : null;
            try {
                $service->computeSemesterFees($s, $ay, $targetSem->id, null);
            } catch (\Throwable $e) {
                echo "  Warning recompute failed for student {$s->id}: {$e->getMessage()}\n";
            }
            echo "Fixed student id={$s->id} matricule={$s->matricule}: semester {$old} -> {$targetSem->id}\n";
            $fixed++;
        } catch (\Throwable $e) {
            echo "Failed to update student id={$s->id} matricule={$s->matricule}: {$e->getMessage()}\n";
            $skipped++;
        }
    }
}

echo "Done. fixed={$fixed}, skipped={$skipped}, noSemester={$noSemester}\n";
