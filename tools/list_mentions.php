<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$mentions = \App\Models\Mention::all();
echo "Mentions count: " . $mentions->count() . "\n";
foreach ($mentions as $m) {
    echo "id={$m->id}, nom={$m->nom}\n";
}
