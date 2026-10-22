@extends('layout.main')

@section('content')
<style>
    .metric-card {
        border-radius: 14px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
        overflow: hidden;
    }
    .metric-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12) !important;
    }
    .metric-card .icon-bg {
        position: absolute;
        right: 15px;
        bottom: 12px;
        font-size: 3.5rem;
        opacity: 0.18;
    }
    .badge-pulse {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #f59e0b;
        margin-right: 6px;
        box-shadow: 0 0 0 rgba(245, 158, 11, 0.7);
        animation: pulse 1.8s infinite;
    }
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7); }
        70% { box-shadow: 0 0 0 8px rgba(245, 158, 11, 0); }
        100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
    }
    .teacher-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 13px;
        color: #fff;
        background: linear-gradient(135deg, #0ea5e9, #3b82f6);
        box-shadow: 0 2px 6px rgba(14, 165, 233, 0.35);
        flex-shrink: 0;
    }
    .request-table th {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        font-weight: 700;
        border-top: none;
        color: #64748b;
    }
    .request-table td {
        vertical-align: middle;
        padding: 0.9rem 0.75rem;
    }
    .modal-hero {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        color: #fff;
        padding: 1.25rem 1.5rem;
    }
    .dark-mode .request-table th {
        color: #94a3b8;
    }
</style>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-3 align-items-center">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">
                    <i class="fas fa-clipboard-check text-info mr-2"></i>Attendance Edit Requests
                </h1>
                <p class="text-muted text-sm mb-0">Manage teacher attendance modification requests, approval status, and messages</p>
            </div>
            <div class="col-sm-6 text-sm-right mt-2 mt-sm-0">
                <a href="{{ route('message.inbox', ['type' => 'attendance_request']) }}" class="btn btn-outline-primary btn-sm px-3 shadow-sm mr-2" style="border-radius: 20px;">
                    <i class="fas fa-inbox mr-1"></i> View in Inbox Approvals
                </a>
                <ol class="breadcrumb float-sm-right bg-transparent p-0 d-inline-block align-middle mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item active">Attendance Requests</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        <!-- Top Metrics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
                <div class="card metric-card shadow-sm border-0 bg-gradient-primary text-white h-100">
                    <div class="card-body p-3">
                        <span class="text-uppercase text-xs font-weight-bold" style="letter-spacing: 0.5px;">All Requests</span>
                        <h2 class="font-weight-bold mt-1 mb-0">{{ number_format($counts['total']) }}</h2>
                        <span class="text-xs opacity-75">Total modification submissions</span>
                        <i class="fas fa-clipboard-list icon-bg text-white"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
                <div class="card metric-card shadow-sm border-0 bg-gradient-warning text-white h-100">
                    <div class="card-body p-3">
                        <span class="text-uppercase text-xs font-weight-bold" style="letter-spacing: 0.5px;">Pending Approval</span>
                        <h2 class="font-weight-bold mt-1 mb-0">
                            {{ number_format($counts['pending']) }}
                            @if($counts['pending'] > 0 && $isAdmin)
                                <span class="badge badge-danger text-xs align-middle ml-2" style="font-size: 11px;">Requires Action</span>
                            @endif
                        </h2>
                        <span class="text-xs opacity-75">Awaiting administrator review</span>
                        <i class="fas fa-hourglass-half icon-bg text-white"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
                <div class="card metric-card shadow-sm border-0 bg-gradient-success text-white h-100">
                    <div class="card-body p-3">
                        <span class="text-uppercase text-xs font-weight-bold" style="letter-spacing: 0.5px;">Approved</span>
                        <h2 class="font-weight-bold mt-1 mb-0">{{ number_format($counts['approved']) }}</h2>
                        <span class="text-xs opacity-75">Unlocked for teacher editing</span>
                        <i class="fas fa-check-circle icon-bg text-white"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card metric-card shadow-sm border-0 bg-gradient-info text-white h-100">
                    <div class="card-body p-3">
                        <span class="text-uppercase text-xs font-weight-bold" style="letter-spacing: 0.5px;">Rejected / Done</span>
                        <h2 class="font-weight-bold mt-1 mb-0">{{ number_format($counts['rejected'] + $counts['completed']) }}</h2>
                        <span class="text-xs opacity-75">Processed requests</span>
                        <i class="fas fa-archive icon-bg text-white"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Requests Card -->
        <div class="card shadow-sm border-0" style="border-radius: 14px; overflow: hidden;">

            <!-- Header with Tabs & Search -->
            <div class="card-header border-bottom py-3 px-3">
                <div class="row align-items-center">

                    <!-- Filter Tabs -->
                    <div class="col-md-7 mb-2 mb-md-0">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link py-1 px-3 {{ $tab === 'all' ? 'active' : '' }}" href="{{ route('attendance.requestList', ['tab' => 'all']) }}">
                                    All <span class="badge badge-light ml-1">{{ $counts['total'] }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-1 px-3 {{ $tab === 'pending' ? 'active' : '' }}" href="{{ route('attendance.requestList', ['tab' => 'pending']) }}">
                                    Pending <span class="badge badge-warning text-white ml-1">{{ $counts['pending'] }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-1 px-3 {{ $tab === 'approved' ? 'active' : '' }}" href="{{ route('attendance.requestList', ['tab' => 'approved']) }}">
                                    Approved <span class="badge badge-success ml-1">{{ $counts['approved'] }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-1 px-3 {{ $tab === 'rejected' ? 'active' : '' }}" href="{{ route('attendance.requestList', ['tab' => 'rejected']) }}">
                                    Rejected <span class="badge badge-danger ml-1">{{ $counts['rejected'] }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Search Input -->
                    <div class="col-md-5">
                        <form method="GET" action="{{ route('attendance.requestList') }}">
                            @if($tab !== 'all')
                                <input type="hidden" name="tab" value="{{ $tab }}">
                            @endif
                            <div class="input-group input-group-sm">
                                <input type="text" name="search" class="form-control" placeholder="Search teacher, class, date, reason..." value="{{ $search ?? '' }}" style="border-radius: 20px 0 0 20px;">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit" style="border-radius: 0 20px 20px 0;">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

            <!-- Body: Table or Empty State -->
            <div class="card-body p-0">
                @if($requests->isEmpty())
                    <div class="text-center py-5 px-3">
                        <div class="mb-3">
                            <span class="btn btn-light btn-circle p-3" style="width: 70px; height: 70px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; background: rgba(14, 165, 233, 0.1);">
                                <i class="fas fa-calendar-check fa-3x text-info opacity-50"></i>
                            </span>
                        </div>
                        <h5 class="font-weight-bold mb-1">No attendance requests found</h5>
                        <p class="text-muted text-sm mb-3">
                            @if($search)
                                No records matched your search query "{{ $search }}".
                            @elseif($tab === 'pending')
                                Great job! There are no pending attendance edit requests awaiting approval.
                            @else
                                There are no attendance requests in this view.
                            @endif
                        </p>
                        @if($search || $tab !== 'all')
                            <a href="{{ route('attendance.requestList') }}" class="btn btn-info btn-sm px-3" style="border-radius: 20px;">
                                <i class="fas fa-arrow-left mr-1"></i> View All Requests
                            </a>
                        @endif
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover request-table mb-0">
                            <thead>
                                <tr class="bg-light">
                                    <th style="width: 250px;">Teacher</th>
                                    <th>Class & Section</th>
                                    <th>Target Date</th>
                                    <th>Reason for Edit</th>
                                    <th>Status</th>
                                    <th class="text-right" style="width: 190px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($requests as $req)
                                    @php
                                        $initials = strtoupper(substr($req->teacher_name ?? 'TE', 0, 2));
                                        $statusSlug = strtolower($req->status);
                                    @endphp
                                    <tr id="req-row-{{ $req->id }}">
                                        <!-- Teacher Info -->
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="teacher-avatar mr-2">
                                                    {{ $initials }}
                                                </div>
                                                <div>
                                                    <div class="font-weight-bold text-dark">{{ $req->teacher_name }}</div>
                                                    <span class="text-xs text-muted">{{ $req->teacher_email ?? 'Teacher' }}</span>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Class & Section -->
                                        <td>
                                            <span class="badge badge-light border px-2 py-1 font-weight-bold" style="border-radius: 6px;">
                                                <i class="fas fa-chalkboard text-info mr-1"></i> {{ $req->class_name }}
                                            </span>
                                            <span class="badge badge-secondary px-2 py-1 ml-1" style="border-radius: 6px;">
                                                {{ $req->section_name }}
                                            </span>
                                        </td>

                                        <!-- Date -->
                                        <td>
                                            <span class="text-dark font-weight-500">
                                                <i class="far fa-calendar-alt text-primary mr-1"></i> {{ \Carbon\Carbon::parse($req->date)->format('M d, Y') }}
                                            </span>
                                        </td>

                                        <!-- Reason -->
                                        <td>
                                            <span class="text-truncate d-inline-block text-muted" style="max-width: 300px;" title="{{ $req->reason }}">
                                                "{{ $req->reason }}"
                                            </span>
                                        </td>

                                        <!-- Status Badge -->
                                        <td>
                                            <span class="badge status-pill px-2 py-1 badge-{{ $statusSlug === 'pending' ? 'warning' : ($statusSlug === 'approved' ? 'success' : ($statusSlug === 'completed' ? 'primary' : 'danger')) }}" style="border-radius: 12px; font-size: 11px;">
                                                @if($statusSlug === 'pending')
                                                    <span class="badge-pulse"></span>Pending Approval
                                                @elseif($statusSlug === 'approved')
                                                    <i class="fas fa-check mr-1"></i>Approved
                                                @elseif($statusSlug === 'completed')
                                                    <i class="fas fa-check-double mr-1"></i>Completed
                                                @else
                                                    <i class="fas fa-times mr-1"></i>Rejected
                                                @endif
                                            </span>
                                        </td>

                                        <!-- Actions -->
                                        <td class="text-right">
                                            <div class="btn-group">
                                                @if($isAdmin && $statusSlug === 'pending')
                                                    <button type="button" class="btn btn-xs btn-success quick-approve-btn mr-1 shadow-sm"
                                                            data-id="{{ $req->id }}" title="One-click Approve">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-xs btn-danger quick-reject-btn mr-1 shadow-sm"
                                                            data-id="{{ $req->id }}" title="One-click Reject">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                @endif

                                                <button type="button" class="btn btn-xs btn-outline-info review-btn mr-1 shadow-sm"
                                                        data-id="{{ $req->id }}"
                                                        data-teacher="{{ $req->teacher_name }}"
                                                        data-email="{{ $req->teacher_email ?? 'Teacher' }}"
                                                        data-class="{{ $req->class_name }}"
                                                        data-section="{{ $req->section_name }}"
                                                        data-date="{{ \Carbon\Carbon::parse($req->date)->format('M d, Y') }}"
                                                        data-reason="{{ $req->reason }}"
                                                        data-status="{{ $req->status }}"
                                                        title="Review Request Details">
                                                    <i class="fas fa-eye"></i> Review
                                                </button>

                                                @if(!empty($req->notification_id))
                                                    <a href="{{ route('message.inbox') }}" class="btn btn-xs btn-outline-secondary shadow-sm" title="Open in Inbox">
                                                        <i class="fas fa-inbox"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- Footer Pagination -->
            @if($requests->hasPages() || $requests->count() > 0)
                <div class="card-footer border-top py-2 px-3 bg-light d-flex justify-content-between align-items-center">
                    <span class="text-xs text-muted">
                        Showing <b>{{ $requests->firstItem() ?? 0 }}</b> - <b>{{ $requests->lastItem() ?? 0 }}</b> of <b>{{ $requests->total() }}</b> requests
                    </span>
                    <div>
                        {{ $requests->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            @endif

        </div>

    </div>
</section>

<!-- Review Modal -->
<div class="modal fade" id="attendanceReviewModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px; overflow: hidden;">

            <!-- Header -->
            <div class="modal-hero d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="modal-title font-weight-bold mb-1">
                        <i class="fas fa-clipboard-check text-info mr-2"></i> Attendance Request Review
                    </h5>
                    <span class="text-xs opacity-75">Review teacher modification justification</span>
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

            <!-- Body -->
            <div class="modal-body p-4">
                <!-- Teacher Profile Card -->
                <div class="card bg-light border-0 mb-3" style="border-radius: 10px;">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="teacher-avatar mr-3" id="modalAvatar">
                            TE
                        </div>
                        <div>
                            <h6 class="font-weight-bold mb-0" id="modalTeacherName">Teacher Name</h6>
                            <span class="text-xs text-muted" id="modalTeacherEmail">teacher@mail.com</span>
                        </div>
                    </div>
                </div>

                <!-- Request Parameters -->
                <div class="row mb-3">
                    <div class="col-6">
                        <span class="text-xs text-muted">Class & Section</span>
                        <div class="font-weight-bold" id="modalClassSection">-</div>
                    </div>
                    <div class="col-6">
                        <span class="text-xs text-muted">Attendance Date</span>
                        <div class="font-weight-bold text-primary" id="modalDate">-</div>
                    </div>
                </div>

                <!-- Justification Callout -->
                <div class="p-3 bg-light rounded mb-3 border-left" style="border-left: 4px solid #0ea5e9 !important; border-radius: 8px;">
                    <span class="text-xs text-uppercase text-muted font-weight-bold d-block mb-1">Teacher's Reason / Justification</span>
                    <p class="mb-0 text-dark font-italic" id="modalReason" style="font-size: 13.5px;"></p>
                </div>

                <div class="text-center">
                    <a href="{{ route('message.inbox', ['type' => 'attendance_request']) }}" class="text-xs text-info">
                        <i class="fas fa-inbox mr-1"></i> View related messages in Inbox & Approvals
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer border-top bg-light py-2 px-3 d-flex justify-content-between">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" style="border-radius: 8px;">
                    Close
                </button>
                <div id="modalAdminButtons" style="display: none;">
                    <button type="button" class="btn btn-danger btn-sm mr-2" id="modalRejectBtn" style="border-radius: 8px;">
                        <i class="fas fa-times mr-1"></i> Reject
                    </button>
                    <button type="button" class="btn btn-success btn-sm" id="modalApproveBtn" style="border-radius: 8px;">
                        <i class="fas fa-check mr-1"></i> Approve Request
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
        let activeModalRequestId = null;

        // Toast configuration
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });

        // 1. OPEN REVIEW MODAL
        document.querySelectorAll('.review-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const data = this.dataset;
                activeModalRequestId = data.id;

                document.getElementById('modalTeacherName').textContent = data.teacher;
                document.getElementById('modalTeacherEmail').textContent = data.email;
                document.getElementById('modalAvatar').textContent = data.teacher.substring(0, 2).toUpperCase();
                document.getElementById('modalClassSection').textContent = `${data.class} (${data.section})`;
                document.getElementById('modalDate').textContent = data.date;
                document.getElementById('modalReason').textContent = `"${data.reason}"`;

                const badge = document.getElementById('modalStatusBadge');
                const status = (data.status || 'Pending').toLowerCase();
                badge.textContent = data.status;

                if (status === 'pending') {
                    badge.className = 'badge badge-warning text-white px-3 py-1 font-weight-bold text-uppercase mr-3';
                    document.getElementById('modalAdminButtons').style.display = 'block';
                } else if (status === 'approved') {
                    badge.className = 'badge badge-success px-3 py-1 font-weight-bold text-uppercase mr-3';
                    document.getElementById('modalAdminButtons').style.display = 'none';
                } else {
                    badge.className = 'badge badge-danger px-3 py-1 font-weight-bold text-uppercase mr-3';
                    document.getElementById('modalAdminButtons').style.display = 'none';
                }

                $('#attendanceReviewModal').modal('show');
            });
        });

        // 2. APPROVE / REJECT DECISION HANDLER
        function handleAttendanceDecision(requestId, actionStatus) {
            const actionText = actionStatus === 'Approved' ? 'Approve' : 'Reject';
            const actionColor = actionStatus === 'Approved' ? '#10b981' : '#ef4444';

            Swal.fire({
                title: `${actionText} Request?`,
                text: `Are you sure you want to ${actionText.toLowerCase()} this attendance edit request? This will update records and send a message notification to the teacher.`,
                icon: actionStatus === 'Approved' ? 'question' : 'warning',
                showCancelButton: true,
                confirmButtonColor: actionColor,
                cancelButtonColor: '#6b7280',
                confirmButtonText: `Yes, ${actionText}`
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.showLoading();

                    fetch(`/attendance/edit-request/${requestId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            _method: 'PUT',
                            status: actionStatus
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

                            $('#attendanceReviewModal').modal('hide');

                            // Live update row UI
                            const row = document.getElementById(`req-row-${requestId}`);
                            if (row) {
                                const pill = row.querySelector('.status-pill');
                                if (pill) {
                                    if (actionStatus === 'Approved') {
                                        pill.className = 'badge status-pill px-2 py-1 badge-success';
                                        pill.innerHTML = '<i class="fas fa-check mr-1"></i>Approved';
                                    } else {
                                        pill.className = 'badge status-pill px-2 py-1 badge-danger';
                                        pill.innerHTML = '<i class="fas fa-times mr-1"></i>Rejected';
                                    }
                                }

                                // Remove quick approve/reject buttons
                                row.querySelectorAll('.quick-approve-btn, .quick-reject-btn').forEach(b => b.remove());

                                // Update review button dataset
                                const revBtn = row.querySelector('.review-btn');
                                if (revBtn) revBtn.dataset.status = actionStatus;
                            }

                            // Refresh global navbar notifications count if function exists
                            if (typeof fetchNotifications === 'function') {
                                fetchNotifications();
                            }
                        } else {
                            Swal.fire('Error', data.message || 'Failed to update request', 'error');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        Swal.fire('Error', 'An unexpected network error occurred.', 'error');
                    });
                }
            });
        }

        // Inline Row Buttons
        document.querySelectorAll('.quick-approve-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                handleAttendanceDecision(this.dataset.id, 'Approved');
            });
        });

        document.querySelectorAll('.quick-reject-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                handleAttendanceDecision(this.dataset.id, 'Rejected');
            });
        });

        // Modal Buttons
        document.getElementById('modalApproveBtn')?.addEventListener('click', function () {
            if (activeModalRequestId) handleAttendanceDecision(activeModalRequestId, 'Approved');
        });

        document.getElementById('modalRejectBtn')?.addEventListener('click', function () {
            if (activeModalRequestId) handleAttendanceDecision(activeModalRequestId, 'Rejected');
        });
    });
</script>
@endpush
@endsection
