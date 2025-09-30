<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use App\Http\Controllers\SuperAdminController;

$controller = new SuperAdminController();

// Build a fake request payload matching the form
$payload = [
    'sigle' => 'AUTOTEST-' . rand(1000,9999),
    'nom' => 'Test création cours',
    'credits' => 2,
    'teacher_id' => null,
    'mention_ids' => [1],
    'year_level_ids' => [1],
    'categorie' => 'général',
];

$request = Request::create('/fake', 'POST', $payload);

try {
    $response = $controller->storeCourse($request);
    echo "Controller returned: ";
    if ($response instanceof \Illuminate\Http\RedirectResponse) {
        echo "Redirect to " . $response->getTargetUrl() . "\n";
    } else {
        echo "Response class: " . get_class($response) . "\n";
    }
} catch (\Illuminate\Validation\ValidationException $e) {
    echo "Validation failed:\n";
    foreach ($e->errors() as $k => $errs) {
        foreach ($errs as $err) {
            echo " - $k: $err\n";
        }
    }
} catch (\Throwable $t) {
    echo "Exception: " . $t->getMessage() . "\n";
    echo $t->getTraceAsString();
}
