@extends('layout.main')

@section('title', __('User Management'))

@section('content')

<style>
/* ══════════════════════════════════════════════════════════════════
   USER MANAGEMENT – Executive SaaS Design System
══════════════════════════════════════════════════════════════════ */
.user-dashboard-wrapper {
    padding: 0.5rem 0.25rem 2.5rem;
}

/* Header Action Box */
.user-header-box {
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
}
html.dark-mode .user-header-box {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 24px -2px rgba(0, 0, 0, 0.35);
}

.user-header-title {
    font-size: 1.35rem;
    font-weight: 800;
    margin-bottom: 0.2rem;
    display: flex;
    align-items: center;
    gap: 0.65rem;
    color: #1e293b;
}
html.dark-mode .user-header-title {
    color: #f8fafc;
}

.user-header-subtitle {
    font-size: 0.85rem;
    color: #64748b;
    margin: 0;
}
html.dark-mode .user-header-subtitle {
    color: #94a3b8;
}

.user-action-btn-group {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    flex-wrap: wrap;
}

.user-btn {
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
.user-btn-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
}
.user-btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
}
.user-btn-secondary {
    background: #f1f5f9;
    color: #334155 !important;
    border-color: #cbd5e1;
}
.user-btn-secondary:hover {
    background: #e2e8f0;
    color: #0f172a !important;
}
html.dark-mode .user-btn-secondary {
    background: #282f48;
    color: #e2e8f0 !important;
    border-color: #3b4261;
}
html.dark-mode .user-btn-secondary:hover {
    background: #333c5e;
}

/* KPI Cards Grid */
.user-kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 1.25rem;
}

.user-kpi-card {
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
.user-kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
}
html.dark-mode .user-kpi-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.25);
}

.user-kpi-icon {
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
.kpi-rose    { background: rgba(244, 63, 94, 0.12);  color: #f43f5e; }
.kpi-sky     { background: rgba(14, 165, 233, 0.12); color: #0ea5e9; }
.kpi-emerald { background: rgba(16, 185, 129, 0.12); color: #10b981; }
.kpi-amber   { background: rgba(245, 158, 11, 0.12); color: #f59e0b; }

.user-kpi-value {
    font-size: 1.6rem;
    font-weight: 800;
    line-height: 1.1;
    color: #0f172a;
}
html.dark-mode .user-kpi-value {
    color: #f8fafc;
}
.user-kpi-label {
    font-size: 0.8rem;
    font-weight: 600;
    color: #64748b;
    margin-top: 0.2rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
html.dark-mode .user-kpi-label {
    color: #94a3b8;
}

/* Main Card */
.user-main-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.04);
    overflow: hidden;
}
html.dark-mode .user-main-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 24px -2px rgba(0, 0, 0, 0.35);
}

/* Card Toolbar & Filter Bar */
.user-card-toolbar {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.85rem;
    background: #fbfcfe;
}
html.dark-mode .user-card-toolbar {
    border-color: #2e354f;
    background: #191c2b;
}

.user-filters-group {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    flex-wrap: wrap;
}

.user-filter-select {
    height: 38px;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    background: #ffffff;
    color: #334155;
    font-size: 0.85rem;
    padding: 0 2.2rem 0 0.85rem;
    outline: none;
    transition: all 0.2s ease;
    cursor: pointer;
    background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2214%22%20height%3D%2214%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%2364748b%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpath%20d%3D%22m6%209%206%206%206-6%22%2F%3E%3C%2Fsvg%3E");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 14px;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}
.user-filter-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}
html.dark-mode .user-filter-select {
    background-color: #1b1e2e;
    border-color: #3b4261;
    color: #f1f5f9;
    background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2214%22%20height%3D%2214%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%2394a3b8%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpath%20d%3D%22m6%209%206%206%206-6%22%2F%3E%3C%2Fsvg%3E");
}

.user-search-box {
    position: relative;
    min-width: 260px;
    flex-grow: 1;
    max-width: 360px;
}
.user-search-icon {
    position: absolute;
    left: 0.85rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.85rem;
    pointer-events: none;
}
.user-search-input {
    width: 100%;
    height: 38px;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    background: #ffffff;
    color: #1e293b;
    padding: 0 1rem 0 2.25rem;
    font-size: 0.85rem;
    transition: all 0.2s ease;
    outline: none;
}
.user-search-input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}
html.dark-mode .user-search-input {
    background: #1b1e2e;
    border-color: #3b4261;
    color: #f8fafc;
}
html.dark-mode .user-search-input::placeholder {
    color: #64748b;
}

/* User Table */
.user-table {
    margin-bottom: 0;
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}
.user-table th {
    background: #f8fafc;
    color: #475569;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 0.85rem 1.15rem;
    border-top: none;
    border-bottom: 1px solid #e2e8f0;
    white-space: nowrap;
}
html.dark-mode .user-table th {
    background: #191c2b;
    color: #94a3b8;
    border-color: #2e354f;
}

.user-table td {
    padding: 0.95rem 1.15rem;
    vertical-align: middle;
    border-top: 1px solid #f1f5f9;
    color: #334155;
    font-size: 0.875rem;
    transition: background 0.15s ease;
}
html.dark-mode .user-table td {
    border-color: #282f48;
    color: #cbd5e1;
}
.user-table tbody tr:hover td {
    background-color: #f8fafc;
}
html.dark-mode .user-table tbody tr:hover td {
    background-color: #252a3d;
}

/* Avatar Box */
.user-avatar-box {
    position: relative;
    width: 44px;
    height: 44px;
    border-radius: 12px;
    overflow: hidden;
    flex-shrink: 0;
    background: #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #ffffff;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
    cursor: pointer;
}
html.dark-mode .user-avatar-box {
    border-color: #2e354f;
    background: #282f48;
}
.user-avatar-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.25s ease;
}
.user-avatar-box:hover .user-avatar-img {
    transform: scale(1.15);
}

.user-name-cell {
    font-weight: 700;
    color: #0f172a;
    font-size: 0.95rem;
    line-height: 1.3;
}
html.dark-mode .user-name-cell {
    color: #f8fafc;
}

.user-id-pill {
    font-size: 0.72rem;
    font-weight: 600;
    padding: 0.12rem 0.45rem;
    border-radius: 6px;
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #e2e8f0;
    font-family: monospace;
}
html.dark-mode .user-id-pill {
    background: #252a3d;
    color: #94a3b8;
    border-color: #3b4261;
}

/* Role Badges */
.badge-role {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.76rem;
    font-weight: 600;
    padding: 0.22rem 0.65rem;
    border-radius: 8px;
    letter-spacing: 0.02em;
}
.badge-role-admin {
    background: rgba(239, 68, 68, 0.12);
    color: #dc2626;
    border: 1px solid rgba(239, 68, 68, 0.25);
}
html.dark-mode .badge-role-admin {
    background: rgba(239, 68, 68, 0.2);
    color: #f87171;
    border-color: rgba(239, 68, 68, 0.4);
}

.badge-role-teacher {
    background: rgba(14, 165, 233, 0.12);
    color: #0284c7;
    border: 1px solid rgba(14, 165, 233, 0.25);
}
html.dark-mode .badge-role-teacher {
    background: rgba(14, 165, 233, 0.2);
    color: #38bdf8;
    border-color: rgba(14, 165, 233, 0.4);
}

.badge-role-student {
    background: rgba(16, 185, 129, 0.12);
    color: #059669;
    border: 1px solid rgba(16, 185, 129, 0.25);
}
html.dark-mode .badge-role-student {
    background: rgba(16, 185, 129, 0.2);
    color: #34d399;
    border-color: rgba(16, 185, 129, 0.4);
}

.badge-role-accountant {
    background: rgba(245, 158, 11, 0.12);
    color: #d97706;
    border: 1px solid rgba(245, 158, 11, 0.25);
}
html.dark-mode .badge-role-accountant {
    background: rgba(245, 158, 11, 0.2);
    color: #fbbf24;
    border-color: rgba(245, 158, 11, 0.4);
}

.badge-role-receptionist {
    background: rgba(139, 92, 246, 0.12);
    color: #7c3aed;
    border: 1px solid rgba(139, 92, 246, 0.25);
}
html.dark-mode .badge-role-receptionist {
    background: rgba(139, 92, 246, 0.2);
    color: #a78bfa;
    border-color: rgba(139, 92, 246, 0.4);
}

.badge-status-active {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    font-size: 0.72rem;
    font-weight: 600;
    color: #059669;
    background: rgba(16, 185, 129, 0.1);
    border: 1px solid rgba(16, 185, 129, 0.25);
    padding: 0.15rem 0.5rem;
    border-radius: 6px;
}
html.dark-mode .badge-status-active {
    background: rgba(16, 185, 129, 0.18);
    color: #34d399;
    border-color: rgba(16, 185, 129, 0.35);
}

/* Modals */
.user-modal .modal-content {
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}
html.dark-mode .user-modal .modal-content {
    background: #1e2235;
    border-color: #2e354f;
    color: #f1f5f9;
}
.user-modal .modal-header {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 1.15rem 1.5rem;
}
html.dark-mode .user-modal .modal-header {
    background: #191c2b;
    border-color: #2e354f;
}
.user-modal .modal-footer {
    border-top: 1px solid #e2e8f0;
    background: #f8fafc;
    padding: 0.95rem 1.5rem;
}
html.dark-mode .user-modal .modal-footer {
    border-color: #2e354f;
    background: #191c2b;
}

.user-input-group .input-group-text {
    background: #f8fafc;
    border-color: #cbd5e1;
    color: #64748b;
    border-radius: 10px 0 0 10px;
    width: 42px;
    justify-content: center;
}
html.dark-mode .user-input-group .input-group-text {
    background: #252a3d;
    border-color: #3b4261;
    color: #94a3b8;
}
.user-input-group .form-control {
    border-color: #cbd5e1;
    border-radius: 0 10px 10px 0;
    font-size: 0.875rem;
    height: 42px;
}
html.dark-mode .user-input-group .form-control {
    background: #1b1e2e;
    border-color: #3b4261;
    color: #f1f5f9;
}
.user-input-group .form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}

/* Avatar Upload Frame */
.avatar-upload-frame {
    position: relative;
    width: 100px;
    height: 100px;
    margin: 0 auto;
}
.avatar-upload-frame img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid #cbd5e1;
    background-color: #f8fafc;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}
html.dark-mode .avatar-upload-frame img {
    border-color: #3b4261;
    background-color: #252a3d;
}
.avatar-upload-btn {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    background: #3b82f6;
    color: #ffffff;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.25);
    margin: 0;
    padding: 0;
    transition: transform 0.2s;
    border: 2px solid #ffffff;
}
.avatar-upload-btn:hover {
    transform: scale(1.1);
    background: #2563eb;
}
html.dark-mode .avatar-upload-btn {
    border-color: #1e2235;
}
</style>

<div class="user-dashboard-wrapper">
    <!-- Header Action Banner -->
    <div class="user-header-box">
        <div>
            <div class="user-header-title">
                <i class="fas fa-user-shield text-primary"></i>
                {{ __('User Access & Identity Management') }}
            </div>
            <p class="user-header-subtitle">
                {{ __('Manage institutional system credentials, user accounts, security roles, and authorization levels.') }}
            </p>
        </div>

        <div class="user-action-btn-group">
            <a href="{{ route('activity.logs') }}" class="user-btn user-btn-secondary" title="{{ __('View System Activity Logs') }}">
                <i class="fas fa-history text-primary"></i>
                <span>{{ __('Security Logs') }}</span>
            </a>

            <button type="button" class="user-btn user-btn-primary" data-toggle="modal" data-target="#addUserModal">
                <i class="fas fa-user-plus"></i>
                <span>{{ __('Add New User') }}</span>
            </button>
        </div>
    </div>

    <!-- Top KPI Metric Cards -->
    <div class="user-kpi-grid">
        <div class="user-kpi-card">
            <div class="user-kpi-icon kpi-indigo">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <div class="user-kpi-value">{{ $metrics['total_users'] ?? count($users) }}</div>
                <div class="user-kpi-label">{{ __('Total Users') }}</div>
            </div>
        </div>

        <div class="user-kpi-card">
            <div class="user-kpi-icon kpi-rose">
                <i class="fas fa-user-shield"></i>
            </div>
            <div>
                <div class="user-kpi-value">{{ $metrics['admin_count'] ?? 0 }}</div>
                <div class="user-kpi-label">{{ __('Administrators') }}</div>
            </div>
        </div>

        <div class="user-kpi-card">
            <div class="user-kpi-icon kpi-sky">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div>
                <div class="user-kpi-value">{{ $metrics['faculty_count'] ?? 0 }}</div>
                <div class="user-kpi-label">{{ __('Faculty / Teachers') }}</div>
            </div>
        </div>

        <div class="user-kpi-card">
            <div class="user-kpi-icon kpi-emerald">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div>
                <div class="user-kpi-value">{{ $metrics['student_count'] ?? 0 }}</div>
                <div class="user-kpi-label">{{ __('Enrolled Students') }}</div>
            </div>
        </div>

        <div class="user-kpi-card">
            <div class="user-kpi-icon kpi-amber">
                <i class="fas fa-user-tie"></i>
            </div>
            <div>
                <div class="user-kpi-value">{{ $metrics['staff_count'] ?? 0 }}</div>
                <div class="user-kpi-label">{{ __('Operational Staff') }}</div>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="user-main-card">
        <!-- Card Toolbar -->
        <div class="user-card-toolbar">
            <div class="d-flex align-items-center gap-2">
                <h5 class="mb-0 font-weight-bold" style="font-size: 1rem;">
                    {{ __('System User Directory') }}
                </h5>
                <span class="badge badge-light border ml-2" id="userCountBadge" style="font-size: 0.78rem;">
                    {{ count($users) }} {{ __('Users') }}
                </span>
            </div>

            <!-- Filter Controls -->
            <div class="user-filters-group">
                <!-- Role Selector Filter -->
                <select id="userRoleFilter" class="user-filter-select" title="{{ __('Filter by Role') }}">
                    <option value="all">{{ __('All System Roles') }}</option>
                    <option value="0">{{ __('Admin (Role 0)') }}</option>
                    <option value="1">{{ __('Teacher (Role 1)') }}</option>
                    <option value="2">{{ __('Student (Role 2)') }}</option>
                    <option value="3">{{ __('Accountant (Role 3)') }}</option>
                    <option value="4">{{ __('Receptionist (Role 4)') }}</option>
                </select>

                <!-- Real-time Live Search -->
                <div class="user-search-box">
                    <i class="fas fa-search user-search-icon"></i>
                    <input type="text" id="userSearchInput" class="user-search-input" placeholder="{{ __('Search name, email, role, ID...') }}" autocomplete="off">
                </div>
            </div>
        </div>

        <!-- Table View -->
        <div class="table-responsive">
            <table class="table user-table" id="userMasterTable">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>{{ __('User Profile') }}</th>
                        <th>{{ __('Email Address') }}</th>
                        <th>{{ __('Role & Access Level') }}</th>
                        <th>{{ __('Registration & Status') }}</th>
                        <th style="width: 100px;" class="text-right">{{ __('Options') }}</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">
                    @forelse($users as $index => $user)
                        @php
                            $searchBlob = strtolower(implode(' ', [
                                $user->name ?? '',
                                $user->email ?? '',
                                $user->role_name ?? '',
                                'role:' . $user->role,
                                'id:' . $user->id
                            ]));
                        @endphp
                        <tr class="user-row"
                            data-search="{{ $searchBlob }}"
                            data-role="{{ $user->role }}">
                            <td class="text-muted font-weight-bold" style="font-size: 0.8rem;">
                                {{ $index + 1 }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar-box mr-3" onclick="viewEnlargedImage('{{ $user->photo_url }}', '{{ addslashes($user->name) }}')" title="{{ __('Click to enlarge photo') }}">
                                        <img src="{{ $user->photo_url }}"
                                             alt="{{ $user->name }}"
                                             class="user-avatar-img"
                                             onerror="this.src='{{ asset('user-profile-default.png') }}';">
                                    </div>
                                    <div>
                                        <div class="user-name-cell">
                                            {{ $user->name }}
                                        </div>
                                        <div class="mt-1">
                                            <span class="user-id-pill" title="{{ __('User Identifier') }}">
                                                #U-{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}
                                            </span>
                                            @if(Auth::id() === $user->id)
                                                <span class="badge badge-primary-subtle ml-1" style="font-size: 0.68rem; font-weight: 700;">
                                                    <i class="fas fa-user-circle mr-1"></i>{{ __('You') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="mailto:{{ $user->email }}" class="text-primary font-weight-500" style="text-decoration: none;">
                                    <i class="far fa-envelope mr-1 text-muted"></i>
                                    {{ $user->email }}
                                </a>
                            </td>
                            <td>
                                @if($user->role == 0)
                                    <span class="badge-role badge-role-admin">
                                        <i class="fas fa-shield-alt"></i> {{ __('Admin') }}
                                    </span>
                                @elseif($user->role == 1)
                                    <span class="badge-role badge-role-teacher">
                                        <i class="fas fa-chalkboard-teacher"></i> {{ __('Teacher') }}
                                    </span>
                                @elseif($user->role == 2)
                                    <span class="badge-role badge-role-student">
                                        <i class="fas fa-user-graduate"></i> {{ __('Student') }}
                                    </span>
                                @elseif($user->role == 3)
                                    <span class="badge-role badge-role-accountant">
                                        <i class="fas fa-calculator"></i> {{ __('Accountant') }}
                                    </span>
                                @elseif($user->role == 4)
                                    <span class="badge-role badge-role-receptionist">
                                        <i class="fas fa-headset"></i> {{ __('Receptionist') }}
                                    </span>
                                @else
                                    <span class="badge badge-light border">{{ __('User') }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="text-muted small">
                                    <i class="far fa-calendar-alt text-primary mr-1"></i>
                                    {{ !empty($user->created_at) ? date('M d, Y', strtotime($user->created_at)) : __('N/A') }}
                                </div>
                                <div class="mt-1">
                                    <span class="badge-status-active">
                                        <i class="fas fa-check-circle"></i> {{ __('Active') }}
                                    </span>
                                </div>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius: 8px;">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right shadow-sm border-0" style="border-radius: 10px;">
                                        <button type="button" class="dropdown-item text-primary font-weight-500 py-2" onclick="showEditModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}', {{ $user->role }}, '{{ $user->photo_url }}')">
                                            <i class="fas fa-edit mr-2"></i> {{ __('Edit User') }}
                                        </button>
                                        <div class="dropdown-divider"></div>
                                        @if(Auth::id() === $user->id)
                                            <button type="button" class="dropdown-item text-muted py-2" disabled title="{{ __('Cannot delete current session') }}">
                                                <i class="fas fa-ban mr-2"></i> {{ __('Current User') }}
                                            </button>
                                        @else
                                            <form action="{{ route('user.delete', $user->id) }}" method="POST" class="delete-user-form" data-name="{{ $user->name }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="dropdown-item text-danger font-weight-500 py-2 delete-user-btn">
                                                    <i class="fas fa-trash-alt mr-2"></i> {{ __('Delete User') }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr id="emptyUserRow">
                            <td colspan="6" class="text-center py-5 text-muted">
                                <div class="py-4">
                                    <i class="fas fa-users-cog fa-3x mb-3 text-secondary opacity-50"></i>
                                    <p class="font-weight-bold mb-1">{{ __('No users found') }}</p>
                                    <p class="small text-muted mb-3">{{ __('Add system administrators, faculty, students, or operational staff.') }}</p>
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addUserModal">
                                        <i class="fas fa-plus mr-1"></i> {{ __('Add User') }}
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    <tr id="noSearchUserRow" style="display: none;">
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-search fa-2x mb-2 text-secondary opacity-50"></i>
                            <p class="font-weight-bold mb-0">{{ __('No matching users found') }}</p>
                            <small>{{ __('Try modifying your role filter or searching with different keywords.') }}</small>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL: ADD USER                                                -->
<!-- ============================================================== -->
<div class="modal fade user-modal" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data" onsubmit="if (typeof showOverlay === 'function') showOverlay();">
                @csrf
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title font-weight-bold" id="addUserModalLabel">
                            <i class="fas fa-user-plus text-primary mr-1"></i>
                            {{ __('Add New User Account') }}
                        </h5>
                        <p class="text-muted small mb-0">{{ __('Provision system login credentials and set authorization role') }}</p>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body p-4">
                    <!-- Profile Image Section -->
                    <div class="form-group text-center mb-3">
                        <label class="d-block font-weight-bold text-sm mb-2">{{ __('Profile Avatar') }}</label>
                        <div class="avatar-upload-frame">
                            <img id="add-user-photo-preview" src="{{ asset('user-profile-default.png') }}" alt="Profile Preview">
                            <label for="add-user-photo-input" class="avatar-upload-btn" title="{{ __('Choose photo') }}">
                                <i class="fas fa-camera" style="font-size: 13px;"></i>
                            </label>
                            <input type="file" id="add-user-photo-input" name="photo" accept="image/jpeg,image/png,image/webp,image/gif" style="display: none;" onchange="previewAddUserPhoto(this)">
                        </div>
                        <div class="mt-2">
                            <button type="button" id="add-user-photo-remove" class="btn btn-xs btn-outline-danger" style="display: none;" onclick="removeAddUserPhoto()">
                                <i class="fas fa-times mr-1"></i> {{ __('Remove Avatar') }}
                            </button>
                        </div>
                        <small class="form-text text-muted">{{ __('JPG, PNG, WEBP, GIF (Max 3MB)') }}</small>
                    </div>

                    <!-- Name -->
                    <div class="form-group">
                        <label class="font-weight-bold text-sm">{{ __('Full Name') }} <span class="text-danger">*</span></label>
                        <div class="input-group user-input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" name="name" class="form-control" placeholder="{{ __('e.g., Jonathan Doe') }}" required autofocus>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label class="font-weight-bold text-sm">{{ __('Email Address') }} <span class="text-danger">*</span></label>
                        <div class="input-group user-input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input type="email" name="email" class="form-control" placeholder="{{ __('user@example.com') }}" required>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label class="font-weight-bold text-sm">{{ __('Initial Password') }} <span class="text-danger">*</span></label>
                        <div class="input-group user-input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                            <input type="password" name="password" class="form-control" placeholder="{{ __('Minimum 6 characters') }}" required>
                        </div>
                    </div>

                    <!-- Role -->
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-sm">{{ __('System Role') }} <span class="text-danger">*</span></label>
                        <div class="input-group user-input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                            </div>
                            <select name="role" class="form-control" required>
                                <option value="0">{{ __('Admin (Role 0)') }}</option>
                                <option value="1">{{ __('Teacher (Role 1)') }}</option>
                                <option value="2">{{ __('Student (Role 2)') }}</option>
                                <option value="3">{{ __('Accountant (Role 3)') }}</option>
                                <option value="4">{{ __('Receptionist (Role 4)') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary px-4 font-weight-bold">
                        <i class="fas fa-check mr-1"></i> {{ __('Save User Account') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL: EDIT USER                                               -->
<!-- ============================================================== -->
<div class="modal fade user-modal" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="edit-user-form" method="POST" action="{{ route('user.update') }}" enctype="multipart/form-data" onsubmit="if (typeof showOverlay === 'function') showOverlay();">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit-user-id">
                <input type="hidden" name="remove_photo" id="edit-user-remove-photo" value="0">

                <div class="modal-header">
                    <div>
                        <h5 class="modal-title font-weight-bold" id="editUserModalLabel">
                            <i class="fas fa-user-edit text-primary mr-1"></i>
                            {{ __('Edit User Account') }}
                        </h5>
                        <p class="text-muted small mb-0">{{ __('Update profile details, password, role assignment, or avatar') }}</p>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body p-4">
                    <!-- Profile Image Section -->
                    <div class="form-group text-center mb-3">
                        <label class="d-block font-weight-bold text-sm mb-2">{{ __('Profile Avatar') }}</label>
                        <div class="avatar-upload-frame">
                            <img id="edit-user-photo-preview" src="{{ asset('user-profile-default.png') }}" alt="Profile Preview">
                            <label for="edit-user-photo-input" class="avatar-upload-btn" title="{{ __('Change photo') }}">
                                <i class="fas fa-camera" style="font-size: 13px;"></i>
                            </label>
                            <input type="file" id="edit-user-photo-input" name="photo" accept="image/jpeg,image/png,image/webp,image/gif" style="display: none;" onchange="previewEditUserPhoto(this)">
                        </div>
                        <div class="mt-2">
                            <button type="button" id="edit-user-photo-reset-btn" class="btn btn-xs btn-outline-secondary mr-1" style="display: none;" onclick="resetEditUserPhoto()">
                                <i class="fas fa-undo mr-1"></i> {{ __('Revert') }}
                            </button>
                            <button type="button" id="edit-user-photo-remove-btn" class="btn btn-xs btn-outline-danger" onclick="removeEditUserPhoto()">
                                <i class="fas fa-trash-alt mr-1"></i> {{ __('Remove Photo') }}
                            </button>
                        </div>
                        <small class="form-text text-muted">{{ __('Click camera icon to change photo (Max 3MB)') }}</small>
                    </div>

                    <!-- Name -->
                    <div class="form-group">
                        <label for="edit-user-name" class="font-weight-bold text-sm">{{ __('Full Name') }} <span class="text-danger">*</span></label>
                        <div class="input-group user-input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" id="edit-user-name" name="name" required>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="edit-user-email" class="font-weight-bold text-sm">{{ __('Email Address') }} <span class="text-danger">*</span></label>
                        <div class="input-group user-input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input type="email" class="form-control" id="edit-user-email" name="email" required>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="edit-user-password" class="font-weight-bold text-sm">{{ __('Change Password') }}</label>
                        <div class="input-group user-input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                            <input type="password" class="form-control" id="edit-user-password" name="password" placeholder="{{ __('Leave blank to keep current password') }}">
                        </div>
                    </div>

                    <!-- Role -->
                    <div class="form-group mb-0">
                        <label for="edit-user-role" class="font-weight-bold text-sm">{{ __('System Role') }} <span class="text-danger">*</span></label>
                        <div class="input-group user-input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                            </div>
                            <select class="form-control" id="edit-user-role" name="role" required>
                                <option value="0">{{ __('Admin (Role 0)') }}</option>
                                <option value="1">{{ __('Teacher (Role 1)') }}</option>
                                <option value="2">{{ __('Student (Role 2)') }}</option>
                                <option value="3">{{ __('Accountant (Role 3)') }}</option>
                                <option value="4">{{ __('Receptionist (Role 4)') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary px-4 font-weight-bold">
                        <i class="fas fa-save mr-1"></i> {{ __('Save Changes') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- ENLARGED IMAGE PREVIEW MODAL                                   -->
<!-- ============================================================== -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg border-0" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header py-2" style="background: #0f172a; color: #ffffff;">
                <h6 class="modal-title font-weight-bold mb-0" id="imagePreviewModalTitle">{{ __('User Profile Photo') }}</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" onclick="closeImagePreviewModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-3 text-center" style="background: #1e293b;">
                <img id="enlargedUserImage" src="" alt="Enlarged Profile" class="img-fluid rounded shadow-sm" style="max-height: 420px; object-fit: contain;">
            </div>
        </div>
    </div>
</div>

<script>
const DEFAULT_AVATAR = '{{ asset('user-profile-default.png') }}';
let originalEditPhotoUrl = DEFAULT_AVATAR;

document.addEventListener('DOMContentLoaded', function () {
    // 1. Live Client-Side Role & Search Filters
    const searchInput = document.getElementById('userSearchInput');
    const roleFilter = document.getElementById('userRoleFilter');
    const rows = document.querySelectorAll('.user-row');
    const noResultRow = document.getElementById('noSearchUserRow');
    const countBadge = document.getElementById('userCountBadge');

    function applyFilters() {
        const query = (searchInput ? searchInput.value.trim().toLowerCase() : '');
        const selectedRole = (roleFilter ? roleFilter.value : 'all');

        let visibleCount = 0;

        rows.forEach(row => {
            const searchData = row.getAttribute('data-search') || '';
            const rowRole = row.getAttribute('data-role') || '';

            const matchesQuery = !query || searchData.includes(query);
            const matchesRole = (selectedRole === 'all' || rowRole === selectedRole);

            if (matchesQuery && matchesRole) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        if (noResultRow) {
            noResultRow.style.display = (visibleCount === 0 && rows.length > 0) ? '' : 'none';
        }

        if (countBadge) {
            countBadge.textContent = `${visibleCount} {{ __('Users') }}`;
        }
    }

    if (searchInput) searchInput.addEventListener('input', applyFilters);
    if (roleFilter) roleFilter.addEventListener('change', applyFilters);

    // 2. SweetAlert2 Delete Confirmation
    document.querySelectorAll('.delete-user-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('form');
            const userName = form.getAttribute('data-name') || 'this user';

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: '{{ __("Delete User Account?") }}',
                    html: `{{ __("Are you sure you want to delete") }} <strong>${userName}</strong>?<br><small class="text-danger">{{ __("This will permanently remove their login access.") }}</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: '<i class="fas fa-trash-alt mr-1"></i> {{ __("Yes, delete user") }}',
                    cancelButtonText: '{{ __("Cancel") }}',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (typeof showOverlay === 'function') showOverlay();
                        form.submit();
                    }
                });
            } else {
                if (confirm(`{{ __("Are you sure you want to delete") }} "${userName}"?`)) {
                    if (typeof showOverlay === 'function') showOverlay();
                    form.submit();
                }
            }
        });
    });
});

// Edit Modal Loader
function showEditModal(id, name, email, role, photoUrl) {
    document.getElementById('edit-user-id').value = id;
    document.getElementById('edit-user-name').value = name;
    document.getElementById('edit-user-email').value = email;
    document.getElementById('edit-user-password').value = '';
    document.getElementById('edit-user-role').value = role;

    document.getElementById('edit-user-remove-photo').value = '0';
    document.getElementById('edit-user-photo-input').value = '';
    document.getElementById('edit-user-photo-reset-btn').style.display = 'none';

    originalEditPhotoUrl = photoUrl || DEFAULT_AVATAR;
    document.getElementById('edit-user-photo-preview').src = originalEditPhotoUrl;

    openModal('editUserModal');
}

// Add Photo Handlers
function previewAddUserPhoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('add-user-photo-preview').src = e.target.result;
            document.getElementById('add-user-photo-remove').style.display = 'inline-block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function removeAddUserPhoto() {
    document.getElementById('add-user-photo-input').value = '';
    document.getElementById('add-user-photo-preview').src = DEFAULT_AVATAR;
    document.getElementById('add-user-photo-remove').style.display = 'none';
}

// Edit Photo Handlers
function previewEditUserPhoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('edit-user-photo-preview').src = e.target.result;
            document.getElementById('edit-user-remove-photo').value = '0';
            document.getElementById('edit-user-photo-reset-btn').style.display = 'inline-block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function resetEditUserPhoto() {
    document.getElementById('edit-user-photo-input').value = '';
    document.getElementById('edit-user-photo-preview').src = originalEditPhotoUrl;
    document.getElementById('edit-user-remove-photo').value = '0';
    document.getElementById('edit-user-photo-reset-btn').style.display = 'none';
}

function removeEditUserPhoto() {
    document.getElementById('edit-user-photo-input').value = '';
    document.getElementById('edit-user-photo-preview').src = DEFAULT_AVATAR;
    document.getElementById('edit-user-remove-photo').value = '1';
    document.getElementById('edit-user-photo-reset-btn').style.display = 'inline-block';
}

// Full Image Preview Modal
function viewEnlargedImage(url, name) {
    document.getElementById('enlargedUserImage').src = url;
    document.getElementById('imagePreviewModalTitle').textContent = (name || 'User') + ' - {{ __("Profile Photo") }}';
    openModal('imagePreviewModal');
}

function closeImagePreviewModal() {
    closeModal('imagePreviewModal');
}

// Modal Open/Close Helpers
function openModal(modalId) {
    const modalEl = document.getElementById(modalId);
    if (!modalEl) return;

    if (typeof $ !== 'undefined' && typeof $('#' + modalId).modal === 'function') {
        $('#' + modalId).modal('show');
    } else if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        let instance = bootstrap.Modal.getInstance(modalEl);
        if (!instance) {
            instance = new bootstrap.Modal(modalEl);
        }
        instance.show();
    }
}

function closeModal(modalId) {
    const modalEl = document.getElementById(modalId);
    if (!modalEl) return;

    if (typeof $ !== 'undefined' && typeof $('#' + modalId).modal === 'function') {
        $('#' + modalId).modal('hide');
    } else if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        let instance = bootstrap.Modal.getInstance(modalEl);
        if (instance) {
            instance.hide();
        }
    }
}
</script>

@endsection
