<?php
// Diagnostic temporaire — à retirer dès le problème résolu.
header('Content-Type: text/plain; charset=utf-8');
$_SERVER['APP_DEBUG'] = 'true';
$_ENV['APP_DEBUG'] = 'true';
putenv('APP_DEBUG=true');
echo "APP_KEY present: " . (!empty($_SERVER['APP_KEY']) ? 'yes, longueur ' . strlen($_SERVER['APP_KEY']) : 'NON') . "\n";
echo "APP_ENV: " . ($_SERVER['APP_ENV'] ?? '(non defini)') . "\n";
echo "--- Demarrage via api/index.php ---\n";
require __DIR__ . '/index.php';
