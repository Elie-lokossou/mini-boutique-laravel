<?php
// Diagnostic temporaire v3 — ne charge PAS api/index.php.
// Reproduit ses conditions (dossiers /tmp, valeurs par défaut, base)
// puis démarre Laravel pas à pas, en affichant chaque étape.
header('Content-Type: text/plain; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', '1');

function ligne($s) { echo $s . "\n"; @flush(); }

ligne('DIAG v3 - debut');
ligne('PHP ' . PHP_VERSION);
ligne('vendor/autoload.php : ' . (file_exists(__DIR__ . '/../vendor/autoload.php') ? 'OUI' : 'NON'));
ligne('bootstrap/app.php : ' . (file_exists(__DIR__ . '/../bootstrap/app.php') ? 'OUI' : 'NON'));
ligne('APP_KEY : ' . (!empty($_SERVER['APP_KEY']) ? 'present, longueur ' . strlen($_SERVER['APP_KEY']) : 'ABSENT'));
ligne('pdo_sqlite : ' . (extension_loaded('pdo_sqlite') ? 'OUI' : 'NON'));
ligne('APP_ENV serveur : ' . ($_SERVER['APP_ENV'] ?? '(non defini)'));

// Memes preparations que api/index.php
foreach (['/tmp/views', '/tmp/storage/framework/cache/data', '/tmp/storage/framework/sessions', '/tmp/storage/framework/views', '/tmp/storage/logs', '/tmp/storage/app/public'] as $d) {
    if (! is_dir($d)) { mkdir($d, 0777, true); }
}
$_SERVER['APP_DEBUG'] = $_ENV['APP_DEBUG'] = 'true'; putenv('APP_DEBUG=true');
$defaults = [
    'DB_CONNECTION' => 'sqlite', 'DB_DATABASE' => '/tmp/database.sqlite',
    'SESSION_DRIVER' => 'cookie', 'CACHE_STORE' => 'array',
    'QUEUE_CONNECTION' => 'sync', 'LOG_CHANNEL' => 'stderr',
    'VIEW_COMPILED_PATH' => '/tmp/views',
];
foreach ($defaults as $k => $v) {
    if (empty($_SERVER[$k]) && empty($_ENV[$k]) && getenv($k) === false) {
        $_SERVER[$k] = $_ENV[$k] = $v; putenv("{$k}={$v}");
    }
}
ligne('preparations OK');

try {
    require __DIR__ . '/../vendor/autoload.php';
    ligne('autoload OK');
} catch (\Throwable $e) {
    ligne('AUTOLOAD EXCEPTION : ' . get_class($e) . ' - ' . $e->getMessage());
}

try {
    $app = require __DIR__ . '/../bootstrap/app.php';
    ligne('bootstrap OK');
} catch (\Throwable $e) {
    ligne('BOOTSTRAP EXCEPTION : ' . get_class($e) . ' - ' . $e->getMessage());
    ligne('DIAG v3 - fin (arret)');
    exit;
}

try {
    $databasePath = $_SERVER['DB_DATABASE'] ?? '/tmp/database.sqlite';
    if (! file_exists($databasePath)) { touch($databasePath); }
    $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    ligne('console kernel OK');
    if (! \Illuminate\Support\Facades\Schema::hasTable('produits')) {
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--seed' => true, '--force' => true]);
        ligne('migrations + seed OK');
    } else {
        ligne('table produits deja presente');
    }
    ligne('produits en base : ' . \Illuminate\Support\Facades\DB::table('produits')->count());
} catch (\Throwable $e) {
    ligne('BASE EXCEPTION : ' . get_class($e) . ' - ' . $e->getMessage());
}

try {
    $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
    $request = \Illuminate\Http\Request::create('/produits/3', 'GET');
    $response = $kernel->handle($request);
    ligne('requete /produits/3 -> HTTP ' . $response->getStatusCode());
    $texte = trim(preg_replace('/\s+/', ' ', strip_tags($response->getContent())));
    ligne('extrait reponse : ' . substr($texte, 0, 600));
} catch (\Throwable $e) {
    ligne('REQUETE EXCEPTION : ' . get_class($e) . ' - ' . $e->getMessage());
}

ligne('DIAG v3 - fin');
