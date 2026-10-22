@extends('layout.main')

@section('content')
<style>
    /* Modern Routine Timetable Styles */
    .timetable-hero {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #007bff 100%);
        border-radius: 16px;
        color: #ffffff;
        padding: 24px 28px;
        margin-bottom: 24px;
        box-shadow: 0 10px 25px rgba(30, 60, 114, 0.22);
    }
    .timetable-hero .badge-outline-white {
        border: 1px solid rgba(255, 255, 255, 0.4);
        background: rgba(255, 255, 255, 0.15);
        color: #fff;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.82rem;
        backdrop-filter: blur(4px);
    }
    .timetable-controls-card {
        border-radius: 14px;
        border: none;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
        margin-bottom: 22px;
        background: #fff;
    }
    .dark-mode .timetable-controls-card {
        background: #2c3034;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.25);
    }

    /* Day Navigation Pills */
    .day-nav-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    .day-nav-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.88rem;
        border: 1px solid #dee2e6;
        background: #f8fafc;
        color: #495057;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    .dark-mode .day-nav-pill {
        background: #343a40;
        border-color: #495057;
        color: #ced4da;
    }
    .day-nav-pill:hover {
        background: #e2e8f0;
        color: #1e293b;
    }
    .dark-mode .day-nav-pill:hover {
        background: #3f474e;
        color: #fff;
    }
    .day-nav-pill.active {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        color: #fff;
        border-color: #007bff;
        box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
    }
    .day-count-badge {
        font-size: 0.72rem;
        padding: 2px 7px;
        border-radius: 12px;
        background: rgba(0, 0, 0, 0.08);
    }
    .day-nav-pill.active .day-count-badge {
        background: rgba(255, 255, 255, 0.25);
        color: #fff;
    }

    /* Day Schedule Section */
    .day-schedule-card {
        border-radius: 14px;
        border: 1px solid #edf2f7;
        background: #fff;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04);
        margin-bottom: 20px;
        overflow: hidden;
    }
    .dark-mode .day-schedule-card {
        background: #2b3035;
        border-color: #3b4248;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.2);
    }
    .day-card-header {
        padding: 14px 20px;
        background: #f8fafc;
        border-bottom: 1px solid #edf2f7;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .dark-mode .day-card-header {
        background: #22262a;
        border-bottom-color: #3b4248;
    }
    .day-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
        color: #1e293b;
    }
    .dark-mode .day-title {
        color: #f8f9fa;
    }

    /* Routine Session Item */
    .routine-items-list {
        padding: 14px 20px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .routine-session-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 18px;
        border-radius: 12px;
        background: #fdfdfd;
        border: 1px solid #e2e8f0;
        border-left: 5px solid #007bff;
        transition: all 0.2s ease;
    }
    .dark-mode .routine-session-item {
        background: #262a2e;
        border-color: #3a4147;
        border-left-color: #007bff;
    }
    .routine-session-item:hover {
        transform: translateX(4px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }
    .session-time-col {
        min-width: 190px;
    }
    .session-time-badge {
        font-size: 0.95rem;
        font-weight: 700;
        color: #007bff;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .dark-mode .session-time-badge {
        color: #63b3ed;
    }
    .session-duration {
        font-size: 0.78rem;
        color: #64748b;
        margin-left: 20px;
    }
    .session-subject-col {
        flex: 1;
        padding: 0 16px;
    }
    .session-subject-name {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 2px;
    }
    .dark-mode .session-subject-name {
        color: #f1f5f9;
    }
    .session-actions-col {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Empty Day Notice */
    .empty-day-state {
        text-align: center;
        padding: 30px 20px;
        color: #94a3b8;
    }

    /* Print Stylesheet */
    @media print {
        .main-header, .main-sidebar, .main-footer, .btn, .timetable-controls-card, .day-nav-pills, .session-actions-col, #addRoutineModal, #editRoutineModal {
            display: none !important;
        }
        .content-wrapper {
            margin: 0 !important;
            padding: 0 !important;
            background: #fff !important;
        }
        .timetable-hero {
            background: #fff !important;
            color: #000 !important;
            box-shadow: none !important;
            border: 1px solid #ccc !important;
        }
        .day-schedule-card {
            border: 1px solid #ccc !important;
            page-break-inside: avoid;
        }
    }
</style>

<div class="content-header p-0 mb-3">
    <div class="container-fluid p-0">
        <!-- Alerts -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-exclamation-triangle mr-1"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (isset($errors) && $errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Class Timetable Header -->
        <div class="timetable-hero">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="mb-2 mb-md-0">
                    <a href="{{ route('class_routines.show_classes') }}" class="btn btn-outline-light btn-sm mb-2" style="border-radius: 8px;">
                        <i class="fas fa-arrow-left mr-1"></i> Back to All Classes
                    </a>
                    <div class="d-flex align-items-center flex-wrap" style="gap: 10px;">
                        <h2 class="font-weight-bold mb-0">{{ $class->name }} Timetable</h2>
                        @if(!empty($class->class_code))
                            <span class="badge-outline-white"><i class="fas fa-tag mr-1"></i>{{ $class->class_code }}</span>
                        @endif
                        @if(!empty($class->class_room))
                            <span class="badge-outline-white"><i class="fas fa-door-open mr-1"></i>Room {{ $class->class_room }}</span>
                        @endif
                        @if(!empty($class->teacher_name))
                            <span class="badge-outline-white"><i class="fas fa-chalkboard-teacher mr-1"></i>{{ $class->teacher_name }}</span>
                        @endif
                    </div>
                </div>

                <!-- Action Controls -->
                <div class="d-flex align-items-center flex-wrap" style="gap: 10px;">
                    <button type="button" class="btn btn-light btn-sm font-weight-bold px-3 py-2 shadow-sm" style="border-radius: 8px;" onclick="window.print()">
                        <i class="fas fa-print mr-1"></i> Print Timetable
                    </button>
                    @if (Auth::user()->role == 0 || Auth::user()->role == 4)
                        <button type="button" class="btn btn-warning btn-sm font-weight-bold px-3 py-2 shadow-sm" style="border-radius: 8px;" data-toggle="modal" data-target="#addRoutineModal">
                            <i class="fas fa-plus-circle mr-1"></i> Add Routine Slot
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Controls & Day Filter Bar -->
        <div class="card timetable-controls-card">
            <div class="card-body p-3">
                <div class="d-flex flex-wrap align-items-center justify-content-between" style="gap: 14px;">
                    <!-- Day Navigation Pills -->
                    <div class="day-nav-pills" id="dayNavPills">
                        <button type="button" class="day-nav-pill active" data-target-day="all">
                            <i class="fas fa-calendar-week"></i>
                            <span>All Days</span>
                            <span class="day-count-badge">{{ $routines->count() }}</span>
                        </button>
                        @foreach ($daysOfWeek as $day)
                            @php
                                $dayRoutines = $routines->where('day', $day);
                            @endphp
                            <button type="button" class="day-nav-pill" data-target-day="{{ $day }}">
                                <span>{{ $day }}</span>
                                <span class="day-count-badge">{{ $dayRoutines->count() }}</span>
                            </button>
                        @endforeach
                    </div>

                    <!-- Quick Switch Class Dropdown -->
                    @if(isset($allClasses) && $allClasses->count() > 1)
                        <div class="d-flex align-items-center" style="min-width: 220px;">
                            <select class="form-control form-control-sm" style="border-radius: 8px;" onchange="if(this.value) window.location.href=this.value;">
                                <option value="">-- Switch Class --</option>
                                @foreach($allClasses as $otherClass)
                                    <option value="{{ route('class_routines.index', $otherClass->class_id) }}" {{ $otherClass->class_id == $class->class_id ? 'selected' : '' }}>
                                        {{ $otherClass->name }} ({{ $otherClass->class_code ?? 'Class #' . $otherClass->class_id }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Day Schedule Cards Container -->
        <div id="daySchedulesContainer">
            @foreach ($daysOfWeek as $day)
                @php
                    $dayRoutines = $routines->where('day', $day)->sortBy('time_start');
                    $count = $dayRoutines->count();
                @endphp
                <div class="day-schedule-card" id="daySection-{{ $day }}" data-day="{{ $day }}">
                    <div class="day-card-header">
                        <h4 class="day-title">
                            <i class="far fa-calendar-check text-primary"></i>
                            <span>{{ $day }}</span>
                            @if($count > 0)
                                <span class="badge badge-success px-2 py-1" style="font-size: 0.75rem; border-radius: 12px;">{{ $count }} {{ $count === 1 ? 'Slot' : 'Slots' }}</span>
                            @else
                                <span class="badge badge-secondary px-2 py-1" style="font-size: 0.75rem; border-radius: 12px;">No Sessions</span>
                            @endif
                        </h4>
                        @if (Auth::user()->role == 0 || Auth::user()->role == 4)
                            <button type="button" class="btn btn-outline-primary btn-sm" style="border-radius: 20px; font-size: 0.8rem;" onclick="openAddRoutineForDay('{{ $day }}')">
                                <i class="fas fa-plus mr-1"></i> Add to {{ $day }}
                            </button>
                        @endif
                    </div>

                    <div class="routine-items-list">
                        @if($dayRoutines->isEmpty())
                            <div class="empty-day-state">
                                <i class="far fa-calendar-times" style="font-size: 2.2rem; opacity: 0.5; margin-bottom: 8px;"></i>
                                <p class="mb-0">No classes scheduled on {{ $day }}.</p>
                            </div>
                        @else
                            @php
                                $hourLabels = [
                                    7 => '07:00 AM', 8 => '08:00 AM', 9 => '09:00 AM', 10 => '10:00 AM', 11 => '11:00 AM',
                                    12 => '12:00 PM', 13 => '01:00 PM', 14 => '02:00 PM', 15 => '03:00 PM', 16 => '04:00 PM',
                                    17 => '05:00 PM', 18 => '06:00 PM', 19 => '07:00 PM', 20 => '08:00 PM', 21 => '09:00 PM'
                                ];
                            @endphp
                            @foreach ($dayRoutines as $routine)
                                @php
                                    $startLabel = $hourLabels[$routine->time_start] ?? sprintf('%02d:00', $routine->time_start);
                                    $endLabel = $hourLabels[$routine->time_end] ?? sprintf('%02d:00', $routine->time_end);
                                    $durationHours = max(1, $routine->time_end - $routine->time_start);
                                @endphp
                                <div class="routine-session-item">
                                    <div class="session-time-col">
                                        <div class="session-time-badge">
                                            <i class="far fa-clock"></i>
                                            <span>{{ $startLabel }} - {{ $endLabel }}</span>
                                        </div>
                                        <div class="session-duration">
                                            <i class="fas fa-hourglass-half mr-1"></i>{{ $durationHours }} {{ $durationHours === 1 ? 'hour' : 'hours' }}
                                        </div>
                                    </div>

                                    <div class="session-subject-col">
                                        <div class="session-subject-name">
                                            <i class="fas fa-book-open text-info mr-2"></i>{{ $routine->subject_name }}
                                        </div>
                                        <div class="text-muted" style="font-size: 0.82rem;">
                                            Class: {{ $class->name }} &bull; {{ $day }}
                                        </div>
                                    </div>

                                    @if (Auth::user()->role == 0 || Auth::user()->role == 4)
                                        <div class="session-actions-col">
                                            <button type="button" class="btn btn-outline-primary btn-sm px-2"
                                                    style="border-radius: 8px;"
                                                    onclick="openEditRoutineModal({{ $routine->class_routine_id }}, '{{ $routine->subject_id }}', {{ $routine->time_start }}, {{ $routine->time_end }}, '{{ $routine->day }}')">
                                                <i class="fas fa-edit mr-1"></i> Edit
                                            </button>
                                            <form action="{{ route('class_routines.destroy', $routine->class_routine_id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to remove this routine slot?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm px-2" style="border-radius: 8px;">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@php
    $startHourOptions = [
        7 => '07:00 AM', 8 => '08:00 AM', 9 => '09:00 AM', 10 => '10:00 AM', 11 => '11:00 AM',
        12 => '12:00 PM', 13 => '01:00 PM', 14 => '02:00 PM', 15 => '03:00 PM', 16 => '04:00 PM',
        17 => '05:00 PM', 18 => '06:00 PM', 19 => '07:00 PM', 20 => '08:00 PM'
    ];
    $endHourOptions = [
        8 => '08:00 AM', 9 => '09:00 AM', 10 => '10:00 AM', 11 => '11:00 AM', 12 => '12:00 PM',
        13 => '01:00 PM', 14 => '02:00 PM', 15 => '03:00 PM', 16 => '04:00 PM', 17 => '05:00 PM',
        18 => '06:00 PM', 19 => '07:00 PM', 20 => '08:00 PM', 21 => '09:00 PM'
    ];
@endphp

<!-- Add Routine Modal (Admin/Staff Only) -->
@if (Auth::user()->role == 0 || Auth::user()->role == 4)
<div class="modal fade" id="addRoutineModal" tabindex="-1" role="dialog" aria-labelledby="addRoutineModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 14px; overflow: hidden; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.2);">
            <form action="{{ route('class_routines.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold" id="addRoutineModalLabel">
                        <i class="fas fa-calendar-plus mr-2"></i> Add Class Routine
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="class_id" value="{{ $class->class_id }}">

                    <div class="form-group">
                        <label class="font-weight-bold"><i class="fas fa-chalkboard mr-1 text-primary"></i> Class</label>
                        <input type="text" class="form-control" value="{{ $class->name }} (Room: {{ $class->class_room ?? 'N/A' }})" readonly>
                    </div>

                    <div class="form-group">
                        <label for="add_subject_id" class="font-weight-bold">
                            <i class="fas fa-book mr-1 text-info"></i> Subject <span class="text-danger">*</span>
                        </label>
                        <select class="form-control" name="subject_id" id="add_subject_id" required>
                            @forelse ($subjects as $subject)
                                <option value="{{ $subject->subject_id }}">{{ $subject->name }}</option>
                            @empty
                                <option value="">No subjects assigned to this class</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="add_day" class="font-weight-bold">
                            <i class="fas fa-calendar-day mr-1 text-warning"></i> Day of Week <span class="text-danger">*</span>
                        </label>
                        <select class="form-control" name="day" id="add_day" required>
                            @foreach ($daysOfWeek as $day)
                                <option value="{{ $day }}">{{ $day }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="add_time_start" class="font-weight-bold">
                                    <i class="fas fa-clock mr-1 text-success"></i> Start Time <span class="text-danger">*</span>
                                </label>
                                <select class="form-control" name="time_start" id="add_time_start" required onchange="validateAddTimes()">
                                    @foreach($startHourOptions as $val => $label)
                                        <option value="{{ $val }}" {{ $val == 8 ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="add_time_end" class="font-weight-bold">
                                    <i class="fas fa-stopwatch mr-1 text-danger"></i> End Time <span class="text-danger">*</span>
                                </label>
                                <select class="form-control" name="time_end" id="add_time_end" required onchange="validateAddTimes()">
                                    @foreach($endHourOptions as $val => $label)
                                        <option value="{{ $val }}" {{ $val == 10 ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="addDurationAlert" class="alert alert-info py-2 px-3 mb-0" style="font-size: 0.88rem; border-radius: 8px;">
                        <i class="fas fa-info-circle mr-1"></i> <span id="addDurationText">Duration: 2 hours</span>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary px-3" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="btnAddSubmit" class="btn btn-primary px-4 font-weight-bold">
                        <i class="fas fa-save mr-1"></i> Save Routine
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Dynamic Unified Edit Routine Modal -->
<div class="modal fade" id="editRoutineModal" tabindex="-1" role="dialog" aria-labelledby="editRoutineModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 14px; overflow: hidden; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.2);">
            <form id="editRoutineForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title font-weight-bold" id="editRoutineModalLabel">
                        <i class="fas fa-edit mr-2"></i> Edit Class Routine
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="form-group">
                        <label for="edit_subject_id" class="font-weight-bold">
                            <i class="fas fa-book mr-1 text-info"></i> Subject <span class="text-danger">*</span>
                        </label>
                        <select class="form-control" name="subject_id" id="edit_subject_id" required>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->subject_id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="edit_day" class="font-weight-bold">
                            <i class="fas fa-calendar-day mr-1 text-warning"></i> Day of Week <span class="text-danger">*</span>
                        </label>
                        <select class="form-control" name="day" id="edit_day" required>
                            @foreach ($daysOfWeek as $day)
                                <option value="{{ $day }}">{{ $day }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="edit_time_start" class="font-weight-bold">
                                    <i class="fas fa-clock mr-1 text-success"></i> Start Time <span class="text-danger">*</span>
                                </label>
                                <select class="form-control" name="time_start" id="edit_time_start" required onchange="validateEditTimes()">
                                    @foreach($startHourOptions as $val => $label)
                                        <option value="{{ $val }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="edit_time_end" class="font-weight-bold">
                                    <i class="fas fa-stopwatch mr-1 text-danger"></i> End Time <span class="text-danger">*</span>
                                </label>
                                <select class="form-control" name="time_end" id="edit_time_end" required onchange="validateEditTimes()">
                                    @foreach($endHourOptions as $val => $label)
                                        <option value="{{ $val }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="editDurationAlert" class="alert alert-info py-2 px-3 mb-0" style="font-size: 0.88rem; border-radius: 8px;">
                        <i class="fas fa-info-circle mr-1"></i> <span id="editDurationText">Duration: 2 hours</span>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary px-3" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="btnEditSubmit" class="btn btn-info px-4 font-weight-bold text-white">
                        <i class="fas fa-save mr-1"></i> Update Routine
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dayPills = document.querySelectorAll('.day-nav-pill');
        const dayCards = document.querySelectorAll('.day-schedule-card');

        dayPills.forEach(pill => {
            pill.addEventListener('click', function() {
                dayPills.forEach(p => p.classList.remove('active'));
                this.classList.add('active');

                const targetDay = this.getAttribute('data-target-day');
                dayCards.forEach(card => {
                    const cardDay = card.getAttribute('data-day');
                    if (targetDay === 'all' || cardDay === targetDay) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });

        validateAddTimes();
    });

    // Time validation helper for Add Modal
    function validateAddTimes() {
        const start = parseInt(document.getElementById('add_time_start').value, 10);
        const end = parseInt(document.getElementById('add_time_end').value, 10);
        const alertBox = document.getElementById('addDurationAlert');
        const text = document.getElementById('addDurationText');
        const submit = document.getElementById('btnAddSubmit');

        if (!alertBox || !text) return;

        if (end <= start) {
            alertBox.className = 'alert alert-danger py-2 px-3 mb-0';
            text.innerHTML = '<strong>Error:</strong> End time must be later than start time.';
            if (submit) submit.disabled = true;
        } else {
            const diff = end - start;
            alertBox.className = 'alert alert-info py-2 px-3 mb-0';
            text.innerHTML = `<strong>Schedule Duration:</strong> ${diff} ${diff === 1 ? 'hour' : 'hours'}`;
            if (submit) submit.disabled = false;
        }
    }

    // Time validation helper for Edit Modal
    function validateEditTimes() {
        const start = parseInt(document.getElementById('edit_time_start').value, 10);
        const end = parseInt(document.getElementById('edit_time_end').value, 10);
        const alertBox = document.getElementById('editDurationAlert');
        const text = document.getElementById('editDurationText');
        const submit = document.getElementById('btnEditSubmit');

        if (!alertBox || !text) return;

        if (end <= start) {
            alertBox.className = 'alert alert-danger py-2 px-3 mb-0';
            text.innerHTML = '<strong>Error:</strong> End time must be later than start time.';
            if (submit) submit.disabled = true;
        } else {
            const diff = end - start;
            alertBox.className = 'alert alert-info py-2 px-3 mb-0';
            text.innerHTML = `<strong>Schedule Duration:</strong> ${diff} ${diff === 1 ? 'hour' : 'hours'}`;
            if (submit) submit.disabled = false;
        }
    }

    // Quick open Add modal with a specific day preselected
    function openAddRoutineForDay(day) {
        const daySelect = document.getElementById('add_day');
        if (daySelect) {
            daySelect.value = day;
        }
        $('#addRoutineModal').modal('show');
    }

    // Dynamic Edit Modal populate
    function openEditRoutineModal(routineId, subjectId, timeStart, timeEnd, day) {
        const form = document.getElementById('editRoutineForm');
        if (form) {
            form.action = '{{ url("/class-routines/update") }}/' + routineId;
        }

        const subSelect = document.getElementById('edit_subject_id');
        if (subSelect) subSelect.value = subjectId;

        const daySelect = document.getElementById('edit_day');
        if (daySelect) daySelect.value = day;

        const startSelect = document.getElementById('edit_time_start');
        if (startSelect) startSelect.value = timeStart;

        const endSelect = document.getElementById('edit_time_end');
        if (endSelect) endSelect.value = timeEnd;

        validateEditTimes();
        $('#editRoutineModal').modal('show');
    }
</script>
@endsection

