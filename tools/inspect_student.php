<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Models\Student;

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$mat = $argv[1] ?? null;
if (!$mat) { echo "Usage: php inspect_student.php <matricule>\n"; exit(1); }
$s = Student::where('matricule', $mat)->first();
if (!$s) { echo "Student not found\n"; exit(1); }
echo "id={$s->id} matricule={$s->matricule} mention_id={$s->mention_id} year_level_id={$s->year_level_id} semester_id={$s->semester_id}\n";
echo "prenom={$s->prenom} nom={$s->nom}\n";
