<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class InboxController extends Controller
{
    /**
     * Unified Inbox View
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $isAdmin = ($user->role == 0);
        $tab = $request->query('tab', 'all');
        $type = $request->query('type');
        $search = $request->query('search');

        // Outgoing notifications sent back to requesting users
        $outgoingTypes = [
            'Fee Approval', 'Fee Rejected',
            'Purchase Approval', 'Purchase Rejected',
            'Attendance Approved', 'Attendance Rejected',
            'Admission Approved', 'Admission Rejected'
        ];

        // Base query for current user
        $baseQuery = Notification::with(['user:id,name,email', 'admin:id,name,email']);
        if ($isAdmin) {
            $baseQuery->where('admin_id', $user->id)
                ->whereNotIn('type', $outgoingTypes);
        } else {
            $baseQuery->where('user_id', $user->id)
                ->where(function($q) use ($outgoingTypes) {
                    $q->whereIn('type', $outgoingTypes)
                      ->orWhere('status', '!=', 'pending');
                });
        }

        // Metrics / counts for badge indicators
        $countsQuery = clone $baseQuery;
        $allNotifications = $countsQuery->get();

        $counts = [
            'total' => $allNotifications->count(),
            'pending' => $allNotifications->where('status', 'pending')->count(),
            'approved' => $allNotifications->where('status', 'approved')->count(),
            'rejected' => $allNotifications->where('status', 'rejected')->count(),
            'unread' => $allNotifications->where('is_read', false)->count(),
            'starred' => $allNotifications->where('starred', true)->count(),
            'purchase' => $allNotifications->filter(fn($n) => str_contains(strtolower($n->type), 'purchase') || $n->target_type === 'purchase_request')->count(),
            'fee' => $allNotifications->filter(fn($n) => str_contains(strtolower($n->type), 'fee') || $n->target_type === 'fee_receipt')->count(),
            'admission' => $allNotifications->filter(fn($n) => str_contains(strtolower($n->type), 'admission') || $n->target_type === 'admission')->count(),
            'attendance' => $allNotifications->filter(fn($n) => str_contains(strtolower($n->type), 'attendance') || $n->target_type === 'attendance_request')->count(),
        ];

        // Apply Tab Filter
        $query = clone $baseQuery;
        switch ($tab) {
            case 'pending':
                $query->where('status', 'pending');
                break;
            case 'approved':
                $query->where('status', 'approved');
                break;
            case 'rejected':
                $query->where('status', 'rejected');
                break;
            case 'unread':
                $query->where('is_read', false);
                break;
            case 'starred':
                $query->where('starred', true);
                break;
            case 'all':
            default:
                break;
        }

        // Apply Type Filter
        if ($type) {
            if ($type === 'purchase_request') {
                $query->where(function ($q) {
                    $q->where('target_type', 'purchase_request')
                        ->orWhere('type', 'like', '%Purchase%');
                });
            } elseif ($type === 'fee_receipt') {
                $query->where(function ($q) {
                    $q->where('target_type', 'fee_receipt')
                        ->orWhere('type', 'like', '%Fee%');
                });
            } elseif ($type === 'admission') {
                $query->where(function ($q) {
                    $q->where('target_type', 'admission')
                        ->orWhere('type', 'like', '%Admission%');
                });
            } elseif ($type === 'attendance_request') {
                $query->where(function ($q) {
                    $q->where('target_type', 'attendance_request')
                        ->orWhere('type', 'like', '%Attendance%');
                });
            } elseif ($type === 'general') {
                $query->where(function ($q) {
                    $q->whereNull('target_type')
                        ->orWhere('target_type', 'general');
                });
            }
        }

        // Apply Search Keyword Filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('message', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $notifications = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('message.inbox', compact('notifications', 'counts', 'tab', 'type', 'search', 'isAdmin'));
    }

    /**
     * Backward-compatible aliases for legacy routes
     */
    public function AdminInbox(Request $request)
    {
        return $this->index($request);
    }

    public function UserInbox(Request $request)
    {
        return $this->index($request);
    }

    /**
     * Get detail payload for preview modal
     */
    public function getDetail($id)
    {
        $user = Auth::user();
        $notification = Notification::with(['user:id,name,email', 'admin:id,name,email'])->findOrFail($id);

        // Security check
        if ($user->role != 0 && $notification->user_id != $user->id && $notification->admin_id != $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Auto mark as read on open
        if (!$notification->is_read) {
            $notification->update(['is_read' => true]);
        }

        $detail = [
            'notification' => $notification,
            'target_type' => $notification->target_type,
            'target_id' => $notification->target_id,
            'action_url' => $notification->action_url,
            'status' => $notification->status ?? 'pending',
            'can_approve' => ($user->role == 0 && ($notification->status === 'pending' || $notification->status === null)),
            'item' => null,
            'items_list' => [],
        ];

        // Resolve linked entity details
        if ($notification->target_type === 'purchase_request' || str_contains($notification->type, 'Purchase')) {
            $targetId = $notification->target_id;
            $purchase = null;
            if ($targetId) {
                $purchase = DB::table('purchase_request')->where('id', $targetId)->first();
            }
            if (!$purchase) {
                $purchase = DB::table('purchase_request')->latest('id')->first();
            }

            if ($purchase) {
                $items = DB::table('purchase_request_items')->where('purchase_request_id', $purchase->id)->get();
                $detail['item'] = $purchase;
                $detail['items_list'] = $items;
                $detail['target_id'] = $purchase->id;
                $detail['target_type'] = 'purchase_request';
                $detail['action_url'] = route('purchase_req.show', $purchase->id);
            }
        } elseif ($notification->target_type === 'fee_receipt' || str_contains($notification->type, 'Fee')) {
            $targetId = $notification->target_id;
            $receipt = null;
            if ($targetId) {
                $receipt = DB::table('fee_receipt')->where('id', $targetId)->first();
            }
            if (!$receipt) {
                $receipt = DB::table('fee_receipt')->latest('id')->first();
            }

            if ($receipt) {
                $items = DB::table('fee_receipt_items')->where('fee_receipt_id', $receipt->id)->get();
                $studentInfo = DB::table('student_classes')
                    ->join('student', 'student_classes.student_id', '=', 'student.student_id')
                    ->leftJoin('class', 'student_classes.class_id', '=', 'class.class_id')
                    ->leftJoin('section', 'student_classes.section_id', '=', 'section.section_id')
                    ->where('student_classes.id', $receipt->student_class_id)
                    ->select('student.name as student_name', 'student_classes.roll', 'class.name as class_name', 'section.name as section_name')
                    ->first();

                $detail['item'] = $receipt;
                $detail['student_info'] = $studentInfo;
                $detail['items_list'] = $items;
                $detail['target_id'] = $receipt->id;
                $detail['target_type'] = 'fee_receipt';
                $detail['action_url'] = route('fee_receipt.show', $receipt->id);
            }
        } elseif ($notification->target_type === 'admission' || str_contains($notification->type, 'Admission')) {
            $targetId = $notification->target_id;
            $admission = null;
            if ($targetId) {
                $admission = DB::table('admission')->where('id', $targetId)->first();
            }
            if (!$admission) {
                $admission = DB::table('admission')->latest('id')->first();
            }

            if ($admission) {
                $detail['item'] = $admission;
                $detail['target_id'] = $admission->id;
                $detail['target_type'] = 'admission';
                $detail['action_url'] = route('studentsAdmission.show', $admission->id);
            }
        } elseif ($notification->target_type === 'attendance_request' || str_contains($notification->type, 'Attendance')) {
            $targetId = $notification->target_id;
            $req = null;
            if ($targetId) {
                $req = DB::table('attendance_edit_requests')->where('id', $targetId)->first();
            }
            if (!$req) {
                $req = DB::table('attendance_edit_requests')->latest('id')->first();
            }

            if ($req) {
                $teacher = DB::table('teacher')->where('teacher_id', $req->teacher_id)->first();
                $class = DB::table('class')->where('class_id', $req->class_id)->first();
                $section = DB::table('section')->where('section_id', $req->section_id)->first();

                $detail['item'] = $req;
                $detail['teacher_name'] = $teacher->name ?? 'Teacher';
                $detail['class_name'] = $class->name ?? 'Class';
                $detail['section_name'] = $section->name ?? 'Section';
                $detail['target_id'] = $req->id;
                $detail['target_type'] = 'attendance_request';
                $detail['action_url'] = route('attendance.requestList');
            }
        }

        return response()->json($detail);
    }

    /**
     * Admin Quick Action (Approve / Reject directly from Inbox Modal)
     */
    public function quickAction(Request $request)
    {
        if (Auth::user()->role != 0) {
            return response()->json(['error' => 'Unauthorized. Admin rights required.'], 403);
        }

        $request->validate([
            'notification_id' => 'required|integer',
            'action' => 'required|in:approve,reject',
            'notes' => 'nullable|string',
        ]);

        $notification = Notification::findOrFail($request->notification_id);
        $action = $request->action;
        $adminId = Auth::id();

        DB::beginTransaction();
        try {
            $targetType = $notification->target_type;
            $targetId = $notification->target_id;

            // 1. Purchase Request Action
            if ($targetType === 'purchase_request' || str_contains($notification->type, 'Purchase')) {
                $purchase = null;
                if ($targetId) {
                    $purchase = DB::table('purchase_request')->where('id', $targetId)->first();
                }
                if (!$purchase) {
                    $purchase = DB::table('purchase_request')->where('status', 'pending')->latest('id')->first();
                }
                if (!$purchase) {
                    $purchase = DB::table('purchase_request')->latest('id')->first();
                }

                if ($purchase) {
                    $targetId = $purchase->id;
                    if ($action === 'approve') {
                        DB::table('purchase_request')->where('id', $targetId)->update([
                            'status' => 'approved',
                            'approved_by' => $adminId,
                        ]);

                        $note = implode(', ', array_filter([
                            $purchase->requisitioner ?? '',
                            $purchase->purpose ?? '',
                            $purchase->vendor ?? '',
                        ]));

                        DB::table('transactions')->insert([
                            'from_id' => $targetId,
                            'date' => $purchase->date_prepared,
                            'type' => 'expense',
                            'category' => 'Purchase Request',
                            'amount' => $purchase->total,
                            'note' => $note,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        Notification::updateTargetStatus('purchase_request', $targetId, 'approved');
                        if (!empty($purchase->user_id)) {
                            Notification::notifyUser($purchase->user_id, [
                                'type' => 'Purchase Approval',
                                'target_id' => $targetId,
                                'target_type' => 'purchase_request',
                                'action_url' => route('purchase_req.show', $targetId),
                                'status' => 'approved',
                                'message' => 'Your purchase request for ' . ($purchase->department ?? 'General') . ' ($' . number_format($purchase->total, 2) . ') has been approved!',
                            ]);
                        }
                    } else {
                        DB::table('purchase_request')->where('id', $targetId)->update([
                            'status' => 'rejected',
                        ]);

                        Notification::updateTargetStatus('purchase_request', $targetId, 'rejected');
                        if (!empty($purchase->user_id)) {
                            Notification::notifyUser($purchase->user_id, [
                                'type' => 'Purchase Rejected',
                                'target_id' => $targetId,
                                'target_type' => 'purchase_request',
                                'action_url' => route('purchase_req.show', $targetId),
                                'status' => 'rejected',
                                'message' => 'Your purchase request for ' . ($purchase->department ?? 'General') . ' has been rejected.',
                            ]);
                        }
                    }
                }
            }

            // 2. Fee Receipt Action
            elseif ($targetType === 'fee_receipt' || str_contains($notification->type, 'Fee')) {
                $feeReceipt = null;
                if ($targetId) {
                    $feeReceipt = DB::table('fee_receipt')->where('id', $targetId)->first();
                }
                if (!$feeReceipt) {
                    $feeReceipt = DB::table('fee_receipt')->where('status', 'pending')->latest('id')->first();
                }
                if (!$feeReceipt) {
                    $feeReceipt = DB::table('fee_receipt')->latest('id')->first();
                }

                if ($feeReceipt) {
                    $targetId = $feeReceipt->id;
                    if ($action === 'approve') {
                        DB::table('fee_receipt')->where('id', $targetId)->update([
                            'status' => 'approved',
                            'approved_by' => $adminId,
                        ]);

                        DB::table('transactions')->insert([
                            'from_id' => $targetId,
                            'date' => $feeReceipt->date,
                            'type' => 'profit',
                            'category' => 'Fee Receipt',
                            'amount' => $feeReceipt->paid,
                            'note' => $feeReceipt->paid_via,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        Notification::updateTargetStatus('fee_receipt', $targetId, 'approved');
                        if (!empty($feeReceipt->user_id)) {
                            Notification::notifyUser($feeReceipt->user_id, [
                                'type' => 'Fee Approval',
                                'target_id' => $targetId,
                                'target_type' => 'fee_receipt',
                                'action_url' => route('fee_receipt.show', $targetId),
                                'status' => 'approved',
                                'message' => 'Your fee receipt request #' . ($feeReceipt->receipt_no ?? $targetId) . ' has been approved!',
                            ]);
                        }
                    } else {
                        DB::table('fee_receipt')->where('id', $targetId)->update([
                            'status' => 'rejected',
                        ]);

                        Notification::updateTargetStatus('fee_receipt', $targetId, 'rejected');
                        if (!empty($feeReceipt->user_id)) {
                            Notification::notifyUser($feeReceipt->user_id, [
                                'type' => 'Fee Rejected',
                                'target_id' => $targetId,
                                'target_type' => 'fee_receipt',
                                'action_url' => route('fee_receipt.show', $targetId),
                                'status' => 'rejected',
                                'message' => 'Your fee receipt request #' . ($feeReceipt->receipt_no ?? $targetId) . ' has been rejected.',
                            ]);
                        }
                    }
                }
            }

            // 3. Admission Action
            elseif ($targetType === 'admission' || str_contains($notification->type, 'Admission')) {
                $admission = null;
                if ($targetId) {
                    $admission = DB::table('admission')->where('id', $targetId)->first();
                }
                if (!$admission) {
                    $admission = DB::table('admission')->where('status', 'pending')->latest('id')->first();
                }
                if (!$admission) {
                    $admission = DB::table('admission')->latest('id')->first();
                }

                if ($admission) {
                    $targetId = $admission->id;
                    if ($action === 'approve') {
                        DB::table('admission')->where('id', $targetId)->update([
                            'status' => 'approved',
                            'decide_by' => $adminId,
                            'updated_at' => now(),
                        ]);

                        // Check if user already exists
                        $existingUser = DB::table('users')->where('email', $admission->email)->first();
                        $newUserId = $existingUser ? $existingUser->id : DB::table('users')->insertGetId([
                            'name' => $admission->full_name,
                            'email' => $admission->email,
                            'password' => Hash::make('123456'),
                            'role' => 2,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        // Guardian / Parent
                        $parentId = null;
                        if ($admission->guardian_name || $admission->guardian_phone || $admission->guardian_email) {
                            $parentId = DB::table('parent')->insertGetId([
                                'name' => $admission->guardian_name ?? '',
                                'phone' => $admission->guardian_phone ?? '',
                                'email' => $admission->guardian_email ?? '',
                            ]);
                        }

                        $address = implode(', ', array_filter([
                            $admission->apartment,
                            $admission->street,
                            $admission->province,
                            $admission->city,
                            $admission->country
                        ]));

                        $studentExists = DB::table('student')->where('user_id', $newUserId)->exists();
                        if (!$studentExists) {
                            DB::table('student')->insert([
                                'user_id' => $newUserId,
                                'name' => $admission->full_name,
                                'birthday' => $admission->dob,
                                'sex' => ($admission->gender === 'Male' ? 0 : 1),
                                'address' => $address,
                                'phone' => $admission->phone,
                                'photo' => 'noimg.jpg',
                                'email' => $admission->email,
                                'parent_id' => $parentId,
                            ]);
                        }

                        Notification::updateTargetStatus('admission', $targetId, 'approved');
                    } else {
                        DB::table('admission')->where('id', $targetId)->update([
                            'status' => 'rejected',
                            'decide_by' => $adminId,
                            'updated_at' => now(),
                        ]);

                        Notification::updateTargetStatus('admission', $targetId, 'rejected');
                    }
                }
            }

            // 4. Attendance Edit Request Action
            elseif ($targetType === 'attendance_request' || str_contains($notification->type, 'Attendance')) {
                $attRequest = null;
                if ($targetId) {
                    $attRequest = DB::table('attendance_edit_requests')->where('id', $targetId)->first();
                }
                if (!$attRequest) {
                    $attRequest = DB::table('attendance_edit_requests')->where('status', 'Pending')->latest('id')->first();
                }
                if (!$attRequest) {
                    $attRequest = DB::table('attendance_edit_requests')->latest('id')->first();
                }

                if ($attRequest) {
                    $targetId = $attRequest->id;
                    $statusText = ($action === 'approve') ? 'Approved' : 'Rejected';
                    $statusSlug = ($action === 'approve') ? 'approved' : 'rejected';

                    DB::table('attendance_edit_requests')->where('id', $targetId)->update([
                        'status' => $statusText,
                        'updated_at' => now(),
                    ]);

                    Notification::updateTargetStatus('attendance_request', $targetId, $statusSlug);

                    $teacher = DB::table('teacher')->where('teacher_id', $attRequest->teacher_id)->first();
                    if ($teacher && $teacher->user_id) {
                        Notification::notifyUser($teacher->user_id, [
                            'type' => 'Attendance ' . $statusText,
                            'target_id' => $targetId,
                            'target_type' => 'attendance_request',
                            'action_url' => route('attendance.requestList'),
                            'status' => $statusSlug,
                            'message' => "Your attendance edit request for {$attRequest->date} has been {$statusText}.",
                        ]);
                    }
                }
            }

            // Update current notification
            $notification->update([
                'status' => ($action === 'approve') ? 'approved' : 'rejected',
                'is_read' => true,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Request successfully ' . ($action === 'approve' ? 'approved!' : 'rejected!'),
                'new_status' => ($action === 'approve') ? 'approved' : 'rejected',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Quick Action Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Mark single notification as read
     */
    public function markAsRead($id)
    {
        $notification = Notification::find($id);
        if ($notification) {
            $notification->update(['is_read' => true]);
            return response()->json(['success' => true, 'message' => 'Marked as read']);
        }
        return response()->json(['success' => false, 'message' => 'Notification not found'], 404);
    }

    /**
     * Mark single notification as unread
     */
    public function markAsUnread($id)
    {
        $notification = Notification::find($id);
        if ($notification) {
            $notification->update(['is_read' => false]);
            return response()->json(['success' => true, 'message' => 'Marked as unread']);
        }
        return response()->json(['success' => false, 'message' => 'Notification not found'], 404);
    }

    /**
     * Toggle Star / Pin
     */
    public function toggleStar($id)
    {
        $notification = Notification::find($id);
        if ($notification) {
            $notification->starred = !$notification->starred;
            $notification->save();
            return response()->json(['success' => true, 'starred' => $notification->starred]);
        }
        return response()->json(['success' => false, 'message' => 'Notification not found'], 404);
    }

    /**
     * Bulk actions (delete, mark_read, mark_unread, star)
     */
    public function bulkAction(Request $request)
    {
        $ids = $request->input('ids', []);
        $action = $request->input('action');

        if (empty($ids) || !is_array($ids)) {
            return response()->json(['success' => false, 'message' => 'No items selected'], 400);
        }

        switch ($action) {
            case 'delete':
                Notification::whereIn('id', $ids)->delete();
                $msg = 'Selected items deleted';
                break;
            case 'mark_read':
                Notification::whereIn('id', $ids)->update(['is_read' => true]);
                $msg = 'Selected items marked as read';
                break;
            case 'mark_unread':
                Notification::whereIn('id', $ids)->update(['is_read' => false]);
                $msg = 'Selected items marked as unread';
                break;
            case 'star':
                Notification::whereIn('id', $ids)->update(['starred' => true]);
                $msg = 'Selected items starred';
                break;
            case 'unstar':
                Notification::whereIn('id', $ids)->update(['starred' => false]);
                $msg = 'Selected items unstarred';
                break;
            default:
                return response()->json(['success' => false, 'message' => 'Invalid action'], 400);
        }

        return response()->json(['success' => true, 'message' => $msg]);
    }
}
