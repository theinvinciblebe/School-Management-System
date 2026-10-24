@extends('layout.main')

@section('content')

    <style>
        /* =========================================================
           Attendance Management & Reporting System Styles
           ========================================================= */
        .atd-card {
            border-radius: 14px;
            border: 1px solid rgba(0, 0, 0, 0.06);
            background-color: #ffffff;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
            transition: all 0.25s ease;
        }

        /* Metric KPI Summary Cards */
        .metric-card {
            border-radius: 12px;
            padding: 16px 18px;
            background: #ffffff;
            border: 1px solid #e9ecef;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .metric-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.06);
        }
        .metric-icon-wrap {
            width: 46px;
            height: 46px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }
        .metric-value {
            font-size: 1.6rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 2px;
        }
        .metric-label {
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            color: #6c757d;
        }

        /* Modern Mode Switcher Pills */
        .view-mode-tabs .nav-link {
            border-radius: 10px;
            padding: 9px 18px;
            font-weight: 700;
            font-size: 0.9rem;
            color: #495057;
            border: 1px solid transparent;
            transition: all 0.2s ease;
        }
        .view-mode-tabs .nav-link:hover {
            background-color: #f1f5f9;
            color: #007bff;
        }
        .view-mode-tabs .nav-link.active {
            background-color: #007bff;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.35);
        }

        /* Section Tabs */
        .section-nav-pills .nav-link {
            border-radius: 8px;
            padding: 8px 16px;
            font-weight: 600;
            font-size: 0.85rem;
            color: #495057;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            margin-right: 8px;
            margin-bottom: 6px;
            transition: all 0.2s ease;
        }
        .section-nav-pills .nav-link:hover {
            background: #e2e8f0;
            color: #007bff;
        }
        .section-nav-pills .nav-link.active {
            background: #007bff;
            color: #ffffff;
            border-color: #007bff;
            box-shadow: 0 3px 8px rgba(0, 123, 255, 0.3);
        }

        /* Interactive Status Segmented Button Group */
        .status-pill-group {
            display: inline-flex;
            border-radius: 8px;
            background-color: #f1f5f9;
            padding: 3px;
            gap: 2px;
            border: 1px solid #e2e8f0;
        }
        .status-btn {
            border: none;
            background: transparent;
            padding: 5px 11px;
            font-size: 0.8rem;
            font-weight: 600;
            border-radius: 6px;
            color: #64748b;
            cursor: pointer;
            transition: all 0.18s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .status-btn:hover {
            background-color: rgba(255, 255, 255, 0.7);
            color: #1e293b;
        }

        /* Active Selected Status Button Styles */
        .status-btn.active-present {
            background-color: #22c55e !important;
            color: #ffffff !important;
            box-shadow: 0 2px 6px rgba(34, 197, 94, 0.35);
        }
        .status-btn.active-absent {
            background-color: #ef4444 !important;
            color: #ffffff !important;
            box-shadow: 0 2px 6px rgba(239, 68, 68, 0.35);
        }
        .status-btn.active-late {
            background-color: #f59e0b !important;
            color: #ffffff !important;
            box-shadow: 0 2px 6px rgba(245, 158, 11, 0.35);
        }
        .status-btn.active-medical {
            background-color: #06b6d4 !important;
            color: #ffffff !important;
            box-shadow: 0 2px 6px rgba(6, 182, 212, 0.35);
        }
        .status-btn.active-undefined {
            background-color: #94a3b8 !important;
            color: #ffffff !important;
        }

        /* Student Row Styling */
        .student-table th {
            background-color: #f8fafc;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 700;
            color: #475569;
            border-top: none;
            vertical-align: middle;
            padding: 12px 14px;
        }
        .student-table td {
            vertical-align: middle;
            padding: 10px 14px;
            border-color: #f1f5f9;
        }
        .student-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            background: #e2e8f0;
            border: 2px solid #ffffff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.08);
        }
        .roll-badge {
            background-color: #e0f2fe;
            color: #0369a1;
            font-weight: 700;
            padding: 4px 9px;
            border-radius: 6px;
            font-size: 0.8rem;
        }

        /* Printable Sheet Styling (Preview & Physical Print) */
        .report-paper {
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }
        .report-header-divider {
            height: 3px;
            background: linear-gradient(90deg, #007bff 0%, #38bdf8 100%);
            border-radius: 2px;
            margin: 12px 0 20px 0;
        }

        /* Loading Overlay */
        .atd-loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(3px);
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            transition: opacity 0.2s ease;
        }

        /* Date Stepper Buttons */
        .date-nav-btn {
            border: 1px solid #ced4da;
            background: #f8fafc;
            color: #495057;
            padding: 6px 12px;
            transition: all 0.2s ease;
        }
        .date-nav-btn:hover {
            background: #e2e8f0;
            color: #007bff;
        }

        /* =========================================================
           Dark Mode Overrides
           ========================================================= */
        .dark-mode .atd-card,
        .dark-mode .report-paper,
        .dark-mode .metric-card {
            background-color: #343a40 !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
            color: #f8f9fa !important;
        }
        .dark-mode .metric-label {
            color: #94a3b8 !important;
        }
        .dark-mode .view-mode-tabs .nav-link {
            color: #cbd5e1;
        }
        .dark-mode .view-mode-tabs .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.08);
            color: #60a5fa;
        }
        .dark-mode .view-mode-tabs .nav-link.active {
            background-color: #007bff !important;
            color: #ffffff !important;
        }
        .dark-mode .section-nav-pills .nav-link {
            background: #2b3035 !important;
            border-color: #4b545c !important;
            color: #cbd5e1 !important;
        }
        .dark-mode .section-nav-pills .nav-link:hover {
            background: #3e444a !important;
            color: #60a5fa !important;
        }
        .dark-mode .section-nav-pills .nav-link.active {
            background: #007bff !important;
            color: #ffffff !important;
            border-color: #007bff !important;
        }
        .dark-mode .status-pill-group {
            background-color: #23272b !important;
            border-color: #3e444a !important;
        }
        .dark-mode .status-btn {
            color: #94a3b8;
        }
        .dark-mode .status-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }
        .dark-mode .student-table th {
            background-color: #2b3035 !important;
            color: #cbd5e1 !important;
        }
        .dark-mode .student-table td {
            border-color: rgba(255, 255, 255, 0.06) !important;
            color: #f1f5f9 !important;
        }
        .dark-mode .roll-badge {
            background-color: rgba(0, 123, 255, 0.15);
            color: #7dd3fc;
        }
        .dark-mode .atd-loading-overlay {
            background: rgba(35, 39, 43, 0.8) !important;
        }
        .dark-mode .date-nav-btn {
            background: #2b3035;
            border-color: #4b545c;
            color: #cbd5e1;
        }
        .dark-mode .date-nav-btn:hover {
            background: #3e444a;
            color: #ffffff;
        }
        .dark-mode .form-control {
            background-color: #2c3238 !important;
            border-color: #4b545c !important;
            color: #ffffff !important;
        }
        .dark-mode .form-control:focus {
            background-color: #2c3238 !important;
            border-color: #007bff !important;
            color: #ffffff !important;
        }
        .dark-mode .input-group-text {
            background-color: #2b3035 !important;
            border-color: #4b545c !important;
            color: #94a3b8 !important;
        }
        .dark-mode .bg-light {
            background-color: #2b3035 !important;
            border-color: #4b545c !important;
        }
        .dark-mode .text-dark {
            color: #f1f5f9 !important;
        }
        .dark-mode .border {
            border-color: #4b545c !important;
        }
        .dark-mode #report-students-table {
            color: #f8f9fa !important;
            background-color: #2b3035 !important;
        }
        .dark-mode #report-students-table th {
            background-color: #1e2227 !important;
            border-color: #4b545c !important;
            color: #f8f9fa !important;
        }
        .dark-mode #report-students-table td {
            border-color: rgba(255, 255, 255, 0.08) !important;
            color: #e2e8f0 !important;
        }
        .dark-mode #report-students-table tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.02) !important;
        }
        .dark-mode #report-students-table tr:nth-child(odd) {
            background-color: rgba(0, 0, 0, 0.15) !important;
        }
        .dark-mode .modal-content {
            background-color: #343a40 !important;
            color: #f8f9fa !important;
        }
        .dark-mode .modal-footer {
            background-color: #2b3035 !important;
            border-top-color: #4b545c !important;
        }

        /* Print Media Styles */
        @media print {
            body {
                background: #ffffff !important;
                color: #000000 !important;
            }
            .main-sidebar, .main-header, .content-header, .no-print, .atd-control-card, .view-mode-tabs, .btn, .nav {
                display: none !important;
            }
            .content-wrapper {
                margin: 0 !important;
                padding: 0 !important;
                background: #ffffff !important;
            }
            .report-paper {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
            }
            .print-only {
                display: block !important;
            }
        }
        @media screen {
            .print-only {
                display: none !important;
            }
        }
    </style>

    <!-- Page Header & Action Bar -->
    <div class="content-header p-0 pt-2 pb-3 no-print">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
            <div>
                <h2 class="m-0 font-weight-bold text-dark">
                    <i class="fas fa-clipboard-check text-primary mr-2"></i> Attendance Management & Reporting
                </h2>
                <small class="text-muted">Take daily student attendance, review real-time analytics, and generate official audit reports</small>
            </div>
            <div class="d-flex align-items-center mt-2 mt-md-0">
                <ol class="breadcrumb m-0 bg-transparent p-0 mr-3 d-none d-lg-flex">
                    <li class="breadcrumb-item"><a href="/"><i class="fas fa-home mr-1"></i> Home</a></li>
                    <li class="breadcrumb-item active">Daily Attendance</li>
                </ol>

                @if (Auth::user()->role == 1)
                    <!-- Teacher Request Edit Button -->
                    <button type="button" id="request-edit-btn" class="btn btn-warning btn-sm font-weight-bold shadow-sm mr-2"
                            data-toggle="modal" data-target="#requestEditModal">
                        <i class="fas fa-key mr-1"></i> Request Edit
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm no-print" role="alert" style="border-radius: 10px;">
            <i class="fas fa-check-circle mr-2"></i> <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm no-print" role="alert" style="border-radius: 10px;">
            <i class="fas fa-exclamation-triangle mr-2"></i> <strong>Notice:</strong> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- 1. Selection & Context Control Card -->
    <div class="card atd-card atd-control-card mb-4 no-print">
        <div class="card-body p-3 p-md-4">
            <div class="row align-items-center">
                <!-- Class Selection -->
                <div class="col-lg-5 col-md-6 mb-3 mb-md-0">
                    <label for="classpicker" class="font-weight-bold text-dark mb-1">
                        <i class="fas fa-chalkboard text-primary mr-1"></i> Academic Class
                    </label>
                    @if($classes->isEmpty())
                        <div class="p-2 border rounded bg-light text-danger">
                            @if(Auth::user()->role == 1)
                                <i class="fas fa-info-circle mr-1"></i> You are not assigned to any classes.
                            @else
                                <i class="fas fa-info-circle mr-1"></i> No classes exist in the database.
                                <a href="{{ route('class.index') }}" class="btn btn-xs btn-primary ml-2">Add Class</a>
                            @endif
                        </div>
                    @else
                        <select id="classpicker" class="form-control font-weight-bold shadow-sm" style="border-radius: 8px;">
                            <option value="" disabled {{ !$selectedClass ? 'selected' : '' }}>-- Choose Academic Class --</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->class_id }}" {{ $class->class_id == $selectedClass ? 'selected' : '' }}>
                                    {{ $class->name }} (Class #{{ $class->class_id }})
                                </option>
                            @endforeach
                        </select>
                    @endif
                </div>

                <!-- Date Navigation & Picker -->
                <div class="col-lg-5 col-md-6 mb-3 mb-md-0">
                    <label for="date_picker" class="font-weight-bold text-dark mb-1">
                        <i class="far fa-calendar-alt text-primary mr-1"></i> Attendance Date
                    </label>
                    <div class="input-group shadow-sm" style="border-radius: 8px; overflow: hidden;">
                        <div class="input-group-prepend">
                            <button type="button" class="btn date-nav-btn" id="prev-date-btn" title="Previous Day">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                        </div>
                        <input type="date" id="date_picker" name="date" class="form-control text-center font-weight-bold"
                               value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                        <div class="input-group-append">
                            <button type="button" class="btn date-nav-btn" id="next-date-btn" title="Next Day">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                            <button type="button" class="btn btn-primary" id="today-btn" title="Set to Today" style="font-size: 0.85rem; font-weight: bold;">
                                Today
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Live Status & Mode Indicator -->
                <div class="col-lg-2 col-md-12 text-center text-lg-right mt-2 mt-lg-0">
                    <div class="small font-weight-bold text-muted mb-1">Status on Date</div>
                    <span id="global-attendance-badge" class="badge badge-secondary px-3 py-2" style="border-radius: 20px; font-size: 0.85rem;">
                        <i class="fas fa-circle-notch fa-spin mr-1"></i> Checking...
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Live KPI Metrics & Reporting Overview Cards -->
    <div class="row mb-4 no-print" id="kpi-metrics-row">
        <div class="col-xl-2 col-lg-4 col-sm-6 mb-3">
            <div class="metric-card">
                <div>
                    <div class="metric-value text-primary" id="kpi-total">0</div>
                    <div class="metric-label">Total Enrolled</div>
                </div>
                <div class="metric-icon-wrap bg-light text-primary">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-4 col-sm-6 mb-3">
            <div class="metric-card">
                <div>
                    <div class="metric-value text-success" id="kpi-present">0</div>
                    <div class="metric-label">Present</div>
                </div>
                <div class="metric-icon-wrap" style="background-color: #dcfce7; color: #16a34a;">
                    <i class="fas fa-user-check"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-4 col-sm-6 mb-3">
            <div class="metric-card">
                <div>
                    <div class="metric-value text-danger" id="kpi-absent">0</div>
                    <div class="metric-label">Absent</div>
                </div>
                <div class="metric-icon-wrap" style="background-color: #fee2e2; color: #dc2626;">
                    <i class="fas fa-user-times"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-4 col-sm-6 mb-3">
            <div class="metric-card">
                <div>
                    <div class="metric-value text-warning" id="kpi-late">0</div>
                    <div class="metric-label">Late</div>
                </div>
                <div class="metric-icon-wrap" style="background-color: #fef3c7; color: #d97706;">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-4 col-sm-6 mb-3">
            <div class="metric-card">
                <div>
                    <div class="metric-value text-info" id="kpi-medical">0</div>
                    <div class="metric-label">Medical</div>
                </div>
                <div class="metric-icon-wrap" style="background-color: #cffafe; color: #0891b2;">
                    <i class="fas fa-notes-medical"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-4 col-sm-6 mb-3">
            <div class="metric-card">
                <div>
                    <div class="metric-value text-purple" id="kpi-rate" style="color: #7c3aed;">0%</div>
                    <div class="metric-label">Attendance Rate</div>
                </div>
                <div class="metric-icon-wrap" style="background-color: #f3e8ff; color: #7c3aed;">
                    <i class="fas fa-percentage"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Dual Mode Container: Live Marking vs Official Report Preview -->
    <div class="card atd-card position-relative mb-4">
        <!-- Interactive Header with Mode Toggle & Action Toolbar -->
        <div class="card-header bg-transparent border-bottom p-3 no-print">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                <!-- Mode Toggle Tabs -->
                <ul class="nav nav-pills view-mode-tabs mb-2 mb-md-0" id="mainAttendanceTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="mode-marking-tab" data-toggle="pill" href="#tab-marking" role="tab">
                            <i class="fas fa-edit mr-1"></i> Live Attendance Marking
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="mode-report-tab" data-toggle="pill" href="#tab-report" role="tab" onclick="loadReportingPreview()">
                            <i class="fas fa-file-invoice mr-1"></i> Daily Preview & Official Report
                        </a>
                    </li>
                </ul>

                <!-- Export & Print Action Toolbar -->
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <button type="button" class="btn btn-outline-primary btn-sm px-3 mr-2 font-weight-bold" onclick="printAttendanceReport()">
                        <i class="fas fa-print mr-1"></i> Print Sheet
                    </button>
                    <button type="button" class="btn btn-outline-success btn-sm px-3 mr-2 font-weight-bold" onclick="exportAttendanceCSV()">
                        <i class="fas fa-file-csv mr-1"></i> Export CSV
                    </button>
                    <a id="btn-download-pdf" href="#" class="btn btn-outline-danger btn-sm px-3 font-weight-bold">
                        <i class="fas fa-file-pdf mr-1"></i> Download PDF
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body p-3 p-md-4">
            <!-- Loading Overlay -->
            <div id="atd-spinner" class="atd-loading-overlay" style="display: none;">
                <div class="text-center">
                    <div class="spinner-border text-primary mb-2" style="width: 3rem; height: 3rem;" role="status"></div>
                    <div class="font-weight-bold text-dark">Updating Attendance Data...</div>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="tab-content" id="attendanceContent">

                <!-- TAB 1: Live Marking Mode -->
                <div class="tab-pane fade show active" id="tab-marking" role="tabpanel">

                    <!-- Section Navigation Pills Bar -->
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3">
                        <div>
                            <div class="small font-weight-bold text-muted mb-1 text-uppercase">Class Sections</div>
                            <ul class="nav nav-pills section-nav-pills" id="sections-tab-pills" role="tablist">
                                <!-- Populated dynamically via JS -->
                            </ul>
                        </div>

                        <!-- Fast Batch Marking Tools & Instant Filter -->
                        <div class="d-flex align-items-center mt-3 mt-md-0 flex-wrap">
                            <div class="input-group input-group-sm mr-2 mb-2 mb-sm-0" style="width: 200px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input type="text" id="student-search-input" class="form-control" placeholder="Search student...">
                            </div>

                            <button type="button" class="btn btn-sm btn-outline-success mr-1 font-weight-bold" onclick="bulkSetStatus(1)" title="Set all students to Present">
                                <i class="fas fa-check-double mr-1"></i> All Present
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger mr-1 font-weight-bold" onclick="bulkSetStatus(2)" title="Set all students to Absent">
                                <i class="fas fa-times-circle mr-1"></i> All Absent
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary font-weight-bold" onclick="bulkSetStatus(0)" title="Reset all statuses">
                                <i class="fas fa-undo mr-1"></i> Reset
                            </button>
                        </div>
                    </div>

                    <!-- Dynamic Sections Containers -->
                    <div class="tab-content" id="sections-tabContent">
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-layer-group fa-3x mb-3 text-secondary" style="opacity: 0.5;"></i>
                            <h5>Select an academic class and date above to load student attendance.</h5>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: Reporting & Audit Preview Hub -->
                <div class="tab-pane fade" id="tab-report" role="tabpanel">
                    <div class="report-paper" id="printable-report-area">

                        <!-- Formal Print/Preview School Header -->
                        <div class="text-center mb-3">
                            <h3 class="font-weight-bold text-dark m-0" id="rep-school-name">{{ config('app.name', 'School Management System') }}</h3>
                            <h5 class="text-primary font-weight-bold text-uppercase mt-1" style="letter-spacing: 0.5px;">Official Daily Attendance Report</h5>
                            <p class="text-muted small m-0" id="rep-meta-line">Attendance Audit & Verification Summary</p>
                            <div class="report-header-divider"></div>
                        </div>

                        <!-- Class & Date Details Box -->
                        <div class="card mb-4 border">
                            <div class="card-body p-3">
                                <div class="row text-center text-md-left">
                                    <div class="col-md-3 col-6 mb-2 mb-md-0">
                                        <small class="text-muted text-uppercase font-weight-bold">Academic Class</small>
                                        <div class="font-weight-bold text-dark h6 m-0" id="rep-class-name">-</div>
                                    </div>
                                    <div class="col-md-3 col-6 mb-2 mb-md-0">
                                        <small class="text-muted text-uppercase font-weight-bold">Selected Section</small>
                                        <div class="font-weight-bold text-dark h6 m-0" id="rep-section-name">All Sections</div>
                                    </div>
                                    <div class="col-md-3 col-6 mb-2 mb-md-0">
                                        <small class="text-muted text-uppercase font-weight-bold">Attendance Date</small>
                                        <div class="font-weight-bold text-dark h6 m-0" id="rep-date-display">-</div>
                                    </div>
                                    <div class="col-md-3 col-6 mb-2 mb-md-0">
                                        <small class="text-muted text-uppercase font-weight-bold">Overall Attendance Rate</small>
                                        <div class="font-weight-bold text-success h6 m-0" id="rep-rate-display">0%</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Report Summary Breakdown Bar -->
                        <div class="row mb-4 text-center">
                            <div class="col">
                                <div class="border rounded p-2 bg-light">
                                    <small class="text-muted text-uppercase font-weight-bold">Total Enrolled</small>
                                    <h4 class="font-weight-bold text-primary m-0" id="rep-stat-total">0</h4>
                                </div>
                            </div>
                            <div class="col">
                                <div class="border rounded p-2 bg-light">
                                    <small class="text-muted text-uppercase font-weight-bold">Present</small>
                                    <h4 class="font-weight-bold text-success m-0" id="rep-stat-present">0</h4>
                                </div>
                            </div>
                            <div class="col">
                                <div class="border rounded p-2 bg-light">
                                    <small class="text-muted text-uppercase font-weight-bold">Absent</small>
                                    <h4 class="font-weight-bold text-danger m-0" id="rep-stat-absent">0</h4>
                                </div>
                            </div>
                            <div class="col">
                                <div class="border rounded p-2 bg-light">
                                    <small class="text-muted text-uppercase font-weight-bold">Late</small>
                                    <h4 class="font-weight-bold text-warning m-0" id="rep-stat-late">0</h4>
                                </div>
                            </div>
                            <div class="col">
                                <div class="border rounded p-2 bg-light">
                                    <small class="text-muted text-uppercase font-weight-bold">Medical</small>
                                    <h4 class="font-weight-bold text-info m-0" id="rep-stat-medical">0</h4>
                                </div>
                            </div>
                        </div>

                        <!-- Filter & Section Selection Toolbar in Report -->
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 no-print">
                            <div class="d-flex align-items-center mb-2 mb-md-0">
                                <h6 class="font-weight-bold text-dark m-0 mr-3">Student Records</h6>
                                <div class="d-flex align-items-center">
                                    <label for="report-section-filter" class="small text-muted font-weight-bold mb-0 mr-2">Section:</label>
                                    <select id="report-section-filter" class="form-control form-control-sm font-weight-bold" style="width: auto; min-width: 150px; border-radius: 6px;" onchange="changeReportSection(this.value)">
                                        <option value="">All Sections</option>
                                    </select>
                                </div>
                            </div>
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-outline-secondary active" onclick="filterReportTable('all', this)">All</button>
                                <button type="button" class="btn btn-outline-success" onclick="filterReportTable('Present', this)">Present</button>
                                <button type="button" class="btn btn-outline-danger" onclick="filterReportTable('Absent', this)">Absent</button>
                                <button type="button" class="btn btn-outline-warning" onclick="filterReportTable('Late', this)">Late</button>
                                <button type="button" class="btn btn-outline-info" onclick="filterReportTable('Medical', this)">Medical</button>
                            </div>
                        </div>

                        <!-- Printable Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="report-students-table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="8%" class="text-center">#</th>
                                        <th width="12%">Roll No</th>
                                        <th width="40%">Student Name</th>
                                        <th width="20%">Section</th>
                                        <th width="20%" class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="report-table-body">
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">Loading preview data...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Signatures for Physical Document Print -->
                        <div class="row mt-5 pt-4 print-only">
                            <div class="col-6 text-center">
                                <div style="border-top: 1px solid #333; width: 80%; margin: 0 auto; padding-top: 5px;" class="font-weight-bold">
                                    Class Instructor / Teacher Signature
                                </div>
                                <small class="text-muted">Date: ________________________</small>
                            </div>
                            <div class="col-6 text-center">
                                <div style="border-top: 1px solid #333; width: 80%; margin: 0 auto; padding-top: 5px;" class="font-weight-bold">
                                    School Principal / Academic Registrar
                                </div>
                                <small class="text-muted">Verified & Approved</small>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Request Edit Modal (For Teachers) -->
    <div class="modal fade" id="requestEditModal" tabindex="-1" aria-labelledby="requestEditModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header bg-warning text-dark py-3">
                    <h5 class="modal-title font-weight-bold" id="requestEditModalLabel">
                        <i class="fas fa-lock mr-1"></i> Request Attendance Edit
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('attendance.requestEdit') }}">
                    @csrf
                    <div class="modal-body p-4">
                        <input type="hidden" id="request-edit-date" name="date">

                        <div class="alert alert-info border-0 mb-3" style="border-radius: 8px;">
                            <i class="fas fa-info-circle mr-1"></i> Attendance for this date has already been locked. Submit a change reason to request administrative unlock.
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit-reason" class="font-weight-bold text-dark">Reason for Modification <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="edit-reason" name="reason" rows="3" required placeholder="Describe why this attendance record requires updating..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light px-4 py-3">
                        <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning font-weight-bold shadow-sm">
                            <i class="fas fa-paper-plane mr-1"></i> Submit Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Global State & Data Store
        let currentClassId = "{{ $selectedClass ?? '' }}";
        let currentDate = "{{ \Carbon\Carbon::now()->format('Y-m-d') }}";
        let activeSectionId = null;
        let selectedReportSectionId = '';
        let attendanceCache = {}; // sectionId => student records
        let currentReportData = [];

        document.addEventListener('DOMContentLoaded', function () {
            const classPicker = document.getElementById('classpicker');
            const datePicker = document.getElementById('date_picker');
            const prevDateBtn = document.getElementById('prev-date-btn');
            const nextDateBtn = document.getElementById('next-date-btn');
            const todayBtn = document.getElementById('today-btn');
            const searchInput = document.getElementById('student-search-input');

            // Initialize Pickers
            if (datePicker) currentDate = datePicker.value;
            if (classPicker) currentClassId = classPicker.value;

            // Date Stepper controls
            if (prevDateBtn && datePicker) {
                prevDateBtn.addEventListener('click', function() {
                    const d = new Date(datePicker.value);
                    d.setDate(d.getDate() - 1);
                    datePicker.value = d.toISOString().split('T')[0];
                    currentDate = datePicker.value;
                    reloadAttendance();
                });
            }
            if (nextDateBtn && datePicker) {
                nextDateBtn.addEventListener('click', function() {
                    const d = new Date(datePicker.value);
                    d.setDate(d.getDate() + 1);
                    datePicker.value = d.toISOString().split('T')[0];
                    currentDate = datePicker.value;
                    reloadAttendance();
                });
            }
            if (todayBtn && datePicker) {
                todayBtn.addEventListener('click', function() {
                    datePicker.value = new Date().toISOString().split('T')[0];
                    currentDate = datePicker.value;
                    reloadAttendance();
                });
            }

            // Change Listeners
            if (classPicker) {
                classPicker.addEventListener('change', function () {
                    currentClassId = this.value;
                    selectedReportSectionId = '';
                    if (window.history && window.history.replaceState) {
                        window.history.replaceState({}, '', '/attendance/class/' + currentClassId);
                    }
                    reloadAttendance();
                });
            }
            if (datePicker) {
                datePicker.addEventListener('change', function () {
                    currentDate = this.value;
                    reloadAttendance();
                });
            }

            // Realtime Student Search Filter
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const query = this.value.toLowerCase().trim();
                    const activePane = document.querySelector('#sections-tabContent .tab-pane.active');
                    if (!activePane) return;

                    const rows = activePane.querySelectorAll('tbody tr');
                    rows.forEach(row => {
                        const name = row.getAttribute('data-student-name') || '';
                        const roll = row.getAttribute('data-student-roll') || '';
                        if (name.includes(query) || roll.includes(query)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }

            // Initial Trigger
            if (currentClassId && currentDate) {
                reloadAttendance();
            }

            // Setup Request Edit Modal
            const requestEditBtn = document.getElementById('request-edit-btn');
            if (requestEditBtn) {
                requestEditBtn.addEventListener('click', function() {
                    document.getElementById('request-edit-date').value = currentDate;
                });
            }
        });

        // Main Attendance Loader
        function reloadAttendance() {
            if (!currentClassId || !currentDate) return;

            showLoading(true);
            updatePdfDownloadLink();

            // 1. Check Attendance Submission State
            fetch(`/attendance/check/${currentClassId}?date=${currentDate}`)
                .then(res => res.json())
                .then(res => {
                    const badge = document.getElementById('global-attendance-badge');
                    if (badge) {
                        if (res.attendance_exists) {
                            badge.className = 'badge badge-success px-3 py-2';
                            badge.innerHTML = '<i class="fas fa-check-circle mr-1"></i> Recorded';
                        } else {
                            badge.className = 'badge badge-warning px-3 py-2';
                            badge.innerHTML = '<i class="fas fa-clock mr-1"></i> Pending';
                        }
                    }
                })
                .catch(err => console.log('Check attendance error', err));

            // 2. Fetch Sections for Selected Class
            fetch(`/get-sections/${currentClassId}`)
                .then(res => res.json())
                .then(data => {
                    const pillsContainer = document.getElementById('sections-tab-pills');
                    const tabContent = document.getElementById('sections-tabContent');
                    pillsContainer.innerHTML = '';
                    tabContent.innerHTML = '';
                    attendanceCache = {};

                    if (!data.sections || data.sections.length === 0) {
                        tabContent.innerHTML = `
                            <div class="text-center py-5 text-muted">
                                <i class="fas fa-exclamation-circle fa-3x text-warning mb-3"></i>
                                <h5>No sections found for this academic class.</h5>
                            </div>`;
                        const repSecFilter = document.getElementById('report-section-filter');
                        if (repSecFilter) repSecFilter.innerHTML = '<option value="">All Sections</option>';
                        recalculateKPIs();
                        showLoading(false);
                        return;
                    }

                    // Populate Report Section Filter Dropdown
                    const repSecFilter = document.getElementById('report-section-filter');
                    if (repSecFilter) {
                        repSecFilter.innerHTML = '<option value="">All Sections</option>';
                        data.sections.forEach(sec => {
                            repSecFilter.innerHTML += `<option value="${sec.section_id}">${sec.name}</option>`;
                        });
                        repSecFilter.value = selectedReportSectionId || '';
                    }

                    // Render Section Navigation Pills
                    data.sections.forEach((sec, idx) => {
                        const isActive = (idx === 0);
                        if (isActive) activeSectionId = sec.section_id;

                        pillsContainer.innerHTML += `
                            <li class="nav-item">
                                <a class="nav-link ${isActive ? 'active' : ''}"
                                   id="sec-tab-${sec.section_id}"
                                   data-toggle="pill"
                                   href="#sec-content-${sec.section_id}"
                                   role="tab"
                                   onclick="switchSection(${sec.section_id})">
                                    <i class="fas fa-layer-group mr-1"></i> ${sec.name}
                                </a>
                            </li>`;

                        // Render Tab Pane Wrapper
                        tabContent.innerHTML += `
                            <div class="tab-pane fade ${isActive ? 'show active' : ''}" id="sec-content-${sec.section_id}" role="tabpanel">
                                <form method="POST" action="{{ route('attendance.update') }}" id="form-section-${sec.section_id}">
                                    @csrf
                                    <input type="hidden" name="class_id" value="${currentClassId}">
                                    <input type="hidden" name="date" value="${currentDate}">

                                    <div class="table-responsive">
                                        <table class="table student-table table-hover mb-3">
                                            <thead>
                                                <tr>
                                                    <th width="8%" class="text-center">Roll</th>
                                                    <th width="42%">Student Information</th>
                                                    <th width="50%">Attendance Status</th>
                                                </tr>
                                            </thead>
                                            <tbody id="students-tbody-${sec.section_id}">
                                                <tr><td colspan="3" class="text-center py-4 text-muted">Loading students...</td></tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle mr-1"></i> Click status buttons to toggle. Don't forget to save changes.
                                        </small>
                                        <button type="submit" class="btn btn-success px-4 py-2 font-weight-bold shadow-sm">
                                            <i class="fas fa-save mr-1"></i> Save Attendance
                                        </button>
                                    </div>
                                </form>
                            </div>`;

                        // Fetch Students for this Section
                        fetchStudentsForSection(sec.section_id);
                    });
                })
                .catch(err => {
                    console.error('Error fetching sections:', err);
                    showLoading(false);
                });
        }

        // Fetch students & populate marking grid
        function fetchStudentsForSection(sectionId) {
            fetch(`/get-students/${sectionId}?date=${currentDate}`)
                .then(res => res.json())
                .then(data => {
                    const tbody = document.getElementById(`students-tbody-${sectionId}`);
                    if (!tbody) return;

                    attendanceCache[sectionId] = data.students || [];

                    if (!data.students || data.students.length === 0) {
                        tbody.innerHTML = `<tr><td colspan="3" class="text-center py-4 text-muted">No students assigned to this section.</td></tr>`;
                    } else {
                        tbody.innerHTML = '';
                        data.students.forEach((st, i) => {
                            const roll = st.roll || (i + 1);
                            const stStatus = (st.status !== null && st.status !== undefined) ? parseInt(st.status) : 0;
                            const avatar = st.photo ? `/students_image/${st.photo}` : '{{ asset("user-profile-default.png") }}';

                            tbody.innerHTML += `
                                <tr data-student-id="${st.student_class_id}"
                                    data-student-name="${st.name.toLowerCase()}"
                                    data-student-roll="${roll}">
                                    <td class="text-center">
                                        <span class="roll-badge">#${roll}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="${avatar}" alt="${st.name}" class="student-avatar mr-3" onerror="this.src='{{ asset("user-profile-default.png") }}';">
                                            <div>
                                                <div class="font-weight-bold text-dark">${st.name}</div>
                                                <small class="text-muted">ID: #${st.student_id || st.student_class_id}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <!-- Interactive Segmented Status Pill -->
                                        <div class="status-pill-group" id="pill-group-${st.student_class_id}">
                                            <button type="button" class="status-btn ${stStatus === 1 ? 'active-present' : ''}"
                                                    onclick="selectStatus(${st.student_class_id}, 1)">
                                                <i class="fas fa-check"></i> Present
                                            </button>
                                            <button type="button" class="status-btn ${stStatus === 2 ? 'active-absent' : ''}"
                                                    onclick="selectStatus(${st.student_class_id}, 2)">
                                                <i class="fas fa-times"></i> Absent
                                            </button>
                                            <button type="button" class="status-btn ${stStatus === 4 ? 'active-late' : ''}"
                                                    onclick="selectStatus(${st.student_class_id}, 4)">
                                                <i class="fas fa-clock"></i> Late
                                            </button>
                                            <button type="button" class="status-btn ${stStatus === 3 ? 'active-medical' : ''}"
                                                    onclick="selectStatus(${st.student_class_id}, 3)">
                                                <i class="fas fa-medkit"></i> Medical
                                            </button>
                                            <button type="button" class="status-btn ${stStatus === 0 ? 'active-undefined' : ''}"
                                                    onclick="selectStatus(${st.student_class_id}, 0)">
                                                -
                                            </button>
                                        </div>

                                        <input type="hidden"
                                               name="attendance[${st.student_class_id}][status]"
                                               id="input-status-${st.student_class_id}"
                                               value="${stStatus}">
                                        <input type="hidden"
                                               name="attendance[${st.student_class_id}][student_class_id]"
                                               value="${st.student_class_id}">
                                    </td>
                                </tr>`;
                        });
                    }

                    recalculateKPIs();
                    showLoading(false);
                })
                .catch(err => {
                    console.error('Error fetching students:', err);
                    showLoading(false);
                });
        }

        // Section Switch Handler
        function switchSection(secId) {
            activeSectionId = secId;
            const searchInput = document.getElementById('student-search-input');
            if (searchInput) searchInput.value = '';
            recalculateKPIs();
        }

        // Realtime Interactive Status Selection
        function selectStatus(studentClassId, statusVal) {
            const input = document.getElementById(`input-status-${studentClassId}`);
            if (input) input.value = statusVal;

            const group = document.getElementById(`pill-group-${studentClassId}`);
            if (group) {
                const buttons = group.querySelectorAll('.status-btn');
                buttons.forEach(btn => {
                    btn.classList.remove('active-present', 'active-absent', 'active-late', 'active-medical', 'active-undefined');
                });

                if (statusVal === 1) buttons[0].classList.add('active-present');
                else if (statusVal === 2) buttons[1].classList.add('active-absent');
                else if (statusVal === 4) buttons[2].classList.add('active-late');
                else if (statusVal === 3) buttons[3].classList.add('active-medical');
                else if (statusVal === 0) buttons[4].classList.add('active-undefined');
            }

            // Sync Cache and recalculate KPIs live
            if (activeSectionId && attendanceCache[activeSectionId]) {
                const student = attendanceCache[activeSectionId].find(s => s.student_class_id == studentClassId);
                if (student) student.status = statusVal;
            }

            recalculateKPIs();
        }

        // Bulk status set (All Present, All Absent, Reset)
        function bulkSetStatus(statusVal) {
            if (!activeSectionId) return;
            const activePane = document.querySelector('#sections-tabContent .tab-pane.active');
            if (!activePane) return;

            const rows = activePane.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const stId = row.getAttribute('data-student-id');
                if (stId) selectStatus(stId, statusVal);
            });
        }

        // Dynamic KPI Calculator
        function recalculateKPIs() {
            let total = 0, present = 0, absent = 0, late = 0, medical = 0;

            // Compute across all loaded sections in class
            Object.keys(attendanceCache).forEach(secId => {
                const students = attendanceCache[secId];
                if (Array.isArray(students)) {
                    total += students.length;
                    students.forEach(st => {
                        const s = parseInt(st.status);
                        if (s === 1) present++;
                        else if (s === 2) absent++;
                        else if (s === 4) late++;
                        else if (s === 3) medical++;
                    });
                }
            });

            const rate = total > 0 ? Math.round((present / total) * 100) : 0;

            document.getElementById('kpi-total').textContent = total;
            document.getElementById('kpi-present').textContent = present;
            document.getElementById('kpi-absent').textContent = absent;
            document.getElementById('kpi-late').textContent = late;
            document.getElementById('kpi-medical').textContent = medical;
            document.getElementById('kpi-rate').textContent = `${rate}%`;
        }

        // Section selection handler for Reporting Tab
        function changeReportSection(secId) {
            selectedReportSectionId = secId;
            const repSecFilter = document.getElementById('report-section-filter');
            const secName = (repSecFilter && repSecFilter.selectedIndex > 0)
                ? repSecFilter.options[repSecFilter.selectedIndex].text
                : 'All Sections';
            const repSecNameEl = document.getElementById('rep-section-name');
            if (repSecNameEl) repSecNameEl.textContent = secName;

            updatePdfDownloadLink();
            loadReportingPreview();
        }

        // Load Reporting & Preview Tab Data
        function loadReportingPreview() {
            if (!currentClassId || !currentDate) return;

            showLoading(true);
            const classPicker = document.getElementById('classpicker');
            const className = classPicker ? classPicker.options[classPicker.selectedIndex].text : 'Class';

            document.getElementById('rep-class-name').textContent = className;
            document.getElementById('rep-date-display').textContent = currentDate;

            let reportUrl = `/attendance/class/${currentClassId}/date/${currentDate}`;
            if (selectedReportSectionId) {
                reportUrl += `?section_id=${selectedReportSectionId}`;
            }

            fetch(reportUrl)
                .then(res => res.json())
                .then(data => {
                    const tbody = document.getElementById('report-table-body');
                    currentReportData = data.attendance || [];
                    const summary = data.summary || {};

                    // Update Reporting summary bar
                    document.getElementById('rep-stat-total').textContent = summary.total || 0;
                    document.getElementById('rep-stat-present').textContent = summary.present || 0;
                    document.getElementById('rep-stat-absent').textContent = summary.absent || 0;
                    document.getElementById('rep-stat-late').textContent = summary.late || 0;
                    document.getElementById('rep-stat-medical').textContent = summary.medical || 0;
                    document.getElementById('rep-rate-display').textContent = `${summary.rate || 0}%`;

                    if (!currentReportData || currentReportData.length === 0) {
                        tbody.innerHTML = `<tr><td colspan="5" class="text-center py-4 text-muted">No attendance records registered for this date.</td></tr>`;
                    } else {
                        renderReportTable(currentReportData);
                    }
                    showLoading(false);
                })
                .catch(err => {
                    console.error('Error loading report preview:', err);
                    showLoading(false);
                });
        }

        // Render report table
        function renderReportTable(records) {
            const tbody = document.getElementById('report-table-body');
            tbody.innerHTML = '';

            records.forEach((r, idx) => {
                let badge = '<span class="badge badge-secondary">Undefined</span>';
                let statusText = 'Undefined';

                if (r.status === 1) {
                    badge = '<span class="badge badge-success px-2 py-1"><i class="fas fa-check mr-1"></i> Present</span>';
                    statusText = 'Present';
                } else if (r.status === 2) {
                    badge = '<span class="badge badge-danger px-2 py-1"><i class="fas fa-times mr-1"></i> Absent</span>';
                    statusText = 'Absent';
                } else if (r.status === 4) {
                    badge = '<span class="badge badge-warning px-2 py-1"><i class="fas fa-clock mr-1"></i> Late</span>';
                    statusText = 'Late';
                } else if (r.status === 3) {
                    badge = '<span class="badge badge-info px-2 py-1"><i class="fas fa-medkit mr-1"></i> Medical</span>';
                    statusText = 'Medical';
                }

                tbody.innerHTML += `
                    <tr data-status="${statusText}">
                        <td class="text-center font-weight-bold">${idx + 1}</td>
                        <td><strong>#${r.roll || (idx + 1)}</strong></td>
                        <td class="font-weight-bold">${r.student_name}</td>
                        <td>${r.section_name || 'Standard'}</td>
                        <td class="text-center">${badge}</td>
                    </tr>`;
            });
        }

        // Filter report table by status
        function filterReportTable(status, btn) {
            const buttons = btn.parentElement.querySelectorAll('.btn');
            buttons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const rows = document.querySelectorAll('#report-table-body tr');
            rows.forEach(r => {
                if (status === 'all' || r.getAttribute('data-status') === status) {
                    r.style.display = '';
                } else {
                    r.style.display = 'none';
                }
            });
        }

        // Print Report Action
        function printAttendanceReport() {
            // Ensure report preview is loaded first
            $('#mode-report-tab').tab('show');
            setTimeout(() => {
                window.print();
            }, 300);
        }

        // Export to CSV Action
        function exportAttendanceCSV() {
            if (!currentReportData || currentReportData.length === 0) {
                alert('No attendance data available to export.');
                return;
            }

            const classPicker = document.getElementById('classpicker');
            const className = classPicker ? classPicker.options[classPicker.selectedIndex].text : 'Class';

            let csvContent = "data:text/csv;charset=utf-8,";
            csvContent += "Index,Roll,Student Name,Section,Status,Date\n";

            currentReportData.forEach((r, i) => {
                let statusLabel = 'Undefined';
                if (r.status === 1) statusLabel = 'Present';
                else if (r.status === 2) statusLabel = 'Absent';
                else if (r.status === 4) statusLabel = 'Late';
                else if (r.status === 3) statusLabel = 'Medical';

                csvContent += `"${i + 1}","${r.roll || (i + 1)}","${r.student_name}","${r.section_name || ''}","${statusLabel}","${currentDate}"\n`;
            });

            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", `Attendance_${className.replace(/\s+/g, '_')}_${currentDate}.csv`);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        // PDF URL Updater
        function updatePdfDownloadLink() {
            const btn = document.getElementById('btn-download-pdf');
            if (btn && currentClassId && currentDate) {
                let pdfUrl = `/attendance/pdf/${currentClassId}/${currentDate}`;
                if (selectedReportSectionId) {
                    pdfUrl += `?section_id=${selectedReportSectionId}`;
                }
                btn.href = pdfUrl;
            }
        }

        // Loading spinner helper
        function showLoading(show) {
            const spinner = document.getElementById('atd-spinner');
            if (spinner) {
                spinner.style.display = show ? 'flex' : 'none';
            }
        }
    </script>

@endsection
