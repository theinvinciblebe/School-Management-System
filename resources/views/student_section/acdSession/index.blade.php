@extends('layout.main')

@section('title', __('Academic Sessions & Semesters'))

@section('content')

<style>
/* ══════════════════════════════════════════════════════════════════
   ACADEMIC SESSIONS – Executive SaaS Design System
══════════════════════════════════════════════════════════════════ */
.session-dashboard-wrapper {
    padding: 0.5rem 0.25rem 2.5rem;
}

/* Header Box */
.session-header-box {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.25rem;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.04);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    position: relative;
    overflow: hidden;
}
.session-header-box::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 5px;
    height: 100%;
    background: linear-gradient(180deg, #6366f1, #3b82f6);
}
html.dark-mode .session-header-box {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 24px -2px rgba(0, 0, 0, 0.35);
}

.session-header-title {
    font-size: 1.35rem;
    font-weight: 800;
    margin-bottom: 0.2rem;
    display: flex;
    align-items: center;
    gap: 0.65rem;
    color: #1e293b;
}
html.dark-mode .session-header-title {
    color: #f8fafc;
}

.session-header-subtitle {
    font-size: 0.85rem;
    color: #64748b;
    margin: 0;
}
html.dark-mode .session-header-subtitle {
    color: #94a3b8;
}

.session-action-group {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    flex-wrap: wrap;
}

.btn-session {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.55rem 1.15rem;
    border-radius: 10px;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none !important;
    transition: all 0.2s ease;
    border: 1px solid transparent;
}
.btn-session-primary {
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25);
}
.btn-session-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(99, 102, 241, 0.35);
    background: linear-gradient(135deg, #4f46e5, #4338ca);
}
.btn-session-secondary {
    background: #f1f5f9;
    color: #334155 !important;
    border-color: #cbd5e1;
}
.btn-session-secondary:hover {
    background: #e2e8f0;
    color: #0f172a !important;
}
html.dark-mode .btn-session-secondary {
    background: #282f48;
    color: #e2e8f0 !important;
    border-color: #3b4261;
}
html.dark-mode .btn-session-secondary:hover {
    background: #333c5e;
}

/* KPI Cards Grid */
.session-kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem;
    margin-bottom: 1.25rem;
}

.session-kpi-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 1.15rem 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.session-kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
}
html.dark-mode .session-kpi-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.25);
}

.session-kpi-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}
.kpi-indigo  { background: rgba(99, 102, 241, 0.12); color: #6366f1; }
.kpi-emerald { background: rgba(16, 185, 129, 0.12); color: #10b981; }
.kpi-slate   { background: rgba(100, 116, 139, 0.12); color: #64748b; }
.kpi-sky     { background: rgba(14, 165, 233, 0.12); color: #0ea5e9; }

.session-kpi-value {
    font-size: 1.55rem;
    font-weight: 800;
    line-height: 1.1;
    color: #0f172a;
}
html.dark-mode .session-kpi-value {
    color: #f8fafc;
}
.session-kpi-label {
    font-size: 0.78rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: #64748b;
    margin-top: 0.15rem;
}
html.dark-mode .session-kpi-label {
    color: #94a3b8;
}

/* Main Table Card */
.session-main-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.04);
}
html.dark-mode .session-main-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 24px -2px rgba(0, 0, 0, 0.35);
}

.session-toolbar {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.85rem;
    background: #f8fafc;
}
html.dark-mode .session-toolbar {
    background: #191c2b;
    border-color: #2e354f;
}

.session-filter-tabs {
    display: flex;
    align-items: center;
    gap: 0.35rem;
    background: #e2e8f0;
    padding: 0.25rem;
    border-radius: 10px;
}
html.dark-mode .session-filter-tabs {
    background: #252a3d;
}
.session-filter-pill {
    padding: 0.35rem 0.85rem;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 600;
    color: #64748b;
    background: transparent;
    border: none;
    cursor: pointer;
    transition: all 0.15s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
}
.session-filter-pill:hover {
    color: #1e293b;
}
.session-filter-pill.active {
    background: #ffffff;
    color: #4f46e5;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
}
html.dark-mode .session-filter-pill {
    color: #94a3b8;
}
html.dark-mode .session-filter-pill.active {
    background: #1e2235;
    color: #a5b4fc;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
}
.session-filter-count {
    font-size: 0.72rem;
    padding: 0.1rem 0.4rem;
    border-radius: 10px;
    background: rgba(100, 116, 139, 0.15);
}
.session-filter-pill.active .session-filter-count {
    background: rgba(99, 102, 241, 0.15);
}

.session-search-box {
    position: relative;
    min-width: 250px;
    max-width: 380px;
    flex: 1;
}
.session-search-input {
    width: 100%;
    padding: 0.45rem 1rem 0.45rem 2.25rem;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 0.875rem;
    background: #ffffff;
    color: #1e293b;
    transition: all 0.2s;
}
.session-search-input:focus {
    outline: none;
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
}
html.dark-mode .session-search-input {
    background: #252a3d;
    border-color: #3b4261;
    color: #f1f5f9;
}
.session-search-icon {
    position: absolute;
    left: 0.8rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.85rem;
    pointer-events: none;
}

/* Modern Table */
.session-table {
    margin: 0;
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}
.session-table thead th {
    background: #f8fafc;
    color: #475569;
    font-size: 0.78rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 0.85rem 1rem;
    border-top: none;
    border-bottom: 1px solid #e2e8f0;
    white-space: nowrap;
}
html.dark-mode .session-table thead th {
    background: #191c2b;
    color: #94a3b8;
    border-color: #2e354f;
}
.session-table tbody td {
    padding: 0.95rem 1rem;
    vertical-align: middle;
    border-top: none;
    border-bottom: 1px solid #f1f5f9;
    font-size: 0.88rem;
    color: #334155;
}
html.dark-mode .session-table tbody td {
    border-color: #262c44;
    color: #cbd5e1;
}
.session-table tbody tr:hover {
    background: #f8fafc;
}
html.dark-mode .session-table tbody tr:hover {
    background: #22273c;
}

/* Session Icon & Badge */
.session-avatar {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
    color: #4338ca;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.05rem;
    flex-shrink: 0;
}
html.dark-mode .session-avatar {
    background: linear-gradient(135deg, #3730a3, #4338ca);
    color: #e0e7ff;
}

.session-name {
    font-weight: 700;
    color: #0f172a;
    font-size: 0.92rem;
    line-height: 1.2;
}
html.dark-mode .session-name {
    color: #f8fafc;
}

.status-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.25rem 0.65rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
}
.status-open {
    background: rgba(16, 185, 129, 0.12);
    color: #059669;
    border: 1px solid rgba(16, 185, 129, 0.25);
}
html.dark-mode .status-open {
    background: rgba(16, 185, 129, 0.2);
    color: #34d399;
}
.status-closed {
    background: rgba(100, 116, 139, 0.12);
    color: #64748b;
    border: 1px solid rgba(100, 116, 139, 0.25);
}
html.dark-mode .status-closed {
    background: rgba(100, 116, 139, 0.2);
    color: #cbd5e1;
}

.pulse-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    display: inline-block;
}
.pulse-dot-green { background: #10b981; box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.3); animation: pulseGreen 1.8s infinite; }
.pulse-dot-slate { background: #94a3b8; }
@keyframes pulseGreen {
    0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.5); }
    70% { transform: scale(1.05); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
    100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
}

.date-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.8rem;
    color: #475569;
    background: #f1f5f9;
    padding: 0.2rem 0.55rem;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
}
html.dark-mode .date-pill {
    background: #252a3d;
    color: #94a3b8;
    border-color: #3b4261;
}

.duration-tag {
    font-size: 0.75rem;
    font-weight: 600;
    color: #6366f1;
    background: rgba(99, 102, 241, 0.08);
    border: 1px solid rgba(99, 102, 241, 0.2);
    padding: 0.15rem 0.5rem;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
}
html.dark-mode .duration-tag {
    background: rgba(99, 102, 241, 0.18);
    color: #a5b4fc;
}

/* Action Icon Buttons */
.session-actions-group {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 0.35rem;
}
.btn-action-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #e2e8f0;
    transition: all 0.15s ease;
    font-size: 0.8rem;
    text-decoration: none !important;
    cursor: pointer;
}
.btn-action-icon:hover { transform: translateY(-1px); }
.btn-action-edit:hover { background: #fef3c7; color: #d97706; border-color: #fde68a; }
.btn-action-delete:hover { background: #fee2e2; color: #dc2626; border-color: #fca5a5; }

html.dark-mode .btn-action-icon {
    background: #252a3d;
    border-color: #3b4261;
    color: #94a3b8;
}
html.dark-mode .btn-action-edit:hover { background: #b45309; color: #ffffff; }
html.dark-mode .btn-action-delete:hover { background: #b91c1c; color: #ffffff; }

/* Modals */
.session-modal .modal-content {
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}
html.dark-mode .session-modal .modal-content {
    background: #1e2235;
    border-color: #2e354f;
    color: #f1f5f9;
}
.session-modal .modal-header {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 1.15rem 1.5rem;
}
html.dark-mode .session-modal .modal-header {
    background: #191c2b;
    border-color: #2e354f;
}
.session-modal .modal-footer {
    border-top: 1px solid #e2e8f0;
    background: #f8fafc;
    padding: 0.95rem 1.5rem;
}
html.dark-mode .session-modal .modal-footer {
    border-color: #2e354f;
    background: #191c2b;
}
</style>

@php
    $totalCount = count($sessions);
    $openCount = $sessions->where('is_open', 1)->count();
    $closedCount = $sessions->where('is_open', 0)->count();
@endphp

<div class="session-dashboard-wrapper">
    <!-- Header Banner -->
    <div class="session-header-box">
        <div>
            <div class="session-header-title">
                <i class="fas fa-calendar-alt text-primary"></i>
                {{ __('Academic Sessions & Semesters') }}
            </div>
            <p class="session-header-subtitle">
                {{ __('Define academic years, active intake cycles, session durations, and operational enrollment periods.') }}
            </p>
        </div>

        <div class="session-action-group">
            <a href="{{ route('students.index') }}" class="btn-session btn-session-secondary" title="{{ __('View Student Roster') }}">
                <i class="fas fa-user-graduate"></i>
                <span>{{ __('Student Directory') }}</span>
            </a>

            @if (Auth::user()->role == 0)
                <button type="button" class="btn-session btn-session-primary" data-toggle="modal" data-target="#addSessionModal">
                    <i class="fas fa-plus"></i>
                    <span>{{ __('New Academic Session') }}</span>
                </button>
            @endif
        </div>
    </div>

    <!-- Top KPI Metric Cards -->
    <div class="session-kpi-grid">
        <div class="session-kpi-card">
            <div class="session-kpi-icon kpi-indigo">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div>
                <div class="session-kpi-value">{{ $totalCount }}</div>
                <div class="session-kpi-label">{{ __('Total Sessions') }}</div>
            </div>
        </div>

        <div class="session-kpi-card">
            <div class="session-kpi-icon kpi-emerald">
                <i class="fas fa-door-open"></i>
            </div>
            <div>
                <div class="session-kpi-value">{{ $openCount }}</div>
                <div class="session-kpi-label">{{ __('Open / Active') }}</div>
            </div>
        </div>

        <div class="session-kpi-card">
            <div class="session-kpi-icon kpi-slate">
                <i class="fas fa-archive"></i>
            </div>
            <div>
                <div class="session-kpi-value">{{ $closedCount }}</div>
                <div class="session-kpi-label">{{ __('Closed / Past') }}</div>
            </div>
        </div>

        <div class="session-kpi-card">
            <div class="session-kpi-icon kpi-sky">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div>
                <div class="session-kpi-value">{{ $openCount > 0 ? __('Ongoing') : __('Standby') }}</div>
                <div class="session-kpi-label">{{ __('Intake State') }}</div>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="session-main-card">
        <!-- Toolbar -->
        <div class="session-toolbar">
            <div class="session-filter-tabs">
                <button type="button" class="session-filter-pill active" data-filter="all">
                    <span>{{ __('All') }}</span>
                    <span class="session-filter-count">{{ $totalCount }}</span>
                </button>
                <button type="button" class="session-filter-pill" data-filter="open">
                    <span>{{ __('Open') }}</span>
                    <span class="session-filter-count">{{ $openCount }}</span>
                </button>
                <button type="button" class="session-filter-pill" data-filter="closed">
                    <span>{{ __('Closed') }}</span>
                    <span class="session-filter-count">{{ $closedCount }}</span>
                </button>
            </div>

            <div class="session-search-box">
                <i class="fas fa-search session-search-icon"></i>
                <input type="text" id="sessionSearchInput" class="session-search-input" placeholder="{{ __('Search session name, date...') }}" autocomplete="off">
            </div>
        </div>

        <!-- Responsive Table -->
        <div class="table-responsive">
            <table class="table session-table" id="sessionMasterTable">
                <thead>
                    <tr>
                        <th style="width: 45px;">#</th>
                        <th>{{ __('Academic Session Name') }}</th>
                        <th>{{ __('Enrollment Status') }}</th>
                        <th>{{ __('Start Date') }}</th>
                        <th>{{ __('End Date') }}</th>
                        <th>{{ __('Cycle Duration') }}</th>
                        <th style="width: 100px;" class="text-right">{{ __('Options') }}</th>
                    </tr>
                </thead>
                <tbody id="sessionTableBody">
                    @forelse($sessions as $index => $session)
                        @php
                            $searchBlob = strtolower(implode(' ', [
                                $session->name ?? '',
                                $session->strt_dt ?? '',
                                $session->end_dt ?? '',
                                $session->is_open ? 'open' : 'closed',
                            ]));

                            // Calculate Duration in Days/Months
                            $days = 0;
                            if (!empty($session->strt_dt) && !empty($session->end_dt)) {
                                try {
                                    $start = \Carbon\Carbon::parse($session->strt_dt);
                                    $end = \Carbon\Carbon::parse($session->end_dt);
                                    $days = $start->diffInDays($end);
                                } catch (\Exception $e) {}
                            }
                        @endphp
                        <tr class="session-row"
                            data-search="{{ $searchBlob }}"
                            data-status="{{ $session->is_open ? 'open' : 'closed' }}">
                            <td class="text-muted font-weight-bold" style="font-size: 0.8rem;">
                                {{ $index + 1 }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="session-avatar mr-2.5">
                                        <i class="far fa-calendar-alt"></i>
                                    </div>
                                    <div>
                                        <div class="session-name">{{ $session->name }}</div>
                                        <span class="badge badge-light border text-muted small mt-0.5">
                                            #S-{{ str_pad($session->id, 3, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($session->is_open)
                                    <span class="status-pill status-open">
                                        <span class="pulse-dot pulse-dot-green"></span>
                                        {{ __('Open') }}
                                    </span>
                                @else
                                    <span class="status-pill status-closed">
                                        <span class="pulse-dot pulse-dot-slate"></span>
                                        {{ __('Closed') }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="date-pill">
                                    <i class="far fa-calendar-plus text-primary mr-1"></i>
                                    {{ $session->strt_dt }}
                                </span>
                            </td>
                            <td>
                                <span class="date-pill">
                                    <i class="far fa-calendar-minus text-secondary mr-1"></i>
                                    {{ $session->end_dt }}
                                </span>
                            </td>
                            <td>
                                @if($days > 0)
                                    <span class="duration-tag">
                                        <i class="far fa-clock"></i>
                                        {{ round($days / 30) }} {{ __('Months') }} ({{ $days }} {{ __('Days') }})
                                    </span>
                                @else
                                    <span class="text-muted small">N/A</span>
                                @endif
                            </td>
                            <td class="text-right">
                                @if (Auth::user()->role == 0)
                                    <div class="session-actions-group">
                                        <button type="button" class="btn-action-icon btn-action-edit edit-session-btn"
                                                data-id="{{ $session->id }}"
                                                data-name="{{ $session->name }}"
                                                data-is-open="{{ $session->is_open }}"
                                                data-start="{{ $session->strt_dt }}"
                                                data-end="{{ $session->end_dt }}"
                                                title="{{ __('Edit Session') }}">
                                            <i class="fas fa-pen"></i>
                                        </button>

                                        <form action="{{ route('sessions.destroy', $session->id) }}" method="POST" class="d-inline delete-session-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action-icon btn-action-delete" title="{{ __('Delete Session') }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-muted small">{{ __('Read Only') }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="far fa-calendar-times fa-3x mb-3 text-secondary opacity-50 d-block"></i>
                                <h6>{{ __('No academic sessions found') }}</h6>
                                <p class="small text-muted mb-0">{{ __('Create a new academic session to define terms and semesters.') }}</p>
                            </td>
                        </tr>
                    @endforelse
                    <tr id="noResultsRow" style="display: none;">
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-search fa-2x mb-2 text-secondary opacity-50 d-block"></i>
                            <h6>{{ __('No matching academic sessions found') }}</h6>
                            <p class="small text-muted mb-0">{{ __('Try adjusting your search query or filters.') }}</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- =====================================================================
     ADD SESSION MODAL
===================================================================== -->
<div class="modal fade session-modal" id="addSessionModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="addModalLabel">
                    <i class="fas fa-plus-circle text-primary mr-1.5"></i>
                    {{ __('Add New Academic Session') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('sessions.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label for="name" class="font-weight-bold text-sm">
                            {{ __('Session Name') }} <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('e.g. 2026-2027 Academic Year') }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="is_open" class="font-weight-bold text-sm">
                            {{ __('Enrollment Status') }} <span class="text-danger">*</span>
                        </label>
                        <select class="form-control" name="is_open" id="is_open" required>
                            <option value="1">{{ __('Open / Accepting Enrollments') }}</option>
                            <option value="0">{{ __('Closed / Archived') }}</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="strt_dt" class="font-weight-bold text-sm">
                                {{ __('Start Date') }} <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="strt_dt" id="strt_dt" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="end_dt" class="font-weight-bold text-sm">
                                {{ __('End Date') }} <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="end_dt" id="end_dt" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">
                        {{ __('Close') }}
                    </button>
                    <button type="submit" class="btn btn-primary font-weight-bold">
                        <i class="fas fa-save mr-1"></i> {{ __('Save Session') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- =====================================================================
     EDIT SESSION MODAL (Single Dynamic Modal)
===================================================================== -->
<div class="modal fade session-modal" id="editSessionModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="editModalLabel">
                    <i class="fas fa-edit text-warning mr-1.5"></i>
                    {{ __('Edit Academic Session') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editSessionForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label for="edit_name" class="font-weight-bold text-sm">
                            {{ __('Session Name') }} <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="edit_is_open" class="font-weight-bold text-sm">
                            {{ __('Enrollment Status') }} <span class="text-danger">*</span>
                        </label>
                        <select class="form-control" name="is_open" id="edit_is_open" required>
                            <option value="1">{{ __('Open / Accepting Enrollments') }}</option>
                            <option value="0">{{ __('Closed / Archived') }}</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_strt_dt" class="font-weight-bold text-sm">
                                {{ __('Start Date') }} <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="strt_dt" id="edit_strt_dt" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_end_dt" class="font-weight-bold text-sm">
                                {{ __('End Date') }} <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="end_dt" id="edit_end_dt" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">
                        {{ __('Close') }}
                    </button>
                    <button type="submit" class="btn btn-primary font-weight-bold">
                        <i class="fas fa-save mr-1"></i> {{ __('Save Changes') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // ══════════════════════════════════════════════════════════════════
    // Instant Live Filtering & Search
    // ══════════════════════════════════════════════════════════════════
    const searchInput = document.getElementById('sessionSearchInput');
    const filterPills = document.querySelectorAll('.session-filter-pill');
    const tableRows = document.querySelectorAll('.session-row');
    const noResultsRow = document.getElementById('noResultsRow');

    let currentFilter = 'all';

    function applyFilters() {
        const query = (searchInput.value || '').trim().toLowerCase();
        let visibleCount = 0;

        tableRows.forEach(row => {
            const rowSearch = row.getAttribute('data-search') || '';
            const rowStatus = row.getAttribute('data-status') || '';

            const matchesSearch = !query || rowSearch.includes(query);
            const matchesFilter = (currentFilter === 'all') || (rowStatus === currentFilter);

            if (matchesSearch && matchesFilter) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        if (noResultsRow) {
            noResultsRow.style.display = (visibleCount === 0 && tableRows.length > 0) ? '' : 'none';
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', applyFilters);
    }

    filterPills.forEach(pill => {
        pill.addEventListener('click', function () {
            filterPills.forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            currentFilter = this.getAttribute('data-filter');
            applyFilters();
        });
    });

    // ══════════════════════════════════════════════════════════════════
    // Dynamic Edit Modal Handlers
    // ══════════════════════════════════════════════════════════════════
    document.querySelectorAll('.edit-session-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const isOpen = this.getAttribute('data-is-open');
            const start = this.getAttribute('data-start');
            const end = this.getAttribute('data-end');

            const form = document.getElementById('editSessionForm');
            form.action = `/sessions/${id}/update`;

            document.getElementById('edit_name').value = name || '';
            document.getElementById('edit_is_open').value = isOpen == '1' ? '1' : '0';
            document.getElementById('edit_strt_dt').value = start || '';
            document.getElementById('edit_end_dt').value = end || '';

            $('#editSessionModal').modal('show');
        });
    });

    // ══════════════════════════════════════════════════════════════════
    // SweetAlert2 Delete Confirmation
    // ══════════════════════════════════════════════════════════════════
    document.querySelectorAll('.delete-session-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: '{{ __("Delete Academic Session?") }}',
                text: '{{ __("Are you sure you want to delete this session? Classes associated with it may be impacted.") }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: '{{ __("Yes, Delete") }}',
                cancelButtonText: '{{ __("Cancel") }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>

@endsection
