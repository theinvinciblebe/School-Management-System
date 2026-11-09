@extends('layout.main')

@section('title', __('Teacher Management'))

@section('content')

<style>
/* ══════════════════════════════════════════════════════════════════
   TEACHER & FACULTY MANAGEMENT – Executive SaaS Design System
══════════════════════════════════════════════════════════════════ */
.teacher-dashboard-wrapper {
    padding: 0.5rem 0.25rem 2.5rem;
}

/* Header Action Box */
.teacher-header-box {
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
html.dark-mode .teacher-header-box {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 24px -2px rgba(0, 0, 0, 0.35);
}

.teacher-header-title {
    font-size: 1.35rem;
    font-weight: 800;
    margin-bottom: 0.2rem;
    display: flex;
    align-items: center;
    gap: 0.65rem;
    color: #1e293b;
}
html.dark-mode .teacher-header-title {
    color: #f8fafc;
}

.teacher-header-subtitle {
    font-size: 0.85rem;
    color: #64748b;
    margin: 0;
}
html.dark-mode .teacher-header-subtitle {
    color: #94a3b8;
}

.teacher-action-btn-group {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    flex-wrap: wrap;
}

.teacher-btn {
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
.teacher-btn-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
}
.teacher-btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
}
.teacher-btn-secondary {
    background: #f1f5f9;
    color: #334155 !important;
    border-color: #cbd5e1;
}
.teacher-btn-secondary:hover {
    background: #e2e8f0;
    color: #0f172a !important;
}
html.dark-mode .teacher-btn-secondary {
    background: #282f48;
    color: #e2e8f0 !important;
    border-color: #3b4261;
}
html.dark-mode .teacher-btn-secondary:hover {
    background: #333c5e;
}

/* KPI Cards Grid */
.teacher-kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem;
    margin-bottom: 1.25rem;
}

.teacher-kpi-card {
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
.teacher-kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
}
html.dark-mode .teacher-kpi-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.25);
}

.teacher-kpi-icon {
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

.teacher-kpi-value {
    font-size: 1.6rem;
    font-weight: 800;
    line-height: 1.1;
    color: #0f172a;
}
html.dark-mode .teacher-kpi-value {
    color: #f8fafc;
}
.teacher-kpi-label {
    font-size: 0.8rem;
    font-weight: 600;
    color: #64748b;
    margin-top: 0.2rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
html.dark-mode .teacher-kpi-label {
    color: #94a3b8;
}

/* Main Card */
.teacher-main-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.04);
    overflow: hidden;
}
html.dark-mode .teacher-main-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 24px -2px rgba(0, 0, 0, 0.35);
}

/* Card Toolbar & Filter Bar */
.teacher-card-toolbar {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.85rem;
    background: #fbfcfe;
}
html.dark-mode .teacher-card-toolbar {
    border-color: #2e354f;
    background: #191c2b;
}

.teacher-filters-group {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    flex-wrap: wrap;
}

.teacher-filter-select {
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
.teacher-filter-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}
html.dark-mode .teacher-filter-select {
    background-color: #1b1e2e;
    border-color: #3b4261;
    color: #f1f5f9;
    background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2214%22%20height%3D%2214%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%2394a3b8%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpath%20d%3D%22m6%209%206%206%206-6%22%2F%3E%3C%2Fsvg%3E");
}

.teacher-search-box {
    position: relative;
    min-width: 260px;
    flex-grow: 1;
    max-width: 360px;
}
.teacher-search-icon {
    position: absolute;
    left: 0.85rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.85rem;
    pointer-events: none;
}
.teacher-search-input {
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
.teacher-search-input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}
html.dark-mode .teacher-search-input {
    background: #1b1e2e;
    border-color: #3b4261;
    color: #f8fafc;
}
html.dark-mode .teacher-search-input::placeholder {
    color: #64748b;
}

/* Teacher Table */
.teacher-table {
    margin-bottom: 0;
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}
.teacher-table th {
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
html.dark-mode .teacher-table th {
    background: #191c2b;
    color: #94a3b8;
    border-color: #2e354f;
}

.teacher-table td {
    padding: 0.95rem 1.15rem;
    vertical-align: middle;
    border-top: 1px solid #f1f5f9;
    color: #334155;
    font-size: 0.875rem;
    transition: background 0.15s ease;
}
html.dark-mode .teacher-table td {
    border-color: #282f48;
    color: #cbd5e1;
}
.teacher-table tbody tr:hover td {
    background-color: #f8fafc;
}
html.dark-mode .teacher-table tbody tr:hover td {
    background-color: #252a3d;
}

/* Avatar box */
.teacher-avatar-box {
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
html.dark-mode .teacher-avatar-box {
    border-color: #2e354f;
    background: #282f48;
}
.teacher-avatar-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.2s ease;
}
.teacher-avatar-box:hover .teacher-avatar-img {
    transform: scale(1.08);
}
.teacher-avatar-initials {
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

.teacher-name {
    font-weight: 700;
    color: #0f172a;
    font-size: 0.95rem;
    line-height: 1.3;
}
html.dark-mode .teacher-name {
    color: #f8fafc;
}

.teacher-meta-badges {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    margin-top: 0.25rem;
    flex-wrap: wrap;
}

.teacher-id-pill {
    font-size: 0.72rem;
    font-weight: 600;
    padding: 0.12rem 0.45rem;
    border-radius: 6px;
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #e2e8f0;
    font-family: monospace;
}
html.dark-mode .teacher-id-pill {
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

.teacher-user-badge {
    font-size: 0.68rem;
    font-weight: 700;
    padding: 0.12rem 0.45rem;
    border-radius: 6px;
    background: rgba(16, 185, 129, 0.12);
    color: #059669;
    border: 1px solid rgba(16, 185, 129, 0.3);
}
html.dark-mode .teacher-user-badge {
    background: rgba(16, 185, 129, 0.2);
    color: #34d399;
    border-color: rgba(16, 185, 129, 0.4);
}

/* Subject Chips */
.subject-chip {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.78rem;
    font-weight: 600;
    color: #2563eb;
    background: rgba(37, 99, 235, 0.08);
    border: 1px solid rgba(37, 99, 235, 0.2);
    padding: 0.22rem 0.6rem;
    border-radius: 8px;
    margin: 0.15rem 0.25rem 0.15rem 0;
}
html.dark-mode .subject-chip {
    background: rgba(59, 130, 246, 0.15);
    color: #60a5fa;
    border-color: rgba(59, 130, 246, 0.3);
}

/* Contact Items */
.teacher-contact-item {
    font-size: 0.825rem;
    display: flex;
    align-items: center;
    gap: 0.45rem;
    margin-bottom: 0.25rem;
    color: #475569;
}
html.dark-mode .teacher-contact-item {
    color: #cbd5e1;
}
.teacher-contact-item a {
    color: inherit;
    text-decoration: none;
    transition: color 0.15s ease;
}
.teacher-contact-item a:hover {
    color: #3b82f6;
    text-decoration: underline;
}

/* Modals */
.teacher-modal .modal-content {
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}
html.dark-mode .teacher-modal .modal-content {
    background: #1e2235;
    border-color: #2e354f;
    color: #f1f5f9;
}
.teacher-modal .modal-header {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 1.15rem 1.5rem;
}
html.dark-mode .teacher-modal .modal-header {
    background: #191c2b;
    border-color: #2e354f;
}
.teacher-modal .modal-footer {
    border-top: 1px solid #e2e8f0;
    background: #f8fafc;
    padding: 0.95rem 1.5rem;
}
html.dark-mode .teacher-modal .modal-footer {
    border-color: #2e354f;
    background: #191c2b;
}

.teacher-input-group .input-group-text {
    background: #f8fafc;
    border-color: #cbd5e1;
    color: #64748b;
    border-radius: 10px 0 0 10px;
    width: 42px;
    justify-content: center;
}
html.dark-mode .teacher-input-group .input-group-text {
    background: #252a3d;
    border-color: #3b4261;
    color: #94a3b8;
}
.teacher-input-group .form-control {
    border-color: #cbd5e1;
    border-radius: 0 10px 10px 0;
    font-size: 0.875rem;
    height: 42px;
}
html.dark-mode .teacher-input-group .form-control {
    background: #1b1e2e;
    border-color: #3b4261;
    color: #f1f5f9;
}
.teacher-input-group .form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}

.teacher-photo-dropzone {
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    padding: 1rem;
    text-align: center;
    background: #f8fafc;
    transition: all 0.2s ease;
    cursor: pointer;
    position: relative;
}
.teacher-photo-dropzone:hover {
    border-color: #3b82f6;
    background: rgba(59, 130, 246, 0.04);
}
html.dark-mode .teacher-photo-dropzone {
    background: #191c2b;
    border-color: #3b4261;
}
html.dark-mode .teacher-photo-dropzone:hover {
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

.teacher-info-notice {
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
html.dark-mode .teacher-info-notice {
    background: rgba(59, 130, 246, 0.15);
    border-color: rgba(59, 130, 246, 0.35);
    color: #93c5fd;
}
</style>

@php
    $isAdmin = (Auth::user()->role == 0);
@endphp

<div class="teacher-dashboard-wrapper">
    <!-- Header Action Banner -->
    <div class="teacher-header-box">
        <div>
            <div class="teacher-header-title">
                <i class="fas fa-chalkboard-teacher text-primary"></i>
                {{ __('Faculty & Teacher Directory') }}
            </div>
            <p class="teacher-header-subtitle">
                {{ __('Manage academic instructors, course allocations, teaching credentials, and faculty portal accounts.') }}
            </p>
        </div>

        <div class="teacher-action-btn-group">
            <a href="{{ route('classesSubject') }}" class="teacher-btn teacher-btn-secondary" title="{{ __('Manage Course Subjects') }}">
                <i class="fas fa-book-open text-primary"></i>
                <span>{{ __('Subject Management') }}</span>
            </a>

            @if($isAdmin)
                <button type="button" class="teacher-btn teacher-btn-primary" data-toggle="modal" data-target="#addTeacherModal">
                    <i class="fas fa-user-plus"></i>
                    <span>{{ __('Add New Teacher') }}</span>
                </button>
            @endif
        </div>
    </div>

    <!-- Top KPI Metric Cards -->
    <div class="teacher-kpi-grid">
        <div class="teacher-kpi-card">
            <div class="teacher-kpi-icon kpi-indigo">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div>
                <div class="teacher-kpi-value">{{ $metrics['total_teachers'] ?? count($teachers) }}</div>
                <div class="teacher-kpi-label">{{ __('Total Faculty') }}</div>
            </div>
        </div>

        <div class="teacher-kpi-card">
            <div class="teacher-kpi-icon kpi-emerald">
                <i class="fas fa-user-check"></i>
            </div>
            <div>
                <div class="teacher-kpi-value">{{ $metrics['assigned_teachers'] ?? 0 }}</div>
                <div class="teacher-kpi-label">{{ __('Course Instructors') }}</div>
            </div>
        </div>

        <div class="teacher-kpi-card">
            <div class="teacher-kpi-icon kpi-sky">
                <i class="fas fa-mars"></i>
            </div>
            <div>
                <div class="teacher-kpi-value">{{ $metrics['male_teachers'] ?? 0 }}</div>
                <div class="teacher-kpi-label">{{ __('Male Faculty') }}</div>
            </div>
        </div>

        <div class="teacher-kpi-card">
            <div class="teacher-kpi-icon kpi-rose">
                <i class="fas fa-venus"></i>
            </div>
            <div>
                <div class="teacher-kpi-value">{{ $metrics['female_teachers'] ?? 0 }}</div>
                <div class="teacher-kpi-label">{{ __('Female Faculty') }}</div>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="teacher-main-card">
        <!-- Card Toolbar -->
        <div class="teacher-card-toolbar">
            <div class="d-flex align-items-center gap-2">
                <h5 class="mb-0 font-weight-bold" style="font-size: 1rem;">
                    {{ __('Academic Faculty Roster') }}
                </h5>
                <span class="badge badge-light border ml-2" id="teacherCountBadge" style="font-size: 0.78rem;">
                    {{ count($teachers) }} {{ __('Teachers') }}
                </span>
            </div>

            <!-- Filter Controls -->
            <div class="teacher-filters-group">
                <!-- Gender Filter -->
                <select id="teacherGenderFilter" class="teacher-filter-select" title="{{ __('Filter by Gender') }}">
                    <option value="all">{{ __('All Genders') }}</option>
                    <option value="1">{{ __('Male') }}</option>
                    <option value="0">{{ __('Female') }}</option>
                </select>

                <!-- Subject Assignment Filter -->
                <select id="teacherCourseFilter" class="teacher-filter-select" title="{{ __('Filter by Course Assignment') }}">
                    <option value="all">{{ __('All Faculty') }}</option>
                    <option value="assigned">{{ __('With Assigned Courses') }}</option>
                    <option value="unassigned">{{ __('Unassigned') }}</option>
                </select>

                <!-- Real-time Live Search -->
                <div class="teacher-search-box">
                    <i class="fas fa-search teacher-search-icon"></i>
                    <input type="text" id="teacherSearchInput" class="teacher-search-input" placeholder="{{ __('Search teacher, subject, email, phone...') }}" autocomplete="off">
                </div>
            </div>
        </div>

        <!-- Table View -->
        <div class="table-responsive">
            <table class="table teacher-table" id="teacherMasterTable">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>{{ __('Faculty Profile') }}</th>
                        <th>{{ __('Assigned Courses / Subjects') }}</th>
                        <th>{{ __('Contact Information') }}</th>
                        <th>{{ __('Personal Details & Location') }}</th>
                        <th style="width: 100px;" class="text-right">{{ __('Options') }}</th>
                    </tr>
                </thead>
                <tbody id="teacherTableBody">
                    @forelse($teachers as $index => $teacher)
                        @php
                            $subjectNames = $teacher->subjects->pluck('name')->implode(' ');
                            $searchBlob = strtolower(implode(' ', [
                                $teacher->name ?? '',
                                $teacher->email ?? '',
                                $teacher->phone ?? '',
                                $teacher->address ?? '',
                                $teacher->birthday ?? '',
                                $subjectNames
                            ]));
                            $isAssigned = ($teacher->subjects_count > 0);
                        @endphp
                        <tr class="teacher-row"
                            data-search="{{ $searchBlob }}"
                            data-gender="{{ $teacher->sex }}"
                            data-assignment="{{ $isAssigned ? 'assigned' : 'unassigned' }}">
                            <td class="text-muted font-weight-bold" style="font-size: 0.8rem;">
                                {{ $index + 1 }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="teacher-avatar-box mr-3">
                                        @if(!empty($teacher->photo) && $teacher->photo !== 'noimg.jpg' && file_exists(public_path('teachers_image/' . $teacher->photo)))
                                            <img src="{{ asset('teachers_image/' . $teacher->photo) }}"
                                                 alt="{{ $teacher->name }}"
                                                 class="teacher-avatar-img">
                                        @else
                                            <div class="teacher-avatar-initials">
                                                {{ strtoupper(mb_substr($teacher->name, 0, 2)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="teacher-name">
                                            {{ $teacher->name }}
                                        </div>
                                        <div class="teacher-meta-badges">
                                            <span class="teacher-id-pill" title="{{ __('Teacher ID') }}">
                                                #T-{{ str_pad($teacher->teacher_id, 4, '0', STR_PAD_LEFT) }}
                                            </span>
                                            @if($teacher->sex == 1)
                                                <span class="badge-gender-male">
                                                    <i class="fas fa-mars mr-1"></i>{{ __('Male') }}
                                                </span>
                                            @else
                                                <span class="badge-gender-female">
                                                    <i class="fas fa-venus mr-1"></i>{{ __('Female') }}
                                                </span>
                                            @endif
                                            <span class="teacher-user-badge" title="{{ __('Faculty user portal active') }}">
                                                <i class="fas fa-shield-alt mr-1"></i>{{ __('Faculty') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($isAssigned)
                                    <div class="d-flex flex-wrap align-items-center">
                                        @foreach($teacher->subjects as $subj)
                                            <span class="subject-chip" title="{{ __('Assigned Subject') }}">
                                                <i class="fas fa-book"></i>
                                                {{ $subj->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted small">
                                        <i class="fas fa-book-open opacity-50 mr-1"></i>
                                        {{ __('No courses assigned') }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="teacher-contact-item">
                                    <i class="far fa-envelope text-primary"></i>
                                    @if(!empty($teacher->email))
                                        <a href="mailto:{{ $teacher->email }}">{{ $teacher->email }}</a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                                <div class="teacher-contact-item">
                                    <i class="fas fa-phone-alt text-success"></i>
                                    @if(!empty($teacher->phone))
                                        <a href="tel:{{ $teacher->phone }}">{{ $teacher->phone }}</a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="text-muted small">
                                    <i class="fas fa-birthday-cake text-warning mr-1"></i>
                                    {{ !empty($teacher->birthday) ? date('M d, Y', strtotime($teacher->birthday)) : __('Birthday N/A') }}
                                </div>
                                <div class="text-muted small mt-1">
                                    <i class="fas fa-map-marker-alt text-danger mr-1"></i>
                                    {{ $teacher->address ?: __('Address not provided') }}
                                </div>
                            </td>
                            <td class="text-right">
                                @if($isAdmin)
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius: 8px;">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right shadow-sm border-0" style="border-radius: 10px;">
                                            <button type="button" class="dropdown-item text-primary font-weight-500 py-2" data-toggle="modal" data-target="#editTeacherModal{{ $teacher->teacher_id }}">
                                                <i class="fas fa-edit mr-2"></i> {{ __('Edit Teacher') }}
                                            </button>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('teachers.destroy', $teacher->teacher_id) }}" method="POST" class="delete-teacher-form" data-name="{{ $teacher->name }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="dropdown-item text-danger font-weight-500 py-2 delete-teacher-btn">
                                                    <i class="fas fa-trash-alt mr-2"></i> {{ __('Delete Teacher') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <span class="badge badge-light border text-muted">
                                        <i class="fas fa-eye mr-1"></i> {{ __('View Only') }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr id="emptyTeacherRow">
                            <td colspan="6" class="text-center py-5 text-muted">
                                <div class="py-4">
                                    <i class="fas fa-chalkboard-teacher fa-3x mb-3 text-secondary opacity-50"></i>
                                    <p class="font-weight-bold mb-1">{{ __('No teachers found') }}</p>
                                    <p class="small text-muted mb-3">{{ __('Add instructors and faculty to oversee course curriculums and student learning.') }}</p>
                                    @if($isAdmin)
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addTeacherModal">
                                            <i class="fas fa-plus mr-1"></i> {{ __('Add Faculty Member') }}
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    <tr id="noSearchTeacherRow" style="display: none;">
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-search fa-2x mb-2 text-secondary opacity-50"></i>
                            <p class="font-weight-bold mb-0">{{ __('No matching teachers found') }}</p>
                            <small>{{ __('Try modifying your search keywords or adjusting the filter criteria.') }}</small>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($isAdmin)
    <!-- ============================================================== -->
    <!-- MODAL: ADD TEACHER                                             -->
    <!-- ============================================================== -->
    <div class="modal fade teacher-modal" id="addTeacherModal" tabindex="-1" role="dialog" aria-labelledby="addTeacherModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('teachers.store') }}" method="POST" enctype="multipart/form-data" onsubmit="if (typeof showOverlay === 'function') showOverlay();">
                    @csrf
                    <div class="modal-header">
                        <div>
                            <h5 class="modal-title font-weight-bold" id="addTeacherModalLabel">
                                <i class="fas fa-user-plus text-primary mr-1"></i>
                                {{ __('Add New Faculty Member') }}
                            </h5>
                            <p class="text-muted small mb-0">{{ __('Enroll teacher credentials and generate system login profile') }}</p>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body p-4">
                        <div class="form-row">
                            <!-- Teacher Name -->
                            <div class="form-group col-md-6">
                                <label for="add_name" class="font-weight-bold text-sm">
                                    {{ __('Faculty Full Name') }} <span class="text-danger">*</span>
                                </label>
                                <div class="input-group teacher-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="add_name" name="name" placeholder="{{ __('e.g., Prof. Sarah Jenkins') }}" required autofocus>
                                </div>
                            </div>

                            <!-- Sex / Gender -->
                            <div class="form-group col-md-6">
                                <label for="add_sex" class="font-weight-bold text-sm">
                                    {{ __('Sex / Gender') }} <span class="text-danger">*</span>
                                </label>
                                <div class="input-group teacher-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                    </div>
                                    <select name="sex" id="add_sex" class="form-control" required>
                                        <option value="1">{{ __('Male') }}</option>
                                        <option value="0">{{ __('Female') }}</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Email Address -->
                            <div class="form-group col-md-6">
                                <label for="add_email" class="font-weight-bold text-sm">
                                    {{ __('Email Address') }} <span class="text-danger">*</span>
                                </label>
                                <div class="input-group teacher-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email" class="form-control" id="add_email" name="email" placeholder="{{ __('e.g., s.jenkins@school.edu') }}" required>
                                </div>
                            </div>

                            <!-- Phone Number -->
                            <div class="form-group col-md-6">
                                <label for="add_phone" class="font-weight-bold text-sm">
                                    {{ __('Phone Number') }} <span class="text-danger">*</span>
                                </label>
                                <div class="input-group teacher-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="add_phone" name="phone" placeholder="{{ __('e.g., +1 234 567 8900') }}" required>
                                </div>
                            </div>

                            <!-- Birthday -->
                            <div class="form-group col-md-6">
                                <label for="add_birthday" class="font-weight-bold text-sm">
                                    {{ __('Date of Birth') }} <span class="text-danger">*</span>
                                </label>
                                <div class="input-group teacher-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="date" class="form-control" id="add_birthday" name="birthday" required>
                                </div>
                            </div>

                            <!-- Residential Address -->
                            <div class="form-group col-md-6">
                                <label for="add_address" class="font-weight-bold text-sm">
                                    {{ __('Residential Address') }} <span class="text-danger">*</span>
                                </label>
                                <div class="input-group teacher-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="add_address" name="address" placeholder="{{ __('Street, District, City') }}" required>
                                </div>
                            </div>

                            <!-- Profile Photo Upload with Live Preview -->
                            <div class="form-group col-12">
                                <label class="font-weight-bold text-sm">
                                    {{ __('Profile Photo') }} <small class="text-muted">({{ __('Optional, JPG/PNG, max 2MB') }})</small>
                                </label>
                                <div class="teacher-photo-dropzone text-center" onclick="document.getElementById('add_file_input').click();">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-primary mb-2"></i>
                                    <div class="font-weight-bold text-sm" id="add_file_name_label">{{ __('Click to browse or drop photo here') }}</div>
                                    <small class="text-muted">{{ __('Supports JPG, PNG, GIF files') }}</small>
                                    <input type="file" name="file" id="add_file_input" accept="image/*" class="d-none" onchange="previewAddTeacherPhoto(this)">
                                    <div id="addPhotoPreviewContainer" style="display: none;" class="mt-3">
                                        <img id="addPhotoPreviewImg" src="#" alt="Preview" class="photo-preview-box">
                                        <button type="button" class="btn btn-xs btn-outline-danger mt-1" onclick="event.stopPropagation(); removeAddTeacherPhoto();">
                                            <i class="fas fa-times mr-1"></i> {{ __('Remove Photo') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- User Account Notice -->
                        <div class="teacher-info-notice mt-2">
                            <i class="fas fa-info-circle text-primary mt-1"></i>
                            <div>
                                <strong>{{ __('Faculty User Account Notice:') }}</strong>
                                <div>{{ __('A system login account is created automatically with role') }} <strong>Teacher</strong> {{ __('and default password') }} <code>123456</code>. {{ __('The teacher can update their password after initial login.') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary px-4 font-weight-bold">
                            <i class="fas fa-check mr-1"></i> {{ __('Register Faculty Member') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- EDIT TEACHER MODALS                                            -->
    <!-- ============================================================== -->
    @foreach ($teachers as $teacher)
        <div class="modal fade teacher-modal" id="editTeacherModal{{ $teacher->teacher_id }}" tabindex="-1" role="dialog" aria-labelledby="editTeacherModalLabel{{ $teacher->teacher_id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form action="{{ route('teachers.update', $teacher->teacher_id) }}" method="POST" enctype="multipart/form-data" onsubmit="if (typeof showOverlay === 'function') showOverlay();">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <div>
                                <h5 class="modal-title font-weight-bold" id="editTeacherModalLabel{{ $teacher->teacher_id }}">
                                    <i class="fas fa-user-edit text-primary mr-1"></i>
                                    {{ __('Edit Faculty Profile') }}: {{ $teacher->name }}
                                </h5>
                                <p class="text-muted small mb-0">{{ __('Update faculty contact details, birthday, address, or profile photo') }}</p>
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body p-4">
                            <div class="form-row">
                                <!-- Name -->
                                <div class="form-group col-md-6">
                                    <label for="edit_name_{{ $teacher->teacher_id }}" class="font-weight-bold text-sm">
                                        {{ __('Faculty Full Name') }} <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group teacher-input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="edit_name_{{ $teacher->teacher_id }}" name="name" value="{{ $teacher->name }}" required>
                                    </div>
                                </div>

                                <!-- Gender -->
                                <div class="form-group col-md-6">
                                    <label for="edit_sex_{{ $teacher->teacher_id }}" class="font-weight-bold text-sm">
                                        {{ __('Sex / Gender') }} <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group teacher-input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                        </div>
                                        <select name="sex" id="edit_sex_{{ $teacher->teacher_id }}" class="form-control" required>
                                            <option value="1" {{ $teacher->sex == 1 ? 'selected' : '' }}>{{ __('Male') }}</option>
                                            <option value="0" {{ $teacher->sex == 0 ? 'selected' : '' }}>{{ __('Female') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="form-group col-md-6">
                                    <label for="edit_email_{{ $teacher->teacher_id }}" class="font-weight-bold text-sm">
                                        {{ __('Email Address') }} <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group teacher-input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input type="email" class="form-control" id="edit_email_{{ $teacher->teacher_id }}" name="email" value="{{ $teacher->email }}" required>
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div class="form-group col-md-6">
                                    <label for="edit_phone_{{ $teacher->teacher_id }}" class="font-weight-bold text-sm">
                                        {{ __('Phone Number') }} <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group teacher-input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="edit_phone_{{ $teacher->teacher_id }}" name="phone" value="{{ $teacher->phone }}" required>
                                    </div>
                                </div>

                                <!-- Birthday -->
                                <div class="form-group col-md-6">
                                    <label for="edit_birthday_{{ $teacher->teacher_id }}" class="font-weight-bold text-sm">
                                        {{ __('Date of Birth') }} <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group teacher-input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="date" class="form-control" id="edit_birthday_{{ $teacher->teacher_id }}" name="birthday" value="{{ $teacher->birthday }}" required>
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="form-group col-md-6">
                                    <label for="edit_address_{{ $teacher->teacher_id }}" class="font-weight-bold text-sm">
                                        {{ __('Residential Address') }} <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group teacher-input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="edit_address_{{ $teacher->teacher_id }}" name="address" value="{{ $teacher->address }}" required>
                                    </div>
                                </div>

                                <!-- Photo Upload & Current Photo -->
                                <div class="form-group col-12">
                                    <label class="font-weight-bold text-sm">
                                        {{ __('Teacher Photo') }}
                                    </label>
                                    <div class="d-flex align-items-center gap-3 p-3 rounded border" style="background: rgba(0,0,0,0.02);">
                                        <div class="text-center mr-3">
                                            <div class="small text-muted mb-1">{{ __('Photo') }}</div>
                                            <img id="photoPreview-{{ $teacher->teacher_id }}"
                                                 src="{{ (!empty($teacher->photo) && $teacher->photo !== 'noimg.jpg' && file_exists(public_path('teachers_image/' . $teacher->photo))) ? asset('teachers_image/' . $teacher->photo) : asset('teachers_image/noimg.jpg') }}"
                                                 alt="Teacher Photo"
                                                 class="photo-preview-box mt-0">
                                        </div>
                                        <div class="flex-grow-1">
                                            <label for="editFileInput-{{ $teacher->teacher_id }}" class="btn btn-sm btn-outline-primary mb-1">
                                                <i class="fas fa-upload mr-1"></i> {{ __('Choose New Photo...') }}
                                            </label>
                                            <input type="file"
                                                   name="file"
                                                   id="editFileInput-{{ $teacher->teacher_id }}"
                                                   accept=".jpeg,.jpg,.png,.gif,.ico"
                                                   class="d-none edit-teacher-file-input"
                                                   data-teacher-id="{{ $teacher->teacher_id }}">
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
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Live Client-Side Multi-Filter & Search
    const searchInput = document.getElementById('teacherSearchInput');
    const genderFilter = document.getElementById('teacherGenderFilter');
    const courseFilter = document.getElementById('teacherCourseFilter');
    const rows = document.querySelectorAll('.teacher-row');
    const noResultRow = document.getElementById('noSearchTeacherRow');
    const countBadge = document.getElementById('teacherCountBadge');

    function applyFilters() {
        const query = (searchInput ? searchInput.value.trim().toLowerCase() : '');
        const selectedGender = (genderFilter ? genderFilter.value : 'all');
        const selectedCourse = (courseFilter ? courseFilter.value : 'all');

        let visibleCount = 0;

        rows.forEach(row => {
            const searchData = row.getAttribute('data-search') || '';
            const rowGender = row.getAttribute('data-gender') || '';
            const rowAssignment = row.getAttribute('data-assignment') || '';

            const matchesQuery = !query || searchData.includes(query);
            const matchesGender = (selectedGender === 'all' || rowGender === selectedGender);
            const matchesCourse = (selectedCourse === 'all' || rowAssignment === selectedCourse);

            if (matchesQuery && matchesGender && matchesCourse) {
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
            countBadge.textContent = `${visibleCount} {{ __('Teachers') }}`;
        }
    }

    if (searchInput) searchInput.addEventListener('input', applyFilters);
    if (genderFilter) genderFilter.addEventListener('change', applyFilters);
    if (courseFilter) courseFilter.addEventListener('change', applyFilters);

    // 2. SweetAlert2 Delete Confirmation
    document.querySelectorAll('.delete-teacher-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('form');
            const teacherName = form.getAttribute('data-name') || 'this teacher';

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: '{{ __("Delete Faculty Member?") }}',
                    html: `{{ __("Are you sure you want to remove") }} <strong>${teacherName}</strong>?<br><small class="text-danger">{{ __("Their user account and assigned subject linkages will be deleted.") }}</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: '<i class="fas fa-trash-alt mr-1"></i> {{ __("Yes, delete teacher") }}',
                    cancelButtonText: '{{ __("Cancel") }}',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (typeof showOverlay === 'function') showOverlay();
                        form.submit();
                    }
                });
            } else {
                if (confirm(`{{ __("Are you sure you want to delete") }} "${teacherName}"?`)) {
                    if (typeof showOverlay === 'function') showOverlay();
                    form.submit();
                }
            }
        });
    });

    // 3. Edit Photo Live Preview
    document.querySelectorAll('.edit-teacher-file-input').forEach(input => {
        input.addEventListener('change', function (e) {
            const teacherId = this.getAttribute('data-teacher-id');
            const previewImg = document.getElementById(`photoPreview-${teacherId}`);
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
function previewAddTeacherPhoto(input) {
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

function removeAddTeacherPhoto() {
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
