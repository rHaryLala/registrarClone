<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\YearLevel;

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
        $students = Student::where('mention_id', $mention->id)->latest()->get();
        $totalStudents = $students->count();

        return view('dean.dashboard', compact('mention', 'students', 'totalStudents'));
    }

    public function students()
    {
        $mention = auth()->user()->mention;
        $students = Student::where('mention_id', $mention->id)->get();
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
                          ->orderBy('nom')
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
        $courses = Course::where('mention_id', $student->mention_id)
            ->whereNotIn('id', $takenCourseIds)
            ->get();
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
        return redirect()->route('dean.students.courses.history', $student->id)->with('success', 'Cours ajoutés à l\'étudiant.');
    }

    public function coursesList()
    {
        $mention = auth()->user()->mention;

        if (!$mention) {
            abort(403, 'Unauthorized - No mention assigned');
        }

        $courses = Course::with('teacher', 'yearLevel')
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
}
