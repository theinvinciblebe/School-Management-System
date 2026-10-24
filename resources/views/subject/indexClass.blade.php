@extends('layout.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Scoped Design System for Subject Hub */
    :root {
        --sub-primary: #6366f1;
        --sub-primary-hover: #4f46e5;
        --sub-card-bg: #ffffff;
        --sub-card-border: rgba(0, 0, 0, 0.08);
        --sub-text-main: #1e293b;
        --sub-text-muted: #64748b;
        --sub-subtle-bg: #f8fafc;
        --sub-chip-bg: #f1f5f9;
    }

    body.dark-mode, .dark-mode {
        --sub-primary: #818cf8;
        --sub-primary-hover: #6366f1;
        --sub-card-bg: #2b2d30;
        --sub-card-border: rgba(255, 255, 255, 0.08);
        --sub-text-main: #f1f5f9;
        --sub-text-muted: #94a3b8;
        --sub-subtle-bg: #1e1e1e;
        --sub-chip-bg: rgba(255, 255, 255, 0.06);
    }

    .subject-hub-container {
        color: var(--sub-text-main);
        padding-top: 8px;
    }

    /* Hero Header */
    .sub-hero-card {
        background: var(--sub-card-bg);
        border: 1px solid var(--sub-card-border);
        border-radius: 16px;
        padding: 24px 28px;
        margin-bottom: 24px;
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
        position: relative;
        overflow: hidden;
    }
    .sub-hero-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 6px;
        height: 100%;
        background: linear-gradient(180deg, #6366f1, #3b82f6);
    }
    .sub-hero-title {
        font-size: 1.65rem;
        font-weight: 700;
        margin-bottom: 4px;
        letter-spacing: -0.02em;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .sub-hero-subtitle {
        color: var(--sub-text-muted);
        font-size: 0.95rem;
        margin-bottom: 0;
    }

    /* Metric Cards */
    .sub-metric-card {
        background: var(--sub-card-bg);
        border: 1px solid var(--sub-card-border);
        border-radius: 14px;
        padding: 18px 20px;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 2px 10px -2px rgba(0, 0, 0, 0.04);
    }
    .sub-metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px -2px rgba(0, 0, 0, 0.08);
    }
    .sub-metric-label {
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--sub-text-muted);
        margin-bottom: 4px;
    }
    .sub-metric-val {
        font-size: 1.75rem;
        font-weight: 800;
        line-height: 1.1;
        letter-spacing: -0.02em;
    }
    .sub-metric-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        flex-shrink: 0;
    }

    /* Workflow Step Bar */
    .sub-process-card {
        background: var(--sub-card-bg);
        border: 1px solid var(--sub-card-border);
        border-radius: 14px;
        padding: 16px 20px;
        margin-bottom: 24px;
        box-shadow: 0 2px 10px -2px rgba(0, 0, 0, 0.04);
    }
    .sub-step-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 8px 12px;
        border-radius: 10px;
        background: var(--sub-subtle-bg);
        border: 1px dashed var(--sub-card-border);
    }
    .sub-step-num {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 13px;
        flex-shrink: 0;
    }

    /* Filter & Control Bar */
    .sub-controls-card {
        background: var(--sub-card-bg);
        border: 1px solid var(--sub-card-border);
        border-radius: 14px;
        padding: 16px 20px;
        margin-bottom: 24px;
        box-shadow: 0 2px 10px -2px rgba(0, 0, 0, 0.04);
    }

    /* Class Cards (Grid View) */
    .sub-class-card {
        background: var(--sub-card-bg);
        border: 1px solid var(--sub-card-border);
        border-radius: 14px;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 2px 12px -2px rgba(0, 0, 0, 0.04);
    }
    .sub-class-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px -4px rgba(0, 0, 0, 0.1);
        border-color: rgba(99, 102, 241, 0.4);
    }
    .sub-card-top-bar {
        height: 5px;
        width: 100%;
    }
    .sub-card-header {
        padding: 18px 20px 14px 20px;
        border-bottom: 1px solid var(--sub-card-border);
    }
    .sub-card-body {
        padding: 18px 20px;
        flex-grow: 1;
    }
    .sub-card-footer {
        padding: 14px 20px;
        background: var(--sub-subtle-bg);
        border-top: 1px solid var(--sub-card-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* Subject Chips / Pills */
    .subject-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 10px;
        border-radius: 8px;
        font-size: 0.78rem;
        font-weight: 600;
        background: var(--sub-chip-bg);
        border: 1px solid var(--sub-card-border);
        margin: 3px;
        transition: all 0.15s ease;
    }
    .subject-pill:hover {
        border-color: var(--sub-primary);
        color: var(--sub-primary);
    }

    /* Table View */
    .sub-table {
        margin-bottom: 0;
        width: 100%;
        color: var(--sub-text-main);
    }
    .sub-table th {
        background: var(--sub-subtle-bg);
        color: var(--sub-text-muted);
        font-size: 0.76rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 12px 16px;
        border-top: none;
        border-bottom: 1px solid var(--sub-card-border);
    }
    .sub-table td {
        padding: 14px 16px;
        vertical-align: middle;
        border-top: 1px solid var(--sub-card-border);
        font-size: 0.88rem;
    }
    .sub-table tbody tr:hover {
        background-color: rgba(99, 102, 241, 0.03);
    }
    .dark-mode .sub-table tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.03);
    }

    /* Buttons */
    .btn-sub-primary {
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #ffffff !important;
        border: none;
        font-weight: 600;
        border-radius: 8px;
        padding: 8px 16px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }
    .btn-sub-primary:hover {
        background: linear-gradient(135deg, #4f46e5, #4338ca);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }
    .btn-sub-outline {
        background: transparent;
        border: 1px solid var(--sub-card-border);
        color: var(--sub-text-main);
        font-weight: 600;
        border-radius: 8px;
        padding: 7px 14px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }
    .btn-sub-outline:hover {
        background: var(--sub-subtle-bg);
        color: var(--sub-text-main);
    }

    /* Dark Mode Modals & Inputs */
    .dark-mode .modal-content {
        background-color: #2b2d30 !important;
        color: #f1f5f9;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .dark-mode .modal-header,
    .dark-mode .modal-footer {
        border-color: rgba(255, 255, 255, 0.08);
    }
    .dark-mode .form-control,
    .dark-mode .custom-select {
        background-color: #1e1e1e !important;
        border-color: rgba(255, 255, 255, 0.12) !important;
        color: #f1f5f9 !important;
    }
    .dark-mode .form-control:focus,
    .dark-mode .custom-select:focus {
        background-color: #1e1e1e !important;
        border-color: #6366f1 !important;
        color: #f1f5f9 !important;
    }
</style>

<div class="subject-hub-container">

    <!-- 1. Hero Header Card -->
    <div class="sub-hero-card">
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-6 mb-3 mb-md-0">
                <h1 class="sub-hero-title">
                    <i class="fas fa-book-bookmark text-primary"></i>
                    Class Curriculum & Subject Hub
                    <span class="badge badge-primary px-3 py-1 font-weight-normal" style="font-size: 0.75rem; border-radius: 20px;">
                        Curriculum Process
                    </span>
                </h1>
                <p class="sub-hero-subtitle">
                    Select an academic class below to configure syllabus subjects, assign specialist teachers, and manage class course modules.
                </p>
            </div>
            <div class="col-lg-5 col-md-6 text-md-right d-flex flex-wrap align-items-center justify-content-md-end gap-2">
                @if (in_array(Auth::user()->role, [0, 4]))
                    <button type="button" class="btn btn-sub-primary mr-2 mb-2 mb-sm-0 shadow-sm" data-toggle="modal" data-target="#quickAddSubjectModal">
                        <i class="fas fa-plus-circle"></i> Add Subject
                    </button>
                    <a href="{{ route('class.index') }}" class="btn btn-sub-outline mb-2 mb-sm-0">
                        <i class="fas fa-layer-group"></i> Manage Classes
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- 2. Academic Summary KPIs (4 Cards) -->
    <div class="row mb-4">
        <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
            <div class="sub-metric-card">
                <div>
                    <div class="sub-metric-label">Academic Classes</div>
                    <div class="sub-metric-val text-primary">{{ $totalClasses }}</div>
                    <small class="text-muted">Configured Streams</small>
                </div>
                <div class="sub-metric-icon" style="background: rgba(99, 102, 241, 0.12); color: #6366f1;">
                    <i class="fas fa-graduation-cap"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
            <div class="sub-metric-card">
                <div>
                    <div class="sub-metric-label">Active Subjects</div>
                    <div class="sub-metric-val text-success">{{ $totalSubjects }}</div>
                    <small class="text-muted">Syllabus Modules</small>
                </div>
                <div class="sub-metric-icon" style="background: rgba(16, 185, 129, 0.12); color: #10b981;">
                    <i class="fas fa-book-open"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
            <div class="sub-metric-card">
                <div>
                    <div class="sub-metric-label">Faculty Instructors</div>
                    <div class="sub-metric-val text-info">{{ $totalTeachers }}</div>
                    <small class="text-muted">Qualified Teachers</small>
                </div>
                <div class="sub-metric-icon" style="background: rgba(6, 182, 212, 0.12); color: #06b6d4;">
                    <i class="fas fa-chalkboard-user"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
            <div class="sub-metric-card">
                <div>
                    <div class="sub-metric-label">Enrolled Students</div>
                    <div class="sub-metric-val text-warning">{{ $totalStudents }}</div>
                    <small class="text-muted">Active Class Learners</small>
                </div>
                <div class="sub-metric-icon" style="background: rgba(245, 158, 11, 0.12); color: #f59e0b;">
                    <i class="fas fa-users-viewfinder"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Process Flow Ribbon -->
    <div class="sub-process-card mb-4">
        <div class="row align-items-center">
            <div class="col-md-4 mb-2 mb-md-0">
                <div class="sub-step-item">
                    <div class="sub-step-num" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">1</div>
                    <div>
                        <strong class="d-block small">Select Class Program</strong>
                        <span class="text-muted text-xs">Choose the target class stream below</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-2 mb-md-0">
                <div class="sub-step-item">
                    <div class="sub-step-num" style="background: linear-gradient(135deg, #3b82f6, #06b6d4);">2</div>
                    <div>
                        <strong class="d-block small">Configure Subjects & Faculty</strong>
                        <span class="text-muted text-xs">Add subjects and assign specialist teachers</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="sub-step-item">
                    <div class="sub-step-num" style="background: linear-gradient(135deg, #10b981, #059669);">3</div>
                    <div>
                        <strong class="d-block small">Class Routine & Evaluation</strong>
                        <span class="text-muted text-xs">Manage timetable periods and student grades</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. Filter, Search & View Toggle Toolbar -->
    <div class="sub-controls-card">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-2 mb-lg-0">
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-transparent border-right-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                    </div>
                    <input type="text" id="classSearchInput" class="form-control border-left-0" placeholder="Filter classes by name, code, room, or subject..." style="border-radius: 0 8px 8px 0;">
                </div>
            </div>

            <div class="col-lg-7 d-flex justify-content-lg-end align-items-center flex-wrap gap-2">
                <!-- Status Filter Buttons -->
                <div class="btn-group btn-group-sm mr-2 mb-2 mb-sm-0" role="group">
                    <button type="button" class="btn btn-primary active class-filter-btn" data-filter="all">
                        All ({{ $totalClasses }})
                    </button>
                    <button type="button" class="btn btn-outline-secondary class-filter-btn" data-filter="has-subjects">
                        With Subjects
                    </button>
                    <button type="button" class="btn btn-outline-secondary class-filter-btn" data-filter="no-subjects">
                        Empty
                    </button>
                </div>

                <!-- View Switcher (Grid vs Table) -->
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-outline-secondary active view-toggle-btn" id="viewGridBtn" title="Grid Card View">
                        <i class="fas fa-table-cells-large"></i> Grid
                    </button>
                    <button type="button" class="btn btn-outline-secondary view-toggle-btn" id="viewTableBtn" title="List Table View">
                        <i class="fas fa-list"></i> Table
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. GRID CARD VIEW -->
    <div id="classesGridSection">
        <div class="row" id="classesGridRow">
            @php
                $colorPalettes = [
                    ['bar' => 'linear-gradient(90deg, #6366f1, #8b5cf6)', 'badge' => 'badge-primary', 'icon' => 'fa-laptop-code', 'iconColor' => '#6366f1'],
                    ['bar' => 'linear-gradient(90deg, #3b82f6, #06b6d4)', 'badge' => 'badge-info', 'icon' => 'fa-palette', 'iconColor' => '#0284c7'],
                    ['bar' => 'linear-gradient(90deg, #10b981, #059669)', 'badge' => 'badge-success', 'icon' => 'fa-square-root-variable', 'iconColor' => '#059669'],
                    ['bar' => 'linear-gradient(90deg, #f59e0b, #d97706)', 'badge' => 'badge-warning', 'icon' => 'fa-flask', 'iconColor' => '#d97706'],
                    ['bar' => 'linear-gradient(90deg, #ec4899, #8b5cf6)', 'badge' => 'badge-danger', 'icon' => 'fa-atom', 'iconColor' => '#db2777'],
                ];
            @endphp

            @forelse($classes as $index => $c)
                @php
                    $palette = $colorPalettes[$index % count($colorPalettes)];
                    $cSubjects = $subjectsByClass->get($c->class_id, collect());
                    $cStudentsCount = $studentCounts[$c->class_id] ?? 0;
                    $cSections = $sectionsByClass->get($c->class_id, collect());
                    $subjectNamesString = strtolower($cSubjects->pluck('name')->implode(' '));
                @endphp

                <div class="col-xl-4 col-md-6 mb-4 class-item-card"
                     data-name="{{ strtolower($c->name) }}"
                     data-code="{{ strtolower($c->class_code ?? '') }}"
                     data-room="{{ strtolower($c->class_room ?? '') }}"
                     data-teacher="{{ strtolower($c->teacher_name ?? '') }}"
                     data-subjects="{{ $subjectNamesString }}"
                     data-subject-count="{{ $cSubjects->count() }}">

                    <div class="sub-class-card">
                        <!-- Top Accent Line -->
                        <div class="sub-card-top-bar" style="background: {{ $palette['bar'] }};"></div>

                        <!-- Card Header -->
                        <div class="sub-card-header d-flex justify-content-between align-items-start">
                            <div class="d-flex align-items-center">
                                <span class="mr-3" style="width: 44px; height: 44px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; background: rgba(99, 102, 241, 0.12); flex-shrink: 0;">
                                    <i class="fas {{ $palette['icon'] }}" style="color: {{ $palette['iconColor'] }}; font-size: 1.25rem;"></i>
                                </span>
                                <div>
                                    <h5 class="font-weight-bold mb-1">
                                        <a href="{{ route('subject.index', ['class_id' => $c->class_id]) }}" class="text-reset text-decoration-none" title="Manage Subjects">
                                            {{ $c->name }}
                                        </a>
                                    </h5>
                                    <div class="text-xs text-muted">
                                        <span class="badge badge-light border text-muted mr-1">Code: <b>{{ $c->class_code ?? 'N/A' }}</b></span>
                                        @if(!empty($c->class_room))
                                            <span class="badge badge-light border text-muted">Room: <b>{{ $c->class_room }}</b></span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <span class="badge {{ $cSubjects->count() > 0 ? $palette['badge'] : 'badge-secondary' }} px-2 py-1 text-xs" style="border-radius: 8px;">
                                {{ $cSubjects->count() }} {{ Str::plural('Subject', $cSubjects->count()) }}
                            </span>
                        </div>

                        <!-- Card Body: Subjects Preview List -->
                        <div class="sub-card-body">
                            <div class="mb-3">
                                <span class="text-xs text-uppercase font-weight-bold text-muted d-block mb-2" style="letter-spacing: 0.5px;">
                                    <i class="fas fa-list-check mr-1 text-primary"></i> Curriculum Subjects:
                                </span>

                                <div class="d-flex flex-wrap" style="min-height: 48px;">
                                    @forelse($cSubjects as $s)
                                        <span class="subject-pill" title="Instructor: {{ $s->teacher_name ?? 'Unassigned' }}">
                                            <i class="fas fa-book text-muted" style="font-size: 10px;"></i>
                                            <span>{{ $s->name }}</span>
                                            @if($s->teacher_name)
                                                <small class="text-muted">({{ Str::limit($s->teacher_name, 12) }})</small>
                                            @endif
                                        </span>
                                    @empty
                                        <div class="w-100 py-2 px-3 rounded text-center small text-muted" style="background: var(--sub-subtle-bg); border: 1px dashed var(--sub-card-border);">
                                            <i class="fas fa-circle-info mr-1"></i> No subjects assigned to this class yet.
                                            @if(in_array(Auth::user()->role, [0, 4]))
                                                <div class="mt-1">
                                                    <a href="javascript:void(0)" onclick="openAddSubjectForClass({{ $c->class_id }}, '{{ addslashes($c->name) }}')" class="font-weight-bold text-primary">
                                                        + Add First Subject
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Meta Details: Class Teacher & Sections -->
                            <div class="row pt-2 border-top" style="font-size: 12px;">
                                <div class="col-7 pr-1">
                                    <span class="text-muted d-block text-xs">Class In-charge</span>
                                    <span class="font-weight-bold text-truncate d-block">
                                        <i class="fas fa-chalkboard-user mr-1 text-muted"></i>
                                        {{ $c->teacher_name ?? 'Not Assigned' }}
                                    </span>
                                </div>
                                <div class="col-5 pl-1 text-right">
                                    <span class="text-muted d-block text-xs">Students</span>
                                    <span class="font-weight-bold text-primary">
                                        <i class="fas fa-user-graduate mr-1"></i>
                                        {{ $cStudentsCount }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="sub-card-footer">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('students.byClass', $c->class_id) }}" class="btn btn-sub-outline btn-sm py-1 px-2" title="View Students Roster">
                                    <i class="fas fa-users mr-1"></i> Roster
                                </a>
                                <a href="{{ route('class_routines.index', $c->class_id) }}" class="btn btn-sub-outline btn-sm py-1 px-2 ml-1" title="View Timetable Routine">
                                    <i class="fas fa-calendar-days mr-1"></i> Routine
                                </a>
                            </div>

                            <a href="{{ route('subject.index', ['class_id' => $c->class_id]) }}" class="btn btn-sub-primary btn-sm py-1 px-3 shadow-sm font-weight-bold">
                                <span>Manage Subjects</span>
                                <i class="fas fa-arrow-right ml-1 text-xs"></i>
                            </a>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-folder-open fa-3x text-muted opacity-50 mb-3"></i>
                    <h5 class="font-weight-bold">No Classes Available</h5>
                    <p class="text-muted small">No class programs have been registered in the system yet.</p>
                </div>
            @endforelse
        </div>

        <!-- No Filter Results Message -->
        <div id="noGridMatchMessage" class="text-center py-5" style="display: none;">
            <i class="fas fa-search fa-3x text-muted opacity-50 mb-3"></i>
            <h5 class="font-weight-bold">No matching classes found</h5>
            <p class="text-muted small">Try adjusting your search criteria or filter options.</p>
            <button type="button" class="btn btn-sm btn-sub-outline" onclick="resetClassFilters()">Reset Filters</button>
        </div>
    </div>

    <!-- 6. TABLE LIST VIEW (Hidden by Default) -->
    <div id="classesTableSection" class="sub-controls-card p-0" style="display: none; overflow: hidden;">
        <div class="table-responsive">
            <table class="table sub-table mb-0" id="classesListTable">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Class Name</th>
                        <th>Code & Room</th>
                        <th>Class In-charge</th>
                        <th>Assigned Subjects</th>
                        <th class="text-center" style="width: 90px;">Students</th>
                        <th class="text-right" style="width: 200px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($classes as $index => $c)
                        @php
                            $cSubjects = $subjectsByClass->get($c->class_id, collect());
                            $cStudentsCount = $studentCounts[$c->class_id] ?? 0;
                            $subjectNamesString = strtolower($cSubjects->pluck('name')->implode(' '));
                        @endphp
                        <tr class="class-table-row"
                            data-name="{{ strtolower($c->name) }}"
                            data-code="{{ strtolower($c->class_code ?? '') }}"
                            data-room="{{ strtolower($c->class_room ?? '') }}"
                            data-teacher="{{ strtolower($c->teacher_name ?? '') }}"
                            data-subjects="{{ $subjectNamesString }}"
                            data-subject-count="{{ $cSubjects->count() }}">
                            <td class="font-weight-bold text-muted">{{ $index + 1 }}</td>
                            <td>
                                <strong>
                                    <a href="{{ route('subject.index', ['class_id' => $c->class_id]) }}" class="text-reset">
                                        {{ $c->name }}
                                    </a>
                                </strong>
                            </td>
                            <td>
                                <span class="badge badge-light border text-muted mr-1">Code: <b>{{ $c->class_code ?? 'N/A' }}</b></span>
                                @if(!empty($c->class_room))
                                    <span class="badge badge-light border text-muted">Room: <b>{{ $c->class_room }}</b></span>
                                @endif
                            </td>
                            <td>
                                <span>{{ $c->teacher_name ?? 'Not Assigned' }}</span>
                            </td>
                            <td>
                                <div class="d-flex flex-wrap align-items-center">
                                    @forelse($cSubjects->take(4) as $s)
                                        <span class="badge badge-light border text-dark mr-1 mb-1 font-weight-normal">
                                            {{ $s->name }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-muted font-italic">No subjects</span>
                                    @endforelse
                                    @if($cSubjects->count() > 4)
                                        <span class="badge badge-primary text-xs">+{{ $cSubjects->count() - 4 }} more</span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-pill badge-info px-2">{{ $cStudentsCount }}</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('students.byClass', $c->class_id) }}" class="btn btn-outline-secondary btn-sm" title="Roster">
                                        <i class="fas fa-users"></i>
                                    </a>
                                    <a href="{{ route('class_routines.index', $c->class_id) }}" class="btn btn-outline-secondary btn-sm" title="Routine">
                                        <i class="fas fa-calendar-days"></i>
                                    </a>
                                    <a href="{{ route('subject.index', ['class_id' => $c->class_id]) }}" class="btn btn-primary btn-sm font-weight-bold ml-1">
                                        <i class="fas fa-book-open mr-1"></i> Subjects
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- No Table Match Message -->
        <div id="noTableMatchMessage" class="text-center py-5" style="display: none;">
            <i class="fas fa-search fa-3x text-muted opacity-50 mb-3"></i>
            <h5 class="font-weight-bold">No matching classes found</h5>
            <p class="text-muted small">Try adjusting your search query.</p>
        </div>
    </div>

</div>

<!-- Quick Add Subject Modal -->
@if(in_array(Auth::user()->role, [0, 4]))
<div class="modal fade" id="quickAddSubjectModal" tabindex="-1" role="dialog" aria-labelledby="quickAddModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('subject.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="quickAddModalLabel">
                        <i class="fas fa-plus-circle text-primary mr-1"></i> Add Subject Module
                    </h5>
                    <button type="button" class="close text-muted" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Academic Class <span class="text-danger">*</span></label>
                        <select name="class_id" id="modalClassSelect" class="custom-select font-weight-bold" required>
                            <option value="" disabled selected>-- Select Target Class --</option>
                            @foreach($classes as $c)
                                <option value="{{ $c->class_id }}">{{ $c->name }} ({{ $c->class_code ?? 'Class' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Subject Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Advanced Laravel, UI/UX Design, Data Structures" required>
                    </div>

                    <div class="form-group mb-0">
                        <label class="font-weight-bold">Assign Specialist Teacher</label>
                        <select name="teacher_id" class="custom-select">
                            <option value="">-- No Teacher Assigned Yet --</option>
                            @foreach($teachers as $t)
                                <option value="{{ $t->teacher_id }}">{{ $t->name }} (Teacher #{{ $t->teacher_id }})</option>
                            @endforeach
                        </select>
                        <small class="text-muted mt-1 d-block">You can reassign or update instructors anytime from the class subject table.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">
                        <i class="fas fa-check mr-1"></i> Save Subject
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('classSearchInput');
    const filterButtons = document.querySelectorAll('.class-filter-btn');
    const gridCards = document.querySelectorAll('.class-item-card');
    const tableRows = document.querySelectorAll('.class-table-row');
    const noGridMatch = document.getElementById('noGridMatchMessage');
    const noTableMatch = document.getElementById('noTableMatchMessage');

    const viewGridBtn = document.getElementById('viewGridBtn');
    const viewTableBtn = document.getElementById('viewTableBtn');
    const gridSection = document.getElementById('classesGridSection');
    const tableSection = document.getElementById('classesTableSection');

    let currentFilter = 'all';

    // 1. Live Search & Filtering Function
    function applyFiltering() {
        const query = (searchInput.value || '').toLowerCase().trim();
        let visibleGridCount = 0;
        let visibleTableCount = 0;

        // Filter Grid Cards
        gridCards.forEach(card => {
            const name = card.dataset.name || '';
            const code = card.dataset.code || '';
            const room = card.dataset.room || '';
            const teacher = card.dataset.teacher || '';
            const subjects = card.dataset.subjects || '';
            const count = parseInt(card.dataset.subjectCount || '0', 10);

            const matchesQuery = (!query || name.includes(query) || code.includes(query) || room.includes(query) || teacher.includes(query) || subjects.includes(query));
            
            let matchesFilter = true;
            if (currentFilter === 'has-subjects') {
                matchesFilter = count > 0;
            } else if (currentFilter === 'no-subjects') {
                matchesFilter = count === 0;
            }

            if (matchesQuery && matchesFilter) {
                card.style.display = '';
                visibleGridCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Filter Table Rows
        tableRows.forEach(row => {
            const name = row.dataset.name || '';
            const code = row.dataset.code || '';
            const room = row.dataset.room || '';
            const teacher = row.dataset.teacher || '';
            const subjects = row.dataset.subjects || '';
            const count = parseInt(row.dataset.subjectCount || '0', 10);

            const matchesQuery = (!query || name.includes(query) || code.includes(query) || room.includes(query) || teacher.includes(query) || subjects.includes(query));
            
            let matchesFilter = true;
            if (currentFilter === 'has-subjects') {
                matchesFilter = count > 0;
            } else if (currentFilter === 'no-subjects') {
                matchesFilter = count === 0;
            }

            if (matchesQuery && matchesFilter) {
                row.style.display = '';
                visibleTableCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Toggle Empty Match Messages
        if (noGridMatch) noGridMatch.style.display = visibleGridCount === 0 ? 'block' : 'none';
        if (noTableMatch) noTableMatch.style.display = visibleTableCount === 0 ? 'block' : 'none';
    }

    if (searchInput) {
        searchInput.addEventListener('input', applyFiltering);
    }

    // Filter Buttons Click
    filterButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            filterButtons.forEach(b => {
                b.classList.remove('btn-primary', 'active');
                b.classList.add('btn-outline-secondary');
            });
            this.classList.remove('btn-outline-secondary');
            this.classList.add('btn-primary', 'active');
            currentFilter = this.dataset.filter;
            applyFiltering();
        });
    });

    // View Toggle Handlers
    if (viewGridBtn && viewTableBtn) {
        viewGridBtn.addEventListener('click', function () {
            viewGridBtn.classList.add('btn-primary', 'active');
            viewGridBtn.classList.remove('btn-outline-secondary');
            viewTableBtn.classList.remove('btn-primary', 'active');
            viewTableBtn.classList.add('btn-outline-secondary');

            gridSection.style.display = '';
            tableSection.style.display = 'none';
        });

        viewTableBtn.addEventListener('click', function () {
            viewTableBtn.classList.add('btn-primary', 'active');
            viewTableBtn.classList.remove('btn-outline-secondary');
            viewGridBtn.classList.remove('btn-primary', 'active');
            viewGridBtn.classList.add('btn-outline-secondary');

            gridSection.style.display = 'none';
            tableSection.style.display = '';
        });
    }

    // Window expose for reset function
    window.resetClassFilters = function () {
        if (searchInput) searchInput.value = '';
        const allBtn = document.querySelector('.class-filter-btn[data-filter="all"]');
        if (allBtn) allBtn.click();
    };

    // Helper to pre-select class in modal
    window.openAddSubjectForClass = function (classId, className) {
        const select = document.getElementById('modalClassSelect');
        if (select) {
            select.value = classId;
        }
        if (window.jQuery) {
            $('#quickAddSubjectModal').modal('show');
        }
    };
});
</script>
@endsection
