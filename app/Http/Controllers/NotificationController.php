<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Get unread notifications for Admin
     */
    public function getNotifications()
    {
        $userId = Auth::id();

        $outgoingTypes = [
            'Fee Approval', 'Fee Rejected',
            'Purchase Approval', 'Purchase Rejected',
            'Attendance Approved', 'Attendance Rejected',
            'Admission Approved', 'Admission Rejected'
        ];

        $notifications = Notification::with('user:id,name,email')
            ->where('admin_id', $userId)
            ->where('is_read', false)
            ->whereNotIn('type', $outgoingTypes)
            ->latest()
            ->take(15)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'type' => $item->type,
                    'message' => $item->message,
                    'status' => $item->status ?? 'pending',
                    'status_color' => $item->status_color,
                    'icon' => $item->icon,
                    'target_type' => $item->target_type,
                    'target_id' => $item->target_id,
                    'action_url' => $item->action_url ?? route('message.inbox'),
                    'sender' => $item->user->name ?? 'System',
                    'time_ago' => $item->created_at->diffForHumans(),
                ];
            });

        return response()->json($notifications);
    }

    /**
     * Get unread notifications for General Users (Teacher, Accountant, Receptionist, Student)
     */
    public function userNotifications()
    {
        $userId = Auth::id();

        $outgoingTypes = [
            'Fee Approval', 'Fee Rejected',
            'Purchase Approval', 'Purchase Rejected',
            'Attendance Approved', 'Attendance Rejected',
            'Admission Approved', 'Admission Rejected'
        ];

        $notifications = Notification::with('admin:id,name,email')
            ->where('user_id', $userId)
            ->where('is_read', false)
            ->where(function($q) use ($outgoingTypes) {
                $q->whereIn('type', $outgoingTypes)
                  ->orWhere('status', '!=', 'pending');
            })
            ->latest()
            ->take(15)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'type' => $item->type,
                    'message' => $item->message,
                    'status' => $item->status ?? 'info',
                    'status_color' => $item->status_color,
                    'icon' => $item->icon,
                    'target_type' => $item->target_type,
                    'target_id' => $item->target_id,
                    'action_url' => $item->action_url ?? route('message.Userinbox'),
                    'sender' => $item->admin->name ?? 'Admin',
                    'time_ago' => $item->created_at->diffForHumans(),
                ];
            });

        return response()->json($notifications);
    }

    /**
     * Mark all notifications as read for current user
     */
    public function markAllRead()
    {
        $userId = Auth::id();
        $isAdmin = (Auth::user()->role == 0);

        if ($isAdmin) {
            Notification::where('admin_id', $userId)->where('is_read', false)->update(['is_read' => true]);
        } else {
            Notification::where('user_id', $userId)->where('is_read', false)->update(['is_read' => true]);
        }

        return response()->json(['success' => true, 'message' => 'All notifications marked as read']);
    }

    /**
     * Bulk delete notifications
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if (!empty($ids) && is_array($ids)) {
            Notification::whereIn('id', $ids)->delete();
            return response()->json(['success' => true, 'message' => 'Notifications deleted']);
        }
        return response()->json(['success' => false, 'message' => 'No items selected'], 400);
    }
}
