<?php
require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$s = \App\Models\Student::where('matricule','40001')->first();
if ($s) echo "STUDENT: id={$s->id} matricule={$s->matricule} mention_id={$s->mention_id} semester_id={$s->semester_id}\n";
else echo "Student not found\n";

$sem9 = \App\Models\Semester::find(9);
if ($sem9) echo "SEM9: id={$sem9->id} mention_id={$sem9->mention_id} ordre={$sem9->ordre} duration={$sem9->duration}\n";
else echo "Semester 9 not found\n";
