<?php
$path = __DIR__ . '/../database/imports/courses.sql';
if (!file_exists($path)) {
    echo "MISSING\n";
    exit(0);
}
$content = file_get_contents($path);
echo "FILE: $path\n";
echo "LENGTH: " . strlen($content) . "\n";
$pattern = '/INSERT\\s+INTO\\s+`?courses`?\\s+.*?;/is';
if (preg_match_all($pattern, $content, $matches)) {
    echo "MATCHES: " . count($matches[0]) . "\n";
    echo "FIRST_SAMPLE: " . substr($matches[0][0], 0, 300) . "\n";
} else {
    echo "MATCHES: 0\n";
}
