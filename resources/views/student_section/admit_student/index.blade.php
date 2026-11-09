@extends('layout.main')

@section('title', __('Student Directory & Roster'))

@section('content')

<style>
/* ══════════════════════════════════════════════════════════════════
   STUDENT DIRECTORY – Executive SaaS Design System
══════════════════════════════════════════════════════════════════ */
.std-dashboard-wrapper {
    padding: 0.5rem 0.25rem 2.5rem;
}

/* Header Box */
.std-header-box {
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
.std-header-box::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 5px;
    height: 100%;
    background: linear-gradient(180deg, #3b82f6, #10b981);
}
html.dark-mode .std-header-box {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 24px -2px rgba(0, 0, 0, 0.35);
}

.std-header-title {
    font-size: 1.35rem;
    font-weight: 800;
    margin-bottom: 0.2rem;
    display: flex;
    align-items: center;
    gap: 0.65rem;
    color: #1e293b;
}
html.dark-mode .std-header-title {
    color: #f8fafc;
}

.std-header-subtitle {
    font-size: 0.85rem;
    color: #64748b;
    margin: 0;
}
html.dark-mode .std-header-subtitle {
    color: #94a3b8;
}

.std-action-group {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    flex-wrap: wrap;
}

.btn-std {
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
.btn-std-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
}
.btn-std-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
}
.btn-std-secondary {
    background: #f1f5f9;
    color: #334155 !important;
    border-color: #cbd5e1;
}
.btn-std-secondary:hover {
    background: #e2e8f0;
    color: #0f172a !important;
}
html.dark-mode .btn-std-secondary {
    background: #282f48;
    color: #e2e8f0 !important;
    border-color: #3b4261;
}
html.dark-mode .btn-std-secondary:hover {
    background: #333c5e;
}

/* KPI Cards Grid */
.std-kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem;
    margin-bottom: 1.25rem;
}

.std-kpi-card {
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
.std-kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
}
html.dark-mode .std-kpi-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.25);
}

.std-kpi-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}
.kpi-blue    { background: rgba(59, 130, 246, 0.12); color: #3b82f6; }
.kpi-indigo  { background: rgba(99, 102, 241, 0.12); color: #6366f1; }
.kpi-rose    { background: rgba(244, 63, 94, 0.12); color: #f43f5e; }
.kpi-emerald { background: rgba(16, 185, 129, 0.12); color: #10b981; }

.std-kpi-value {
    font-size: 1.55rem;
    font-weight: 800;
    line-height: 1.1;
    color: #0f172a;
}
html.dark-mode .std-kpi-value {
    color: #f8fafc;
}
.std-kpi-label {
    font-size: 0.78rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: #64748b;
    margin-top: 0.15rem;
}
html.dark-mode .std-kpi-label {
    color: #94a3b8;
}

/* Main Table Card */
.std-main-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.04);
}
html.dark-mode .std-main-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 24px -2px rgba(0, 0, 0, 0.35);
}

.std-toolbar {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.85rem;
    background: #f8fafc;
}
html.dark-mode .std-toolbar {
    background: #191c2b;
    border-color: #2e354f;
}

.std-filter-tabs {
    display: flex;
    align-items: center;
    gap: 0.35rem;
    background: #e2e8f0;
    padding: 0.25rem;
    border-radius: 10px;
}
html.dark-mode .std-filter-tabs {
    background: #252a3d;
}
.std-filter-pill {
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
.std-filter-pill:hover {
    color: #1e293b;
}
.std-filter-pill.active {
    background: #ffffff;
    color: #2563eb;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
}
html.dark-mode .std-filter-pill {
    color: #94a3b8;
}
html.dark-mode .std-filter-pill.active {
    background: #1e2235;
    color: #60a5fa;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
}
.std-filter-count {
    font-size: 0.72rem;
    padding: 0.1rem 0.4rem;
    border-radius: 10px;
    background: rgba(100, 116, 139, 0.15);
}
.std-filter-pill.active .std-filter-count {
    background: rgba(37, 99, 235, 0.15);
}

.std-search-box {
    position: relative;
    min-width: 250px;
    max-width: 380px;
    flex: 1;
}
.std-search-input {
    width: 100%;
    padding: 0.45rem 1rem 0.45rem 2.25rem;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 0.875rem;
    background: #ffffff;
    color: #1e293b;
    transition: all 0.2s;
}
.std-search-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}
html.dark-mode .std-search-input {
    background: #252a3d;
    border-color: #3b4261;
    color: #f1f5f9;
}
.std-search-icon {
    position: absolute;
    left: 0.8rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.85rem;
    pointer-events: none;
}

/* Modern Table */
.std-table {
    margin: 0;
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}
.std-table thead th {
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
html.dark-mode .std-table thead th {
    background: #191c2b;
    color: #94a3b8;
    border-color: #2e354f;
}
.std-table tbody td {
    padding: 0.95rem 1rem;
    vertical-align: middle;
    border-top: none;
    border-bottom: 1px solid #f1f5f9;
    font-size: 0.88rem;
    color: #334155;
}
html.dark-mode .std-table tbody td {
    border-color: #262c44;
    color: #cbd5e1;
}
.std-table tbody tr:hover {
    background: #f8fafc;
}
html.dark-mode .std-table tbody tr:hover {
    background: #22273c;
}

/* Student Avatar Box */
.std-avatar-box {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    overflow: hidden;
    position: relative;
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.std-avatar-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.std-avatar-initials {
    font-weight: 800;
    font-size: 0.95rem;
    color: #2563eb;
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}
html.dark-mode .std-avatar-initials {
    background: linear-gradient(135deg, #1e3a8a, #2563eb);
    color: #bfdbfe;
}

.std-name {
    font-weight: 700;
    color: #0f172a;
    font-size: 0.95rem;
    line-height: 1.2;
}
html.dark-mode .std-name {
    color: #f8fafc;
}

.badge-pill-custom {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.15rem 0.5rem;
    border-radius: 6px;
    font-size: 0.72rem;
    font-weight: 600;
}
.badge-gender-male {
    background: rgba(59, 130, 246, 0.1);
    color: #2563eb;
    border: 1px solid rgba(59, 130, 246, 0.2);
}
.badge-gender-female {
    background: rgba(244, 63, 94, 0.1);
    color: #e11d48;
    border: 1px solid rgba(244, 63, 94, 0.2);
}

.class-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.78rem;
    font-weight: 600;
    color: #4f46e5;
    background: rgba(99, 102, 241, 0.08);
    border: 1px solid rgba(99, 102, 241, 0.2);
    padding: 0.2rem 0.6rem;
    border-radius: 8px;
}
html.dark-mode .class-pill {
    background: rgba(99, 102, 241, 0.18);
    color: #a5b4fc;
}

.section-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.78rem;
    font-weight: 600;
    color: #059669;
    background: rgba(16, 185, 129, 0.08);
    border: 1px solid rgba(16, 185, 129, 0.2);
    padding: 0.2rem 0.55rem;
    border-radius: 8px;
}
html.dark-mode .section-pill {
    background: rgba(16, 185, 129, 0.18);
    color: #34d399;
}

.contact-line {
    font-size: 0.8rem;
    color: #475569;
    display: flex;
    align-items: center;
    gap: 0.35rem;
}
html.dark-mode .contact-line {
    color: #cbd5e1;
}

/* Action Icon Buttons */
.std-actions-group {
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
.std-modal .modal-content {
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}
html.dark-mode .std-modal .modal-content {
    background: #1e2235;
    border-color: #2e354f;
    color: #f1f5f9;
}
.std-modal .modal-header {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 1.15rem 1.5rem;
}
html.dark-mode .std-modal .modal-header {
    background: #191c2b;
    border-color: #2e354f;
}
.std-modal .modal-footer {
    border-top: 1px solid #e2e8f0;
    background: #f8fafc;
    padding: 0.95rem 1.5rem;
}
html.dark-mode .std-modal .modal-footer {
    border-color: #2e354f;
    background: #191c2b;
}
</style>

@php
    $totalStudents = count($students);
    $maleCount = $students->where('sex', 1)->count();
    $femaleCount = $students->where('sex', 0)->count();
    $assignedCount = $students->whereNotNull('class_name')->count();
@endphp

<div class="std-dashboard-wrapper">
    <!-- Header Banner -->
    <div class="std-header-box">
        <div>
            <div class="std-header-title">
                <i class="fas fa-user-graduate text-primary"></i>
                {{ __('Student Directory & Roster') }}
            </div>
            <p class="std-header-subtitle">
                {{ __('Manage enrolled students, monitor class and section assignments, guardian contacts, and student profiles.') }}
            </p>
        </div>

        <div class="std-action-group">
            <a href="{{ route('sessions.index') }}" class="btn-std btn-std-secondary" title="{{ __('Manage Academic Sessions') }}">
                <i class="fas fa-calendar-alt text-primary"></i>
                <span>{{ __('Academic Sessions') }}</span>
            </a>

            @if (Auth::user()->role == 0 || Auth::user()->role == 3 || Auth::user()->role == 4)
                <a href="{{ route('students.create') }}" class="btn-std btn-std-primary" title="{{ __('Add New Student') }}">
                    <i class="fas fa-plus"></i>
                    <span>{{ __('Admit New Student') }}</span>
                </a>
            @endif
        </div>
    </div>

    <!-- Top KPI Metric Cards -->
    <div class="std-kpi-grid">
        <div class="std-kpi-card">
            <div class="std-kpi-icon kpi-blue">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div>
                <div class="std-kpi-value">{{ $totalStudents }}</div>
                <div class="std-kpi-label">{{ __('Total Students') }}</div>
            </div>
        </div>

        <div class="std-kpi-card">
            <div class="std-kpi-icon kpi-indigo">
                <i class="fas fa-mars"></i>
            </div>
            <div>
                <div class="std-kpi-value">{{ $maleCount }}</div>
                <div class="std-kpi-label">{{ __('Male Students') }}</div>
            </div>
        </div>

        <div class="std-kpi-card">
            <div class="std-kpi-icon kpi-rose">
                <i class="fas fa-venus"></i>
            </div>
            <div>
                <div class="std-kpi-value">{{ $femaleCount }}</div>
                <div class="std-kpi-label">{{ __('Female Students') }}</div>
            </div>
        </div>

        <div class="std-kpi-card">
            <div class="std-kpi-icon kpi-emerald">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div>
                <div class="std-kpi-value">{{ $assignedCount }}</div>
                <div class="std-kpi-label">{{ __('Class Placed') }}</div>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="std-main-card">
        <!-- Toolbar -->
        <div class="std-toolbar">
            <div class="std-filter-tabs">
                <button type="button" class="std-filter-pill active" data-filter="all">
                    <span>{{ __('All') }}</span>
                    <span class="std-filter-count">{{ $totalStudents }}</span>
                </button>
                <button type="button" class="std-filter-pill" data-filter="male">
                    <span>{{ __('Male') }}</span>
                    <span class="std-filter-count">{{ $maleCount }}</span>
                </button>
                <button type="button" class="std-filter-pill" data-filter="female">
                    <span>{{ __('Female') }}</span>
                    <span class="std-filter-count">{{ $femaleCount }}</span>
                </button>
                <button type="button" class="std-filter-pill" data-filter="assigned">
                    <span>{{ __('Assigned') }}</span>
                    <span class="std-filter-count">{{ $assignedCount }}</span>
                </button>
                <button type="button" class="std-filter-pill" data-filter="unassigned">
                    <span>{{ __('Unassigned') }}</span>
                    <span class="std-filter-count">{{ $totalStudents - $assignedCount }}</span>
                </button>
            </div>

            <div class="d-flex align-items-center" style="gap: 0.65rem; flex: 1; max-width: 520px;">
                <select id="classFilterSelect" class="form-control form-control-sm" style="max-width: 160px; border-radius: 10px;">
                    <option value="">{{ __('All Classes') }}</option>
                    @foreach($classes as $c)
                        <option value="{{ strtolower($c->name) }}">{{ $c->name }}</option>
                    @endforeach
                </select>

                <div class="std-search-box">
                    <i class="fas fa-search std-search-icon"></i>
                    <input type="text" id="stdSearchInput" class="std-search-input" placeholder="{{ __('Search student, roll, parent, email, phone...') }}" autocomplete="off">
                </div>
            </div>
        </div>

        <!-- Responsive Table -->
        <div class="table-responsive">
            <table class="table std-table" id="studentMasterTable">
                <thead>
                    <tr>
                        <th style="width: 45px;">#</th>
                        <th>{{ __('Student Profile') }}</th>
                        <th>{{ __('Class Placement') }}</th>
                        <th>{{ __('Guardian Details') }}</th>
                        <th>{{ __('Contact & Location') }}</th>
                        <th>{{ __('Date of Birth') }}</th>
                        <th style="width: 90px;" class="text-right">{{ __('Options') }}</th>
                    </tr>
                </thead>
                <tbody id="stdTableBody">
                    @forelse($students as $index => $student)
                        @php
                            $searchBlob = strtolower(implode(' ', [
                                $student->student_name ?? '',
                                $student->roll ?? '',
                                $student->class_name ?? '',
                                $student->section_name ?? '',
                                $student->parent_name ?? '',
                                $student->parent_phone ?? '',
                                $student->phone ?? '',
                                $student->email ?? '',
                                $student->address ?? '',
                            ]));
                            $isPlaced = !empty($student->class_name);
                        @endphp
                        <tr class="std-row"
                            data-search="{{ $searchBlob }}"
                            data-gender="{{ $student->sex == 1 ? 'male' : 'female' }}"
                            data-placement="{{ $isPlaced ? 'assigned' : 'unassigned' }}"
                            data-class="{{ strtolower($student->class_name ?? '') }}">
                            <td class="text-muted font-weight-bold" style="font-size: 0.8rem;">
                                {{ $index + 1 }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="std-avatar-box mr-2.5">
                                        @if(!empty($student->photo) && $student->photo !== 'noimg.jpg' && file_exists(public_path('students_image/' . $student->photo)))
                                            <img src="{{ asset('students_image/' . $student->photo) }}" alt="{{ $student->student_name }}" class="std-avatar-img">
                                        @else
                                            <div class="std-avatar-initials">
                                                {{ strtoupper(mb_substr($student->student_name ?? 'S', 0, 2)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="std-name">{{ $student->student_name }}</div>
                                        <div class="d-flex align-items-center mt-1" style="gap: 0.35rem;">
                                            @if($student->roll)
                                                <span class="badge badge-light border small font-weight-bold">
                                                    {{ __('Roll:') }} {{ $student->roll }}
                                                </span>
                                            @endif
                                            @if($student->sex == 1)
                                                <span class="badge-pill-custom badge-gender-male">
                                                    <i class="fas fa-mars mr-1"></i>{{ __('Male') }}
                                                </span>
                                            @else
                                                <span class="badge-pill-custom badge-gender-female">
                                                    <i class="fas fa-venus mr-1"></i>{{ __('Female') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($isPlaced)
                                    <div>
                                        <span class="class-pill">
                                            <i class="fas fa-graduation-cap"></i>
                                            {{ $student->class_name }}
                                        </span>
                                    </div>
                                    <div class="mt-1">
                                        <span class="section-pill">
                                            <i class="fas fa-layer-group"></i>
                                            {{ $student->section_name ?? __('General') }}
                                        </span>
                                    </div>
                                @else
                                    <span class="badge badge-light border text-muted small">
                                        <em>{{ __('Unassigned') }}</em>
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="font-weight-bold text-dark" style="font-size: 0.88rem;">
                                    <i class="fas fa-user-shield text-primary mr-1"></i>
                                    {{ $student->parent_name ?: __('Not registered') }}
                                </div>
                                @if($student->parent_phone)
                                    <div class="contact-line mt-0.5">
                                        <i class="fas fa-phone text-secondary"></i>
                                        <a href="tel:{{ $student->parent_phone }}" class="text-dark text-decoration-none">{{ $student->parent_phone }}</a>
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if($student->phone)
                                    <div class="contact-line mb-1">
                                        <i class="fas fa-phone-alt text-primary"></i>
                                        <span>{{ $student->phone }}</span>
                                    </div>
                                @endif
                                @if($student->email && $student->email !== 'No Email')
                                    <div class="contact-line mb-1">
                                        <i class="far fa-envelope text-secondary"></i>
                                        <a href="mailto:{{ $student->email }}" class="text-dark text-decoration-none text-truncate" style="max-width: 160px;">{{ $student->email }}</a>
                                    </div>
                                @endif
                                @if($student->address)
                                    <div class="contact-line">
                                        <i class="fas fa-map-marker-alt text-muted"></i>
                                        <span class="text-truncate" style="max-width: 170px;" title="{{ $student->address }}">{{ $student->address }}</span>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="small text-muted font-weight-500">
                                    <i class="far fa-calendar-alt text-primary mr-1"></i>
                                    {{ $student->birthday ?: 'N/A' }}
                                </div>
                            </td>
                            <td class="text-right">
                                @if (Auth::user()->role == 0 || Auth::user()->role == 3 || Auth::user()->role == 4)
                                    <div class="std-actions-group">
                                        <button type="button" class="btn-action-icon btn-action-edit edit-student-btn"
                                                data-id="{{ $student->student_id }}"
                                                data-name="{{ $student->student_name }}"
                                                data-birthday="{{ $student->birthday }}"
                                                data-sex="{{ $student->sex }}"
                                                data-address="{{ $student->address }}"
                                                data-phone="{{ $student->phone }}"
                                                data-email="{{ $student->email }}"
                                                data-class-id="{{ $student->class_id }}"
                                                data-section-id="{{ $student->section_id }}"
                                                data-parent-id="{{ $student->parent_id }}"
                                                data-photo="{{ asset('students_image/' . ($student->photo ?? 'noimg.jpg')) }}"
                                                title="{{ __('Edit Student') }}">
                                            <i class="fas fa-pen"></i>
                                        </button>

                                        <form action="{{ route('students.destroy', $student->student_id) }}" method="POST" class="d-inline delete-student-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action-icon btn-action-delete" title="{{ __('Delete Student') }}">
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
                                <i class="fas fa-user-graduate fa-3x mb-3 text-secondary opacity-50 d-block"></i>
                                <h6>{{ __('No students found') }}</h6>
                                <p class="small text-muted mb-0">{{ __('Admit new students into the system to build your roster.') }}</p>
                            </td>
                        </tr>
                    @endforelse
                    <tr id="noResultsRow" style="display: none;">
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-search fa-2x mb-2 text-secondary opacity-50 d-block"></i>
                            <h6>{{ __('No matching students found') }}</h6>
                            <p class="small text-muted mb-0">{{ __('Try adjusting your search query or filters.') }}</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- =====================================================================
     EDIT STUDENT MODAL (Single Dynamic Modal)
===================================================================== -->
<div class="modal fade std-modal" id="editStudentModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="editModalLabel">
                    <i class="fas fa-user-edit text-warning mr-1.5"></i>
                    {{ __('Edit Student Record') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editStudentForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row">
                        <!-- Name -->
                        <div class="col-md-6 mb-3">
                            <label for="edit_name" class="font-weight-bold text-sm">
                                {{ __('Student Full Name') }} <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>

                        <!-- Date of Birth -->
                        <div class="col-md-3 mb-3">
                            <label for="edit_birthday" class="font-weight-bold text-sm">
                                {{ __('Date of Birth') }} <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="birthday" id="edit_birthday" class="form-control" required>
                        </div>

                        <!-- Sex -->
                        <div class="col-md-3 mb-3">
                            <label for="edit_sex" class="font-weight-bold text-sm">
                                {{ __('Gender') }} <span class="text-danger">*</span>
                            </label>
                            <select name="sex" id="edit_sex" class="form-control" required>
                                <option value="1">{{ __('Male') }}</option>
                                <option value="0">{{ __('Female') }}</option>
                            </select>
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6 mb-3">
                            <label for="edit_phone" class="font-weight-bold text-sm">
                                {{ __('Phone Number') }} <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="phone" id="edit_phone" class="form-control" required>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label for="edit_email" class="font-weight-bold text-sm">
                                {{ __('Email Address') }}
                            </label>
                            <input type="email" name="email" id="edit_email" class="form-control">
                        </div>

                        <!-- Address -->
                        <div class="col-md-12 mb-3">
                            <label for="edit_address" class="font-weight-bold text-sm">
                                {{ __('Home Address') }} <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="address" id="edit_address" class="form-control" required>
                        </div>

                        <!-- Class -->
                        <div class="col-md-4 mb-3">
                            <label for="edit_class_id" class="font-weight-bold text-sm">
                                {{ __('Class') }} <span class="text-danger">*</span>
                            </label>
                            <select name="class_id" id="edit_class_id" class="form-control" required>
                                <option value="">{{ __('-- Select Class --') }}</option>
                                @foreach($classes as $c)
                                    <option value="{{ $c->class_id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Section -->
                        <div class="col-md-4 mb-3">
                            <label for="edit_section_id" class="font-weight-bold text-sm">
                                {{ __('Section') }} <span class="text-danger">*</span>
                            </label>
                            <select name="section_id" id="edit_section_id" class="form-control" required>
                                <option value="">{{ __('-- Select Section --') }}</option>
                            </select>
                        </div>

                        <!-- Parent -->
                        <div class="col-md-4 mb-3">
                            <label for="edit_parent_id" class="font-weight-bold text-sm">
                                {{ __('Guardian / Parent') }}
                            </label>
                            <select name="parent_id" id="edit_parent_id" class="form-control">
                                <option value="">{{ __('-- None / Independent --') }}</option>
                                @foreach($parents as $p)
                                    <option value="{{ $p->parent_id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Photo Section -->
                        <div class="col-md-12 mt-2">
                            <label class="font-weight-bold text-sm d-block">{{ __('Student Photograph') }}</label>
                            <div class="d-flex align-items-center" style="gap: 1.25rem;">
                                <div style="width: 70px; height: 70px; border-radius: 12px; overflow: hidden; border: 1px solid #cbd5e1; background: #f8fafc;">
                                    <img id="editPhotoPreview" src="" alt="Student Preview" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <div class="flex-grow-1">
                                    <div class="custom-file">
                                        <input type="file" name="file" id="editFileInput" accept="image/*" class="custom-file-input">
                                        <label class="custom-file-label" for="editFileInput">{{ __('Choose new photo...') }}</label>
                                    </div>
                                    <small class="text-muted mt-1 d-block">{{ __('Accepted formats: JPG, PNG, GIF. Leave empty to keep existing photo.') }}</small>
                                </div>
                            </div>
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
    const searchInput = document.getElementById('stdSearchInput');
    const classFilter = document.getElementById('classFilterSelect');
    const filterPills = document.querySelectorAll('.std-filter-pill');
    const tableRows = document.querySelectorAll('.std-row');
    const noResultsRow = document.getElementById('noResultsRow');

    let currentFilter = 'all';

    function applyFilters() {
        const query = (searchInput.value || '').trim().toLowerCase();
        const selectedClass = (classFilter.value || '').toLowerCase();
        let visibleCount = 0;

        tableRows.forEach(row => {
            const rowSearch = row.getAttribute('data-search') || '';
            const rowGender = row.getAttribute('data-gender') || '';
            const rowPlacement = row.getAttribute('data-placement') || '';
            const rowClass = row.getAttribute('data-class') || '';

            const matchesSearch = !query || rowSearch.includes(query);
            const matchesClass = !selectedClass || rowClass === selectedClass;

            let matchesTab = true;
            if (currentFilter === 'male') matchesTab = (rowGender === 'male');
            else if (currentFilter === 'female') matchesTab = (rowGender === 'female');
            else if (currentFilter === 'assigned') matchesTab = (rowPlacement === 'assigned');
            else if (currentFilter === 'unassigned') matchesTab = (rowPlacement === 'unassigned');

            if (matchesSearch && matchesClass && matchesTab) {
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

    if (searchInput) searchInput.addEventListener('input', applyFilters);
    if (classFilter) classFilter.addEventListener('change', applyFilters);

    filterPills.forEach(pill => {
        pill.addEventListener('click', function () {
            filterPills.forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            currentFilter = this.getAttribute('data-filter');
            applyFilters();
        });
    });

    // ══════════════════════════════════════════════════════════════════
    // Dynamic Edit Modal & Section Fetching
    // ══════════════════════════════════════════════════════════════════
    const editForm = document.getElementById('editStudentForm');
    const editClassSelect = document.getElementById('edit_class_id');
    const editSectionSelect = document.getElementById('edit_section_id');
    const editPhotoPreview = document.getElementById('editPhotoPreview');
    const editFileInput = document.getElementById('editFileInput');

    function loadSections(classId, preSelectedSectionId) {
        if (!classId) {
            editSectionSelect.innerHTML = '<option value="">{{ __("-- Select Class First --") }}</option>';
            return;
        }

        editSectionSelect.innerHTML = '<option value="">{{ __("Loading sections...") }}</option>';

        fetch(`/get-sections-by-class/${classId}`)
            .then(res => res.json())
            .then(data => {
                let options = '<option value="">{{ __("-- Select Section --") }}</option>';
                (data.sections || []).forEach(sec => {
                    const sel = (sec.section_id == preSelectedSectionId) ? 'selected' : '';
                    options += `<option value="${sec.section_id}" ${sel}>${sec.name}</option>`;
                });
                editSectionSelect.innerHTML = options;
            })
            .catch(() => {
                editSectionSelect.innerHTML = '<option value="">{{ __("Error loading sections") }}</option>';
            });
    }

    if (editClassSelect) {
        editClassSelect.addEventListener('change', function () {
            loadSections(this.value, null);
        });
    }

    if (editFileInput) {
        editFileInput.addEventListener('change', function (e) {
            if (e.target.files.length > 0) {
                const file = e.target.files[0];
                const label = this.nextElementSibling;
                if (label) label.textContent = file.name;

                const reader = new FileReader();
                reader.onload = function (evt) {
                    editPhotoPreview.src = evt.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }

    document.querySelectorAll('.edit-student-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const birthday = this.getAttribute('data-birthday');
            const sex = this.getAttribute('data-sex');
            const address = this.getAttribute('data-address');
            const phone = this.getAttribute('data-phone');
            const email = this.getAttribute('data-email');
            const classId = this.getAttribute('data-class-id');
            const sectionId = this.getAttribute('data-section-id');
            const parentId = this.getAttribute('data-parent-id');
            const photo = this.getAttribute('data-photo');

            editForm.action = `/students/${id}`;

            document.getElementById('edit_name').value = name || '';
            document.getElementById('edit_birthday').value = birthday || '';
            document.getElementById('edit_sex').value = (sex == '0') ? '0' : '1';
            document.getElementById('edit_address').value = address || '';
            document.getElementById('edit_phone').value = phone || '';
            document.getElementById('edit_email').value = (email && email !== 'No Email') ? email : '';
            document.getElementById('edit_class_id').value = classId || '';
            document.getElementById('edit_parent_id').value = parentId || '';

            if (editPhotoPreview) {
                editPhotoPreview.src = photo || '';
            }

            const fileLabel = document.querySelector('.custom-file-label');
            if (fileLabel) fileLabel.textContent = '{{ __("Choose new photo...") }}';
            if (editFileInput) editFileInput.value = '';

            loadSections(classId, sectionId);

            $('#editStudentModal').modal('show');
        });
    });

    // ══════════════════════════════════════════════════════════════════
    // SweetAlert2 Delete Confirmation
    // ══════════════════════════════════════════════════════════════════
    document.querySelectorAll('.delete-student-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: '{{ __("Delete Student Record?") }}',
                text: '{{ __("Are you sure you want to permanently delete this student record?") }}',
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
