@extends('layout.main')

@section('title', __('Student Marksheet & Academic Performance'))

@section('content')

<style>
/* ══════════════════════════════════════════════════════════════════
   STUDENT MARKSHEET – Executive SaaS Design System
══════════════════════════════════════════════════════════════════ */
.mark-dashboard-wrapper {
    padding: 0.5rem 0.25rem 2.5rem;
}

/* Header Box */
.mark-header-box {
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
.mark-header-box::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 5px;
    height: 100%;
    background: linear-gradient(180deg, #6366f1, #8b5cf6);
}
html.dark-mode .mark-header-box {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 24px -2px rgba(0, 0, 0, 0.35);
}

.mark-header-title {
    font-size: 1.35rem;
    font-weight: 800;
    margin-bottom: 0.2rem;
    display: flex;
    align-items: center;
    gap: 0.65rem;
    color: #1e293b;
}
html.dark-mode .mark-header-title {
    color: #f8fafc;
}

.mark-header-subtitle {
    font-size: 0.85rem;
    color: #64748b;
    margin: 0;
}
html.dark-mode .mark-header-subtitle {
    color: #94a3b8;
}

.mark-action-group {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    flex-wrap: wrap;
}

.btn-mark {
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
.btn-mark-primary {
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25);
}
.btn-mark-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(99, 102, 241, 0.35);
    background: linear-gradient(135deg, #4f46e5, #4338ca);
}
.btn-mark-secondary {
    background: #f1f5f9;
    color: #334155 !important;
    border-color: #cbd5e1;
}
.btn-mark-secondary:hover {
    background: #e2e8f0;
    color: #0f172a !important;
}
html.dark-mode .btn-mark-secondary {
    background: #282f48;
    color: #e2e8f0 !important;
    border-color: #3b4261;
}
html.dark-mode .btn-mark-secondary:hover {
    background: #333c5e;
}

/* Class Switcher Select */
.class-switcher-select {
    padding: 0.5rem 1rem;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 0.875rem;
    font-weight: 600;
    background: #ffffff;
    color: #1e293b;
    outline: none;
    transition: all 0.2s;
    min-width: 180px;
}
.class-switcher-select:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
}
html.dark-mode .class-switcher-select {
    background: #252a3d;
    border-color: #3b4261;
    color: #f1f5f9;
}

/* KPI Cards Grid */
.mark-kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem;
    margin-bottom: 1.25rem;
}

.mark-kpi-card {
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
.mark-kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
}
html.dark-mode .mark-kpi-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.25);
}

.mark-kpi-icon {
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
.kpi-purple  { background: rgba(139, 92, 246, 0.12); color: #8b5cf6; }
.kpi-emerald { background: rgba(16, 185, 129, 0.12); color: #10b981; }
.kpi-sky     { background: rgba(14, 165, 233, 0.12); color: #0ea5e9; }

.mark-kpi-value {
    font-size: 1.55rem;
    font-weight: 800;
    line-height: 1.1;
    color: #0f172a;
}
html.dark-mode .mark-kpi-value {
    color: #f8fafc;
}
.mark-kpi-label {
    font-size: 0.78rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: #64748b;
    margin-top: 0.15rem;
}
html.dark-mode .mark-kpi-label {
    color: #94a3b8;
}

/* Main Table Card */
.mark-main-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.04);
}
html.dark-mode .mark-main-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 24px -2px rgba(0, 0, 0, 0.35);
}

.mark-toolbar {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.85rem;
    background: #f8fafc;
}
html.dark-mode .mark-toolbar {
    background: #191c2b;
    border-color: #2e354f;
}

.mark-filter-tabs {
    display: flex;
    align-items: center;
    gap: 0.35rem;
    background: #e2e8f0;
    padding: 0.25rem;
    border-radius: 10px;
    flex-wrap: wrap;
}
html.dark-mode .mark-filter-tabs {
    background: #252a3d;
}
.mark-filter-pill {
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
.mark-filter-pill:hover {
    color: #1e293b;
}
.mark-filter-pill.active {
    background: #ffffff;
    color: #4f46e5;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
}
html.dark-mode .mark-filter-pill {
    color: #94a3b8;
}
html.dark-mode .mark-filter-pill.active {
    background: #1e2235;
    color: #a5b4fc;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
}
.mark-filter-count {
    font-size: 0.72rem;
    padding: 0.1rem 0.4rem;
    border-radius: 10px;
    background: rgba(100, 116, 139, 0.15);
}
.mark-filter-pill.active .mark-filter-count {
    background: rgba(99, 102, 241, 0.15);
}

.mark-search-box {
    position: relative;
    min-width: 250px;
    max-width: 380px;
    flex: 1;
}
.mark-search-input {
    width: 100%;
    padding: 0.45rem 1rem 0.45rem 2.25rem;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 0.875rem;
    background: #ffffff;
    color: #1e293b;
    transition: all 0.2s;
}
.mark-search-input:focus {
    outline: none;
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
}
html.dark-mode .mark-search-input {
    background: #252a3d;
    border-color: #3b4261;
    color: #f1f5f9;
}
.mark-search-icon {
    position: absolute;
    left: 0.8rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.85rem;
    pointer-events: none;
}

/* Modern Table */
.mark-table {
    margin: 0;
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}
.mark-table thead th {
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
html.dark-mode .mark-table thead th {
    background: #191c2b;
    color: #94a3b8;
    border-color: #2e354f;
}
.mark-table tbody td {
    padding: 0.95rem 1rem;
    vertical-align: middle;
    border-top: none;
    border-bottom: 1px solid #f1f5f9;
    font-size: 0.88rem;
    color: #334155;
}
html.dark-mode .mark-table tbody td {
    border-color: #262c44;
    color: #cbd5e1;
}
.mark-table tbody tr:hover {
    background: #f8fafc;
}
html.dark-mode .mark-table tbody tr:hover {
    background: #22273c;
}

/* Student Avatar Box */
.mark-student-avatar {
    width: 42px;
    height: 42px;
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
.mark-student-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.mark-student-initials {
    font-weight: 800;
    font-size: 0.95rem;
    color: #4f46e5;
    background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}
html.dark-mode .mark-student-initials {
    background: linear-gradient(135deg, #3730a3, #4338ca);
    color: #e0e7ff;
}

.mark-student-name {
    font-weight: 700;
    color: #0f172a;
    font-size: 0.95rem;
    line-height: 1.2;
}
html.dark-mode .mark-student-name {
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

.section-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.78rem;
    font-weight: 600;
    color: #059669;
    background: rgba(16, 185, 129, 0.08);
    border: 1px solid rgba(16, 185, 129, 0.2);
    padding: 0.25rem 0.65rem;
    border-radius: 8px;
}
html.dark-mode .section-pill {
    background: rgba(16, 185, 129, 0.18);
    color: #34d399;
}

.btn-view-marksheet {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    padding: 0.45rem 1rem;
    border-radius: 10px;
    font-size: 0.825rem;
    font-weight: 700;
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    color: #ffffff !important;
    border: none;
    box-shadow: 0 2px 8px rgba(99, 102, 241, 0.25);
    transition: all 0.2s ease;
    cursor: pointer;
}
.btn-view-marksheet:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.35);
    background: linear-gradient(135deg, #4f46e5, #4338ca);
}

/* Marksheet Modal */
.mark-modal .modal-content {
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}
html.dark-mode .mark-modal .modal-content {
    background: #1e2235;
    border-color: #2e354f;
    color: #f1f5f9;
}
.mark-modal .modal-header {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 1.15rem 1.5rem;
}
html.dark-mode .mark-modal .modal-header {
    background: #191c2b;
    border-color: #2e354f;
}
.mark-modal .modal-footer {
    border-top: 1px solid #e2e8f0;
    background: #f8fafc;
    padding: 0.95rem 1.5rem;
}
html.dark-mode .mark-modal .modal-footer {
    border-color: #2e354f;
    background: #191c2b;
}

/* Exam Card in Modal */
.modal-exam-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    margin-bottom: 1.25rem;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
}
html.dark-mode .modal-exam-card {
    background: #252a3d;
    border-color: #3b4261;
}
.modal-exam-header {
    padding: 0.95rem 1.25rem;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.5rem;
}
html.dark-mode .modal-exam-header {
    background: #191c2b;
    border-color: #3b4261;
}

.grade-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    border-radius: 8px;
    font-weight: 800;
    font-size: 0.85rem;
}
.grade-A { background: rgba(16, 185, 129, 0.15); color: #059669; border: 1px solid rgba(16, 185, 129, 0.3); }
.grade-B { background: rgba(59, 130, 246, 0.15); color: #2563eb; border: 1px solid rgba(59, 130, 246, 0.3); }
.grade-C { background: rgba(245, 158, 11, 0.15); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.3); }
.grade-D { background: rgba(249, 115, 22, 0.15); color: #ea580c; border: 1px solid rgba(249, 115, 22, 0.3); }
.grade-F { background: rgba(239, 68, 68, 0.15); color: #dc2626; border: 1px solid rgba(239, 68, 68, 0.3); }

/* Print Styles */
@media print {
    body * { visibility: hidden; }
    #printableMarksheet, #printableMarksheet * { visibility: visible; }
    #printableMarksheet { position: absolute; left: 0; top: 0; width: 100%; }
}
</style>

@php
    $totalStudents = count($students);
    $totalSections = count($sections);
    $uniqueExamsCount = isset($marks) ? $marks->pluck('exam_name')->unique()->filter()->count() : 0;
    $totalMarksCount = isset($marks) ? count($marks) : 0;
    $className = $class->name ?? __('Academic Class');
    $currentClassId = $class->class_id ?? 0;
@endphp

<div class="mark-dashboard-wrapper">
    <!-- Header Banner -->
    <div class="mark-header-box">
        <div>
            <div class="mark-header-title">
                <i class="fas fa-graduation-cap text-primary"></i>
                {{ __('Class Marksheet & Academic Records') }}
            </div>
            <p class="mark-header-subtitle">
                {{ __('Performance evaluation, exam grades, and GPA statements for') }}
                <strong class="text-primary">{{ $className }}</strong>.
            </p>
        </div>

        <div class="mark-action-group">
            @if(isset($classes) && count($classes) > 0)
                <select class="class-switcher-select" onchange="if(this.value) window.location.href='/marks/class/' + this.value;">
                    <option value="" disabled>{{ __('Switch Academic Class') }}</option>
                    @foreach($classes as $c)
                        <option value="{{ $c->class_id }}" {{ $c->class_id == $currentClassId ? 'selected' : '' }}>
                            {{ $c->name }}
                        </option>
                    @endforeach
                </select>
            @endif

            <a href="{{ route('exam_marks.index') }}" class="btn-mark btn-mark-secondary" title="{{ __('Manage Exam Marks') }}">
                <i class="fas fa-pen-fancy text-primary"></i>
                <span>{{ __('Assign Marks') }}</span>
            </a>

            <a href="{{ route('exams_grade.index') }}" class="btn-mark btn-mark-primary" title="{{ __('Grading Scales') }}">
                <i class="fas fa-award"></i>
                <span>{{ __('Grading System') }}</span>
            </a>
        </div>
    </div>

    <!-- Top KPI Metric Cards -->
    <div class="mark-kpi-grid">
        <div class="mark-kpi-card">
            <div class="mark-kpi-icon kpi-indigo">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div>
                <div class="mark-kpi-value">{{ $totalStudents }}</div>
                <div class="mark-kpi-label">{{ __('Enrolled Cohort') }}</div>
            </div>
        </div>

        <div class="mark-kpi-card">
            <div class="mark-kpi-icon kpi-purple">
                <i class="fas fa-layer-group"></i>
            </div>
            <div>
                <div class="mark-kpi-value">{{ $totalSections }}</div>
                <div class="mark-kpi-label">{{ __('Class Sections') }}</div>
            </div>
        </div>

        <div class="mark-kpi-card">
            <div class="mark-kpi-icon kpi-emerald">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <div>
                <div class="mark-kpi-value">{{ $uniqueExamsCount }}</div>
                <div class="mark-kpi-label">{{ __('Exams Conducted') }}</div>
            </div>
        </div>

        <div class="mark-kpi-card">
            <div class="mark-kpi-icon kpi-sky">
                <i class="fas fa-chart-line"></i>
            </div>
            <div>
                <div class="mark-kpi-value">{{ $totalMarksCount }}</div>
                <div class="mark-kpi-label">{{ __('Scores Recorded') }}</div>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="mark-main-card">
        <!-- Toolbar -->
        <div class="mark-toolbar">
            <div class="mark-filter-tabs">
                <button type="button" class="mark-filter-pill active" data-filter="all">
                    <span>{{ __('All Sections') }}</span>
                    <span class="mark-filter-count">{{ $totalStudents }}</span>
                </button>
                @foreach($sections as $sec)
                    @php
                        $secStudentCount = $students->where('section_id', $sec->section_id)->count();
                    @endphp
                    <button type="button" class="mark-filter-pill" data-filter="section-{{ $sec->section_id }}">
                        <span>{{ $sec->name }}</span>
                        <span class="mark-filter-count">{{ $secStudentCount }}</span>
                    </button>
                @endforeach
            </div>

            <div class="mark-search-box">
                <i class="fas fa-search mark-search-icon"></i>
                <input type="text" id="markSearchInput" class="mark-search-input" placeholder="{{ __('Search student, roll number, section...') }}" autocomplete="off">
            </div>
        </div>

        <!-- Responsive Table -->
        <div class="table-responsive">
            <table class="table mark-table" id="markMasterTable">
                <thead>
                    <tr>
                        <th style="width: 50px;">{{ __('Roll') }}</th>
                        <th>{{ __('Student Profile') }}</th>
                        <th>{{ __('Section') }}</th>
                        <th>{{ __('Academic Class') }}</th>
                        <th>{{ __('Evaluation Status') }}</th>
                        <th style="width: 150px;" class="text-right">{{ __('Statement') }}</th>
                    </tr>
                </thead>
                <tbody id="markTableBody">
                    @forelse($students as $student)
                        @php
                            $searchBlob = strtolower(implode(' ', [
                                $student->student_name ?? '',
                                $student->roll ?? '',
                                $student->section_name ?? '',
                                $student->class_name ?? '',
                            ]));
                        @endphp
                        <tr class="mark-row"
                            data-search="{{ $searchBlob }}"
                            data-section="section-{{ $student->section_id ?? '0' }}">
                            <td>
                                <span class="badge badge-light border font-weight-bold text-dark px-2 py-1">
                                    #{{ $student->roll ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="mark-student-avatar mr-2.5">
                                        @if(!empty($student->photo) && $student->photo !== 'noimg.jpg' && file_exists(public_path('students_image/' . $student->photo)))
                                            <img src="{{ asset('students_image/' . $student->photo) }}" alt="{{ $student->student_name }}" class="mark-student-img">
                                        @else
                                            <div class="mark-student-initials">
                                                {{ strtoupper(mb_substr($student->student_name ?? 'S', 0, 2)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="mark-student-name">{{ $student->student_name }}</div>
                                        <div class="d-flex align-items-center mt-0.5" style="gap: 0.35rem;">
                                            <span class="badge badge-light border text-muted small">
                                                #STU-{{ str_pad($student->student_id, 4, '0', STR_PAD_LEFT) }}
                                            </span>
                                            @if(isset($student->sex))
                                                @if($student->sex == 1)
                                                    <span class="badge-pill-custom badge-gender-male">
                                                        <i class="fas fa-mars mr-1"></i>{{ __('Male') }}
                                                    </span>
                                                @else
                                                    <span class="badge-pill-custom badge-gender-female">
                                                        <i class="fas fa-venus mr-1"></i>{{ __('Female') }}
                                                    </span>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="section-pill">
                                    <i class="fas fa-layer-group"></i>
                                    {{ $student->section_name ?? __('General') }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-light border font-weight-600 text-primary">
                                    <i class="fas fa-graduation-cap mr-1"></i>
                                    {{ $student->class_name ?? $className }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-light border text-success small font-weight-600">
                                    <i class="fas fa-check-circle mr-1"></i> {{ __('Scores On File') }}
                                </span>
                            </td>
                            <td class="text-right">
                                <button type="button" class="btn-view-marksheet view-marksheet"
                                        data-student-id="{{ $student->student_id }}"
                                        data-student-name="{{ $student->student_name }}"
                                        data-roll="{{ $student->roll ?? 'N/A' }}"
                                        data-section="{{ $student->section_name ?? __('General') }}"
                                        data-class-id="{{ $currentClassId }}"
                                        data-class-name="{{ $className }}">
                                    <i class="fas fa-file-invoice"></i>
                                    <span>{{ __('View Marksheet') }}</span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-graduation-cap fa-3x mb-3 text-secondary opacity-50 d-block"></i>
                                <h6>{{ __('No students enrolled in this class') }}</h6>
                                <p class="small text-muted mb-0">{{ __('Admit students or assign them to this academic class to display marksheets.') }}</p>
                            </td>
                        </tr>
                    @endforelse
                    <tr id="noResultsRow" style="display: none;">
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-search fa-2x mb-2 text-secondary opacity-50 d-block"></i>
                            <h6>{{ __('No matching student records found') }}</h6>
                            <p class="small text-muted mb-0">{{ __('Try adjusting your search query or filters.') }}</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- =====================================================================
     STUDENT MARKSHEET MODAL
===================================================================== -->
<div class="modal fade mark-modal" id="marksheetModal" tabindex="-1" role="dialog" aria-labelledby="marksheetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title font-weight-bold" id="marksheetModalLabel">
                        <i class="fas fa-award text-warning mr-1.5"></i>
                        {{ __('Official Student Academic Transcript') }}
                    </h5>
                    <div class="small text-muted mt-1 d-flex align-items-center flex-wrap" style="gap: 0.75rem;">
                        <span><strong class="text-dark">{{ __('Student:') }}</strong> <span id="modal-student-name" class="text-primary font-weight-bold">-</span></span>
                        <span>&bull;</span>
                        <span><strong class="text-dark">{{ __('Class:') }}</strong> <span id="modal-class-name">-</span></span>
                        <span>&bull;</span>
                        <span><strong class="text-dark">{{ __('Section:') }}</strong> <span id="modal-section-name">-</span></span>
                        <span>&bull;</span>
                        <span><strong class="text-dark">{{ __('Roll:') }}</strong> <span id="modal-roll">-</span></span>
                    </div>
                </div>
                <div class="d-flex align-items-center" style="gap: 0.5rem;">
                    <button type="button" class="btn btn-sm btn-outline-secondary font-weight-600" onclick="window.print()">
                        <i class="fas fa-print mr-1"></i> {{ __('Print Statement') }}
                    </button>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-body p-4" id="printableMarksheet">
                <div id="marksAccordion">
                    <!-- Populated dynamically via AJAX -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">
                    {{ __('Close') }}
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // ══════════════════════════════════════════════════════════════════
    // Instant Live Filtering & Search
    // ══════════════════════════════════════════════════════════════════
    const searchInput = document.getElementById('markSearchInput');
    const filterPills = document.querySelectorAll('.mark-filter-pill');
    const tableRows = document.querySelectorAll('.mark-row');
    const noResultsRow = document.getElementById('noResultsRow');

    let currentSectionFilter = 'all';

    function applyFilters() {
        const query = (searchInput.value || '').trim().toLowerCase();
        let visibleCount = 0;

        tableRows.forEach(row => {
            const rowSearch = row.getAttribute('data-search') || '';
            const rowSection = row.getAttribute('data-section') || '';

            const matchesSearch = !query || rowSearch.includes(query);
            const matchesSection = (currentSectionFilter === 'all') || (rowSection === currentSectionFilter);

            if (matchesSearch && matchesSection) {
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
            currentSectionFilter = this.getAttribute('data-filter');
            applyFilters();
        });
    });

    // ══════════════════════════════════════════════════════════════════
    // Fetch and Display Student Marksheet via AJAX
    // ══════════════════════════════════════════════════════════════════
    document.querySelectorAll('.view-marksheet').forEach(button => {
        button.addEventListener('click', function () {
            const studentId = this.getAttribute('data-student-id');
            const classId = this.getAttribute('data-class-id');
            const studentName = this.getAttribute('data-student-name');
            const roll = this.getAttribute('data-roll');
            const section = this.getAttribute('data-section');
            const className = this.getAttribute('data-class-name');

            document.getElementById('modal-student-name').textContent = studentName || 'N/A';
            document.getElementById('modal-class-name').textContent = className || 'N/A';
            document.getElementById('modal-section-name').textContent = section || 'N/A';
            document.getElementById('modal-roll').textContent = roll || 'N/A';

            const container = document.getElementById('marksAccordion');
            container.innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="text-muted mt-2 mb-0 font-weight-500">{{ __("Retrieving academic transcript records...") }}</p>
                </div>
            `;

            $('#marksheetModal').modal('show');

            fetch(`/marks/class/${classId}/student/${studentId}`)
                .then(response => response.json())
                .then(data => {
                    container.innerHTML = '';

                    const exams = data.exams || {};
                    const examKeys = Object.keys(exams);

                    if (examKeys.length === 0) {
                        container.innerHTML = `
                            <div class="text-center py-5 text-muted">
                                <i class="fas fa-file-invoice fa-3x mb-3 text-secondary opacity-50 d-block"></i>
                                <h5>{{ __("No examination marks recorded yet") }}</h5>
                                <p class="small text-muted mb-0">{{ __("There are currently no recorded test marks or grades on file for this student.") }}</p>
                            </div>
                        `;
                        return;
                    }

                    examKeys.forEach((examName, index) => {
                        const exam = exams[examName];
                        const subjectRows = (exam.subjects || []).map(subject => {
                            const gradeLetter = (subject.grade || '-').trim().toUpperCase();
                            const gradeClass = ['A','B','C','D','F'].includes(gradeLetter) ? `grade-${gradeLetter}` : 'grade-A';

                            return `
                                <tr>
                                    <td class="font-weight-600 text-dark">
                                        <i class="fas fa-book text-primary mr-1.5 opacity-75"></i>
                                        ${subject.subject_name || '{{ __("N/A") }}'}
                                    </td>
                                    <td class="font-weight-700 text-dark text-center" style="font-size: 0.95rem;">
                                        ${subject.mark_obtained !== null ? subject.mark_obtained : 'N/A'}
                                    </td>
                                    <td class="text-center text-muted">
                                        ${subject.mark_total !== null ? subject.mark_total : '100'}
                                    </td>
                                    <td class="text-center">
                                        <span class="grade-badge ${gradeClass}">
                                            ${subject.grade || 'N/A'}
                                        </span>
                                    </td>
                                    <td class="text-muted small">
                                        ${subject.comment ? `<i class="far fa-comment-dots mr-1 text-secondary"></i>${subject.comment}` : '<span class="text-muted opacity-50">{{ __("No comments") }}</span>'}
                                    </td>
                                </tr>
                            `;
                        }).join('');

                        const totalObtained = exam.total_marks !== undefined ? exam.total_marks : 0;
                        const gpa = exam.gpa !== undefined ? exam.gpa : 'N/A';

                        container.innerHTML += `
                            <div class="modal-exam-card">
                                <div class="modal-exam-header">
                                    <div class="d-flex align-items-center" style="gap: 0.5rem;">
                                        <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(99, 102, 241, 0.1); color: #4f46e5; display: flex; align-items: center; justify-content: center; font-size: 0.9rem;">
                                            <i class="fas fa-award"></i>
                                        </div>
                                        <h6 class="font-weight-bold mb-0 text-dark" style="font-size: 0.95rem;">
                                            ${exam.name || examName}
                                        </h6>
                                    </div>
                                    <div class="d-flex align-items-center" style="gap: 0.65rem;">
                                        <span class="badge badge-light border px-2 py-1 font-weight-600">
                                            {{ __("Total Score:") }} <strong class="text-primary">${totalObtained}</strong>
                                        </span>
                                        <span class="badge badge-success px-2.5 py-1 font-weight-700">
                                            {{ __("GPA:") }} ${gpa}
                                        </span>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr style="background: #f8fafc; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.04em; color: #64748b;">
                                                <th>{{ __("Course / Subject") }}</th>
                                                <th class="text-center">{{ __("Marks Obtained") }}</th>
                                                <th class="text-center">{{ __("Max Total") }}</th>
                                                <th class="text-center">{{ __("Letter Grade") }}</th>
                                                <th>{{ __("Teacher Remarks") }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${subjectRows || `<tr><td colspan="5" class="text-center py-3 text-muted">{{ __("No subject scores recorded for this exam.") }}</td></tr>`}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        `;
                    });
                })
                .catch(err => {
                    console.error('Error fetching marksheet:', err);
                    container.innerHTML = `
                        <div class="text-center py-4 text-danger">
                            <i class="fas fa-exclamation-triangle fa-2x mb-2 d-block"></i>
                            <p class="font-weight-600">{{ __("Failed to load marksheet. Please try again later.") }}</p>
                        </div>
                    `;
                });
        });
    });
});
</script>

@endsection
