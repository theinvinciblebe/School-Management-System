<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of activity logs with filtering, metrics, and pagination.
     */
    public function index(Request $request)
    {
        if (Auth::user()->role !== 0) {
            abort(403, 'Unauthorized access to audit logs.');
        }

        $query = $this->buildFilterQuery($request);

        $perPage = (int) $request->input('per_page', 25);
        if (!in_array($perPage, [15, 25, 50, 100])) {
            $perPage = 25;
        }

        $logs = $query->paginate($perPage)->withQueryString();

        // Metrics for top KPI counters
        $today = Carbon::today();
        $metrics = [
            'total_all' => ActivityLog::count(),
            'today_total' => ActivityLog::whereDate('timestamp', $today)->count(),
            'active_users_today' => ActivityLog::whereDate('timestamp', $today)->distinct('user_id')->count('user_id'),
            'mutations_today' => ActivityLog::whereDate('timestamp', $today)
                ->whereIn('method', ['POST', 'PUT', 'PATCH', 'DELETE'])
                ->count(),
        ];

        // Unique users for filter dropdown
        $users = User::select('id', 'name', 'email', 'role')->orderBy('name')->get();

        return view('activity_logs.index', compact('logs', 'users', 'metrics'));
    }

    /**
     * Stream filtered activity logs as a downloadable CSV audit file.
     */
    public function export(Request $request): StreamedResponse
    {
        if (Auth::user()->role !== 0) {
            abort(403, 'Unauthorized.');
        }

        $query = $this->buildFilterQuery($request);
        $fileName = 'Activity_Logs_Audit_Trail_' . now()->format('Y-m-d_His') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');

            // UTF-8 BOM for Excel compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            // CSV Header
            fputcsv($handle, [
                'Log ID',
                'Timestamp',
                'User Name',
                'User Email',
                'User Role',
                'Action',
                'Description',
                'Method',
                'URL / Route',
                'Status Code',
                'IP Address',
                'Geo Location',
                'Device / OS',
                'User Agent',
            ]);

            // Stream chunked records to keep memory footprint minimal
            $query->chunk(500, function ($logs) use ($handle) {
                foreach ($logs as $log) {
                    $user = $log->user;
                    fputcsv($handle, [
                        $log->id,
                        $log->timestamp ? $log->timestamp->format('Y-m-d H:i:s') : '',
                        $user ? $user->name : 'Unknown User',
                        $user ? $user->email : 'N/A',
                        $log->role_name,
                        $log->action ?? 'General Activity',
                        $log->description ?? '',
                        $log->method ?? 'GET',
                        $log->url ?? '',
                        $log->status_code ?? 200,
                        $log->ip_address,
                        $log->geo_location ?? 'Unknown',
                        $log->device ?? 'Desktop',
                        $log->user_agent ?? '',
                    ]);
                }
            });

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Cache-Control' => 'no-store, no-cache',
        ]);
    }

    /**
     * Clear / purge old activity logs.
     */
    public function clear(Request $request)
    {
        if (Auth::user()->role !== 0) {
            abort(403, 'Unauthorized.');
        }

        $scope = $request->input('scope', 'older_30');
        $deleted = 0;

        if ($scope === 'older_30') {
            $deleted = ActivityLog::where('timestamp', '<', now()->subDays(30))->delete();
            $scopeText = 'older than 30 days';
        } elseif ($scope === 'older_7') {
            $deleted = ActivityLog::where('timestamp', '<', now()->subDays(7))->delete();
            $scopeText = 'older than 7 days';
        } elseif ($scope === 'older_today') {
            $deleted = ActivityLog::where('timestamp', '<', Carbon::today())->delete();
            $scopeText = 'prior to today';
        } elseif ($scope === 'all') {
            $deleted = ActivityLog::count();
            ActivityLog::truncate();
            $scopeText = 'all records';
        } else {
            return redirect()->back()->with('error', 'Invalid purge scope selected.');
        }

        // Record the admin purge action
        ActivityLog::record(
            'Purged Activity Logs',
            "Administrator purged {$deleted} activity log records ({$scopeText})",
            $request,
            Auth::user()
        );

        return redirect()->route('activity.logs')->with('success', "Successfully purged {$deleted} activity logs ({$scopeText})!");
    }

    /**
     * Build the filtered query based on incoming request parameters
     */
    protected function buildFilterQuery(Request $request)
    {
        $query = ActivityLog::with('user')->orderBy('timestamp', 'desc')->orderBy('id', 'desc');

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by HTTP method
        if ($request->filled('method')) {
            $method = strtoupper($request->method);
            if ($method === 'MUTATION') {
                $query->whereIn('method', ['POST', 'PUT', 'PATCH', 'DELETE']);
            } elseif (in_array($method, ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'])) {
                $query->where('method', $method);
            }
        }

        // Filter by search keyword
        if ($request->filled('search')) {
            $term = trim($request->search);
            $query->where(function ($q) use ($term) {
                $q->where('action', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%")
                  ->orWhere('url', 'like', "%{$term}%")
                  ->orWhere('ip_address', 'like', "%{$term}%")
                  ->orWhere('device', 'like', "%{$term}%")
                  ->orWhere('geo_location', 'like', "%{$term}%")
                  ->orWhereHas('user', function ($uq) use ($term) {
                      $uq->where('name', 'like', "%{$term}%")
                         ->orWhere('email', 'like', "%{$term}%");
                  });
            });
        }

        // Filter by date range preset or custom
        if ($request->filled('date_filter')) {
            $dateFilter = $request->date_filter;
            if ($dateFilter === 'today') {
                $query->whereDate('timestamp', Carbon::today());
            } elseif ($dateFilter === 'yesterday') {
                $query->whereDate('timestamp', Carbon::yesterday());
            } elseif ($dateFilter === 'week') {
                $query->where('timestamp', '>=', now()->subDays(7));
            } elseif ($dateFilter === 'month') {
                $query->where('timestamp', '>=', now()->subDays(30));
            } elseif ($dateFilter === 'custom') {
                if ($request->filled('start_date')) {
                    $query->whereDate('timestamp', '>=', $request->start_date);
                }
                if ($request->filled('end_date')) {
                    $query->whereDate('timestamp', '<=', $request->end_date);
                }
            }
        }

        return $query;
    }
}
