<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Http\Controllers\ChiefAccountantController;

// Find or create a test user with role 'chief_accountant'
$user = User::where('email', 'chief.accountant@example.test')->first();
if (! $user) {
    $user = User::create([
        'name' => 'Chief Accountant Test',
        'email' => 'chief.accountant@example.test',
        'password' => bcrypt('secret123'),
        'role' => 'accountant', // app's enum doesn't include chief_accountant; use accountant for middleware passthrough
    ]);
}

// Authenticate as that user
auth()->login($user);

$controller = new ChiefAccountantController();
$response = $controller->dashboard();

// Rendered view content (if it's a View instance)
if ($response instanceof \Illuminate\View\View) {
    echo "View name: " . $response->name() . "\n";
    echo "Rendered (first 200 chars):\n" . substr($response->render(), 0, 200) . "\n";
} else {
    echo "Controller returned " . get_class($response) . "\n";
}
