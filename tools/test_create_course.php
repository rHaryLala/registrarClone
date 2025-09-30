<?php
// Quick test: create a temporary course and attach multiple mentions & yearLevels
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Course;
use App\Models\YearLevel;
use App\Models\Mention;

$mentions = Mention::limit(3)->pluck('id')->toArray();
$years = YearLevel::limit(2)->pluck('id')->toArray();

$course = Course::create([
    'sigle' => 'TEST-' . uniqid(),
    'nom' => 'Cours test multi-mention',
    'credits' => 1,
    'teacher_id' => null,
    'categorie' => 'général'
]);

if ($course) {
    $course->mentions()->sync($mentions);
    $course->yearLevels()->sync($years);
    echo "Created course id={$course->id} with mentions=" . implode(',', $mentions) . " and years=" . implode(',', $years) . "\n";
} else {
    echo "Failed to create course\n";
}
