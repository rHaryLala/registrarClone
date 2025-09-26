<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Mention;
use Illuminate\Support\Facades\DB;

echo "Mentions:\n";
foreach (Mention::all() as $m) {
    echo $m->id . ' - ' . $m->nom . PHP_EOL;
}

echo "\nAcademicFee mention_id distribution:\n";
$rows = DB::table('academic_fees')->select('mention_id', DB::raw('count(*) as c'))->groupBy('mention_id')->get();
foreach ($rows as $r) {
    echo 'mention_id=' . $r->mention_id . ' count=' . $r->c . PHP_EOL;
}
