@extends('layout.main')

@section('content')
<style>
    /* Modern Inbox Styling */
    .inbox-wrapper {
        font-family: inherit;
    }
    .metric-card {
        border-radius: 14px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        overflow: hidden;
        position: relative;
    }
    .metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15) !important;
    }
    .metric-card .icon-bg {
        position: absolute;
        right: 15px;
        bottom: 12px;
        font-size: 3.2rem;
        opacity: 0.15;
    }

    /* Sidebar Navigation */
    .inbox-nav .nav-link {
        border-radius: 8px;
        color: inherit;
        font-weight: 500;
        padding: 10px 14px;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.2s ease;
    }
    .inbox-nav .nav-link:hover {
        background: rgba(0, 123, 255, 0.08);
        color: #007bff;
    }
    .inbox-nav .nav-link.active {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        color: #fff !important;
        box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
    }
    .inbox-nav .nav-link.active .badge {
        background-color: rgba(255, 255, 255, 0.25) !important;
        color: #fff !important;
    }

    /* Mailbox Table Rows */
    .mail-row {
        cursor: pointer;
        transition: background-color 0.15s ease, transform 0.15s ease;
        border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    }
    .dark-mode .mail-row {
        border-bottom: 1px solid rgba(255, 255, 255, 0.07);
    }
    .mail-row:hover {
        background-color: rgba(0, 123, 255, 0.04) !important;
    }
    .dark-mode .mail-row:hover {
        background-color: rgba(255, 255, 255, 0.05) !important;
    }
    .mail-row.unread {
        background-color: rgba(0, 123, 255, 0.07);
        font-weight: 600;
        border-left: 4px solid #007bff;
    }
    .dark-mode .mail-row.unread {
        background-color: rgba(30, 48, 80, 0.5);
        border-left: 4px solid #3b82f6;
    }
    .mail-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 700;
        color: #fff;
        text-transform: uppercase;
        box-shadow: 0 2px 6px rgba(0,0,0,0.12);
    }

    /* Star toggle */
    .star-btn {
        background: none;
        border: none;
        padding: 4px 8px;
        color: #adb5bd;
        transition: color 0.2s, transform 0.2s;
        cursor: pointer;
    }
    .star-btn.starred {
        color: #f59e0b !important;
    }
    .star-btn:hover {
        transform: scale(1.2);
    }

    /* Pulsing pending badge */
    .badge-pulse {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #f59e0b;
        margin-right: 6px;
        box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7);
        animation: pulseAnimation 1.6s infinite cubic-bezier(0.66, 0, 0, 1);
    }
    @keyframes pulseAnimation {
        to {
            box-shadow: 0 0 0 10px rgba(245, 158, 11, 0);
        }
    }

    /* Quick action buttons on row */
    .row-actions {
        opacity: 0;
        transition: opacity 0.2s ease;
    }
    .mail-row:hover .row-actions {
        opacity: 1;
    }

    /* Custom Scrollbar for Mailbox */
    .mailbox-scroll {
        max-height: 650px;
        overflow-y: auto;
    }

    /* Modal styling */
    .modal-hero {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        color: #fff;
        border-radius: 12px 12px 0 0;
        padding: 20px 24px;
    }

    /* Dark Mode specific theme styles */
    .dark-mode .modal-content {
        background-color: #1e293b !important;
        color: #e2e8f0 !important;
    }
    .dark-mode .modal-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
    }
    .dark-mode .card.bg-light,
    .dark-mode .modal-footer.bg-light,
    .dark-mode .card-header.bg-light,
    .dark-mode .card-footer.bg-light,
    .dark-mode .bg-light {
        background-color: #0f172a !important;
        border-color: rgba(255, 255, 255, 0.1) !important;
    }
    .dark-mode .table.table-sm.table-bordered thead.thead-light th {
        background-color: rgba(255, 255, 255, 0.08) !important;
        color: #e2e8f0 !important;
        border-color: rgba(255, 255, 255, 0.1) !important;
    }
    .dark-mode .table.table-sm.table-bordered td {
        border-color: rgba(255, 255, 255, 0.1) !important;
        color: #e2e8f0 !important;
    }
    .dark-mode .text-dark {
        color: #f1f5f9 !important;
    }
    .dark-mode .inbox-nav .nav-link {
        color: #cbd5e1;
    }
    .dark-mode .inbox-nav .nav-link:hover {
        background: rgba(255, 255, 255, 0.08);
        color: #60a5fa;
    }
</style>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-3 align-items-center">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">
                    <i class="fas fa-inbox text-primary mr-2"></i>Inbox & Approvals
                </h1>
                <p class="text-muted text-sm mb-0">Manage approvals, financial requests, admissions, and notifications</p>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item active">Inbox & Approvals</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content inbox-wrapper">
    <div class="container-fluid">

        <!-- Top Metrics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
                <div class="card metric-card shadow-sm border-0 bg-gradient-primary text-white h-100">
                    <div class="card-body p-3">
                        <span class="text-uppercase text-xs font-weight-bold" style="letter-spacing: 0.5px;">All Notifications</span>
                        <h2 class="font-weight-bold mt-1 mb-0">{{ number_format($counts['total']) }}</h2>
                        <span class="text-xs opacity-75">Incoming notifications & requests</span>
                        <i class="fas fa-inbox icon-bg text-white"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
                <div class="card metric-card shadow-sm border-0 bg-gradient-warning text-white h-100">
                    <div class="card-body p-3">
                        <span class="text-uppercase text-xs font-weight-bold" style="letter-spacing: 0.5px;">Pending Action</span>
                        <h2 class="font-weight-bold mt-1 mb-0">
                            {{ number_format($counts['pending']) }}
                            @if($counts['pending'] > 0)
                                <span class="badge badge-danger text-xs align-middle ml-2" style="font-size: 11px;">Requires Action</span>
                            @endif
                        </h2>
                        <span class="text-xs opacity-75">Awaiting admin decision</span>
                        <i class="fas fa-hourglass-half icon-bg text-white"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
                <div class="card metric-card shadow-sm border-0 bg-gradient-success text-white h-100">
                    <div class="card-body p-3">
                        <span class="text-uppercase text-xs font-weight-bold" style="letter-spacing: 0.5px;">Approved / Resolved</span>
                        <h2 class="font-weight-bold mt-1 mb-0">{{ number_format($counts['approved']) }}</h2>
                        <span class="text-xs opacity-75">Successfully processed</span>
                        <i class="fas fa-check-circle icon-bg text-white"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card metric-card shadow-sm border-0 bg-gradient-info text-white h-100">
                    <div class="card-body p-3">
                        <span class="text-uppercase text-xs font-weight-bold" style="letter-spacing: 0.5px;">Unread Messages</span>
                        <h2 class="font-weight-bold mt-1 mb-0">{{ number_format($counts['unread']) }}</h2>
                        <div class="d-flex justify-content-between align-items-center mt-1">
                            <span class="text-xs opacity-75">New updates</span>
                            @if($counts['unread'] > 0)
                                <button type="button" id="topMarkAllReadBtn" class="btn btn-xs btn-outline-light py-0 px-2" style="border-radius: 20px;">
                                    Mark all read
                                </button>
                            @endif
                        </div>
                        <i class="fas fa-bell icon-bg text-white"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Layout: Sidebar & Content -->
        <div class="row">

            <!-- Sidebar Navigation -->
            <div class="col-lg-3 col-md-4 mb-4">
                <div class="card shadow-sm border-0" style="border-radius: 14px;">
                    <div class="card-body p-3">

                        <h6 class="text-xs font-weight-bold text-uppercase text-muted px-2 mb-2" style="letter-spacing: 1px;">
                            Quick Filters
                        </h6>
                        <nav class="nav flex-column inbox-nav mb-4">
                            <a href="{{ route('message.inbox', ['tab' => 'all']) }}" class="nav-link {{ $tab === 'all' && empty($type) ? 'active' : '' }}">
                                <span><i class="fas fa-inbox mr-2"></i> All Notifications</span>
                                <span class="badge badge-light badge-pill">{{ $counts['total'] }}</span>
                            </a>
                            <a href="{{ route('message.inbox', ['tab' => 'pending']) }}" class="nav-link {{ $tab === 'pending' ? 'active' : '' }}">
                                <span><i class="fas fa-hourglass-half text-warning mr-2"></i> Pending Approvals</span>
                                <span class="badge badge-warning badge-pill text-white">{{ $counts['pending'] }}</span>
                            </a>
                            <a href="{{ route('message.inbox', ['tab' => 'approved']) }}" class="nav-link {{ $tab === 'approved' ? 'active' : '' }}">
                                <span><i class="fas fa-check-circle text-success mr-2"></i> Approved</span>
                                <span class="badge badge-success badge-pill">{{ $counts['approved'] }}</span>
                            </a>
                            <a href="{{ route('message.inbox', ['tab' => 'rejected']) }}" class="nav-link {{ $tab === 'rejected' ? 'active' : '' }}">
                                <span><i class="fas fa-times-circle text-danger mr-2"></i> Rejected</span>
                                <span class="badge badge-danger badge-pill">{{ $counts['rejected'] }}</span>
                            </a>
                            <a href="{{ route('message.inbox', ['tab' => 'unread']) }}" class="nav-link {{ $tab === 'unread' ? 'active' : '' }}">
                                <span><i class="far fa-envelope text-info mr-2"></i> Unread</span>
                                <span class="badge badge-info badge-pill">{{ $counts['unread'] }}</span>
                            </a>
                            <a href="{{ route('message.inbox', ['tab' => 'starred']) }}" class="nav-link {{ $tab === 'starred' ? 'active' : '' }}">
                                <span><i class="fas fa-star text-warning mr-2"></i> Starred</span>
                                <span class="badge badge-secondary badge-pill">{{ $counts['starred'] }}</span>
                            </a>
                        </nav>

                        <h6 class="text-xs font-weight-bold text-uppercase text-muted px-2 mb-2" style="letter-spacing: 1px;">
                            Flow Categories
                        </h6>
                        <nav class="nav flex-column inbox-nav">
                            <a href="{{ route('message.inbox', ['type' => 'purchase_request']) }}" class="nav-link {{ $type === 'purchase_request' ? 'active' : '' }}">
                                <span><i class="fas fa-shopping-cart text-primary mr-2"></i> Purchase Requests</span>
                                <span class="badge badge-light badge-pill">{{ $counts['purchase'] }}</span>
                            </a>
                            <a href="{{ route('message.inbox', ['type' => 'fee_receipt']) }}" class="nav-link {{ $type === 'fee_receipt' ? 'active' : '' }}">
                                <span><i class="fas fa-receipt text-success mr-2"></i> Fee Receipts</span>
                                <span class="badge badge-light badge-pill">{{ $counts['fee'] }}</span>
                            </a>
                            <a href="{{ route('message.inbox', ['type' => 'admission']) }}" class="nav-link {{ $type === 'admission' ? 'active' : '' }}">
                                <span><i class="fas fa-user-graduate text-purple mr-2" style="color: #8b5cf6;"></i> Admissions</span>
                                <span class="badge badge-light badge-pill">{{ $counts['admission'] }}</span>
                            </a>
                            <a href="{{ route('message.inbox', ['type' => 'attendance_request']) }}" class="nav-link {{ $type === 'attendance_request' ? 'active' : '' }}">
                                <span><i class="fas fa-calendar-check text-info mr-2"></i> Attendance Requests</span>
                                <span class="badge badge-light badge-pill">{{ $counts['attendance'] }}</span>
                            </a>
                            <a href="{{ route('message.inbox', ['type' => 'general']) }}" class="nav-link {{ $type === 'general' ? 'active' : '' }}">
                                <span><i class="fas fa-bullhorn text-secondary mr-2"></i> General Notices</span>
                            </a>
                        </nav>

                    </div>
                </div>
            </div>

            <!-- Main Mailbox Panel -->
            <div class="col-lg-9 col-md-8">
                <div class="card shadow-sm border-0" style="border-radius: 14px; overflow: hidden;">

                    <!-- Top Action & Search Bar -->
                    <div class="card-header border-bottom py-3 px-3">
                        <div class="row align-items-center">

                            <!-- Left: Bulk Controls -->
                            <div class="col-md-7 mb-2 mb-md-0 d-flex align-items-center">
                                <div class="custom-control custom-checkbox mr-3">
                                    <input type="checkbox" class="custom-control-input" id="checkAll">
                                    <label class="custom-control-label" for="checkAll"></label>
                                </div>

                                <div class="btn-group mr-2">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" id="refreshBtn" title="Refresh list">
                                        <i class="fas fa-sync-alt" id="refreshIcon"></i>
                                    </button>
                                </div>

                                <div class="btn-group mr-2" id="bulkActionsGroup" style="display: none;">
                                    <button type="button" class="btn btn-outline-primary btn-sm" id="bulkMarkReadBtn" title="Mark selected as read">
                                        <i class="far fa-envelope-open mr-1"></i> Read
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" id="bulkMarkUnreadBtn" title="Mark selected as unread">
                                        <i class="far fa-envelope mr-1"></i> Unread
                                    </button>
                                    <button type="button" class="btn btn-outline-warning btn-sm" id="bulkStarBtn" title="Star selected">
                                        <i class="fas fa-star mr-1"></i> Star
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm" id="bulkDeleteBtn" title="Delete selected">
                                        <i class="far fa-trash-alt mr-1"></i> Delete
                                    </button>
                                </div>

                                <span class="text-xs text-muted ml-2" id="selectedCountText"></span>
                            </div>

                            <!-- Right: Search Form -->
                            <div class="col-md-5">
                                <form method="GET" action="{{ route('message.inbox') }}" class="m-0">
                                    <input type="hidden" name="tab" value="{{ $tab }}">
                                    @if($type)
                                        <input type="hidden" name="type" value="{{ $type }}">
                                    @endif
                                    <div class="input-group input-group-sm">
                                        <input type="text" name="search" class="form-control" placeholder="Search message, sender, type..." value="{{ $search ?? '' }}">
                                        <div class="input-group-append">
                                            @if($search)
                                                <a href="{{ route('message.inbox', ['tab' => $tab, 'type' => $type]) }}" class="btn btn-default" title="Clear search">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            @endif
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>

                    <!-- Notification Rows Container -->
                    <div class="card-body p-0">
                        @if($notifications->isEmpty())
                            <!-- Empty State -->
                            <div class="text-center py-5 px-3">
                                <div class="mb-3">
                                    <span class="btn btn-light btn-circle p-3" style="width: 70px; height: 70px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; background: rgba(0, 123, 255, 0.08);">
                                        <i class="fas fa-inbox fa-3x text-primary opacity-50"></i>
                                    </span>
                                </div>
                                <h5 class="font-weight-bold mb-1">No notifications found</h5>
                                <p class="text-muted text-sm mb-3">
                                    @if($search)
                                        No items matched your search query "{{ $search }}".
                                    @elseif($tab === 'pending')
                                        You're all caught up! There are no pending approvals waiting for your review.
                                    @elseif($tab === 'unread')
                                        You have read all your notifications.
                                    @elseif($tab === 'starred')
                                        You haven't starred any notifications yet.
                                    @else
                                        There are no notifications in this folder.
                                    @endif
                                </p>
                                @if($search || $type || $tab !== 'all')
                                    <a href="{{ route('message.inbox') }}" class="btn btn-primary btn-sm px-3" style="border-radius: 20px;">
                                        <i class="fas fa-arrow-left mr-1"></i> View All Notifications
                                    </a>
                                @endif
                            </div>
                        @else
                            <div class="table-responsive mailbox-scroll">
                                <table class="table table-hover mb-0">
                                    <tbody>
                                        @foreach($notifications as $notification)
                                            @php
                                                $sender = $notification->user->name ?? $notification->admin->name ?? 'System User';
                                                $initials = strtoupper(substr($sender, 0, 2));

                                                // Category colors
                                                $catColor = match(true) {
                                                    str_contains($notification->type, 'Purchase') => 'primary',
                                                    str_contains($notification->type, 'Fee') => 'success',
                                                    str_contains($notification->type, 'Admission') => 'purple',
                                                    str_contains($notification->type, 'Attendance') => 'info',
                                                    default => 'secondary',
                                                };

                                                // Status badge info
                                                $status = strtolower($notification->status ?? 'pending');
                                            @endphp

                                            <tr class="mail-row {{ $notification->is_read ? 'read' : 'unread' }}"
                                                data-id="{{ $notification->id }}"
                                                data-read="{{ $notification->is_read ? 'true' : 'false' }}">

                                                <!-- Checkbox -->
                                                <td class="align-middle py-3 pl-3 pr-1" style="width: 36px;" onclick="event.stopPropagation();">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input mail-select"
                                                               id="rowCheck{{ $notification->id }}"
                                                               value="{{ $notification->id }}">
                                                        <label class="custom-control-label" for="rowCheck{{ $notification->id }}"></label>
                                                    </div>
                                                </td>

                                                <!-- Star -->
                                                <td class="align-middle py-3 px-1 text-center" style="width: 36px;" onclick="event.stopPropagation();">
                                                    <button type="button" class="star-btn {{ $notification->starred ? 'starred' : '' }}"
                                                            data-id="{{ $notification->id }}"
                                                            title="{{ $notification->starred ? 'Unstar' : 'Star' }}">
                                                        <i class="{{ $notification->starred ? 'fas fa-star' : 'far fa-star' }}"></i>
                                                    </button>
                                                </td>

                                                <!-- Avatar / Requester -->
                                                <td class="align-middle py-3 px-2" style="width: 190px;">
                                                    <div class="d-flex align-items-center">
                                                        <div class="mail-avatar mr-2 bg-gradient-{{ $catColor }}">
                                                            {{ $initials }}
                                                        </div>
                                                        <div class="overflow-hidden" style="max-width: 135px;">
                                                            <div class="font-weight-bold text-truncate" title="{{ $sender }}">
                                                                {{ $sender }}
                                                            </div>
                                                            <div class="text-xs text-muted text-truncate">
                                                                {{ $notification->user->email ?? 'System' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <!-- Category Badge -->
                                                <td class="align-middle py-3 px-2" style="width: 140px;">
                                                    <span class="badge badge-{{ $catColor }} py-1 px-2 font-weight-normal text-xs" style="border-radius: 6px;">
                                                        <i class="{{ $notification->icon }} mr-1"></i>
                                                        {{ Str::limit($notification->type, 18) }}
                                                    </span>
                                                </td>

                                                <!-- Message Snippet -->
                                                <td class="align-middle py-3 px-2">
                                                    <div class="d-flex align-items-center">
                                                        <span class="text-truncate mr-2 flex-grow-1" style="max-width: 420px;" title="{{ $notification->message }}">
                                                            {{ $notification->message }}
                                                        </span>

                                                        <!-- Status Pill -->
                                                        @if($status === 'pending')
                                                            <span class="badge badge-warning text-dark px-2 py-1 ml-1 badge-status" style="border-radius: 12px; font-size: 11px;">
                                                                <span class="badge-pulse"></span>Pending Approval
                                                            </span>
                                                        @elseif($status === 'approved')
                                                            <span class="badge badge-success px-2 py-1 ml-1 badge-status" style="border-radius: 12px; font-size: 11px;">
                                                                <i class="fas fa-check mr-1"></i>Approved
                                                            </span>
                                                        @elseif($status === 'rejected')
                                                            <span class="badge badge-danger px-2 py-1 ml-1 badge-status" style="border-radius: 12px; font-size: 11px;">
                                                                <i class="fas fa-times mr-1"></i>Rejected
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>

                                                <!-- Quick Hover Actions -->
                                                <td class="align-middle py-3 px-2 text-right" style="width: 170px;" onclick="event.stopPropagation();">
                                                    <div class="row-actions d-inline-block">
                                                        @if($isAdmin && $status === 'pending')
                                                            <button type="button" class="btn btn-xs btn-success quick-approve-btn mr-1"
                                                                    data-id="{{ $notification->id }}" title="One-click Approve">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-xs btn-danger quick-reject-btn mr-1"
                                                                    data-id="{{ $notification->id }}" title="One-click Reject">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        @endif
                                                        <button type="button" class="btn btn-xs btn-outline-info preview-row-btn mr-1"
                                                                data-id="{{ $notification->id }}" title="Quick Review">
                                                            <i class="fas fa-eye"></i> Review
                                                        </button>
                                                    </div>
                                                    <span class="text-xs text-muted ml-2">
                                                        {{ $notification->created_at->diffForHumans(null, true) }}
                                                    </span>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    <!-- Footer & Pagination -->
                    @if($notifications->hasPages() || $notifications->count() > 0)
                        <div class="card-footer border-top py-2 px-3 bg-light d-flex justify-content-between align-items-center">
                            <span class="text-xs text-muted">
                                Showing <b>{{ $notifications->firstItem() ?? 0 }}</b> - <b>{{ $notifications->lastItem() ?? 0 }}</b> of <b>{{ $notifications->total() }}</b> notifications
                            </span>
                            <div>
                                {{ $notifications->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    @endif

                </div>
            </div>

        </div>

    </div>
</section>

<!-- Quick Review & Approval Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px; overflow: hidden;">

            <!-- Modal Header -->
            <div class="modal-hero d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="modal-title font-weight-bold mb-1" id="modalTitle">
                        <i class="fas fa-clipboard-check mr-2 text-primary"></i> Request Details
                    </h5>
                    <span class="text-xs opacity-75" id="modalSubtitle">Review request information & take action</span>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge badge-light px-3 py-1 font-weight-bold text-uppercase mr-3" id="modalStatusBadge" style="font-size: 12px; border-radius: 20px;">
                        Pending
                    </span>
                    <button type="button" class="close text-white opacity-75" data-dismiss="modal" aria-label="Close" style="outline: none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-4" id="modalBody">
                <div class="text-center py-5" id="modalLoading">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="text-muted text-sm mt-2">Loading request details...</p>
                </div>

                <div id="modalContent" style="display: none;">
                    <!-- Requester Header Card -->
                    <div class="card bg-light border-0 mb-4" style="border-radius: 10px;">
                        <div class="card-body p-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="mail-avatar mr-3 bg-primary" id="modalUserAvatar">
                                    AD
                                </div>
                                <div>
                                    <h6 class="font-weight-bold mb-0" id="modalUserName">User Name</h6>
                                    <span class="text-xs text-muted" id="modalUserEmail">user@email.com</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-xs text-muted d-block">Submitted At</span>
                                <span class="font-weight-bold text-sm" id="modalCreatedAt">-</span>
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Details Slot -->
                    <div id="modalDynamicFields"></div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer border-top bg-light py-2 px-3 d-flex justify-content-between align-items-center">
                <div>
                    <a href="#" id="modalDirectLink" target="_blank" class="btn btn-outline-secondary btn-sm" style="border-radius: 8px;">
                        <i class="fas fa-external-link-alt mr-1"></i> Open Record Page
                    </a>
                </div>
                <div class="d-flex align-items-center">
                    <!-- Admin Approval Controls -->
                    <div id="modalAdminActions" style="display: none;" class="mr-2">
                        <button type="button" class="btn btn-danger btn-sm mr-2" id="modalRejectBtn" style="border-radius: 8px;">
                            <i class="fas fa-times mr-1"></i> Reject
                        </button>
                        <button type="button" class="btn btn-success btn-sm" id="modalApproveBtn" style="border-radius: 8px;">
                            <i class="fas fa-check mr-1"></i> Approve Request
                        </button>
                    </div>

                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" style="border-radius: 8px;">
                        Close
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let currentNotificationId = null;

        // Toast configuration
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });

        // ==========================================
        // 1. SELECT ALL & BULK ACTIONS
        // ==========================================
        const checkAll = document.getElementById('checkAll');
        const mailChecks = document.querySelectorAll('.mail-select');
        const bulkGroup = document.getElementById('bulkActionsGroup');
        const countText = document.getElementById('selectedCountText');

        function updateBulkUI() {
            const checked = document.querySelectorAll('.mail-select:checked');
            const total = mailChecks.length;
            if (checked.length > 0) {
                bulkGroup.style.display = 'inline-flex';
                countText.textContent = `${checked.length} selected`;
                if (checkAll) checkAll.checked = (checked.length === total);
            } else {
                bulkGroup.style.display = 'none';
                countText.textContent = '';
                if (checkAll) checkAll.checked = false;
            }
        }

        if (checkAll) {
            checkAll.addEventListener('change', function () {
                mailChecks.forEach(cb => cb.checked = checkAll.checked);
                updateBulkUI();
            });
        }

        mailChecks.forEach(cb => {
            cb.addEventListener('change', updateBulkUI);
        });

        // Bulk Action Dispatcher
        function executeBulkAction(action) {
            const selectedIds = Array.from(document.querySelectorAll('.mail-select:checked')).map(cb => cb.value);
            if (selectedIds.length === 0) return;

            if (action === 'delete') {
                Swal.fire({
                    title: 'Delete Selected?',
                    text: `Are you sure you want to delete ${selectedIds.length} notification(s)?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Yes, delete'
                }).then((result) => {
                    if (result.isConfirmed) {
                        sendBulkRequest(action, selectedIds);
                    }
                });
            } else {
                sendBulkRequest(action, selectedIds);
            }
        }

        function sendBulkRequest(action, ids) {
            fetch('{{ route("notifications.bulkAction") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ action: action, ids: ids })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Toast.fire({ icon: 'success', title: data.message });
                    setTimeout(() => window.location.reload(), 800);
                } else {
                    Toast.fire({ icon: 'error', title: data.message || 'Operation failed' });
                }
            })
            .catch(err => console.error(err));
        }

        document.getElementById('bulkMarkReadBtn')?.addEventListener('click', () => executeBulkAction('mark_read'));
        document.getElementById('bulkMarkUnreadBtn')?.addEventListener('click', () => executeBulkAction('mark_unread'));
        document.getElementById('bulkStarBtn')?.addEventListener('click', () => executeBulkAction('star'));
        document.getElementById('bulkDeleteBtn')?.addEventListener('click', () => executeBulkAction('delete'));

        // Refresh Button
        document.getElementById('refreshBtn')?.addEventListener('click', function () {
            const icon = document.getElementById('refreshIcon');
            icon.classList.add('fa-spin');
            window.location.reload();
        });

        // Top Mark All Read
        document.getElementById('topMarkAllReadBtn')?.addEventListener('click', function () {
            fetch('{{ route("notifications.markAllRead") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    Toast.fire({ icon: 'success', title: 'All marked as read' });
                    setTimeout(() => window.location.reload(), 600);
                }
            });
        });

        // ==========================================
        // 2. STAR / PIN TOGGLE
        // ==========================================
        document.querySelectorAll('.star-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                const notifId = this.dataset.id;
                fetch(`/notifications/toggle-star/${notifId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        this.classList.toggle('starred', data.starred);
                        const starIcon = this.querySelector('i');
                        if (data.starred) {
                            starIcon.className = 'fas fa-star';
                        } else {
                            starIcon.className = 'far fa-star';
                        }
                    }
                });
            });
        });

        // ==========================================
        // 3. ROW CLICK & QUICK REVIEW MODAL
        // ==========================================
        function openReviewModal(notificationId) {
            currentNotificationId = notificationId;
            $('#reviewModal').modal('show');

            document.getElementById('modalLoading').style.display = 'block';
            document.getElementById('modalContent').style.display = 'none';

            fetch(`/inbox/detail/${notificationId}`)
                .then(res => res.json())
                .then(data => {
                    renderModalDetails(data);
                    // Mark as read in DOM
                    const row = document.querySelector(`.mail-row[data-id="${notificationId}"]`);
                    if (row) {
                        row.classList.remove('unread');
                        row.classList.add('read');
                    }
                })
                .catch(err => {
                    document.getElementById('modalLoading').innerHTML = `
                        <div class="text-danger py-4">
                            <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                            <p>Unable to load request details.</p>
                        </div>
                    `;
                });
        }

        document.querySelectorAll('.mail-row').forEach(row => {
            row.addEventListener('click', function () {
                openReviewModal(this.dataset.id);
            });
        });

        document.querySelectorAll('.preview-row-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                openReviewModal(this.dataset.id);
            });
        });

        // Render dynamic content inside modal
        function renderModalDetails(data) {
            document.getElementById('modalLoading').style.display = 'none';
            document.getElementById('modalContent').style.display = 'block';

            const n = data.notification;
            const status = (data.status || 'pending').toLowerCase();

            // Set Title & Status
            document.getElementById('modalTitle').innerHTML = `<i class="${n.icon || 'fas fa-bell'} mr-2"></i> ${n.type || 'Notification'}`;
            document.getElementById('modalSubtitle').textContent = n.message;

            const badge = document.getElementById('modalStatusBadge');
            badge.textContent = status.toUpperCase();
            badge.className = 'badge px-3 py-1 font-weight-bold text-uppercase mr-3';
            if (status === 'approved') badge.classList.add('badge-success');
            else if (status === 'rejected') badge.classList.add('badge-danger');
            else badge.classList.add('badge-warning', 'text-dark');

            // User Info
            const sender = n.user?.name || n.admin?.name || 'School System';
            document.getElementById('modalUserName').textContent = sender;
            document.getElementById('modalUserEmail').textContent = n.user?.email || 'N/A';
            document.getElementById('modalUserAvatar').textContent = sender.substring(0, 2).toUpperCase();
            document.getElementById('modalCreatedAt').textContent = new Date(n.created_at).toLocaleString();

            // Direct link
            const directLink = document.getElementById('modalDirectLink');
            if (data.action_url && data.action_url !== '#') {
                directLink.href = data.action_url;
                directLink.style.display = 'inline-block';
            } else {
                directLink.style.display = 'none';
            }

            // Show/Hide Admin Action Buttons
            const adminActions = document.getElementById('modalAdminActions');
            if (data.can_approve) {
                adminActions.style.display = 'inline-flex';
            } else {
                adminActions.style.display = 'none';
            }

            // Build Entity Specific HTML
            const dynamicFields = document.getElementById('modalDynamicFields');
            let html = '';

            // --- PURCHASE REQUEST ---
            if (data.target_type === 'purchase_request' && data.item) {
                const p = data.item;
                html += `
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <span class="text-xs text-muted">Requisitioner</span>
                            <div class="font-weight-bold">${p.requisitioner || 'N/A'}</div>
                        </div>
                        <div class="col-sm-4">
                            <span class="text-xs text-muted">Department</span>
                            <div class="font-weight-bold">${p.department || 'General'}</div>
                        </div>
                        <div class="col-sm-4">
                            <span class="text-xs text-muted">Total Budget</span>
                            <div class="font-weight-bold text-success font-size-lg">$${parseFloat(p.total || 0).toFixed(2)}</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <span class="text-xs text-muted">Date Needed</span>
                            <div>${p.date_needed || 'As soon as possible'}</div>
                        </div>
                        <div class="col-sm-8">
                            <span class="text-xs text-muted">Purpose</span>
                            <div>${p.purpose || 'Not specified'}</div>
                        </div>
                    </div>
                `;

                if (data.items_list && data.items_list.length > 0) {
                    html += `
                        <h6 class="font-weight-bold mt-3 mb-2 text-xs text-uppercase text-muted">Requested Items Breakdown</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Description</th>
                                        <th class="text-center" width="70">Qty</th>
                                        <th class="text-right" width="100">Unit Price</th>
                                        <th class="text-right" width="110">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;
                    data.items_list.forEach(item => {
                        html += `
                            <tr>
                                <td>${item.description || 'Item'}</td>
                                <td class="text-center">${item.qty || 1}</td>
                                <td class="text-right">$${parseFloat(item.unit_price || 0).toFixed(2)}</td>
                                <td class="text-right font-weight-bold">$${parseFloat(item.total_price || 0).toFixed(2)}</td>
                            </tr>
                        `;
                    });
                    html += `</tbody></table></div>`;
                }
            }
            // --- FEE RECEIPT ---
            else if (data.target_type === 'fee_receipt' && data.item) {
                const f = data.item;
                const stu = data.student_info || {};
                html += `
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <span class="text-xs text-muted">Student Name</span>
                            <div class="font-weight-bold">${stu.student_name || 'N/A'} (Roll #${stu.roll || 'N/A'})</div>
                        </div>
                        <div class="col-sm-4">
                            <span class="text-xs text-muted">Class & Section</span>
                            <div class="font-weight-bold">${stu.class_name || 'Class'} - ${stu.section_name || 'Section'}</div>
                        </div>
                        <div class="col-sm-4">
                            <span class="text-xs text-muted">Paid Amount</span>
                            <div class="font-weight-bold text-success font-size-lg">$${parseFloat(f.paid || 0).toFixed(2)}</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <span class="text-xs text-muted">Receipt Number</span>
                            <div>${f.receipt_no || 'N/A'}</div>
                        </div>
                        <div class="col-sm-4">
                            <span class="text-xs text-muted">Receipt Date</span>
                            <div>${f.date || 'N/A'}</div>
                        </div>
                        <div class="col-sm-4">
                            <span class="text-xs text-muted">Paid Via</span>
                            <div>${f.paid_via || 'Cash'}</div>
                        </div>
                    </div>
                `;

                if (data.items_list && data.items_list.length > 0) {
                    html += `
                        <h6 class="font-weight-bold mt-3 mb-2 text-xs text-uppercase text-muted">Fee Items Breakdown</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Description</th>
                                        <th class="text-center" width="70">Qty</th>
                                        <th class="text-right" width="100">Price</th>
                                        <th class="text-right" width="110">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;
                    data.items_list.forEach(item => {
                        html += `
                            <tr>
                                <td>${item.description || 'Fee'}</td>
                                <td class="text-center">${item.qty || 1}</td>
                                <td class="text-right">$${parseFloat(item.price || 0).toFixed(2)}</td>
                                <td class="text-right font-weight-bold">$${parseFloat(item.total || 0).toFixed(2)}</td>
                            </tr>
                        `;
                    });
                    html += `</tbody></table></div>`;
                }
            }
            // --- ADMISSION ---
            else if (data.target_type === 'admission' && data.item) {
                const a = data.item;
                html += `
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <span class="text-xs text-muted">Applicant Full Name</span>
                            <div class="font-weight-bold font-size-lg">${a.full_name || 'N/A'}</div>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-xs text-muted">Desired Course</span>
                            <div class="font-weight-bold text-primary">${a.course || 'General'}</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <span class="text-xs text-muted">Email</span>
                            <div>${a.email || 'N/A'}</div>
                        </div>
                        <div class="col-sm-4">
                            <span class="text-xs text-muted">Phone Number</span>
                            <div>${a.phone || 'N/A'}</div>
                        </div>
                        <div class="col-sm-4">
                            <span class="text-xs text-muted">Country</span>
                            <div>${a.country || 'N/A'}</div>
                        </div>
                    </div>
                `;
            }
            // --- ATTENDANCE REQUEST ---
            else if (data.target_type === 'attendance_request' && data.item) {
                const att = data.item;
                html += `
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <span class="text-xs text-muted">Teacher</span>
                            <div class="font-weight-bold">${data.teacher_name || 'Teacher'}</div>
                        </div>
                        <div class="col-sm-4">
                            <span class="text-xs text-muted">Class & Section</span>
                            <div class="font-weight-bold">${data.class_name || 'Class'} (${data.section_name || 'Section'})</div>
                        </div>
                        <div class="col-sm-4">
                            <span class="text-xs text-muted">Attendance Date</span>
                            <div class="font-weight-bold text-primary">${att.date || 'N/A'}</div>
                        </div>
                    </div>
                    <div class="p-3 bg-light rounded">
                        <span class="text-xs text-muted d-block mb-1">Reason for Edit Request:</span>
                        <div class="font-italic text-dark">"${att.reason || 'No specific reason given'}"</div>
                    </div>
                `;
            }
            // --- GENERAL FALLBACK ---
            else {
                html += `
                    <div class="p-3 bg-light rounded text-center">
                        <p class="mb-0 text-dark font-weight-500">${n.message}</p>
                    </div>
                `;
            }

            dynamicFields.innerHTML = html;
        }

        // ==========================================
        // 4. ADMIN APPROVE & REJECT ACTIONS
        // ==========================================
        function handleDecision(notificationId, action) {
            const actionText = action === 'approve' ? 'Approve' : 'Reject';
            const actionColor = action === 'approve' ? '#10b981' : '#ef4444';

            Swal.fire({
                title: `${actionText} Request?`,
                text: `Are you sure you want to ${action} this request? This will update records and send a notification to the requester.`,
                icon: action === 'approve' ? 'question' : 'warning',
                showCancelButton: true,
                confirmButtonColor: actionColor,
                cancelButtonColor: '#6b7280',
                confirmButtonText: `Yes, ${actionText}`
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.showLoading();
                    fetch('{{ route("inbox.quickAction") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            notification_id: notificationId,
                            action: action
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: data.message,
                                timer: 1500,
                                showConfirmButton: false
                            });

                            $('#reviewModal').modal('hide');

                            // Update row status badge in table
                            const row = document.querySelector(`.mail-row[data-id="${notificationId}"]`);
                            if (row) {
                                const badge = row.querySelector('.badge-status');
                                if (badge) {
                                    if (action === 'approve') {
                                        badge.className = 'badge badge-success px-2 py-1 ml-1 badge-status';
                                        badge.innerHTML = '<i class="fas fa-check mr-1"></i>Approved';
                                    } else {
                                        badge.className = 'badge badge-danger px-2 py-1 ml-1 badge-status';
                                        badge.innerHTML = '<i class="fas fa-times mr-1"></i>Rejected';
                                    }
                                }
                                // Hide quick buttons
                                const actions = row.querySelector('.quick-approve-btn')?.parentElement;
                                if (actions) {
                                    actions.querySelectorAll('.quick-approve-btn, .quick-reject-btn').forEach(b => b.remove());
                                }
                            }

                            // Trigger global notification update
                            if (typeof fetchNotifications === 'function') {
                                fetchNotifications();
                            }
                        } else {
                            Swal.fire('Error', data.error || 'Failed to process request', 'error');
                        }
                    })
                    .catch(err => {
                        Swal.fire('Error', 'An unexpected error occurred.', 'error');
                    });
                }
            });
        }

        // Modal Action Click Handlers
        document.getElementById('modalApproveBtn')?.addEventListener('click', function () {
            if (currentNotificationId) handleDecision(currentNotificationId, 'approve');
        });

        document.getElementById('modalRejectBtn')?.addEventListener('click', function () {
            if (currentNotificationId) handleDecision(currentNotificationId, 'reject');
        });

        // Inline Row Quick Buttons
        document.querySelectorAll('.quick-approve-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                handleDecision(this.dataset.id, 'approve');
            });
        });

        document.querySelectorAll('.quick-reject-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                handleDecision(this.dataset.id, 'reject');
            });
        });
    });
</script>
@endpush
@endsection
