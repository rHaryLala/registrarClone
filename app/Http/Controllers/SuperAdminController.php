<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Course;
use App\Models\Mention;
use App\Models\Teacher;
use App\Models\StudentFinance;
use App\Models\Finance;
use Illuminate\Support\Facades\DB;
use App\Models\YearLevel;
use App\Models\AcademicYear;
use App\Models\Semester;
use App\Models\FinanceDetail;
use App\Services\InstallmentService;
use Barryvdh\DomPDF\Facade\Pdf; // Ajoutez ceci en haut du fichier
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        $usersCount = User::count();
        $studentsCount = Student::count();
        $teachersCount = Teacher::count();
        $coursesCount = Course::count();

        $latestRegistrations = Student::orderBy('created_at', 'desc')
            ->latest()
            ->take(3)
            ->get();

        // Statistiques journalières (étudiants inscrits par jour sur les 7 derniers jours)
        $startDate = now()->subDays(6)->startOfDay();
        $endDate = now()->endOfDay();
        $dailyRegistrations = Student::query()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as day, COUNT(*) as count')
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('count', 'day');

        return view('superadmin.dashboard', compact(
            'usersCount', 'studentsCount', 'teachersCount', 'coursesCount',
            'latestRegistrations', 'dailyRegistrations'
        ));
    }

    public function coursesList()
    {
    $courses = Course::with('teacher', 'yearLevels')->get();
        $yearLevels = YearLevel::all();
        return view('superadmin.courses.list', compact('courses', 'yearLevels'));
    }

    public function createCourse()
    {
        $teachers = Teacher::all();
        $mentions = Mention::all();
        $yearLevels = YearLevel::all();
        return view('superadmin.courses.create', compact('teachers', 'mentions', 'yearLevels'));
    }

    public function storeCourse(Request $request)
    {
        $request->validate([
            'sigle' => 'required|unique:courses,sigle|max:10',
            'nom' => 'required|max:255',
            'credits' => 'required|integer|min:1|max:10',
            'teacher_id' => 'nullable|exists:teachers,id',
            'mention_id' => 'nullable|exists:mentions,id',
            'categorie' => 'required|in:général,majeur',
        ]);

        Course::create([
            'sigle' => $request->sigle,
            'nom' => $request->nom,
            'credits' => $request->credits,
            'teacher_id' => $request->teacher_id,
            'mention_id' => $request->mention_id,
            'categorie' => $request->categorie,
        ]);

        return redirect()->route('superadmin.courses.list')->with('success', 'Cours créé avec succès.');
    }

    public function editCourse($id)
    {
        $course = Course::findOrFail($id);
        $teachers = Teacher::all();
        $mentions = Mention::all();
        $yearLevels = YearLevel::all();
        return view('superadmin.courses.edit', compact('course', 'teachers', 'mentions', 'yearLevels'));
    }

    public function updateCourse(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $validated = $request->validate([
            'sigle' => 'required|string|max:255|unique:courses,sigle,' . $id,
            'nom' => 'required|string|max:255',
            'credits' => 'required|integer|min:1',
            'teacher_id' => 'nullable|exists:teachers,id',
            'mention_id' => 'nullable|exists:mentions,id',
            'categorie' => 'required|in:général,majeur',
        ]);
        $course->update($validated);
        return redirect()->route('superadmin.courses.list')->with('success', 'Cours modifié avec succès.');
    }

    public function destroyCourse($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return redirect()->route('superadmin.courses.list')->with('success', 'Cours supprimé avec succès.');
    }

    public function teachersList()
    {
        $teachers = Teacher::all();
        return view('superadmin.teachers.list', compact('teachers'));
    }

    public function createTeacher()
    {
        return view('superadmin.teachers.create');
    }

    public function storeTeacher(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email',
            'telephone' => 'nullable|string|max:255',
            'diplome' => 'nullable|string|max:255',
        ]);
        Teacher::create($validated);
        return redirect()->route('superadmin.teachers.list')->with('success', 'Enseignant ajouté avec succès.');
    }

    public function editTeacher($id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('superadmin.teachers.edit', compact('teacher'));
    }

    public function updateTeacher(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email,' . $id,
            'telephone' => 'nullable|string|max:255',
            'diplome' => 'nullable|string|max:255',
        ]);
        $teacher->update($validated);
        return redirect()->route('superadmin.teachers.list')->with('success', 'Enseignant modifié avec succès.');
    }

    public function destroyTeacher($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();
        return redirect()->route('superadmin.teachers.list')->with('success', 'Enseignant supprimé avec succès.');
    }

    /**
     * Export the list of students for a course as PDF
     */
    public function exportCourseStudents($id)
    {
        $course = Course::with(['teacher', 'students.mention', 'students.yearLevel'])->findOrFail($id);
        $filename = 'Liste des étudiants - ' . ($course->sigle ?? $course->id) . '.pdf';
        return Pdf::loadView('dean.courses.students-pdf', compact('course'))->download($filename);
    }

    // USERS
    public function usersList()
    {
        $users = User::all();
        return view('superadmin.users.list', compact('users'));
    }
    public function createUser()
    {
        return view('superadmin.users.create');
    }
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,dean,teacher,student,parent',
            'mention_id' => 'required_if:role,dean|exists:mentions,id'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'plain_password' => $validated['password'],
            'role' => $validated['role'],
            'mention_id' => $validated['mention_id'] ?? null
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('superadmin.users.edit', compact('user'));
    }
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|string',
        ]);
        $user->update($validated);
        return redirect()->route('superadmin.users.list')->with('success', 'Utilisateur modifié avec succès.');
    }
    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('superadmin.users.list')->with('success', 'Utilisateur supprimé avec succès.');
    }

    // MENTIONS
    public function mentionsList()
    {
        $mentions = \App\Models\Mention::all();
        return view('superadmin.mentions.list', compact('mentions'));
    }
    public function createMention()
    {
        return view('superadmin.mentions.create');
    }
    public function storeMention(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:mentions,nom',
        ]);
        \App\Models\Mention::create($validated);
        return redirect()->route('superadmin.mentions.list')->with('success', 'Mention ajoutée avec succès.');
    }
    public function editMention($id)
    {
        $mention = \App\Models\Mention::findOrFail($id);
        return view('superadmin.mentions.edit', compact('mention'));
    }
    public function updateMention(Request $request, $id)
    {
        $mention = \App\Models\Mention::findOrFail($id);
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:mentions,nom,' . $id,
        ]);
        $mention->update($validated);
        return redirect()->route('superadmin.mentions.list')->with('success', 'Mention modifiée avec succès.');
    }
    public function destroyMention($id)
    {
        $mention = \App\Models\Mention::findOrFail($id);
        $mention->delete();
        return redirect()->route('superadmin.mentions.list')->with('success', 'Mention supprimée avec succès.');
    }

    // STUDENTS
    public function studentsList(Request $request)
    {
        $sortable = ['id', 'matricule', 'nom', 'prenom', 'email', 'mention_id', 'annee_etude']; // Ajout du tri par ID
        $sort = $request->get('sort', 'id'); // Par défaut, tri par ID
        $direction = $request->get('direction', 'desc');

        if (!in_array($sort, $sortable)) {
            $sort = 'id';
        }
        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'asc';
        }

        $query = Student::query();
        if ($request->filled('mention_id')) {
            $query->where('mention_id', $request->mention_id);
        }
        // Recherche multi-champs
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('matricule', 'like', "%$q%")
                    ->orWhere('nom', 'like', "%$q%")
                    ->orWhere('prenom', 'like', "%$q%")
                    ->orWhere('email', 'like', "%$q%");
            });
        }
        $students = $query->orderBy($sort, $direction)->get();

        $mentions = \App\Models\Mention::all();
        $yearLevels = YearLevel::all();

        // Préparer les tableaux pour le JS
        $studentsArray = $students->map(function($student) {
            // Normalize academic year libelle: prefer relation, otherwise resolve from id if numeric, else pass-through
            $acadLibelle = null;
            try {
                if ($student->academicYear) {
                    $acadLibelle = $student->academicYear->libelle;
                } elseif (is_numeric($student->academic_year_id)) {
                    $ay = \App\Models\AcademicYear::find($student->academic_year_id);
                    $acadLibelle = $ay ? $ay->libelle : null;
                } else {
                    $acadLibelle = $student->academic_year_id ?? null;
                }
            } catch (\Throwable $e) {
                $acadLibelle = $student->academic_year_id ?? null;
            }

            return [
                'id' => $student->id,
                'matricule' => $student->matricule,
                'nom' => $student->nom,
                'prenom' => $student->prenom,
                'email' => $student->email,
                'mention_id' => $student->mention_id,
                'mention_nom' => $student->mention ? $student->mention->nom : '-',
                // Provide the academic year libelle so frontend can filter by the dropdown values (e.g. '2025-2026')
                'academic_year' => $acadLibelle,
                'year_level_id' => $student->year_level_id,
                'year_level_label' => $student->yearLevel ? $student->yearLevel->label : '-',
            ];
        })->values()->toArray();

        $mentionsArray = $mentions->map(function($mention) {
            return [
                'id' => $mention->id,
                'nom' => $mention->nom,
            ];
        })->values()->toArray();

        return view('superadmin.students.list', compact('students', 'mentions', 'studentsArray', 'mentionsArray', 'yearLevels'));
    }
    
    public function createStudent()
    {
        $mentions = Mention::all();
        $yearLevels = YearLevel::all();
        return view('superadmin.students.create', compact('mentions', 'yearLevels'));
    }
    
    private function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $image->getClientOriginalName());
            $directory = public_path('storage/students');
            $path = 'storage/students/' . $filename;

            // Créer le dossier s'il n'existe pas
            if (!file_exists($directory)) {
                if (!mkdir($directory, 0777, true) && !is_dir($directory)) {
                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $directory));
                }
            }

            // Traitement carré avec GD
            $srcPath = $image->getRealPath();
            [$width, $height, $type] = getimagesize($srcPath);

            // Charger l'image selon le type
            switch ($type) {
                case IMAGETYPE_JPEG:
                    $srcImg = imagecreatefromjpeg($srcPath);
                    break;
                case IMAGETYPE_PNG:
                    $srcImg = imagecreatefrompng($srcPath);
                    break;
                case IMAGETYPE_GIF:
                    $srcImg = imagecreatefromgif($srcPath);
                    break;
                default:
                    // Fallback: déplacer sans traitement
                    $image->move($directory, $filename);
                    return $path;
            }

            // Calculer la taille du carré et cropper au centre
            $side = min($width, $height);
            $src_x = ($width > $height) ? intval(($width - $height) / 2) : 0;
            $src_y = ($height > $width) ? intval(($height - $width) / 2) : 0;

            $dstImg = imagecreatetruecolor($side, $side);

            // Pour PNG/GIF, gérer la transparence
            if ($type == IMAGETYPE_PNG || $type == IMAGETYPE_GIF) {
                imagecolortransparent($dstImg, imagecolorallocatealpha($dstImg, 0, 0, 0, 127));
                imagealphablending($dstImg, false);
                imagesavealpha($dstImg, true);
            }

            imagecopyresampled($dstImg, $srcImg, 0, 0, $src_x, $src_y, $side, $side, $side, $side);

            // Sauvegarder l'image carrée
            switch ($type) {
                case IMAGETYPE_JPEG:
                    imagejpeg($dstImg, $directory . '/' . $filename, 90);
                    break;
                case IMAGETYPE_PNG:
                    imagepng($dstImg, $directory . '/' . $filename);
                    break;
                case IMAGETYPE_GIF:
                    imagegif($dstImg, $directory . '/' . $filename);
                    break;
            }

            imagedestroy($srcImg);
            imagedestroy($dstImg);

            return $path;
        }

        return null;
    }
    public function storeStudent(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'sexe' => 'nullable|string|max:10',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'nullable|string|max:255',
            'nationalite' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:255',
            'etat_civil' => 'required|in:célibataire,marié,divorcé,veuf',
            'passport_status' => 'nullable|boolean',
            'passport_numero' => 'nullable|string|max:255',
            'passport_pays_emission' => 'nullable|string|max:255',
            'passport_date_emission' => 'nullable|date',
            'passport_date_expiration' => 'nullable|date',
            'nom_conjoint' => 'nullable|string|max:255',
            'nb_enfant' => 'nullable|integer',
            'cin_numero' => 'nullable|string|max:255',
            'cin_date_delivrance' => 'nullable|date',
            'cin_lieu_delivrance' => 'nullable|string|max:255',
            'nom_pere' => 'nullable|string|max:255',
            'profession_pere' => 'nullable|string|max:255',
            'contact_pere' => 'nullable|string|max:255',
            'nom_mere' => 'nullable|string|max:255',
            'profession_mere' => 'nullable|string|max:255',
            'contact_mere' => 'nullable|string|max:255',
            'adresse_parents' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:255',
            'email' => 'required|email|unique:students,email',
            'adresse' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'bacc_serie' => 'nullable|string|max:255',
            'bacc_date_obtention' => 'nullable', // on gère la validation plus bas
            'bursary_status' => 'nullable|boolean',
            'sponsor_nom' => 'nullable|string|max:255',
            'sponsor_prenom' => 'nullable|string|max:255',
            'sponsor_telephone' => 'nullable|string|max:255',
            'sponsor_adresse' => 'nullable|string|max:255',
            'year_level_id' => 'required|exists:year_levels,id',
            'mention_id' => 'nullable|exists:mentions,id',
            'matricule' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'parcours_id' => 'nullable|exists:parcours,id',
            'statut_interne' => 'nullable|boolean',
            'abonne_caf' => 'nullable|boolean',
        ]);
        // Remplacer l'appel à uploadProfilePhoto par uploadImage
        $imagePath = $this->uploadImage($request);
        if ($imagePath) {
            $validated['image'] = $imagePath;
        }
        $validated['parcours_id'] = $request->parcours_id;

        // Récupérer l'année académique active
        $activeAcademicYear = AcademicYear::where('active', true)->first();
        if ($activeAcademicYear) {
            // Récupérer le semestre d'ordre 1 de cette année académique
            $semester = Semester::where('academic_year_id', $activeAcademicYear->id)
                ->where('ordre', 1)
                ->first();
            if ($semester) {
                $validated['semester_id'] = $semester->id;
            }
            $validated['academic_year_id'] = $activeAcademicYear->id;
        }

        // Correction robuste pour bacc_date_obtention
        if (isset($validated['bacc_date_obtention']) && $validated['bacc_date_obtention'] !== null && $validated['bacc_date_obtention'] !== '') {
            // Si la valeur ressemble à une date (ex: 1970-01-01...), extraire l'année
            if (preg_match('/^\d{4}-\d{2}-\d{2}/', $validated['bacc_date_obtention'])) {
                $validated['bacc_date_obtention'] = (int)substr($validated['bacc_date_obtention'], 0, 4);
            } else {
                $validated['bacc_date_obtention'] = (int)$validated['bacc_date_obtention'];
            }
            // Si ce n'est pas une année valide, mettre à null
            if ($validated['bacc_date_obtention'] < 1900 || $validated['bacc_date_obtention'] > (date('Y')+1)) {
                $validated['bacc_date_obtention'] = null;
            }
        } else {
            $validated['bacc_date_obtention'] = null;
        }

        Student::create($validated);
        return redirect()->route('superadmin.students.list')->with('success', 'Étudiant ajouté avec succès.');
    }
    public function editStudent($id)
    {
        $student = Student::findOrFail($id);
        $mentions = Mention::all();
        $yearLevels = YearLevel::all();
        return view('superadmin.students.edit', compact('student', 'mentions', 'yearLevels'));
    }
    public function updateStudent(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        // Si c'est une requête AJAX pour uploader une image
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif'
            ]);
            
            // Upload de l'image
            $imagePath = $this->uploadImage($request);
            
            if ($imagePath) {
                $student->update(['image' => $imagePath]);
                
                return response()->json([
                    'success' => true,
                    'image_url' => asset($imagePath) . '?t=' . time()
                ]);
            }
            
            return response()->json(['success' => false, 'message' => 'Erreur lors du téléchargement'], 500);
        }

        // Si c'est une requête AJAX inline (modification rapide d'un seul champ)
        if ($request->ajax() || $request->wantsJson()) {
            // Déterminer le champ modifié en ignorant _method et _token (ordre non garanti)
            $keys = array_values(array_diff($request->keys(), ['_method', '_token']));
            $field = $keys[0] ?? null;
            $value = $field ? $request->input($field) : null;

            // Liste des champs autorisés à l'édition rapide
            $editableFields = [
                'sexe' => 'nullable|string|max:10',
                // Allow nullable for inline editing (full form still requires date)
                'date_naissance' => 'nullable|date',
                'lieu_naissance' => 'nullable|string|max:255',
                'nationalite' => 'nullable|string|max:255',
                'religion' => 'nullable|string|max:255',
                // For inline edits enforce allowed civil statuses (required to avoid NULL DB updates)
                // Values normalized to match DB enum: lowercase with accents
                'etat_civil' => 'required|in:célibataire,marié,divorcé,veuf',
                'telephone' => 'nullable|string|max:255',
                'adresse' => 'nullable|string|max:255',
                'region' => 'nullable|string|max:255',
                'district' => 'nullable|string|max:255',
                'bacc_serie' => 'nullable|string|max:255',
                'bacc_date_obtention' => 'nullable|digits:4',
                'nom_conjoint' => 'nullable|string|max:255',
                'nb_enfant' => 'nullable|integer',
                'cin_numero' => 'nullable|string|max:255',
                'cin_date_delivrance' => 'nullable|date',
                'cin_lieu_delivrance' => 'nullable|string|max:255',
                'nom_pere' => 'nullable|string|max:255',
                'profession_pere' => 'nullable|string|max:255',
                'contact_pere' => 'nullable|string|max:255',
                'nom_mere' => 'nullable|string|max:255',
                'profession_mere' => 'nullable|string|max:255',
                'contact_mere' => 'nullable|string|max:255',
                'adresse_parents' => 'nullable|string|max:255',
                'sponsor_nom' => 'nullable|string|max:255',
                'sponsor_prenom' => 'nullable|string|max:255',
                'sponsor_telephone' => 'nullable|string|max:255',
                'sponsor_adresse' => 'nullable|string|max:255',
                'taille' => 'nullable|string|in:S,M,L,XL,XXL,XXXL',
            ];

            if (!$field || !array_key_exists($field, $editableFields)) {
                return response()->json(['success' => false, 'message' => 'Champ non autorisé.'], 422);
            }

            // Validation du champ unique
            $validated = $request->validate([
                $field => $editableFields[$field]
            ]);

            // Correction pour date_naissance si besoin
            if ($field === 'date_naissance' && $validated[$field]) {
                // S'assurer que la date est bien au format Y-m-d
                $validated[$field] = date('Y-m-d', strtotime($validated[$field]));
            }

            $student->update($validated);

            return response()->json(['success' => true]);
        }

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'sexe' => 'nullable|string|max:10',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'nullable|string|max:255',
            'nationalite' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:255',
            'etat_civil' => 'nullable|string|max:255',
            'passport_status' => 'nullable|boolean',
            'passport_numero' => 'nullable|string|max:255',
            'passport_pays_emission' => 'nullable|string|max:255',
            'passport_date_emission' => 'nullable|date',
            'passport_date_expiration' => 'nullable|date',
            'nom_conjoint' => 'nullable|string|max:255',
            'nb_enfant' => 'nullable|integer',
            'cin_numero' => 'nullable|string|max:255',
            'cin_date_delivrance' => 'nullable|date',
            'cin_lieu_delivrance' => 'nullable|string|max:255',
            'nom_pere' => 'nullable|string|max:255',
            'profession_pere' => 'nullable|string|max:255',
            'contact_pere' => 'nullable|string|max:255',
            'nom_mere' => 'nullable|string|max:255',
            'profession_mere' => 'nullable|string|max:255',
            'contact_mere' => 'nullable|string|max:255',
            'adresse_parents' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:255',
            'email' => 'required|email|unique:students,email,' . $id,
            'adresse' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'bacc_serie' => 'nullable|string|max:255',
            'bacc_date_obtention' => 'nullable',
            'bursary_status' => 'nullable|boolean',
            'sponsor_nom' => 'nullable|string|max:255',
            'sponsor_prenom' => 'nullable|string|max:255',
            'sponsor_telephone' => 'nullable|string|max:255',
            'sponsor_adresse' => 'nullable|string|max:255',
            'year_level_id' => 'required|exists:year_levels,id',
            'mention_id' => 'nullable|exists:mentions,id',
            'parcours_id' => 'nullable|exists:parcours,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'abonne_caf' => 'nullable|boolean',
        ]);

        // Upload photo si besoin
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request);
            if ($imagePath) {
                $validated['image'] = $imagePath;
            }
        }
        
        $validated['abonne_caf'] = $request->has('abonne_caf');

        // Gestion du semester_id comme dans storeStudent
        $activeAcademicYear = AcademicYear::where('active', true)->first();
        if ($activeAcademicYear) {
            // Récupérer le semestre d'ordre 1 de cette année académique
            $semester = Semester::where('academic_year_id', $activeAcademicYear->id)
                ->where('ordre', 1)
                ->first();
            if ($semester) {
                $validated['semester_id'] = $semester->id;
            }
            $validated['academic_year_id'] = $activeAcademicYear->id;
        }

        // Correction robuste pour bacc_date_obtention
        if (isset($validated['bacc_date_obtention']) && $validated['bacc_date_obtention'] !== null && $validated['bacc_date_obtention'] !== '') {
            if (preg_match('/^\d{4}-\d{2}-\d{2}/', $validated['bacc_date_obtention'])) {
                $validated['bacc_date_obtention'] = (int)substr($validated['bacc_date_obtention'], 0, 4);
            } else {
                $validated['bacc_date_obtention'] = (int)$validated['bacc_date_obtention'];
            }
            if ($validated['bacc_date_obtention'] < 1900 || $validated['bacc_date_obtention'] > (date('Y')+1)) {
                $validated['bacc_date_obtention'] = null;
            }
        } else {
            $validated['bacc_date_obtention'] = null;
        }

        $student->update($validated);
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'image_url' => isset($validated['image']) ? asset($validated['image']) : null
            ]);
        }
        
        return redirect()->route('superadmin.students.list')->with('success', 'Étudiant modifié avec succès.');
    }
    public function destroyStudent($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return redirect()->route('superadmin.students.list')->with('success', 'Étudiant supprimé avec succès.');
    }
    public function showStudent($id)
    {
        $student = Student::with('lastChangedBy')->findOrFail($id);
        $yearLevels = YearLevel::all();
        return view('superadmin.students.show', compact('student', 'yearLevels'));
    }
    public function showStudentCourses($id)
    {
        $student = Student::findOrFail($id);
        return view('superadmin.students.courses-history', compact('student'));
    }

    public function updateSettings(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'lang' => 'required|in:fr,en',
            'notif_email' => 'nullable|boolean',
            'notif_sms' => 'nullable|boolean',
        ]);
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->lang = $validated['lang'];
        $user->notif_email = $request->has('notif_email');
        $user->notif_sms = $request->has('notif_sms');
        if (!empty($validated['password'])) {
            // store plain password as requested (note: storing plaintext passwords is insecure)
            $user->plain_password = $validated['password'];
            $user->password = bcrypt($validated['password']);
        }
        $user->save();
        return redirect()->back()->with('success', 'Paramètres mis à jour avec succès.');
    }

    public function addCourseToStudent($studentId)
    {
        $student = Student::findOrFail($studentId);
        // Exclure les cours déjà pris (non retirés)
        $takenCourseIds = $student->courses()->wherePivot('deleted_at', null)->pluck('courses.id')->toArray();
        // Determine whether the legacy `year_level_id` column exists on the courses table
        $hasLegacyYearLevelColumn = Schema::hasColumn('courses', 'year_level_id');
        // Ne récupérer que les cours qui correspondent au niveau de l'étudiant.
        // Supporte la relation many-to-many via la table pivot `course_yearlevel`
        // ou la colonne legacy `year_level_id` si elle existe encore.
        $courses = Course::whereNotIn('id', $takenCourseIds)
            ->where(function($query) use ($student, $hasLegacyYearLevelColumn) {
                // First, filter by mention: allow global courses (mention_id IS NULL) or courses for the student's mention
                $query->where(function($q) use ($student) {
                    $q->whereNull('mention_id')
                      ->orWhere('mention_id', $student->mention_id);
                });

                // Then, ensure the course is available for the student's year level (pivot or legacy column)
                $query->where(function($q) use ($student, $hasLegacyYearLevelColumn) {
                    $studentYearLevelCode = optional($student->yearLevel)->code ?? null;

                    if ($studentYearLevelCode) {
                        // Prefer matching by year level code on the pivot relation
                        $q->whereHas('yearLevels', function($q2) use ($studentYearLevelCode) {
                            $q2->where('year_levels.code', $studentYearLevelCode);
                        });

                        // Fallback: if legacy column exists and a numeric year_level_id is present, allow it too
                        if ($hasLegacyYearLevelColumn && isset($student->year_level_id)) {
                            $q->orWhere('year_level_id', $student->year_level_id);
                        }
                    } else {
                        // If no code available, fall back to matching by year_level_id as before
                        $q->whereHas('yearLevels', function($q2) use ($student) {
                            $q2->where('year_levels.id', $student->year_level_id);
                        });

                        if ($hasLegacyYearLevelColumn && isset($student->year_level_id)) {
                            $q->orWhere('year_level_id', $student->year_level_id);
                        }
                    }
                });
            })
            ->get();
        return view('superadmin.students.courses-add', compact('student', 'courses'));
    }

    public function storeCourseToStudent(Request $request, $studentId)
    {
        $student = Student::findOrFail($studentId);
        $request->validate([
            'course_id' => 'required|array',
            'course_id.*' => 'exists:courses,id',
        ]);
        foreach ($request->course_id as $courseId) {
            $existing = $student->courses()->where('course_id', $courseId)->first();
            if ($existing && $existing->pivot->deleted_at) {
                $student->courses()->updateExistingPivot($courseId, [
                    'deleted_at' => null,
                    'updated_at' => now(),
                ]);
            } elseif (!$existing) {
                $student->courses()->attach($courseId, [
                    'added_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ]);
            }
        }
        // Recompute and update total credits for the student's finance row
        $this->recomputeStudentFinanceTotalCredits($student->id);

        // Recompute student's semester fee breakdown (ecolage depends on attached courses)
        try {
            if ($student->academic_year_id && $student->semester_id) {
                (new InstallmentService())->computeSemesterFees($student->fresh(), $student->academic_year_id, $student->semester_id, auth()->id());
            }
        } catch (\Throwable $e) {
            logger()->warning('Failed to recompute semester fees after adding courses for student ' . $student->id . ': ' . $e->getMessage());
        }

        return redirect()->route('superadmin.students.courses.history', $student->id)->with('success', 'Cours ajoutés à l\'étudiant.');
    }

    public function removeCourseFromStudent($studentId, $courseId)
    {
        $student = Student::findOrFail($studentId);
        $student->courses()->updateExistingPivot($courseId, [
            'deleted_at' => now(),
            'updated_at' => now(),
        ]);
        // Recompute and update total credits for the student's finance row
        $this->recomputeStudentFinanceTotalCredits($student->id);

        // Recompute student's semester fee breakdown (ecolage depends on attached courses)
        try {
            if ($student->academic_year_id && $student->semester_id) {
                (new InstallmentService())->computeSemesterFees($student->fresh(), $student->academic_year_id, $student->semester_id, auth()->id());
            }
        } catch (\Throwable $e) {
            logger()->warning('Failed to recompute semester fees after removing course for student ' . $student->id . ': ' . $e->getMessage());
        }

        return back()->with('success', 'Cours retiré de l\'étudiant.');
    }

    /**
     * Recompute total credits for a student from course_student pivot and update finance.total_credit
     * @param int $studentId
     * @return void
     */
    private function recomputeStudentFinanceTotalCredits(int $studentId): void
    {
        // Sum credits for non-deleted pivot entries
        $totalCredits = DB::table('course_student')
            ->join('courses', 'course_student.course_id', '=', 'courses.id')
            ->where('course_student.student_id', $studentId)
            ->whereNull('course_student.deleted_at')
            ->sum('courses.credits');

        $student = Student::find($studentId);
        if (!$student) {
            return;
        }

        // Update finance row(s) that reference this student's matricule
        if ($student->matricule) {
            Finance::where('student_id', $student->matricule)
                ->update(['total_credit' => (int)$totalCredits]);
        }
    }

    public function showCourse($id)
    {
        $course = Course::with('teacher', 'students')->findOrFail($id);
        return view('superadmin.courses.show', compact('course'));
    }
    public function showMention($id)
    {
        $mention = Mention::with('students')->findOrFail($id);
        return view('superadmin.mentions.show', compact('mention'));
    }

    // FINANCES
    public function financesList()
    {
        // Eager-load student (with their installments ordered by sequence), semester and lastChangedBy
        $finances = Finance::with([
            'student.installments' => function($q) { $q->orderBy('sequence'); },
            'semester',
            'lastChangedBy'
        ])->orderByDesc('date_entry')->get();

        // determine the most recent change across finance rows (if any)
        $lastChange = Finance::whereNotNull('last_change_datetime')
            ->orderByDesc('last_change_datetime')
            ->with('lastChangedBy')
            ->first();

        $lastChangedBy = null;
        $lastChangedAt = null;
        if ($lastChange) {
            $lastChangedBy = $lastChange->lastChangedBy;
            $lastChangedAt = $lastChange->last_change_datetime;
        }

        // Prepare fee type ids for lookup
        $feeTypeNames = ['Frais Généraux', 'Écolage', 'Cantine', 'Dortoir'];
        $feeTypes = \App\Models\FeeType::whereIn('name', $feeTypeNames)->get()->keyBy('name');

        // For each finance row, compute what the student should pay (based on AcademicFee entries and student flags)
        foreach ($finances as $finance) {
            // If the finance->student relation is null but the finance row stores a matricule in student_id,
            // try to resolve the Student model and attach it (with installments) so the view can use it.
            if (!$finance->student && $finance->student_id) {
                $resolved = \App\Models\Student::where('matricule', $finance->student_id)
                    ->with(['installments' => function($q) { $q->orderBy('sequence'); }])
                    ->first();
                if ($resolved) {
                    // attach the resolved student to the finance model instance for easy access in the view
                    $finance->student = $resolved;
                }
            }

            $student = $finance->student;
            $computed = [
                'frais_generaux' => 0,
                'ecolage' => 0,
                'cantine' => 0,
                'dortoir' => 0,
                'total_due' => 0,
            ];

            if ($student) {
                // Find academic fees matching the student's mention/year level/academic year and semester if available
                $query = \App\Models\AcademicFee::where('mention_id', $student->mention_id)
                    ->where('year_level_id', $student->year_level_id)
                    ->where('academic_year_id', $student->academic_year_id);

                if ($student->semester_id) {
                    $query->where('semester_id', $student->semester_id);
                }

                $fees = $query->get()->keyBy(function ($row) { return $row->feeType ? $row->feeType->name : $row->fee_type_id; });

                // frais généraux
                if (isset($feeTypes['Frais Généraux'])) {
                    $fgRow = $fees->firstWhere('fee_type_id', $feeTypes['Frais Généraux']->id) ?? $fees->get('Frais Généraux');
                    $computed['frais_generaux'] = $fgRow->amount ?? 0;
                }

                // ecolage
                if (isset($feeTypes['Écolage'])) {
                    $ecRow = $fees->firstWhere('fee_type_id', $feeTypes['Écolage']->id) ?? $fees->get('Écolage');
                    $computed['ecolage'] = $ecRow->amount ?? 0;
                }

                // cantine (only if student subscribed)
                if ($student->abonne_caf) {
                    if (isset($feeTypes['Cantine'])) {
                        $cRow = $fees->firstWhere('fee_type_id', $feeTypes['Cantine']->id) ?? $fees->get('Cantine');
                        $computed['cantine'] = $cRow->amount ?? 0;
                    }
                }

                // dortoir (only if student is interne / statut_interne truthy)
                $isInterne = false;
                if (in_array($student->statut_interne, [true, 'true', '1', 1, 'interne', 'Interne', 'intern'])) {
                    $isInterne = true;
                }
                if ($isInterne) {
                    if (isset($feeTypes['Dortoir'])) {
                        $dRow = $fees->firstWhere('fee_type_id', $feeTypes['Dortoir']->id) ?? $fees->get('Dortoir');
                        $computed['dortoir'] = $dRow->amount ?? 0;
                    }
                }

                $computed['total_due'] = array_sum([$computed['frais_generaux'], $computed['ecolage'], $computed['cantine'], $computed['dortoir']]);
            }

            // Attach computed array to finance model so the view can use it
            $finance->computed = (object)$computed;
        }

        return view('superadmin.finances.list', compact('finances', 'lastChangedBy', 'lastChangedAt'));
    }

    /**
     * Update finance plan (A..E) via AJAX
     */
    public function updateFinancePlan(Request $request, $financeId)
    {
        $finance = Finance::findOrFail($financeId);

        $validated = $request->validate([
            'plan' => 'required|string|in:A,B,C,D,E'
        ]);

        $finance->plan = $validated['plan'];
        $finance->last_change_user_id = auth()->id() ?? $finance->last_change_user_id;
        $finance->last_change_datetime = now();
        $finance->save();

        return response()->json(['success' => true, 'plan' => $finance->plan]);
    }

    public function createFinance()
    {
        $students = Student::all();
        $courses = Course::all();
        return view('superadmin.finances.create', compact('students', 'courses'));
    }

    public function storeFinance(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'type' => 'required|string|max:255',
            'montant' => 'required|numeric|min:0',
            'status' => 'required|string|max:50',
            'description' => 'nullable|string',
            'course_id' => 'nullable|exists:courses,id',
            'extra' => 'nullable|array',
        ]);
        if (isset($validated['extra'])) {
            $validated['extra'] = json_encode($validated['extra']);
        }
        StudentFinance::create($validated);
        return redirect()->route('superadmin.finances.list')->with('success', 'Finance ajoutée avec succès.');
    }

    public function showFinance($id)
    {
        $finance = StudentFinance::with(['student', 'course'])->findOrFail($id);
        return view('superadmin.finances.show', compact('finance'));
    }

    public function editFinance($id)
    {
        $finance = StudentFinance::findOrFail($id);
        $students = Student::all();
        $courses = Course::all();
        return view('superadmin.finances.edit', compact('finance', 'students', 'courses'));
    }

    public function updateFinance(Request $request, $id)
    {
        $finance = StudentFinance::findOrFail($id);
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'type' => 'required|string|max:255',
            'montant' => 'required|numeric|min:0',
            'status' => 'required|string|max:50',
            'description' => 'nullable|string',
            'course_id' => 'nullable|exists:courses,id',
            'extra' => 'nullable|array',
        ]);
        if (isset($validated['extra'])) {
            $validated['extra'] = json_encode($validated['extra']);
        }
        $finance->update($validated);
        return redirect()->route('superadmin.finances.list')->with('success', 'Finance modifiée avec succès.');
    }

    public function destroyFinance($id)
    {
        $finance = StudentFinance::findOrFail($id);
        $finance->delete();
        return redirect()->route('superadmin.finances.list')->with('success', 'Finance supprimée avec succès.');
    }

    // DETAILS FINANCES CRUD

    public function index()
    {
        // Return the academic fees so the financedetails index shows academic_fees table content
        $details = \App\Models\AcademicFee::with(['feeType', 'mention', 'yearLevel', 'academicYear', 'semester'])->get();
        return view('superadmin.financedetails.index', compact('details'));
    }

    public function create()
    {
        $mentions = \App\Models\Mention::all();
        return view('superadmin.financedetails.create', compact('mentions'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'statut_etudiant' => 'required|string',
            'mention_id' => 'nullable|exists:mentions,id',
            'frais_generaux' => 'required|numeric',
            'ecolage' => 'required|numeric',
            'laboratory' => 'required|numeric',
            'dortoir' => 'required|numeric',
            'nb_jours_semestre' => 'nullable|integer',
            'nb_jours_semestre_L2' => 'nullable|integer',
            'nb_jours_semestre_L3' => 'nullable|integer',
            'cafeteria' => 'required|numeric',
            'fond_depot' => 'required|numeric',
            'frais_graduation' => 'required|numeric',
            'frais_costume' => 'required|numeric',
            'frais_voyage' => 'required|numeric',
        ]);
        \App\Models\FinanceDetail::create($validated);
        return redirect()->route('superadmin.financedetails.index')->with('success', 'Détail finance ajouté.');
    }

    public function edit($id)
    {
        $detail = \App\Models\FinanceDetail::findOrFail($id);
        $mentions = \App\Models\Mention::all();
        return view('superadmin.financedetails.edit', compact('detail', 'mentions'));
    }

    public function update(\Illuminate\Http\Request $request, $id)
    {
        $validated = $request->validate([
            'statut_etudiant' => 'required|string',
            'mention_id' => 'nullable|exists:mentions,id',
            'frais_generaux' => 'required|numeric',
            'ecolage' => 'required|numeric',
            'laboratory' => 'required|numeric',
            'dortoir' => 'required|numeric',
            'nb_jours_semestre' => 'nullable|integer',
            'nb_jours_semestre_L2' => 'nullable|integer',
            'nb_jours_semestre_L3' => 'nullable|integer',
            'cafeteria' => 'required|numeric',
            'fond_depot' => 'required|numeric',
            'frais_graduation' => 'required|numeric',
            'frais_costume' => 'required|numeric',
            'frais_voyage' => 'required|numeric',
        ]);
        $detail = \App\Models\FinanceDetail::findOrFail($id);
        $detail->update($validated);
        return redirect()->route('superadmin.financedetails.index')->with('success', 'Détail finance modifié.');
    }

    public function destroy($id)
    {
        $detail = \App\Models\FinanceDetail::findOrFail($id);
        $detail->delete();
        return redirect()->route('superadmin.financedetails.index')->with('success', 'Détail finance supprimé.');
    }

    public function show($id)
    {
        $detail = \App\Models\FinanceDetail::with('mention')->findOrFail($id);
        return view('superadmin.financedetails.show', compact('detail'));
    }

    // Exemple d'appel à la vue pour l'export PDF étudiant :
    public function exportStudentPdf($id)
    {
        $student = Student::findOrFail($id);
        $pdf = Pdf::loadView('PDFexport.recap-pdf', compact('student'));
        return $pdf->download('fiche-inscription-'.$student->matricule.'.pdf');
    }

    // Preview wrapper for SuperAdmin (moved from ExportPreviewController)
    public function previewIndex(Request $request)
    {
        $ptype = $request->get('ptype', 'Fiche_inscription');

        // Map default scale/quality per ptype (simple defaults)
        $map = [
            'Fiche_inscription' => ['scale' => 3, 'quality' => 3],
            'Badge' => ['scale' => 4, 'quality' => 4],
            'Diplôme' => ['scale' => 4, 'quality' => 4],
            'worked' => ['scale' => 1, 'quality' => 1],
        ];

        $cfg = $map[$ptype] ?? ['scale' => 3, 'quality' => 3];

        return view('preview.print-preview', [
            'ptype' => $ptype,
            'scale' => $cfg['scale'],
            'quality' => $cfg['quality'],
            'printName' => strtoupper($ptype),
        ]);
    }

    // Return the content fragment to preview (selected by ptype) - placed in SuperAdminController so it has access to the same context
    public function previewContent(Request $request)
    {
        $ptype = $request->get('ptype', 'Fiche_inscription');

        // allow previewing a specific student if provided
        $studentId = $request->get('student_id');

        if ($ptype === 'Fiche_inscription') {
            $student = null;
            // Defensive: ensure user still authenticated as SuperAdmin. The route is protected,
            // but fetch() from the preview wrapper may follow redirects to login if session expired.
            if (!auth()->check() || !method_exists(auth()->user(), 'isSuperAdmin') || !auth()->user()->isSuperAdmin()) {
                return '<div style="padding:20px">Vous devez être connecté en tant que SuperAdmin pour voir cette prévisualisation. Veuillez vous reconnecter.</div>';
            }

            if ($studentId) {
                // Load student basic relations; we'll set the courses relation explicitly later to filter deleted pivots
                $student = Student::with(['mention', 'parcours', 'yearLevel'])
                    ->find($studentId);
            }
            if (!$student) {
                $student = Student::with(['mention', 'parcours', 'yearLevel'])->first();
            }
            if (!$student) {
                return '<div style="padding:20px">Aucun étudiant trouvé pour la prévisualisation.</div>';
            }

            // Ensure StudentSemesterFee exists for this student's academic year & semester so recap-pdf can read persisted values
            try {
                if ($student->academic_year_id && $student->semester_id) {
                    $ssfExists = \App\Models\StudentSemesterFee::where('student_id', $student->id)
                        ->where('academic_year_id', $student->academic_year_id)
                        ->where('semester_id', $student->semester_id)
                        ->exists();
                    if (!$ssfExists) {
                        // compute and persist
                        try {
                            (new InstallmentService())->computeSemesterFees($student->fresh(), $student->academic_year_id, $student->semester_id, auth()->id() ?? null);
                            // refresh student to pick up any changes (don't force-reload courses here)
                            $student = $student->fresh(['mention', 'parcours', 'yearLevel']);
                        } catch (\Throwable $e) {
                            logger()->warning('Failed to compute StudentSemesterFee during preview for student '.$student->id.': '.$e->getMessage());
                        }
                    }
                }
            } catch (\Throwable $e) {
                // ignore and continue rendering fallback values
            }

            // Ensure the student's courses relation used by the Blade template returns only non-deleted pivots
            try {
                $courses = $student->courses()->wherePivot('deleted_at', null)->get();
                $student->setRelation('courses', $courses);
            } catch (\Throwable $e) {
                // ignore; the Blade view may re-query if necessary
            }

            // Render the existing recap pdf view (full HTML)
            $fullHtml = view('PDFexport.recap-pdf', ['student' => $student])->render();

            // Extract only the body contents (strip outer <!doctype><html><head>..</head><body>..</body></html>)
            $bodyHtml = $fullHtml;
            if (preg_match('#<body[^>]*>(.*)</body>#is', $fullHtml, $bm)) {
                $bodyHtml = $bm[1];
            }

            // Shared PDF styles (as fragment)
            $styles = '';
            if (view()->exists('layouts.pdf-style')) {
                $styles = view('layouts.pdf-style')->render();
            }

            // If the client requested full HTML (full=1), we will transform and return the complete HTML
            $returnFull = (bool)$request->get('full');

            $html = $returnFull ? $fullHtml : ($styles . $bodyHtml);

            // Convert any server filesystem paths (public_path) to web URLs so images load in browser preview
            try {
                $publicPath = str_replace('\\', '/', public_path());
                $publicPath = rtrim($publicPath, '/');
                $publicPathNormalized = $publicPath;
                $baseUrl = rtrim(url('/'), '/');

                // Normalize HTML backslashes to forward slashes for matching
                $html = str_replace('\\', '/', $html);

                // 1) Replace occurrences where the full public path appears
                if (!empty($publicPathNormalized)) {
                    $html = str_replace($publicPathNormalized, $baseUrl, $html);
                }

                // 2) Replace src/href attributes that point to filesystem paths or file:// urls
                $html = preg_replace_callback('/(src|href)=["\']([^"\']+)["\']/i', function($m) use ($baseUrl, $publicPathNormalized) {
                    $attr = $m[1];
                    $val = $m[2];
                    $valNorm = str_replace('\\', '/', $val);

                    // Keep already valid web URLs (http, https, //, data)
                    if (preg_match('#^[a-zA-Z][a-zA-Z0-9+.-]*://#', $valNorm) || strpos($valNorm, '//') === 0 || strpos($valNorm, 'data:') === 0) {
                        return $m[0];
                    }

                    // If value contains public path, map to baseUrl + relative
                    if (!empty($publicPathNormalized) && strpos($valNorm, $publicPathNormalized) !== false) {
                        $rel = substr($valNorm, strlen($publicPathNormalized));
                        $rel = ltrim($rel, '/');
                        $new = $baseUrl . '/' . $rel;
                        return $attr . '="' . $new . '"';
                    }

                    // Windows drive absolute path like C:/... or file:///C:/...
                    if (preg_match('#^[A-Za-z]:/#', $valNorm) || preg_match('#^file:///#i', $valNorm) || preg_match('#^file://#i', $valNorm)) {
                        $parts = explode('/', $valNorm);
                        $file = end($parts);
                        $new = $baseUrl . '/' . ltrim($file, '/');
                        return $attr . '="' . $new . '"';
                    }

                    // Relative storage path (storage/...) -> map to baseUrl/storage/...
                    if (strpos($valNorm, 'storage/') === 0) {
                        $new = $baseUrl . '/' . ltrim($valNorm, '/');
                        return $attr . '="' . $new . '"';
                    }

                    // If it's an absolute path on the domain (starts with /), keep as-is
                    if (strpos($valNorm, '/') === 0) {
                        return $attr . '="' . $valNorm . '"';
                    }

                    // Fallback: return the original value
                    return $m[0];
                }, $html);

                // 3) Replace CSS url(...) occurrences
                $html = preg_replace_callback('/url\(([^)]+)\)/i', function($m) use ($baseUrl, $publicPathNormalized) {
                    $inside = trim($m[1], " \"'\t\n\r");
                    $valNorm = str_replace('\\', '/', $inside);

                    if (preg_match('#^[a-zA-Z][a-zA-Z0-9+.-]*://#', $valNorm) || strpos($valNorm, '//') === 0 || strpos($valNorm, 'data:') === 0) {
                        return 'url(' . $inside . ')';
                    }

                    if (!empty($publicPathNormalized) && strpos($valNorm, $publicPathNormalized) !== false) {
                        $rel = substr($valNorm, strlen($publicPathNormalized));
                        $rel = ltrim($rel, '/');
                        $new = $baseUrl . '/' . $rel;
                        return 'url(' . $new . ')';
                    }

                    if (preg_match('#^[A-Za-z]:/#', $valNorm) || preg_match('#^file:///#i', $valNorm) || preg_match('#^file://#i', $valNorm)) {
                        $parts = explode('/', $valNorm);
                        $file = end($parts);
                        $new = $baseUrl . '/' . ltrim($file, '/');
                        return 'url(' . $new . ')';
                    }

                    if (strpos($valNorm, 'storage/') === 0) {
                        $new = $baseUrl . '/' . ltrim($valNorm, '/');
                        return 'url(' . $new . ')';
                    }

                    return 'url(' . $inside . ')';
                }, $html);

                // 4) Try to inline local images (<img src="...">) as data URIs so preview loads even when files are not publicly served
                $html = preg_replace_callback('/<img[^>]+src=["\']([^"\']+)["\'][^>]*>/i', function($m) use ($baseUrl, $publicPathNormalized) {
                    $orig = $m[0];
                    $src = $m[1];
                    $srcNorm = str_replace('\\', '/', $src);

                    // skip already data or remote URLs
                    if (strpos($srcNorm, 'data:') === 0 || preg_match('#^[a-zA-Z][a-zA-Z0-9+.-]*://#', $srcNorm) || strpos($srcNorm, '//') === 0) {
                        return $orig;
                    }

                    $fs = null;

                    // If URL starts with baseUrl, map back to public path
                    if (!empty($baseUrl) && strpos($srcNorm, $baseUrl) === 0) {
                        $rel = substr($srcNorm, strlen($baseUrl));
                        $rel = ltrim($rel, '/');
                        $candidate = $publicPathNormalized . '/' . $rel;
                        if (file_exists($candidate)) $fs = $candidate;
                    }

                    // If it's an absolute path on the domain (/storage/...), map to public_path
                    if (!$fs && strpos($srcNorm, '/') === 0) {
                        $candidate = public_path(ltrim($srcNorm, '/'));
                        if (file_exists($candidate)) $fs = $candidate;
                    }

                    // If it looks like storage/filename
                    if (!$fs && strpos($srcNorm, 'storage/') === 0) {
                        $candidate = public_path($srcNorm);
                        if (file_exists($candidate)) $fs = $candidate;
                    }

                    // Windows drive path or file://
                    if (!$fs) {
                        $tmp = preg_replace('#^file:///#i', '', $srcNorm);
                        $tmp = preg_replace('#^file://#i', '', $tmp);
                        $tmp = str_replace('/', DIRECTORY_SEPARATOR, $tmp);
                        if (preg_match('#^[A-Za-z]:\\#', $tmp) && file_exists($tmp)) {
                            $fs = $tmp;
                        }
                    }

                    if ($fs && is_readable($fs)) {
                        try {
                            $data = file_get_contents($fs);
                            if ($data !== false) {
                                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                                $mime = $finfo ? finfo_file($finfo, $fs) : mime_content_type($fs);
                                if ($finfo) finfo_close($finfo);
                                if (!$mime) $mime = 'application/octet-stream';
                                $b64 = base64_encode($data);
                                $dataUri = 'data:' . $mime . ';base64,' . $b64;

                                // replace src attribute value with data URI
                                $new = preg_replace('/(src=["\'])([^"\']+)(["\'])/i', '\\1' . $dataUri . '\\3', $orig, 1);
                                return $new;
                            }
                        } catch (\Throwable $e) {
                            // ignore and keep original
                        }
                    }

                    return $orig;
                }, $html);

            } catch (\Exception $e) {
                // If anything fails, just return the raw HTML
            }

            return $html;
        }

        // Attempt to include a blade partial under preview.partials.{ptype}
        $partial = 'preview.partials.' . $ptype;
        if (view()->exists($partial)) {
            return view($partial)->render();
        }

        // Fallback message
        return "<div style='padding:20px'>Aucun contenu de prévisualisation disponible pour <strong>{$ptype}</strong>.</div>";
    }

    /**
     * AJAX: recompute a student's semester fee and return the before/after record
     */
    public function recomputeStudentSemesterFee(Request $request, $studentId)
    {
        $student = Student::findOrFail($studentId);
        // require auth and appropriate permission - this route is under superadmin middleware in routes

        if (!$student->academic_year_id || !$student->semester_id) {
            return response()->json(['success' => false, 'message' => 'Student has no academic_year_id or semester_id set'], 422);
        }

        // fetch existing record snapshot (if any)
        $before = \App\Models\StudentSemesterFee::where('student_id', $student->id)
            ->where('academic_year_id', $student->academic_year_id)
            ->where('semester_id', $student->semester_id)
            ->first();

        // Run recompute (this persists the StudentSemesterFee via InstallmentService)
        try {
            $service = new InstallmentService();
            $after = $service->computeSemesterFees($student->fresh(), $student->academic_year_id, $student->semester_id, auth()->id());
        } catch (\Throwable $e) {
            logger()->error('Failed to recompute semester fees for student ' . $student->id . ': ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to recompute: ' . $e->getMessage()], 500);
        }

        return response()->json(['success' => true, 'before' => $before, 'after' => $after]);
    }

}