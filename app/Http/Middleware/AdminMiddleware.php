<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->role == 0) {
            return $next($request); // Admin
        }

        // Optional: logout + redirect, or just abort(403)
        Auth::logout();
        return redirect()->route('login')->with('status', 'Access denied.');

        //return redirect()->back()->with('error', 'Access denied.');
    }
}
