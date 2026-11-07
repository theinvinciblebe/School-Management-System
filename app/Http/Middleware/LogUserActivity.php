<?php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only log for authenticated users
        if (!Auth::check()) {
            return $response;
        }

        try {
            $this->logActivity($request, $response);
        } catch (\Throwable $e) {
            // Never break application flow if logging fails
            Log::warning('Activity log capture skipped: ' . $e->getMessage());
        }

        return $response;
    }

    /**
     * Process and record the activity log
     */
    protected function logActivity(Request $request, Response $response): void
    {
        $path = $request->path();
        $method = strtoupper($request->method());
        $user = Auth::user();

        // 1. Skip static assets, health checks, background polling, and debug endpoints
        if ($this->shouldIgnore($request, $path)) {
            return;
        }

        // 2. Throttle GET page requests to avoid logging every fast refresh/re-click within 20s
        if ($method === 'GET') {
            $cacheKey = "user_activity_throttle_{$user->id}_" . md5($path);
            if (Cache::has($cacheKey)) {
                return;
            }
            Cache::put($cacheKey, true, 20); // 20 seconds cooldown for same page GET
        }

        // 3. Resolve human-readable action and description
        [$action, $description] = $this->determineAction($request, $path, $method, $response->getStatusCode());

        $ipAddress = $request->ip() ?: '127.0.0.1';
        $userAgent = $request->userAgent();

        ActivityLog::create([
            'user_id' => $user->id,
            'action' => $action,
            'description' => $description,
            'method' => $method,
            'url' => '/' . ltrim($path, '/'),
            'ip_address' => $ipAddress,
            'geo_location' => ActivityLog::resolveGeoLocation($ipAddress),
            'user_agent' => $userAgent ? substr($userAgent, 0, 500) : null,
            'device' => ActivityLog::parseDevice($userAgent),
            'status_code' => $response->getStatusCode(),
            'timestamp' => now(),
        ]);
    }

    /**
     * Check if request should be ignored from activity logging
     */
    protected function shouldIgnore(Request $request, string $path): bool
    {
        // Ignore static asset extensions
        if (preg_match('/\.(css|js|map|png|jpg|jpeg|gif|svg|ico|woff|woff2|ttf|eot)$/i', $path)) {
            return true;
        }

        // Ignore common background routes & telemetry
        $ignoredPatterns = [
            'up',
            'livewire/*',
            '_ignition/*',
            'telescope/*',
            'horizon/*',
            'sanctum/*',
            'api/notifications/count',
            'api/ping',
            'api/heartbeat',
        ];

        foreach ($ignoredPatterns as $pattern) {
            if ($request->is($pattern)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine human-friendly action and description from route, path and method
     */
    protected function determineAction(Request $request, string $path, string $method, int $statusCode): array
    {
        $pathLower = strtolower($path);
        $routeName = $request->route() ? $request->route()->getName() : '';

        // Authentication
        if (str_contains($pathLower, 'login') || $routeName === 'login' || $routeName === 'do_login') {
            return ['User Authentication', 'Logged into user session'];
        }
        if (str_contains($pathLower, 'logout') || $routeName === 'logout') {
            return ['User Logout', 'Ended user session'];
        }

        // Accounting - Fee Receipts & Billing
        if (str_contains($pathLower, 'fee-receipt') || str_contains($pathLower, 'fee_receipt')) {
            if ($method === 'POST') {
                return ['Created Fee Receipt', 'Generated student fee billing record'];
            }
            if ($method === 'DELETE') {
                return ['Deleted Fee Receipt', 'Removed student fee billing record'];
            }
            if (str_contains($pathLower, 'pdf')) {
                return ['Exported Fee PDF', 'Downloaded/Printed official fee receipt voucher'];
            }
            if (str_contains($pathLower, 'show') || preg_match('/\/\d+$/', $path)) {
                return ['Viewed Fee Voucher', 'Inspected fee billing details'];
            }
            return ['Accessed Fee Billing', 'Viewed Fee Receipts & Billing list'];
        }

        // Accounting - Purchase Requests
        if (str_contains($pathLower, 'purchase-req') || str_contains($pathLower, 'purchase_req')) {
            if ($method === 'POST') {
                return ['Created Purchase Request', 'Submitted requisition voucher for approval'];
            }
            if ($method === 'DELETE') {
                return ['Deleted Purchase Request', 'Removed purchase requisition record'];
            }
            if (str_contains($pathLower, 'pdf') || str_contains($pathLower, 'print')) {
                return ['Printed Purchase Voucher', 'Downloaded/Printed purchase request voucher'];
            }
            if (str_contains($pathLower, 'show') || preg_match('/\/\d+$/', $path)) {
                return ['Viewed Purchase Voucher', 'Inspected purchase request details'];
            }
            return ['Accessed Purchase Requests', 'Viewed Purchase Requests list'];
        }

        // Accounting - Profits & Expenses
        if (str_contains($pathLower, 'profit') || str_contains($pathLower, 'transaction')) {
            if ($method === 'POST') {
                return ['Recorded Transaction', 'Added new financial revenue/expense entry'];
            }
            if ($method === 'DELETE') {
                return ['Deleted Transaction', 'Removed financial ledger entry'];
            }
            return ['Accessed Financial Reports', 'Inspected Profits & Expenses ledger and statements'];
        }

        // Activity Logs
        if (str_contains($pathLower, 'activity-log')) {
            if (str_contains($pathLower, 'clear') || $method === 'POST') {
                return ['Cleared Activity Logs', 'Purged audit trail history'];
            }
            if (str_contains($pathLower, 'export')) {
                return ['Exported Activity Logs', 'Downloaded audit trail CSV dataset'];
            }
            return ['Audited Activity Logs', 'Inspected system security audit logs'];
        }

        // User Management
        if (str_contains($pathLower, 'user-management') || str_contains($pathLower, 'user')) {
            if ($method === 'POST') {
                return ['Created User', 'Created new system user account'];
            }
            if (in_array($method, ['PUT', 'PATCH'])) {
                return ['Updated User', 'Modified user account information or permissions'];
            }
            if ($method === 'DELETE') {
                return ['Deleted User', 'Removed user account from system'];
            }
            return ['Managed Users', 'Viewed User Management directory'];
        }

        // Customization & System Settings
        if (str_contains($pathLower, 'customize')) {
            if ($method === 'POST' || in_array($method, ['PUT', 'PATCH'])) {
                return ['Updated School Settings', 'Modified school profile, logo, or theme branding'];
            }
            return ['Viewed School Customization', 'Opened school customization panel'];
        }

        // Students
        if (str_contains($pathLower, 'student')) {
            if ($method === 'POST') {
                return ['Created Student', 'Registered new student record'];
            }
            if (in_array($method, ['PUT', 'PATCH'])) {
                return ['Updated Student', 'Modified student academic/profile record'];
            }
            if ($method === 'DELETE') {
                return ['Deleted Student', 'Removed student record'];
            }
            return ['Viewed Students', 'Accessed student directory / details'];
        }

        // Teachers
        if (str_contains($pathLower, 'teacher')) {
            if ($method === 'POST') {
                return ['Created Teacher', 'Added new faculty/teacher profile'];
            }
            if (in_array($method, ['PUT', 'PATCH'])) {
                return ['Updated Teacher', 'Modified teacher information'];
            }
            if ($method === 'DELETE') {
                return ['Deleted Teacher', 'Removed teacher profile'];
            }
            return ['Viewed Teachers', 'Accessed faculty / teacher directory'];
        }

        // Classes / Classrooms
        if (str_contains($pathLower, 'class')) {
            if ($method === 'POST' || in_array($method, ['PUT', 'PATCH'])) {
                return ['Updated Classroom', 'Configured grade / class section details'];
            }
            return ['Viewed Classrooms', 'Opened classrooms management'];
        }

        // Examinations & Marks
        if (str_contains($pathLower, 'exam') || str_contains($pathLower, 'mark') || str_contains($pathLower, 'grade')) {
            if ($method === 'POST' || in_array($method, ['PUT', 'PATCH'])) {
                return ['Recorded Exam Grades', 'Saved student examination scores & grading'];
            }
            return ['Accessed Examination Hub', 'Viewed exam records and scores'];
        }

        // Attendance
        if (str_contains($pathLower, 'attendance')) {
            if ($method === 'POST') {
                return ['Recorded Attendance', 'Submitted daily attendance roll'];
            }
            return ['Viewed Attendance', 'Inspected attendance records'];
        }

        // Dashboard
        if (str_contains($pathLower, 'dashboard') || $pathLower === '' || $pathLower === '/') {
            return ['Accessed Dashboard', 'Navigated to primary executive overview'];
        }

        // Fallback based on HTTP Method
        $friendlyPath = ucwords(str_replace(['-', '_', '/'], ' ', trim($path, '/')));
        return match ($method) {
            'POST' => ['Created Record', "Submitted {$friendlyPath} form"],
            'PUT', 'PATCH' => ['Updated Record', "Modified {$friendlyPath} data"],
            'DELETE' => ['Deleted Record', "Deleted {$friendlyPath} record"],
            default => ["Navigated: {$friendlyPath}", "Viewed page at /" . ltrim($path, '/')]
        };
    }
}
