<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\Student;
use App\Models\Grade;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\AcademicYear;
use App\Models\Semester;


class TeacherController extends Controller
{
    /**
     * Display the teacher dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Try to resolve the Teacher model for the authenticated user.
        // Some installations link users->teacher via a relation, others keep teachers
        // as a separate table identified by email. We support both fallbacks here.
        $teacher = null;
        if ($user) {
            // If a relation exists on the User model, prefer it.
            try {
                $teacher = $user->teacher ?? null;
            } catch (\Throwable $e) {
                $teacher = null;
            }

            // Fallback: try to find a Teacher by the user's email.
            if (!$teacher) {
                $teacher = \App\Models\Teacher::where('email', $user->email)->first();
            }
        }

        if (!$user || !$teacher) {
            // Friendly redirect if no teacher profile is associated
            return redirect('/')->with('error', __('Profil enseignant introuvable. Veuillez contacter un administrateur.'));
        }

        // Compute totals: courses and unique students across those courses
        $courses = Course::where('teacher_id', $teacher->id)->with('students')->get();
        $totalCourses = $courses->count();
        $studentIds = $courses->flatMap(function ($c) {
            return $c->students->pluck('id');
        })->unique();
        $totalStudents = $studentIds->count();

        return view('teacher.dashboard', compact('teacher', 'user', 'courses', 'totalCourses', 'totalStudents'));
    }

    /**
     * Show the list of courses taught by the currently authenticated teacher.
     */
    public function coursesList()
    {
        $user = Auth::user();

        $teacher = null;
        if ($user) {
            try {
                $teacher = $user->teacher ?? null;
            } catch (\Throwable $e) {
                $teacher = null;
            }

            if (!$teacher) {
                $teacher = Teacher::where('email', $user->email)->first();
            }
        }

        if (!$user || !$teacher) {
            return redirect('/')->with('error', __('Profil enseignant introuvable. Veuillez contacter un administrateur.'));
        }

        $courses = Course::where('teacher_id', $teacher->id)->with(['teacher', 'mention', 'mentions', 'students'])->get();

    // Return teacher-specific courses list (same UI as dean)
    return view('teacher.courses.list', compact('courses'));
    }

    /**
     * List students taught by the authenticated teacher (unique students across their courses).
     */
    public function studentsIndex()
    {
        $user = Auth::user();

        $teacher = null;
        if ($user) {
            try {
                $teacher = $user->teacher ?? null;
            } catch (\Throwable $e) {
                $teacher = null;
            }

            if (!$teacher) {
                $teacher = Teacher::where('email', $user->email)->first();
            }
        }

        if (!$user || !$teacher) {
            return redirect('/')->with('error', __('Profil enseignant introuvable. Veuillez contacter un administrateur.'));
        }

        $courses = Course::where('teacher_id', $teacher->id)->with('students')->get();
        $students = $courses->flatMap(function ($c) {
            return $c->students;
        })->unique('id')->values();

        return view('teacher.students.index', compact('students'));
    }

    /**
     * Show a specific course to the teacher (only if they teach it).
     */
    public function showCourse($id)
    {
        $user = Auth::user();

        $teacher = null;
        if ($user) {
            try {
                $teacher = $user->teacher ?? null;
            } catch (\Throwable $e) {
                $teacher = null;
            }

            if (!$teacher) {
                $teacher = Teacher::where('email', $user->email)->first();
            }
        }

        if (!$user || !$teacher) {
            return redirect('/')->with('error', __('Profil enseignant introuvable. Veuillez contacter un administrateur.'));
        }

        $course = Course::with(['teacher', 'students', 'mention', 'mentions'])->findOrFail($id);

        // Ensure the teacher actually teaches this course
        if ($course->teacher_id !== $teacher->id) {
            abort(403, 'Accès non autorisé');
        }

        // Prefer a teacher-specific view, fallback to dean's
        if (view()->exists('teacher.courses.show')) {
            return view('teacher.courses.show', compact('course'));
        }
        return view('dean.courses.show', compact('course'));
    }

    /**
     * Export students for a course (PDF) for the teacher if they teach it.
     */
    public function exportCourseStudents($id)
    {
        $user = Auth::user();

        $teacher = null;
        if ($user) {
            try { $teacher = $user->teacher ?? null; } catch (\Throwable $e) { $teacher = null; }
            if (!$teacher) { $teacher = Teacher::where('email', $user->email)->first(); }
        }

        if (!$user || !$teacher) {
            return redirect('/')->with('error', __('Profil enseignant introuvable.'));
        }

        $course = Course::with(['teacher', 'students'])->findOrFail($id);
        if ($course->teacher_id !== $teacher->id) {
            abort(403, 'Accès non autorisé');
        }

        $filename = 'Liste des étudiants - ' . ($course->sigle ?? $course->id) . '.pdf';
        return \Pdf::loadView('dean.courses.students-pdf', compact('course'))->download($filename);
    }

    /**
     * Show teacher settings page.
     */
    public function settings()
    {
        $user = Auth::user();
        return view('teacher.settings', compact('user'));
    }

    /**
     * Update teacher settings.
     */
    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
            $data['plain_password'] = $validated['password'];
        }

        $user->update($data);

        return redirect()->route('teacher.settings')->with('success', 'Paramètres mis à jour.');
    }
}