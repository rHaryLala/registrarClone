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

$student = Student::first();
if (!$student) {
    echo "NO_STUDENT\n";
    exit(0);
}

echo "STUDENT: {$student->id}|{$student->matricule}\n";
echo "student fields: mention_id={$student->mention_id}, year_level_id={$student->year_level_id}, academic_year_id={$student->academic_year_id}, semester_id={$student->semester_id}, statut_interne={$student->statut_interne}, abonne_caf={$student->abonne_caf}\n";

$currentAcademicYear = \App\Models\AcademicYear::where('active', true)->first();
$aqYear = $currentAcademicYear ? $currentAcademicYear->id : null;
$levelId = $student->year_level_id;
$semesterId = $student->semester_id ?? null;
$isInternal = ($student->statut_interne === 'interne');
$feeTypeName = 'Frais Généraux';

$academicFee = null;

$queries = [];

// 1 exact
$queries[] = "mention + year_level + academic_year + semester";
$academicFee = AcademicFee::whereHas('feeType', function($q) use ($feeTypeName){ $q->where('name', $feeTypeName); })
    ->where('mention_id', $student->mention_id)
    ->where('year_level_id', $levelId)
    ->where('academic_year_id', $aqYear)
    ->where('semester_id', $semesterId)
    ->first();

if (!$academicFee) {
    $queries[] = "mention + year_level + academic_year";
    $academicFee = AcademicFee::whereHas('feeType', function($q) use ($feeTypeName){ $q->where('name', $feeTypeName); })
        ->where('mention_id', $student->mention_id)
        ->where('year_level_id', $levelId)
        ->where('academic_year_id', $aqYear)
        ->first();
}

if (!$academicFee) {
    $queries[] = "generic mention + year_level + academic_year";
    $academicFee = AcademicFee::whereHas('feeType', function($q) use ($feeTypeName){ $q->where('name', $feeTypeName); })
        ->whereNull('mention_id')
        ->where('year_level_id', $levelId)
        ->where('academic_year_id', $aqYear)
        ->first();
}

if (!$academicFee) {
    $queries[] = "generic mention, relax year_level + academic_year";
    $academicFee = AcademicFee::whereHas('feeType', function($q) use ($feeTypeName){ $q->where('name', $feeTypeName); })
        ->whereNull('mention_id')
        ->where(function($q) use ($levelId){ $q->where('year_level_id', $levelId)->orWhereNull('year_level_id'); })
        ->where('academic_year_id', $aqYear)
        ->first();
}

if (!$academicFee) {
    $queries[] = "last resort: any fee_type match for academic year";
    $academicFee = AcademicFee::whereHas('feeType', function($q) use ($feeTypeName){ $q->where('name', $feeTypeName); })
        ->where('academic_year_id', $aqYear)
        ->first();
}

if ($academicFee) {
    echo "FEE: {$academicFee->id}|{$academicFee->amount}\n";
} else {
    echo "FEE: NOT_FOUND\n";
}

$finance = DB::table('finance')->where('student_id', $student->matricule)->first();
$plan = $finance->plan ?? 'A';

echo "PLAN: {$plan}\n";
$paymentMode = PaymentMode::where('code', $plan)->first();
if ($paymentMode) echo "PAYMENT_MODE: {$paymentMode->id}\n"; else echo "PAYMENT_MODE: NONE\n";

$before = \App\Models\StudentInstallment::count();

if ($academicFee && $paymentMode) {
    try {
        $created = app(InstallmentService::class)->generateFor($student, $academicFee, $paymentMode, \Carbon\Carbon::now());
        echo "CREATED: " . count($created) . "\n";
    } catch (\Throwable $e) {
        echo "ERR: " . $e->getMessage() . "\n";
    }
}

$after = \App\Models\StudentInstallment::count();

echo "TOTAL_INSTALLMENTS_BEFORE: {$before}\n";
echo "TOTAL_INSTALLMENTS_AFTER: {$after}\n";

echo "\n--- Academic fees for current academic year (sample 20) ---\n";
$list = \App\Models\AcademicFee::with('feeType','mention','yearLevel','academicYear','semester')->where('academic_year_id',$aqYear)->limit(20)->get();
foreach($list as $af){
    echo "AF: id={$af->id}, fee_type=".($af->feeType->name ?? 'NULL').", mention_id=".($af->mention_id ?? 'NULL').", year_level_id=".($af->year_level_id ?? 'NULL').", semester_id=".($af->semester_id ?? 'NULL').", amount={$af->amount}\n";
}

echo "\n--- All 'Frais Généraux' academic_fees (no academic_year filter) ---\n";
$allFG = \App\Models\AcademicFee::with('feeType','mention','yearLevel','academicYear','semester')->whereHas('feeType', function($q){ $q->where('name','Frais Généraux'); })->get();
foreach($allFG as $af){
    echo "FG: id={$af->id}, acad_year_id=".($af->academic_year_id??'NULL').", mention_id=".($af->mention_id??'NULL').", year_level_id=".($af->year_level_id??'NULL').", sem_id=".($af->semester_id??'NULL').", amount={$af->amount}\n";
}

// Show first 20 students with quick matching result
echo "\n--- First 20 students matching attempt summary ---\n";
$students = \App\Models\Student::limit(20)->get();
foreach($students as $s){
    $sInfo = "student {$s->id} ({$s->matricule}) mention={$s->mention_id} level={$s->year_level_id} ay={$s->academic_year_id} sem={$s->semester_id} statut={$s->statut_interne}";
    // Try find any FG ignoring academic_year/is_internal first
    $found = \App\Models\AcademicFee::whereHas('feeType', function($q){ $q->where('name','Frais Généraux'); })
        ->where(function($q) use ($s){
            $q->where('mention_id',$s->mention_id)
              ->orWhereNull('mention_id');
        })->where(function($q) use ($s){
            $q->where('year_level_id',$s->year_level_id)
              ->orWhereNull('year_level_id');
        })->get();
    echo $sInfo." -> found_fg_count=".($found->count())."\n";
}

