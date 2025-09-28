<?php
require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$results = [];
$students = \App\Models\Student::whereNotNull('semester_id')->get();
foreach ($students as $s) {
    $sem = \App\Models\Semester::find($s->semester_id);
    $semMention = $sem ? $sem->mention_id : null;
    if ($semMention !== null && intval($semMention) !== intval($s->mention_id)) {
        $results[] = [
            'student_id' => $s->id,
            'matricule' => $s->matricule,
            'student_mention_id' => $s->mention_id,
            'semester_id' => $s->semester_id,
            'semester_mention_id' => $semMention,
        ];
    }
}

if (empty($results)) {
    echo "No mismatches found.\n";
    exit(0);
}

foreach ($results as $r) {
    echo "STUDENT id={$r['student_id']} matricule={$r['matricule']} student_mention_id={$r['student_mention_id']} semester_id={$r['semester_id']} semester_mention_id={$r['semester_mention_id']}\n";
}

echo "Found " . count($results) . " mismatches.\n";
