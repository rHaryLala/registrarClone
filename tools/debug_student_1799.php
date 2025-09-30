<?php
// Debug script to reproduce DeanController::addCourseToStudent() for student id 1799
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Student;
use App\Models\Course;
use Illuminate\Support\Facades\Schema;

$studentId = 1799;
$student = Student::with('mention','yearLevel','courses')->find($studentId);
if (! $student) {
    echo json_encode(['error' => 'STUDENT_NOT_FOUND', 'student_id' => $studentId]);
    exit(0);
}

// Exclure les cours déjà pris (non retirés)
$takenCourseIds = $student->courses()->wherePivot('deleted_at', null)->pluck('courses.id')->toArray();

// Build base query for available courses in the student's mention.
$coursesQuery = Course::where(function ($q) use ($student) {
        $q->where('mention_id', $student->mention_id)
          ->orWhereHas('mentions', function ($q2) use ($student) {
              $q2->where('mentions.id', $student->mention_id);
          });
    })
    ->whereNotIn('id', $takenCourseIds);

$studentYearLevelId = $student->year_level_id;
$yearColumnExists = Schema::hasColumn('courses', 'year_level_id');

if (! empty($studentYearLevelId)) {
    // Allowed year level ids: only the student's own level. (L1R should not see L1-only courses)
    $allowedYearLevelIds = [$studentYearLevelId];

    if (count($allowedYearLevelIds) > 0) {
        if ($yearColumnExists) {
            $coursesQuery->where(function ($q) use ($allowedYearLevelIds) {
                $q->whereIn('year_level_id', $allowedYearLevelIds)
                  ->orWhereHas('yearLevels', function ($q2) use ($allowedYearLevelIds) {
                      $q2->whereIn('year_levels.id', $allowedYearLevelIds);
                  });
            });
        } else {
            $coursesQuery->whereHas('yearLevels', function ($q2) use ($allowedYearLevelIds) {
                $q2->whereIn('year_levels.id', $allowedYearLevelIds);
            });
        }
    }
}

$courses = $coursesQuery->with('teacher', 'yearLevels', 'mention', 'mentions')->get();

$results = [
    'student' => [
        'id' => $student->id,
        'matricule' => $student->matricule,
        'mention_id' => $student->mention_id,
        'mention' => $student->mention?->nom,
        'year_level_id' => $student->year_level_id,
        'year_level_label' => $student->yearLevel?->label,
    ],
    'year_column_exists' => $yearColumnExists,
    'takenCourseIds' => $takenCourseIds,
    'courses' => $courses->map(function ($c) {
        return [
            'id' => $c->id,
            'sigle' => $c->sigle,
            'nom' => $c->nom,
            'mention_id' => $c->mention_id ?? null,
            'mention' => $c->mention?->nom ?? null,
            'mentions' => $c->mentions->map(function($m){ return ['id'=>$m->id,'nom'=>$m->nom]; })->values()->all(),
            'year_level_column' => $c->year_level_id ?? null,
            'yearLevels' => $c->yearLevels->map(function($y){ return ['id'=>$y->id,'code'=>$y->code,'label'=>$y->label]; })->values()->all(),
        ];
    })->toArray(),
];

echo json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
