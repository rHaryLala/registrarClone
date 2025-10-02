<?php
// boots a minimal Laravel application to use the DB facade
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use Illuminate\Support\Facades\DB;
echo 'COUNT: ' . DB::table('courses')->count() . "\n";
