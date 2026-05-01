<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        $adminId = Auth::id();
        $notifications = Notification::where('admin_id', $adminId)
            ->where('is_read', false)
            ->whereNotIn('type', ['Fee Approval', 'Fee Rejected', 'Purchase Approval', 'Purchase Rejected'])

            ->latest()
            ->get();

        return response()->json($notifications);
    }
    public function userNotifications()
    {
        $userId = Auth::id();

        // Fetch user's notifications
        $notifications = Notification::where('user_id', $userId)
            ->where('is_read', false)
            ->whereIn('type', ['Fee Approval', 'Fee Rejected', 'Purchase Approval', 'Purchase Rejected'])

            ->latest()
            ->get();

        return response()->json($notifications);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if (!empty($ids)) {
            Notification::whereIn('id', $ids)->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 400);
    }


}
