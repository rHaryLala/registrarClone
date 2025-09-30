<?php
namespace App\Observers;

use App\Models\Course;
use App\Services\InstallmentService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CourseObserver
{
    /**
     * Handle the Course "updated" event.
     */
    public function updated(Course $course): void
    {
        // Only trigger recompute when fields that affect fees change
        $dirty = $course->getDirty();
        $interesting = ['credits', 'labo_info', 'labo_comm', 'labo_langue', 'mention_id', 'year_level_id'];
        if (!array_intersect(array_keys($dirty), $interesting)) {
            return;
        }

        try {
            $studentIds = DB::table('course_student')
                ->where('course_id', $course->id)
                ->whereNull('deleted_at')
                ->pluck('student_id')
                ->unique()
                ->toArray();

            foreach ($studentIds as $studentId) {
                try {
                    $student = \App\Models\Student::find($studentId);
                    if (!$student) continue;
                    if ($student->academic_year_id && $student->semester_id) {
                        // compute and persist fees; run synchronously for now
                        (new InstallmentService())->computeSemesterFees($student->fresh(), $student->academic_year_id, $student->semester_id, null);
                    }
                } catch (\Throwable $e) {
                    Log::warning('CourseObserver: failed to recompute fees for student ' . ($studentId ?? 'unknown') . ' after course update: ' . $e->getMessage());
                }
            }
        } catch (\Throwable $e) {
            Log::warning('CourseObserver: error while finding students for course ' . $course->id . ': ' . $e->getMessage());
        }
    }

    /**
     * Handle the Course "deleted" event.
     */
    public function deleted(Course $course): void
    {
        try {
            $studentIds = DB::table('course_student')
                ->where('course_id', $course->id)
                ->whereNull('deleted_at')
                ->pluck('student_id')
                ->unique()
                ->toArray();

            foreach ($studentIds as $studentId) {
                try {
                    $student = \App\Models\Student::find($studentId);
                    if (!$student) continue;
                    if ($student->academic_year_id && $student->semester_id) {
                        (new InstallmentService())->computeSemesterFees($student->fresh(), $student->academic_year_id, $student->semester_id, null);
                    }
                } catch (\Throwable $e) {
                    Log::warning('CourseObserver: failed to recompute fees for student ' . ($studentId ?? 'unknown') . ' after course delete: ' . $e->getMessage());
                }
            }
        } catch (\Throwable $e) {
            Log::warning('CourseObserver: error while finding students for deleted course ' . $course->id . ': ' . $e->getMessage());
        }
    }

    /**
     * Handle the Course "restored" event.
     */
    public function restored(Course $course): void
    {
        // When a course is restored, recompute fees for enrolled students (if any)
        try {
            $studentIds = DB::table('course_student')
                ->where('course_id', $course->id)
                ->whereNull('deleted_at')
                ->pluck('student_id')
                ->unique()
                ->toArray();

            foreach ($studentIds as $studentId) {
                try {
                    $student = \App\Models\Student::find($studentId);
                    if (!$student) continue;
                    if ($student->academic_year_id && $student->semester_id) {
                        (new InstallmentService())->computeSemesterFees($student->fresh(), $student->academic_year_id, $student->semester_id, null);
                    }
                } catch (\Throwable $e) {
                    Log::warning('CourseObserver: failed to recompute fees for student ' . ($studentId ?? 'unknown') . ' after course restore: ' . $e->getMessage());
                }
            }
        } catch (\Throwable $e) {
            Log::warning('CourseObserver: error while finding students for restored course ' . $course->id . ': ' . $e->getMessage());
        }
    }
}
