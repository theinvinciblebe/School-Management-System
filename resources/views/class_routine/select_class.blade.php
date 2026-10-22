@extends('layout.main')

@section('content')
<style>
    /* Modern Routine Portal Styling */
    .routine-hero {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #007bff 100%);
        border-radius: 16px;
        color: #ffffff;
        padding: 30px;
        margin-bottom: 25px;
        box-shadow: 0 10px 25px rgba(30, 60, 114, 0.25);
        position: relative;
        overflow: hidden;
    }
    .routine-hero::after {
        content: '';
        position: absolute;
        top: -40px;
        right: -40px;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
        pointer-events: none;
    }
    .hero-stat-card {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 12px;
        padding: 14px 18px;
        color: #fff;
        transition: transform 0.2s ease, background 0.2s ease;
    }
    .hero-stat-card:hover {
        transform: translateY(-3px);
        background: rgba(255, 255, 255, 0.22);
    }
    .hero-stat-card .stat-number {
        font-size: 1.8rem;
        font-weight: 700;
        line-height: 1.2;
    }
    .hero-stat-card .stat-label {
        font-size: 0.85rem;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Filter & Control Bar */
    .control-panel-card {
        border-radius: 14px;
        border: none;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
        margin-bottom: 25px;
        background-color: #fff;
    }
    .dark-mode .control-panel-card {
        background-color: #2c3034;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.25);
    }
    .search-input-group .form-control {
        border-radius: 10px 0 0 10px;
        border-right: none;
        height: 44px;
    }
    .search-input-group .input-group-text {
        border-radius: 0 10px 10px 0;
        background-color: transparent;
    }
    .filter-btn-pill {
        border-radius: 20px;
        padding: 6px 16px;
        font-size: 0.88rem;
        font-weight: 600;
        border: 1px solid #dee2e6;
        color: #495057;
        background: #fff;
        transition: all 0.2s;
        cursor: pointer;
    }
    .dark-mode .filter-btn-pill {
        background: #343a40;
        color: #ced4da;
        border-color: #495057;
    }
    .filter-btn-pill.active, .filter-btn-pill:hover {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
    }

    /* Modern Class Routine Cards */
    .class-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 22px;
    }
    .class-routine-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid #edf2f7;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        transition: all 0.25s cubic-bezier(0.165, 0.84, 0.44, 1);
        display: flex;
        flex-direction: column;
        position: relative;
    }
    .dark-mode .class-routine-card {
        background: #2b3035;
        border-color: #3b4248;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
    }
    .class-routine-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 123, 255, 0.15);
        border-color: #b8daff;
    }
    .dark-mode .class-routine-card:hover {
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.4);
        border-color: #007bff;
    }
    .card-top-accent {
        height: 6px;
        background: linear-gradient(90deg, #007bff, #00c6ff);
    }
    .card-accent-emerald {
        background: linear-gradient(90deg, #10b981, #059669);
    }
    .card-accent-purple {
        background: linear-gradient(90deg, #8b5cf6, #6366f1);
    }
    .card-accent-amber {
        background: linear-gradient(90deg, #f59e0b, #d97706);
    }
    .card-accent-rose {
        background: linear-gradient(90deg, #ec4899, #f43f5e);
    }

    .class-card-body {
        padding: 20px 22px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .class-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #212529;
        margin-bottom: 6px;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .dark-mode .class-title {
        color: #f8f9fa;
    }
    .class-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 14px;
    }
    .badge-pill-custom {
        font-size: 0.75rem;
        padding: 4px 10px;
        border-radius: 20px;
        font-weight: 600;
    }
    .teacher-pill {
        display: inline-flex;
        align-items: center;
        background-color: #f1f5f9;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.85rem;
        color: #475569;
        margin-bottom: 16px;
    }
    .dark-mode .teacher-pill {
        background-color: #343a40;
        color: #ced4da;
    }
    .routine-metrics-row {
        display: flex;
        justify-content: space-between;
        background-color: #f8fafc;
        border-radius: 10px;
        padding: 10px 14px;
        margin-top: auto;
        margin-bottom: 16px;
        border: 1px dashed #e2e8f0;
    }
    .dark-mode .routine-metrics-row {
        background-color: #22262a;
        border-color: #3e444a;
    }
    .metric-item {
        text-align: center;
        flex: 1;
    }
    .metric-item:first-child {
        border-right: 1px solid #e2e8f0;
    }
    .dark-mode .metric-item:first-child {
        border-right-color: #3e444a;
    }
    .metric-val {
        font-weight: 700;
        font-size: 1.1rem;
        color: #1e293b;
    }
    .dark-mode .metric-val {
        color: #e2e8f0;
    }
    .metric-lbl {
        font-size: 0.75rem;
        color: #64748b;
        text-transform: uppercase;
    }

    .class-card-actions {
        display: flex;
        gap: 8px;
    }
    .btn-view-routine {
        flex: 1;
        border-radius: 10px;
        font-weight: 600;
        padding: 9px 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        border: none;
        color: #fff;
        transition: all 0.2s;
        text-decoration: none;
    }
    .btn-view-routine:hover {
        background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
    }
    .btn-quick-add {
        border-radius: 10px;
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #007bff;
        color: #007bff;
        background-color: transparent;
        transition: all 0.2s;
    }
    .btn-quick-add:hover {
        background-color: #007bff;
        color: #fff;
    }

    /* Empty state */
    .empty-state-container {
        text-align: center;
        padding: 60px 20px;
        background: #fff;
        border-radius: 16px;
        border: 2px dashed #dee2e6;
    }
    .dark-mode .empty-state-container {
        background: #2b3035;
        border-color: #495057;
    }
    .empty-state-icon {
        font-size: 3.5rem;
        color: #adb5bd;
        margin-bottom: 15px;
    }
</style>

<div class="content-header p-0 mb-3">
    <div class="container-fluid p-0">
        <!-- Validation / Session Alerts -->
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

        <!-- Hero Header -->
        <div class="routine-hero">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 mb-3 mb-lg-0">
                    <span class="badge badge-light px-3 py-1 mb-2 font-weight-bold text-primary">
                        <i class="fas fa-calendar-alt mr-1"></i> Academic Scheduling
                    </span>
                    <h2 class="font-weight-bold mb-2">Class Routines & Timetables</h2>
                    <p class="mb-0 text-white-50" style="font-size: 1rem;">
                        Select a class below to view full weekly timetable routines, schedule lecture hours, and organize teacher assignments.
                    </p>
                </div>
                <div class="col-lg-5 col-md-12">
                    <div class="row">
                        <div class="col-4">
                            <div class="hero-stat-card text-center">
                                <div class="stat-number">{{ $classes->count() }}</div>
                                <div class="stat-label">Classes</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="hero-stat-card text-center">
                                <div class="stat-number">{{ $totalRoutines }}</div>
                                <div class="stat-label">Routines</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="hero-stat-card text-center">
                                <div class="stat-number">{{ $allSubjects->count() }}</div>
                                <div class="stat-label">Subjects</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="card control-panel-card">
            <div class="card-body p-3">
                <div class="row align-items-center">
                    <!-- Search Input -->
                    <div class="col-lg-5 col-md-6 mb-2 mb-lg-0">
                        <div class="input-group search-input-group">
                            <input type="text" id="classFilterSearch" class="form-control" placeholder="Search by class name, code, room, or teacher...">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-search text-muted"></i></span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Dropdown Jump -->
                    <div class="col-lg-4 col-md-6 mb-2 mb-lg-0">
                        <div class="input-group">
                            <select id="quickClassDropdown" class="form-control" style="border-radius: 10px;">
                                <option value="">-- Quick Jump to Class Timetable --</option>
                                @foreach($classes as $c)
                                    <option value="{{ route('class_routines.index', $c->class_id) }}">
                                        {{ $c->name }} ({{ $c->class_code ?? 'Class #' . $c->class_id }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Add Routine Button (Admin / Staff) -->
                    <div class="col-lg-3 col-md-12 text-lg-right text-left">
                        @if (Auth::user()->role == 0 || Auth::user()->role == 4)
                            <button type="button" class="btn btn-primary px-3 shadow-sm font-weight-bold" style="border-radius: 10px; height: 44px;" data-toggle="modal" data-target="#quickAddRoutineModal">
                                <i class="fas fa-plus-circle mr-1"></i> Add Routine
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Filter Tabs -->
                <div class="d-flex flex-wrap align-items-center mt-3 pt-2 border-top" style="gap: 8px;">
                    <span class="text-muted mr-2 font-weight-bold" style="font-size: 0.85rem;">Filter:</span>
                    <button type="button" class="filter-btn-pill active" data-filter="all">
                        All Classes ({{ $classes->count() }})
                    </button>
                    <button type="button" class="filter-btn-pill" data-filter="active">
                        With Routines ({{ $classes->where('routine_count', '>', 0)->count() }})
                    </button>
                    <button type="button" class="filter-btn-pill" data-filter="empty">
                        No Routines ({{ $classes->where('routine_count', 0)->count() }})
                    </button>
                </div>
            </div>
        </div>

        <!-- Class Cards Grid -->
        @php
            $accentColors = ['card-accent-emerald', 'card-accent-purple', 'card-accent-amber', 'card-accent-rose', ''];
        @endphp

        <div class="class-cards-grid" id="classCardsContainer">
            @forelse($classes as $index => $class)
                @php
                    $accentClass = $accentColors[$index % count($accentColors)];
                    $hasRoutines = ($class->routine_count > 0);
                @endphp
                <div class="class-routine-card"
                     data-name="{{ strtolower($class->name) }}"
                     data-code="{{ strtolower($class->class_code ?? '') }}"
                     data-room="{{ strtolower($class->class_room ?? '') }}"
                     data-teacher="{{ strtolower($class->teacher_name ?? '') }}"
                     data-has-routines="{{ $hasRoutines ? 'yes' : 'no' }}">
                    <div class="card-top-accent {{ $accentClass }}"></div>
                    <div class="class-card-body">
                        <!-- Badges: Room & Code -->
                        <div class="class-badges">
                            @if(!empty($class->class_code))
                                <span class="badge badge-primary badge-pill-custom">
                                    <i class="fas fa-tag mr-1"></i>{{ $class->class_code }}
                                </span>
                            @endif
                            @if(!empty($class->class_room))
                                <span class="badge badge-info badge-pill-custom">
                                    <i class="fas fa-door-open mr-1"></i>Room {{ $class->class_room }}
                                </span>
                            @else
                                <span class="badge badge-light badge-pill-custom text-muted">
                                    <i class="fas fa-door-open mr-1"></i>Room N/A
                                </span>
                            @endif
                            @if($hasRoutines)
                                <span class="badge badge-success badge-pill-custom ml-auto">
                                    <i class="fas fa-check-circle mr-1"></i>Scheduled
                                </span>
                            @else
                                <span class="badge badge-warning badge-pill-custom ml-auto">
                                    <i class="fas fa-clock mr-1"></i>Needs Setup
                                </span>
                            @endif
                        </div>

                        <!-- Class Name -->
                        <h4 class="class-title" title="{{ $class->name }}">{{ $class->name }}</h4>

                        <!-- Homeroom Teacher -->
                        <div class="teacher-pill">
                            <i class="fas fa-chalkboard-teacher mr-2 text-primary"></i>
                            <span class="text-truncate">
                                {{ $class->teacher_name ? 'Teacher: ' . $class->teacher_name : 'No Teacher Assigned' }}
                            </span>
                        </div>

                        <!-- Metrics row -->
                        <div class="routine-metrics-row">
                            <div class="metric-item">
                                <div class="metric-val text-primary">{{ $class->routine_count }}</div>
                                <div class="metric-lbl">Routine Slots</div>
                            </div>
                            <div class="metric-item">
                                <div class="metric-val text-info">{{ $class->subject_count }}</div>
                                <div class="metric-lbl">Subjects</div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="class-card-actions">
                            <a href="{{ route('class_routines.index', $class->class_id) }}" class="btn-view-routine">
                                <i class="fas fa-calendar-alt"></i>
                                <span>View Timetable</span>
                                <i class="fas fa-arrow-right ml-auto" style="font-size: 0.8rem;"></i>
                            </a>
                            @if (Auth::user()->role == 0 || Auth::user()->role == 4)
                                <button type="button" class="btn-quick-add"
                                        title="Quick Add Routine"
                                        onclick="openScheduleForClass({{ $class->class_id }})">
                                    <i class="fas fa-plus"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12" style="grid-column: 1 / -1;">
                    <div class="empty-state-container">
                        <i class="fas fa-folder-open empty-state-icon"></i>
                        <h4 class="font-weight-bold">No Classes Available</h4>
                        <p class="text-muted">No classes were found under your current account permissions.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- No search matches empty state (hidden by default) -->
        <div id="noSearchMatches" class="empty-state-container mt-4" style="display: none;">
            <i class="fas fa-search empty-state-icon"></i>
            <h4 class="font-weight-bold">No Matching Classes Found</h4>
            <p class="text-muted mb-3">No classes match your current search criteria. Try a different keyword.</p>
            <button type="button" class="btn btn-outline-primary btn-sm px-3" onclick="resetClassSearch()">
                <i class="fas fa-redo mr-1"></i> Clear Search
            </button>
        </div>
    </div>
</div>

<!-- Quick Add Routine Modal (Admin/Staff Only) -->
@if (Auth::user()->role == 0 || Auth::user()->role == 4)
<div class="modal fade" id="quickAddRoutineModal" tabindex="-1" role="dialog" aria-labelledby="quickAddRoutineModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 14px; overflow: hidden; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.2);">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold" id="quickAddRoutineModalLabel">
                    <i class="fas fa-calendar-plus mr-2"></i> Schedule Class Routine
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="quickAddRoutineForm" action="{{ route('class_routines.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <!-- Class Selection -->
                    <div class="form-group">
                        <label for="modal_class_id" class="font-weight-bold">
                            <i class="fas fa-chalkboard text-primary mr-1"></i> Select Class <span class="text-danger">*</span>
                        </label>
                        <select class="form-control" name="class_id" id="modal_class_id" required onchange="filterSubjectsByClass(this.value)">
                            <option value="">-- Choose Class --</option>
                            @foreach ($classes as $c)
                                <option value="{{ $c->class_id }}" data-code="{{ $c->class_code }}">{{ $c->name }} (Room: {{ $c->class_room ?? 'N/A' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Subject Selection -->
                    <div class="form-group">
                        <label for="modal_subject_id" class="font-weight-bold">
                            <i class="fas fa-book text-info mr-1"></i> Subject <span class="text-danger">*</span>
                        </label>
                        <select class="form-control" name="subject_id" id="modal_subject_id" required>
                            <option value="">-- First Select a Class Above --</option>
                            @foreach ($allSubjects as $sub)
                                <option value="{{ $sub->subject_id }}" data-class="{{ $sub->class_id }}">{{ $sub->name }}</option>
                            @endforeach
                        </select>
                        <small id="subjectHelpText" class="form-text text-muted">Showing subjects assigned to the chosen class.</small>
                    </div>

                    <!-- Day of the Week -->
                    <div class="form-group">
                        <label for="modal_day" class="font-weight-bold">
                            <i class="fas fa-calendar-day text-warning mr-1"></i> Day of Week <span class="text-danger">*</span>
                        </label>
                        <select class="form-control" name="day" id="modal_day" required>
                            @foreach ($daysOfWeek as $day)
                                <option value="{{ $day }}">{{ $day }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Time Selection Row -->
                    <div class="row">
                        @php
                            $hours = [
                                7 => '07:00 AM',
                                8 => '08:00 AM',
                                9 => '09:00 AM',
                                10 => '10:00 AM',
                                11 => '11:00 AM',
                                12 => '12:00 PM',
                                13 => '01:00 PM',
                                14 => '02:00 PM',
                                15 => '03:00 PM',
                                16 => '04:00 PM',
                                17 => '05:00 PM',
                                18 => '06:00 PM',
                                19 => '07:00 PM',
                                20 => '08:00 PM',
                            ];
                            $endHours = [
                                8 => '08:00 AM',
                                9 => '09:00 AM',
                                10 => '10:00 AM',
                                11 => '11:00 AM',
                                12 => '12:00 PM',
                                13 => '01:00 PM',
                                14 => '02:00 PM',
                                15 => '03:00 PM',
                                16 => '04:00 PM',
                                17 => '05:00 PM',
                                18 => '06:00 PM',
                                19 => '07:00 PM',
                                20 => '08:00 PM',
                                21 => '09:00 PM',
                            ];
                        @endphp
                        <div class="col-6">
                            <div class="form-group">
                                <label for="modal_time_start" class="font-weight-bold">
                                    <i class="fas fa-clock text-success mr-1"></i> Start Time <span class="text-danger">*</span>
                                </label>
                                <select class="form-control" name="time_start" id="modal_time_start" required onchange="validateRoutineTimes()">
                                    @foreach($hours as $val => $label)
                                        <option value="{{ $val }}" {{ $val == 8 ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="modal_time_end" class="font-weight-bold">
                                    <i class="fas fa-stopwatch text-danger mr-1"></i> End Time <span class="text-danger">*</span>
                                </label>
                                <select class="form-control" name="time_end" id="modal_time_end" required onchange="validateRoutineTimes()">
                                    @foreach($endHours as $val => $label)
                                        <option value="{{ $val }}" {{ $val == 10 ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Time Duration Notice -->
                    <div id="routineDurationAlert" class="alert alert-info py-2 px-3 mb-0" style="font-size: 0.88rem; border-radius: 8px;">
                        <i class="fas fa-info-circle mr-1"></i> <span id="routineDurationText">Duration: 2 hours</span>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary px-3" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="btnSubmitRoutine" class="btn btn-primary px-4 font-weight-bold">
                        <i class="fas fa-save mr-1"></i> Save Routine
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<script>
    // Live Search & Filter Logic
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('classFilterSearch');
        const cards = document.querySelectorAll('.class-routine-card');
        const filterBtns = document.querySelectorAll('.filter-btn-pill');
        const noMatchesAlert = document.getElementById('noSearchMatches');
        const quickSelect = document.getElementById('quickClassDropdown');

        let activeFilter = 'all';

        // Quick Class Jump
        if (quickSelect) {
            quickSelect.addEventListener('change', function() {
                if (this.value) {
                    window.location.href = this.value;
                }
            });
        }

        function filterCards() {
            const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
            let visibleCount = 0;

            cards.forEach(card => {
                const name = card.getAttribute('data-name') || '';
                const code = card.getAttribute('data-code') || '';
                const room = card.getAttribute('data-room') || '';
                const teacher = card.getAttribute('data-teacher') || '';
                const hasRoutines = card.getAttribute('data-has-routines') || 'no';

                // Check text query
                const matchesSearch = !query ||
                    name.includes(query) ||
                    code.includes(query) ||
                    room.includes(query) ||
                    teacher.includes(query);

                // Check status filter tab
                let matchesFilter = true;
                if (activeFilter === 'active') {
                    matchesFilter = (hasRoutines === 'yes');
                } else if (activeFilter === 'empty') {
                    matchesFilter = (hasRoutines === 'no');
                }

                if (matchesSearch && matchesFilter) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (noMatchesAlert) {
                noMatchesAlert.style.display = (visibleCount === 0 && cards.length > 0) ? 'block' : 'none';
            }
        }

        if (searchInput) {
            searchInput.addEventListener('input', filterCards);
        }

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                activeFilter = this.getAttribute('data-filter');
                filterCards();
            });
        });

        // Initialize modal validation
        validateRoutineTimes();
    });

    function resetClassSearch() {
        const searchInput = document.getElementById('classFilterSearch');
        if (searchInput) {
            searchInput.value = '';
        }
        const allBtn = document.querySelector('.filter-btn-pill[data-filter="all"]');
        if (allBtn) {
            allBtn.click();
        }
    }

    // Modal Subject Filter by Class
    function filterSubjectsByClass(classId) {
        const subjectSelect = document.getElementById('modal_subject_id');
        if (!subjectSelect) return;

        const options = subjectSelect.querySelectorAll('option');
        let matchedCount = 0;

        options.forEach(opt => {
            if (!opt.value) {
                opt.style.display = 'block';
                return;
            }
            const optClass = opt.getAttribute('data-class');
            if (!classId || optClass == classId) {
                opt.style.display = 'block';
                matchedCount++;
            } else {
                opt.style.display = 'none';
            }
        });

        // Reset selected subject to first valid option
        let selectedValid = false;
        options.forEach(opt => {
            if (opt.value && opt.style.display !== 'none' && !selectedValid) {
                subjectSelect.value = opt.value;
                selectedValid = true;
            }
        });

        if (!selectedValid) {
            subjectSelect.value = '';
        }

        const helpText = document.getElementById('subjectHelpText');
        if (helpText) {
            if (classId && matchedCount === 0) {
                helpText.innerHTML = '<span class="text-danger"><i class="fas fa-exclamation-circle mr-1"></i> No subjects assigned to this class yet.</span>';
            } else {
                helpText.innerHTML = 'Showing subjects for selected class.';
            }
        }
    }

    // Modal Routine Times Validation & Duration Calculation
    function validateRoutineTimes() {
        const startSelect = document.getElementById('modal_time_start');
        const endSelect = document.getElementById('modal_time_end');
        const submitBtn = document.getElementById('btnSubmitRoutine');
        const alertBox = document.getElementById('routineDurationAlert');
        const durationText = document.getElementById('routineDurationText');

        if (!startSelect || !endSelect || !alertBox || !durationText) return;

        const start = parseInt(startSelect.value, 10);
        const end = parseInt(endSelect.value, 10);

        if (end <= start) {
            alertBox.className = 'alert alert-danger py-2 px-3 mb-0';
            durationText.innerHTML = '<strong>Error:</strong> End time must be later than start time.';
            if (submitBtn) submitBtn.disabled = true;
        } else {
            const diff = end - start;
            alertBox.className = 'alert alert-info py-2 px-3 mb-0';
            durationText.innerHTML = `<strong>Schedule Duration:</strong> ${diff} ${diff === 1 ? 'hour' : 'hours'}`;
            if (submitBtn) submitBtn.disabled = false;
        }
    }

    // Open modal directly pre-selecting specific class
    function openScheduleForClass(classId) {
        const classSelect = document.getElementById('modal_class_id');
        if (classSelect) {
            classSelect.value = classId;
            filterSubjectsByClass(classId);
        }
        $('#quickAddRoutineModal').modal('show');
    }
</script>
@endsection

