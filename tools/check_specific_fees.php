<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\AcademicFee;
use App\Models\FeeType;

function printFee($feeTypeName, $mentionId, $yearLevelId) {
    $ft = FeeType::where('name', $feeTypeName)->first();
    if (!$ft) { echo "FeeType $feeTypeName not found\n"; return; }
    $f = AcademicFee::where('fee_type_id', $ft->id)
        ->where('mention_id', $mentionId)
        ->where('year_level_id', $yearLevelId)
        ->first();
    if (!$f) { echo "No AcademicFee for $feeTypeName mention=$mentionId year_level=$yearLevelId\n"; }
    else { echo "$feeTypeName mention=$mentionId year_level=$yearLevelId => amount={$f->amount}\n"; }
}

// checks requested by user
printFee('Frais Généraux', 4, 2);
printFee('Frais Généraux', 4, 3);
printFee('Écolage', 1, 1);
printFee('Écolage', 1, 2);
printFee('Écolage', 1, 3);
printFee('Écolage', 1, 4);
printFee('Écolage', 1, 5);
