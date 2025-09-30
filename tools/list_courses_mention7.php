<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Course;

$mentionId = 7;
$courses = Course::where('mention_id', $mentionId)
    ->orWhereHas('mentions', function($q) use ($mentionId) { $q->where('mentions.id', $mentionId); })
    ->with('yearLevels', 'mentions')
    ->orderBy('sigle')
    ->get();

$out = $courses->map(function($c){
    $mentions = array_map(function($m){ return ['id'=>$m['id'],'nom'=>$m['nom']]; }, $c->mentions->toArray());
    $yearLevels = array_map(function($y){ return ['id'=>$y['id'],'code'=>$y['code'],'label'=>$y['label']]; }, $c->yearLevels->toArray());
    return [
        'id'=>$c->id,
        'sigle'=>$c->sigle,
        'nom'=>$c->nom,
        'mention_id'=>$c->mention_id,
        'mentions'=>$mentions,
        'yearLevels'=>$yearLevels,
    ];
})->toArray();

echo json_encode(['count'=>count($out),'courses'=>$out], JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
