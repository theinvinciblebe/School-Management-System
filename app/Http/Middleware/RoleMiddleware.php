<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (Auth::check() && Auth::user()->role == $role) {
            return $next($request);
        }

        Auth::logout();
        return redirect()->route('login')->with('status', 'Access denied.');
    }

//    public function handle(Request $request, Closure $next, $requiredRole)
//    {
//        // Ensure the user is authenticated
//        if (!auth()->check()) {
//            return redirect('/login');
//        }
//
//        // Convert string role to integer if needed
//        $roleMap = [
//            'admin' => 0,
//            'teacher' => 1,
//            'student' => 2,
//            'accountant' => 3,
//            'reception' => 4,
//        ];
//
//        // Get the actual role value from user
//        $userRole = Auth::user()->role;
//
//        // Match role using the map
//        if (isset($roleMap[$requiredRole]) && $userRole == $roleMap[$requiredRole]) {
//            return $next($request);
//        }
//
//        // Optional: redirect or abort
//        abort(403, 'Unauthorized action.');
//    }


//    public function handle(Request $request, Closure $next): Response
//    {
//        return $next($request);
//    }
}
