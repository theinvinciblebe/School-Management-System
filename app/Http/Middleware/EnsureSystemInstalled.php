<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSystemInstalled
{
    /**
     * Handle an incoming request.
     * Automatically redirects to the Installation Wizard on a fresh start
     * if the system has not been installed yet.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isInstalled = file_exists(storage_path('installed'))
            || file_exists(base_path('storage/installed'))
            || file_exists('/tmp/storage/installed')
            || file_exists('/tmp/installed')
            || env('APP_INSTALLED') === true
            || env('APP_INSTALLED') === 'true';

        // In serverless environments (Vercel / Lambda) where database is already configured in production,
        // treat as installed so public visitors are not redirected to the wizard unexpectedly
        $isServerless = !empty(getenv('VERCEL')) || !empty($_ENV['VERCEL']) || !empty($_SERVER['VERCEL']) || !empty(getenv('AWS_LAMBDA_FUNCTION_NAME'));
        if ($isServerless && !$isInstalled) {
            $hasDb = !empty(getenv('DB_CONNECTION')) || !empty($_ENV['DB_CONNECTION']) || !empty($_SERVER['DB_CONNECTION']) || !empty(config('database.default'));
            if ($hasDb && config('app.env') === 'production') {
                $isInstalled = true;
            }
        }

        // If not installed yet, redirect everything to /install (except installer endpoints and static assets)
        if (!$isInstalled) {
            $allowedPatterns = [
                'install*',
                'installer*',
                'setup*',
                'lang/*',
                'assets/*',
                'build/*',
                'customize_images/*',
                'favicon.ico',
            ];

            foreach ($allowedPatterns as $pattern) {
                if ($request->is($pattern)) {
                    return $next($request);
                }
            }

            return redirect()->route('install.index');
        }

        return $next($request);
    }
}

