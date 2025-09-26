<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Models\Student;
use App\Models\AcademicFee;
use App\Models\PaymentMode;
use App\Services\InstallmentService;
use Illuminate\Support\Facades\DB;

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Starting generation of frais généraux installments for students...\n";

$students = Student::all();
$totalCreated = 0;
$skipped = 0;
$noFee = 0;
$noPaymentMode = 0;

$currentAcademicYear = \App\Models\AcademicYear::where('active', true)->first();
$aqYear = $currentAcademicYear ? $currentAcademicYear->id : null;

foreach ($students as $student) {
    $existing = \App\Models\StudentInstallment::where('student_id', $student->id)->count();
    if ($existing > 0) {
        // already has installments
        $skipped++;
        continue;
    }

    // Ensure we have essential fields
    if (!$student->year_level_id) {
        echo "SKIP student {$student->id} ({$student->matricule}): missing year_level_id\n";
        $skipped++;
        continue;
    }

    $levelId = $student->year_level_id;
    $semesterId = $student->semester_id ?? null;
    $isInternal = ($student->statut_interne === 'interne');
    $feeTypeName = 'Frais Généraux';

    // same matching order as controller
    $academicFee = null;
    $academicFee = AcademicFee::whereHas('feeType', function($q) use ($feeTypeName){ $q->where('name', $feeTypeName); })
        ->where('mention_id', $student->mention_id)
        ->where('year_level_id', $levelId)
        ->where('academic_year_id', $aqYear)
        ->where('semester_id', $semesterId)
        ->first();

    if (!$academicFee) {
        $academicFee = AcademicFee::whereHas('feeType', function($q) use ($feeTypeName){ $q->where('name', $feeTypeName); })
            ->where('mention_id', $student->mention_id)
            ->where('year_level_id', $levelId)
            ->where('academic_year_id', $aqYear)
            ->first();
    }

    if (!$academicFee) {
        $academicFee = AcademicFee::whereHas('feeType', function($q) use ($feeTypeName){ $q->where('name', $feeTypeName); })
            ->whereNull('mention_id')
            ->where('year_level_id', $levelId)
            ->where('academic_year_id', $aqYear)
            ->first();
    }

    if (!$academicFee) {
        $academicFee = AcademicFee::whereHas('feeType', function($q) use ($feeTypeName){ $q->where('name', $feeTypeName); })
            ->whereNull('mention_id')
            ->where(function($q) use ($levelId){ $q->where('year_level_id', $levelId)->orWhereNull('year_level_id'); })
            ->where('academic_year_id', $aqYear)
            ->first();
    }

    if (!$academicFee) {
        $academicFee = AcademicFee::whereHas('feeType', function($q) use ($feeTypeName){ $q->where('name', $feeTypeName); })
            ->where('academic_year_id', $aqYear)
            ->first();
    }

    if (!$academicFee) {
        echo "NO_FEE for student {$student->id} ({$student->matricule})\n";
        $noFee++;
        continue;
    }

    // find finance plan
    $finance = DB::table('finance')->where('student_id', $student->matricule)->first();
    $plan = $finance->plan ?? 'A';
    $paymentMode = PaymentMode::where('code', $plan)->first();
    if (!$paymentMode) {
        echo "NO_PAYMENT_MODE for student {$student->id} ({$student->matricule}) plan={$plan}\n";
        $noPaymentMode++;
        continue;
    }

    try {
        $created = app(InstallmentService::class)->generateFor($student, $academicFee, $paymentMode, \Carbon\Carbon::now());
        $count = count($created);
        $totalCreated += $count;
        echo "CREATED {$count} installments for student {$student->id} ({$student->matricule}) using academic_fee {$academicFee->id}\n";
    } catch (\Throwable $e) {
        echo "ERR for student {$student->id}: {$e->getMessage()}\n";
    }
}

echo "Done. total_created={$totalCreated}, skipped={$skipped}, no_fee={$noFee}, no_payment_mode={$noPaymentMode}\n";
