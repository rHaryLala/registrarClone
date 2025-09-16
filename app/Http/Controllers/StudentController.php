<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Mention;
use App\Models\AcademicYear;
use App\Models\Semester;
use App\Models\YearLevel;
use App\Models\Parcours;
use Illuminate\Support\Facades\DB;

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

    public function store(Request $request)
    {
        // Validation des données (inchangée)
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'sexe' => 'required|in:M,F',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string|max:255',
            'nationalite' => 'required|string|max:255',
            'religion' => 'nullable|string|max:255',
            'etat_civil' => 'required|in:célibataire,marié,divorcé,veuf',
            
            // Informations passeport
            'passport_numero' => 'nullable|required_if:passport_status,true|string|max:255',
            'passport_pays_emission' => 'nullable|required_if:passport_status,true|string|max:255',
            'passport_date_emission' => 'nullable|required_if:passport_status,true|date',
            'passport_date_expiration' => 'nullable|required_if:passport_status,true|date',
            
            // Informations conjoint
            'nom_conjoint' => 'nullable|required_if:etat_civil,marié|string|max:255',
            
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
            'bacc_date_obtention' => 'nullable|date',
            
            // Informations sponsor
            'sponsor_nom' => 'nullable|required_if:bursary_status,true|string|max:255',
            'sponsor_prenom' => 'nullable|required_if:bursary_status,true|string|max:255',
            'sponsor_telephone' => 'nullable|required_if:bursary_status,true|string|max:255',
            'sponsor_adresse' => 'nullable|required_if:bursary_status,true|string',
            
            // Informations académiques
            'mention_id' => 'required|exists:mentions,id',
            'year_level_id' => 'required|exists:year_levels,id',
            'parcours_id' => 'nullable|exists:parcours,id',
        ]);

        // Ajouter les champs checkbox
        $validated['passport_status'] = $request->has('passport_status');
        $validated['bursary_status'] = $request->has('bursary_status');

        // Génération du matricule côté backend
        $mention = Mention::findOrFail($validated['mention_id']);
        $prefixes = [
            'Théologie' => '1',
            'Gestion' => '2',
            'Informatique' => '3',
            'Sciences Infirmières' => '4',
            'Éducation' => '5',
            'Communication' => '6',
            'Études Anglophones' => '7',
            'Droit' => '9',
        ];
        
        $prefix = $prefixes[$mention->nom] ?? '0';
        
        // Récupérer le dernier matricule pour cette mention
        $lastStudent = Student::where('matricule', 'like', $prefix . '%')
            ->where('matricule', 'REGEXP', '^' . $prefix . '[0-9]{4}$') // Assure 5 chiffres au total
            ->orderByDesc('matricule')
            ->first();
        
        if ($lastStudent) {
            // Extraire la partie numérique (les 4 derniers chiffres)
            $lastNumber = (int)substr($lastStudent->matricule, 1);
            $nextNumber = $lastNumber + 1;
            
            // Vérifier que le nombre ne dépasse pas 9999
            if ($nextNumber > 9999) {
                throw new \Exception("Numéro de matricule dépassé pour la mention " . $mention->nom);
            }
        } else {
            // Premier matricule pour cette mention
            $nextNumber = 1;
        }
        
        // Formater le matricule avec 5 chiffres au total
        $matricule = $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        
        // Vérifier l'unicité (au cas où il y aurait un doublon)
        $existingStudent = Student::where('matricule', $matricule)->first();
        if ($existingStudent) {
            // Si le matricule existe déjà, on continue à incrémenter jusqu'à trouver un numéro libre
            do {
                $nextNumber++;
                if ($nextNumber > 9999) {
                    throw new \Exception("Numéro de matricule dépassé pour la mention " . $mention->nom);
                }
                $matricule = $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            } while (Student::where('matricule', $matricule)->exists());
        }
        
        $validated['matricule'] = $matricule;

        // Récupérer l'année académique active
        $activeAcademicYear = AcademicYear::where('active', true)->first();
        if ($activeAcademicYear) {
            // year_level_id déjà validé et présent dans $validated
            $validated['academic_year_id'] = $activeAcademicYear->id;
            $semester = Semester::where('academic_year_id', $activeAcademicYear->id)
                ->where('ordre', 1)
                ->first();
            if ($semester) {
                $validated['semester_id'] = $semester->id;
            }
        }

        // Sécuriser la présence de year_level_id
        if (!$request->has('year_level_id')) {
            return response()->json([
                'success' => false,
                'errors' => ['Le niveau d\'étude est requis.']
            ], 422);
        }
        $validated['year_level_id'] = $request->input('year_level_id');

        // Ajoutez explicitement parcours_id si transmis
        if ($request->has('parcours_id')) {
            $validated['parcours_id'] = $request->input('parcours_id');
        }

        // Créer l'étudiant
        $student = Student::create($validated);

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