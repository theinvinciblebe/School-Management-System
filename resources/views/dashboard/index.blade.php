@extends('layout.main')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* Modern Dashboard Styles */
        .dash-container {
            padding: 1.25rem 0.5rem;
        }

        /* Hero Welcome Banner */
        .dash-hero {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
            border-radius: 18px;
            padding: 1.75rem 2rem;
            color: #ffffff;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px -5px rgba(67, 56, 202, 0.3);
            margin-bottom: 1.75rem;
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        .dash-hero::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 220px;
            height: 220px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.18) 0%, rgba(255, 255, 255, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .dash-hero::after {
            content: '';
            position: absolute;
            bottom: -60px;
            left: 20%;
            width: 180px;
            height: 180px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.35) 0%, rgba(99, 102, 241, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .dash-hero h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.35rem;
            letter-spacing: -0.02em;
        }

        .dash-hero p {
            color: rgba(255, 255, 255, 0.85);
            font-size: 0.95rem;
            margin-bottom: 1rem;
        }

        .dash-hero-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            align-items: center;
        }

        .dash-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.4rem 0.85rem;
            border-radius: 30px;
            font-size: 0.82rem;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
        }

        .dash-hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.65rem;
            margin-top: 1.25rem;
        }

        .btn-dash-action {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.55rem 1.15rem;
            border-radius: 12px;
            font-size: 0.86rem;
            font-weight: 600;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none !important;
        }

        .btn-dash-action-primary {
            background: #ffffff;
            color: #312e81 !important;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
        }

        .btn-dash-action-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
            background: #f8fafc;
        }

        .btn-dash-action-ghost {
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff !important;
            border: 1px solid rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(6px);
        }

        .btn-dash-action-ghost:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.25);
            color: #ffffff !important;
        }

        /* Metric Cards */
        .dash-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 1.35rem 1.4rem;
            border: 1px solid #edf2f7;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }

        .dash-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -4px rgba(0, 0, 0, 0.1);
            border-color: #cbd5e1;
        }

        .dark-mode .dash-card {
            background: #202020 !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.4) !important;
        }

        .dark-mode .dash-card:hover {
            border-color: rgba(255, 255, 255, 0.2) !important;
            box-shadow: 0 10px 25px -4px rgba(0, 0, 0, 0.6) !important;
        }

        .dash-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.85rem;
        }

        .dash-card-title {
            font-size: 0.84rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #64748b;
            margin: 0;
        }

        .dark-mode .dash-card-title {
            color: #94a3b8;
        }

        .dash-card-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            transition: transform 0.2s ease;
        }

        .dash-card:hover .dash-card-icon {
            transform: scale(1.08);
        }

        .icon-indigo { background: rgba(99, 102, 241, 0.12); color: #6366f1; }
        .icon-emerald { background: rgba(16, 185, 129, 0.12); color: #10b981; }
        .icon-sky    { background: rgba(14, 165, 233, 0.12); color: #0ea5e9; }
        .icon-amber  { background: rgba(245, 158, 11, 0.12); color: #f59e0b; }
        .icon-rose   { background: rgba(244, 63, 94, 0.12);  color: #f43f5e; }

        .dash-card-value {
            font-size: 2rem;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.1;
            margin-bottom: 0.4rem;
            letter-spacing: -0.02em;
        }

        .dark-mode .dash-card-value {
            color: #f8fafc;
        }

        .dash-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.82rem;
            color: #64748b;
            padding-top: 0.5rem;
            border-top: 1px solid #f1f5f9;
        }

        .dark-mode .dash-card-footer {
            border-top-color: rgba(255, 255, 255, 0.06);
            color: #94a3b8;
        }

        .dash-card-link {
            font-weight: 600;
            color: #4f46e5;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            transition: gap 0.2s ease;
            text-decoration: none !important;
        }

        .dash-card-link:hover {
            gap: 0.45rem;
            color: #4338ca;
        }

        .dark-mode .dash-card-link {
            color: #818cf8;
        }

        /* Attendance Snapshot Section */
        .attendance-banner {
            background: #ffffff;
            border-radius: 16px;
            padding: 1.35rem 1.6rem;
            border: 1px solid #edf2f7;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.75rem;
        }

        .dark-mode .attendance-banner {
            background: #202020 !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.4) !important;
        }

        .atd-progress-track {
            height: 12px;
            border-radius: 10px;
            background: #e2e8f0;
            overflow: hidden;
            display: flex;
            margin-top: 0.85rem;
        }

        .dark-mode .atd-progress-track {
            background: #333333;
        }

        .atd-bar-present {
            background: linear-gradient(90deg, #10b981 0%, #059669 100%);
            transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .atd-bar-absent {
            background: linear-gradient(90deg, #f43f5e 0%, #e11d48 100%);
            transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .pulse-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #10b981;
            box-shadow: 0 0 0 rgba(16, 185, 129, 0.6);
            animation: pulseAtd 1.8s infinite;
        }

        @keyframes pulseAtd {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.6); }
            70% { box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        /* Chart Panels */
        .chart-panel {
            background: #ffffff;
            border-radius: 16px;
            padding: 1.5rem 1.6rem;
            border: 1px solid #edf2f7;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.75rem;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .dark-mode .chart-panel {
            background: #202020 !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.4) !important;
        }

        .chart-panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-bottom: 1.25rem;
            padding-bottom: 0.85rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .dark-mode .chart-panel-header {
            border-bottom-color: rgba(255, 255, 255, 0.06);
        }

        .chart-title {
            font-size: 1.08rem;
            font-weight: 700;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0;
        }

        .dark-mode .chart-title {
            color: #f8fafc;
        }

        .chart-kpis {
            display: flex;
            gap: 1.25rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .chart-kpi-item {
            display: flex;
            flex-direction: column;
        }

        .chart-kpi-label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #64748b;
        }

        .dark-mode .chart-kpi-label {
            color: #94a3b8;
        }

        .chart-kpi-value {
            font-size: 1.2rem;
            font-weight: 700;
        }

        .kpi-profit { color: #10b981; }
        .kpi-expense { color: #ef4444; }
        .kpi-net { color: #6366f1; }

        .select-modern {
            padding: 0.4rem 2rem 0.4rem 0.85rem;
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            font-size: 0.85rem;
            font-weight: 600;
            color: #1e293b;
            background-color: #f8fafc;
            outline: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .dark-mode .select-modern {
            background-color: #2b2b2b;
            border-color: rgba(255, 255, 255, 0.15);
            color: #f1f5f9;
        }

        .select-modern:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        /* Quick Navigation Shortcuts Grid */
        .shortcut-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
            gap: 0.85rem;
            margin-top: 1rem;
        }

        .shortcut-item {
            background: #ffffff;
            border: 1px solid #edf2f7;
            border-radius: 14px;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            text-decoration: none !important;
            color: #1e293b;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            gap: 0.5rem;
        }

        .dark-mode .shortcut-item {
            background: #202020;
            border-color: rgba(255, 255, 255, 0.08);
            color: #f1f5f9;
        }

        .shortcut-item:hover {
            transform: translateY(-3px);
            border-color: #818cf8;
            box-shadow: 0 6px 18px -2px rgba(99, 102, 241, 0.15);
            color: #4f46e5;
        }

        .dark-mode .shortcut-item:hover {
            color: #818cf8;
            border-color: #6366f1;
        }

        .shortcut-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            background: #f1f5f9;
            color: #4f46e5;
            transition: transform 0.2s ease;
        }

        .dark-mode .shortcut-icon {
            background: #2a2a2a;
            color: #818cf8;
        }

        .shortcut-item:hover .shortcut-icon {
            transform: scale(1.1);
        }

        .shortcut-label {
            font-size: 0.82rem;
            font-weight: 600;
        }

        /* Responsive Layout */
        @media (max-width: 768px) {
            .dash-hero {
                padding: 1.25rem 1.25rem;
            }
            .dash-hero h1 {
                font-size: 1.4rem;
            }
            .shortcut-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>

    <div class="dash-container">
        <div class="container-fluid">

            <!-- Hero Welcome Card -->
            <div class="dash-hero">
                <div class="row align-items-center">
                    <div class="col-lg-8 col-md-12">
                        <div class="dash-hero-badges mb-2">
                            <span class="dash-badge">
                                <i class="far fa-calendar-alt"></i>
                                {{ now()->format('l, F j, Y') }}
                            </span>
                            <span class="dash-badge">
                                <i class="fas fa-check-circle text-emerald-400"></i>
                                {{ __('Academic Management Online') }}
                            </span>
                        </div>
                        <h1>{{ __('Welcome back') }}, {{ Auth::check() ? Auth::user()->name : 'Administrator' }}! 👋</h1>
                        <p>Here is your school system's real-time academic status, daily attendance metrics, and financial performance overview.</p>
                        
                        <div class="dash-hero-actions">
                            <a href="/students/create" class="btn-dash-action btn-dash-action-primary" onclick="showOverlay()">
                                <i class="fas fa-user-plus"></i>
                                <span>{{ __('Enroll Student') }}</span>
                            </a>
                            <a href="{{ !empty($defaultClassId) ? route('attendance.show', $defaultClassId) : '/attendance/class/62' }}" class="btn-dash-action btn-dash-action-ghost" onclick="showOverlay()">
                                <i class="fas fa-user-check"></i>
                                <span>{{ __('Student Attendance') }}</span>
                            </a>
                            <a href="/staff/attendance" class="btn-dash-action btn-dash-action-ghost" onclick="showOverlay()">
                                <i class="fas fa-clipboard-check"></i>
                                <span>{{ __('Staff Attendance') }}</span>
                            </a>
                            <a href="/profit" class="btn-dash-action btn-dash-action-ghost" onclick="showOverlay()">
                                <i class="fas fa-chart-line"></i>
                                <span>{{ __('Financials') }}</span>
                            </a>
                            <a href="/customize" class="btn-dash-action btn-dash-action-ghost" onclick="showOverlay()">
                                <i class="fas fa-palette"></i>
                                <span>{{ __('Settings') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Row: Modern Metric KPI Cards -->
            <div class="row mb-4">
                <!-- 1. Students -->
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
                    <div class="dash-card">
                        <div>
                            <div class="dash-card-header">
                                <span class="dash-card-title">{{ __('Enrolled Students') }}</span>
                                <div class="dash-card-icon icon-indigo">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                            </div>
                            <div class="dash-card-value">{{ number_format($students_count) }}</div>
                        </div>
                        <div class="dash-card-footer">
                            <span>Active student records</span>
                            <a href="/students" class="dash-card-link" onclick="showOverlay()">
                                {{ __('View all') }} <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 2. Faculty / Teachers -->
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
                    <div class="dash-card">
                        <div>
                            <div class="dash-card-header">
                                <span class="dash-card-title">{{ __('Teachers & Faculty') }}</span>
                                <div class="dash-card-icon icon-emerald">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </div>
                            </div>
                            <div class="dash-card-value">{{ number_format($teachers_count) }}</div>
                        </div>
                        <div class="dash-card-footer">
                            <span>Academic instructors</span>
                            <a href="/teachers" class="dash-card-link" onclick="showOverlay()">
                                {{ __('View all') }} <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 3. Available Classes -->
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
                    <div class="dash-card">
                        <div>
                            <div class="dash-card-header">
                                <span class="dash-card-title">{{ __('Active Classes') }}</span>
                                <div class="dash-card-icon icon-sky">
                                    <i class="fas fa-school"></i>
                                </div>
                            </div>
                            <div class="dash-card-value">{{ number_format($classes_count) }}</div>
                        </div>
                        <div class="dash-card-footer">
                            <span>Classes & sections</span>
                            <a href="/class" class="dash-card-link" onclick="showOverlay()">
                                {{ __('View all') }} <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 4. Parents -->
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
                    <div class="dash-card">
                        <div>
                            <div class="dash-card-header">
                                <span class="dash-card-title">{{ __('Registered Parents') }}</span>
                                <div class="dash-card-icon icon-amber">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="dash-card-value">{{ number_format($parents_count) }}</div>
                        </div>
                        <div class="dash-card-footer">
                            <span>Guardian profiles</span>
                            <a href="/parents" class="dash-card-link" onclick="showOverlay()">
                                {{ __('View all') }} <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attendance Pulse Banner -->
            @php
                $studentAttendanceUrl = !empty($defaultClassId) ? route('attendance.show', $defaultClassId) : '/attendance/class/62';
                $totalMarked = $today_atd + $absent_atd;
                $presentRate = $totalMarked > 0 ? round(($today_atd / $totalMarked) * 100, 1) : 0;
                $absentRate = $totalMarked > 0 ? round(($absent_atd / $totalMarked) * 100, 1) : 0;
            @endphp
            <div class="attendance-banner mb-4">
                <div class="d-flex align-items-center justify-content-between flex-wrap mb-2">
                    <div class="d-flex align-items-center gap-2">
                        <div class="pulse-dot mr-2"></div>
                        <h3 class="m-0 font-weight-bold" style="font-size: 1.05rem;">{{ __("Today's Student Attendance") }}</h3>
                        <span class="text-muted ml-2" style="font-size: 0.85rem;">({{ now()->format('M d, Y') }})</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="badge px-3 py-2" style="background: rgba(16, 185, 129, 0.12); color: #10b981; font-weight: 600; font-size: 0.85rem;">
                            <i class="fas fa-check-circle mr-1"></i> {{ $today_atd }} {{ __('Present') }}
                        </span>
                        <span class="badge px-3 py-2 ml-2" style="background: rgba(244, 63, 94, 0.12); color: #f43f5e; font-weight: 600; font-size: 0.85rem;">
                            <i class="fas fa-times-circle mr-1"></i> {{ $absent_atd }} {{ __('Absent') }}
                        </span>
                        <a href="{{ $studentAttendanceUrl }}" class="dash-card-link ml-3" style="font-size: 0.86rem;" onclick="showOverlay()">
                            {{ __('Student Attendance') }} <i class="fas fa-arrow-right"></i>
                        </a>
                        <a href="/staff/attendance" class="dash-card-link ml-3 text-muted" style="font-size: 0.86rem;" onclick="showOverlay()">
                            {{ __('Staff Attendance') }} <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                @if($totalMarked > 0)
                    <div class="atd-progress-track" title="{{ $presentRate }}% Present, {{ $absentRate }}% Absent">
                        <div class="atd-bar-present" style="width: {{ $presentRate }}%;"></div>
                        <div class="atd-bar-absent" style="width: {{ $absentRate }}%;"></div>
                    </div>
                    <div class="d-flex justify-content-between text-muted mt-2" style="font-size: 0.8rem;">
                        <span>Present Rate: <strong class="text-success">{{ $presentRate }}%</strong></span>
                        <span>Total Records Processed Today: <strong>{{ $totalMarked }}</strong></span>
                    </div>
                @else
                    <div class="atd-progress-track">
                        <div class="w-100 bg-secondary" style="opacity: 0.25;"></div>
                    </div>
                    <div class="text-muted mt-2" style="font-size: 0.8rem;">
                        <i class="fas fa-info-circle mr-1"></i> No student attendance recorded yet for today. <a href="{{ $studentAttendanceUrl }}" class="dash-card-link">Take student attendance now</a>.
                    </div>
                @endif
            </div>

            <!-- Charts Section: Main Trends (Line) & Expense Breakdown (Donut) -->
            <div class="row">
                <!-- Line Chart: Cash Flow / Profit & Expense Trends -->
                <div class="col-xl-8 col-lg-7 col-md-12 mb-4">
                    <div class="chart-panel">
                        <div class="chart-panel-header">
                            <div>
                                <h3 class="chart-title">
                                    <i class="fas fa-chart-line text-indigo" style="color: #6366f1;"></i>
                                    {{ __('Financial Performance & Cash Flow') }}
                                </h3>
                                <p class="text-muted m-0" style="font-size: 0.82rem;">Monthly breakdown of revenues vs operational expenditures</p>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <select id="year-filter" class="select-modern">
                                    @foreach($years as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                                <a href="/profit" class="btn btn-sm btn-outline-primary ml-2" style="border-radius: 8px; font-weight: 600;" onclick="showOverlay()">
                                    <i class="fas fa-external-link-alt mr-1"></i> Full Report
                                </a>
                            </div>
                        </div>

                        <!-- Dynamic KPI Pills for Selected Year -->
                        <div class="chart-kpis">
                            <div class="chart-kpi-item">
                                <span class="chart-kpi-label">{{ __('Total Revenue') }}</span>
                                <span class="chart-kpi-value kpi-profit" id="kpi-total-profit">$0.00</span>
                            </div>
                            <div class="chart-kpi-item">
                                <span class="chart-kpi-label">{{ __('Total Expenses') }}</span>
                                <span class="chart-kpi-value kpi-expense" id="kpi-total-expense">$0.00</span>
                            </div>
                            <div class="chart-kpi-item">
                                <span class="chart-kpi-label">{{ __('Net Balance') }}</span>
                                <span class="chart-kpi-value kpi-net" id="kpi-net-margin">$0.00</span>
                            </div>
                        </div>

                        <!-- Canvas -->
                        <div style="position: relative; height: 320px; width: 100%;">
                            <canvas id="profit-chart-canvas"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Doughnut Chart: Expense Breakdown -->
                <div class="col-xl-4 col-lg-5 col-md-12 mb-4">
                    <div class="chart-panel">
                        <div class="chart-panel-header">
                            <div>
                                <h3 class="chart-title">
                                    <i class="fas fa-chart-pie" style="color: #f43f5e;"></i>
                                    {{ __('Expense Distribution') }}
                                </h3>
                                <p class="text-muted m-0" style="font-size: 0.82rem;">Allocation by category</p>
                            </div>
                            <a href="/accounting" class="dash-card-link" style="font-size: 0.82rem;" onclick="showOverlay()">
                                {{ __('Accounting') }} <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>

                        <!-- Canvas Doughnut -->
                        <div style="position: relative; height: 260px; width: 100%; display: flex; align-items: center; justify-content: center;">
                            <canvas id="expenses-chart-canvas"></canvas>
                        </div>

                        <!-- Custom Category Legend Pills -->
                        <div id="expense-legend-container" class="mt-3" style="max-height: 120px; overflow-y: auto;">
                            <!-- Populated via JavaScript -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Access / Administrative Hub -->
            <div class="mb-4">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h4 class="font-weight-bold m-0" style="font-size: 1.05rem;">
                        <i class="fas fa-th-large mr-2 text-primary"></i> {{ __('Administrative Shortcuts') }}
                    </h4>
                    <span class="text-muted" style="font-size: 0.82rem;">Quick operations & settings</span>
                </div>
                <div class="shortcut-grid">
                    <a href="{{ !empty($defaultClassId) ? route('attendance.show', $defaultClassId) : '/attendance/class/62' }}" class="shortcut-item" onclick="showOverlay()">
                        <div class="shortcut-icon" style="color: #10b981; background: rgba(16, 185, 129, 0.12);"><i class="fas fa-user-check"></i></div>
                        <span class="shortcut-label">{{ __('Student Attendance') }}</span>
                    </a>
                    <a href="/staff/attendance" class="shortcut-item" onclick="showOverlay()">
                        <div class="shortcut-icon" style="color: #6366f1; background: rgba(99, 102, 241, 0.12);"><i class="fas fa-clipboard-check"></i></div>
                        <span class="shortcut-label">{{ __('Staff Attendance') }}</span>
                    </a>
                    <a href="/class-routines" class="shortcut-item" onclick="showOverlay()">
                        <div class="shortcut-icon"><i class="fas fa-calendar-alt"></i></div>
                        <span class="shortcut-label">{{ __('Class Routine') }}</span>
                    </a>
                    <a href="/classes-subject" class="shortcut-item" onclick="showOverlay()">
                        <div class="shortcut-icon"><i class="fas fa-book-open"></i></div>
                        <span class="shortcut-label">{{ __('Subjects') }}</span>
                    </a>
                    <a href="/departments" class="shortcut-item" onclick="showOverlay()">
                        <div class="shortcut-icon"><i class="fas fa-building"></i></div>
                        <span class="shortcut-label">{{ __('Departments') }}</span>
                    </a>
                    <a href="/profit" class="shortcut-item" onclick="showOverlay()">
                        <div class="shortcut-icon"><i class="fas fa-file-invoice-dollar"></i></div>
                        <span class="shortcut-label">{{ __('Accounting') }}</span>
                    </a>
                    <a href="/customize" class="shortcut-item" onclick="showOverlay()">
                        <div class="shortcut-icon"><i class="fas fa-sliders-h"></i></div>
                        <span class="shortcut-label">{{ __('Customization') }}</span>
                    </a>
                    <a href="/user-management" class="shortcut-item" onclick="showOverlay()">
                        <div class="shortcut-icon"><i class="fas fa-user-shield"></i></div>
                        <span class="shortcut-label">{{ __('User Access') }}</span>
                    </a>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div><!-- /.dash-container -->

    <!-- Charts Initialization Script -->
    <script>
        let profitChart = null;
        let expenseChart = null;

        // Check if dark mode is active
        function isDarkModeActive() {
            return document.documentElement.classList.contains('dark-mode') || 
                   document.body.classList.contains('dark-mode');
        }

        // Color palettes for themes
        function getChartThemeColors() {
            const isDark = isDarkModeActive();
            return {
                gridColor: isDark ? 'rgba(255, 255, 255, 0.08)' : 'rgba(0, 0, 0, 0.06)',
                textColor: isDark ? '#a1a1aa' : '#64748b',
                tooltipBg: isDark ? '#27272a' : '#1e293b',
                tooltipTitle: isDark ? '#f4f4f5' : '#ffffff',
                tooltipBody: isDark ? '#e4e4e7' : '#f8fafc',
                cardBg: isDark ? '#202020' : '#ffffff'
            };
        }

        // Format currency helper
        function formatCurrency(val) {
            const num = parseFloat(val) || 0;
            return '$' + num.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        // 1. Load Line Chart (Profit vs Expense)
        function loadProfitChart(year) {
            fetch(`/dashboard/chart-data?year=${year}`)
                .then(response => response.json())
                .then(data => {
                    const canvas = document.getElementById('profit-chart-canvas');
                    if (!canvas) return;
                    const ctx = canvas.getContext('2d');
                    const colors = getChartThemeColors();

                    const profits = (data.profits || []).map(v => parseFloat(v) || 0);
                    const expenses = (data.expenses || []).map(v => parseFloat(v) || 0);
                    const labels = data.labels || [];

                    // Calculate KPI sums
                    const sumProfit = profits.reduce((a, b) => a + b, 0);
                    const sumExpense = expenses.reduce((a, b) => a + b, 0);
                    const netMargin = sumProfit - sumExpense;

                    // Update KPI display
                    const elProfit = document.getElementById('kpi-total-profit');
                    const elExpense = document.getElementById('kpi-total-expense');
                    const elNet = document.getElementById('kpi-net-margin');

                    if (elProfit) elProfit.textContent = formatCurrency(sumProfit);
                    if (elExpense) elExpense.textContent = formatCurrency(sumExpense);
                    if (elNet) {
                        elNet.textContent = formatCurrency(netMargin);
                        elNet.className = 'chart-kpi-value ' + (netMargin >= 0 ? 'kpi-profit' : 'kpi-expense');
                    }

                    // Gradients for area under curves
                    const profitGradient = ctx.createLinearGradient(0, 0, 0, 300);
                    profitGradient.addColorStop(0, 'rgba(16, 185, 129, 0.35)');
                    profitGradient.addColorStop(1, 'rgba(16, 185, 129, 0.0)');

                    const expenseGradient = ctx.createLinearGradient(0, 0, 0, 300);
                    expenseGradient.addColorStop(0, 'rgba(239, 68, 68, 0.3)');
                    expenseGradient.addColorStop(1, 'rgba(239, 68, 68, 0.0)');

                    if (profitChart) {
                        profitChart.destroy();
                    }

                    profitChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels.length ? labels : ['No Data'],
                            datasets: [
                                {
                                    label: 'Revenue / Profit',
                                    data: profits.length ? profits : [0],
                                    backgroundColor: profitGradient,
                                    borderColor: '#10b981',
                                    borderWidth: 2.5,
                                    pointBackgroundColor: '#10b981',
                                    pointBorderColor: '#ffffff',
                                    pointBorderWidth: 2,
                                    pointRadius: 4,
                                    pointHoverRadius: 6,
                                    tension: 0.38,
                                    fill: true
                                },
                                {
                                    label: 'Expenditure',
                                    data: expenses.length ? expenses : [0],
                                    backgroundColor: expenseGradient,
                                    borderColor: '#ef4444',
                                    borderWidth: 2.5,
                                    pointBackgroundColor: '#ef4444',
                                    pointBorderColor: '#ffffff',
                                    pointBorderWidth: 2,
                                    pointRadius: 4,
                                    pointHoverRadius: 6,
                                    tension: 0.38,
                                    fill: true
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: {
                                mode: 'index',
                                intersect: false
                            },
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top',
                                    labels: {
                                        color: colors.textColor,
                                        font: { family: "'Nunito', sans-serif", weight: '600', size: 12 },
                                        usePointStyle: true,
                                        boxWidth: 8
                                    }
                                },
                                tooltip: {
                                    backgroundColor: colors.tooltipBg,
                                    titleColor: colors.tooltipTitle,
                                    bodyColor: colors.tooltipBody,
                                    padding: 12,
                                    cornerRadius: 10,
                                    boxPadding: 6,
                                    usePointStyle: true,
                                    callbacks: {
                                        label: function(context) {
                                            return `${context.dataset.label}: ${formatCurrency(context.raw)}`;
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    grid: { display: false },
                                    ticks: {
                                        color: colors.textColor,
                                        font: { family: "'Nunito', sans-serif", size: 11 }
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: colors.gridColor,
                                        drawBorder: false
                                    },
                                    ticks: {
                                        color: colors.textColor,
                                        font: { family: "'Nunito', sans-serif", size: 11 },
                                        callback: function(value) {
                                            return '$' + value.toLocaleString();
                                        }
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(err => console.error("Error loading profit chart:", err));
        }

        // 2. Load Doughnut Chart (Expense Category Breakdown)
        function loadExpenseChart() {
            const canvas = document.getElementById('expenses-chart-canvas');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            const colors = getChartThemeColors();

            const rawLabels = @json($expenseLabels ?? []);
            const rawData = @json($expenseData ?? []);

            const expenseLabels = rawLabels.length ? rawLabels : ['No Expenses'];
            const expenseData = rawData.length ? rawData.map(v => parseFloat(v) || 0) : [1];
            const hasData = rawData.length > 0 && rawData.some(v => parseFloat(v) > 0);

            const palette = [
                '#f43f5e', '#f59e0b', '#3b82f6', '#10b981', '#8b5cf6', 
                '#ec4899', '#06b6d4', '#84cc16', '#64748b'
            ];

            if (expenseChart) {
                expenseChart.destroy();
            }

            expenseChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: expenseLabels,
                    datasets: [{
                        data: hasData ? expenseData : [1],
                        backgroundColor: hasData ? palette.slice(0, expenseLabels.length) : ['#94a3b8'],
                        borderWidth: 3,
                        borderColor: colors.cardBg,
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '72%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            enabled: hasData,
                            backgroundColor: colors.tooltipBg,
                            titleColor: colors.tooltipTitle,
                            bodyColor: colors.tooltipBody,
                            padding: 10,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    return ` ${context.label}: ${formatCurrency(context.raw)}`;
                                }
                            }
                        }
                    }
                }
            });

            // Populate custom category legend pills
            const legendContainer = document.getElementById('expense-legend-container');
            if (legendContainer) {
                legendContainer.innerHTML = '';
                if (!hasData) {
                    legendContainer.innerHTML = `<div class="text-center text-muted" style="font-size: 0.8rem;">No expense categories recorded</div>`;
                    return;
                }
                const total = expenseData.reduce((a, b) => a + b, 0);
                expenseLabels.forEach((label, idx) => {
                    const amt = expenseData[idx] || 0;
                    const pct = total > 0 ? Math.round((amt / total) * 100) : 0;
                    const dotColor = palette[idx % palette.length];

                    const item = document.createElement('div');
                    item.className = 'd-flex align-items-center justify-content-between py-1';
                    item.style.fontSize = '0.8rem';
                    item.innerHTML = `
                        <div class="d-flex align-items-center text-truncate mr-2">
                            <span style="display:inline-block; width:9px; height:9px; border-radius:50%; background-color:${dotColor}; margin-right:8px; flex-shrink:0;"></span>
                            <span class="text-truncate font-weight-600">${label}</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted mr-2">${pct}%</span>
                            <span class="font-weight-bold">${formatCurrency(amt)}</span>
                        </div>
                    `;
                    legendContainer.appendChild(item);
                });
            }
        }

        // Initialize dashboard charts
        document.addEventListener('DOMContentLoaded', function () {
            const yearFilter = document.getElementById('year-filter');
            const initialYear = yearFilter ? yearFilter.value : new Date().getFullYear();
            
            loadProfitChart(initialYear);
            loadExpenseChart();

            if (yearFilter) {
                yearFilter.addEventListener('change', function () {
                    loadProfitChart(this.value);
                });
            }

            // Re-render charts on theme switch so colors adapt cleanly
            const themeSwitch = document.getElementById('themeSwitch');
            if (themeSwitch) {
                themeSwitch.addEventListener('change', function() {
                    setTimeout(() => {
                        loadProfitChart(yearFilter ? yearFilter.value : initialYear);
                        loadExpenseChart();
                    }, 250);
                });
            }
        });
    </script>
@endsection
