<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Models\Student;
use App\Models\StudentSemesterFee;
use App\Models\Semester;

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$mentionName = 'Sciences Infirmières';
$mention = \App\Models\Mention::where('nom', $mentionName)->first();
if (!$mention) {
    echo "Mention '$mentionName' not found\n";
    exit(1);
}

$students = Student::where('mention_id', $mention->id)->orderBy('id')->get();
if ($students->isEmpty()) {
    echo "No students found for mention {$mentionName}\n";
    exit(0);
}

foreach ($students as $s) {
    echo "Student id={$s->id} matricule={$s->matricule} name={$s->nom} {$s->prenom} statut_interne={$s->statut_interne} semester_id={$s->semester_id}\n";
    $fees = StudentSemesterFee::where('student_id', $s->id)->get();
    if ($fees->isEmpty()) {
        echo "  No student_semester_fees entries\n";
        continue;
    }
    foreach ($fees as $f) {
        $semester = Semester::find($f->semester_id);
        $days = 0;
        if ($semester) {
            $days = $semester->duration ?? 0;
            if (!$days && $semester->date_debut && $semester->date_fin) {
                $days = \Carbon\Carbon::parse($semester->date_debut)->diffInDays(\Carbon\Carbon::parse($semester->date_fin)) + 1;
            }
        }
        echo "  SSF id={$f->id} semester_id={$f->semester_id} academic_year_id={$f->academic_year_id} dortoir={$f->dortoir} total_amount={$f->total_amount} computed_at={$f->computed_at} computed_by={$f->computed_by_user_id} semester_days_calc={$days} semester_duration_field=" . ($semester ? $semester->duration : 'NULL') . "\n";
    }
}

echo "Done.\n";
