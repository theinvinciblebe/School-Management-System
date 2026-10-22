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
    .student-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 15px;
        color: #fff;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        box-shadow: 0 3px 8px rgba(99, 102, 241, 0.35);
        flex-shrink: 0;
        overflow: hidden;
        border: 2px solid rgba(255, 255, 255, 0.2);
    }
    .student-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .student-card {
        border-radius: 14px;
        transition: all 0.25s ease;
        border: 1px solid rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }
    .student-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12) !important;
        border-color: rgba(99, 102, 241, 0.3);
    }
    .student-table th {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        font-weight: 700;
        border-top: none;
        color: #64748b;
    }
    .student-table td {
        vertical-align: middle;
        padding: 0.9rem 0.75rem;
    }
    .roll-pill {
        font-family: monospace;
        font-size: 12px;
        letter-spacing: 0.5px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 20px;
    }
    .dark-mode .student-table th {
        color: #94a3b8;
    }
    .dark-mode .student-card {
        background-color: #1e293b;
        border-color: rgba(255, 255, 255, 0.08);
    }
    .dark-mode .student-card:hover {
        border-color: rgba(99, 102, 241, 0.5);
    }
    .profile-hero-banner {
        background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
        color: #fff;
        padding: 1.75rem 1.5rem;
        position: relative;
    }
    .modal-hero {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        color: #fff;
        padding: 1.25rem 1.5rem;
    }
</style>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-3 align-items-center">
            <div class="col-sm-7">
                <div class="d-flex align-items-center flex-wrap">
                    <h1 class="m-0 font-weight-bold mr-3">
                        <i class="fas fa-user-graduate text-purple mr-2" style="color: #8b5cf6;"></i>{{ $class->name }}
                    </h1>
                    <!-- Class Hub Back & Class Switcher Dropdown -->
                    <a href="{{ route('students.info') }}" class="btn btn-outline-secondary btn-sm shadow-sm mr-2" style="border-radius: 20px;" title="Back to Student Information Hub">
                        <i class="fas fa-arrow-left mr-1"></i> All Classes
                    </a>
                    <div class="dropdown d-inline-block">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle shadow-sm" type="button" id="classSwitchDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius: 20px;">
                            <i class="fas fa-exchange-alt mr-1"></i> Switch Class
                        </button>
                        <div class="dropdown-menu shadow-lg" aria-labelledby="classSwitchDropdown" style="border-radius: 12px; max-height: 280px; overflow-y: auto;">
                            <h6 class="dropdown-header text-uppercase text-xs">Select Class Roster</h6>
                            @foreach($allClasses as $c)
                                <a class="dropdown-item d-flex justify-content-between align-items-center {{ $c->class_id == $class->class_id ? 'active font-weight-bold' : '' }}" href="{{ route('students.byClass', $c->class_id) }}">
                                    <span>{{ $c->name }}</span>
                                    @if($c->class_id == $class->class_id)
                                        <i class="fas fa-check text-xs ml-2"></i>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <p class="text-muted text-sm mb-0 mt-1">
                    <span class="mr-3"><i class="fas fa-barcode text-xs mr-1"></i> Code: <b>{{ $class->class_code ?? 'N/A' }}</b></span>
                    <span class="mr-3"><i class="fas fa-door-open text-xs mr-1"></i> Room: <b>{{ $class->class_room ?? 'N/A' }}</b></span>
                    <span><i class="fas fa-chalkboard-teacher text-xs mr-1"></i> Teacher: <b>{{ $class->teacher_name ?? 'Not Assigned' }}</b></span>
                </p>
            </div>
            <div class="col-sm-5 text-sm-right mt-3 mt-sm-0">
                @if (Auth::user()->role == 0)
                    <button type="button" class="btn btn-primary btn-sm px-3 shadow-sm mr-2" data-toggle="modal" data-target="#addStudentModal" style="border-radius: 20px;">
                        <i class="fas fa-plus-circle mr-1"></i> Add Student
                    </button>
                @endif
                <a href="{{ route('attendance.show', $class->class_id) }}" class="btn btn-outline-info btn-sm px-3 shadow-sm mr-2" style="border-radius: 20px;" title="Take or View Class Attendance">
                    <i class="fas fa-calendar-check mr-1"></i> Attendance
                </a>
                <ol class="breadcrumb float-sm-right bg-transparent p-0 d-inline-block align-middle mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('students.info') }}">Student Information</a></li>
                    <li class="breadcrumb-item active">{{ $class->name }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        <!-- Top Metrics KPI Cards -->
        @php
            $totalStudents = $students->count();
            $maleCount = $students->where('sex', 0)->count();
            $femaleCount = $students->where('sex', 1)->count();
            $totalSections = $sections->count();
        @endphp

        <div class="row mb-4">
            <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
                <div class="card metric-card shadow-sm border-0 bg-gradient-primary text-white h-100">
                    <div class="card-body p-3">
                        <span class="text-uppercase text-xs font-weight-bold" style="letter-spacing: 0.5px;">Enrolled Students</span>
                        <h2 class="font-weight-bold mt-1 mb-0">{{ number_format($totalStudents) }}</h2>
                        <span class="text-xs opacity-75">Active in {{ $class->name }}</span>
                        <i class="fas fa-user-graduate icon-bg text-white"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
                <div class="card metric-card shadow-sm border-0 bg-gradient-info text-white h-100">
                    <div class="card-body p-3">
                        <span class="text-uppercase text-xs font-weight-bold" style="letter-spacing: 0.5px;">Active Sections</span>
                        <h2 class="font-weight-bold mt-1 mb-0">{{ number_format($totalSections) }}</h2>
                        <span class="text-xs opacity-75">
                            @foreach($sections->take(2) as $s)
                                <span class="badge badge-light text-dark py-0 px-1 text-xs">{{ $s->name }}</span>
                            @endforeach
                            @if($totalSections > 2) +{{ $totalSections - 2 }} @endif
                        </span>
                        <i class="fas fa-cubes icon-bg text-white"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
                <div class="card metric-card shadow-sm border-0 bg-gradient-success text-white h-100">
                    <div class="card-body p-3">
                        <span class="text-uppercase text-xs font-weight-bold" style="letter-spacing: 0.5px;">Gender Breakdown</span>
                        <h2 class="font-weight-bold mt-1 mb-0">
                            {{ $maleCount }} <span class="text-xs opacity-75 font-weight-normal">M</span> /
                            {{ $femaleCount }} <span class="text-xs opacity-75 font-weight-normal">F</span>
                        </h2>
                        <span class="text-xs opacity-75">
                            <i class="fas fa-mars mr-1"></i>{{ $totalStudents > 0 ? round(($maleCount/$totalStudents)*100) : 0 }}% Male
                            &bull;
                            <i class="fas fa-venus mr-1"></i>{{ $totalStudents > 0 ? round(($femaleCount/$totalStudents)*100) : 0 }}% Female
                        </span>
                        <i class="fas fa-restroom icon-bg text-white"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card metric-card shadow-sm border-0 bg-gradient-warning text-white h-100">
                    <div class="card-body p-3">
                        <span class="text-uppercase text-xs font-weight-bold" style="letter-spacing: 0.5px;">Class Incharge</span>
                        <h4 class="font-weight-bold mt-1 mb-0 text-truncate" title="{{ $class->teacher_name ?? 'Not Assigned' }}">
                            {{ $class->teacher_name ?? 'Not Assigned' }}
                        </h4>
                        <span class="text-xs opacity-75"><i class="fas fa-map-marker-alt mr-1"></i>Room {{ $class->class_room ?? 'TBD' }}</span>
                        <i class="fas fa-id-badge icon-bg text-white"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Card Container -->
        <div class="card shadow-sm border-0" style="border-radius: 14px; overflow: hidden;">

            <!-- Controls: Section Filter Pills, Search Bar, View Mode Toggle -->
            <div class="card-header border-bottom py-3 px-3">
                <div class="row align-items-center">

                    <!-- Section Filters -->
                    <div class="col-lg-6 col-md-12 mb-2 mb-lg-0">
                        <div class="d-flex align-items-center flex-wrap">
                            <span class="text-xs font-weight-bold text-muted text-uppercase mr-2">Section:</span>
                            <div class="btn-group btn-group-sm flex-wrap" role="group" id="sectionFilterGroup">
                                <button type="button" class="btn btn-primary active section-filter-btn" data-section="all" style="border-radius: 20px 0 0 20px;">
                                    All <span class="badge badge-light ml-1">{{ $totalStudents }}</span>
                                </button>
                                @foreach($sections as $index => $sec)
                                    @php
                                        $secCount = $students->where('section_id', $sec->section_id)->count();
                                        $isLast = ($index === $sections->count() - 1);
                                    @endphp
                                    <button type="button" class="btn btn-outline-secondary section-filter-btn"
                                            data-section="{{ $sec->section_id }}"
                                            style="{{ $isLast ? 'border-radius: 0 20px 20px 0;' : '' }}">
                                        {{ $sec->name }} <span class="badge badge-secondary ml-1">{{ $secCount }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Search & View Mode Switcher -->
                    <div class="col-lg-6 col-md-12 d-flex justify-content-lg-end align-items-center flex-wrap">
                        <!-- Live Search -->
                        <div class="input-group input-group-sm mr-2 mb-2 mb-sm-0" style="max-width: 260px;">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-transparent border-right-0" style="border-radius: 20px 0 0 20px;">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                            </div>
                            <input type="text" id="studentSearchInput" class="form-control border-left-0" placeholder="Search name, roll, parent..." style="border-radius: 0 20px 20px 0;">
                        </div>

                        <!-- View Toggle -->
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-outline-secondary active" id="viewTableBtn" title="Table View">
                                <i class="fas fa-list"></i>
                            </button>
                            <button type="button" class="btn btn-outline-secondary" id="viewGridBtn" title="Cards Grid View">
                                <i class="fas fa-th-large"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Body: Table and Cards -->
            <div class="card-body p-0">

                @if($students->isEmpty())
                    <!-- Empty State -->
                    <div class="text-center py-5 px-3">
                        <div class="mb-3">
                            <span class="btn btn-light btn-circle p-3" style="width: 70px; height: 70px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; background: rgba(99, 102, 241, 0.1);">
                                <i class="fas fa-user-graduate fa-3x text-primary opacity-50"></i>
                            </span>
                        </div>
                        <h5 class="font-weight-bold mb-1">No students enrolled yet</h5>
                        <p class="text-muted text-sm mb-3">
                            There are currently no students assigned to <b>{{ $class->name }}</b>.
                        </p>
                        @if (Auth::user()->role == 0)
                            <button type="button" class="btn btn-primary btn-sm px-3 shadow-sm" data-toggle="modal" data-target="#addStudentModal" style="border-radius: 20px;">
                                <i class="fas fa-plus-circle mr-1"></i> Enroll First Student
                            </button>
                        @endif
                    </div>
                @else

                    <!-- 1. TABLE VIEW -->
                    <div id="tableViewContainer" class="table-responsive">
                        <table class="table table-hover student-table mb-0" id="studentsTable">
                            <thead>
                                <tr class="bg-light">
                                    <th style="width: 50px;">#</th>
                                    <th>Student</th>
                                    <th>Roll Number</th>
                                    <th>Section</th>
                                    <th>Gender & Age</th>
                                    <th>Parent / Guardian</th>
                                    <th>Contact</th>
                                    <th class="text-right" style="width: 140px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $index => $student)
                                    @php
                                        $initials = strtoupper(substr($student->name ?? 'ST', 0, 2));
                                        $avatarColor = match($index % 5) {
                                            0 => 'linear-gradient(135deg, #6366f1, #8b5cf6)',
                                            1 => 'linear-gradient(135deg, #3b82f6, #06b6d4)',
                                            2 => 'linear-gradient(135deg, #10b981, #059669)',
                                            3 => 'linear-gradient(135deg, #f59e0b, #d97706)',
                                            default => 'linear-gradient(135deg, #ec4899, #8b5cf6)',
                                        };
                                        $hasPhoto = (!empty($student->photo) && $student->photo !== 'noimg.jpg');
                                        $photoUrl = asset('students_image/' . ($student->photo ?? 'noimg.jpg'));
                                        $genderText = ($student->sex == 0) ? 'Male' : 'Female';
                                        $genderBadge = ($student->sex == 0) ? 'badge-primary' : 'badge-danger';
                                        $genderIcon = ($student->sex == 0) ? 'fa-mars' : 'fa-venus';
                                        $age = $student->birthday ? \Carbon\Carbon::parse($student->birthday)->age : null;
                                    @endphp

                                    <tr class="student-row"
                                        data-section="{{ $student->section_id }}"
                                        data-name="{{ strtolower($student->name) }}"
                                        data-roll="{{ strtolower($student->roll) }}"
                                        data-parent="{{ strtolower($student->parent_name ?? '') }}"
                                        data-email="{{ strtolower($student->email ?? '') }}"
                                        data-phone="{{ strtolower($student->phone ?? '') }}">

                                        <!-- Index -->
                                        <td class="text-muted font-weight-bold">{{ $index + 1 }}</td>

                                        <!-- Student Profile -->
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="student-avatar mr-2" style="background: {{ $avatarColor }};">
                                                    @if($hasPhoto)
                                                        <img src="{{ $photoUrl }}" alt="{{ $student->name }}" onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';">
                                                        <span style="display: none;">{{ $initials }}</span>
                                                    @else
                                                        <span>{{ $initials }}</span>
                                                    @endif
                                                </div>
                                                <div>
                                                    <a href="javascript:void(0)" class="font-weight-bold text-dark view-profile-btn" data-student='@json($student)'>
                                                        {{ $student->name }}
                                                    </a>
                                                    <div>
                                                        <span class="badge badge-light border text-muted py-0 px-1" style="font-size: 10.5px;">
                                                            ID: #{{ $student->student_id }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Roll Number -->
                                        <td>
                                            <span class="badge badge-primary roll-pill shadow-sm">
                                                #{{ $student->roll }}
                                            </span>
                                        </td>

                                        <!-- Section -->
                                        <td>
                                            <span class="badge badge-info px-2 py-1" style="border-radius: 8px;">
                                                <i class="fas fa-layer-group text-xs mr-1"></i> {{ $student->section_name ?? 'N/A' }}
                                            </span>
                                        </td>

                                        <!-- Gender & Birthday -->
                                        <td>
                                            <span class="badge {{ $genderBadge }} px-2 py-1 mr-1" style="border-radius: 10px;">
                                                <i class="fas {{ $genderIcon }} mr-1"></i> {{ $genderText }}
                                            </span>
                                            @if($age)
                                                <span class="text-xs text-muted">({{ $age }} yrs)</span>
                                            @endif
                                        </td>

                                        <!-- Parent / Guardian -->
                                        <td>
                                            @if(!empty($student->parent_name))
                                                <div class="font-weight-bold text-dark" style="font-size: 13.5px;">{{ $student->parent_name }}</div>
                                                <span class="text-xs text-muted">{{ $student->parent_phone ?? 'Guardian' }}</span>
                                            @else
                                                <span class="text-muted text-xs font-italic">No guardian linked</span>
                                            @endif
                                        </td>

                                        <!-- Contact -->
                                        <td>
                                            <div class="text-truncate" style="max-width: 170px;" title="{{ $student->email }}">
                                                <i class="far fa-envelope text-xs text-muted mr-1"></i> {{ $student->email }}
                                            </div>
                                            <span class="text-xs text-muted">
                                                <i class="fas fa-phone text-xs mr-1"></i> {{ $student->phone }}
                                            </span>
                                        </td>

                                        <!-- Actions -->
                                        <td class="text-right">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-xs btn-outline-primary view-profile-btn mr-1 shadow-sm"
                                                        data-student='@json($student)' title="View Student Profile">
                                                    <i class="fas fa-id-card"></i>
                                                </button>

                                                @if (Auth::user()->role == 0)
                                                    <button type="button" class="btn btn-xs btn-outline-info edit-student-btn mr-1 shadow-sm"
                                                            data-student-id="{{ $student->student_id }}"
                                                            data-name="{{ $student->name }}"
                                                            data-section-id="{{ $student->section_id }}"
                                                            data-roll="{{ $student->roll }}"
                                                            title="Edit Class Assignment">
                                                        <i class="fas fa-edit"></i>
                                                    </button>

                                                    <button type="button" class="btn btn-xs btn-outline-danger remove-student-btn shadow-sm"
                                                            data-student-id="{{ $student->student_id }}"
                                                            data-name="{{ $student->name }}"
                                                            title="Remove from Class">
                                                        <i class="fas fa-user-minus"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- 2. GRID CARDS VIEW (HIDDEN BY DEFAULT) -->
                    <div id="gridViewContainer" class="p-3" style="display: none;">
                        <div class="row">
                            @foreach($students as $index => $student)
                                @php
                                    $initials = strtoupper(substr($student->name ?? 'ST', 0, 2));
                                    $avatarColor = match($index % 5) {
                                        0 => 'linear-gradient(135deg, #6366f1, #8b5cf6)',
                                        1 => 'linear-gradient(135deg, #3b82f6, #06b6d4)',
                                        2 => 'linear-gradient(135deg, #10b981, #059669)',
                                        3 => 'linear-gradient(135deg, #f59e0b, #d97706)',
                                        default => 'linear-gradient(135deg, #ec4899, #8b5cf6)',
                                    };
                                    $hasPhoto = (!empty($student->photo) && $student->photo !== 'noimg.jpg');
                                    $photoUrl = asset('students_image/' . ($student->photo ?? 'noimg.jpg'));
                                    $genderText = ($student->sex == 0) ? 'Male' : 'Female';
                                    $genderBadge = ($student->sex == 0) ? 'badge-primary' : 'badge-danger';
                                    $genderIcon = ($student->sex == 0) ? 'fa-mars' : 'fa-venus';
                                @endphp

                                <div class="col-xl-3 col-lg-4 col-md-6 mb-3 student-card-col"
                                     data-section="{{ $student->section_id }}"
                                     data-name="{{ strtolower($student->name) }}"
                                     data-roll="{{ strtolower($student->roll) }}"
                                     data-parent="{{ strtolower($student->parent_name ?? '') }}"
                                     data-email="{{ strtolower($student->email ?? '') }}"
                                     data-phone="{{ strtolower($student->phone ?? '') }}">

                                    <div class="card student-card shadow-sm h-100">
                                        <!-- Top Accent Header -->
                                        <div class="p-3 pb-0 d-flex justify-content-between align-items-start">
                                            <span class="badge badge-info px-2 py-1 text-xs" style="border-radius: 8px;">
                                                <i class="fas fa-layer-group mr-1"></i> {{ $student->section_name ?? 'N/A' }}
                                            </span>
                                            <span class="badge badge-primary roll-pill shadow-sm">
                                                #{{ $student->roll }}
                                            </span>
                                        </div>

                                        <!-- Card Body -->
                                        <div class="card-body p-3 text-center">
                                            <div class="student-avatar mx-auto mb-2" style="width: 58px; height: 58px; font-size: 20px; background: {{ $avatarColor }};">
                                                @if($hasPhoto)
                                                    <img src="{{ $photoUrl }}" alt="{{ $student->name }}" onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';">
                                                    <span style="display: none;">{{ $initials }}</span>
                                                @else
                                                    <span>{{ $initials }}</span>
                                                @endif
                                            </div>

                                            <h6 class="font-weight-bold mb-1 text-truncate" title="{{ $student->name }}">
                                                <a href="javascript:void(0)" class="text-dark view-profile-btn" data-student='@json($student)'>
                                                    {{ $student->name }}
                                                </a>
                                            </h6>
                                            <span class="text-xs text-muted d-block text-truncate mb-2" title="{{ $student->email }}">
                                                {{ $student->email }}
                                            </span>

                                            <div class="d-flex justify-content-center align-items-center mb-3">
                                                <span class="badge {{ $genderBadge }} px-2 py-1 mr-2" style="border-radius: 10px; font-size: 11px;">
                                                    <i class="fas {{ $genderIcon }} mr-1"></i> {{ $genderText }}
                                                </span>
                                                <span class="text-xs text-muted">ID: #{{ $student->student_id }}</span>
                                            </div>

                                            <div class="text-left bg-light p-2 rounded mb-3" style="font-size: 12px; border-radius: 8px;">
                                                <div class="d-flex justify-content-between text-truncate mb-1">
                                                    <span class="text-muted"><i class="fas fa-user-shield mr-1"></i> Guardian:</span>
                                                    <span class="font-weight-bold text-dark text-truncate ml-1" title="{{ $student->parent_name ?? 'N/A' }}">{{ $student->parent_name ?? 'N/A' }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between text-truncate">
                                                    <span class="text-muted"><i class="fas fa-phone mr-1"></i> Phone:</span>
                                                    <span class="font-weight-500 text-dark ml-1">{{ $student->phone ?? 'N/A' }}</span>
                                                </div>
                                            </div>

                                            <!-- Bottom Actions -->
                                            <div class="d-flex justify-content-between align-items-center border-top pt-2">
                                                <button type="button" class="btn btn-xs btn-outline-primary view-profile-btn flex-grow-1 mr-1"
                                                        data-student='@json($student)' style="border-radius: 6px;">
                                                    <i class="fas fa-id-card mr-1"></i> Profile
                                                </button>

                                                @if (Auth::user()->role == 0)
                                                    <button type="button" class="btn btn-xs btn-outline-info edit-student-btn mr-1"
                                                            data-student-id="{{ $student->student_id }}"
                                                            data-name="{{ $student->name }}"
                                                            data-section-id="{{ $student->section_id }}"
                                                            data-roll="{{ $student->roll }}"
                                                            style="border-radius: 6px;">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-xs btn-outline-danger remove-student-btn"
                                                            data-student-id="{{ $student->student_id }}"
                                                            data-name="{{ $student->name }}"
                                                            style="border-radius: 6px;">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- No Results Match State (for search/filtering) -->
                    <div id="noMatchState" class="text-center py-5 px-3" style="display: none;">
                        <i class="fas fa-search fa-3x text-muted opacity-50 mb-2"></i>
                        <h6 class="font-weight-bold">No students match your filter</h6>
                        <p class="text-muted text-sm">Try adjusting your section tab or search term.</p>
                        <button type="button" class="btn btn-xs btn-outline-primary" id="resetFiltersBtn">Reset Filters</button>
                    </div>

                @endif

            </div>

            <!-- Footer: Showing count -->
            <div class="card-footer border-top py-2 px-3 bg-light d-flex justify-content-between align-items-center">
                <span class="text-xs text-muted">
                    Total: <b id="visibleCount">{{ $totalStudents }}</b> student(s) in <b>{{ $class->name }}</b>
                </span>
                <span class="text-xs text-muted">
                    Updated {{ now()->format('M d, Y') }}
                </span>
            </div>

        </div>

    </div>
</section>

<!-- ======================================================== -->
<!-- MODAL 1: VIEW STUDENT FULL PROFILE DRAWER/MODAL -->
<!-- ======================================================== -->
<div class="modal fade" id="studentProfileModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px; overflow: hidden;">

            <!-- Hero Header -->
            <div class="profile-hero-banner d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="student-avatar mr-3" id="profileModalAvatar" style="width: 65px; height: 65px; font-size: 24px; border: 3px solid rgba(255, 255, 255, 0.4);">
                        <span id="profileModalInitials">ST</span>
                    </div>
                    <div>
                        <h4 class="font-weight-bold mb-1" id="profileModalName">Student Name</h4>
                        <span class="text-xs opacity-75" id="profileModalEmail">student@mail.com</span>
                        <div class="mt-1">
                            <span class="badge badge-warning text-dark font-weight-bold mr-1" id="profileModalRoll">Roll: #0001</span>
                            <span class="badge badge-light" id="profileModalClass">{{ $class->name }}</span>
                            <span class="badge badge-light" id="profileModalSection">Section</span>
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
                                        <td class="font-weight-bold" id="profileModalGender">-</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Birthday</td>
                                        <td class="font-weight-bold" id="profileModalDob">-</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Phone</td>
                                        <td class="font-weight-bold" id="profileModalPhone">-</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Address</td>
                                        <td class="font-weight-bold" id="profileModalAddress">-</td>
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
                                        <td class="font-weight-bold" id="profileModalParentName">-</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Parent Phone</td>
                                        <td class="font-weight-bold" id="profileModalParentPhone">-</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Parent Email</td>
                                        <td class="font-weight-bold" id="profileModalParentEmail">-</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Student ID</td>
                                        <td class="font-weight-bold text-primary" id="profileModalStudentId">-</td>
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
                    <a href="#" id="profileModalCallLink" class="btn btn-outline-secondary btn-sm mr-1" style="border-radius: 8px;">
                        <i class="fas fa-phone mr-1"></i> Call Student
                    </a>
                    <a href="#" id="profileModalMailLink" class="btn btn-outline-secondary btn-sm" style="border-radius: 8px;">
                        <i class="fas fa-envelope mr-1"></i> Email
                    </a>
                </div>
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" style="border-radius: 8px;">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL 2: EDIT STUDENT CLASS ASSIGNMENT -->
<!-- ======================================================== -->
@if (Auth::user()->role == 0)
<div class="modal fade" id="editAssignmentModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px; overflow: hidden;">
            <form id="editAssignmentForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="modal-hero d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="modal-title font-weight-bold mb-1">
                            <i class="fas fa-user-edit mr-2 text-info"></i> Edit Class Assignment
                        </h5>
                        <span class="text-xs opacity-75" id="editModalSubtitle">Update section or roll number</span>
                    </div>
                    <button type="button" class="close text-white opacity-75" data-dismiss="modal" aria-label="Close" style="outline: none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label class="text-xs font-weight-bold text-uppercase text-muted">Student Name</label>
                        <input type="text" id="editModalStudentName" class="form-control" readonly style="border-radius: 8px;">
                    </div>
                    <div class="form-group mb-3">
                        <label class="text-xs font-weight-bold text-uppercase text-muted">Section</label>
                        <select name="section_id" id="editModalSectionSelect" class="form-control" required style="border-radius: 8px;">
                            @foreach($sections as $sec)
                                <option value="{{ $sec->section_id }}">{{ $sec->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <label class="text-xs font-weight-bold text-uppercase text-muted">Roll Number</label>
                        <input type="text" name="roll" id="editModalRollInput" class="form-control" required placeholder="e.g. 0001" style="border-radius: 8px;">
                    </div>
                </div>
                <div class="modal-footer border-top bg-light py-2 px-3 d-flex justify-content-between">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm px-3" style="border-radius: 8px;">
                        <i class="fas fa-save mr-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL 3: ADD STUDENT TO CLASS -->
<!-- ======================================================== -->
<div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px; overflow: hidden;">
            <form action="{{ route('students.add_to_class') }}" method="POST">
                @csrf
                <input type="hidden" name="class_id" value="{{ $class->class_id }}">

                <div class="modal-hero d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="modal-title font-weight-bold mb-1">
                            <i class="fas fa-user-plus mr-2 text-success"></i> Add Student to Class
                        </h5>
                        <span class="text-xs opacity-75">Assign an existing student to {{ $class->name }}</span>
                    </div>
                    <button type="button" class="close text-white opacity-75" data-dismiss="modal" aria-label="Close" style="outline: none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body p-4">
                    @if($availableStudents->isEmpty())
                        <div class="alert alert-info mb-0 text-sm" style="border-radius: 8px;">
                            <i class="fas fa-info-circle mr-1"></i> All registered students are already enrolled in this class!
                        </div>
                    @else
                        <div class="form-group mb-3">
                            <label class="text-xs font-weight-bold text-uppercase text-muted">Select Student</label>
                            <select name="student_id" class="form-control" required style="border-radius: 8px;">
                                <option value="" disabled selected>-- Choose Student --</option>
                                @foreach($availableStudents as $avail)
                                    <option value="{{ $avail->student_id }}">
                                        {{ $avail->name }} ({{ $avail->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="text-xs font-weight-bold text-uppercase text-muted">Assign Section</label>
                            <select name="section_id" class="form-control" required style="border-radius: 8px;">
                                @foreach($sections as $sec)
                                    <option value="{{ $sec->section_id }}">{{ $sec->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-0">
                            <label class="text-xs font-weight-bold text-uppercase text-muted">Roll Number</label>
                            <input type="text" name="roll" class="form-control" value="{{ $suggestedRoll }}" required placeholder="e.g. 0002" style="border-radius: 8px;">
                            <small class="text-muted">Auto-suggested based on current max roll number.</small>
                        </div>
                    @endif
                </div>

                <div class="modal-footer border-top bg-light py-2 px-3 d-flex justify-content-between">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                    @if(!$availableStudents->isEmpty())
                        <button type="submit" class="btn btn-success btn-sm px-3" style="border-radius: 8px;">
                            <i class="fas fa-check mr-1"></i> Enroll Student
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Hidden Delete Form for SweetAlert -->
<form id="removeStudentForm" method="POST" action="" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endif

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const classId = {{ $class->class_id }};
        let activeSection = 'all';
        let currentSearchQuery = '';

        // 1. FILTERING ENGINE (SECTION & SEARCH)
        function applyFilters() {
            const rows = document.querySelectorAll('.student-row');
            const cards = document.querySelectorAll('.student-card-col');
            let visibleCount = 0;

            const q = currentSearchQuery.trim().toLowerCase();

            function checkMatch(elem) {
                const section = elem.dataset.section;
                const matchesSection = (activeSection === 'all' || section === activeSection);
                if (!matchesSection) return false;

                if (!q) return true;

                const name = elem.dataset.name || '';
                const roll = elem.dataset.roll || '';
                const parent = elem.dataset.parent || '';
                const email = elem.dataset.email || '';
                const phone = elem.dataset.phone || '';

                return name.includes(q) || roll.includes(q) || parent.includes(q) || email.includes(q) || phone.includes(q);
            }

            rows.forEach(r => {
                const matches = checkMatch(r);
                r.style.display = matches ? '' : 'none';
                if (matches) visibleCount++;
            });

            cards.forEach(c => {
                const matches = checkMatch(c);
                c.style.display = matches ? '' : 'none';
            });

            document.getElementById('visibleCount').textContent = visibleCount;

            const noMatch = document.getElementById('noMatchState');
            if (noMatch) {
                noMatch.style.display = (visibleCount === 0 && (rows.length > 0)) ? 'block' : 'none';
            }
        }

        // Section Tabs Click
        document.querySelectorAll('.section-filter-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.section-filter-btn').forEach(b => {
                    b.classList.remove('active', 'btn-primary');
                    b.classList.add('btn-outline-secondary');
                });
                this.classList.add('active', 'btn-primary');
                this.classList.remove('btn-outline-secondary');

                activeSection = this.dataset.section;
                applyFilters();
            });
        });

        // Live Search Input
        const searchInput = document.getElementById('studentSearchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function () {
                currentSearchQuery = this.value;
                applyFilters();
            });
        }

        // Reset Filters Button
        document.getElementById('resetFiltersBtn')?.addEventListener('click', function () {
            activeSection = 'all';
            currentSearchQuery = '';
            if (searchInput) searchInput.value = '';
            document.querySelector('.section-filter-btn[data-section="all"]')?.click();
        });

        // 2. VIEW TOGGLE: TABLE VS GRID
        const viewTableBtn = document.getElementById('viewTableBtn');
        const viewGridBtn = document.getElementById('viewGridBtn');
        const tableContainer = document.getElementById('tableViewContainer');
        const gridContainer = document.getElementById('gridViewContainer');

        function setView(mode) {
            if (mode === 'grid') {
                tableContainer.style.display = 'none';
                gridContainer.style.display = 'block';
                viewGridBtn.classList.add('active', 'btn-primary');
                viewGridBtn.classList.remove('btn-outline-secondary');
                viewTableBtn.classList.remove('active', 'btn-primary');
                viewTableBtn.classList.add('btn-outline-secondary');
                localStorage.setItem('student_view_mode', 'grid');
            } else {
                tableContainer.style.display = 'block';
                gridContainer.style.display = 'none';
                viewTableBtn.classList.add('active', 'btn-primary');
                viewTableBtn.classList.remove('btn-outline-secondary');
                viewGridBtn.classList.remove('active', 'btn-primary');
                viewGridBtn.classList.add('btn-outline-secondary');
                localStorage.setItem('student_view_mode', 'table');
            }
        }

        viewTableBtn?.addEventListener('click', () => setView('table'));
        viewGridBtn?.addEventListener('click', () => setView('grid'));

        const savedMode = localStorage.getItem('student_view_mode');
        if (savedMode) setView(savedMode);

        // 3. STUDENT PROFILE MODAL POPULATOR
        document.querySelectorAll('.view-profile-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                const raw = this.dataset.student;
                if (!raw) return;
                const s = JSON.parse(raw);

                const initials = (s.name || 'ST').substring(0, 2).toUpperCase();
                document.getElementById('profileModalInitials').textContent = initials;
                document.getElementById('profileModalName').textContent = s.name || 'N/A';
                document.getElementById('profileModalEmail').textContent = s.email || 'N/A';
                document.getElementById('profileModalRoll').textContent = `Roll: #${s.roll || 'N/A'}`;
                document.getElementById('profileModalSection').textContent = s.section_name || 'N/A';

                document.getElementById('profileModalGender').textContent = (s.sex == 0 ? 'Male' : 'Female');
                document.getElementById('profileModalDob').textContent = s.birthday || 'N/A';
                document.getElementById('profileModalPhone').textContent = s.phone || 'N/A';
                document.getElementById('profileModalAddress').textContent = s.address || 'N/A';

                document.getElementById('profileModalParentName').textContent = s.parent_name || 'N/A';
                document.getElementById('profileModalParentPhone').textContent = s.parent_phone || 'N/A';
                document.getElementById('profileModalParentEmail').textContent = s.parent_email || 'N/A';
                document.getElementById('profileModalStudentId').textContent = `#${s.student_id}`;

                const callLink = document.getElementById('profileModalCallLink');
                if (callLink) callLink.href = s.phone ? `tel:${s.phone}` : '#';

                const mailLink = document.getElementById('profileModalMailLink');
                if (mailLink) mailLink.href = s.email ? `mailto:${s.email}` : '#';

                $('#studentProfileModal').modal('show');
            });
        });

        // 4. EDIT ASSIGNMENT MODAL POPULATOR
        document.querySelectorAll('.edit-student-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                const studentId = this.dataset.studentId;
                const name = this.dataset.name;
                const sectionId = this.dataset.sectionId;
                const roll = this.dataset.roll;

                document.getElementById('editModalStudentName').value = name;
                document.getElementById('editModalRollInput').value = roll;
                document.getElementById('editModalSectionSelect').value = sectionId;

                const form = document.getElementById('editAssignmentForm');
                form.action = `/students/${studentId}/class/${classId}/update`;

                $('#editAssignmentModal').modal('show');
            });
        });

        // 5. REMOVE FROM CLASS WITH SWEETALERT CONFIRMATION
        document.querySelectorAll('.remove-student-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                const studentId = this.dataset.studentId;
                const name = this.dataset.name;

                Swal.fire({
                    title: `Remove ${name}?`,
                    text: `Are you sure you want to remove this student from {{ $class->name }}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Yes, Remove'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.getElementById('removeStudentForm');
                        form.action = `/students/${studentId}/class/${classId}/remove`;
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endpush
@endsection
