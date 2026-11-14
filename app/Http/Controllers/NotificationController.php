<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

class NotificationController extends Controller
{
    /**
     * Get unread notifications for Admin
     */
    public function getNotifications()
    {
        try {
            if (!Schema::hasTable('notifications')) {
                return response()->json([]);
            }

            $userId = Auth::id();
            if (!$userId) {
                return response()->json([]);
            }

            $outgoingTypes = [
                'Fee Approval', 'Fee Rejected',
                'Purchase Approval', 'Purchase Rejected',
                'Attendance Approved', 'Attendance Rejected',
                'Admission Approved', 'Admission Rejected'
            ];

            $query = Notification::with('user:id,name,email')
                ->where('admin_id', $userId)
                ->whereNotIn('type', $outgoingTypes);

            // Cross-database boolean check for unread notifications
            if (DB::connection()->getDriverName() === 'pgsql') {
                $query->whereRaw('(is_read = false OR is_read IS NULL)');
            } else {
                $query->where(function ($q) {
                    $q->where('is_read', 0)
                      ->orWhere('is_read', false)
                      ->orWhereNull('is_read');
                });
            }

            $notifications = $query->latest()
                ->take(15)
                ->get()
                ->map(function ($item) {
                    return [
                        'id'           => $item->id,
                        'type'         => $item->type,
                        'message'      => $item->message,
                        'status'       => $item->status ?? 'pending',
                        'status_color' => $item->status_color,
                        'icon'         => $item->icon,
                        'target_type'  => $item->target_type,
                        'target_id'    => $item->target_id,
                        'action_url'   => $item->action_url ?? (Route::has('message.inbox') ? route('message.inbox') : '/inbox'),
                        'sender'       => $item->user?->name ?? 'System',
                        'time_ago'     => $item->created_at ? $item->created_at->diffForHumans() : 'Just now',
                    ];
                });

            return response()->json($notifications);
        } catch (\Throwable $e) {
            Log::warning('Error in NotificationController@getNotifications: ' . $e->getMessage());
            return response()->json([]);
        }
    }

    /**
     * Get unread notifications for General Users (Teacher, Accountant, Receptionist, Student)
     */
    public function userNotifications()
    {
        try {
            if (!Schema::hasTable('notifications')) {
                return response()->json([]);
            }

            $userId = Auth::id();
            if (!$userId) {
                return response()->json([]);
            }

            $outgoingTypes = [
                'Fee Approval', 'Fee Rejected',
                'Purchase Approval', 'Purchase Rejected',
                'Attendance Approved', 'Attendance Rejected',
                'Admission Approved', 'Admission Rejected'
            ];

            $query = Notification::with('admin:id,name,email')
                ->where('user_id', $userId)
                ->where(function ($q) use ($outgoingTypes) {
                    $q->whereIn('type', $outgoingTypes)
                      ->orWhere('status', '!=', 'pending');
                });

            // Cross-database boolean check for unread notifications
            if (DB::connection()->getDriverName() === 'pgsql') {
                $query->whereRaw('(is_read = false OR is_read IS NULL)');
            } else {
                $query->where(function ($q) {
                    $q->where('is_read', 0)
                      ->orWhere('is_read', false)
                      ->orWhereNull('is_read');
                });
            }

            $notifications = $query->latest()
                ->take(15)
                ->get()
                ->map(function ($item) {
                    return [
                        'id'           => $item->id,
                        'type'         => $item->type,
                        'message'      => $item->message,
                        'status'       => $item->status ?? 'info',
                        'status_color' => $item->status_color,
                        'icon'         => $item->icon,
                        'target_type'  => $item->target_type,
                        'target_id'    => $item->target_id,
                        'action_url'   => $item->action_url ?? (Route::has('message.Userinbox') ? route('message.Userinbox') : '/Userinbox'),
                        'sender'       => $item->admin?->name ?? 'Admin',
                        'time_ago'     => $item->created_at ? $item->created_at->diffForHumans() : 'Just now',
                    ];
                });

            return response()->json($notifications);
        } catch (\Throwable $e) {
            Log::warning('Error in NotificationController@userNotifications: ' . $e->getMessage());
            return response()->json([]);
        }
    }

    /**
     * Mark all notifications as read for current user
     */
    public function markAllRead()
    {
        try {
            if (!Schema::hasTable('notifications')) {
                return response()->json(['success' => true]);
            }

            $userId = Auth::id();
            if (!$userId) {
                return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
            }

            $isAdmin = (Auth::user()->role == 0);
            $query = $isAdmin ? Notification::where('admin_id', $userId) : Notification::where('user_id', $userId);

            if (DB::connection()->getDriverName() === 'pgsql') {
                $query->whereRaw('(is_read = false OR is_read IS NULL)')->update(['is_read' => DB::raw('true')]);
            } else {
                $query->where(function ($q) {
                    $q->where('is_read', 0)
                      ->orWhere('is_read', false)
                      ->orWhereNull('is_read');
                })->update(['is_read' => true]);
            }

            return response()->json(['success' => true, 'message' => 'All notifications marked as read']);
        } catch (\Throwable $e) {
            Log::warning('Error in NotificationController@markAllRead: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Bulk delete notifications
     */
    public function bulkDelete(Request $request)
    {
        try {
            if (!Schema::hasTable('notifications')) {
                return response()->json(['success' => true]);
            }

            $ids = $request->ids;
            if (!empty($ids) && is_array($ids)) {
                Notification::whereIn('id', $ids)->delete();
                return response()->json(['success' => true, 'message' => 'Notifications deleted']);
            }
            return response()->json(['success' => false, 'message' => 'No items selected'], 400);
        } catch (\Throwable $e) {
            Log::warning('Error in NotificationController@bulkDelete: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
