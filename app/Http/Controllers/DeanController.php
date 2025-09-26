<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\YearLevel;
use App\Models\Teacher;
use App\Services\InstallmentService;
use Barryvdh\DomPDF\Facade\Pdf;

class DeanController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // Check if user exists and has mention
        if (!$user || !$user->mention) {
            abort(403, 'Unauthorized - No mention assigned');
        }

        $mention = $user->mention;
        $totalStudents = Student::where('mention_id', $mention->id)->count();
        $students = Student::where('mention_id', $mention->id)->orderByDesc('created_at')->get();
        $totalCourses = Course::where('mention_id', $mention->id)->count();
        // Total number of teachers for this mention
        // Teachers aren't directly linked to mentions in the teachers table; count distinct teachers assigned to courses in this mention
        $totalTeachers = Course::where('mention_id', $mention->id)
            ->whereNotNull('teacher_id')
            ->distinct()
            ->pluck('teacher_id')
            ->filter()
            ->unique()
            ->count();

        return view('dean.dashboard', compact('mention', 'students', 'totalStudents', 'totalCourses', 'totalTeachers'));
    }

    public function students()
    {
        $mention = auth()->user()->mention;
        $students = Student::where('mention_id', $mention->id)
                            ->orderByDesc('id')
                            ->get();
        return view('dean.students.index', compact('students'));
    }

    public function showStudent($id)
    {
        $student = Student::findOrFail($id);
        if ($student->mention_id !== auth()->user()->mention_id) {
            abort(403);
        }
        return view('dean.students.show', compact('student'));
    }

    public function studentsList()
    {
        $mention = auth()->user()->mention;
        if (!$mention) {
            abort(403, 'Unauthorized - No mention assigned');
        }

    $students = Student::where('mention_id', $mention->id)
              ->where('fee_check', 1)
              ->orderByDesc('id')
              ->get();

        return view('dean.students.index', [
            'students' => $students,
            'studentsArray' => $students->map(function($student) {
                return [
                    'id' => $student->id,
                    'matricule' => $student->matricule,
                    'photo' => $student->image,
                    'nom' => $student->nom,
                    'prenom' => $student->prenom,
                    'email' => $student->email,
                    'niveau_etude' => $student->niveau_etude,
                    'mention_nom' => $student->mention->nom,
                    'mention_id' => $student->mention_id,
                    'year_level_label' => $student->yearLevel ? $student->yearLevel->label : '-',
                ];
            })->toArray(),
            'mentions' => [$mention] // Pass the dean's mention as a single-item array
        ]);
    }

    public function showStudentCourses($id)
    {
        $student = Student::findOrFail($id);
        return view('dean.students.courses-history', compact('student'));
    }

    public function addCourseToStudent($studentId)
    {
        $student = Student::findOrFail($studentId);
        // Exclure les cours déjà pris (non retirés)
        $takenCourseIds = $student->courses()->wherePivot('deleted_at', null)->pluck('courses.id')->toArray();

        // Build base query for available courses in the student's mention
        $coursesQuery = Course::where('mention_id', $student->mention_id)
            ->whereNotIn('id', $takenCourseIds);

        // Restrict courses to those matching the student's year level code when available.
        // Example: if student's year level code is 'L1R', only show courses associated with 'L1R'.
        $studentYearLevelCode = optional($student->yearLevel)->code ?? null;
        if ($studentYearLevelCode) {
            $coursesQuery->whereHas('yearLevels', function ($q) use ($studentYearLevelCode) {
                $q->where('code', $studentYearLevelCode);
            });
        }

        $courses = $coursesQuery->get();

        return view('dean.students.courses-add', compact('student', 'courses'));
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
        // Recompute student's semester fee breakdown (ecolage depends on attached courses)
        try {
            if ($student->academic_year_id && $student->semester_id) {
                (new InstallmentService())->computeSemesterFees($student->fresh(), $student->academic_year_id, $student->semester_id, auth()->id());
            }
        } catch (\Throwable $e) {
            logger()->warning('Failed to recompute semester fees after adding courses for student ' . $student->id . ': ' . $e->getMessage());
        }

        return redirect()->route('dean.students.courses.history', $student->id)->with('success', 'Cours ajoutés à l\'étudiant.');
    }

    public function coursesList()
    {
        $mention = auth()->user()->mention;

        if (!$mention) {
            abort(403, 'Unauthorized - No mention assigned');
        }

        $courses = Course::with('teacher', 'yearLevels')
            ->where('mention_id', $mention->id)
            ->get();

        $yearLevels = YearLevel::all();

        return view('dean.courses.list', compact('courses', 'yearLevels'));
    }

    public function showCourse($id)
    {
        $course = Course::with('teacher', 'students')->findOrFail($id);
        return view('dean.courses.show', compact('course'));
    }

    /**
     * Export students enrolled in the course as CSV (streamed)
     */
    public function exportStudents($id)
    {
        $course = Course::with(['students.mention', 'students.yearLevel'])->findOrFail($id);
        $filename = 'Liste des étudiants - ' . ($course->sigle ?? $course->id) . '.pdf';
        $pdf = Pdf::loadView('dean.courses.students-pdf', compact('course'));

        return $pdf->download($filename);
    }

    // Teachers list for dean (teachers teaching in the dean's mention)
    public function teachersList()
    {
        $mention = auth()->user()->mention;
        if (!$mention) {
            abort(403, 'Unauthorized - No mention assigned');
        }

        // Get distinct teacher IDs from courses in this mention
        $teacherIds = Course::where('mention_id', $mention->id)
            ->whereNotNull('teacher_id')
            ->distinct()
            ->pluck('teacher_id')
            ->filter()
            ->toArray();

        // Load teachers by those IDs, preserving order
        $teachers = \App\Models\Teacher::whereIn('id', $teacherIds)->get();

        // If a dean-specific teachers view exists, use it; otherwise fall back to superadmin list view
        if (view()->exists('dean.teachers.list')) {
            return view('dean.teachers.list', compact('teachers'));
        }

        return view('superadmin.teachers.list', compact('teachers'));
    }

    /**
     * Remove (soft) a course from a student by setting deleted_at on the pivot.
     */
    public function removeCourseFromStudent(Request $request, $studentId, $courseId)
    {
        $student = Student::findOrFail($studentId);

        // Permission: dean can only act on students of their mention
        if ($student->mention_id !== auth()->user()->mention_id) {
            abort(403);
        }

        $course = Course::findOrFail($courseId);

        $existing = $student->courses()->where('courses.id', $courseId)->first();
        if ($existing && !$existing->pivot->deleted_at) {
            $student->courses()->updateExistingPivot($courseId, [
                'deleted_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Recompute student's semester fee breakdown (safe-guarded)
        try {
            if ($student->academic_year_id && $student->semester_id) {
                (new InstallmentService())->computeSemesterFees($student->fresh(), $student->academic_year_id, $student->semester_id, auth()->id());
            }
        } catch (\Throwable $e) {
            logger()->warning('Failed to recompute semester fees after removing course for student ' . $student->id . ': ' . $e->getMessage());
        }

        return redirect()->route('dean.students.courses.history', $student->id)->with('success', 'Cours retiré de l\'étudiant.');
    }

    /**
     * Show account/settings page for the dean.
     * Falls back to the superadmin settings view if a dean-specific view doesn't exist.
     */
    public function settings()
    {
        $user = auth()->user();

        if (view()->exists('dean.settings')) {
            return view('dean.settings', compact('user'));
        }

        if (view()->exists('dean.settings')) {
            return view('dean.settings', compact('user'));
        }

        abort(404, 'Settings view not found');
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

        // Apply locale immediately for the current session
        app()->setLocale($user->lang);
        session(['app_locale' => $user->lang]);

        return redirect()->back()->with('success', 'Paramètres mis à jour avec succès.');
    }
}
