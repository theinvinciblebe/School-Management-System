<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Role names to integer mapping:
     * 0: Admin
     * 1: Teacher
     * 2: Student
     * 3: Accountant
     * 4: Receptionist
     */
    protected array $roleMap = [
        'admin'        => 0,
        'teacher'      => 1,
        'student'      => 2,
        'accountant'   => 3,
        'reception'    => 4,
        'receptionist' => 4,
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  mixed  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Ensure user is logged in
        if (!Auth::check()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login');
        }

        // 2. If no role parameter provided, allow any authenticated user
        if (empty($roles)) {
            return $next($request);
        }

        // 3. Normalize roles (supports 'role:0,1', 'role:admin,teacher', or variadic args)
        $allowedRoles = [];
        foreach ($roles as $roleArg) {
            foreach (explode(',', (string) $roleArg) as $r) {
                $r = trim(strtolower($r));
                if (is_numeric($r)) {
                    $allowedRoles[] = (int) $r;
                } elseif (isset($this->roleMap[$r])) {
                    $allowedRoles[] = $this->roleMap[$r];
                }
            }
        }

        $userRole = (int) Auth::user()->role;

        // 4. Grant access if user role matches allowed roles
        if (in_array($userRole, $allowedRoles, true)) {
            return $next($request);
        }

        // 5. User does not have access: return 403 without logging out
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'error' => 'Forbidden',
                'message' => 'Unauthorized action. You do not have permission to access this resource.'
            ], 403);
        }

        abort(403, 'Unauthorized action. You do not have permission to access this page.');
    }
}
