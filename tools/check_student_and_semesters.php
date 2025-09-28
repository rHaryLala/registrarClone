<?php
require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$s = \App\Models\Student::where('matricule','40001')->first();
if ($s) {
    echo "STUDENT: id={$s->id} matricule={$s->matricule} nom={$s->nom} prenom={$s->prenom} mention_id={$s->mention_id} semester_id={$s->semester_id}\n";
} else {
    echo "Student not found\n";
}

$semesters = \App\Models\Semester::orderBy('mention_id')->orderBy('ordre')->get();
foreach ($semesters as $sem) {
    echo "SEM: id={$sem->id} mention_id=" . ($sem->mention_id ?? 'NULL') . " ordre={$sem->ordre} duration=" . ($sem->duration ?? 'NULL') . " date_debut={$sem->date_debut} date_fin={$sem->date_fin}\n";
}
