<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InboxController extends Controller
{
    public function AdminInbox()
    {
        $adminId = Auth::id();

        // Fetch notifications with the user's name using Eloquent
        $notifications = Notification::with('user:id,name') // Eager load only 'id' and 'name' from users
        ->where('admin_id', $adminId)
            ->whereNotIn('type', ['Fee Approval', 'Fee Rejected', 'Purchase Approval', 'Purchase Rejected'])

            ->orderBy('created_at', 'desc')
            ->paginate(10); // Paginate 10 notifications per page

        return view('message.inbox', compact('notifications'));
    }
    public function UserInbox()
    {
        $userId = Auth::id();

        // Fetch notifications with the user's name using Eloquent
        $notifications = Notification::with('user:id,name') // Eager load only 'id' and 'name' from users
        ->where('user_id', $userId)
            ->whereIn('type', ['Fee Approval', 'Fee Rejected', 'Purchase Approval', 'Purchase Rejected'])

            ->orderBy('created_at', 'desc')
            ->paginate(10); // Paginate 10 notifications per page

        return view('message.inbox', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::find($id);

        if ($notification) {
            $notification->update(['is_read' => true]); // Set is_read to true
            return response()->json(['success' => true, 'message' => 'Notification marked as read']);
        }

        return response()->json(['success' => false, 'message' => 'Notification not found'], 404);
    }


}
