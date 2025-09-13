<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Course;
use App\Models\Mention;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        $usersCount = User::count();
        $studentsCount = Student::count();
        $teachersCount = Teacher::count();
        $coursesCount = \App\Models\Course::count(); // Si ton modèle s'appelle Course

        // Dernières inscriptions (étudiants)
        $latestRegistrations = Student::orderBy('created_at', 'desc')
            ->latest()
            ->take(3)
            ->get();

        // Statistiques mensuelles (étudiants inscrits par mois)
        $monthlyRegistrations = Student::query()
            ->whereYear('created_at', now()->year)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month');

        return view('superadmin.dashboard', compact(
            'usersCount', 'studentsCount', 'teachersCount', 'coursesCount',
            'latestRegistrations', 'monthlyRegistrations'
        ));
    }

    public function coursesList()
    {
        $courses = Course::with('teacher')->get();
        return view('superadmin.courses-list', compact('courses'));
    }

    public function createCourse()
    {
        $teachers = Teacher::all();
        $mentions = Mention::all();
        return view('superadmin.courses-create', compact('teachers', 'mentions'));
    }

    public function storeCourse(Request $request)
    {
        $request->validate([
            'sigle' => 'required|unique:courses,sigle|max:10',
            'nom' => 'required|max:255',
            'credits' => 'required|integer|min:1|max:10',
            'teacher_id' => 'nullable|exists:teachers,id',
            'mention_id' => 'nullable|exists:mentions,id',
        ]);

        Course::create([
            'sigle' => $request->sigle,
            'nom' => $request->nom,
            'credits' => $request->credits,
            'teacher_id' => $request->teacher_id,
            'mention_id' => $request->mention_id,
        ]);

        return redirect()->route('superadmin.courses.list')->with('success', 'Cours créé avec succès.');
    }

    public function editCourse($id)
    {
        $course = Course::findOrFail($id);
        $teachers = Teacher::all();
        $mentions = Mention::all();
        return view('superadmin.courses-edit', compact('course', 'teachers', 'mentions'));
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
        return view('superadmin.teachers-list', compact('teachers'));
    }

    public function createTeacher()
    {
        return view('superadmin.teachers-create');
    }

    public function storeTeacher(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email',
        ]);
        Teacher::create($validated);
        return redirect()->route('superadmin.teachers.list')->with('success', 'Enseignant ajouté avec succès.');
    }

    public function editTeacher($id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('superadmin.teachers-edit', compact('teacher'));
    }

    public function updateTeacher(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email,' . $id,
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

    // USERS
    public function usersList()
    {
        $users = User::all();
        return view('superadmin.users-list', compact('users'));
    }
    public function createUser()
    {
        return view('superadmin.users-create');
    }
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string',
            'password' => 'required|string|min:6',
        ]);
        $validated['password'] = bcrypt($validated['password']);
        User::create($validated);
        return redirect()->route('superadmin.users.list')->with('success', 'Utilisateur ajouté avec succès.');
    }
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('superadmin.users-edit', compact('user'));
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
        return view('superadmin.mentions-list', compact('mentions'));
    }
    public function createMention()
    {
        return view('superadmin.mentions-create');
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
        return view('superadmin.mentions-edit', compact('mention'));
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
        $sortable = ['matricule', 'nom', 'prenom', 'email', 'mention_id', 'annee_etude']; // Ajout du tri par niveau d'étude
        $sort = $request->get('sort', 'matricule');
        $direction = $request->get('direction', 'asc');

        if (!in_array($sort, $sortable)) {
            $sort = 'matricule';
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

        // Préparer les tableaux pour le JS
        $studentsArray = $students->map(function($student) {
            return [
                'id' => $student->id,
                'matricule' => $student->matricule,
                'nom' => $student->nom,
                'prenom' => $student->prenom,
                'email' => $student->email,
                'mention_id' => $student->mention_id,
                'mention_nom' => $student->mention ? $student->mention->nom : '-',
                'annee_etude' => $student->annee_etude, // Ajout du niveau d'étude
            ];
        })->values()->toArray();

        $mentionsArray = $mentions->map(function($mention) {
            return [
                'id' => $mention->id,
                'nom' => $mention->nom,
            ];
        })->values()->toArray();

        return view('superadmin.students-list', compact('students', 'mentions', 'studentsArray', 'mentionsArray'));
    }
    public function createStudent()
    {
        $mentions = Mention::all();
        return view('superadmin.students-create', compact('mentions'));
    }
    private function uploadProfilePhoto(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('photo_profil'), $filename);
            return 'photo_profil/' . $filename;
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
            'email' => 'required|email|unique:students,email',
            'adresse' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'bacc_serie' => 'nullable|string|max:255',
            'bacc_date_obtention' => 'nullable|date',
            'bursary_status' => 'nullable|boolean',
            'sponsor_nom' => 'nullable|string|max:255',
            'sponsor_prenom' => 'nullable|string|max:255',
            'sponsor_telephone' => 'nullable|string|max:255',
            'sponsor_adresse' => 'nullable|string|max:255',
            'annee_etude' => 'nullable|integer',
            'mention_id' => 'nullable|exists:mentions,id',
            'matricule' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imagePath = $this->uploadProfilePhoto($request);
        if ($imagePath) {
            $validated['image'] = $imagePath;
        }
        Student::create($validated);
        return redirect()->route('superadmin.students.list')->with('success', 'Étudiant ajouté avec succès.');
    }
    public function editStudent($id)
    {
        $student = Student::findOrFail($id);
        $mentions = Mention::all();
        return view('superadmin.students-edit', compact('student', 'mentions'));
    }
    public function updateStudent(Request $request, $id)
    {
        $student = Student::findOrFail($id);
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
            'bacc_date_obtention' => 'nullable|date',
            'bursary_status' => 'nullable|boolean',
            'sponsor_nom' => 'nullable|string|max:255',
            'sponsor_prenom' => 'nullable|string|max:255',
            'sponsor_telephone' => 'nullable|string|max:255',
            'sponsor_adresse' => 'nullable|string|max:255',
            'annee_etude' => 'required|in:L1,L2,L3,M1,M2',
            'mention_id' => 'nullable|exists:mentions,id',
            'matricule' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imagePath = $this->uploadProfilePhoto($request);
        if ($imagePath) {
            $validated['image'] = $imagePath;
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
        $student = Student::findOrFail($id);
        return view('superadmin.students-show', compact('student'));
    }
    public function showStudentCourses($id)
    {
        $student = Student::findOrFail($id);
        return view('superadmin.students-courses-history', compact('student'));
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
        $courses = Course::where('mention_id', $student->mention_id)
            ->whereNotIn('id', $takenCourseIds)
            ->get();
        return view('superadmin.students-courses-add', compact('student', 'courses'));
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
        return redirect()->route('superadmin.students.courses.history', $student->id)->with('success', 'Cours ajoutés à l\'étudiant.');
    }

    public function removeCourseFromStudent($studentId, $courseId)
    {
        $student = Student::findOrFail($studentId);
        $student->courses()->updateExistingPivot($courseId, [
            'deleted_at' => now(),
            'updated_at' => now(),
        ]);
        return back()->with('success', 'Cours retiré de l\'étudiant.');
    }

    public function showCourse($id)
    {
        $course = Course::with('teacher', 'students')->findOrFail($id);
        return view('superadmin.courses-show', compact('course'));
    }
    public function showMention($id)
    {
        $mention = Mention::with('students')->findOrFail($id);
        return view('superadmin.mentions-show', compact('mention'));
    }
}