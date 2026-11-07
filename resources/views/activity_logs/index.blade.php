@extends('layout.main')

@section('title', 'Activity Logs & Audit Trail')

@section('content')

<style>
/* ══════════════════════════════════════════════════════════════════
   ACTIVITY LOGS & AUDIT TRAIL – Executive SaaS Architecture
══════════════════════════════════════════════════════════════════ */

.audit-wrapper {
    max-width: 1360px;
    margin: 0.5rem auto 3rem;
    padding: 0 0.5rem;
}

/* Header & Action Bar */
.audit-header-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 1rem 1.5rem;
    margin-bottom: 1.25rem;
    box-shadow: 0 4px 16px -2px rgba(0, 0, 0, 0.04);
}
html.dark-mode .audit-header-bar {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.35);
}

.audit-title {
    font-size: 1.35rem;
    font-weight: 700;
    margin-bottom: 0.15rem;
    display: flex;
    align-items: center;
    gap: 0.6rem;
    color: #1e293b;
}
html.dark-mode .audit-title {
    color: #f1f5f9;
}

.audit-subtitle {
    font-size: 0.85rem;
    color: #64748b;
    margin: 0;
}
html.dark-mode .audit-subtitle {
    color: #94a3b8;
}

/* KPI Metric Cards */
.audit-kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1rem;
    margin-bottom: 1.25rem;
}

.audit-kpi-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 1.1rem 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.audit-kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
}
html.dark-mode .audit-kpi-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.25);
}

.audit-kpi-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.kpi-indigo { background: rgba(99, 102, 241, 0.12); color: #6366f1; }
.kpi-emerald { background: rgba(16, 185, 129, 0.12); color: #10b981; }
.kpi-purple { background: rgba(168, 85, 247, 0.12); color: #a855f7; }
.kpi-amber  { background: rgba(245, 158, 11, 0.12); color: #f59e0b; }

.audit-kpi-val {
    font-size: 1.5rem;
    font-weight: 700;
    line-height: 1.2;
    color: #0f172a;
}
html.dark-mode .audit-kpi-val {
    color: #f8fafc;
}

.audit-kpi-lbl {
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-weight: 600;
    color: #64748b;
    margin-top: 0.1rem;
}
html.dark-mode .audit-kpi-lbl {
    color: #94a3b8;
}

/* Filter Card */
.audit-filter-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 1.25rem;
    margin-bottom: 1.25rem;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
}
html.dark-mode .audit-filter-card {
    background: #1e2235;
    border-color: #2e354f;
}

.audit-form-label {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: #64748b;
    margin-bottom: 0.35rem;
    display: block;
}
html.dark-mode .audit-form-label {
    color: #94a3b8;
}

.audit-form-control {
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    font-size: 0.88rem;
    height: calc(2.25rem + 2px);
    transition: all 0.15s ease;
}
html.dark-mode .audit-form-control {
    background: #252b42;
    border-color: #3b4566;
    color: #e2e8f0;
}
.audit-form-control:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
}

/* Table Card */
.audit-table-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.04);
}
html.dark-mode .audit-table-card {
    background: #1e2235;
    border-color: #2e354f;
}

.audit-table-header {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.75rem;
}
html.dark-mode .audit-table-header {
    border-color: #2e354f;
}

.audit-table {
    margin-bottom: 0;
    font-size: 0.88rem;
}
.audit-table thead th {
    background: #f8fafc;
    border-bottom: 2px solid #e2e8f0;
    border-top: none;
    font-size: 0.74rem;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    font-weight: 700;
    color: #64748b;
    padding: 0.85rem 0.75rem;
    vertical-align: middle;
}
html.dark-mode .audit-table thead th {
    background: #181b2a;
    border-color: #2e354f;
    color: #94a3b8;
}

.audit-table tbody td {
    padding: 0.85rem 0.75rem;
    vertical-align: middle;
    border-top: 1px solid #f1f5f9;
}
html.dark-mode .audit-table tbody td {
    border-color: #262c43;
}

.audit-table tbody tr:hover {
    background-color: #f8fafc;
}
html.dark-mode .audit-table tbody tr:hover {
    background-color: #242a40;
}

/* User Pill */
.user-avatar-pill {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.82rem;
    color: #ffffff;
    flex-shrink: 0;
}

/* Method Badge */
.badge-method {
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.05em;
    padding: 0.3em 0.55em;
    border-radius: 6px;
    display: inline-block;
    min-width: 52px;
    text-align: center;
}

/* URL Pill */
.url-pill {
    display: inline-block;
    font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
    font-size: 0.76rem;
    background: #f1f5f9;
    color: #334155;
    padding: 0.2rem 0.5rem;
    border-radius: 5px;
    max-width: 200px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    vertical-align: middle;
}
html.dark-mode .url-pill {
    background: #252c44;
    color: #cbd5e1;
}

/* IP Pill */
.ip-pill {
    font-family: SFMono-Regular, Menlo, Monaco, Consolas, monospace;
    font-size: 0.76rem;
    background: #e2e8f0;
    color: #1e293b;
    padding: 0.15rem 0.45rem;
    border-radius: 5px;
}
html.dark-mode .ip-pill {
    background: #2f3754;
    color: #e2e8f0;
}

/* Status Badge */
.status-pill {
    font-size: 0.72rem;
    font-weight: 700;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
}

/* Pagination container */
.audit-pagination-bar {
    padding: 1rem 1.25rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    border-top: 1px solid #e2e8f0;
}
html.dark-mode .audit-pagination-bar {
    border-color: #2e354f;
}

/* Empty State */
.audit-empty-state {
    padding: 3.5rem 1.5rem;
    text-align: center;
}
.audit-empty-icon {
    font-size: 3rem;
    color: #cbd5e1;
    margin-bottom: 1rem;
}
html.dark-mode .audit-empty-icon {
    color: #3f4a6e;
}
</style>

<div class="audit-wrapper">

    {{-- Session Flash Notifications --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Header Action Ribbon --}}
    <div class="audit-header-bar">
        <div>
            <div class="audit-title">
                <i class="fas fa-history text-primary"></i>
                <span>{{ __('Activity Logs & Audit Trail') }}</span>
            </div>
            <p class="audit-subtitle">
                {{ __('Real-time executive audit trail, security events, authentication records, and system mutations.') }}
            </p>
        </div>
        <div class="d-flex align-items-center flex-wrap" style="gap: 0.5rem;">
            <a href="{{ route('activity.logs.export', request()->all()) }}" class="btn btn-outline-success btn-sm font-weight-bold" title="{{ __('Export Current Audit Trail as CSV') }}">
                <i class="fas fa-file-csv mr-1"></i> {{ __('Export CSV') }}
            </a>
            <button type="button" class="btn btn-outline-danger btn-sm font-weight-bold" data-toggle="modal" data-target="#clearLogsModal" title="{{ __('Purge Old Audit Logs') }}">
                <i class="fas fa-broom mr-1"></i> {{ __('Purge Logs') }}
            </button>
            <a href="{{ route('activity.logs') }}" class="btn btn-outline-secondary btn-sm" title="{{ __('Refresh Log Stream') }}">
                <i class="fas fa-sync-alt mr-1"></i> {{ __('Refresh') }}
            </a>
        </div>
    </div>

    {{-- Top KPI Cards --}}
    <div class="audit-kpi-grid">
        <div class="audit-kpi-card">
            <div class="audit-kpi-icon kpi-indigo">
                <i class="fas fa-database"></i>
            </div>
            <div>
                <div class="audit-kpi-val">{{ number_format($metrics['total_all'] ?? 0) }}</div>
                <div class="audit-kpi-lbl">{{ __('Total Activities') }}</div>
            </div>
        </div>

        <div class="audit-kpi-card">
            <div class="audit-kpi-icon kpi-emerald">
                <i class="fas fa-bolt"></i>
            </div>
            <div>
                <div class="audit-kpi-val">{{ number_format($metrics['today_total'] ?? 0) }}</div>
                <div class="audit-kpi-lbl">{{ __('Recorded Today') }}</div>
            </div>
        </div>

        <div class="audit-kpi-card">
            <div class="audit-kpi-icon kpi-purple">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <div class="audit-kpi-val">{{ number_format($metrics['active_users_today'] ?? 0) }}</div>
                <div class="audit-kpi-lbl">{{ __('Active Users Today') }}</div>
            </div>
        </div>

        <div class="audit-kpi-card">
            <div class="audit-kpi-icon kpi-amber">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div>
                <div class="audit-kpi-val">{{ number_format($metrics['mutations_today'] ?? 0) }}</div>
                <div class="audit-kpi-lbl">{{ __('Mutations Today (POST/DEL)') }}</div>
            </div>
        </div>
    </div>

    {{-- Interactive Filter Bar --}}
    <div class="audit-filter-card">
        <form method="GET" action="{{ route('activity.logs') }}" id="activityFilterForm">
            <div class="row align-items-end">
                {{-- Search Keyword --}}
                <div class="col-lg-3 col-md-6 mb-2">
                    <label class="audit-form-label">{{ __('Search Audit Trail') }}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-transparent border-right-0"><i class="fas fa-search text-muted"></i></span>
                        </div>
                        <input type="text" name="search" class="form-control audit-form-control border-left-0" placeholder="{{ __('User, action, IP, url...') }}" value="{{ request('search') }}">
                    </div>
                </div>

                {{-- User Filter --}}
                <div class="col-lg-2 col-md-6 mb-2">
                    <label class="audit-form-label">{{ __('Filter by User') }}</label>
                    <select name="user_id" class="form-control audit-form-control">
                        <option value="">{{ __('All Users') }}</option>
                        @foreach ($users as $u)
                            <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>
                                {{ $u->name }} ({{ match($u->role) { 0=>'Admin', 1=>'Teacher', 2=>'Student', 3=>'Accountant', 4=>'Receptionist', default=>'User' } }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Action / Method Filter --}}
                <div class="col-lg-2 col-md-4 mb-2">
                    <label class="audit-form-label">{{ __('Action / Method') }}</label>
                    <select name="method" class="form-control audit-form-control">
                        <option value="">{{ __('All Actions & Methods') }}</option>
                        <option value="MUTATION" {{ request('method') === 'MUTATION' ? 'selected' : '' }}>{{ __('Mutations (POST / PUT / DEL)') }}</option>
                        <option value="GET" {{ request('method') === 'GET' ? 'selected' : '' }}>GET ({{ __('Page Views') }})</option>
                        <option value="POST" {{ request('method') === 'POST' ? 'selected' : '' }}>POST ({{ __('Creations') }})</option>
                        <option value="PUT" {{ request('method') === 'PUT' ? 'selected' : '' }}>PUT / PATCH ({{ __('Updates') }})</option>
                        <option value="DELETE" {{ request('method') === 'DELETE' ? 'selected' : '' }}>DELETE ({{ __('Removals') }})</option>
                    </select>
                </div>

                {{-- Date Filter Preset --}}
                <div class="col-lg-2 col-md-4 mb-2">
                    <label class="audit-form-label">{{ __('Date Period') }}</label>
                    <select name="date_filter" id="dateFilterSelect" class="form-control audit-form-control" onchange="toggleCustomDates(this.value)">
                        <option value="">{{ __('All Time') }}</option>
                        <option value="today" {{ request('date_filter') === 'today' ? 'selected' : '' }}>{{ __('Today') }}</option>
                        <option value="yesterday" {{ request('date_filter') === 'yesterday' ? 'selected' : '' }}>{{ __('Yesterday') }}</option>
                        <option value="week" {{ request('date_filter') === 'week' ? 'selected' : '' }}>{{ __('Past 7 Days') }}</option>
                        <option value="month" {{ request('date_filter') === 'month' ? 'selected' : '' }}>{{ __('Past 30 Days') }}</option>
                        <option value="custom" {{ request('date_filter') === 'custom' ? 'selected' : '' }}>{{ __('Custom Range...') }}</option>
                    </select>
                </div>

                {{-- Rows Per Page --}}
                <div class="col-lg-1 col-md-4 mb-2">
                    <label class="audit-form-label">{{ __('Per Page') }}</label>
                    <select name="per_page" class="form-control audit-form-control">
                        <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
                        <option value="25" {{ request('per_page', 25) == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </div>

                {{-- Filter & Reset Buttons --}}
                <div class="col-lg-2 col-md-12 mb-2 d-flex" style="gap: 0.5rem;">
                    <button type="submit" class="btn btn-primary btn-block audit-form-control font-weight-bold">
                        <i class="fas fa-filter mr-1"></i> {{ __('Filter') }}
                    </button>
                    @if (request()->hasAny(['search', 'user_id', 'method', 'date_filter', 'start_date', 'end_date']))
                        <a href="{{ route('activity.logs') }}" class="btn btn-outline-secondary audit-form-control px-3" title="{{ __('Reset Filters') }}">
                            <i class="fas fa-undo"></i>
                        </a>
                    @endif
                </div>
            </div>

            {{-- Custom Date Range Fields (Conditional) --}}
            <div class="row mt-2" id="customDateRow" style="{{ request('date_filter') === 'custom' ? '' : 'display: none;' }}">
                <div class="col-md-3">
                    <label class="audit-form-label">{{ __('Start Date') }}</label>
                    <input type="date" name="start_date" class="form-control audit-form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3">
                    <label class="audit-form-label">{{ __('End Date') }}</label>
                    <input type="date" name="end_date" class="form-control audit-form-control" value="{{ request('end_date') }}">
                </div>
            </div>
        </form>
    </div>

    {{-- Main Activity Logs Table Card --}}
    <div class="audit-table-card">
        <div class="audit-table-header">
            <div class="d-flex align-items-center" style="gap: 0.5rem;">
                <h5 class="mb-0 font-weight-bold" style="font-size: 1rem;">
                    <i class="fas fa-list text-muted mr-1"></i> {{ __('Audit Trail Records') }}
                </h5>
                <span class="badge badge-light border">{{ number_format($logs->total()) }} {{ __('total events') }}</span>
            </div>
            <div>
                <small class="text-muted">{{ __('Sorted chronologically (Newest first)') }}</small>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table audit-table align-middle">
                <thead>
                    <tr>
                        <th style="width: 55px;" class="text-center">#</th>
                        <th style="width: 210px;">{{ __('User & Role') }}</th>
                        <th style="min-width: 220px;">{{ __('Action & Event Details') }}</th>
                        <th style="width: 140px;">{{ __('Method & Route') }}</th>
                        <th style="width: 160px;">{{ __('Client Device') }}</th>
                        <th style="width: 170px;">{{ __('IP & Geolocation') }}</th>
                        <th style="width: 75px;" class="text-center">{{ __('Status') }}</th>
                        <th style="width: 150px;" class="text-right">{{ __('Timestamp') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $index => $log)
                        @php
                            $user = $log->user;
                            $roleColors = [
                                0 => ['bg' => '#ef4444', 'label' => 'Admin', 'badge' => 'badge-danger'],
                                1 => ['bg' => '#3b82f6', 'label' => 'Teacher', 'badge' => 'badge-primary'],
                                2 => ['bg' => '#10b981', 'label' => 'Student', 'badge' => 'badge-success'],
                                3 => ['bg' => '#f59e0b', 'label' => 'Accountant', 'badge' => 'badge-warning text-dark'],
                                4 => ['bg' => '#06b6d4', 'label' => 'Receptionist', 'badge' => 'badge-info'],
                            ];
                            $userRole = $user ? $user->role : null;
                            $roleMeta = $roleColors[$userRole] ?? ['bg' => '#64748b', 'label' => 'System / Guest', 'badge' => 'badge-secondary'];
                            $userInitial = $user && !empty($user->name) ? strtoupper(mb_substr($user->name, 0, 1)) : 'U';
                        @endphp
                        <tr>
                            {{-- ID / Index --}}
                            <td class="text-center text-muted font-weight-bold" style="font-size: 0.8rem;">
                                {{ $logs->firstItem() + $index }}
                            </td>

                            {{-- User --}}
                            <td>
                                <div class="d-flex align-items-center" style="gap: 0.65rem;">
                                    <span class="user-avatar-pill shadow-sm" style="background-color: {{ $roleMeta['bg'] }};">
                                        {{ $userInitial }}
                                    </span>
                                    <div style="min-width: 0;">
                                        <div class="font-weight-bold text-truncate" style="max-width: 140px;" title="{{ $user->name ?? 'Unknown User' }}">
                                            {{ $user->name ?? 'Deleted User' }}
                                        </div>
                                        <div class="d-flex align-items-center mt-1" style="gap: 0.35rem;">
                                            <span class="badge {{ $roleMeta['badge'] }}" style="font-size: 0.68rem;">
                                                {{ $roleMeta['label'] }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Action & Event Details --}}
                            <td>
                                <div class="d-flex align-items-center mb-1" style="gap: 0.4rem;">
                                    <i class="{{ $log->action_icon }}"></i>
                                    <span class="font-weight-bold" style="color: #1e293b;">
                                        {{ $log->action ?? 'General Activity' }}
                                    </span>
                                </div>
                                @if (!empty($log->description))
                                    <div class="text-muted" style="font-size: 0.8rem; line-height: 1.3;">
                                        {{ $log->description }}
                                    </div>
                                @endif
                            </td>

                            {{-- Method & Route --}}
                            <td>
                                <div class="mb-1">
                                    <span class="badge {{ $log->method_badge_class }} badge-method">
                                        {{ strtoupper($log->method ?? 'GET') }}
                                    </span>
                                </div>
                                <span class="url-pill" title="{{ $log->url ?? '/' }}">
                                    {{ $log->url ?? '/' }}
                                </span>
                            </td>

                            {{-- Device --}}
                            <td>
                                <div class="d-flex align-items-center" style="gap: 0.4rem;">
                                    <i class="{{ $log->device_icon }}"></i>
                                    <span style="font-size: 0.82rem; font-weight: 500;">
                                        {{ $log->device ?? 'Desktop' }}
                                    </span>
                                </div>
                                @if (!empty($log->user_agent))
                                    <small class="text-muted d-block text-truncate mt-1" style="max-width: 145px; font-size: 0.72rem;" title="{{ $log->user_agent }}">
                                        {{ substr($log->user_agent, 0, 30) }}...
                                    </small>
                                @endif
                            </td>

                            {{-- Network & Geolocation --}}
                            <td>
                                <div class="mb-1">
                                    <span class="ip-pill">
                                        <i class="fas fa-network-wired text-muted mr-1" style="font-size: 0.68rem;"></i>{{ $log->ip_address }}
                                    </span>
                                </div>
                                <div style="font-size: 0.76rem; color: #64748b;" class="text-truncate" style="max-width: 155px;" title="{{ $log->geo_location ?? 'Unknown' }}">
                                    <i class="fas fa-map-marker-alt text-danger mr-1" style="font-size: 0.72rem;"></i>{{ $log->geo_location ?? 'Unknown' }}
                                </div>
                            </td>

                            {{-- Status --}}
                            <td class="text-center">
                                @php
                                    $code = $log->status_code ?? 200;
                                    $statusBadge = match(true) {
                                        $code >= 200 && $code < 300 => 'badge-success',
                                        $code >= 300 && $code < 400 => 'badge-info',
                                        $code >= 400 && $code < 500 => 'badge-warning text-dark',
                                        default => 'badge-danger'
                                    };
                                @endphp
                                <span class="badge {{ $statusBadge }} status-pill">
                                    {{ $code }}
                                </span>
                            </td>

                            {{-- Timestamp --}}
                            <td class="text-right">
                                @if ($log->timestamp)
                                    <div class="font-weight-bold" style="font-size: 0.82rem;">
                                        {{ $log->timestamp->diffForHumans() }}
                                    </div>
                                    <small class="text-muted" style="font-size: 0.72rem;">
                                        {{ $log->timestamp->format('Y-m-d H:i:s') }}
                                    </small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="audit-empty-state">
                                    <div class="audit-empty-icon">
                                        <i class="fas fa-clipboard-check"></i>
                                    </div>
                                    <h5 class="font-weight-bold">{{ __('No Activity Logs Found') }}</h5>
                                    <p class="text-muted mb-3" style="max-width: 420px; margin: 0 auto;">
                                        {{ __('No system activities matched your current search filters or date range criteria.') }}
                                    </p>
                                    @if (request()->hasAny(['search', 'user_id', 'method', 'date_filter']))
                                        <a href="{{ route('activity.logs') }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-undo mr-1"></i> {{ __('Clear Filter Parameters') }}
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination & Entry Counter --}}
        @if ($logs->hasPages() || $logs->total() > 0)
            <div class="audit-pagination-bar">
                <div class="text-muted" style="font-size: 0.85rem;">
                    {{ __('Showing') }}
                    <span class="font-weight-bold text-dark">{{ $logs->firstItem() ?? 0 }}</span>
                    {{ __('to') }}
                    <span class="font-weight-bold text-dark">{{ $logs->lastItem() ?? 0 }}</span>
                    {{ __('of') }}
                    <span class="font-weight-bold text-dark">{{ number_format($logs->total()) }}</span>
                    {{ __('entries') }}
                </div>
                <div>
                    {{ $logs->links('pagination::bootstrap-4') }}
                </div>
            </div>
        @endif
    </div>

</div>

{{-- Clear / Purge Logs Modal --}}
<div class="modal fade" id="clearLogsModal" tabindex="-1" role="dialog" aria-labelledby="clearLogsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 14px; overflow: hidden; border: none;">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title font-weight-bold" id="clearLogsModalLabel">
                    <i class="fas fa-exclamation-triangle mr-1"></i> {{ __('Purge System Activity Logs') }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('activity.logs.clear') }}" method="POST" id="purgeLogsForm">
                @csrf
                <div class="modal-body p-4">
                    <p class="text-muted mb-3">
                        {{ __('Select the time window of historical activity records you want to permanently delete from the database:') }}
                    </p>

                    <div class="list-group mb-3">
                        <label class="list-group-item d-flex align-items-center py-3 mb-2 border rounded" style="cursor: pointer;">
                            <input type="radio" name="scope" value="older_30" checked class="mr-3">
                            <div>
                                <strong class="d-block text-dark">{{ __('Purge logs older than 30 days') }}</strong>
                                <small class="text-muted">{{ __('Recommended retention policy. Retains the most recent month of audit history.') }}</small>
                            </div>
                        </label>

                        <label class="list-group-item d-flex align-items-center py-3 mb-2 border rounded" style="cursor: pointer;">
                            <input type="radio" name="scope" value="older_7" class="mr-3">
                            <div>
                                <strong class="d-block text-dark">{{ __('Purge logs older than 7 days') }}</strong>
                                <small class="text-muted">{{ __('Keep only the current week of activity records.') }}</small>
                            </div>
                        </label>

                        <label class="list-group-item d-flex align-items-center py-3 mb-2 border rounded" style="cursor: pointer;">
                            <input type="radio" name="scope" value="older_today" class="mr-3">
                            <div>
                                <strong class="d-block text-dark">{{ __('Purge logs prior to today') }}</strong>
                                <small class="text-muted">{{ __('Retain only activities logged since midnight today.') }}</small>
                            </div>
                        </label>

                        <label class="list-group-item d-flex align-items-center py-3 border rounded border-danger" style="cursor: pointer; background: rgba(239, 68, 68, 0.04);">
                            <input type="radio" name="scope" value="all" class="mr-3">
                            <div>
                                <strong class="d-block text-danger">{{ __('Purge ALL historical activity logs') }}</strong>
                                <small class="text-danger font-weight-bold">{{ __('Danger: Completely empties the audit trail table.') }}</small>
                            </div>
                        </label>
                    </div>

                    <div class="alert alert-warning py-2 px-3 mb-0" style="font-size: 0.82rem;">
                        <i class="fas fa-info-circle mr-1"></i>
                        {{ __('This action cannot be undone. An administrative purge log will be recorded automatically.') }}
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-danger font-weight-bold px-4" id="btnConfirmPurge">
                        <i class="fas fa-trash-alt mr-1"></i> {{ __('Confirm & Purge') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function toggleCustomDates(val) {
    var row = document.getElementById('customDateRow');
    if (!row) return;
    if (val === 'custom') {
        row.style.display = 'flex';
    } else {
        row.style.display = 'none';
    }
}

// Confirmation alert on Purge submit
document.addEventListener('DOMContentLoaded', function () {
    var purgeForm = document.getElementById('purgeLogsForm');
    if (purgeForm) {
        purgeForm.addEventListener('submit', function (e) {
            var selectedScope = document.querySelector('input[name="scope"]:checked').value;
            if (selectedScope === 'all') {
                if (!confirm('CAUTION: Are you absolutely certain you want to purge ALL historical activity logs?')) {
                    e.preventDefault();
                    return false;
                }
            }
        });
    }
});
</script>

@endsection
