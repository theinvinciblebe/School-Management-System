<?php

use App\Http\Middleware\LogUserActivity;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\SetLocale;
use App\Http\Middleware\EnsureSystemInstalled;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;


// Suppress PHP 8.5 deprecation notices from polluting HTTP response
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

$app = Application::configure(basePath: dirname(__DIR__))

    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware) {
        $middleware->trustProxies(at: '*');
        $middleware->encryptCookies(except: [
            'theme',
            'locale',
        ]);
        $middleware->web(append: [
            EnsureSystemInstalled::class,
            SetLocale::class,
        ]);
        $middleware->alias([
            'role'=> RoleMiddleware::class,
            'log.activity' => LogUserActivity::class, // Define the alias as a key-value pair inside an array
            //'admin'=> \App\Http\Middleware\AdminMiddleware::class,

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

// On Vercel / serverless environment, set storage path to /tmp/storage
$isServerless = !empty(getenv('VERCEL')) || !empty($_ENV['VERCEL']) || !empty($_SERVER['VERCEL']) || !empty(getenv('AWS_LAMBDA_FUNCTION_NAME'));
if ($isServerless && PHP_OS_FAMILY !== 'Windows') {
    $tmpStorage = '/tmp/storage';
    if (!is_dir($tmpStorage)) {
        @mkdir($tmpStorage, 0755, true);
        @mkdir($tmpStorage . '/framework/views', 0755, true);
        @mkdir($tmpStorage . '/framework/sessions', 0755, true);
        @mkdir($tmpStorage . '/framework/cache', 0755, true);
        @mkdir($tmpStorage . '/logs', 0755, true);
        @mkdir($tmpStorage . '/bootstrap/cache', 0755, true);
    }
    $app->useStoragePath($tmpStorage);
}

return $app;

