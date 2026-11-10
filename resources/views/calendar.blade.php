@extends('layout.main')

@section('content')
<!-- FullCalendar CSS -->
<link rel="stylesheet" href="/assets/plugins/fullcalendar/main.min.css">

<style>
    /* ══════════════════════════════════════════════════════════════════
       MODERN CALENDAR EXECUTIVE SUITE STYLES
       ══════════════════════════════════════════════════════════════════ */
    .calendar-page-header {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.95) 100%);
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
        backdrop-filter: blur(8px);
    }
    .dark-mode .calendar-page-header {
        background: linear-gradient(135deg, rgba(30, 41, 59, 0.95) 0%, rgba(15, 23, 42, 0.95) 100%);
        border-color: rgba(51, 65, 85, 0.8);
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.35);
    }

    /* KPI Metric Cards */
    .metric-card {
        border-radius: 1rem;
        border: 1px solid rgba(226, 232, 240, 0.8);
        background: #ffffff;
        padding: 1.25rem;
        transition: transform 0.22s ease, box-shadow 0.22s ease;
        box-shadow: 0 4px 15px -3px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        gap: 1.25rem;
        height: 100%;
    }
    .dark-mode .metric-card {
        background: #1e293b;
        border-color: #334155;
        box-shadow: 0 4px 15px -3px rgba(0, 0, 0, 0.25);
    }
    .metric-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px -4px rgba(0, 0, 0, 0.1);
    }
    .metric-icon-wrap {
        width: 54px;
        height: 54px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
        box-shadow: 0 6px 14px -2px rgba(0, 0, 0, 0.15);
    }
    .metric-icon-indigo  { background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%); color: #ffffff; }
    .metric-icon-emerald { background: linear-gradient(135deg, #10b981 0%, #047857 100%); color: #ffffff; }
    .metric-icon-amber   { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #ffffff; }
    .metric-icon-sky     { background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%); color: #ffffff; }

    /* Modern Card Container */
    .modern-calendar-card {
        border-radius: 1rem !important;
        border: 1px solid rgba(226, 232, 240, 0.8) !important;
        background: #ffffff !important;
        box-shadow: 0 6px 20px -3px rgba(0, 0, 0, 0.06) !important;
        overflow: hidden;
    }
    .dark-mode .modern-calendar-card {
        background: #1e293b !important;
        border-color: #334155 !important;
        box-shadow: 0 6px 20px -3px rgba(0, 0, 0, 0.3) !important;
    }

    /* Draggable external event badges */
    .external-event {
        cursor: grab;
        padding: 0.65rem 0.9rem;
        margin-bottom: 0.55rem;
        border-radius: 0.65rem;
        font-weight: 600;
        font-size: 0.88rem;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        transition: transform 0.18s ease, box-shadow 0.18s ease;
        display: flex;
        align-items: center;
        justify-content: space-between;
        user-select: none;
    }
    .external-event:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .external-event:active {
        cursor: grabbing;
    }

    /* Color picker circles */
    .color-swatch-list {
        display: flex;
        gap: 0.5rem;
        list-style: none;
        padding: 0;
        margin: 0;
        flex-wrap: wrap;
    }
    .color-swatch-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 2px solid transparent;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.18s ease, border-color 0.18s ease;
    }
    .color-swatch-btn:hover {
        transform: scale(1.15);
    }
    .color-swatch-btn.active {
        border-color: #0f172a;
        box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.5);
    }
    .dark-mode .color-swatch-btn.active {
        border-color: #ffffff;
        box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.5);
    }

    /* FullCalendar Customizations & Modern Theme */
    #calendar {
        min-height: 680px;
    }
    .fc {
        font-family: inherit;
    }
    .fc .fc-toolbar {
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-bottom: 1.25rem !important;
    }
    .fc .fc-toolbar-title {
        font-size: 1.45rem !important;
        font-weight: 700 !important;
        color: #1e293b;
    }
    .dark-mode .fc .fc-toolbar-title {
        color: #f1f5f9;
    }
    .fc .fc-button {
        border-radius: 0.6rem !important;
        font-weight: 600 !important;
        font-size: 0.88rem !important;
        padding: 0.45rem 0.95rem !important;
        box-shadow: none !important;
        transition: all 0.2s ease !important;
    }
    .fc .fc-button-primary {
        background-color: #3b82f6 !important;
        border-color: #3b82f6 !important;
        color: #ffffff !important;
    }
    .fc .fc-button-primary:hover {
        background-color: #2563eb !important;
        border-color: #2563eb !important;
    }
    .fc .fc-button-primary:not(:disabled).fc-button-active,
    .fc .fc-button-primary:not(:disabled):active {
        background-color: #1d4ed8 !important;
        border-color: #1d4ed8 !important;
    }
    .fc-theme-standard th {
        border-color: #e2e8f0 !important;
        background-color: #f8fafc;
        padding: 0.75rem 0.5rem !important;
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #64748b;
    }
    .dark-mode .fc-theme-standard th {
        background-color: #0f172a !important;
        border-color: #334155 !important;
        color: #94a3b8 !important;
    }
    .fc-theme-standard td {
        border-color: #e2e8f0 !important;
    }
    .dark-mode .fc-theme-standard td {
        border-color: #334155 !important;
    }
    .dark-mode .fc .fc-daygrid-day-number {
        color: #cbd5e1;
    }
    .fc .fc-daygrid-day.fc-day-today {
        background-color: rgba(59, 130, 246, 0.08) !important;
    }
    .dark-mode .fc .fc-daygrid-day.fc-day-today {
        background-color: rgba(59, 130, 246, 0.16) !important;
    }

    /* Event pill modern look */
    .fc-event {
        border-radius: 6px !important;
        padding: 2px 5px !important;
        font-size: 0.82rem !important;
        font-weight: 600 !important;
        border: none !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.12) !important;
        transition: transform 0.15s ease, box-shadow 0.15s ease !important;
    }
    .fc-event:hover {
        transform: translateY(-1px) scale(1.01) !important;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.22) !important;
    }
    .fc-event-main {
        padding: 2px 3px;
        white-space: normal;
        line-height: 1.25;
    }

    /* Filter button pills */
    .filter-pill {
        border-radius: 9999px;
        padding: 0.35rem 0.85rem;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #475569;
    }
    .dark-mode .filter-pill {
        background: #1e293b;
        border-color: #334155;
        color: #cbd5e1;
    }
    .filter-pill:hover,
    .filter-pill.active {
        background: #3b82f6;
        border-color: #3b82f6;
        color: #ffffff;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.35);
    }

    /* Legend Dot */
    .legend-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 0.5rem;
    }
</style>

<div class="container-fluid py-3">

    <!-- Modern Executive Header -->
    <div class="calendar-page-header">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div>
                <div class="d-flex align-items-center mb-1">
                    <span class="mr-2 px-2 py-1 rounded text-white" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                        <i class="fas fa-calendar-alt"></i>
                    </span>
                    <h2 class="h4 font-weight-bold mb-0 text-dark dark:text-white">{{ __('Academic & Event Calendar') }}</h2>
                </div>
                <p class="text-muted small mb-0">{{ __('Comprehensive schedule of school milestones, exam dates, national holidays, and academic routines.') }}</p>
            </div>
            <div class="d-flex align-items-center flex-wrap gap-2">
                <button type="button" class="btn btn-primary rounded-pill px-3 shadow-sm" data-toggle="modal" data-target="#addEventModal">
                    <i class="fas fa-plus-circle mr-1"></i> {{ __('Add New Event') }}
                </button>
                <button type="button" class="btn btn-outline-secondary rounded-pill px-3" id="jumpTodayBtn">
                    <i class="fas fa-crosshairs mr-1"></i> {{ __('Jump to Today') }}
                </button>
            </div>
        </div>
    </div>

    <!-- 4 KPI Summary Cards -->
    <div class="row mb-4">
        <div class="col-sm-6 col-lg-3 mb-3 mb-lg-0">
            <div class="metric-card">
                <div class="metric-icon-wrap metric-icon-indigo">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div>
                    <div class="text-muted small font-weight-bold uppercase">{{ __('This Month') }}</div>
                    <div class="h3 font-weight-bold mb-0 text-dark dark:text-white" id="statMonthEvents">{{ $monthEventsCount ?? 0 }}</div>
                    <div class="text-muted small">{{ __('Scheduled events') }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3 mb-3 mb-lg-0">
            <div class="metric-card">
                <div class="metric-icon-wrap metric-icon-amber">
                    <i class="fas fa-pencil-alt"></i>
                </div>
                <div>
                    <div class="text-muted small font-weight-bold uppercase">{{ __('Upcoming Exams') }}</div>
                    <div class="h3 font-weight-bold mb-0 text-dark dark:text-white" id="statUpcomingExams">{{ $upcomingExamsCount ?? 0 }}</div>
                    <div class="text-muted small">{{ __('Assessments & tests') }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3 mb-3 mb-lg-0">
            <div class="metric-card">
                <div class="metric-icon-wrap metric-icon-emerald">
                    <i class="fas fa-umbrella-beach"></i>
                </div>
                <div>
                    <div class="text-muted small font-weight-bold uppercase">{{ __('Holidays & Days Off') }}</div>
                    <div class="h3 font-weight-bold mb-0 text-dark dark:text-white" id="statHolidays">{{ $holidaysCount ?? 0 }}</div>
                    <div class="text-muted small">{{ __('Official vacations') }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3 mb-3 mb-lg-0">
            <div class="metric-card">
                <div class="metric-icon-wrap metric-icon-sky">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div>
                    <div class="text-muted small font-weight-bold uppercase">{{ __('Total System Events') }}</div>
                    <div class="h3 font-weight-bold mb-0 text-dark dark:text-white" id="statTotalEvents">{{ $totalEventsCount ?? 0 }}</div>
                    <div class="text-muted small">{{ __('Full academic year') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Workspace (Sidebar + Interactive Calendar) -->
    <div class="row">
        <!-- Left Sidebar Controls -->
        <div class="col-xl-3 col-lg-4 mb-4">
            
            <!-- Quick Add Event Widget -->
            <div class="card modern-calendar-card mb-3">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h5 class="card-title font-weight-bold mb-0 text-dark dark:text-white">
                        <i class="fas fa-bolt text-warning mr-1"></i> {{ __('Quick Create Event') }}
                    </h5>
                </div>
                <div class="card-body">
                    <form id="quickEventForm">
                        <div class="form-group mb-2">
                            <label class="small font-weight-bold">{{ __('Event Title') }} <span class="text-danger">*</span></label>
                            <input id="quick-event-title" type="text" class="form-control form-control-sm rounded-lg" placeholder="{{ __('e.g. Faculty Meeting') }}" required>
                        </div>
                        <div class="form-group mb-2">
                            <label class="small font-weight-bold">{{ __('Category') }}</label>
                            <select id="quick-event-category" class="form-control form-control-sm rounded-lg">
                                <option value="activity">{{ __('School Activity') }}</option>
                                <option value="exam">{{ __('Exam') }}</option>
                                <option value="academic">{{ __('Academic Term') }}</option>
                                <option value="holiday">{{ __('Holiday') }}</option>
                                <option value="meeting">{{ __('Meeting') }}</option>
                                <option value="personal">{{ __('Personal Task') }}</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold d-block">{{ __('Pick Badge Color') }}</label>
                            <ul class="color-swatch-list" id="quickColorChooser">
                                <li><span class="color-swatch-btn active" data-color="#3b82f6" style="background-color: #3b82f6;" title="{{ __('Blue') }}"><i class="fas fa-check text-white small"></i></span></li>
                                <li><span class="color-swatch-btn" data-color="#10b981" style="background-color: #10b981;" title="{{ __('Emerald') }}"></span></li>
                                <li><span class="color-swatch-btn" data-color="#f59e0b" style="background-color: #f59e0b;" title="{{ __('Amber') }}"></span></li>
                                <li><span class="color-swatch-btn" data-color="#ef4444" style="background-color: #ef4444;" title="{{ __('Crimson') }}"></span></li>
                                <li><span class="color-swatch-btn" data-color="#8b5cf6" style="background-color: #8b5cf6;" title="{{ __('Purple') }}"></span></li>
                                <li><span class="color-swatch-btn" data-color="#06b6d4" style="background-color: #06b6d4;" title="{{ __('Cyan') }}"></span></li>
                            </ul>
                        </div>
                        <button id="btnQuickAddEvent" type="submit" class="btn btn-primary btn-sm btn-block rounded-pill font-weight-bold">
                            <i class="fas fa-plus mr-1"></i> {{ __('Add to Draggable') }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Draggable Events Card -->
            <div class="card modern-calendar-card mb-3">
                <div class="card-header bg-transparent border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title font-weight-bold mb-0 text-dark dark:text-white">
                        <i class="fas fa-hand-pointer text-primary mr-1"></i> {{ __('Draggable Events') }}
                    </h5>
                    <span class="badge badge-light border text-muted small">{{ __('Drag onto Calendar') }}</span>
                </div>
                <div class="card-body">
                    <p class="small text-muted mb-2">{{ __('Drag these badges directly onto any date on the calendar grid.') }}</p>
                    <div id="external-events">
                        <div class="external-event text-white" style="background-color: #3b82f6;" data-category="meeting" data-color="#3b82f6">
                            <span><i class="fas fa-users mr-1"></i> {{ __('Parent-Teacher Meeting') }}</span>
                            <i class="fas fa-grip-vertical opacity-75"></i>
                        </div>
                        <div class="external-event text-white" style="background-color: #10b981;" data-category="activity" data-color="#10b981">
                            <span><i class="fas fa-running mr-1"></i> {{ __('School Sports Day') }}</span>
                            <i class="fas fa-grip-vertical opacity-75"></i>
                        </div>
                        <div class="external-event text-white" style="background-color: #f59e0b;" data-category="exam" data-color="#f59e0b">
                            <span><i class="fas fa-book-reader mr-1"></i> {{ __('Exam Revision Week') }}</span>
                            <i class="fas fa-grip-vertical opacity-75"></i>
                        </div>
                        <div class="external-event text-white" style="background-color: #8b5cf6;" data-category="academic" data-color="#8b5cf6">
                            <span><i class="fas fa-graduation-cap mr-1"></i> {{ __('Homework / Project Due') }}</span>
                            <i class="fas fa-grip-vertical opacity-75"></i>
                        </div>
                        <div class="external-event text-white" style="background-color: #06b6d4;" data-category="meeting" data-color="#06b6d4">
                            <span><i class="fas fa-chalkboard-teacher mr-1"></i> {{ __('Faculty Briefing') }}</span>
                            <i class="fas fa-grip-vertical opacity-75"></i>
                        </div>
                    </div>
                    
                    <div class="custom-control custom-checkbox mt-3">
                        <input type="checkbox" class="custom-control-input" id="drop-remove">
                        <label class="custom-control-label small text-muted" for="drop-remove">{{ __('Remove after drop') }}</label>
                    </div>
                </div>
            </div>

            <!-- Category Legend -->
            <div class="card modern-calendar-card">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h5 class="card-title font-weight-bold mb-0 text-dark dark:text-white">
                        <i class="fas fa-palette text-info mr-1"></i> {{ __('Calendar Legend') }}
                    </h5>
                </div>
                <div class="card-body p-3">
                    <ul class="list-unstyled mb-0 small">
                        <li class="mb-2 d-flex align-items-center">
                            <span class="legend-dot" style="background-color: #ef4444;"></span>
                            <span class="font-weight-600 text-dark dark:text-white">{{ __('Examinations') }}</span>
                            <span class="text-muted ml-auto">#ef4444</span>
                        </li>
                        <li class="mb-2 d-flex align-items-center">
                            <span class="legend-dot" style="background-color: #10b981;"></span>
                            <span class="font-weight-600 text-dark dark:text-white">{{ __('Public Holidays & Off Days') }}</span>
                            <span class="text-muted ml-auto">#10b981</span>
                        </li>
                        <li class="mb-2 d-flex align-items-center">
                            <span class="legend-dot" style="background-color: #6366f1;"></span>
                            <span class="font-weight-600 text-dark dark:text-white">{{ __('Academic Sessions & Terms') }}</span>
                            <span class="text-muted ml-auto">#6366f1</span>
                        </li>
                        <li class="mb-2 d-flex align-items-center">
                            <span class="legend-dot" style="background-color: #3b82f6;"></span>
                            <span class="font-weight-600 text-dark dark:text-white">{{ __('School Activities & Events') }}</span>
                            <span class="text-muted ml-auto">#3b82f6</span>
                        </li>
                        <li class="d-flex align-items-center">
                            <span class="legend-dot" style="background-color: #0ea5e9;"></span>
                            <span class="font-weight-600 text-dark dark:text-white">{{ __('Meetings & Conferences') }}</span>
                            <span class="text-muted ml-auto">#0ea5e9</span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>

        <!-- Right Main FullCalendar Area -->
        <div class="col-xl-9 col-lg-8">
            <div class="card modern-calendar-card">
                <!-- Toolbar & Filter Header -->
                <div class="card-header bg-transparent border-bottom py-3 d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div class="d-flex align-items-center flex-wrap gap-1">
                        <span class="font-weight-bold text-muted small mr-2">{{ __('Filter View:') }}</span>
                        <button type="button" class="filter-pill active" data-filter="all">{{ __('All Events') }}</button>
                        <button type="button" class="filter-pill" data-filter="exam">{{ __('Exams') }}</button>
                        <button type="button" class="filter-pill" data-filter="holiday">{{ __('Holidays') }}</button>
                        <button type="button" class="filter-pill" data-filter="academic">{{ __('Academic') }}</button>
                        <button type="button" class="filter-pill" data-filter="meeting">{{ __('Meetings') }}</button>
                        <button type="button" class="filter-pill" data-filter="activity">{{ __('Activities') }}</button>
                    </div>
                    <div class="text-muted small">
                        <i class="fas fa-info-circle text-primary mr-1"></i> {{ __('Click any date or time slot to add an event.') }}
                    </div>
                </div>

                <!-- Calendar Viewport -->
                <div class="card-body p-3">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- =========================================================================
     MODAL 1: ADD EVENT MODAL
     ========================================================================= -->
<div class="modal fade" id="addEventModal" tabindex="-1" role="dialog" aria-labelledby="addEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1rem;">
            <div class="modal-header bg-primary text-white" style="border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                <h5 class="modal-title font-weight-bold" id="addEventModalLabel">
                    <i class="fas fa-calendar-plus mr-1"></i> {{ __('Create New Calendar Event') }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="{{ __('Close') }}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addEventForm">
                @csrf
                <div class="modal-body p-4">
                    <div class="form-group">
                        <label class="font-weight-bold small text-dark dark:text-white">{{ __('Event Title') }} <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="modalEventTitle" class="form-control rounded-lg" placeholder="{{ __('e.g. Science Fair Presentation') }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold small text-dark dark:text-white">{{ __('Category') }}</label>
                            <select name="category" id="modalEventCategory" class="form-control rounded-lg">
                                <option value="activity">{{ __('School Activity') }}</option>
                                <option value="exam">{{ __('Exam') }}</option>
                                <option value="academic">{{ __('Academic Session') }}</option>
                                <option value="holiday">{{ __('Holiday') }}</option>
                                <option value="meeting">{{ __('Meeting') }}</option>
                                <option value="personal">{{ __('Personal Task') }}</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold small text-dark dark:text-white d-block">{{ __('Theme Color') }}</label>
                            <input type="hidden" name="bg_color" id="modalEventColor" value="#3b82f6">
                            <ul class="color-swatch-list mt-1" id="modalColorChooser">
                                <li><span class="color-swatch-btn active" data-color="#3b82f6" style="background-color: #3b82f6;"><i class="fas fa-check text-white small"></i></span></li>
                                <li><span class="color-swatch-btn" data-color="#10b981" style="background-color: #10b981;"></span></li>
                                <li><span class="color-swatch-btn" data-color="#f59e0b" style="background-color: #f59e0b;"></span></li>
                                <li><span class="color-swatch-btn" data-color="#ef4444" style="background-color: #ef4444;"></span></li>
                                <li><span class="color-swatch-btn" data-color="#8b5cf6" style="background-color: #8b5cf6;"></span></li>
                                <li><span class="color-swatch-btn" data-color="#06b6d4" style="background-color: #06b6d4;"></span></li>
                            </ul>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold small text-dark dark:text-white">{{ __('Start Date / Time') }} <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="start_date" id="modalEventStart" class="form-control rounded-lg" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold small text-dark dark:text-white">{{ __('End Date / Time (Optional)') }}</label>
                            <input type="datetime-local" name="end_date" id="modalEventEnd" class="form-control rounded-lg">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="modalEventAllDay" name="all_day" value="1" checked>
                            <label class="custom-control-label font-weight-bold small" for="modalEventAllDay">{{ __('All Day Event') }}</label>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <label class="font-weight-bold small text-dark dark:text-white">{{ __('Description & Notes') }}</label>
                        <textarea name="description" id="modalEventDesc" class="form-control rounded-lg" rows="3" placeholder="{{ __('Optional details or instructions...') }}"></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3" style="border-bottom-left-radius: 1rem; border-bottom-right-radius: 1rem;">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 font-weight-bold" id="btnSubmitAddEvent">
                        <i class="fas fa-check mr-1"></i> {{ __('Save Event') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- =========================================================================
     MODAL 2: VIEW & EDIT EVENT MODAL
     ========================================================================= -->
<div class="modal fade" id="viewEventModal" tabindex="-1" role="dialog" aria-labelledby="viewEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1rem;">
            <div class="modal-header text-white" id="viewModalHeader" style="border-top-left-radius: 1rem; border-top-right-radius: 1rem; background-color: #3b82f6;">
                <div class="d-flex align-items-center">
                    <span class="badge badge-light mr-2 font-weight-bold uppercase" id="viewModalCategoryBadge">Event</span>
                    <h5 class="modal-title font-weight-bold mb-0 text-white" id="viewModalTitle">{{ __('Event Details') }}</h5>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="{{ __('Close') }}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="small text-muted font-weight-bold uppercase">{{ __('Schedule') }}</label>
                    <div class="d-flex align-items-center text-dark dark:text-white font-weight-bold">
                        <i class="far fa-clock text-primary mr-2"></i>
                        <span id="viewModalDateText">--</span>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="small text-muted font-weight-bold uppercase">{{ __('Details & Notes') }}</label>
                    <p class="text-dark dark:text-white mb-0" id="viewModalDesc" style="white-space: pre-wrap;">{{ __('No description provided.') }}</p>
                </div>

                <div id="viewSystemNotice" class="alert alert-info py-2 px-3 small d-none">
                    <i class="fas fa-lock mr-1"></i> {{ __('This is an official system schedule (examination or academic term) and is managed automatically.') }}
                </div>
            </div>
            <div class="modal-footer bg-light border-0 py-3" style="border-bottom-left-radius: 1rem; border-bottom-right-radius: 1rem;">
                <button type="button" class="btn btn-outline-danger rounded-pill px-3 mr-auto d-none" id="btnDeleteEvent">
                    <i class="fas fa-trash-alt mr-1"></i> {{ __('Delete') }}
                </button>
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal">{{ __('Close') }}</button>
            </div>
        </div>
    </div>
</div>

<!-- FullCalendar JavaScript & Localization Files -->
<script src="/assets/plugins/fullcalendar/main.min.js"></script>
@if (app()->getLocale() === 'km')
<script src="/assets/plugins/fullcalendar/locales/km.js"></script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var currentLocale = "{{ app()->getLocale() === 'km' ? 'km' : 'en' }}";
        var csrfToken = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '{{ csrf_token() }}';

        // Elements
        var calendarEl = document.getElementById('calendar');
        var containerEl = document.getElementById('external-events');
        var checkbox = document.getElementById('drop-remove');
        var activeFilter = 'all';
        var currentSelectedEvent = null;

        // Initialize External Draggable Items
        var Draggable = FullCalendar.Draggable;
        new Draggable(containerEl, {
            itemSelector: '.external-event',
            eventData: function(eventEl) {
                var title = eventEl.innerText.trim();
                var color = eventEl.getAttribute('data-color') || '#3b82f6';
                var category = eventEl.getAttribute('data-category') || 'activity';
                return {
                    title: title,
                    backgroundColor: color,
                    borderColor: color,
                    textColor: '#ffffff',
                    extendedProps: {
                        category: category,
                        description: '',
                        is_system: false,
                        can_edit: true
                    }
                };
            }
        });

        // Initialize Calendar
        var calendar = new FullCalendar.Calendar(calendarEl, {
            themeSystem: 'standard',
            locale: currentLocale,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            buttonText: currentLocale === 'km' ? {
                today: 'ថ្ងៃនេះ',
                month: 'ខែ',
                week: 'សប្តាហ៍',
                day: 'ថ្ងៃ',
                list: 'បញ្ជី'
            } : {
                today: 'Today',
                month: 'Month',
                week: 'Week',
                day: 'Day',
                list: 'List'
            },
            initialView: 'dayGridMonth',
            navLinks: true,
            editable: true,
            droppable: true,
            dayMaxEvents: true, // "more" link when too many events
            events: '/calendar/events',

            // Event Filtering
            eventDidMount: function(info) {
                var category = (info.event.extendedProps && info.event.extendedProps.category) ? info.event.extendedProps.category : 'activity';
                if (activeFilter !== 'all' && category !== activeFilter) {
                    info.el.style.display = 'none';
                } else {
                    info.el.style.display = '';
                }
            },

            // Click Date Grid to Add Event
            dateClick: function(info) {
                var dateStr = info.dateStr;
                // If it's a date only (e.g. "2026-11-10"), append time
                var startVal = dateStr.length === 10 ? dateStr + 'T09:00' : dateStr;
                var endVal = dateStr.length === 10 ? dateStr + 'T17:00' : dateStr;

                document.getElementById('addEventForm').reset();
                document.getElementById('modalEventStart').value = startVal;
                document.getElementById('modalEventEnd').value = endVal;
                document.getElementById('modalEventAllDay').checked = (info.dateStr.length === 10);
                
                $('#addEventModal').modal('show');
            },

            // Click Existing Event to View / Delete
            eventClick: function(info) {
                info.jsEvent.preventDefault();
                currentSelectedEvent = info.event;
                var props = info.event.extendedProps || {};

                // Header styling & category
                var modalHeader = document.getElementById('viewModalHeader');
                var categoryBadge = document.getElementById('viewModalCategoryBadge');
                modalHeader.style.backgroundColor = info.event.backgroundColor || '#3b82f6';
                categoryBadge.innerText = (props.category || 'Event').toUpperCase();

                // Title
                document.getElementById('viewModalTitle').innerText = info.event.title;

                // Dates
                var dateStr = '';
                if (info.event.start) {
                    dateStr = info.event.start.toLocaleDateString(currentLocale === 'km' ? 'km-KH' : 'en-US', {
                        year: 'numeric', month: 'short', day: 'numeric',
                        hour: info.event.allDay ? undefined : '2-digit',
                        minute: info.event.allDay ? undefined : '2-digit'
                    });
                }
                if (info.event.end) {
                    dateStr += ' – ' + info.event.end.toLocaleDateString(currentLocale === 'km' ? 'km-KH' : 'en-US', {
                        year: 'numeric', month: 'short', day: 'numeric',
                        hour: info.event.allDay ? undefined : '2-digit',
                        minute: info.event.allDay ? undefined : '2-digit'
                    });
                }
                document.getElementById('viewModalDateText').innerText = dateStr;

                // Description
                var descEl = document.getElementById('viewModalDesc');
                descEl.innerText = props.description ? props.description : '{{ __("No description provided.") }}';

                // System event lock notice
                var noticeEl = document.getElementById('viewSystemNotice');
                var deleteBtn = document.getElementById('btnDeleteEvent');

                if (props.is_system) {
                    noticeEl.classList.remove('d-none');
                    deleteBtn.classList.add('d-none');
                } else {
                    noticeEl.classList.add('d-none');
                    deleteBtn.classList.remove('d-none');
                }

                $('#viewEventModal').modal('show');
            },

            // Dragged and Dropped onto Calendar from External list
            drop: function(info) {
                if (checkbox && checkbox.checked) {
                    info.draggedEl.parentNode.removeChild(info.draggedEl);
                }

                var title = info.draggedEl.innerText.trim();
                var color = info.draggedEl.getAttribute('data-color') || '#3b82f6';
                var category = info.draggedEl.getAttribute('data-category') || 'activity';
                var dateStr = info.dateStr;

                // Persist dropped event to backend
                $.ajax({
                    url: '/calendar/events',
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                    data: {
                        title: title,
                        category: category,
                        start_date: dateStr,
                        all_day: true,
                        bg_color: color
                    },
                    success: function(resp) {
                        if (resp.success) {
                            calendar.refetchEvents();
                            if (window.toastr) {
                                toastr.success('{{ __("Event placed on calendar successfully.") }}');
                            }
                        }
                    },
                    error: function() {
                        if (window.toastr) {
                            toastr.error('{{ __("Failed to save event.") }}');
                        }
                    }
                });
            },

            // Moving an Event on the Calendar
            eventDrop: function(info) {
                var props = info.event.extendedProps || {};
                if (props.is_system) {
                    info.revert();
                    if (window.toastr) {
                        toastr.warning('{{ __("System events (exams/terms) cannot be rescheduled here.") }}');
                    }
                    return;
                }

                var eventId = info.event.id;
                var newStart = info.event.start ? info.event.start.toISOString() : null;
                var newEnd = info.event.end ? info.event.end.toISOString() : null;

                $.ajax({
                    url: '/calendar/events/' + eventId,
                    method: 'PUT',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                    data: {
                        start_date: newStart,
                        end_date: newEnd,
                        all_day: info.event.allDay
                    },
                    success: function() {
                        if (window.toastr) {
                            toastr.success('{{ __("Event schedule updated.") }}');
                        }
                    },
                    error: function() {
                        info.revert();
                        if (window.toastr) {
                            toastr.error('{{ __("Failed to update event schedule.") }}');
                        }
                    }
                });
            },

            // Resizing an Event
            eventResize: function(info) {
                var props = info.event.extendedProps || {};
                if (props.is_system) {
                    info.revert();
                    return;
                }

                var eventId = info.event.id;
                var newStart = info.event.start ? info.event.start.toISOString() : null;
                var newEnd = info.event.end ? info.event.end.toISOString() : null;

                $.ajax({
                    url: '/calendar/events/' + eventId,
                    method: 'PUT',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                    data: {
                        start_date: newStart,
                        end_date: newEnd,
                        all_day: info.event.allDay
                    },
                    success: function() {
                        if (window.toastr) {
                            toastr.success('{{ __("Event duration updated.") }}');
                        }
                    },
                    error: function() {
                        info.revert();
                        if (window.toastr) {
                            toastr.error('{{ __("Failed to resize event.") }}');
                        }
                    }
                });
            }
        });

        calendar.render();

        // Jump to Today button
        document.getElementById('jumpTodayBtn').addEventListener('click', function () {
            calendar.today();
        });

        // Category Filter Pills
        document.querySelectorAll('.filter-pill').forEach(function(pill) {
            pill.addEventListener('click', function () {
                document.querySelectorAll('.filter-pill').forEach(function(p) { p.classList.remove('active'); });
                this.classList.add('active');
                activeFilter = this.getAttribute('data-filter');
                calendar.render(); // Triggers eventDidMount
            });
        });

        // Color Swatches in Quick Add
        var quickColor = '#3b82f6';
        $('#quickColorChooser .color-swatch-btn').click(function () {
            $('#quickColorChooser .color-swatch-btn').removeClass('active').html('');
            $(this).addClass('active').html('<i class="fas fa-check text-white small"></i>');
            quickColor = $(this).attr('data-color');
        });

        // Color Swatches in Modal
        $('#modalColorChooser .color-swatch-btn').click(function () {
            $('#modalColorChooser .color-swatch-btn').removeClass('active').html('');
            $(this).addClass('active').html('<i class="fas fa-check text-white small"></i>');
            var col = $(this).attr('data-color');
            $('#modalEventColor').val(col);
        });

        // Quick Create Form Submit (adds to Draggable external items)
        $('#quickEventForm').on('submit', function (e) {
            e.preventDefault();
            var title = $('#quick-event-title').val().trim();
            var category = $('#quick-event-category').val();
            if (!title) return;

            var newEl = $('<div></div>')
                .addClass('external-event text-white')
                .css('background-color', quickColor)
                .attr('data-color', quickColor)
                .attr('data-category', category)
                .html('<span><i class="fas fa-tag mr-1"></i> ' + $('<div>').text(title).html() + '</span><i class="fas fa-grip-vertical opacity-75"></i>');

            $('#external-events').prepend(newEl);
            $('#quick-event-title').val('');

            if (window.toastr) {
                toastr.success('{{ __("Quick badge added. You can now drag it onto the calendar.") }}');
            }
        });

        // Modal Form Submit (Creates DB event)
        $('#addEventForm').on('submit', function (e) {
            e.preventDefault();
            var submitBtn = $('#btnSubmitAddEvent');
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> {{ __("Saving...") }}');

            var formData = $(this).serialize();

            $.ajax({
                url: '/calendar/events',
                method: 'POST',
                data: formData,
                success: function (resp) {
                    submitBtn.prop('disabled', false).html('<i class="fas fa-check mr-1"></i> {{ __("Save Event") }}');
                    if (resp.success) {
                        $('#addEventModal').modal('hide');
                        calendar.refetchEvents();
                        if (window.toastr) {
                            toastr.success(resp.message || '{{ __("Event created successfully.") }}');
                        }
                    }
                },
                error: function (xhr) {
                    submitBtn.prop('disabled', false).html('<i class="fas fa-check mr-1"></i> {{ __("Save Event") }}');
                    var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : '{{ __("Error creating event.") }}';
                    if (window.toastr) {
                        toastr.error(msg);
                    }
                }
            });
        });

        // Delete Event Action
        $('#btnDeleteEvent').click(function () {
            if (!currentSelectedEvent) return;
            if (!confirm('{{ __("Are you sure you want to delete this event?") }}')) return;

            var eventId = currentSelectedEvent.id;

            $.ajax({
                url: '/calendar/events/' + eventId,
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                success: function (resp) {
                    $('#viewEventModal').modal('hide');
                    currentSelectedEvent.remove();
                    if (window.toastr) {
                        toastr.success(resp.message || '{{ __("Event deleted successfully.") }}');
                    }
                },
                error: function () {
                    if (window.toastr) {
                        toastr.error('{{ __("Failed to delete event.") }}');
                    }
                }
            });
        });
    });
</script>
@endsection
