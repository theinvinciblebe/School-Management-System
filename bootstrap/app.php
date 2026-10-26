<?php

use App\Http\Middleware\LogUserActivity;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;


// Suppress PHP 8.5 deprecation notices from polluting HTTP response
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

return Application::configure(basePath: dirname(__DIR__))

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

