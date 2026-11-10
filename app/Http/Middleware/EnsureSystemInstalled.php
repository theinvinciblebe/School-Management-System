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
        $isInstalled = file_exists(storage_path('installed'));

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

