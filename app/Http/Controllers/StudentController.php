<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\Mention;
use App\Models\AcademicYear;
use App\Models\Semester;
use App\Models\YearLevel;
use App\Models\Parcours;
use App\Models\AccessCode;
use Illuminate\Support\Facades\DB;
use App\Models\FinancePlan;
use App\Models\AcademicFee;
use App\Models\PaymentMode;
use App\Services\InstallmentService;

class StudentController extends Controller 
{
    public function create()
    {
        $mentions = Mention::all();
        $academicYears = AcademicYear::orderByDesc('date_debut')->get();
        $semesters = Semester::orderBy('ordre')->get();
        $yearLevels = YearLevel::all();
        $parcours = Parcours::all();
        return view('register', compact('mentions', 'academicYears', 'semesters', 'yearLevels', 'parcours'));
    }

    public function index(Request $request)
    {
        $students = Student::orderBy('created_at', 'desc')->get();

        // If this request comes from the chief-accountant area (url prefix) or the
        // authenticated user is a chief accountant, delegate to the
        // ChiefAccountantController which prepares the specialized view and data.
        try {
            if ($request->is('chief-accountant*') || (auth()->check() && method_exists(auth()->user(), 'isChiefAccountant') && auth()->user()->isChiefAccountant())) {
                return app(\App\Http\Controllers\ChiefAccountantController::class)->studentsList($request);
            }
        } catch (\Throwable $e) {
            // fallback to default view if delegation fails
            logger()->warning('StudentController@index: delegation to ChiefAccountantController failed: ' . $e->getMessage());
        }

        return view('students.index', compact('students'));
    }

    public function checkAccessCode(Request $request)
    {
        $code = strtoupper($request->input('access_code'));
        
        $validCode = AccessCode::where('code', $code)->first();

        if (!$validCode) {
            return response()->json([
                'valid' => false,
                'message' => 'Code d\'accès invalide'
            ]);
        }

        // Vérifier si le code est déjà utilisé (inactif)
        if (!$validCode->is_active) {
            return response()->json([
                'valid' => false,
                'message' => 'Ce code d\'accès a déjà été utilisé'
            ]);
        }

        // Désactiver le code après validation
        $validCode->is_active = false;
        $validCode->save();

        return response()->json([
            'valid' => true,
            'message' => 'Code d\'accès validé avec succès'
        ]);
    }

    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'sexe' => 'required|in:M,F',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string|max:255',
            'nationalite' => 'required|string|max:255',
            'religion' => 'nullable|string|max:255',
            'taille' => 'nullable|in:S,M,L,XL,XXL,XXXL',
            'etat_civil' => 'required|in:célibataire,marié,divorcé,veuf',
            'statut_interne' => 'nullable|in:interne,externe',
            
            // Informations passeport
            'passport_numero' => 'nullable|required_if:passport_status,true|string|max:255',
            'passport_pays_emission' => 'nullable|required_if:passport_status,true|string|max:255',
            'passport_date_emission' => 'nullable|required_if:passport_status,true|date',
            'passport_date_expiration' => 'nullable|required_if:passport_status,true|date',
            
            // Informations conjoint
            'nom_conjoint' => 'nullable|required_if:etat_civil,marié|string|max:255',
            'nb_enfant' => 'nullable|integer|min:0',
            
            // Informations CIN
            'cin_numero' => 'nullable|string|max:255',
            'cin_date_delivrance' => 'nullable|date',
            'cin_lieu_delivrance' => 'nullable|string|max:255',
            
            // Informations parents
            'nom_pere' => 'required|string|max:255',
            'profession_pere' => 'required|string|max:255',
            'contact_pere' => 'required|string|max:255',
            'nom_mere' => 'required|string|max:255',
            'profession_mere' => 'required|string|max:255',
            'contact_mere' => 'required|string|max:255',
            'adresse_parents' => 'required|string',
            
            // Coordonnées
            'telephone' => 'nullable|string|max:255',
            'email' => 'required|email|unique:students,email',
            'adresse' => 'required|string',
            'region' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            
            // Scolarité
            'bacc_serie' => 'nullable|string|max:255',
            'bacc_date_obtention' => 'nullable|digits:4', // année sur 4 chiffres
            
            // Informations sponsor
            'sponsor_nom' => 'nullable|required_if:bursary_status,true|string|max:255',
            'sponsor_prenom' => 'nullable|string|max:255',
            'sponsor_telephone' => 'nullable|required_if:bursary_status,true|string|max:255',
            'sponsor_adresse' => 'nullable|required_if:bursary_status,true|string',
            
            // Informations académiques
            'mention_id' => 'required|exists:mentions,id',
            'year_level_id' => 'required|exists:year_levels,id',
            'parcours_id' => 'nullable|exists:parcours,id',
        ]);

        // Get current academic year
        $currentAcademicYear = AcademicYear::where('active', true)->first();
        
        if (!$currentAcademicYear) {
            return response()->json([
                'success' => false,
                'message' => 'Aucune année académique active trouvée'
            ], 422);
        }

        // Get current semester based on date
        $currentDate = now();
        $currentSemester = Semester::where('academic_year_id', $currentAcademicYear->id)
            ->where('date_debut', '<=', $currentDate)
            ->where('date_fin', '>=', $currentDate)
            ->first();

        // If no current semester found, get the first semester of the academic year
        if (!$currentSemester) {
            $currentSemester = Semester::where('academic_year_id', $currentAcademicYear->id)
                ->orderBy('ordre')
                ->first();
        }

        // Add academic year and semester to validated data
        $validated['academic_year_id'] = $currentAcademicYear->id;
        $validated['semester_id'] = $currentSemester ? $currentSemester->id : 1; // Default to 1 if no semester found

        // Ajouter les champs checkbox
        $validated['passport_status'] = $request->has('passport_status');
        $validated['bursary_status'] = $request->has('bursary_status');
        $validated['abonne_caf'] = $request->has('abonne_caf');

        // Créer l'étudiant
        $student = Student::create($validated);
        
        // Générer matricule et account_code
        $student->generateMatricule($validated['mention_id']);
        $student->generateAccountCode();
        $student->generatePassword();

        // Insert into finance table
        try {
            // student_id stores matricule
            $matricule = $student->matricule;

            $semesterId = $validated['semester_id'] ?? null;

            // Map statut_interne to residence: interne => 0, externe => 1
            $residence = 1; // default external
            if (isset($validated['statut_interne'])) {
                $residence = $validated['statut_interne'] === 'interne' ? 0 : 1;
            }

            $stdYearLevel = $validated['year_level_id'] ?? null;

            // Compute total credits from pivot table course_student joined with courses
            // Sum credits for courses linked to this student (if any)
            $totalCredits = DB::table('course_student')
                ->join('courses', 'course_student.course_id', '=', 'courses.id')
                ->where('course_student.student_id', $student->id)
                ->sum('courses.credits');

            // If there are no pivot entries yet, default to 0
            $totalCredits = $totalCredits ?? 0;

            // Determine default plan (category) from finance_plan table if the model exists
            $planCategory = 'E'; // default
            try {
                if (class_exists(\App\Models\FinancePlan::class)) {
                    $planRow = \App\Models\FinancePlan::orderBy('id')->first();
                    $planCategory = $planRow ? $planRow->category : $planCategory;
                } else {
                    logger()->info('FinancePlan model not found; using default plan category "' . $planCategory . '"');
                }
            } catch (\Throwable $e) {
                // In case something else goes wrong, keep default and log
                logger()->warning('Error while reading FinancePlan: ' . $e->getMessage());
            }

            DB::table('finance')->insert([
                'student_id' => $matricule,
                'semester_id' => $semesterId,
                'residence' => $residence,
                'std_yearlevel' => $stdYearLevel,
                'total_credit' => $totalCredits,
                'plan' => $planCategory,
                'total_payment' => '0',
                'date_entry' => now(),
                'last_change_user_id' => auth()->id() ?? null,
                'last_change_datetime' => now(),
            ]);

            // Try to link to AcademicFee and generate installments according to the default plan
            try {
                // We'll explicitly add the "Frais Généraux" academic fee at registration.
                // Match as specifically as possible: mention, year_level, academic_year, semester and is_internal.
                $aqYear = $currentAcademicYear->id ?? null;
                $levelId = $stdYearLevel;
                $semesterId = $semesterId ?? ($validated['semester_id'] ?? null);
                $isInternal = (isset($validated['statut_interne']) && $validated['statut_interne'] === 'interne');

                $feeTypeName = 'Frais Généraux';

                // helper: try different specificity levels from most specific to least
                $academicFee = null;

                                // 1) exact match: mention + year_level + academic_year + semester
                                $academicFee = AcademicFee::whereHas('feeType', function($q) use ($feeTypeName) {
                                        $q->where('name', $feeTypeName);
                                })->where('mention_id', $validated['mention_id'])
                                    ->where('year_level_id', $levelId)
                                    ->where('academic_year_id', $aqYear)
                                    ->where('semester_id', $semesterId)
                                    ->first();

                // 2) relax semester
                if (!$academicFee) {
                    $academicFee = AcademicFee::whereHas('feeType', function($q) use ($feeTypeName) {
                        $q->where('name', $feeTypeName);
                    })->where('mention_id', $validated['mention_id'])
                      ->where('year_level_id', $levelId)
                      ->where('academic_year_id', $aqYear)
                      ->first();
                }

                // 3) relax mention (generic fee for level/year)
                if (!$academicFee) {
                    $academicFee = AcademicFee::whereHas('feeType', function($q) use ($feeTypeName) {
                        $q->where('name', $feeTypeName);
                    })->whereNull('mention_id')
                      ->where('year_level_id', $levelId)
                      ->where('academic_year_id', $aqYear)
                      ->first();
                }

                // 4) relax year_level
                if (!$academicFee) {
                    $academicFee = AcademicFee::whereHas('feeType', function($q) use ($feeTypeName) {
                        $q->where('name', $feeTypeName);
                    })->whereNull('mention_id')
                      ->where(function($q) use ($levelId) {
                          $q->where('year_level_id', $levelId)
                            ->orWhereNull('year_level_id');
                      })
                      ->where('academic_year_id', $aqYear)
                      ->first();
                }

                // 5) last resort: any fee_type match for the academic year and internal flag
                if (!$academicFee) {
                    $academicFee = AcademicFee::whereHas('feeType', function($q) use ($feeTypeName) {
                        $q->where('name', $feeTypeName);
                    })->where('academic_year_id', $aqYear)
                      ->first();
                }

                // Final fallback: try to find any matching 'Frais Généraux' academic fee regardless of academic year
                if (!$academicFee) {
                    $fallbackCount = AcademicFee::whereHas('feeType', function($q) use ($feeTypeName) {
                        $q->where('name', $feeTypeName);
                    })->count();
                    logger()->info('AcademicFee fallback: found ' . $fallbackCount . ' candidate(s) for feeType "' . $feeTypeName . '" across all years');
                    $academicFee = AcademicFee::whereHas('feeType', function($q) use ($feeTypeName) {
                        $q->where('name', $feeTypeName);
                    })->first();
                    if ($academicFee) {
                        logger()->info('AcademicFee fallback: using AcademicFee id=' . $academicFee->id . ' from academic_year_id=' . ($academicFee->academic_year_id ?? 'NULL'));
                    }
                }

                if ($academicFee) {
                    // Find default payment mode from planCategory (A..E)
                    $paymentMode = PaymentMode::where('code', $planCategory)->first();
                    if (!$paymentMode) {
                        // fallback to code 'A' or first available payment mode
                        $paymentMode = PaymentMode::where('code', 'E')->first() ?: PaymentMode::first();
                    }

                    if ($paymentMode) {
                        try {
                            // Use InstallmentService to generate installments for the frais généraux
                            $created = app(InstallmentService::class)->generateFor($student, $academicFee, $paymentMode, \Carbon\Carbon::now());
                            $countCreated = is_array($created) ? count($created) : 0;
                            logger()->info("Generated {$countCreated} frais généraux installment(s) for student " . ($student->id ?? 'unknown'));

                            // If InstallmentService didn't create any installments (unexpected), add a minimal fallback row
                            if ($countCreated === 0) {
                                try {
                                    \App\Models\StudentInstallment::create([
                                        'student_id' => $student->id,
                                        'payment_mode_id' => $paymentMode->id,
                                        'academic_fee_id' => $academicFee->id,
                                        'sequence' => 1,
                                        'amount_due' => $academicFee->amount,
                                        'amount_paid' => 0,
                                        'due_at' => \Carbon\Carbon::now(),
                                        'status' => 'pending'
                                    ]);
                                    logger()->info('Fallback: created 1 StudentInstallment for student ' . ($student->id ?? 'unknown'));
                                } catch (\Throwable $e) {
                                    logger()->warning('Fallback StudentInstallment creation failed for student ' . ($student->id ?? 'unknown') . ': ' . $e->getMessage());
                                }
                            }
                        } catch (\Throwable $e) {
                            logger()->warning('Failed to generate "Frais Généraux" installments for student ' . ($student->id ?? 'unknown') . ': ' . $e->getMessage());
                        }
                    } else {
                        logger()->warning('No payment mode available while creating frais généraux for student ' . ($student->id ?? 'unknown'));
                    }
                } else {
                    logger()->info('No "Frais Généraux" academic_fee found for student ' . ($student->id ?? 'unknown') . ' (mention ' . ($validated['mention_id'] ?? 'null') . ', level ' . ($levelId ?? 'null') . ', acad_year ' . ($aqYear ?? 'null') . ', semester ' . ($semesterId ?? 'null') . ', internal ' . ($isInternal ? '1' : '0') . ')');
                }
            } catch (\Throwable $e) {
                logger()->warning('Error while linking academic fee/installments: ' . $e->getMessage());
            }
            // Compute and persist semester fee breakdown (frais généraux, dortoir, cantine, ecolage, etc.)
            try {
                app(InstallmentService::class)->computeSemesterFees($student, $currentAcademicYear->id, $semesterId, auth()->id() ?? null);
                logger()->info('StudentSemesterFee computed for student ' . ($student->id ?? 'unknown'));
            } catch (\Throwable $e) {
                logger()->warning('Failed to compute StudentSemesterFee for student ' . ($student->id ?? 'unknown') . ': ' . $e->getMessage());
            }
        } catch (\Throwable $e) {
            // Log error but don't block student creation
            logger()->error('Failed to insert finance row for student: ' . ($student->id ?? 'unknown') . ' - ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Inscription enregistrée avec succès!',
            'student_id' => $student->id,
            'redirect_url' => route('recap', ['id' => $student->id])
        ]);
    }

    public function recap($id)
    {
        $student = Student::findOrFail($id);
        return view('recap', compact('student'));
    }

}