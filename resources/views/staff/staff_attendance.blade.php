@extends('layout.main')

@section('content')

    <style>
        /* =========================================================
           Staff Attendance Management & Reporting System Styles
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
        .status-btn.active-undefined {
            background-color: #94a3b8 !important;
            color: #ffffff !important;
        }

        /* Staff Row Styling */
        .staff-table th {
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
        .staff-table td {
            vertical-align: middle;
            padding: 10px 14px;
            border-color: #f1f5f9;
        }
        .staff-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            background: #e2e8f0;
            border: 2px solid #ffffff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.08);
        }
        .dept-badge {
            background-color: #e0f2fe;
            color: #0369a1;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
            display: inline-block;
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

        /* Time inputs inside table */
        .time-box {
            max-width: 130px;
            font-size: 0.85rem;
            font-weight: 600;
            border-radius: 6px;
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
        .dark-mode .staff-table th {
            background-color: #2b3035 !important;
            color: #cbd5e1 !important;
        }
        .dark-mode .staff-table td {
            border-color: rgba(255, 255, 255, 0.06) !important;
            color: #f1f5f9 !important;
        }
        .dark-mode .dept-badge {
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
        .dark-mode #report-staff-table {
            color: #f8f9fa !important;
            background-color: #2b3035 !important;
        }
        .dark-mode #report-staff-table th {
            background-color: #1e2227 !important;
            border-color: #4b545c !important;
            color: #f8f9fa !important;
        }
        .dark-mode #report-staff-table td {
            border-color: rgba(255, 255, 255, 0.08) !important;
            color: #e2e8f0 !important;
        }
        .dark-mode #report-staff-table tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.02) !important;
        }
        .dark-mode #report-staff-table tr:nth-child(odd) {
            background-color: rgba(0, 0, 0, 0.15) !important;
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
    <div class="content-header p-0 mb-3 no-print">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
            <div>
                <h2 class="m-0 font-weight-bold text-dark">
                    <i class="fas fa-user-clock text-primary mr-2"></i> Staff Attendance Management & Reporting
                </h2>
                <small class="text-muted">Record employee daily shifts, monitor attendance analytics, and generate institutional audit reports</small>
            </div>
            <div class="d-flex align-items-center mt-2 mt-md-0">
                <ol class="breadcrumb m-0 bg-transparent p-0 mr-3 d-none d-lg-flex">
                    <li class="breadcrumb-item"><a href="/"><i class="fas fa-home mr-1"></i> Home</a></li>
                    <li class="breadcrumb-item active">Staff Attendance</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Alert Notifications -->
    <div id="ajax-alert-container" class="no-print"></div>
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
                <!-- Department Selection -->
                <div class="col-lg-5 col-md-6 mb-3 mb-md-0">
                    <label for="department_picker" class="font-weight-bold text-dark mb-1">
                        <i class="fas fa-sitemap text-primary mr-1"></i> Staff Department
                    </label>
                    <select id="department_picker" class="form-control font-weight-bold shadow-sm" style="border-radius: 8px;">
                        <option value="all" selected>All Departments</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
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
                               value="{{ request('date', \Carbon\Carbon::now()->format('Y-m-d')) }}" required>
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

                <!-- Live Status Indicator -->
                <div class="col-lg-2 col-md-12 text-center text-lg-right mt-2 mt-lg-0">
                    <div class="small font-weight-bold text-muted mb-1">Status on Date</div>
                    <span id="global-attendance-badge" class="badge badge-secondary px-3 py-2" style="border-radius: 20px; font-size: 0.85rem;">
                        <i class="fas fa-circle-notch fa-spin mr-1"></i> Checking...
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Live KPI Metrics Overview Cards -->
    <div class="row mb-4 no-print" id="kpi-metrics-row">
        <div class="col-xl-2 col-lg-4 col-sm-6 mb-3">
            <div class="metric-card">
                <div>
                    <div class="metric-value text-primary" id="kpi-total">0</div>
                    <div class="metric-label">Total Staff</div>
                </div>
                <div class="metric-icon-wrap bg-light text-primary">
                    <i class="fas fa-users-cog"></i>
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
                    <div class="metric-value text-secondary" id="kpi-undefined">0</div>
                    <div class="metric-label">Unmarked</div>
                </div>
                <div class="metric-icon-wrap" style="background-color: #f1f5f9; color: #64748b;">
                    <i class="fas fa-question"></i>
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

    <!-- 3. Dual Mode Container: Live Marking vs Official Staff Report Preview -->
    <div class="card atd-card position-relative mb-4">
        <!-- Interactive Header with Mode Toggle & Action Toolbar -->
        <div class="card-header bg-transparent border-bottom p-3 no-print">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                <!-- Mode Toggle Tabs -->
                <ul class="nav nav-pills view-mode-tabs mb-2 mb-md-0" id="mainAttendanceTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="mode-marking-tab" data-toggle="pill" href="#tab-marking" role="tab">
                            <i class="fas fa-edit mr-1"></i> Live Staff Attendance Marking
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
                    <button type="button" class="btn btn-outline-primary btn-sm px-3 mr-2 font-weight-bold" onclick="printStaffReport()">
                        <i class="fas fa-print mr-1"></i> Print Sheet
                    </button>
                    <button type="button" class="btn btn-outline-success btn-sm px-3 mr-2 font-weight-bold" onclick="exportStaffCSV()">
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

                <!-- TAB 1: Live Staff Marking Mode -->
                <div class="tab-pane fade show active" id="tab-marking" role="tabpanel">

                    <!-- Instant Search & Fast Batch Tools -->
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3">
                        <div class="d-flex align-items-center mb-2 mb-md-0">
                            <div class="input-group input-group-sm" style="width: 260px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input type="text" id="staff-search-input" class="form-control" placeholder="Search employee, position...">
                            </div>
                        </div>

                        <!-- Bulk Actions -->
                        <div class="d-flex align-items-center flex-wrap">
                            <span class="small font-weight-bold text-muted mr-2">Quick Batch:</span>
                            <button type="button" class="btn btn-sm btn-outline-success mr-1 font-weight-bold" onclick="bulkSetStatus('Present')" title="Set all to Present (08:00 - 17:00)">
                                <i class="fas fa-check-double mr-1"></i> All Present
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger mr-1 font-weight-bold" onclick="bulkSetStatus('Absent')" title="Set all to Absent">
                                <i class="fas fa-times-circle mr-1"></i> All Absent
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary font-weight-bold" onclick="bulkSetStatus('Undefined')" title="Reset all statuses">
                                <i class="fas fa-undo mr-1"></i> Reset
                            </button>
                        </div>
                    </div>

                    <!-- Staff Attendance Form -->
                    <form id="staff-attendance-form" method="POST" action="/staffAttendance/save" data-no-overlay="true" data-ajax="true">
                        @csrf
                        <input type="hidden" name="date" id="form-hidden-date">

                        <div class="table-responsive">
                            <table class="table staff-table table-hover mb-3">
                                <thead>
                                    <tr>
                                        <th width="32%">Staff Member</th>
                                        <th width="32%">Attendance Status</th>
                                        <th width="18%">Time In</th>
                                        <th width="18%">Time Out</th>
                                    </tr>
                                </thead>
                                <tbody id="staff-tbody">
                                    <tr><td colspan="4" class="text-center py-4 text-muted">Loading staff members...</td></tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <small class="text-muted">
                                <i class="fas fa-info-circle mr-1"></i> Click status buttons to toggle. Don't forget to save changes when finished.
                            </small>
                            <button type="submit" id="save-attendance-btn" class="btn btn-success px-4 py-2 font-weight-bold shadow-sm">
                                <i class="fas fa-save mr-1"></i> Save Staff Attendance
                            </button>
                        </div>
                    </form>
                </div>

                <!-- TAB 2: Reporting & Audit Preview Hub -->
                <div class="tab-pane fade" id="tab-report" role="tabpanel">
                    <div class="report-paper" id="printable-report-area">

                        <!-- Formal Print/Preview School Header -->
                        <div class="text-center mb-3">
                            <h3 class="font-weight-bold text-dark m-0" id="rep-school-name">{{ config('app.name', 'School Management System') }}</h3>
                            <h5 class="text-primary font-weight-bold text-uppercase mt-1" style="letter-spacing: 0.5px;">Official Staff Daily Attendance Report</h5>
                            <p class="text-muted small m-0">Institutional Staff Audit & Verification Summary</p>
                            <div class="report-header-divider"></div>
                        </div>

                        <!-- Department & Date Details Box -->
                        <div class="card mb-4 border">
                            <div class="card-body p-3">
                                <div class="row text-center text-md-left">
                                    <div class="col-md-3 col-6 mb-2 mb-md-0">
                                        <small class="text-muted text-uppercase font-weight-bold">Department Scope</small>
                                        <div class="font-weight-bold text-dark h6 m-0" id="rep-department-name">All Departments</div>
                                    </div>
                                    <div class="col-md-3 col-6 mb-2 mb-md-0">
                                        <small class="text-muted text-uppercase font-weight-bold">Attendance Date</small>
                                        <div class="font-weight-bold text-dark h6 m-0" id="rep-date-display">-</div>
                                    </div>
                                    <div class="col-md-3 col-6 mb-2 mb-md-0">
                                        <small class="text-muted text-uppercase font-weight-bold">Staff Enrolled</small>
                                        <div class="font-weight-bold text-primary h6 m-0" id="rep-enrolled-display">0</div>
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
                                    <small class="text-muted text-uppercase font-weight-bold">Total Staff</small>
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
                                    <small class="text-muted text-uppercase font-weight-bold">Unmarked</small>
                                    <h4 class="font-weight-bold text-secondary m-0" id="rep-stat-undefined">0</h4>
                                </div>
                            </div>
                        </div>

                        <!-- Filter Toolbar in Report -->
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 no-print">
                            <h6 class="font-weight-bold text-dark m-0 mb-2 mb-md-0">Employee Attendance Audit Records</h6>
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-outline-secondary active" onclick="filterReportTable('all', this)">All</button>
                                <button type="button" class="btn btn-outline-success" onclick="filterReportTable('Present', this)">Present</button>
                                <button type="button" class="btn btn-outline-danger" onclick="filterReportTable('Absent', this)">Absent</button>
                                <button type="button" class="btn btn-outline-warning" onclick="filterReportTable('Late', this)">Late</button>
                                <button type="button" class="btn btn-outline-secondary" onclick="filterReportTable('Undefined', this)">Unmarked</button>
                            </div>
                        </div>

                        <!-- Printable Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="report-staff-table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="6%" class="text-center">#</th>
                                        <th width="30%">Employee Name</th>
                                        <th width="20%">Position</th>
                                        <th width="18%">Department</th>
                                        <th width="14%">Shift Hours</th>
                                        <th width="12%" class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="report-table-body">
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">Loading preview data...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Signatures for Physical Document Print -->
                        <div class="row mt-5 pt-4 print-only">
                            <div class="col-6 text-center">
                                <div style="border-top: 1px solid #333; width: 80%; margin: 0 auto; padding-top: 5px;" class="font-weight-bold">
                                    HR Manager / Supervisor Signature
                                </div>
                                <small class="text-muted">Date: ________________________</small>
                            </div>
                            <div class="col-6 text-center">
                                <div style="border-top: 1px solid #333; width: 80%; margin: 0 auto; padding-top: 5px;" class="font-weight-bold">
                                    School Principal / Administrator
                                </div>
                                <small class="text-muted">Verified & Approved</small>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Global State & Data Store
        let currentDepartmentId = "{{ request('department_id', 'all') }}";
        let currentDate = "{{ request('date', \Carbon\Carbon::now()->format('Y-m-d')) }}";
        let staffRecordsCache = [];

        document.addEventListener('DOMContentLoaded', function () {
            const deptPicker = document.getElementById('department_picker');
            const datePicker = document.getElementById('date_picker');
            const prevDateBtn = document.getElementById('prev-date-btn');
            const nextDateBtn = document.getElementById('next-date-btn');
            const todayBtn = document.getElementById('today-btn');
            const searchInput = document.getElementById('staff-search-input');
            const attendanceForm = document.getElementById('staff-attendance-form');

            // Initialize Pickers
            if (datePicker) currentDate = datePicker.value;
            if (deptPicker) currentDepartmentId = deptPicker.value;

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
            if (deptPicker) {
                deptPicker.addEventListener('change', function () {
                    currentDepartmentId = this.value;
                    reloadAttendance();
                });
            }
            if (datePicker) {
                datePicker.addEventListener('change', function () {
                    currentDate = this.value;
                    reloadAttendance();
                });
            }

            // Realtime Staff Search Filter
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const query = this.value.toLowerCase().trim();
                    const rows = document.querySelectorAll('#staff-tbody tr');
                    rows.forEach(row => {
                        const name = row.getAttribute('data-staff-name') || '';
                        const position = row.getAttribute('data-staff-position') || '';
                        const dept = row.getAttribute('data-staff-dept') || '';
                        if (name.includes(query) || position.includes(query) || dept.includes(query)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }

            // AJAX Form Submission
            if (attendanceForm) {
                attendanceForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (e.stopImmediatePropagation) e.stopImmediatePropagation();

                    const submitBtn = document.getElementById('save-attendance-btn');
                    const originalBtnHtml = submitBtn ? submitBtn.innerHTML : '';
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Saving Attendance...';
                    }

                    showLoading(true);

                    const formData = new FormData(this);

                    fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (submitBtn) {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalBtnHtml;
                        }
                        showLoading(false);
                        if (data.success) {
                            showFlashAlert('success', data.message || 'Staff attendance saved successfully.');
                            reloadAttendance();
                        } else {
                            showFlashAlert('danger', data.message || 'Failed to save attendance. Please check input errors.');
                        }
                    })
                    .catch(err => {
                        console.error('Error saving attendance:', err);
                        if (submitBtn) {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalBtnHtml;
                        }
                        showLoading(false);
                        showFlashAlert('danger', 'An unexpected error occurred while saving.');
                    });
                });
            }

            // Check if initial tab requested
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('tab') === 'report') {
                $('#mode-report-tab').tab('show');
            }

            // Initial Trigger
            reloadAttendance();
        });

        // Main Attendance Loader
        function reloadAttendance() {
            if (!currentDate) return;

            showLoading(true);
            updatePdfDownloadLink();

            const formHiddenDate = document.getElementById('form-hidden-date');
            if (formHiddenDate) formHiddenDate.value = currentDate;

            fetch(`/get-staffAttendance?date=${currentDate}&department_id=${currentDepartmentId}`)
                .then(res => res.json())
                .then(data => {
                    staffRecordsCache = data.staff || [];
                    const summary = data.summary || {};
                    const tbody = document.getElementById('staff-tbody');

                    // 1. Update Global Status Badge
                    const badge = document.getElementById('global-attendance-badge');
                    if (badge) {
                        if (data.attendance_exists) {
                            badge.className = 'badge badge-success px-3 py-2';
                            badge.innerHTML = '<i class="fas fa-check-circle mr-1"></i> Recorded';
                        } else {
                            badge.className = 'badge badge-warning px-3 py-2';
                            badge.innerHTML = '<i class="fas fa-clock mr-1"></i> Pending';
                        }
                    }

                    // 2. Render Live Marking Table Rows
                    tbody.innerHTML = '';
                    if (staffRecordsCache.length === 0) {
                        tbody.innerHTML = `<tr><td colspan="4" class="text-center py-5 text-muted">No staff members found for the selected department.</td></tr>`;
                    } else {
                        staffRecordsCache.forEach((s) => {
                            const status = s.status || 'Undefined';
                            const avatar = s.photo ? `/staffs_image/${s.photo}` : '{{ asset("user-profile-default.png") }}';
                            const isPresentOrLate = (status === 'Present' || status === 'Late');
                            const timeInVal = s.time_in ? s.time_in.substring(0, 5) : '';
                            const timeOutVal = s.time_out ? s.time_out.substring(0, 5) : '';

                            tbody.innerHTML += `
                                <tr data-staff-id="${s.staff_id}"
                                    data-staff-name="${s.name.toLowerCase()}"
                                    data-staff-position="${(s.position || '').toLowerCase()}"
                                    data-staff-dept="${(s.department_name || '').toLowerCase()}">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="${avatar}" alt="${s.name}" class="staff-avatar mr-3" onerror="this.src='{{ asset("user-profile-default.png") }}';">
                                            <div>
                                                <div class="font-weight-bold text-dark">${s.name}</div>
                                                <div class="text-muted small">${s.position || 'Employee'}</div>
                                                <span class="dept-badge mt-1">${s.department_name}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <!-- Interactive Segmented Status Pill -->
                                        <div class="status-pill-group" id="pill-group-${s.staff_id}">
                                            <button type="button" class="status-btn ${status === 'Present' ? 'active-present' : ''}"
                                                    onclick="selectStaffStatus(${s.staff_id}, 'Present')">
                                                <i class="fas fa-check"></i> Present
                                            </button>
                                            <button type="button" class="status-btn ${status === 'Absent' ? 'active-absent' : ''}"
                                                    onclick="selectStaffStatus(${s.staff_id}, 'Absent')">
                                                <i class="fas fa-times"></i> Absent
                                            </button>
                                            <button type="button" class="status-btn ${status === 'Late' ? 'active-late' : ''}"
                                                    onclick="selectStaffStatus(${s.staff_id}, 'Late')">
                                                <i class="fas fa-clock"></i> Late
                                            </button>
                                            <button type="button" class="status-btn ${status === 'Undefined' ? 'active-undefined' : ''}"
                                                    onclick="selectStaffStatus(${s.staff_id}, 'Undefined')">
                                                -
                                            </button>
                                        </div>

                                        <input type="hidden"
                                               name="attendance[${s.staff_id}][status]"
                                               id="input-status-${s.staff_id}"
                                               value="${status}">
                                    </td>
                                    <td>
                                        <input type="time"
                                               name="attendance[${s.staff_id}][time_in]"
                                               id="input-timein-${s.staff_id}"
                                               class="form-control time-box shadow-sm"
                                               value="${timeInVal}"
                                               ${isPresentOrLate ? '' : 'disabled'}>
                                    </td>
                                    <td>
                                        <input type="time"
                                               name="attendance[${s.staff_id}][time_out]"
                                               id="input-timeout-${s.staff_id}"
                                               class="form-control time-box shadow-sm"
                                               value="${timeOutVal}"
                                               ${isPresentOrLate ? '' : 'disabled'}>
                                    </td>
                                </tr>`;
                        });
                    }

                    // 3. Update Live KPI Metrics
                    recalculateKPIs();
                    showLoading(false);
                })
                .catch(err => {
                    console.error('Error fetching staff attendance:', err);
                    showLoading(false);
                });
        }

        // Realtime Interactive Status Selection
        function selectStaffStatus(staffId, statusVal) {
            const input = document.getElementById(`input-status-${staffId}`);
            if (input) input.value = statusVal;

            const timeInInput = document.getElementById(`input-timein-${staffId}`);
            const timeOutInput = document.getElementById(`input-timeout-${staffId}`);

            if (statusVal === 'Present' || statusVal === 'Late') {
                if (timeInInput) {
                    timeInInput.disabled = false;
                    if (!timeInInput.value) timeInInput.value = statusVal === 'Late' ? '08:45' : '08:00';
                }
                if (timeOutInput) {
                    timeOutInput.disabled = false;
                    if (!timeOutInput.value) timeOutInput.value = '17:00';
                }
            } else {
                if (timeInInput) {
                    timeInInput.disabled = true;
                    timeInInput.value = '';
                }
                if (timeOutInput) {
                    timeOutInput.disabled = true;
                    timeOutInput.value = '';
                }
            }

            const group = document.getElementById(`pill-group-${staffId}`);
            if (group) {
                const buttons = group.querySelectorAll('.status-btn');
                buttons.forEach(btn => btn.classList.remove('active-present', 'active-absent', 'active-late', 'active-undefined'));

                if (statusVal === 'Present') buttons[0].classList.add('active-present');
                else if (statusVal === 'Absent') buttons[1].classList.add('active-absent');
                else if (statusVal === 'Late') buttons[2].classList.add('active-late');
                else if (statusVal === 'Undefined') buttons[3].classList.add('active-undefined');
            }

            // Sync with local cache
            const staff = staffRecordsCache.find(s => s.staff_id == staffId);
            if (staff) {
                staff.status = statusVal;
                staff.time_in = timeInInput ? timeInInput.value : '';
                staff.time_out = timeOutInput ? timeOutInput.value : '';
            }

            recalculateKPIs();
        }

        // Bulk status set (All Present, All Absent, Reset)
        function bulkSetStatus(statusVal) {
            const rows = document.querySelectorAll('#staff-tbody tr');
            rows.forEach(row => {
                const sId = row.getAttribute('data-staff-id');
                if (sId) selectStaffStatus(sId, statusVal);
            });
        }

        // Recalculate KPIs Live
        function recalculateKPIs() {
            let total = staffRecordsCache.length;
            let present = 0, absent = 0, late = 0, undefinedCount = 0;

            staffRecordsCache.forEach(s => {
                if (s.status === 'Present') present++;
                else if (s.status === 'Absent') absent++;
                else if (s.status === 'Late') late++;
                else undefinedCount++;
            });

            const rate = total > 0 ? Math.round(((present + late) / total) * 100) : 0;

            document.getElementById('kpi-total').textContent = total;
            document.getElementById('kpi-present').textContent = present;
            document.getElementById('kpi-absent').textContent = absent;
            document.getElementById('kpi-late').textContent = late;
            document.getElementById('kpi-undefined').textContent = undefinedCount;
            document.getElementById('kpi-rate').textContent = `${rate}%`;
        }

        // Load Reporting & Preview Tab Data
        function loadReportingPreview() {
            if (!currentDate) return;

            showLoading(true);
            const deptPicker = document.getElementById('department_picker');
            const deptName = deptPicker ? deptPicker.options[deptPicker.selectedIndex].text : 'All Departments';

            document.getElementById('rep-department-name').textContent = deptName;
            document.getElementById('rep-date-display').textContent = currentDate;

            fetch(`/get-staffAttendance?date=${currentDate}&department_id=${currentDepartmentId}`)
                .then(res => res.json())
                .then(data => {
                    const tbody = document.getElementById('report-table-body');
                    const records = data.staff || [];
                    const summary = data.summary || {};

                    document.getElementById('rep-enrolled-display').textContent = summary.total || 0;
                    document.getElementById('rep-stat-total').textContent = summary.total || 0;
                    document.getElementById('rep-stat-present').textContent = summary.present || 0;
                    document.getElementById('rep-stat-absent').textContent = summary.absent || 0;
                    document.getElementById('rep-stat-late').textContent = summary.late || 0;
                    document.getElementById('rep-stat-undefined').textContent = summary.undefined || 0;
                    document.getElementById('rep-rate-display').textContent = `${summary.rate || 0}%`;

                    tbody.innerHTML = '';
                    if (records.length === 0) {
                        tbody.innerHTML = `<tr><td colspan="6" class="text-center py-4 text-muted">No staff records available for this date.</td></tr>`;
                    } else {
                        records.forEach((r, idx) => {
                            let badge = '<span class="badge badge-secondary px-2 py-1">Unmarked</span>';
                            let statusText = r.status || 'Undefined';

                            if (statusText === 'Present') {
                                badge = '<span class="badge badge-success px-2 py-1"><i class="fas fa-check mr-1"></i> Present</span>';
                            } else if (statusText === 'Absent') {
                                badge = '<span class="badge badge-danger px-2 py-1"><i class="fas fa-times mr-1"></i> Absent</span>';
                            } else if (statusText === 'Late') {
                                badge = '<span class="badge badge-warning px-2 py-1"><i class="fas fa-clock mr-1"></i> Late</span>';
                            }

                            const hoursText = (statusText === 'Present' || statusText === 'Late') && r.time_in
                                ? `${r.time_in.substring(0, 5)} - ${r.time_out ? r.time_out.substring(0, 5) : '—'}`
                                : '—';

                            tbody.innerHTML += `
                                <tr data-status="${statusText}">
                                    <td class="text-center font-weight-bold">${idx + 1}</td>
                                    <td class="font-weight-bold text-dark">${r.name}</td>
                                    <td>${r.position || 'Staff'}</td>
                                    <td><span class="dept-badge">${r.department_name}</span></td>
                                    <td>${hoursText}</td>
                                    <td class="text-center">${badge}</td>
                                </tr>`;
                        });
                    }
                    showLoading(false);
                })
                .catch(err => {
                    console.error('Error loading report preview:', err);
                    showLoading(false);
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
        function printStaffReport() {
            $('#mode-report-tab').tab('show');
            setTimeout(() => {
                window.print();
            }, 300);
        }

        // Export to CSV Action
        function exportStaffCSV() {
            if (!staffRecordsCache || staffRecordsCache.length === 0) {
                alert('No staff attendance data available to export.');
                return;
            }

            const deptPicker = document.getElementById('department_picker');
            const deptName = deptPicker ? deptPicker.options[deptPicker.selectedIndex].text : 'All_Departments';

            let csvContent = "data:text/csv;charset=utf-8,";
            csvContent += "Index,Staff ID,Staff Name,Position,Department,Status,Time In,Time Out,Date\n";

            staffRecordsCache.forEach((r, i) => {
                const statusLabel = r.status || 'Undefined';
                const timeIn = r.time_in ? r.time_in.substring(0, 5) : '';
                const timeOut = r.time_out ? r.time_out.substring(0, 5) : '';

                csvContent += `"${i + 1}","${r.staff_id}","${r.name}","${r.position || ''}","${r.department_name || ''}","${statusLabel}","${timeIn}","${timeOut}","${currentDate}"\n`;
            });

            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", `Staff_Attendance_${deptName.replace(/\s+/g, '_')}_${currentDate}.csv`);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        // PDF URL Updater
        function updatePdfDownloadLink() {
            const btn = document.getElementById('btn-download-pdf');
            if (btn && currentDate) {
                let pdfUrl = `/staff/attendance/pdf/${currentDate}`;
                if (currentDepartmentId && currentDepartmentId !== 'all') {
                    pdfUrl += `?department_id=${currentDepartmentId}`;
                }
                btn.href = pdfUrl;
            }
        }

        // Flash Alert message helper
        function showFlashAlert(type, message) {
            const container = document.getElementById('ajax-alert-container');
            if (!container) return;
            container.innerHTML = `
                <div class="alert alert-${type} alert-dismissible fade show shadow-sm" role="alert" style="border-radius: 10px;">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle'} mr-2"></i> ${message}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>`;
            window.scrollTo({ top: 0, behavior: 'smooth' });
            setTimeout(() => {
                if (window.$ && $(container).find('.alert').length) {
                    $(container).find('.alert').alert('close');
                }
            }, 5000);
        }

        // Loading spinner helper
        function showLoading(show) {
            const spinner = document.getElementById('atd-spinner');
            if (spinner) {
                spinner.style.display = show ? 'flex' : 'none';
            }
            if (!show) {
                if (window.hideOverlay) window.hideOverlay();
                const globalOverlay = document.getElementById('contentOverlay');
                if (globalOverlay) {
                    globalOverlay.style.display = 'none';
                    globalOverlay.remove();
                }
            }
        }
    </script>

@endsection
