<?php

/**
 * Serverless Front Controller for Vercel
 */

// 1. Prepare writable directories for storage, caches, and compiled views
// On Vercel (Linux), /tmp is the only writable filesystem. Locally on Windows, use project storage.
$isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
$tmpStorage = $isWindows ? dirname(__DIR__) . '/storage' : '/tmp/storage';
$cacheBase = $isWindows ? 'cache' : $tmpStorage . '/bootstrap/cache';

$requiredDirs = [
    $isWindows ? dirname(__DIR__) . '/bootstrap/cache' : $tmpStorage . '/bootstrap/cache',
    $tmpStorage . '/framework/views',
    $tmpStorage . '/framework/sessions',
    $tmpStorage . '/framework/cache',
    $tmpStorage . '/logs',
];

foreach ($requiredDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// 2. Set environment variables for cache and storage paths on serverless (Linux/Vercel)
if (!$isWindows) {
    $envOverrides = [
        'APP_CONFIG_CACHE'    => $tmpStorage . '/bootstrap/cache/config.php',
        'APP_EVENTS_CACHE'    => $tmpStorage . '/bootstrap/cache/events.php',
        'APP_PACKAGES_CACHE'  => $tmpStorage . '/bootstrap/cache/packages.php',
        'APP_ROUTES_CACHE'    => $tmpStorage . '/bootstrap/cache/routes.php',
        'APP_SERVICES_CACHE'  => $tmpStorage . '/bootstrap/cache/services.php',
        'VIEW_COMPILED_PATH'  => $tmpStorage . '/framework/views',
        'CACHE_STORE'         => 'array',
        'CACHE_DRIVER'        => 'array',
        'LOG_CHANNEL'         => 'stderr',
        'SESSION_DRIVER'      => 'cookie',
    ];

    foreach ($envOverrides as $key => $value) {
        if (empty(getenv($key)) && empty($_ENV[$key])) {
            putenv("{$key}={$value}");
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }
    }
}

// 3. Fallback APP_KEY if not configured in Vercel Dashboard
$currentKey = getenv('APP_KEY') ?: ($_ENV['APP_KEY'] ?? ($_SERVER['APP_KEY'] ?? null));
if (empty($currentKey)) {
    $fallbackKey = 'base64:sEMiMy2kiu9CAZ/+n3FNno6Hdq66cdT9jqSkxxHaHF8=';
    putenv("APP_KEY={$fallbackKey}");
    $_ENV['APP_KEY'] = $fallbackKey;
    $_SERVER['APP_KEY'] = $fallbackKey;
}

// 4. Catch fatal errors and display diagnostic info instead of opaque FUNCTION_INVOCATION_FAILED
register_shutdown_function(function () {
    $error = error_get_last();
    if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        if (!headers_sent()) {
            http_response_code(500);
            header('Content-Type: text/html; charset=utf-8');
        }
        echo "<html><body style='font-family:sans-serif;padding:30px;line-height:1.6;background:#fef2f2;color:#991b1b;'>";
        echo "<h2>Vercel Serverless Function Crash (Fatal PHP Error)</h2>";
        echo "<p><strong>Message:</strong> " . htmlspecialchars($error['message']) . "</p>";
        echo "<p><strong>File:</strong> " . htmlspecialchars($error['file']) . " (line " . $error['line'] . ")</p>";
        echo "<p><small>Tip: Check your Vercel Project Settings > Environment Variables.</small></p>";
        echo "</body></html>";
    }
});

// 5. Execute Laravel application
try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    if (!headers_sent()) {
        http_response_code(500);
        header('Content-Type: text/html; charset=utf-8');
    }
    echo "<html><body style='font-family:sans-serif;padding:30px;line-height:1.6;background:#fef2f2;color:#991b1b;'>";
    echo "<h2>Laravel Application Error (" . htmlspecialchars(get_class($e)) . ")</h2>";
    echo "<p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . " (line " . $e->getLine() . ")</p>";
    echo "<pre style='background:#fff;padding:15px;border-radius:6px;overflow:auto;'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    echo "</body></html>";
}
