@extends('layout.main')

@section('title', __('Online Student Admissions'))

@section('content')

<style>
/* ══════════════════════════════════════════════════════════════════
   STUDENT ADMISSIONS – Executive SaaS Design System
══════════════════════════════════════════════════════════════════ */
.adm-dashboard-wrapper {
    padding: 0.5rem 0.25rem 2.5rem;
}

/* Header Box */
.adm-header-box {
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
.adm-header-box::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 5px;
    height: 100%;
    background: linear-gradient(180deg, #0ea5e9, #10b981);
}
html.dark-mode .adm-header-box {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 24px -2px rgba(0, 0, 0, 0.35);
}

.adm-header-title {
    font-size: 1.35rem;
    font-weight: 800;
    margin-bottom: 0.2rem;
    display: flex;
    align-items: center;
    gap: 0.65rem;
    color: #1e293b;
}
html.dark-mode .adm-header-title {
    color: #f8fafc;
}

.adm-header-subtitle {
    font-size: 0.85rem;
    color: #64748b;
    margin: 0;
}
html.dark-mode .adm-header-subtitle {
    color: #94a3b8;
}

.adm-action-group {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    flex-wrap: wrap;
}

.btn-adm {
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
.btn-adm-primary {
    background: linear-gradient(135deg, #0ea5e9, #0284c7);
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(14, 165, 233, 0.25);
}
.btn-adm-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(14, 165, 233, 0.35);
    background: linear-gradient(135deg, #0284c7, #0369a1);
}
.btn-adm-secondary {
    background: #f1f5f9;
    color: #334155 !important;
    border-color: #cbd5e1;
}
.btn-adm-secondary:hover {
    background: #e2e8f0;
    color: #0f172a !important;
}
html.dark-mode .btn-adm-secondary {
    background: #282f48;
    color: #e2e8f0 !important;
    border-color: #3b4261;
}
html.dark-mode .btn-adm-secondary:hover {
    background: #333c5e;
}

/* KPI Cards Grid */
.adm-kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem;
    margin-bottom: 1.25rem;
}

.adm-kpi-card {
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
.adm-kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
}
html.dark-mode .adm-kpi-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.25);
}

.adm-kpi-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}
.kpi-sky     { background: rgba(14, 165, 233, 0.12); color: #0ea5e9; }
.kpi-emerald { background: rgba(16, 185, 129, 0.12); color: #10b981; }
.kpi-amber   { background: rgba(245, 158, 11, 0.12); color: #f59e0b; }
.kpi-rose    { background: rgba(244, 63, 94, 0.12); color: #f43f5e; }

.adm-kpi-value {
    font-size: 1.55rem;
    font-weight: 800;
    line-height: 1.1;
    color: #0f172a;
}
html.dark-mode .adm-kpi-value {
    color: #f8fafc;
}
.adm-kpi-label {
    font-size: 0.78rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: #64748b;
    margin-top: 0.15rem;
}
html.dark-mode .adm-kpi-label {
    color: #94a3b8;
}

/* Main Table Card */
.adm-main-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.04);
}
html.dark-mode .adm-main-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 24px -2px rgba(0, 0, 0, 0.35);
}

.adm-toolbar {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.85rem;
    background: #f8fafc;
}
html.dark-mode .adm-toolbar {
    background: #191c2b;
    border-color: #2e354f;
}

.adm-filter-tabs {
    display: flex;
    align-items: center;
    gap: 0.35rem;
    background: #e2e8f0;
    padding: 0.25rem;
    border-radius: 10px;
}
html.dark-mode .adm-filter-tabs {
    background: #252a3d;
}
.adm-filter-pill {
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
.adm-filter-pill:hover {
    color: #1e293b;
}
.adm-filter-pill.active {
    background: #ffffff;
    color: #0284c7;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
}
html.dark-mode .adm-filter-pill {
    color: #94a3b8;
}
html.dark-mode .adm-filter-pill.active {
    background: #1e2235;
    color: #38bdf8;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
}
.adm-filter-count {
    font-size: 0.72rem;
    padding: 0.1rem 0.4rem;
    border-radius: 10px;
    background: rgba(100, 116, 139, 0.15);
}
.adm-filter-pill.active .adm-filter-count {
    background: rgba(14, 165, 233, 0.15);
}

.adm-search-box {
    position: relative;
    min-width: 250px;
    max-width: 380px;
    flex: 1;
}
.adm-search-input {
    width: 100%;
    padding: 0.45rem 1rem 0.45rem 2.25rem;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 0.875rem;
    background: #ffffff;
    color: #1e293b;
    transition: all 0.2s;
}
.adm-search-input:focus {
    outline: none;
    border-color: #0ea5e9;
    box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.15);
}
html.dark-mode .adm-search-input {
    background: #252a3d;
    border-color: #3b4261;
    color: #f1f5f9;
}
.adm-search-icon {
    position: absolute;
    left: 0.8rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.85rem;
    pointer-events: none;
}

/* Modern Table */
.adm-table {
    margin: 0;
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}
.adm-table thead th {
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
html.dark-mode .adm-table thead th {
    background: #191c2b;
    color: #94a3b8;
    border-color: #2e354f;
}
.adm-table tbody td {
    padding: 0.95rem 1rem;
    vertical-align: middle;
    border-top: none;
    border-bottom: 1px solid #f1f5f9;
    font-size: 0.88rem;
    color: #334155;
}
html.dark-mode .adm-table tbody td {
    border-color: #262c44;
    color: #cbd5e1;
}
.adm-table tbody tr:hover {
    background: #f8fafc;
}
html.dark-mode .adm-table tbody tr:hover {
    background: #22273c;
}

/* Applicant Avatar & Badges */
.adm-avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, #e0f2fe, #bae6fd);
    color: #0369a1;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.85rem;
    flex-shrink: 0;
}
html.dark-mode .adm-avatar {
    background: linear-gradient(135deg, #075985, #0284c7);
    color: #e0f2fe;
}

.adm-name {
    font-weight: 700;
    color: #0f172a;
    font-size: 0.92rem;
    line-height: 1.2;
}
html.dark-mode .adm-name {
    color: #f8fafc;
}

.adm-contact-item {
    font-size: 0.8rem;
    color: #475569;
    display: flex;
    align-items: center;
    gap: 0.35rem;
}
html.dark-mode .adm-contact-item {
    color: #cbd5e1;
}

.course-chip {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.78rem;
    font-weight: 600;
    color: #0369a1;
    background: rgba(14, 165, 233, 0.08);
    border: 1px solid rgba(14, 165, 233, 0.2);
    padding: 0.2rem 0.6rem;
    border-radius: 8px;
}
html.dark-mode .course-chip {
    background: rgba(14, 165, 233, 0.18);
    color: #38bdf8;
    border-color: rgba(14, 165, 233, 0.35);
}

.country-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.78rem;
    padding: 0.15rem 0.5rem;
    border-radius: 6px;
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #e2e8f0;
}
html.dark-mode .country-pill {
    background: #252a3d;
    color: #94a3b8;
    border-color: #3b4261;
}

/* Status Badges */
.status-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.25rem 0.65rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: capitalize;
}
.status-approved {
    background: rgba(16, 185, 129, 0.12);
    color: #059669;
    border: 1px solid rgba(16, 185, 129, 0.25);
}
html.dark-mode .status-approved {
    background: rgba(16, 185, 129, 0.2);
    color: #34d399;
}
.status-pending {
    background: rgba(245, 158, 11, 0.12);
    color: #d97706;
    border: 1px solid rgba(245, 158, 11, 0.25);
}
html.dark-mode .status-pending {
    background: rgba(245, 158, 11, 0.2);
    color: #fbbf24;
}
.status-rejected {
    background: rgba(239, 68, 68, 0.12);
    color: #dc2626;
    border: 1px solid rgba(239, 68, 68, 0.25);
}
html.dark-mode .status-rejected {
    background: rgba(239, 68, 68, 0.2);
    color: #f87171;
}

.pulse-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    display: inline-block;
}
.pulse-dot-green { background: #10b981; box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.3); }
.pulse-dot-amber { background: #f59e0b; box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.3); animation: pulseAmber 1.6s infinite; }
.pulse-dot-red   { background: #ef4444; box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.3); }
@keyframes pulseAmber {
    0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.5); }
    70% { transform: scale(1.05); box-shadow: 0 0 0 6px rgba(245, 158, 11, 0); }
    100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
}

/* Action Icon Buttons */
.adm-actions-group {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 0.35rem;
}
.btn-action-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #e2e8f0;
    transition: all 0.15s ease;
    font-size: 0.8rem;
    text-decoration: none !important;
    cursor: pointer;
}
.btn-action-icon:hover { transform: translateY(-1px); }
.btn-action-view:hover { background: #e0f2fe; color: #0284c7; border-color: #bae6fd; }
.btn-action-approve:hover { background: #dcfce7; color: #16a34a; border-color: #bbf7d0; }
.btn-action-reject:hover { background: #fee2e2; color: #dc2626; border-color: #fca5a5; }
.btn-action-delete:hover { background: #fee2e2; color: #dc2626; border-color: #fca5a5; }

html.dark-mode .btn-action-icon {
    background: #252a3d;
    border-color: #3b4261;
    color: #94a3b8;
}
html.dark-mode .btn-action-view:hover { background: #0369a1; color: #ffffff; }
html.dark-mode .btn-action-approve:hover { background: #15803d; color: #ffffff; }
html.dark-mode .btn-action-reject:hover { background: #b91c1c; color: #ffffff; }
html.dark-mode .btn-action-delete:hover { background: #b91c1c; color: #ffffff; }
</style>

@php
    $totalApplications = count($admissions);
    $approvedCount = $admissions->where('status', 'approved')->count();
    $pendingCount = $admissions->where('status', 'pending')->count();
    $rejectedCount = $admissions->where('status', 'rejected')->count();

    // Map common country ISO codes to country names
    $countryMap = [
        'kh' => 'Cambodia', 'us' => 'United States', 'fr' => 'France', 'jp' => 'Japan',
        'cn' => 'China', 'vn' => 'Vietnam', 'th' => 'Thailand', 'kr' => 'South Korea',
        'sg' => 'Singapore', 'my' => 'Malaysia', 'ph' => 'Philippines', 'id' => 'Indonesia',
        'in' => 'India', 'gb' => 'United Kingdom', 'de' => 'Germany', 'au' => 'Australia',
        'ca' => 'Canada'
    ];
@endphp

<div class="adm-dashboard-wrapper">
    <!-- Header Banner -->
    <div class="adm-header-box">
        <div>
            <div class="adm-header-title">
                <i class="fas fa-user-graduate text-primary"></i>
                {{ __('Online Student Admissions') }}
            </div>
            <p class="adm-header-subtitle">
                {{ __('Review matriculation applications, verify student records, and manage admissions approval.') }}
            </p>
        </div>

        <div class="adm-action-group">
            <a href="{{ route('students.index') }}" class="btn-adm btn-adm-secondary" title="{{ __('View Student Roster') }}">
                <i class="fas fa-users text-primary"></i>
                <span>{{ __('Student Directory') }}</span>
            </a>

            <a href="{{ route('students.create') }}" class="btn-adm btn-adm-primary" title="{{ __('Manual Registration') }}">
                <i class="fas fa-user-plus"></i>
                <span>{{ __('Add New Student') }}</span>
            </a>
        </div>
    </div>

    <!-- Top KPI Metric Cards -->
    <div class="adm-kpi-grid">
        <div class="adm-kpi-card">
            <div class="adm-kpi-icon kpi-sky">
                <i class="fas fa-file-signature"></i>
            </div>
            <div>
                <div class="adm-kpi-value">{{ $totalApplications }}</div>
                <div class="adm-kpi-label">{{ __('Total Applications') }}</div>
            </div>
        </div>

        <div class="adm-kpi-card">
            <div class="adm-kpi-icon kpi-emerald">
                <i class="fas fa-user-check"></i>
            </div>
            <div>
                <div class="adm-kpi-value">{{ $approvedCount }}</div>
                <div class="adm-kpi-label">{{ __('Approved Enrollees') }}</div>
            </div>
        </div>

        <div class="adm-kpi-card">
            <div class="adm-kpi-icon kpi-amber">
                <i class="fas fa-user-clock"></i>
            </div>
            <div>
                <div class="adm-kpi-value">{{ $pendingCount }}</div>
                <div class="adm-kpi-label">{{ __('Pending Review') }}</div>
            </div>
        </div>

        <div class="adm-kpi-card">
            <div class="adm-kpi-icon kpi-rose">
                <i class="fas fa-user-times"></i>
            </div>
            <div>
                <div class="adm-kpi-value">{{ $rejectedCount }}</div>
                <div class="adm-kpi-label">{{ __('Rejected Applications') }}</div>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="adm-main-card">
        <!-- Toolbar -->
        <div class="adm-toolbar">
            <div class="adm-filter-tabs">
                <button type="button" class="adm-filter-pill active" data-filter="all">
                    <span>{{ __('All') }}</span>
                    <span class="adm-filter-count">{{ $totalApplications }}</span>
                </button>
                <button type="button" class="adm-filter-pill" data-filter="pending">
                    <span>{{ __('Pending') }}</span>
                    <span class="adm-filter-count">{{ $pendingCount }}</span>
                </button>
                <button type="button" class="adm-filter-pill" data-filter="approved">
                    <span>{{ __('Approved') }}</span>
                    <span class="adm-filter-count">{{ $approvedCount }}</span>
                </button>
                <button type="button" class="adm-filter-pill" data-filter="rejected">
                    <span>{{ __('Rejected') }}</span>
                    <span class="adm-filter-count">{{ $rejectedCount }}</span>
                </button>
            </div>

            <div class="adm-search-box">
                <i class="fas fa-search adm-search-icon"></i>
                <input type="text" id="admSearchInput" class="adm-search-input" placeholder="{{ __('Search applicant, email, phone, course, city, country...') }}" autocomplete="off">
            </div>
        </div>

        <!-- Responsive Table -->
        <div class="table-responsive">
            <table class="table adm-table" id="admissionMasterTable">
                <thead>
                    <tr>
                        <th style="width: 45px;">#</th>
                        <th>{{ __('Applicant Profile') }}</th>
                        <th>{{ __('Contact Information') }}</th>
                        <th>{{ __('Course Applied') }}</th>
                        <th>{{ __('Origin / Location') }}</th>
                        <th>{{ __('Application Date') }}</th>
                        <th>{{ __('Approval Status') }}</th>
                        <th style="width: 140px;" class="text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody id="admTableBody">
                    @forelse ($admissions as $index => $admission)
                        @php
                            $searchBlob = strtolower(implode(' ', [
                                $admission->full_name ?? '',
                                $admission->email ?? '',
                                $admission->phone ?? '',
                                $admission->city ?? '',
                                $admission->country ?? '',
                                $admission->course ?? '',
                                $admission->subject ?? '',
                                $admission->status ?? '',
                            ]));

                            $countryRaw = strtolower(trim($admission->country ?? ''));
                            $displayCountry = $countryMap[$countryRaw] ?? ($admission->country ?: __('N/A'));
                            $hasIsoFlag = strlen($countryRaw) === 2;
                        @endphp
                        <tr class="adm-row"
                            data-search="{{ $searchBlob }}"
                            data-status="{{ $admission->status ?? 'pending' }}">
                            <td class="text-muted font-weight-bold" style="font-size: 0.8rem;">
                                {{ $index + 1 }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="adm-avatar mr-2.5">
                                        {{ strtoupper(mb_substr($admission->full_name ?? 'A', 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="adm-name">
                                            <a href="{{ route('studentsAdmission.show', $admission->id) }}" class="text-dark text-decoration-none">
                                                {{ $admission->full_name }}
                                            </a>
                                        </div>
                                        <div class="d-flex align-items-center mt-0.5" style="gap: 0.35rem;">
                                            <span class="badge badge-light border text-muted small">
                                                #APP-{{ str_pad($admission->id, 4, '0', STR_PAD_LEFT) }}
                                            </span>
                                            @if($admission->gender)
                                                <span class="badge badge-light border small text-primary">
                                                    {{ $admission->gender }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="adm-contact-item mb-1">
                                    <i class="far fa-envelope text-primary"></i>
                                    <a href="mailto:{{ $admission->email }}" class="text-dark text-decoration-none">{{ $admission->email }}</a>
                                </div>
                                <div class="adm-contact-item">
                                    <i class="fas fa-phone-alt text-secondary"></i>
                                    <span>{{ $admission->phone }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="course-chip">
                                    <i class="fas fa-book-open"></i>
                                    {{ $admission->course ?: __('General Program') }}
                                </span>
                                @if($admission->subject)
                                    <div class="text-muted small mt-1">
                                        {{ __('Subject:') }} {{ $admission->subject }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <span class="country-pill">
                                    @if($hasIsoFlag)
                                        <img src="https://flagcdn.com/20x15/{{ $countryRaw }}.png" width="18" height="13" class="mr-1" alt="flag">
                                    @else
                                        <i class="fas fa-globe-americas mr-1 text-secondary"></i>
                                    @endif
                                    {{ $displayCountry }}
                                </span>
                                @if($admission->city)
                                    <div class="text-muted small mt-0.5">
                                        <i class="fas fa-map-marker-alt text-muted mr-1"></i>{{ $admission->city }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="small text-muted font-weight-500">
                                    <i class="far fa-calendar-alt text-primary mr-1"></i>
                                    {{ \Carbon\Carbon::parse($admission->created_at)->format('d M Y') }}
                                </div>
                            </td>
                            <td>
                                @if($admission->status == 'approved')
                                    <span class="status-pill status-approved">
                                        <span class="pulse-dot pulse-dot-green"></span>
                                        {{ __('Approved') }}
                                    </span>
                                @elseif($admission->status == 'rejected')
                                    <span class="status-pill status-rejected">
                                        <span class="pulse-dot pulse-dot-red"></span>
                                        {{ __('Rejected') }}
                                    </span>
                                @else
                                    <span class="status-pill status-pending">
                                        <span class="pulse-dot pulse-dot-amber"></span>
                                        {{ __('Pending') }}
                                    </span>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="adm-actions-group">
                                    @if(Auth::user()->role == 0 && $admission->status == 'pending')
                                        <button type="button" class="btn-action-icon btn-action-approve approve-btn" data-id="{{ $admission->id }}" title="{{ __('Approve Admission') }}">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button type="button" class="btn-action-icon btn-action-reject reject-btn" data-id="{{ $admission->id }}" title="{{ __('Reject Admission') }}">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif

                                    <a href="{{ route('studentsAdmission.show', $admission->id) }}" class="btn-action-icon btn-action-view" title="{{ __('View Application') }}">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    @if(Auth::user()->role == 0)
                                        <form action="{{ route('admissions.destroy', $admission->id) }}" method="POST" class="d-inline delete-adm-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action-icon btn-action-delete" title="{{ __('Delete Application') }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fas fa-user-graduate fa-3x mb-3 text-secondary opacity-50 d-block"></i>
                                <h6>{{ __('No student admissions found') }}</h6>
                                <p class="small text-muted mb-0">{{ __('Applications submitted through the online admission portal will appear here.') }}</p>
                            </td>
                        </tr>
                    @endforelse
                    <tr id="noResultsRow" style="display: none;">
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="fas fa-search fa-2x mb-2 text-secondary opacity-50 d-block"></i>
                            <h6>{{ __('No matching applications found') }}</h6>
                            <p class="small text-muted mb-0">{{ __('Try adjusting your search query or filters.') }}</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // ══════════════════════════════════════════════════════════════════
    // Instant Live Filtering & Search
    // ══════════════════════════════════════════════════════════════════
    const searchInput = document.getElementById('admSearchInput');
    const filterPills = document.querySelectorAll('.adm-filter-pill');
    const tableRows = document.querySelectorAll('.adm-row');
    const noResultsRow = document.getElementById('noResultsRow');

    let currentFilter = 'all';

    function applyFilters() {
        const query = (searchInput.value || '').trim().toLowerCase();
        let visibleCount = 0;

        tableRows.forEach(row => {
            const rowSearch = row.getAttribute('data-search') || '';
            const rowStatus = row.getAttribute('data-status') || '';

            const matchesSearch = !query || rowSearch.includes(query);
            const matchesFilter = (currentFilter === 'all') || (rowStatus === currentFilter);

            if (matchesSearch && matchesFilter) {
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
            currentFilter = this.getAttribute('data-filter');
            applyFilters();
        });
    });

    // ══════════════════════════════════════════════════════════════════
    // SweetAlert2 Quick Approve
    // ══════════════════════════════════════════════════════════════════
    document.querySelectorAll('.approve-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.getAttribute('data-id');

            Swal.fire({
                title: '{{ __("Approve Admission Application?") }}',
                text: '{{ __("Approving this application will automatically generate student and guardian portal accounts.") }}',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#64748b',
                confirmButtonText: '{{ __("Yes, Approve") }}',
                cancelButtonText: '{{ __("Cancel") }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: '{{ __("Processing...") }}',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    fetch(`/admissions/${id}/approve`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.error) {
                            Swal.fire({
                                icon: 'error',
                                title: '{{ __("Approval Failed") }}',
                                text: data.error
                            });
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: '{{ __("Approved!") }}',
                                text: data.success || '{{ __("Admission request approved successfully.") }}',
                                confirmButtonText: '{{ __("OK") }}'
                            }).then(() => location.reload());
                        }
                    })
                    .catch(err => {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __("Error") }}',
                            text: '{{ __("Failed to approve admission.") }}'
                        });
                    });
                }
            });
        });
    });

    // ══════════════════════════════════════════════════════════════════
    // SweetAlert2 Quick Reject
    // ══════════════════════════════════════════════════════════════════
    document.querySelectorAll('.reject-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.getAttribute('data-id');

            Swal.fire({
                title: '{{ __("Reject Admission Application?") }}',
                text: '{{ __("Are you sure you want to reject this applicant?") }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: '{{ __("Yes, Reject") }}',
                cancelButtonText: '{{ __("Cancel") }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: '{{ __("Processing...") }}',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    fetch(`/admissions/${id}/reject`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(r => r.json())
                    .then(data => {
                        Swal.fire({
                            icon: 'success',
                            title: '{{ __("Rejected") }}',
                            text: data.success || '{{ __("Admission request has been rejected.") }}',
                            confirmButtonText: '{{ __("OK") }}'
                        }).then(() => location.reload());
                    })
                    .catch(err => {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __("Error") }}',
                            text: '{{ __("Failed to reject admission.") }}'
                        });
                    });
                }
            });
        });
    });

    // ══════════════════════════════════════════════════════════════════
    // Delete Confirmation with SweetAlert2
    // ══════════════════════════════════════════════════════════════════
    document.querySelectorAll('.delete-adm-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: '{{ __("Delete Admission Application?") }}',
                text: '{{ __("Are you sure you want to permanently delete this application record?") }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: '{{ __("Yes, Delete") }}',
                cancelButtonText: '{{ __("Cancel") }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>

@endsection
