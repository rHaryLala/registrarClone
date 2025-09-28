<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Models\Semester;
use App\Models\Mention;

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$semesters = Semester::orderBy('mention_id')->orderBy('ordre')->get();
if ($semesters->isEmpty()) {
    echo "No semesters found\n";
    exit(0);
}

foreach ($semesters as $s) {
    $m = null;
    if ($s->mention_id) {
        $m = Mention::find($s->mention_id);
    }
    echo "id={$s->id} mention_id=" . ($s->mention_id ?? 'NULL') . " mention_name=" . ($m->nom ?? 'NULL') . " ordre={$s->ordre} duration=" . ($s->duration ?? 'NULL') . " date_debut={$s->date_debut} date_fin={$s->date_fin}\n";
}

echo "Done.\n";
