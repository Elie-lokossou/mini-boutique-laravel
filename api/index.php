<?php

// [DIAGNOSTIC TEMPORAIRE] Rendre toute erreur visible dans la réponse,
// y compris les erreurs fatales qui échappent aux gestionnaires habituels.
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
register_shutdown_function(function () {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR], true)) {
        echo "\nERREUR FATALE : {$error['message']} dans {$error['file']} ligne {$error['line']}";
    }
});

use Illuminate\Contracts\Console\Kernel as ConsoleKernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Point d'entrée serverless (Vercel)
|--------------------------------------------------------------------------
|
| Vercel ne fait pas tourner PHP nativement : ce fichier est la fonction
| serverless (runtime communautaire vercel-php) qui reçoit toutes les
| requêtes et les transmet à Laravel, comme le ferait public/index.php
| sur un hébergement classique.
|
| Le système de fichiers d'une fonction serverless est en lecture seule,
| sauf /tmp. On y place donc tout ce que Laravel doit pouvoir écrire :
| la base SQLite, les vues Blade compilées et les dossiers de travail.
|
*/

define('LARAVEL_START', microtime(true));

// Dossiers inscriptibles dans /tmp (vues compilées, cache, sessions, logs).
foreach ([
    '/tmp/views',
    '/tmp/bootstrap-cache',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
    '/tmp/storage/app/public',
] as $directory) {
    if (! is_dir($directory)) {
        mkdir($directory, 0777, true);
    }
}

// Valeurs par défaut adaptées au serverless. Les variables d'environnement
// définies dans le projet Vercel (APP_KEY, APP_ENV...) ont toujours priorité.
$defaults = [
    'DB_CONNECTION' => 'sqlite',
    'DB_DATABASE' => '/tmp/database.sqlite',
    'SESSION_DRIVER' => 'cookie',
    'CACHE_STORE' => 'array',
    'QUEUE_CONNECTION' => 'sync',
    'LOG_CHANNEL' => 'stderr',
    'VIEW_COMPILED_PATH' => '/tmp/views',
    // Les caches internes de Laravel (configuration, routes, services,
    // paquets) s'écrivent normalement dans bootstrap/cache, en lecture
    // seule dans la fonction : on les déplace aussi dans /tmp.
    'APP_CONFIG_CACHE' => '/tmp/bootstrap-cache/config.php',
    'APP_ROUTES_CACHE' => '/tmp/bootstrap-cache/routes-v7.php',
    'APP_SERVICES_CACHE' => '/tmp/bootstrap-cache/services.php',
    'APP_PACKAGES_CACHE' => '/tmp/bootstrap-cache/packages.php',
    'APP_EVENTS_CACHE' => '/tmp/bootstrap-cache/events.php',
];

foreach ($defaults as $key => $value) {
    if (empty($_SERVER[$key]) && empty($_ENV[$key]) && getenv($key) === false) {
        $_SERVER[$key] = $_ENV[$key] = $value;
        putenv("{$key}={$value}");
    }
}

// Mode maintenance (même vérification que public/index.php).
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel...
/** @var \Illuminate\Foundation\Application $app */
$app = require __DIR__.'/../bootstrap/app.php';

// Tout ce que Laravel écrit passe par storage/ : on le déplace dans /tmp.
$app->useStoragePath('/tmp/storage');

// Démarrage à froid : la base SQLite de /tmp est éphémère. Si elle n'existe
// pas encore (ou si les tables manquent), on la crée et on la remplit avec
// les migrations et les seeders : la boutique repart avec ses 20 produits.
try {
    $databasePath = $_SERVER['DB_DATABASE'] ?? '/tmp/database.sqlite';

    if (! file_exists($databasePath)) {
        touch($databasePath);
    }

    $app->make(ConsoleKernel::class)->bootstrap();

    if (! Schema::hasTable('produits')) {
        Artisan::call('migrate:fresh', ['--seed' => true, '--force' => true]);
    }
} catch (\Throwable $e) {
    // Ne pas bloquer la requête : l'erreur éventuelle sera visible
    // dans les logs d'exécution de la fonction.
    error_log('Mini-Boutique — initialisation de la base : '.$e->getMessage());
}

// Répondre à la requête HTTP.
try {
    $app->handleRequest(Request::capture());
} catch (\Throwable $e) {
    // [DIAGNOSTIC TEMPORAIRE] Afficher l'exception qui a traversé Laravel.
    echo "\nEXCEPTION : ".get_class($e).' — '.$e->getMessage().' dans '.$e->getFile().' ligne '.$e->getLine();
    throw $e;
}
