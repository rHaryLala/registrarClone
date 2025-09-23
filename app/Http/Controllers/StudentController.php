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

    public function index()
    {
        $students = Student::orderBy('created_at', 'desc')->get();
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

            // Determine default plan (category) from finance_plan table
            $planRow = FinancePlan::orderBy('id')->first();
            $planCategory = $planRow ? $planRow->category : 'A';

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