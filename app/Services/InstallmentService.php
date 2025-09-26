<?php
namespace App\Services;

use App\Models\Student;
use App\Models\AcademicFee;
use App\Models\PaymentMode;
use App\Models\PaymentModeInstallment;
use App\Models\StudentInstallment;
use App\Models\StudentSemesterFee;
use App\Models\Mention;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use App\Models\FeeType;

class InstallmentService
{
    /**
     * Generate installments for a student given an academic fee and a payment mode
     *
     * @param Student $student
     * @param AcademicFee $academicFee
     * @param PaymentMode $paymentMode
     * @param Carbon|null $startAt (optional) start date for first installment
     * @return array created StudentInstallment objects
     */
    public function generateFor(Student $student, AcademicFee $academicFee, PaymentMode $paymentMode, ?Carbon $startAt = null)
    {
        $startAt = $startAt ?: Carbon::now();

        $modeInstallments = $paymentMode->installments()->orderBy('sequence')->get();
        if ($modeInstallments->isEmpty()) {
            throw new \Exception('Payment mode has no installment template');
        }

        $created = [];
        foreach ($modeInstallments as $mi) {
            $seq = $mi->sequence;
            $dueAt = $startAt->copy()->addDays($mi->days_after);
            $amountDue = round(($mi->percentage / 100.0) * $academicFee->amount, 2);

            $studentInstallment = StudentInstallment::create([
                'student_id' => $student->id,
                'payment_mode_id' => $paymentMode->id,
                'academic_fee_id' => $academicFee->id,
                'sequence' => $seq,
                'amount_due' => $amountDue,
                'amount_paid' => 0,
                'due_at' => $dueAt,
                'status' => 'pending'
            ]);

            $created[] = $studentInstallment;
        }

        return $created;
    }

    /**
     * Compute and persist the semester fee breakdown for a student
     * Rules (as requested):
     * - frais_generaux by mention and year_level (AcademicFee matching)
     * - dortoir if interne
     * - cantine if abonne_caf
     * - laboratoire if any of student's courses require a lab (course.has_lab boolean assumed)
     * - ecolage: total credits * per-credit rate (assume 'Écolage' AcademicFee amount applies per credit)
     * - voyage_etude for mention except for 'Theologie' where it becomes 'Colloque'
     * - frais_costume for new theology students (assume year_level == 1 and mention name contains 'Theologie')
     */
    public function computeSemesterFees(Student $student, $academicYearId, $semesterId, $computedByUserId = null)
    {
        // Load related data
        $student->load('mention', 'yearLevel');

    // load semester to get number of days (duration) to apply per-day fees
    $semester = \App\Models\Semester::find($semesterId);
    $daysInSemester = 0;
    if ($semester) {
        $daysInSemester = $semester->duration ?? 0;
        if (!$daysInSemester && $semester->date_debut && $semester->date_fin) {
            $daysInSemester = Carbon::parse($semester->date_debut)->diffInDays(Carbon::parse($semester->date_fin)) + 1;
        }
    }

    $fraisGeneraux = 0;
    $dortoir = 0;
    $cantine = 0;
    $labo_info = 0;
    $labo_comm = 0;
    $labo_langue = 0;
    $ecolage = 0;
    $voyage = 0;
    $colloque = 0;
    $costume = 0;

        // 1) frais_generaux: find AcademicFee matching fee type name 'Frais Généraux'
        $fraisGenAF = AcademicFee::whereHas('feeType', function($q){ $q->where('name','Frais Généraux'); })
            ->where('mention_id', $student->mention_id)
            ->where('year_level_id', $student->year_level_id)
            ->where('academic_year_id', $academicYearId)
            ->first();
        if (!$fraisGenAF) {
            // relax matches
            $fraisGenAF = AcademicFee::whereHas('feeType', function($q){ $q->where('name','Frais Généraux'); })
                ->where('mention_id', $student->mention_id)
                ->where('academic_year_id', $academicYearId)
                ->first();
        }
        if ($fraisGenAF) $fraisGeneraux = $fraisGenAF->amount;

        // 2) dortoir
        if ($student->statut_interne === 'interne') {
            $dortoirAF = AcademicFee::whereHas('feeType', function($q){ $q->where('name','Dortoir'); })
                ->where('academic_year_id', $academicYearId)
                ->first();
            if ($dortoirAF) {
                // if semester length is known, assume AcademicFee amount is a per-day rate and multiply
                $dortoir = $dortoirAF->amount;
                if ($daysInSemester > 0) {
                    $dortoir = round($dortoirAF->amount * $daysInSemester, 2);
                }
            }
        }

        // 3) cantine
        if ($student->abonne_caf) {
            $cantineAF = AcademicFee::whereHas('feeType', function($q){ $q->where('name','Cantine'); })
                ->where('academic_year_id', $academicYearId)
                ->first();
            if ($cantineAF) {
                // if semester length is known, assume AcademicFee amount is a per-day rate and multiply
                $cantine = $cantineAF->amount;
                if ($daysInSemester > 0) {
                    $cantine = round($cantineAF->amount * $daysInSemester, 2);
                }
            }
        }

        // 4) laboratoire: check per-course lab requirements using the three lab flags on `courses`
        // and fetch the corresponding AcademicFee amounts for each lab type if any course requires it.
        $hasLaboInfo = false;
        $hasLaboComm = false;
        $hasLaboLang = false;
        try {
            // Check Informatique lab flag
            if (Schema::hasColumn('courses', 'labo_info')) {
                $hasLaboInfo = \DB::table('course_student')
                    ->join('courses','course_student.course_id','=','courses.id')
                    ->where('course_student.student_id',$student->id)
                    ->whereNull('course_student.deleted_at')
                    ->where('courses.labo_info', true)
                    ->exists();
            }

            // Check Communication lab flag
            if (Schema::hasColumn('courses', 'labo_comm')) {
                $hasLaboComm = \DB::table('course_student')
                    ->join('courses','course_student.course_id','=','courses.id')
                    ->where('course_student.student_id',$student->id)
                    ->whereNull('course_student.deleted_at')
                    ->where('courses.labo_comm', true)
                    ->exists();
            }

            // Check Langue lab flag
            if (Schema::hasColumn('courses', 'labo_langue')) {
                $hasLaboLang = \DB::table('course_student')
                    ->join('courses','course_student.course_id','=','courses.id')
                    ->where('course_student.student_id',$student->id)
                    ->whereNull('course_student.deleted_at')
                    ->where('courses.labo_langue', true)
                    ->exists();
            }
        } catch (\Throwable $e) {
            logger()->warning('Unable to detect course lab requirement: ' . $e->getMessage());
        }

        // For each lab type required, fetch its AcademicFee for the given academic year (fallback to any if year-specific not found)
        if ($hasLaboInfo) {
            $labInfoAF = AcademicFee::whereHas('feeType', function($q){ $q->where('name','Laboratoire Informatique'); })->where('academic_year_id', $academicYearId)->first();
            if (!$labInfoAF) {
                $labInfoAF = AcademicFee::whereHas('feeType', function($q){ $q->where('name','Laboratoire Informatique'); })->first();
            }
            if ($labInfoAF) $labo_info = $labInfoAF->amount;
        }
        if ($hasLaboComm) {
            $labCommAF = AcademicFee::whereHas('feeType', function($q){ $q->where('name','Laboratoire Communication'); })->where('academic_year_id', $academicYearId)->first();
            if (!$labCommAF) {
                $labCommAF = AcademicFee::whereHas('feeType', function($q){ $q->where('name','Laboratoire Communication'); })->first();
            }
            if ($labCommAF) $labo_comm = $labCommAF->amount;
        }
        if ($hasLaboLang) {
            $labLangAF = AcademicFee::whereHas('feeType', function($q){ $q->where('name','Laboratoire Langue'); })->where('academic_year_id', $academicYearId)->first();
            if (!$labLangAF) {
                $labLangAF = AcademicFee::whereHas('feeType', function($q){ $q->where('name','Laboratoire Langue'); })->first();
            }
            if ($labLangAF) $labo_langue = $labLangAF->amount;
        }

        // 5) ecolage: total credits * per-credit rate. Find 'Écolage' AcademicFee
        $credits = 0;
        try {
            if (Schema::hasColumn('courses', 'credits')) {
                $credits = \DB::table('course_student')
                    ->join('courses','course_student.course_id','=','courses.id')
                    ->where('course_student.student_id',$student->id)
                    ->sum('courses.credits');
            } else {
                // no credits column -> default to 0
                $credits = 0;
            }
        } catch (\Throwable $e) {
            logger()->warning('Unable to sum course credits: ' . $e->getMessage());
            $credits = 0;
        }
        $ecolageAF = AcademicFee::whereHas('feeType', function($q){ $q->where('name','Écolage'); })
            ->where('academic_year_id', $academicYearId)
            ->first();
        if ($ecolageAF) {
            // if academic fee amount is per-credit (assumption), multiply; otherwise if it's total, use as-is
            $ecolage = $credits * $ecolageAF->amount;
        }

        // 6) voyage or colloque
    $mentionName = $student->mention->nom ?? '';
    // Detect Theologie by mention_id (1 in our configuration). This is more reliable
    // than string matching the name. Keep name as fallback if needed in future.
    $isTheology = (intval($student->mention_id) === 1);
    if ($isTheology) {
            // Theologie => colloque (match FeeType names containing 'colloque')
            try {
                $colFeeTypeIds = FeeType::whereRaw('LOWER(name) LIKE ?', ['%colloque%'])->pluck('id')->toArray();
                if (!empty($colFeeTypeIds)) {
                    $colAF = AcademicFee::whereIn('fee_type_id', $colFeeTypeIds)
                        ->where('academic_year_id', $academicYearId)
                        ->first();
                    if (!$colAF) {
                        $colAF = AcademicFee::whereIn('fee_type_id', $colFeeTypeIds)->first();
                        if ($colAF) logger()->info('Colloque AcademicFee fallback used (no academic_year match) for academic_year_id=' . $academicYearId);
                    }
                    if ($colAF) {
                        $colloque = $colAF->amount;
                    } else {
                        logger()->info('No Colloque AcademicFee found for academic_year_id=' . $academicYearId . ' (fee_type ids: ' . implode(',', $colFeeTypeIds) . ')');
                    }
                } else {
                    logger()->info('No FeeType matching colloque found');
                }
            } catch (\Throwable $e) {
                logger()->warning('Error while searching Colloque fee: ' . $e->getMessage());
            }
        } else {
            // Non-Theologie => voyage d'etude (match FeeType names containing 'voyage')
            try {
                $voyFeeTypeIds = FeeType::whereRaw('LOWER(name) LIKE ?', ['%voyage%'])->pluck('id')->toArray();
                if (!empty($voyFeeTypeIds)) {
                    $voyAF = AcademicFee::whereIn('fee_type_id', $voyFeeTypeIds)
                        ->where('academic_year_id', $academicYearId)
                        ->first();
                    if (!$voyAF) {
                        $voyAF = AcademicFee::whereIn('fee_type_id', $voyFeeTypeIds)->first();
                        if ($voyAF) logger()->info('Voyage AcademicFee fallback used (no academic_year match) for academic_year_id=' . $academicYearId);
                    }
                    if ($voyAF) {
                        $voyage = $voyAF->amount;
                    } else {
                        logger()->info('No Voyage AcademicFee found for academic_year_id=' . $academicYearId . ' (fee_type ids: ' . implode(',', $voyFeeTypeIds) . ')');
                    }
                } else {
                    logger()->info('No FeeType matching voyage found');
                }
            } catch (\Throwable $e) {
                logger()->warning('Error while searching Voyage fee: ' . $e->getMessage());
            }
        }

    // 7) costume for new theology students: only for Theologie (mention_id==1), first year AND first semester (ordre == 1)
    if ($isTheology && ($student->year_level_id == 1 || $student->year_level_id == '1')) {
            $isFirstSemester = false;
            try {
                if ($semester && isset($semester->ordre)) {
                    $isFirstSemester = intval($semester->ordre) === 1;
                }
            } catch (\Throwable $e) {
                logger()->warning('Unable to determine semester ordre for costume rule: ' . $e->getMessage());
                $isFirstSemester = false;
            }

            if ($isFirstSemester) {
                $costAF = AcademicFee::whereHas('feeType', function($q){ $q->where('name','Graduation')->orWhere('name','Costume'); })
                    ->where('academic_year_id', $academicYearId)
                    ->first();
                if ($costAF) $costume = $costAF->amount;
            }
        }

    $total = $fraisGeneraux + $dortoir + $cantine + $labo_info + $labo_comm + $labo_langue + $ecolage + $voyage + $colloque + $costume;

        // Upsert into student_semester_fees
        $record = \App\Models\StudentSemesterFee::updateOrCreate(
            ['student_id' => $student->id, 'academic_year_id' => $academicYearId, 'semester_id' => $semesterId],
            [
                'frais_generaux' => $fraisGeneraux,
                'dortoir' => $dortoir,
                'cantine' => $cantine,
                'labo_info' => $labo_info,
                'labo_comm' => $labo_comm,
                'labo_langue' => $labo_langue,
                'ecolage' => $ecolage,
                'voyage_etude' => $voyage,
                'colloque' => $colloque,
                'frais_costume' => $costume,
                'total_amount' => $total,
                'computed_by_user_id' => $computedByUserId,
                'computed_at' => Carbon::now()
            ]
        );

        return $record;
    }
}
