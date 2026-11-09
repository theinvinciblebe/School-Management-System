@extends('layout.main')

@section('title', __('Staff Management'))

@section('content')

<style>
/* ══════════════════════════════════════════════════════════════════
   STAFF MANAGEMENT – Executive SaaS Design System
══════════════════════════════════════════════════════════════════ */
.staff-dashboard-wrapper {
    padding: 0.5rem 0.25rem 2.5rem;
}

/* Header Action Box */
.staff-header-box {
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
html.dark-mode .staff-header-box {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 24px -2px rgba(0, 0, 0, 0.35);
}

.staff-header-title {
    font-size: 1.35rem;
    font-weight: 800;
    margin-bottom: 0.2rem;
    display: flex;
    align-items: center;
    gap: 0.65rem;
    color: #1e293b;
}
html.dark-mode .staff-header-title {
    color: #f8fafc;
}

.staff-header-subtitle {
    font-size: 0.85rem;
    color: #64748b;
    margin: 0;
}
html.dark-mode .staff-header-subtitle {
    color: #94a3b8;
}

.staff-action-btn-group {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    flex-wrap: wrap;
}

.staff-btn {
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
.staff-btn-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
}
.staff-btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
}
.staff-btn-secondary {
    background: #f1f5f9;
    color: #334155 !important;
    border-color: #cbd5e1;
}
.staff-btn-secondary:hover {
    background: #e2e8f0;
    color: #0f172a !important;
}
html.dark-mode .staff-btn-secondary {
    background: #282f48;
    color: #e2e8f0 !important;
    border-color: #3b4261;
}
html.dark-mode .staff-btn-secondary:hover {
    background: #333c5e;
}

/* KPI Cards Grid */
.staff-kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem;
    margin-bottom: 1.25rem;
}

.staff-kpi-card {
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
.staff-kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
}
html.dark-mode .staff-kpi-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.25);
}

.staff-kpi-icon {
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
.kpi-sky     { background: rgba(14, 165, 233, 0.12); color: #0ea5e9; }
.kpi-rose    { background: rgba(244, 63, 94, 0.12);  color: #f43f5e; }

.staff-kpi-value {
    font-size: 1.6rem;
    font-weight: 800;
    line-height: 1.1;
    color: #0f172a;
}
html.dark-mode .staff-kpi-value {
    color: #f8fafc;
}
.staff-kpi-label {
    font-size: 0.8rem;
    font-weight: 600;
    color: #64748b;
    margin-top: 0.2rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
html.dark-mode .staff-kpi-label {
    color: #94a3b8;
}

/* Main Card */
.staff-main-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.04);
    overflow: hidden;
}
html.dark-mode .staff-main-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 24px -2px rgba(0, 0, 0, 0.35);
}

/* Card Toolbar & Filter Bar */
.staff-card-toolbar {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.85rem;
    background: #fbfcfe;
}
html.dark-mode .staff-card-toolbar {
    border-color: #2e354f;
    background: #191c2b;
}

.staff-filters-group {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    flex-wrap: wrap;
}

.staff-filter-select {
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
.staff-filter-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}
html.dark-mode .staff-filter-select {
    background-color: #1b1e2e;
    border-color: #3b4261;
    color: #f1f5f9;
    background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2214%22%20height%3D%2214%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%2394a3b8%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpath%20d%3D%22m6%209%206%206%206-6%22%2F%3E%3C%2Fsvg%3E");
}

.staff-search-box {
    position: relative;
    min-width: 260px;
    flex-grow: 1;
    max-width: 360px;
}
.staff-search-icon {
    position: absolute;
    left: 0.85rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.85rem;
    pointer-events: none;
}
.staff-search-input {
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
.staff-search-input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}
html.dark-mode .staff-search-input {
    background: #1b1e2e;
    border-color: #3b4261;
    color: #f8fafc;
}
html.dark-mode .staff-search-input::placeholder {
    color: #64748b;
}

/* Staff Table */
.staff-table {
    margin-bottom: 0;
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}
.staff-table th {
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
html.dark-mode .staff-table th {
    background: #191c2b;
    color: #94a3b8;
    border-color: #2e354f;
}

.staff-table td {
    padding: 0.95rem 1.15rem;
    vertical-align: middle;
    border-top: 1px solid #f1f5f9;
    color: #334155;
    font-size: 0.875rem;
    transition: background 0.15s ease;
}
html.dark-mode .staff-table td {
    border-color: #282f48;
    color: #cbd5e1;
}
.staff-table tbody tr:hover td {
    background-color: #f8fafc;
}
html.dark-mode .staff-table tbody tr:hover td {
    background-color: #252a3d;
}

/* Staff Avatar / Thumbnail */
.staff-avatar-box {
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
}
html.dark-mode .staff-avatar-box {
    border-color: #2e354f;
    background: #282f48;
}
.staff-avatar-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.2s ease;
}
.staff-avatar-box:hover .staff-avatar-img {
    transform: scale(1.08);
}
.staff-avatar-initials {
    font-weight: 700;
    font-size: 0.9rem;
    color: #3b82f6;
    background: rgba(59, 130, 246, 0.12);
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Profile details */
.staff-name-link {
    font-weight: 700;
    color: #0f172a;
    font-size: 0.925rem;
    display: block;
    line-height: 1.3;
}
html.dark-mode .staff-name-link {
    color: #f8fafc;
}

.staff-meta-badges {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    margin-top: 0.25rem;
    flex-wrap: wrap;
}

.staff-card-id {
    font-size: 0.72rem;
    font-weight: 600;
    padding: 0.12rem 0.45rem;
    border-radius: 6px;
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #e2e8f0;
    font-family: monospace;
}
html.dark-mode .staff-card-id {
    background: #252a3d;
    color: #94a3b8;
    border-color: #3b4261;
}

.badge-gender-male {
    background: rgba(59, 130, 246, 0.12);
    color: #2563eb;
    border: 1px solid rgba(59, 130, 246, 0.25);
    font-size: 0.7rem;
    font-weight: 600;
    border-radius: 6px;
    padding: 0.12rem 0.45rem;
}
html.dark-mode .badge-gender-male {
    background: rgba(59, 130, 246, 0.2);
    color: #60a5fa;
    border-color: rgba(59, 130, 246, 0.4);
}

.badge-gender-female {
    background: rgba(244, 63, 94, 0.12);
    color: #e11d48;
    border: 1px solid rgba(244, 63, 94, 0.25);
    font-size: 0.7rem;
    font-weight: 600;
    border-radius: 6px;
    padding: 0.12rem 0.45rem;
}
html.dark-mode .badge-gender-female {
    background: rgba(244, 63, 94, 0.2);
    color: #fb7185;
    border-color: rgba(244, 63, 94, 0.4);
}

/* Department & Position Badges */
.staff-dept-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.78rem;
    font-weight: 600;
    color: #3b82f6;
    background: rgba(59, 130, 246, 0.08);
    border: 1px solid rgba(59, 130, 246, 0.2);
    padding: 0.25rem 0.65rem;
    border-radius: 8px;
    text-decoration: none !important;
    transition: all 0.2s ease;
}
.staff-dept-badge:hover {
    background: #3b82f6;
    color: #ffffff !important;
}
html.dark-mode .staff-dept-badge {
    background: rgba(59, 130, 246, 0.15);
    color: #60a5fa;
    border-color: rgba(59, 130, 246, 0.3);
}
html.dark-mode .staff-dept-badge:hover {
    background: #3b82f6;
    color: #ffffff !important;
}

.staff-role-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    font-size: 0.78rem;
    font-weight: 600;
    padding: 0.2rem 0.55rem;
    border-radius: 6px;
    background: #f1f5f9;
    color: #334155;
    border: 1px solid #cbd5e1;
}
html.dark-mode .staff-role-badge {
    background: #252a3d;
    color: #e2e8f0;
    border-color: #3b4261;
}

.staff-system-user-badge {
    font-size: 0.68rem;
    font-weight: 700;
    padding: 0.15rem 0.45rem;
    border-radius: 6px;
    background: rgba(16, 185, 129, 0.12);
    color: #059669;
    border: 1px solid rgba(16, 185, 129, 0.3);
    margin-left: 0.35rem;
}
html.dark-mode .staff-system-user-badge {
    background: rgba(16, 185, 129, 0.2);
    color: #34d399;
    border-color: rgba(16, 185, 129, 0.4);
}

/* Contacts column */
.staff-contact-item {
    font-size: 0.825rem;
    display: flex;
    align-items: center;
    gap: 0.45rem;
    margin-bottom: 0.2rem;
    color: #475569;
}
html.dark-mode .staff-contact-item {
    color: #cbd5e1;
}
.staff-contact-item a {
    color: inherit;
    text-decoration: none;
    transition: color 0.15s ease;
}
.staff-contact-item a:hover {
    color: #3b82f6;
    text-decoration: underline;
}

/* Modals */
.staff-modal .modal-content {
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}
html.dark-mode .staff-modal .modal-content {
    background: #1e2235;
    border-color: #2e354f;
    color: #f1f5f9;
}
.staff-modal .modal-header {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 1.15rem 1.5rem;
}
html.dark-mode .staff-modal .modal-header {
    background: #191c2b;
    border-color: #2e354f;
}
.staff-modal .modal-footer {
    border-top: 1px solid #e2e8f0;
    background: #f8fafc;
    padding: 0.95rem 1.5rem;
}
html.dark-mode .staff-modal .modal-footer {
    border-color: #2e354f;
    background: #191c2b;
}

.staff-input-group .input-group-text {
    background: #f8fafc;
    border-color: #cbd5e1;
    color: #64748b;
    border-radius: 10px 0 0 10px;
    width: 42px;
    justify-content: center;
}
html.dark-mode .staff-input-group .input-group-text {
    background: #252a3d;
    border-color: #3b4261;
    color: #94a3b8;
}
.staff-input-group .form-control {
    border-color: #cbd5e1;
    border-radius: 0 10px 10px 0;
    font-size: 0.875rem;
    height: 42px;
}
html.dark-mode .staff-input-group .form-control {
    background: #1b1e2e;
    border-color: #3b4261;
    color: #f1f5f9;
}
.staff-input-group .form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}

.staff-photo-dropzone {
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    padding: 1rem;
    text-align: center;
    background: #f8fafc;
    transition: all 0.2s ease;
    cursor: pointer;
    position: relative;
}
.staff-photo-dropzone:hover {
    border-color: #3b82f6;
    background: rgba(59, 130, 246, 0.04);
}
html.dark-mode .staff-photo-dropzone {
    background: #191c2b;
    border-color: #3b4261;
}
html.dark-mode .staff-photo-dropzone:hover {
    border-color: #60a5fa;
    background: rgba(59, 130, 246, 0.08);
}

.photo-preview-box {
    width: 90px;
    height: 90px;
    border-radius: 14px;
    border: 2px solid #3b82f6;
    object-fit: cover;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    margin: 0.5rem auto;
    display: block;
}

.staff-info-notice {
    background: rgba(59, 130, 246, 0.08);
    border: 1px solid rgba(59, 130, 246, 0.25);
    border-radius: 10px;
    padding: 0.75rem 1rem;
    font-size: 0.8rem;
    color: #1e40af;
    display: flex;
    align-items: flex-start;
    gap: 0.65rem;
}
html.dark-mode .staff-info-notice {
    background: rgba(59, 130, 246, 0.15);
    border-color: rgba(59, 130, 246, 0.35);
    color: #93c5fd;
}
</style>

<div class="staff-dashboard-wrapper">
    <!-- Header Action Banner -->
    <div class="staff-header-box">
        <div>
            <div class="staff-header-title">
                <i class="fas fa-user-tie text-primary"></i>
                {{ __('Staff Directory & Personnel') }}
            </div>
            <p class="staff-header-subtitle">
                {{ __('Manage employee profiles, departmental allocations, designations, and system credentials.') }}
            </p>
        </div>

        <div class="staff-action-btn-group">
            <a href="{{ route('departments.index') }}" class="staff-btn staff-btn-secondary" title="{{ __('Manage Departments') }}">
                <i class="fas fa-sitemap text-primary"></i>
                <span>{{ __('Department Directory') }}</span>
            </a>

            <button type="button" class="staff-btn staff-btn-primary" data-toggle="modal" data-target="#addStaffModal">
                <i class="fas fa-user-plus"></i>
                <span>{{ __('Add New Staff') }}</span>
            </button>
        </div>
    </div>

    <!-- Top KPI Metric Cards -->
    <div class="staff-kpi-grid">
        <div class="staff-kpi-card">
            <div class="staff-kpi-icon kpi-indigo">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <div class="staff-kpi-value">{{ $metrics['total_staff'] ?? count($staffs) }}</div>
                <div class="staff-kpi-label">{{ __('Total Personnel') }}</div>
            </div>
        </div>

        <div class="staff-kpi-card">
            <div class="staff-kpi-icon kpi-sky">
                <i class="fas fa-building"></i>
            </div>
            <div>
                <div class="staff-kpi-value">{{ $metrics['total_departments'] ?? count($departments) }}</div>
                <div class="staff-kpi-label">{{ __('Active Departments') }}</div>
            </div>
        </div>

        <div class="staff-kpi-card">
            <div class="staff-kpi-icon kpi-emerald">
                <i class="fas fa-mars"></i>
            </div>
            <div>
                <div class="staff-kpi-value">{{ $metrics['male_count'] ?? 0 }}</div>
                <div class="staff-kpi-label">{{ __('Male Staff') }}</div>
            </div>
        </div>

        <div class="staff-kpi-card">
            <div class="staff-kpi-icon kpi-rose">
                <i class="fas fa-venus"></i>
            </div>
            <div>
                <div class="staff-kpi-value">{{ $metrics['female_count'] ?? 0 }}</div>
                <div class="staff-kpi-label">{{ __('Female Staff') }}</div>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="staff-main-card">
        <!-- Card Toolbar -->
        <div class="staff-card-toolbar">
            <div class="d-flex align-items-center gap-2">
                <h5 class="mb-0 font-weight-bold" style="font-size: 1rem;">
                    {{ __('Staff Roster') }}
                </h5>
                <span class="badge badge-light border ml-2" id="staffCountBadge" style="font-size: 0.78rem;">
                    {{ count($staffs) }} {{ __('Members') }}
                </span>
            </div>

            <!-- Filter Controls -->
            <div class="staff-filters-group">
                <!-- Department Selector Filter -->
                <select id="staffDeptFilter" class="staff-filter-select" title="{{ __('Filter by Department') }}">
                    <option value="all">{{ __('All Departments') }}</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ ($selectedDepartmentId == $dept->id) ? 'selected' : '' }}>
                            {{ $dept->name }} ({{ $dept->staff_count ?? 0 }})
                        </option>
                    @endforeach
                </select>

                <!-- Gender Quick Filter -->
                <select id="staffGenderFilter" class="staff-filter-select" title="{{ __('Filter by Sex') }}">
                    <option value="all">{{ __('All Genders') }}</option>
                    <option value="Male">{{ __('Male') }}</option>
                    <option value="Female">{{ __('Female') }}</option>
                </select>

                <!-- Real-time Live Search -->
                <div class="staff-search-box">
                    <i class="fas fa-search staff-search-icon"></i>
                    <input type="text" id="staffSearchInput" class="staff-search-input" placeholder="{{ __('Search name, role, email, phone...') }}" autocomplete="off">
                </div>
            </div>
        </div>

        <!-- Table View -->
        <div class="table-responsive">
            <table class="table staff-table" id="staffMasterTable">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>{{ __('Staff Profile') }}</th>
                        <th>{{ __('Department & Designation') }}</th>
                        <th>{{ __('Contact Information') }}</th>
                        <th>{{ __('Location & Hire Date') }}</th>
                        <th style="width: 100px;" class="text-right">{{ __('Options') }}</th>
                    </tr>
                </thead>
                <tbody id="staffTableBody">
                    @forelse($staffs as $index => $item)
                        @php
                            $searchBlob = strtolower(implode(' ', [
                                $item->name ?? '',
                                $item->email ?? '',
                                $item->phone ?? '',
                                $item->position ?? '',
                                $item->department_name ?? '',
                                $item->id_card ?? '',
                                $item->address ?? '',
                                $item->sex ?? ''
                            ]));
                            $isSystemRole = in_array(trim($item->position ?? ''), ['Accountant', 'Receptionist']);
                        @endphp
                        <tr class="staff-row"
                            data-search="{{ $searchBlob }}"
                            data-dept-id="{{ $item->department_id }}"
                            data-gender="{{ $item->sex }}">
                            <td class="text-muted font-weight-bold" style="font-size: 0.8rem;">
                                {{ $index + 1 }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="staff-avatar-box mr-3">
                                        @if(!empty($item->photo) && $item->photo !== 'noimg.jpg' && file_exists(public_path('staffs_image/' . $item->photo)))
                                            <img src="{{ asset('staffs_image/' . $item->photo) }}"
                                                 alt="{{ $item->name }}"
                                                 class="staff-avatar-img">
                                        @else
                                            <div class="staff-avatar-initials">
                                                {{ strtoupper(mb_substr($item->name, 0, 2)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="staff-name-link">
                                            {{ $item->name }}
                                        </div>
                                        <div class="staff-meta-badges">
                                            <span class="staff-card-id" title="{{ __('Employee ID') }}">
                                                #{{ $item->id_card ?: str_pad($item->staff_id, 4, '0', STR_PAD_LEFT) }}
                                            </span>
                                            @if($item->sex === 'Male')
                                                <span class="badge-gender-male">
                                                    <i class="fas fa-mars mr-1"></i>{{ __('Male') }}
                                                </span>
                                            @else
                                                <span class="badge-gender-female">
                                                    <i class="fas fa-venus mr-1"></i>{{ __('Female') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="mb-1">
                                    <span class="staff-role-badge">
                                        <i class="fas fa-briefcase text-primary mr-1"></i>
                                        {{ $item->position ?: __('General Staff') }}
                                    </span>
                                    @if($isSystemRole)
                                        <span class="staff-system-user-badge" title="{{ __('Automatic portal login enabled') }}">
                                            <i class="fas fa-shield-alt mr-1"></i>{{ __('User Role') }}
                                        </span>
                                    @endif
                                </div>
                                <div>
                                    <a href="{{ route('departments.index') }}" class="staff-dept-badge" title="{{ __('View department details') }}">
                                        <i class="fas fa-building"></i>
                                        <span>{{ $item->department_name ?: __('Unassigned') }}</span>
                                    </a>
                                </div>
                            </td>
                            <td>
                                <div class="staff-contact-item">
                                    <i class="far fa-envelope text-primary"></i>
                                    @if(!empty($item->email))
                                        <a href="mailto:{{ $item->email }}">{{ $item->email }}</a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                                <div class="staff-contact-item">
                                    <i class="fas fa-phone-alt text-success"></i>
                                    @if(!empty($item->phone))
                                        <a href="tel:{{ $item->phone }}">{{ $item->phone }}</a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="text-muted small">
                                    <i class="fas fa-map-marker-alt text-danger mr-1"></i>
                                    {{ $item->address ?: __('Address not registered') }}
                                </div>
                                <div class="text-muted small mt-1">
                                    <i class="far fa-calendar-alt text-info mr-1"></i>
                                    {{ !empty($item->hire_date) ? date('M d, Y', strtotime($item->hire_date)) : __('Date N/A') }}
                                </div>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius: 8px;">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right shadow-sm border-0" style="border-radius: 10px;">
                                        <button type="button" class="dropdown-item text-primary font-weight-500 py-2" data-toggle="modal" data-target="#editModal{{ $item->staff_id }}">
                                            <i class="fas fa-edit mr-2"></i> {{ __('Edit Staff') }}
                                        </button>
                                        <div class="dropdown-divider"></div>
                                        <form action="{{ route('staffs.destroy', $item->staff_id) }}" method="POST" class="delete-staff-form" data-name="{{ $item->name }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="dropdown-item text-danger font-weight-500 py-2 delete-staff-btn">
                                                <i class="fas fa-trash-alt mr-2"></i> {{ __('Delete Staff') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr id="emptyStaffRow">
                            <td colspan="6" class="text-center py-5 text-muted">
                                <div class="py-4">
                                    <i class="fas fa-user-tie fa-3x mb-3 text-secondary opacity-50"></i>
                                    <p class="font-weight-bold mb-1">{{ __('No staff members found') }}</p>
                                    <p class="small text-muted mb-3">{{ __('Add faculty, administration, or operational employees to get started.') }}</p>
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addStaffModal">
                                        <i class="fas fa-plus mr-1"></i> {{ __('Add Staff Member') }}
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    <tr id="noSearchStaffRow" style="display: none;">
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-search fa-2x mb-2 text-secondary opacity-50"></i>
                            <p class="font-weight-bold mb-0">{{ __('No matching staff members found') }}</p>
                            <small>{{ __('Try modifying your department filter or search keywords.') }}</small>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL: ADD NEW STAFF                                           -->
<!-- ============================================================== -->
<div class="modal fade staff-modal" id="addStaffModal" tabindex="-1" role="dialog" aria-labelledby="addStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('staffs.store') }}" method="POST" enctype="multipart/form-data" onsubmit="if (typeof showOverlay === 'function') showOverlay();">
                @csrf
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title font-weight-bold" id="addStaffModalLabel">
                            <i class="fas fa-user-plus text-primary mr-1"></i>
                            {{ __('Add New Staff Member') }}
                        </h5>
                        <p class="text-muted small mb-0">{{ __('Enroll employee profile and assign organizational department') }}</p>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body p-4">
                    <div class="form-row">
                        <!-- Full Name -->
                        <div class="form-group col-md-6">
                            <label for="add_name" class="font-weight-bold text-sm">
                                {{ __('Staff Full Name') }} <span class="text-danger">*</span>
                            </label>
                            <div class="input-group staff-input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control" id="add_name" name="name" placeholder="{{ __('e.g., Jonathan Doe') }}" required>
                            </div>
                        </div>

                        <!-- Sex -->
                        <div class="form-group col-md-6">
                            <label for="add_sex" class="font-weight-bold text-sm">
                                {{ __('Sex / Gender') }} <span class="text-danger">*</span>
                            </label>
                            <div class="input-group staff-input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                </div>
                                <select name="sex" id="add_sex" class="form-control" required>
                                    <option value="Male">{{ __('Male') }}</option>
                                    <option value="Female">{{ __('Female') }}</option>
                                </select>
                            </div>
                        </div>

                        <!-- Email Address -->
                        <div class="form-group col-md-6">
                            <label for="add_email" class="font-weight-bold text-sm">
                                {{ __('Email Address') }} <span class="text-danger">*</span>
                            </label>
                            <div class="input-group staff-input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input type="email" class="form-control" id="add_email" name="email" placeholder="{{ __('e.g., j.doe@school.edu') }}" required>
                            </div>
                        </div>

                        <!-- Telephone / Phone -->
                        <div class="form-group col-md-6">
                            <label for="add_phone" class="font-weight-bold text-sm">
                                {{ __('Phone Number') }} <span class="text-danger">*</span>
                            </label>
                            <div class="input-group staff-input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                </div>
                                <input type="text" class="form-control" id="add_phone" name="phone" placeholder="{{ __('e.g., +1 234 567 8900') }}" required>
                            </div>
                        </div>

                        <!-- Department -->
                        <div class="form-group col-md-6">
                            <label for="add_department_id" class="font-weight-bold text-sm">
                                {{ __('Department') }} <span class="text-danger">*</span>
                            </label>
                            <div class="input-group staff-input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                                </div>
                                <select name="department_id" id="add_department_id" class="form-control" required>
                                    <option value="">{{ __('Select Department') }}</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Position -->
                        <div class="form-group col-md-6">
                            <label for="add_position" class="font-weight-bold text-sm">
                                {{ __('Position / Role') }} <span class="text-danger">*</span>
                            </label>
                            <div class="input-group staff-input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                </div>
                                <input type="text" list="positionSuggestions" class="form-control" id="add_position" name="position" placeholder="{{ __('e.g., Accountant, Receptionist, Instructor') }}" required>
                                <datalist id="positionSuggestions">
                                    <option value="Accountant">
                                    <option value="Receptionist">
                                    <option value="Senior Instructor">
                                    <option value="Academic Coordinator">
                                    <option value="IT Specialist">
                                    <option value="Administrator">
                                </datalist>
                            </div>
                        </div>

                        <!-- Hire Date -->
                        <div class="form-group col-md-6">
                            <label for="add_hire_date" class="font-weight-bold text-sm">
                                {{ __('Hire Date') }} <span class="text-danger">*</span>
                            </label>
                            <div class="input-group staff-input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                                <input type="date" class="form-control" id="add_hire_date" name="hire_date" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>

                        <!-- Residential Address -->
                        <div class="form-group col-md-6">
                            <label for="add_address" class="font-weight-bold text-sm">
                                {{ __('Residential Address') }} <span class="text-danger">*</span>
                            </label>
                            <div class="input-group staff-input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                </div>
                                <input type="text" class="form-control" id="add_address" name="address" placeholder="{{ __('City, Street, Building') }}" required>
                            </div>
                        </div>

                        <!-- Profile Photo Upload with Live Preview -->
                        <div class="form-group col-12">
                            <label class="font-weight-bold text-sm">
                                {{ __('Profile Photo') }} <small class="text-muted">({{ __('Optional, JPG/PNG, max 2MB') }})</small>
                            </label>
                            <div class="staff-photo-dropzone text-center" onclick="document.getElementById('add_file_input').click();">
                                <i class="fas fa-cloud-upload-alt fa-2x text-primary mb-2"></i>
                                <div class="font-weight-bold text-sm" id="add_file_name_label">{{ __('Click to browse or drop photo here') }}</div>
                                <small class="text-muted">{{ __('Supports JPG, PNG, GIF files') }}</small>
                                <input type="file" name="file" id="add_file_input" accept="image/*" class="d-none" onchange="previewAddPhoto(this)">
                                <div id="addPhotoPreviewContainer" style="display: none;" class="mt-3">
                                    <img id="addPhotoPreviewImg" src="#" alt="Preview" class="photo-preview-box">
                                    <button type="button" class="btn btn-xs btn-outline-danger mt-1" onclick="event.stopPropagation(); removeAddPhoto();">
                                        <i class="fas fa-times mr-1"></i> {{ __('Remove Photo') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Auto-Provisioning Notice -->
                    <div class="staff-info-notice mt-2">
                        <i class="fas fa-info-circle text-primary mt-1"></i>
                        <div>
                            <strong>{{ __('System User Provisioning Notice:') }}</strong>
                            <div>{{ __('If designation is set to') }} <strong>Accountant</strong> {{ __('or') }} <strong>Receptionist</strong>, {{ __('a system user account is provisioned automatically with default temporary password') }} <code>123456</code>.</div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary px-4 font-weight-bold">
                        <i class="fas fa-check mr-1"></i> {{ __('Create Staff Profile') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- EDIT STAFF MODALS                                              -->
<!-- ============================================================== -->
@foreach ($staffs as $item)
    <div class="modal fade staff-modal" id="editModal{{ $item->staff_id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $item->staff_id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('staffs.update', $item->staff_id) }}" method="POST" enctype="multipart/form-data" onsubmit="if (typeof showOverlay === 'function') showOverlay();">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <div>
                            <h5 class="modal-title font-weight-bold" id="editModalLabel{{ $item->staff_id }}">
                                <i class="fas fa-user-edit text-primary mr-1"></i>
                                {{ __('Edit Staff Profile') }}: {{ $item->name }}
                            </h5>
                            <p class="text-muted small mb-0">{{ __('Update personnel details, department allocation, or profile photo') }}</p>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body p-4">
                        <div class="form-row">
                            <!-- Staff Name -->
                            <div class="form-group col-md-6">
                                <label for="edit_name_{{ $item->staff_id }}" class="font-weight-bold text-sm">
                                    {{ __('Staff Full Name') }} <span class="text-danger">*</span>
                                </label>
                                <div class="input-group staff-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="edit_name_{{ $item->staff_id }}" name="name" value="{{ $item->name }}" required>
                                </div>
                            </div>

                            <!-- Sex -->
                            <div class="form-group col-md-6">
                                <label for="edit_sex_{{ $item->staff_id }}" class="font-weight-bold text-sm">
                                    {{ __('Sex / Gender') }} <span class="text-danger">*</span>
                                </label>
                                <div class="input-group staff-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                    </div>
                                    <select name="sex" id="edit_sex_{{ $item->staff_id }}" class="form-control" required>
                                        <option value="Male" {{ $item->sex === 'Male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                                        <option value="Female" {{ $item->sex === 'Female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="form-group col-md-6">
                                <label for="edit_email_{{ $item->staff_id }}" class="font-weight-bold text-sm">
                                    {{ __('Email Address') }} <span class="text-danger">*</span>
                                </label>
                                <div class="input-group staff-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email" class="form-control" id="edit_email_{{ $item->staff_id }}" name="email" value="{{ $item->email }}" required>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="form-group col-md-6">
                                <label for="edit_phone_{{ $item->staff_id }}" class="font-weight-bold text-sm">
                                    {{ __('Phone Number') }} <span class="text-danger">*</span>
                                </label>
                                <div class="input-group staff-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="edit_phone_{{ $item->staff_id }}" name="phone" value="{{ $item->phone }}" required>
                                </div>
                            </div>

                            <!-- Department -->
                            <div class="form-group col-md-6">
                                <label for="edit_department_{{ $item->staff_id }}" class="font-weight-bold text-sm">
                                    {{ __('Department') }} <span class="text-danger">*</span>
                                </label>
                                <div class="input-group staff-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                                    </div>
                                    <select name="department_id" id="edit_department_{{ $item->staff_id }}" class="form-control" required>
                                        <option value="">{{ __('Select Department') }}</option>
                                        @foreach($departments as $dept)
                                            <option value="{{ $dept->id }}" {{ $item->department_id == $dept->id ? 'selected' : '' }}>
                                                {{ $dept->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Position -->
                            <div class="form-group col-md-6">
                                <label for="edit_position_{{ $item->staff_id }}" class="font-weight-bold text-sm">
                                    {{ __('Position / Role') }} <span class="text-danger">*</span>
                                </label>
                                <div class="input-group staff-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                    </div>
                                    <input type="text" list="positionSuggestions" class="form-control" id="edit_position_{{ $item->staff_id }}" name="position" value="{{ $item->position }}" required>
                                </div>
                            </div>

                            <!-- Hire Date -->
                            <div class="form-group col-md-6">
                                <label for="edit_hire_date_{{ $item->staff_id }}" class="font-weight-bold text-sm">
                                    {{ __('Hire Date') }} <span class="text-danger">*</span>
                                </label>
                                <div class="input-group staff-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="date" class="form-control" id="edit_hire_date_{{ $item->staff_id }}" name="hire_date" value="{{ $item->hire_date }}" required>
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="form-group col-md-6">
                                <label for="edit_address_{{ $item->staff_id }}" class="font-weight-bold text-sm">
                                    {{ __('Residential Address') }} <span class="text-danger">*</span>
                                </label>
                                <div class="input-group staff-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="edit_address_{{ $item->staff_id }}" name="address" value="{{ $item->address }}" required>
                                </div>
                            </div>

                            <!-- Photo Upload & Current Photo -->
                            <div class="form-group col-12">
                                <label class="font-weight-bold text-sm">
                                    {{ __('Staff Photo') }}
                                </label>
                                <div class="d-flex align-items-center gap-3 p-3 rounded border" style="background: rgba(0,0,0,0.02);">
                                    <div class="text-center mr-3">
                                        <div class="small text-muted mb-1">{{ __('Photo') }}</div>
                                        <img id="photoPreview-{{ $item->staff_id }}"
                                             src="{{ (!empty($item->photo) && $item->photo !== 'noimg.jpg' && file_exists(public_path('staffs_image/' . $item->photo))) ? asset('staffs_image/' . $item->photo) : asset('staffs_image/noimg.jpg') }}"
                                             alt="Staff Photo"
                                             class="photo-preview-box mt-0">
                                    </div>
                                    <div class="flex-grow-1">
                                        <label for="editFileInput-{{ $item->staff_id }}" class="btn btn-sm btn-outline-primary mb-1">
                                            <i class="fas fa-upload mr-1"></i> {{ __('Choose New Photo...') }}
                                        </label>
                                        <input type="file"
                                               name="file"
                                               id="editFileInput-{{ $item->staff_id }}"
                                               accept=".jpeg,.jpg,.png,.gif,.ico"
                                               class="d-none edit-file-input"
                                               data-staff-id="{{ $item->staff_id }}">
                                        <div class="small text-muted">
                                            {{ __('Accepted formats: JPEG, PNG, GIF. Leave untouched to keep current photo.') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary px-4 font-weight-bold">
                            <i class="fas fa-save mr-1"></i> {{ __('Save Changes') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Live Client-Side Filtering & Search
    const searchInput = document.getElementById('staffSearchInput');
    const deptFilter = document.getElementById('staffDeptFilter');
    const genderFilter = document.getElementById('staffGenderFilter');
    const rows = document.querySelectorAll('.staff-row');
    const noResultRow = document.getElementById('noSearchStaffRow');
    const countBadge = document.getElementById('staffCountBadge');

    function applyFilters() {
        const query = (searchInput ? searchInput.value.trim().toLowerCase() : '');
        const selectedDept = (deptFilter ? deptFilter.value : 'all');
        const selectedGender = (genderFilter ? genderFilter.value : 'all');

        let visibleCount = 0;

        rows.forEach(row => {
            const searchData = row.getAttribute('data-search') || '';
            const rowDept = row.getAttribute('data-dept-id') || '';
            const rowGender = row.getAttribute('data-gender') || '';

            const matchesQuery = !query || searchData.includes(query);
            const matchesDept = (selectedDept === 'all' || selectedDept === '' || rowDept === selectedDept);
            const matchesGender = (selectedGender === 'all' || rowGender === selectedGender);

            if (matchesQuery && matchesDept && matchesGender) {
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
            countBadge.textContent = `${visibleCount} {{ __('Members') }}`;
        }
    }

    if (searchInput) searchInput.addEventListener('input', applyFilters);
    if (deptFilter) {
        deptFilter.addEventListener('change', function () {
            applyFilters();
            // Optional sync to query string without hard reload
            if (window.history && window.history.replaceState) {
                const url = new URL(window.location);
                if (this.value && this.value !== 'all') {
                    url.searchParams.set('department_id', this.value);
                } else {
                    url.searchParams.delete('department_id');
                }
                window.history.replaceState({}, '', url);
            }
        });
    }
    if (genderFilter) genderFilter.addEventListener('change', applyFilters);

    // 2. SweetAlert2 Delete Confirmation
    document.querySelectorAll('.delete-staff-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('form');
            const staffName = form.getAttribute('data-name') || 'this staff member';

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: '{{ __("Delete Staff Member?") }}',
                    html: `{{ __("Are you sure you want to remove") }} <strong>${staffName}</strong>?<br><small class="text-danger">{{ __("This action cannot be undone.") }}</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: '<i class="fas fa-trash-alt mr-1"></i> {{ __("Yes, delete staff") }}',
                    cancelButtonText: '{{ __("Cancel") }}',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (typeof showOverlay === 'function') showOverlay();
                        form.submit();
                    }
                });
            } else {
                if (confirm(`{{ __("Are you sure you want to delete") }} "${staffName}"?`)) {
                    if (typeof showOverlay === 'function') showOverlay();
                    form.submit();
                }
            }
        });
    });

    // 3. Edit Photo Upload Preview
    document.querySelectorAll('.edit-file-input').forEach(input => {
        input.addEventListener('change', function (e) {
            const staffId = this.getAttribute('data-staff-id');
            const previewImg = document.getElementById(`photoPreview-${staffId}`);
            if (this.files && this.files[0] && previewImg) {
                const reader = new FileReader();
                reader.onload = function (evt) {
                    previewImg.src = evt.target.result;
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
});

// Helper for Add Modal Live Photo Preview
function previewAddPhoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        const container = document.getElementById('addPhotoPreviewContainer');
        const img = document.getElementById('addPhotoPreviewImg');
        const label = document.getElementById('add_file_name_label');

        reader.onload = function (e) {
            if (img) img.src = e.target.result;
            if (container) container.style.display = 'block';
            if (label) label.textContent = input.files[0].name;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function removeAddPhoto() {
    const input = document.getElementById('add_file_input');
    const container = document.getElementById('addPhotoPreviewContainer');
    const img = document.getElementById('addPhotoPreviewImg');
    const label = document.getElementById('add_file_name_label');

    if (input) input.value = '';
    if (img) img.src = '#';
    if (container) container.style.display = 'none';
    if (label) label.textContent = '{{ __("Click to browse or drop photo here") }}';
}
</script>

@endsection
