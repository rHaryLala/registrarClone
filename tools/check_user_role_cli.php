<?php
// Quick CLI helper to print a user's role (by email) without using PsySH/tinker quoting issues.
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$email = $argv[1] ?? 'tahinahosearak@zurcher.edu.mg';
$user = User::where('email', $email)->first();
if ($user) {
    echo $user->role . PHP_EOL;
} else {
    echo 'NO_USER' . PHP_EOL;
}
