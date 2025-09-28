<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Models\Student;
use App\Models\StudentSemesterFee;
use App\Models\AcademicFee;
use App\Models\Semester;
use App\Services\InstallmentService;

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$argStudentId = $argv[1] ?? null;

$mentionName = 'Sciences Infirmières';

// find mention id
$mention = \App\Models\Mention::where('nom', $mentionName)->first();
if (!$mention) {
    echo "Mention '$mentionName' not found\n";
    exit(1);
}
$mentionId = $mention->id;

if ($argStudentId) {
    $students = Student::where('id', $argStudentId)->get();
} else {
    // find student_semester_fees where dortoir = 366000 and student's mention = mentionId
    $students = Student::join('student_semester_fees', 'students.id', '=', 'student_semester_fees.student_id')
        ->where('students.mention_id', $mentionId)
        ->where('student_semester_fees.dortoir', 366000)
        ->select('students.*', 'student_semester_fees.semester_id as ssf_semester_id', 'student_semester_fees.academic_year_id as ssf_ay')
        ->get();
}

if ($students->isEmpty()) {
    echo "No matching students found (mention={$mentionName})\n";
    exit(0);
}

$service = app(InstallmentService::class);

foreach ($students as $s) {
    echo "--- Student id={$s->id} matricule={$s->matricule} name={$s->nom} {$s->prenom}\n";
    $ssf = StudentSemesterFee::where('student_id', $s->id)->where('semester_id', $s->ssf_semester_id)->first();
    if (!$ssf) {
        echo "  No student_semester_fee for semester_id={$s->ssf_semester_id}\n";
        continue;
    }
    echo "  Current dortoir in DB: {$ssf->dortoir}, total_amount: {$ssf->total_amount}\n";

    $semesterId = $s->ssf_semester_id;
    $semester = Semester::find($semesterId);
    if (!$semester) {
        echo "  Semester id {$semesterId} not found\n";
    } else {
        $days = $semester->duration ?? 0;
        if (!$days && $semester->date_debut && $semester->date_fin) {
            $days = \Carbon\Carbon::parse($semester->date_debut)->diffInDays(\Carbon\Carbon::parse($semester->date_fin)) + 1;
        }
        echo "  Semester id={$semester->id} ordre={$semester->ordre} duration={$semester->duration} date_debut={$semester->date_debut} date_fin={$semester->date_fin} => computed days={$days}\n";
    }

    // Re-run selection logic for dortoir AcademicFee
    $academicYearId = $ssf->academic_year_id;
    $dortoirAF = AcademicFee::whereHas('feeType', function($q){ $q->where('name','Dortoir'); })
                ->where('mention_id', $s->mention_id)
                ->where('academic_year_id', $academicYearId)
                ->first();
    if (!$dortoirAF) {
        $dortoirAF = AcademicFee::whereHas('feeType', function($q){ $q->where('name','Dortoir'); })
                    ->where('academic_year_id', $academicYearId)
                    ->first();
    }
    if (!$dortoirAF) {
        $dortoirAF = AcademicFee::whereHas('feeType', function($q){ $q->where('name','Dortoir'); })->first();
    }

    if ($dortoirAF) {
        echo "  Selected dortoir AcademicFee id={$dortoirAF->id} amount={$dortoirAF->amount}\n";
        $computed = ($days > 0) ? round($dortoirAF->amount * $days, 2) : $dortoirAF->amount;
        echo "  Computed dortoir (amount * days): {$dortoirAF->amount} * {$days} = {$computed}\n";
    } else {
        echo "  No dortoir AcademicFee found\n";
    }

    // Show path: check if semester->duration set or date range
    // Optionally perform recompute and update DB
    echo "  Recomputing and updating student_semester_fees record...\n";
    try {
        $record = $service->computeSemesterFees($s, $academicYearId, $semesterId, null);
        echo "  Updated dortoir={$record->dortoir} total_amount={$record->total_amount}\n";
    } catch (\Throwable $e) {
        echo "  Error during recompute: {$e->getMessage()}\n";
    }
}

echo "Done.\n";
