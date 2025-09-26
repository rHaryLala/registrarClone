<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Semester;

foreach (Semester::all() as $s) {
    echo sprintf("%d %s start=%s end=%s duration=%s\n", $s->id, $s->nom, $s->date_debut, $s->date_fin, $s->duration);
}
