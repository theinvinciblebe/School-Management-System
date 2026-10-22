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
    .process-step-card {
        background: rgba(99, 102, 241, 0.05);
        border: 1px dashed rgba(99, 102, 241, 0.25);
        border-radius: 12px;
        padding: 1rem 1.25rem;
        transition: all 0.2s ease;
    }
    .process-step-card:hover {
        background: rgba(99, 102, 241, 0.08);
        border-color: rgba(99, 102, 241, 0.45);
    }
    .step-number-badge {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        box-shadow: 0 3px 8px rgba(99, 102, 241, 0.35);
        flex-shrink: 0;
    }
    .class-card {
        border-radius: 14px;
        transition: all 0.25s ease;
        border: 1px solid rgba(0, 0, 0, 0.07);
        overflow: hidden;
        background: #fff;
    }
    .class-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.1) !important;
        border-color: rgba(99, 102, 241, 0.35);
    }
    .class-card-header {
        padding: 1.25rem 1.25rem 0.75rem 1.25rem;
        position: relative;
    }
    .class-card-top-bar {
        height: 5px;
        width: 100%;
    }
    .student-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        color: #fff;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        box-shadow: 0 3px 8px rgba(99, 102, 241, 0.3);
        flex-shrink: 0;
        overflow: hidden;
    }
    .student-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .roll-pill {
        font-family: monospace;
        font-size: 11px;
        letter-spacing: 0.5px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 12px;
    }
    .tab-pills-container .nav-pills .nav-link {
        border-radius: 20px;
        padding: 0.45rem 1.25rem;
        font-weight: 600;
        font-size: 13px;
        color: #64748b;
        background: transparent;
        transition: all 0.2s ease;
    }
    .tab-pills-container .nav-pills .nav-link.active {
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #fff;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.35);
    }
    .profile-hero-banner {
        background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
        color: #fff;
        padding: 1.75rem 1.5rem;
        position: relative;
    }
    .dark-mode .class-card {
        background-color: #1e293b;
        border-color: rgba(255, 255, 255, 0.08);
    }
    .dark-mode .class-card:hover {
        border-color: rgba(99, 102, 241, 0.5);
    }
    .dark-mode .process-step-card {
        background: rgba(99, 102, 241, 0.1);
        border-color: rgba(99, 102, 241, 0.3);
    }
    .dark-mode .tab-pills-container .nav-pills .nav-link {
        color: #94a3b8;
    }
    .dark-mode .tab-pills-container .nav-pills .nav-link.active {
        color: #fff;
    }
    .gender-bar {
        height: 8px;
        border-radius: 4px;
        overflow: hidden;
        display: flex;
        background: #e2e8f0;
    }
</style>

<!-- Header & Breadcrumb -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-7">
                <div class="d-flex align-items-center flex-wrap">
                    <h1 class="m-0 font-weight-bold mr-3">
                        <i class="fas fa-user-graduate text-purple mr-2" style="color: #8b5cf6;"></i>{{ __('Student Information') }}
                    </h1>
                    <span class="badge badge-light border text-muted px-2 py-1 text-xs" style="border-radius: 12px;">
                        <i class="fas fa-layer-group mr-1 text-primary"></i> Academic Hub
                    </span>
                </div>
                <p class="text-muted text-sm mb-0 mt-1">
                    Select a class roster below to manage students, or search directly across the institutional directory.
                </p>
            </div>
            <div class="col-sm-5 text-sm-right mt-3 mt-sm-0">
                @if (in_array(Auth::user()->role, [0, 3, 4]))
                    <a href="{{ route('students.index') }}" class="btn btn-primary btn-sm px-3 shadow-sm mr-2" style="border-radius: 20px;">
                        <i class="fas fa-user-plus mr-1"></i> Admit Student
                    </a>
                @endif
                @if (in_array(Auth::user()->role, [0, 4]))
                    <a href="{{ route('admissions.list') }}" class="btn btn-outline-secondary btn-sm px-3 shadow-sm mr-2" style="border-radius: 20px;">
                        <i class="fas fa-list-alt mr-1"></i> Admission List
                    </a>
                @endif
                <ol class="breadcrumb float-sm-right bg-transparent p-0 d-inline-block align-middle mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item active">Student Information</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        <!-- Top Institutional Metrics -->
        <div class="row mb-4">
            <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
                <div class="card metric-card shadow-sm border-0 bg-gradient-primary text-white h-100">
                    <div class="card-body p-3">
                        <span class="text-uppercase text-xs font-weight-bold" style="letter-spacing: 0.5px;">Enrolled Students</span>
                        <h2 class="font-weight-bold mt-1 mb-0">{{ number_format($enrolledStudentsCount) }}</h2>
                        <span class="text-xs opacity-75">
                            {{ $totalStudents > 0 ? round(($enrolledStudentsCount / $totalStudents) * 100) : 0 }}% of total admitted ({{ $totalStudents }})
                        </span>
                        <i class="fas fa-user-graduate icon-bg text-white"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
                <div class="card metric-card shadow-sm border-0 bg-gradient-info text-white h-100">
                    <div class="card-body p-3">
                        <span class="text-uppercase text-xs font-weight-bold" style="letter-spacing: 0.5px;">Active Classes</span>
                        <h2 class="font-weight-bold mt-1 mb-0">{{ number_format($totalClasses) }}</h2>
                        <span class="text-xs opacity-75">With {{ $totalSections }} total class sections</span>
                        <i class="fas fa-chalkboard icon-bg text-white"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
                <div class="card metric-card shadow-sm border-0 bg-gradient-success text-white h-100">
                    <div class="card-body p-3">
                        <span class="text-uppercase text-xs font-weight-bold" style="letter-spacing: 0.5px;">Gender Breakdown</span>
                        <h2 class="font-weight-bold mt-1 mb-0">
                            {{ $totalMale }} <span class="text-xs font-weight-normal opacity-75">M</span> / {{ $totalFemale }} <span class="text-xs font-weight-normal opacity-75">F</span>
                        </h2>
                        @php
                            $malePercent = ($totalStudents > 0) ? round(($totalMale / $totalStudents) * 100) : 0;
                            $femalePercent = ($totalStudents > 0) ? (100 - $malePercent) : 0;
                        @endphp
                        <span class="text-xs opacity-75">
                            <i class="fas fa-mars mr-1"></i>{{ $malePercent }}% Male &bull; <i class="fas fa-venus mr-1"></i>{{ $femalePercent }}% Female
                        </span>
                        <i class="fas fa-restroom icon-bg text-white"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
                <div class="card metric-card shadow-sm border-0 bg-gradient-warning text-dark h-100">
                    <div class="card-body p-3">
                        <span class="text-uppercase text-xs font-weight-bold" style="letter-spacing: 0.5px;">Unassigned Students</span>
                        <h2 class="font-weight-bold mt-1 mb-0">{{ number_format($unenrolledCount) }}</h2>
                        <span class="text-xs opacity-75">
                            @if($unenrolledCount > 0)
                                <a href="#global-directory" class="text-dark font-weight-bold" onclick="filterUnassigned()">Needs Class Placement &rarr;</a>
                            @else
                                All students placed in classes
                            @endif
                        </span>
                        <i class="fas fa-user-clock icon-bg text-dark"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modern 3-Step Process Flow Guide -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm" style="border-radius: 14px;">
                    <div class="card-body p-3">
                        <div class="row align-items-center">
                            <div class="col-md-4 mb-2 mb-md-0">
                                <div class="process-step-card d-flex align-items-center">
                                    <div class="step-number-badge mr-3">1</div>
                                    <div>
                                        <h6 class="font-weight-bold mb-0 text-sm">Select Class or Search</h6>
                                        <span class="text-xs text-muted">Click a class card below or use the Global Directory.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2 mb-md-0">
                                <div class="process-step-card d-flex align-items-center">
                                    <div class="step-number-badge mr-3" style="background: linear-gradient(135deg, #3b82f6, #06b6d4);">2</div>
                                    <div>
                                        <h6 class="font-weight-bold mb-0 text-sm">Inspect Class Roster</h6>
                                        <span class="text-xs text-muted">Filter by sections, toggle Grid or Table layout modes.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="process-step-card d-flex align-items-center">
                                    <div class="step-number-badge mr-3" style="background: linear-gradient(135deg, #10b981, #059669);">3</div>
                                    <div>
                                        <h6 class="font-weight-bold mb-0 text-sm">Manage & Reassign</h6>
                                        <span class="text-xs text-muted">Update sections, roll numbers, or view profile dossiers.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs: Class Roster Cards vs Global Student Directory -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 14px; overflow: hidden;">
            <div class="card-header bg-white border-bottom p-3">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-2 mb-lg-0 tab-pills-container">
                        <ul class="nav nav-pills" id="processTabs" role="tablist">
                            <li class="nav-item mr-2">
                                <a class="nav-link active" id="classes-tab" data-toggle="pill" href="#classes-panel" role="tab">
                                    <i class="fas fa-th-large mr-1"></i> Class Rosters ({{ $totalClasses }})
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="directory-tab" data-toggle="pill" href="#directory-panel" role="tab">
                                    <i class="fas fa-users mr-1"></i> Global Student Directory ({{ $totalStudents }})
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-6 d-flex justify-content-lg-end align-items-center flex-wrap">
                        <!-- Search Box (Dynamically filters active tab) -->
                        <div class="input-group input-group-sm mr-2 mb-2 mb-sm-0" style="max-width: 280px;">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-transparent border-right-0" style="border-radius: 20px 0 0 20px;">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                            </div>
                            <input type="text" id="unifiedSearchInput" class="form-control border-left-0" placeholder="Search class or student..." style="border-radius: 0 20px 20px 0;">
                        </div>

                        <!-- Class Filter Status Buttons (Visible on Classes Tab) -->
                        <div class="btn-group btn-group-sm" id="classFilterGroup" role="group">
                            <button type="button" class="btn btn-primary active class-filter-btn" data-filter="all" style="border-radius: 20px 0 0 20px;">All</button>
                            <button type="button" class="btn btn-outline-secondary class-filter-btn" data-filter="active">With Students</button>
                            <button type="button" class="btn btn-outline-secondary class-filter-btn" data-filter="empty" style="border-radius: 0 20px 20px 0;">Empty</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <div class="tab-content" id="processTabsContent">

                    <!-- ======================================================== -->
                    <!-- TAB 1: CLASS ROSTER CARDS (Primary Class Selection Flow) -->
                    <!-- ======================================================== -->
                    <div class="tab-pane fade show active" id="classes-panel" role="tabpanel">

                        <div class="row" id="classesGridContainer">
                            @forelse($classes as $index => $c)
                                @php
                                    $cStudentCount = $studentCounts[$c->class_id] ?? 0;
                                    $cSections = $sections->get($c->class_id, collect());
                                    $genderStat = $classGenderStats->get($c->class_id);
                                    $cMale = $genderStat->male_count ?? 0;
                                    $cFemale = $genderStat->female_count ?? 0;

                                    $cardColors = [
                                        ['bar' => 'linear-gradient(90deg, #6366f1, #8b5cf6)', 'badge' => 'badge-primary', 'iconColor' => '#6366f1'],
                                        ['bar' => 'linear-gradient(90deg, #3b82f6, #06b6d4)', 'badge' => 'badge-info', 'iconColor' => '#0284c7'],
                                        ['bar' => 'linear-gradient(90deg, #10b981, #059669)', 'badge' => 'badge-success', 'iconColor' => '#059669'],
                                        ['bar' => 'linear-gradient(90deg, #f59e0b, #d97706)', 'badge' => 'badge-warning', 'iconColor' => '#d97706'],
                                        ['bar' => 'linear-gradient(90deg, #ec4899, #8b5cf6)', 'badge' => 'badge-danger', 'iconColor' => '#db2777'],
                                    ];
                                    $palette = $cardColors[$index % count($cardColors)];
                                @endphp

                                <div class="col-xl-4 col-md-6 mb-4 class-card-col"
                                     data-class-id="{{ $c->class_id }}"
                                     data-name="{{ strtolower($c->name) }}"
                                     data-code="{{ strtolower($c->class_code ?? '') }}"
                                     data-room="{{ strtolower($c->class_room ?? '') }}"
                                     data-teacher="{{ strtolower($c->teacher_name ?? '') }}"
                                     data-has-students="{{ $cStudentCount > 0 ? 'true' : 'false' }}">

                                    <div class="card class-card shadow-sm h-100">
                                        <!-- Top Accent Gradient Line -->
                                        <div class="class-card-top-bar" style="background: {{ $palette['bar'] }};"></div>

                                        <!-- Header -->
                                        <div class="class-card-header d-flex justify-content-between align-items-start">
                                            <div>
                                                <div class="d-flex align-items-center mb-1">
                                                    <span class="btn btn-light btn-circle mr-2 p-0" style="width: 36px; height: 36px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; background: rgba(99, 102, 241, 0.1);">
                                                        <i class="fas fa-graduation-cap" style="color: {{ $palette['iconColor'] }}; font-size: 16px;"></i>
                                                    </span>
                                                    <div>
                                                        <h5 class="font-weight-bold mb-0 text-dark">
                                                            <a href="{{ route('students.byClass', $c->class_id) }}" class="text-dark text-decoration-none">
                                                                {{ $c->name }}
                                                            </a>
                                                        </h5>
                                                        <span class="text-xs text-muted">
                                                            <i class="fas fa-barcode mr-1"></i>Code: <b>{{ $c->class_code ?? 'N/A' }}</b> &bull;
                                                            <i class="fas fa-door-open mr-1"></i>Room: <b>{{ $c->class_room ?? 'N/A' }}</b>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <span class="badge {{ $palette['badge'] }} px-2 py-1 text-xs" style="border-radius: 8px;">
                                                {{ $cStudentCount }} {{ Str::plural('Student', $cStudentCount) }}
                                            </span>
                                        </div>

                                        <!-- Card Details -->
                                        <div class="card-body p-3 pt-2">
                                            <!-- Teacher Incharge -->
                                            <div class="d-flex align-items-center bg-light p-2 rounded mb-3" style="font-size: 12px; border-radius: 8px;">
                                                <i class="fas fa-chalkboard-teacher mr-2 text-muted" style="font-size: 16px;"></i>
                                                <div class="text-truncate">
                                                    <span class="text-muted d-block text-xs">Class Teacher / Incharge</span>
                                                    <span class="font-weight-bold text-dark text-truncate">
                                                        {{ $c->teacher_name ?? 'Not Assigned' }}
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Active Sections -->
                                            <div class="mb-3">
                                                <span class="text-xs text-uppercase font-weight-bold text-muted d-block mb-1" style="letter-spacing: 0.5px;">
                                                    Active Sections ({{ $cSections->count() }}):
                                                </span>
                                                <div class="d-flex flex-wrap" style="gap: 4px;">
                                                    @forelse($cSections as $sec)
                                                        <span class="badge badge-secondary py-1 px-2 text-xs" style="border-radius: 6px; font-weight: 500;">
                                                            {{ $sec->name }}
                                                        </span>
                                                    @empty
                                                        <span class="text-xs text-muted font-italic">No sections configured</span>
                                                    @endforelse
                                                </div>
                                            </div>

                                            <!-- Gender Breakdown (if has students) -->
                                            @if($cStudentCount > 0)
                                                <div class="mb-2">
                                                    <div class="d-flex justify-content-between text-xs text-muted mb-1">
                                                        <span><i class="fas fa-mars mr-1 text-primary"></i> {{ $cMale }} Male</span>
                                                        <span><i class="fas fa-venus mr-1 text-danger"></i> {{ $cFemale }} Female</span>
                                                    </div>
                                                    @php
                                                        $maleRatio = round(($cMale / $cStudentCount) * 100);
                                                    @endphp
                                                    <div class="progress" style="height: 5px; border-radius: 3px;">
                                                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $maleRatio }}%"></div>
                                                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ 100 - $maleRatio }}%"></div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Card Footer: Flow Action Buttons -->
                                        <div class="card-footer bg-transparent border-top p-3 d-flex justify-content-between align-items-center">
                                            <a href="{{ route('attendance.show', $c->class_id) }}" class="btn btn-outline-secondary btn-xs px-2 shadow-sm" style="border-radius: 6px;" title="Attendance">
                                                <i class="fas fa-calendar-check mr-1"></i> Attendance
                                            </a>

                                            <a href="{{ route('students.byClass', $c->class_id) }}" class="btn btn-primary btn-sm px-3 shadow-sm font-weight-bold" style="border-radius: 20px;">
                                                <span>View Roster</span>
                                                <i class="fas fa-arrow-right ml-1 text-xs"></i>
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center py-5">
                                    <i class="fas fa-school fa-3x text-muted opacity-50 mb-3"></i>
                                    <h5>No classes found</h5>
                                    <p class="text-muted text-sm">Please create a class in Class Management first.</p>
                                    @if(Auth::user()->role == 0)
                                        <a href="{{ route('class.create') }}" class="btn btn-primary btn-sm" style="border-radius: 20px;">
                                            <i class="fas fa-plus mr-1"></i> Create Class
                                        </a>
                                    @endif
                                </div>
                            @endforelse
                        </div>

                        <!-- No Class Match Alert -->
                        <div id="noClassMatch" class="text-center py-5" style="display: none;">
                            <i class="fas fa-search fa-3x text-muted opacity-50 mb-2"></i>
                            <h6 class="font-weight-bold">No classes match your filter</h6>
                            <p class="text-muted text-sm">Try adjusting your search query or status filter.</p>
                            <button type="button" class="btn btn-xs btn-outline-primary" id="resetClassFilterBtn">Reset Filter</button>
                        </div>

                    </div>

                    <!-- ======================================================== -->
                    <!-- TAB 2: GLOBAL STUDENT DIRECTORY (Instant Student Search) -->
                    <!-- ======================================================== -->
                    <div class="tab-pane fade" id="directory-panel" role="tabpanel">

                        <div class="table-responsive">
                            <table class="table table-hover student-table mb-0" id="globalStudentsTable">
                                <thead>
                                    <tr class="bg-light">
                                        <th style="width: 50px;">#</th>
                                        <th>Student</th>
                                        <th>Class & Section</th>
                                        <th>Roll Number</th>
                                        <th>Gender</th>
                                        <th>Parent / Guardian</th>
                                        <th>Contact</th>
                                        <th class="text-right" style="width: 130px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($studentsDirectory as $index => $s)
                                        @php
                                            $initials = strtoupper(substr($s->name ?? 'ST', 0, 2));
                                            $avatarColor = match($index % 5) {
                                                0 => 'linear-gradient(135deg, #6366f1, #8b5cf6)',
                                                1 => 'linear-gradient(135deg, #3b82f6, #06b6d4)',
                                                2 => 'linear-gradient(135deg, #10b981, #059669)',
                                                3 => 'linear-gradient(135deg, #f59e0b, #d97706)',
                                                default => 'linear-gradient(135deg, #ec4899, #8b5cf6)',
                                            };
                                            $hasPhoto = (!empty($s->photo) && $s->photo !== 'noimg.jpg');
                                            $photoUrl = asset('students_image/' . ($s->photo ?? 'noimg.jpg'));
                                            $genderText = ($s->sex == 0) ? 'Male' : 'Female';
                                            $genderBadge = ($s->sex == 0) ? 'badge-primary' : 'badge-danger';
                                            $genderIcon = ($s->sex == 0) ? 'fa-mars' : 'fa-venus';
                                            $isEnrolled = !empty($s->class_id);
                                        @endphp

                                        <tr class="global-student-row"
                                            data-name="{{ strtolower($s->name) }}"
                                            data-email="{{ strtolower($s->email ?? '') }}"
                                            data-phone="{{ strtolower($s->phone ?? '') }}"
                                            data-class="{{ strtolower($s->class_name ?? '') }}"
                                            data-section="{{ strtolower($s->section_name ?? '') }}"
                                            data-roll="{{ strtolower($s->roll ?? '') }}"
                                            data-parent="{{ strtolower($s->parent_name ?? '') }}"
                                            data-is-enrolled="{{ $isEnrolled ? 'true' : 'false' }}">

                                            <!-- Index -->
                                            <td class="text-muted text-xs font-weight-bold">
                                                {{ $index + 1 }}
                                            </td>

                                            <!-- Student Info -->
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="student-avatar mr-2" style="background: {{ $avatarColor }};">
                                                        @if($hasPhoto)
                                                            <img src="{{ $photoUrl }}" alt="{{ $s->name }}" onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';">
                                                            <span style="display: none;">{{ $initials }}</span>
                                                        @else
                                                            <span>{{ $initials }}</span>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <a href="javascript:void(0)" class="font-weight-bold text-dark view-hub-profile-btn" data-student='@json($s)'>
                                                            {{ $s->name }}
                                                        </a>
                                                        <div class="text-xs text-muted">ID: #{{ $s->student_id }}</div>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Class & Section -->
                                            <td>
                                                @if($isEnrolled)
                                                    <a href="{{ route('students.byClass', $s->class_id) }}" class="badge badge-light border text-dark py-1 px-2 text-xs" style="border-radius: 6px;">
                                                        <i class="fas fa-graduation-cap mr-1 text-primary"></i> <b>{{ $s->class_name }}</b>
                                                    </a>
                                                    <span class="badge badge-secondary py-1 px-2 text-xs ml-1" style="border-radius: 6px;">
                                                        {{ $s->section_name ?? 'N/A' }}
                                                    </span>
                                                @else
                                                    <span class="badge badge-warning text-dark py-1 px-2 text-xs" style="border-radius: 6px;">
                                                        <i class="fas fa-exclamation-triangle mr-1"></i> Not Enrolled
                                                    </span>
                                                @endif
                                            </td>

                                            <!-- Roll Number -->
                                            <td>
                                                @if($s->roll)
                                                    <span class="badge badge-primary roll-pill">#{{ $s->roll }}</span>
                                                @else
                                                    <span class="text-muted text-xs font-italic">-</span>
                                                @endif
                                            </td>

                                            <!-- Gender -->
                                            <td>
                                                <span class="badge {{ $genderBadge }} px-2 py-1 text-xs" style="border-radius: 10px;">
                                                    <i class="fas {{ $genderIcon }} mr-1"></i> {{ $genderText }}
                                                </span>
                                            </td>

                                            <!-- Parent / Guardian -->
                                            <td>
                                                <div class="font-weight-bold text-dark text-xs">
                                                    {{ $s->parent_name ?? 'N/A' }}
                                                </div>
                                                <span class="text-xs text-muted">{{ $s->parent_phone ?? '' }}</span>
                                            </td>

                                            <!-- Contact -->
                                            <td>
                                                <div class="text-truncate text-xs" style="max-width: 160px;" title="{{ $s->email }}">
                                                    <i class="far fa-envelope text-muted mr-1"></i> {{ $s->email ?? 'N/A' }}
                                                </div>
                                                <span class="text-xs text-muted">
                                                    <i class="fas fa-phone text-muted mr-1"></i> {{ $s->phone ?? 'N/A' }}
                                                </span>
                                            </td>

                                            <!-- Action -->
                                            <td class="text-right">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-xs btn-outline-primary view-hub-profile-btn shadow-sm mr-1"
                                                            data-student='@json($s)' title="View Profile Dossier">
                                                        <i class="fas fa-id-card"></i>
                                                    </button>
                                                    @if($isEnrolled)
                                                        <a href="{{ route('students.byClass', $s->class_id) }}" class="btn btn-xs btn-outline-info shadow-sm" title="Go to Class Roster">
                                                            <i class="fas fa-arrow-right"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4 text-muted">
                                                No students found in the database.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- No Match in Global Directory -->
                        <div id="noDirectoryMatch" class="text-center py-5" style="display: none;">
                            <i class="fas fa-user-slash fa-3x text-muted opacity-50 mb-2"></i>
                            <h6 class="font-weight-bold">No students match your search</h6>
                            <p class="text-muted text-sm">Try searching by student name, roll number, or class.</p>
                            <button type="button" class="btn btn-xs btn-outline-primary" id="resetDirectoryFilterBtn">Reset Search</button>
                        </div>

                    </div>

                </div>
            </div>

            <!-- Footer Meta -->
            <div class="card-footer bg-light p-3 d-flex justify-content-between align-items-center flex-wrap">
                <span class="text-xs text-muted">
                    <i class="fas fa-info-circle mr-1"></i> Institutional Student Management System &bull; Total records: <b>{{ $totalStudents }}</b>
                </span>
                <span class="text-xs text-muted">
                    Updated {{ now()->format('M d, Y') }}
                </span>
            </div>

        </div>

    </div>
</section>

<!-- ======================================================== -->
<!-- MODAL: VIEW STUDENT FULL PROFILE DOSSIER -->
<!-- ======================================================== -->
<div class="modal fade" id="hubStudentProfileModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px; overflow: hidden;">

            <!-- Hero Header -->
            <div class="profile-hero-banner d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="student-avatar mr-3" id="hubModalAvatar" style="width: 65px; height: 65px; font-size: 24px; border: 3px solid rgba(255, 255, 255, 0.4);">
                        <span id="hubModalInitials">ST</span>
                    </div>
                    <div>
                        <h4 class="font-weight-bold mb-1" id="hubModalName">Student Name</h4>
                        <span class="text-xs opacity-75" id="hubModalEmail">student@mail.com</span>
                        <div class="mt-1">
                            <span class="badge badge-warning text-dark font-weight-bold mr-1" id="hubModalRoll">Roll: #0001</span>
                            <span class="badge badge-light mr-1" id="hubModalClass">Class</span>
                            <span class="badge badge-light" id="hubModalSection">Section</span>
                        </div>
                    </div>
                </div>
                <button type="button" class="close text-white opacity-75" data-dismiss="modal" aria-label="Close" style="outline: none;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal Body Details -->
            <div class="modal-body p-4">
                <div class="row">

                    <!-- Personal Information -->
                    <div class="col-md-6 mb-3">
                        <div class="card bg-light border-0 h-100" style="border-radius: 10px;">
                            <div class="card-body p-3">
                                <h6 class="font-weight-bold text-xs text-uppercase text-muted mb-3" style="letter-spacing: 0.8px;">
                                    <i class="fas fa-user mr-1 text-primary"></i> Personal Details
                                </h6>
                                <table class="table table-sm table-borderless mb-0" style="font-size: 13px;">
                                    <tr>
                                        <td class="text-muted" width="110">Gender</td>
                                        <td class="font-weight-bold" id="hubModalGender">-</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Birthday</td>
                                        <td class="font-weight-bold" id="hubModalDob">-</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Phone</td>
                                        <td class="font-weight-bold" id="hubModalPhone">-</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Address</td>
                                        <td class="font-weight-bold" id="hubModalAddress">-</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Guardian / Parent Info -->
                    <div class="col-md-6 mb-3">
                        <div class="card bg-light border-0 h-100" style="border-radius: 10px;">
                            <div class="card-body p-3">
                                <h6 class="font-weight-bold text-xs text-uppercase text-muted mb-3" style="letter-spacing: 0.8px;">
                                    <i class="fas fa-user-shield mr-1 text-info"></i> Guardian & Parent Info
                                </h6>
                                <table class="table table-sm table-borderless mb-0" style="font-size: 13px;">
                                    <tr>
                                        <td class="text-muted" width="110">Parent Name</td>
                                        <td class="font-weight-bold" id="hubModalParentName">-</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Parent Phone</td>
                                        <td class="font-weight-bold" id="hubModalParentPhone">-</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Parent Email</td>
                                        <td class="font-weight-bold" id="hubModalParentEmail">-</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Student ID</td>
                                        <td class="font-weight-bold text-primary" id="hubModalStudentId">-</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Footer Actions -->
            <div class="modal-footer border-top bg-light py-2 px-3 d-flex justify-content-between align-items-center">
                <div>
                    <a href="#" id="hubModalCallLink" class="btn btn-outline-secondary btn-sm mr-1" style="border-radius: 8px;">
                        <i class="fas fa-phone mr-1"></i> Call
                    </a>
                    <a href="#" id="hubModalMailLink" class="btn btn-outline-secondary btn-sm" style="border-radius: 8px;">
                        <i class="fas fa-envelope mr-1"></i> Email
                    </a>
                </div>
                <div>
                    <a href="#" id="hubModalRosterLink" class="btn btn-primary btn-sm px-3 mr-2" style="border-radius: 8px; display: none;">
                        <i class="fas fa-arrow-right mr-1"></i> Open Class Roster
                    </a>
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
        let activeTab = 'classes'; // 'classes' or 'directory'
        let currentSearchQuery = '';
        let classStatusFilter = 'all'; // 'all', 'active', 'empty'

        // 1. TAB SWITCHING HANDLER
        $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
            activeTab = (e.target.id === 'classes-tab') ? 'classes' : 'directory';
            const filterGroup = document.getElementById('classFilterGroup');
            if (filterGroup) {
                filterGroup.style.display = (activeTab === 'classes') ? 'inline-flex' : 'none';
            }
            applyFilters();
        });

        // 2. UNIFIED SEARCH INPUT
        const searchInput = document.getElementById('unifiedSearchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function () {
                currentSearchQuery = this.value.trim().toLowerCase();
                applyFilters();
            });
        }

        // 3. CLASS STATUS FILTER (ALL / ACTIVE / EMPTY)
        document.querySelectorAll('.class-filter-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.class-filter-btn').forEach(b => {
                    b.classList.remove('active', 'btn-primary');
                    b.classList.add('btn-outline-secondary');
                });
                this.classList.add('active', 'btn-primary');
                this.classList.remove('btn-outline-secondary');
                classStatusFilter = this.dataset.filter;
                applyFilters();
            });
        });

        // 4. FILTERING LOGIC
        function applyFilters() {
            const q = currentSearchQuery;

            if (activeTab === 'classes') {
                const classCols = document.querySelectorAll('.class-card-col');
                let matchCount = 0;

                classCols.forEach(col => {
                    const hasStudents = col.dataset.hasStudents === 'true';
                    let matchesStatus = true;
                    if (classStatusFilter === 'active') matchesStatus = hasStudents;
                    if (classStatusFilter === 'empty') matchesStatus = !hasStudents;

                    if (!matchesStatus) {
                        col.style.display = 'none';
                        return;
                    }

                    if (!q) {
                        col.style.display = '';
                        matchCount++;
                        return;
                    }

                    const name = col.dataset.name || '';
                    const code = col.dataset.code || '';
                    const room = col.dataset.room || '';
                    const teacher = col.dataset.teacher || '';

                    const matches = name.includes(q) || code.includes(q) || room.includes(q) || teacher.includes(q);
                    col.style.display = matches ? '' : 'none';
                    if (matches) matchCount++;
                });

                const noMatch = document.getElementById('noClassMatch');
                if (noMatch) {
                    noMatch.style.display = (matchCount === 0 && classCols.length > 0) ? 'block' : 'none';
                }

            } else {
                // Directory Filter
                const rows = document.querySelectorAll('.global-student-row');
                let matchCount = 0;

                rows.forEach(r => {
                    if (!q) {
                        r.style.display = '';
                        matchCount++;
                        return;
                    }

                    const name = r.dataset.name || '';
                    const email = r.dataset.email || '';
                    const phone = r.dataset.phone || '';
                    const className = r.dataset.class || '';
                    const sectionName = r.dataset.section || '';
                    const roll = r.dataset.roll || '';
                    const parent = r.dataset.parent || '';

                    const matches = name.includes(q) || email.includes(q) || phone.includes(q) ||
                                    className.includes(q) || sectionName.includes(q) ||
                                    roll.includes(q) || parent.includes(q);

                    r.style.display = matches ? '' : 'none';
                    if (matches) matchCount++;
                });

                const noDirMatch = document.getElementById('noDirectoryMatch');
                if (noDirMatch) {
                    noDirMatch.style.display = (matchCount === 0 && rows.length > 0) ? 'block' : 'none';
                }
            }
        }

        // Reset Filter Buttons
        document.getElementById('resetClassFilterBtn')?.addEventListener('click', function () {
            if (searchInput) searchInput.value = '';
            currentSearchQuery = '';
            document.querySelector('.class-filter-btn[data-filter="all"]')?.click();
        });

        document.getElementById('resetDirectoryFilterBtn')?.addEventListener('click', function () {
            if (searchInput) searchInput.value = '';
            currentSearchQuery = '';
            applyFilters();
        });

        window.filterUnassigned = function () {
            $('#directory-tab').tab('show');
            const rows = document.querySelectorAll('.global-student-row');
            rows.forEach(r => {
                const isEnrolled = r.dataset.isEnrolled === 'true';
                r.style.display = (!isEnrolled) ? '' : 'none';
            });
        };

        // 5. STUDENT PROFILE MODAL IN HUB
        document.querySelectorAll('.view-hub-profile-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                const raw = this.dataset.student;
                if (!raw) return;
                const s = JSON.parse(raw);

                const initials = (s.name || 'ST').substring(0, 2).toUpperCase();
                document.getElementById('hubModalInitials').textContent = initials;
                document.getElementById('hubModalName').textContent = s.name || 'N/A';
                document.getElementById('hubModalEmail').textContent = s.email || 'N/A';
                document.getElementById('hubModalRoll').textContent = s.roll ? `Roll: #${s.roll}` : 'No Roll Assigned';
                document.getElementById('hubModalClass').textContent = s.class_name ? `Class: ${s.class_name}` : 'Unassigned Class';
                document.getElementById('hubModalSection').textContent = s.section_name ? `Section: ${s.section_name}` : 'No Section';

                document.getElementById('hubModalGender').textContent = (s.sex == 0 ? 'Male' : 'Female');
                document.getElementById('hubModalDob').textContent = s.birthday || 'N/A';
                document.getElementById('hubModalPhone').textContent = s.phone || 'N/A';
                document.getElementById('hubModalAddress').textContent = s.address || 'N/A';

                document.getElementById('hubModalParentName').textContent = s.parent_name || 'N/A';
                document.getElementById('hubModalParentPhone').textContent = s.parent_phone || 'N/A';
                document.getElementById('hubModalParentEmail').textContent = s.parent_email || 'N/A';
                document.getElementById('hubModalStudentId').textContent = `#${s.student_id}`;

                // Action Links
                const callBtn = document.getElementById('hubModalCallLink');
                if (callBtn) {
                    callBtn.href = s.phone ? `tel:${s.phone}` : '#';
                    callBtn.style.display = s.phone ? 'inline-block' : 'none';
                }

                const mailBtn = document.getElementById('hubModalMailLink');
                if (mailBtn) {
                    mailBtn.href = s.email ? `mailto:${s.email}` : '#';
                    mailBtn.style.display = s.email ? 'inline-block' : 'none';
                }

                const rosterBtn = document.getElementById('hubModalRosterLink');
                if (rosterBtn) {
                    if (s.class_id) {
                        rosterBtn.href = `/students/class/${s.class_id}`;
                        rosterBtn.style.display = 'inline-block';
                    } else {
                        rosterBtn.style.display = 'none';
                    }
                }

                $('#hubStudentProfileModal').modal('show');
            });
        });

    });
</script>
@endpush
@endsection
