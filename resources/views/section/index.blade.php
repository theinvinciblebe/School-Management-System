@extends('layout.main')

@section('title', __('Section Management'))

@section('content')

@php
    $canManage = in_array((int)Auth::user()->role, [0, 3, 4]);
@endphp

<style>
/* ══════════════════════════════════════════════════════════════════
   SECTION MANAGEMENT – Executive SaaS Design System
══════════════════════════════════════════════════════════════════ */
.sec-dashboard-wrapper {
    padding: 0.5rem 0.25rem 2.5rem;
}

/* Header Action Banner */
.sec-header-box {
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
}
html.dark-mode .sec-header-box {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 24px -2px rgba(0, 0, 0, 0.35);
}

.sec-header-title {
    font-size: 1.35rem;
    font-weight: 800;
    margin-bottom: 0.2rem;
    display: flex;
    align-items: center;
    gap: 0.65rem;
    color: #1e293b;
}
html.dark-mode .sec-header-title {
    color: #f8fafc;
}

.sec-header-subtitle {
    font-size: 0.85rem;
    color: #64748b;
    margin: 0;
}
html.dark-mode .sec-header-subtitle {
    color: #94a3b8;
}

.sec-action-btn-group {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    flex-wrap: wrap;
}

.sec-btn {
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
.sec-btn-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
}
.sec-btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
}
.sec-btn-secondary {
    background: #f1f5f9;
    color: #334155 !important;
    border-color: #cbd5e1;
}
.sec-btn-secondary:hover {
    background: #e2e8f0;
    color: #0f172a !important;
}
html.dark-mode .sec-btn-secondary {
    background: #282f48;
    color: #e2e8f0 !important;
    border-color: #3b4261;
}
html.dark-mode .sec-btn-secondary:hover {
    background: #333c5e;
}

/* KPI Cards Grid */
.sec-kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem;
    margin-bottom: 1.25rem;
}

.sec-kpi-card {
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
.sec-kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
}
html.dark-mode .sec-kpi-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.25);
}

.sec-kpi-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}
.kpi-indigo  { background: rgba(99, 102, 241, 0.12); color: #6366f1; }
.kpi-sky     { background: rgba(14, 165, 233, 0.12); color: #0ea5e9; }
.kpi-emerald { background: rgba(16, 185, 129, 0.12); color: #10b981; }
.kpi-amber   { background: rgba(245, 158, 11, 0.12); color: #f59e0b; }

.sec-kpi-value {
    font-size: 1.6rem;
    font-weight: 800;
    line-height: 1.1;
    color: #0f172a;
}
html.dark-mode .sec-kpi-value {
    color: #f8fafc;
}
.sec-kpi-label {
    font-size: 0.78rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: #64748b;
    margin-top: 0.15rem;
}
html.dark-mode .sec-kpi-label {
    color: #94a3b8;
}

/* Class Switcher Toolbar */
.sec-switcher-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 1.15rem 1.5rem;
    margin-bottom: 1.25rem;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.04);
}
html.dark-mode .sec-switcher-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 24px -2px rgba(0, 0, 0, 0.35);
}

.sec-switcher-grid {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
}

.sec-select-wrap {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex: 1;
    min-width: 280px;
    max-width: 480px;
}
.sec-select-label {
    font-size: 0.85rem;
    font-weight: 700;
    color: #475569;
    white-space: nowrap;
    margin-bottom: 0;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}
html.dark-mode .sec-select-label {
    color: #cbd5e1;
}

.sec-class-dropdown {
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-weight: 600;
    padding: 0.55rem 0.85rem;
    font-size: 0.9rem;
    background-color: #ffffff;
    color: #0f172a;
    transition: all 0.2s;
}
.sec-class-dropdown:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}
html.dark-mode .sec-class-dropdown {
    background-color: #252a3d;
    border-color: #3b4261;
    color: #f1f5f9;
}

/* Class Metadata Bar */
.sec-class-meta {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    flex-wrap: wrap;
}
.sec-meta-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.35rem 0.75rem;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 600;
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #e2e8f0;
}
html.dark-mode .sec-meta-pill {
    background: #252a3d;
    color: #cbd5e1;
    border-color: #3b4261;
}

/* Main Content Card (NO NESTED CARDS) */
.sec-main-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.04);
}
html.dark-mode .sec-main-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 24px -2px rgba(0, 0, 0, 0.35);
}

.sec-card-toolbar {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.85rem;
    background: #f8fafc;
}
html.dark-mode .sec-card-toolbar {
    background: #191c2b;
    border-color: #2e354f;
}

.sec-search-box {
    position: relative;
    min-width: 240px;
    max-width: 340px;
    flex: 1;
}
.sec-search-input {
    width: 100%;
    padding: 0.45rem 1rem 0.45rem 2.25rem;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 0.875rem;
    background: #ffffff;
    color: #1e293b;
    transition: all 0.2s;
}
.sec-search-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}
html.dark-mode .sec-search-input {
    background: #252a3d;
    border-color: #3b4261;
    color: #f1f5f9;
}
.sec-search-icon {
    position: absolute;
    left: 0.8rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.85rem;
    pointer-events: none;
}

/* Table Styling */
.sec-table {
    margin: 0;
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}
.sec-table thead th {
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
html.dark-mode .sec-table thead th {
    background: #191c2b;
    color: #94a3b8;
    border-color: #2e354f;
}
.sec-table tbody td {
    padding: 0.9rem 1rem;
    vertical-align: middle;
    border-top: none;
    border-bottom: 1px solid #f1f5f9;
    font-size: 0.88rem;
    color: #334155;
}
html.dark-mode .sec-table tbody td {
    border-color: #262c44;
    color: #cbd5e1;
}
.sec-table tbody tr:hover {
    background: #f8fafc;
}
html.dark-mode .sec-table tbody tr:hover {
    background: #22273c;
}

/* Badges & Pills */
.sec-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.25rem 0.65rem;
    border-radius: 8px;
    font-size: 0.78rem;
    font-weight: 600;
    line-height: 1.2;
}
.sec-badge-schedule {
    background: rgba(14, 165, 233, 0.1);
    color: #0284c7;
    border: 1px solid rgba(14, 165, 233, 0.2);
    white-space: nowrap;
}
html.dark-mode .sec-badge-schedule {
    background: rgba(14, 165, 233, 0.15);
    color: #38bdf8;
    border-color: rgba(14, 165, 233, 0.3);
}
.sec-badge-time {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
    border: 1px solid rgba(16, 185, 129, 0.2);
    font-family: monospace;
    font-size: 0.82rem;
    white-space: nowrap;
}
html.dark-mode .sec-badge-time {
    background: rgba(16, 185, 129, 0.15);
    color: #34d399;
    border-color: rgba(16, 185, 129, 0.3);
}
.sec-badge-student {
    background: rgba(139, 92, 246, 0.1);
    color: #7c3aed;
    border: 1px solid rgba(139, 92, 246, 0.2);
}
html.dark-mode .sec-badge-student {
    background: rgba(139, 92, 246, 0.18);
    color: #a78bfa;
    border-color: rgba(139, 92, 246, 0.35);
}

.sec-avatar {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    color: #1d4ed8;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.85rem;
    flex-shrink: 0;
}
html.dark-mode .sec-avatar {
    background: linear-gradient(135deg, #1e3a8a, #2563eb);
    color: #bfdbfe;
}

/* Modals */
.sec-modal .modal-content {
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}
html.dark-mode .sec-modal .modal-content {
    background: #1e2235;
    border-color: #2e354f;
    color: #f1f5f9;
}
.sec-modal .modal-header {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 1rem 1.25rem;
}
html.dark-mode .sec-modal .modal-header {
    background: #191c2b;
    border-color: #2e354f;
}
.sec-modal .modal-title {
    font-weight: 700;
    font-size: 1.15rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.sec-modal .modal-footer {
    border-top: 1px solid #e2e8f0;
    background: #f8fafc;
    padding: 0.85rem 1.25rem;
}
html.dark-mode .sec-modal .modal-footer {
    border-color: #2e354f;
    background: #191c2b;
}

.sec-input-group .input-group-text {
    background: #f8fafc;
    border-color: #cbd5e1;
    color: #64748b;
    border-radius: 10px 0 0 10px;
}
html.dark-mode .sec-input-group .input-group-text {
    background: #252a3d;
    border-color: #3b4261;
    color: #94a3b8;
}
.sec-input-group .form-control {
    border-color: #cbd5e1;
    border-radius: 0 10px 10px 0;
}
html.dark-mode .sec-input-group .form-control {
    background: #1b1e2e;
    border-color: #3b4261;
    color: #f1f5f9;
}
.sec-input-group .form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}
</style>

<div class="sec-dashboard-wrapper">
    <!-- Header & Action Bar -->
    <div class="sec-header-box">
        <div>
            <div class="sec-header-title">
                <i class="fas fa-layer-group text-primary"></i>
                {{ __('Section Management') }}
            </div>
            <p class="sec-header-subtitle">
                {{ __('Manage cohort sections, academic terms, daily schedules, and teacher assignments per class.') }}
            </p>
        </div>

        <div class="sec-action-btn-group">
            <a href="{{ route('class.index') }}" class="sec-btn sec-btn-secondary" title="{{ __('Back to Class List') }}">
                <i class="fas fa-chalkboard text-primary"></i>
                <span>{{ __('Class Directory') }}</span>
            </a>

            @if ($canManage)
                <button type="button" class="sec-btn sec-btn-primary" data-toggle="modal" data-target="#addSectionModal">
                    <i class="fas fa-plus"></i>
                    <span>{{ __('Add Section') }}</span>
                </button>
            @endif
        </div>
    </div>

    <!-- Top KPI Metric Cards -->
    <div class="sec-kpi-grid">
        <div class="sec-kpi-card">
            <div class="sec-kpi-icon kpi-indigo">
                <i class="fas fa-layer-group"></i>
            </div>
            <div>
                <div class="sec-kpi-value">{{ $metrics['total_sections'] ?? 0 }}</div>
                <div class="sec-kpi-label">{{ __('Total Sections') }}</div>
            </div>
        </div>

        <div class="sec-kpi-card">
            <div class="sec-kpi-icon kpi-sky">
                <i class="fas fa-chalkboard"></i>
            </div>
            <div>
                <div class="sec-kpi-value">{{ $metrics['total_classes'] ?? $classes->count() }}</div>
                <div class="sec-kpi-label">{{ __('Total Classes') }}</div>
            </div>
        </div>

        <div class="sec-kpi-card">
            <div class="sec-kpi-icon kpi-emerald">
                <i class="fas fa-cubes"></i>
            </div>
            <div>
                <div class="sec-kpi-value" id="kpiSelectedSections">{{ $metrics['current_class_sections'] ?? count($sections) }}</div>
                <div class="sec-kpi-label">{{ __('Active Class Sections') }}</div>
            </div>
        </div>

        <div class="sec-kpi-card">
            <div class="sec-kpi-icon kpi-amber">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div>
                <div class="sec-kpi-value" id="kpiSelectedStudents">{{ $metrics['current_class_students'] ?? 0 }}</div>
                <div class="sec-kpi-label">{{ __('Active Class Students') }}</div>
            </div>
        </div>
    </div>

    <!-- Class Switcher Toolbar -->
    <div class="sec-switcher-card">
        <div class="sec-switcher-grid">
            <div class="sec-select-wrap">
                <label for="classSelect" class="sec-select-label">
                    <i class="fas fa-filter text-primary"></i>
                    {{ __('Select Class:') }}
                </label>
                <select id="classSelect" name="classSelect" class="form-control sec-class-dropdown">
                    <option value="" disabled>{{ __('Choose an academic class...') }}</option>
                    @foreach ($classes as $c)
                        <option value="{{ $c->class_id }}" {{ (string)$selectedClassId === (string)$c->class_id ? 'selected' : '' }}>
                            {{ $c->name }} ({{ $c->sections_count ?? 0 }} {{ __('sections') }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Active Class Meta Information -->
            <div class="sec-class-meta" id="classMetaBar">
                <span class="sec-meta-pill" id="metaCode">
                    <i class="fas fa-barcode text-primary"></i>
                    <span>{{ __('Code') }}: <strong>{{ $currentClass->class_code ?? __('None') }}</strong></span>
                </span>
                <span class="sec-meta-pill" id="metaRoom">
                    <i class="fas fa-door-open text-success"></i>
                    <span>{{ __('Room') }}: <strong>{{ $currentClass->class_room ?? __('Unassigned') }}</strong></span>
                </span>
                <span class="sec-meta-pill" id="metaTeacher">
                    <i class="fas fa-user-tie text-info"></i>
                    <span>{{ __('Head Teacher') }}: <strong>{{ $currentClass->teacher_name ?? __('None') }}</strong></span>
                </span>
            </div>
        </div>
    </div>

    <!-- Main Sections List Card (Clean Single Container, No Nested Cards) -->
    <div class="sec-main-card">
        <!-- Toolbar -->
        <div class="sec-card-toolbar">
            <div class="d-flex align-items-center gap-2">
                <h5 class="mb-0 font-weight-bold" style="font-size: 1rem;">
                    {{ __('Sections Roster') }}
                </h5>
                <span class="badge badge-light border ml-2" id="sectionCountBadge" style="font-size: 0.78rem;">
                    {{ count($sections) }} {{ __('Sections') }}
                </span>
            </div>

            <!-- Real-time Filter/Search -->
            <div class="sec-search-box">
                <i class="fas fa-search sec-search-icon"></i>
                <input type="text" id="sectionSearchInput" class="sec-search-input" placeholder="{{ __('Search section, nickname, teacher...') }}" autocomplete="off">
            </div>
        </div>

        <!-- Table View with Initial Server-Rendered Content (Instant Load with Zero Flicker) -->
        <div class="table-responsive">
            <table class="table sec-table" id="sectionMasterTable">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>{{ __('Section Details') }}</th>
                        <th>{{ __('Assigned Teacher') }}</th>
                        <th>{{ __('Academic Term') }}</th>
                        <th>{{ __('Daily Schedule') }}</th>
                        <th class="text-center">{{ __('Students') }}</th>
                        <th style="width: 110px;" class="text-right">{{ __('Options') }}</th>
                    </tr>
                </thead>
                <tbody id="sectionTableBody">
                    @forelse($sections as $index => $s)
                        <tr class="section-row" data-search="{{ strtolower($s->section_name . ' ' . ($s->nick_name ?? '') . ' ' . ($s->teacher_name ?? '')) }}">
                            <td class="text-muted font-weight-bold" style="font-size: 0.8rem;">
                                {{ $index + 1 }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="sec-avatar mr-2.5">
                                        {{ strtoupper(mb_substr($s->section_name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="font-weight-bold text-dark dark:text-white" style="font-size: 0.92rem;">
                                            {{ $s->section_name }}
                                        </div>
                                        @if(!empty($s->nick_name))
                                            <span class="badge badge-light border text-secondary" style="font-size: 0.75rem;">
                                                <i class="fas fa-tag mr-1 text-muted"></i>{{ $s->nick_name }}
                                            </span>
                                        @else
                                            <span class="text-muted small"><em>{{ __('ID') }}: #{{ $s->section_id }}</em></span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if(!empty($s->teacher_name))
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center mr-2" style="width: 26px; height: 26px; font-size: 0.72rem;">
                                            <i class="fas fa-user-tie text-muted"></i>
                                        </div>
                                        <span class="font-weight-600">{{ $s->teacher_name }}</span>
                                    </div>
                                @else
                                    <span class="badge badge-light border text-muted">
                                        <i class="fas fa-user-slash mr-1"></i> {{ __('No Teacher') }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if(!empty($s->start_date) || !empty($s->end_date))
                                    <span class="sec-badge sec-badge-schedule">
                                        <i class="far fa-calendar-alt"></i>
                                        <span>{{ $s->start_date ?? '---' }} &rarr; {{ $s->end_date ?? '---' }}</span>
                                    </span>
                                @else
                                    <span class="text-muted small"><em>{{ __('No dates set') }}</em></span>
                                @endif
                            </td>
                            <td>
                                @if(!empty($s->time_in) || !empty($s->time_out))
                                    <span class="sec-badge sec-badge-time">
                                        <i class="far fa-clock"></i>
                                        <span>{{ substr($s->time_in ?? '', 0, 5) }} - {{ substr($s->time_out ?? '', 0, 5) }}</span>
                                    </span>
                                @else
                                    <span class="text-muted small"><em>{{ __('No times set') }}</em></span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="sec-badge sec-badge-student">
                                    <i class="fas fa-user-graduate"></i>
                                    <span>{{ $s->students_count ?? 0 }}</span>
                                </span>
                            </td>
                            <td class="text-right">
                                @if ($canManage)
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius: 8px;">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right shadow-sm border-0" style="border-radius: 10px;">
                                            <button type="button" class="dropdown-item text-primary font-weight-500 py-2" data-toggle="modal" data-target="#editSectionModal{{ $s->section_id }}">
                                                <i class="fas fa-edit mr-2"></i> {{ __('Edit Section') }}
                                            </button>
                                            <div class="dropdown-divider"></div>
                                            <form action="/section/destroy/{{ $s->section_id }}" method="POST" class="delete-section-form" data-name="{{ $s->section_name }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="dropdown-item text-danger font-weight-500 py-2 delete-section-btn">
                                                    <i class="fas fa-trash-alt mr-2"></i> {{ __('Delete Section') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <span class="badge badge-light border text-muted">{{ __('Read-Only') }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr id="emptySectionRow">
                            <td colspan="7" class="text-center py-5 text-muted">
                                <div class="py-4">
                                    <i class="fas fa-layer-group fa-3x mb-3 text-secondary opacity-50"></i>
                                    <p class="font-weight-bold mb-1">{{ __('No sections found for this class') }}</p>
                                    <p class="small text-muted mb-3">{{ __('Add a section to create schedules and enroll students.') }}</p>
                                    @if ($canManage)
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addSectionModal">
                                            <i class="fas fa-plus mr-1"></i> {{ __('Add Section') }}
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    <tr id="noSearchSectionRow" style="display: none;">
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-search fa-2x mb-2 text-secondary opacity-50"></i>
                            <p class="font-weight-bold mb-0">{{ __('No matching sections found') }}</p>
                            <small>{{ __('Try searching with another keyword.') }}</small>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- ADD SECTION MODAL                                              -->
<!-- ============================================================== -->
@if ($canManage)
<div class="modal fade sec-modal" id="addSectionModal" tabindex="-1" role="dialog" aria-labelledby="addSectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('section.store') }}" method="POST" onsubmit="if (typeof showOverlay === 'function') showOverlay();">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addSectionModalLabel">
                        <i class="fas fa-plus-circle text-primary"></i>
                        {{ __('Add New Section') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <!-- Target Class -->
                        <div class="col-md-6 form-group mb-3">
                            <label for="addModalClassSelect" class="font-weight-bold text-sm">
                                {{ __('Target Class') }} <span class="text-danger">*</span>
                            </label>
                            <div class="input-group sec-input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-chalkboard"></i></span>
                                </div>
                                <select class="form-control" id="addModalClassSelect" name="class_id" required>
                                    @foreach ($classes as $c)
                                        <option value="{{ $c->class_id }}" {{ (string)$selectedClassId === (string)$c->class_id ? 'selected' : '' }}>
                                            {{ $c->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Section Name -->
                        <div class="col-md-6 form-group mb-3">
                            <label for="new_section_name" class="font-weight-bold text-sm">
                                {{ __('Section Name') }} <span class="text-danger">*</span>
                            </label>
                            <div class="input-group sec-input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-layer-group"></i></span>
                                </div>
                                <input type="text" class="form-control" id="new_section_name" name="section_name" placeholder="{{ __('e.g., Section A, Morning Cohort') }}" required>
                            </div>
                        </div>

                        <!-- Nickname / Batch -->
                        <div class="col-md-6 form-group mb-3">
                            <label for="new_nick_name" class="font-weight-bold text-sm">
                                {{ __('Nick Name / Alias') }}
                            </label>
                            <div class="input-group sec-input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                </div>
                                <input type="text" class="form-control" id="new_nick_name" name="nick_name" placeholder="{{ __('e.g., Batch 1, Group Blue') }}">
                            </div>
                        </div>

                        <!-- Assigned Teacher -->
                        <div class="col-md-6 form-group mb-3">
                            <label for="new_sec_teacher" class="font-weight-bold text-sm">
                                {{ __('Section Teacher') }}
                            </label>
                            <div class="input-group sec-input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                </div>
                                <select class="form-control" id="new_sec_teacher" name="teacher_id">
                                    <option value="">-- {{ __('No Teacher Assigned') }} --</option>
                                    @foreach ($teachers as $t)
                                        <option value="{{ $t->teacher_id }}">{{ $t->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Academic Term (Dates) -->
                    <div class="row pt-2 border-top">
                        <div class="col-12 mb-2">
                            <span class="font-weight-bold text-sm text-secondary">
                                <i class="far fa-calendar-alt mr-1 text-primary"></i> {{ __('Academic Schedule Period') }}
                            </span>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="new_start_date" class="font-weight-600 text-xs text-muted">{{ __('Start Date') }}</label>
                            <input type="date" class="form-control" id="new_start_date" name="start_date">
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="new_end_date" class="font-weight-600 text-xs text-muted">{{ __('End Date') }}</label>
                            <input type="date" class="form-control" id="new_end_date" name="end_date">
                        </div>
                    </div>

                    <!-- Daily Schedule (Hours) -->
                    <div class="row pt-2 border-top">
                        <div class="col-12 mb-2">
                            <span class="font-weight-bold text-sm text-secondary">
                                <i class="far fa-clock mr-1 text-success"></i> {{ __('Daily Class Hours (24H)') }}
                            </span>
                        </div>
                        <div class="col-md-6 form-group mb-2">
                            <label for="new_start_time" class="font-weight-600 text-xs text-muted">{{ __('Time In (Start)') }}</label>
                            <input type="time" class="form-control" id="new_start_time" name="start_time">
                        </div>
                        <div class="col-md-6 form-group mb-2">
                            <label for="new_end_time" class="font-weight-600 text-xs text-muted">{{ __('Time Out (End)') }}</label>
                            <input type="time" class="form-control" id="new_end_time" name="end_time">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" class="btn btn-primary px-4 font-weight-bold">
                        <i class="fas fa-check mr-1"></i> {{ __('Add Section') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- ============================================================== -->
<!-- SERVER-RENDERED EDIT SECTION MODALS (Initial Class Load)       -->
<!-- ============================================================== -->
<div id="modalContainer">
    @if ($canManage)
        @foreach ($sections as $s)
            <div class="modal fade sec-modal" id="editSectionModal{{ $s->section_id }}" tabindex="-1" role="dialog" aria-labelledby="editSectionModalLabel{{ $s->section_id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <form action="/section/update/{{ $s->section_id }}" method="POST" onsubmit="if (typeof showOverlay === 'function') showOverlay();">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title" id="editSectionModalLabel{{ $s->section_id }}">
                                    <i class="fas fa-edit text-primary"></i>
                                    {{ __('Edit Section') }}: {{ $s->section_name }}
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="row">
                                    <!-- Section Name -->
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="edit_sec_name_{{ $s->section_id }}" class="font-weight-bold text-sm">
                                            {{ __('Section Name') }} <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group sec-input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-layer-group"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="edit_sec_name_{{ $s->section_id }}" name="section_name" value="{{ $s->section_name }}" required>
                                        </div>
                                    </div>

                                    <!-- Nickname -->
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="edit_nick_{{ $s->section_id }}" class="font-weight-bold text-sm">
                                            {{ __('Nick Name / Alias') }}
                                        </label>
                                        <div class="input-group sec-input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="edit_nick_{{ $s->section_id }}" name="nick_name" value="{{ $s->nick_name }}">
                                        </div>
                                    </div>

                                    <!-- Teacher -->
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="edit_sec_teacher_{{ $s->section_id }}" class="font-weight-bold text-sm">
                                            {{ __('Section Teacher') }}
                                        </label>
                                        <div class="input-group sec-input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                            </div>
                                            <select class="form-control" id="edit_sec_teacher_{{ $s->section_id }}" name="teacher_id">
                                                <option value="">-- {{ __('No Teacher Assigned') }} --</option>
                                                @foreach ($teachers as $t)
                                                    <option value="{{ $t->teacher_id }}" {{ (string)$s->teacher_id === (string)$t->teacher_id ? 'selected' : '' }}>
                                                        {{ $t->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Academic Dates -->
                                <div class="row pt-2 border-top">
                                    <div class="col-12 mb-2">
                                        <span class="font-weight-bold text-sm text-secondary">
                                            <i class="far fa-calendar-alt mr-1 text-primary"></i> {{ __('Academic Schedule Period') }}
                                        </span>
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label class="font-weight-600 text-xs text-muted">{{ __('Start Date') }}</label>
                                        <input type="date" class="form-control" name="start_date" value="{{ $s->start_date }}">
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label class="font-weight-600 text-xs text-muted">{{ __('End Date') }}</label>
                                        <input type="date" class="form-control" name="end_date" value="{{ $s->end_date }}">
                                    </div>
                                </div>

                                <!-- Daily Times -->
                                <div class="row pt-2 border-top">
                                    <div class="col-12 mb-2">
                                        <span class="font-weight-bold text-sm text-secondary">
                                            <i class="far fa-clock mr-1 text-success"></i> {{ __('Daily Class Hours (24H)') }}
                                        </span>
                                    </div>
                                    <div class="col-md-6 form-group mb-2">
                                        <label class="font-weight-600 text-xs text-muted">{{ __('Time In (Start)') }}</label>
                                        <input type="time" class="form-control" name="start_time" value="{{ substr($s->time_in ?? '', 0, 5) }}">
                                    </div>
                                    <div class="col-md-6 form-group mb-2">
                                        <label class="font-weight-600 text-xs text-muted">{{ __('Time Out (End)') }}</label>
                                        <input type="time" class="form-control" name="end_time" value="{{ substr($s->time_out ?? '', 0, 5) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">
                                    {{ __('Close') }}
                                </button>
                                <button type="submit" class="btn btn-primary px-4 font-weight-bold">
                                    <i class="fas fa-save mr-1"></i> {{ __('Save Changes') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>

<!-- ============================================================== -->
<!-- JAVASCRIPT: INSTANT SWITCHING, AJAX SYNC & SEARCH              -->
<!-- ============================================================== -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const classSelect = document.getElementById('classSelect');
    const tableBody = document.getElementById('sectionTableBody');
    const modalContainer = document.getElementById('modalContainer');
    const searchInput = document.getElementById('sectionSearchInput');
    const noSearchRow = document.getElementById('noSearchSectionRow');
    const sectionCountBadge = document.getElementById('sectionCountBadge');

    const metaCode = document.getElementById('metaCode');
    const metaRoom = document.getElementById('metaRoom');
    const metaTeacher = document.getElementById('metaTeacher');
    const kpiSelectedSections = document.getElementById('kpiSelectedSections');
    const kpiSelectedStudents = document.getElementById('kpiSelectedStudents');
    const addModalClassSelect = document.getElementById('addModalClassSelect');

    const canManage = {{ $canManage ? 'true' : 'false' }};
    const csrfToken = '{{ csrf_token() }}';

    // 1. Live Client-side Search Filtering
    function setupSearch() {
        if (!searchInput) return;
        searchInput.value = ''; // Reset query on class change
        filterRows();
    }

    function filterRows() {
        if (!searchInput) return;
        const query = searchInput.value.trim().toLowerCase();
        const rows = tableBody.querySelectorAll('.section-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const searchData = row.getAttribute('data-search') || '';
            if (searchData.includes(query)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        if (noSearchRow) {
            noSearchRow.style.display = (visibleCount === 0 && rows.length > 0) ? '' : 'none';
        }

        if (sectionCountBadge) {
            sectionCountBadge.textContent = `${visibleCount} {{ __('Sections') }}`;
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterRows);
    }

    // 2. SweetAlert2 Delete Confirmation Hook
    function attachDeleteHandlers() {
        document.querySelectorAll('.delete-section-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('form');
                const sectionName = form.getAttribute('data-name') || 'this section';

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: '{{ __("Delete Section?") }}',
                        html: `{{ __("Are you sure you want to delete") }} <strong>${sectionName}</strong>?<br><small class="text-danger">{{ __("Student enrollments and routines will be removed.") }}</small>`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: '<i class="fas fa-trash-alt mr-1"></i> {{ __("Yes, delete it") }}',
                        cancelButtonText: '{{ __("Cancel") }}',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (typeof showOverlay === 'function') showOverlay();
                            form.submit();
                        }
                    });
                } else {
                    if (confirm(`{{ __("Are you sure you want to delete") }} "${sectionName}"?`)) {
                        if (typeof showOverlay === 'function') showOverlay();
                        form.submit();
                    }
                }
            });
        });
    }

    attachDeleteHandlers();

    // 3. Dynamic AJAX Class Switcher
    const fetchSections = (classId) => {
        // Show lightweight loading state
        tableBody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center py-5">
                    <div class="spinner-border text-primary" role="status" style="width: 2rem; height: 2rem;">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted small font-weight-bold">{{ __('Loading class sections...') }}</p>
                </td>
            </tr>`;

        // Update URL query parameter silently
        if (window.history && window.history.replaceState) {
            const url = new URL(window.location);
            url.searchParams.set('class_id', classId);
            window.history.replaceState({}, '', url);
        }

        fetch(`/sections/${classId}`)
            .then(res => {
                if (!res.ok) throw new Error('Network response was not ok');
                return res.json();
            })
            .then(data => {
                // Update Meta Banner
                if (data.class) {
                    if (metaCode) metaCode.innerHTML = `<i class="fas fa-barcode text-primary"></i> <span>{{ __('Code') }}: <strong>${data.class.class_code || '{{ __("None") }}'}</strong></span>`;
                    if (metaRoom) metaRoom.innerHTML = `<i class="fas fa-door-open text-success"></i> <span>{{ __('Room') }}: <strong>${data.class.class_room || '{{ __("Unassigned") }}'}</strong></span>`;
                    if (metaTeacher) metaTeacher.innerHTML = `<i class="fas fa-user-tie text-info"></i> <span>{{ __('Head Teacher') }}: <strong>${data.class.teacher_name || '{{ __("None") }}'}</strong></span>`;
                }

                // Update KPI Cards
                if (kpiSelectedSections) kpiSelectedSections.textContent = data.sections ? data.sections.length : 0;
                if (kpiSelectedStudents) kpiSelectedStudents.textContent = data.total_students || 0;

                // Update Add Modal Class Select
                if (addModalClassSelect) {
                    addModalClassSelect.value = classId;
                }

                // Clear & Build Table Rows
                tableBody.innerHTML = '';
                if (modalContainer) modalContainer.innerHTML = '';

                if (data.sections && data.sections.length > 0) {
                    data.sections.forEach((s, index) => {
                        const tr = document.createElement('tr');
                        tr.className = 'section-row';
                        tr.setAttribute('data-search', `${s.section_name || ''} ${s.nick_name || ''} ${s.teacher_name || ''}`.toLowerCase());

                        const initials = (s.section_name || 'SC').substring(0, 2).toUpperCase();
                        const timeIn = s.time_in ? s.time_in.substring(0, 5) : '';
                        const timeOut = s.time_out ? s.time_out.substring(0, 5) : '';
                        const timeBadge = (timeIn || timeOut)
                            ? `<span class="sec-badge sec-badge-time"><i class="far fa-clock"></i> <span>${timeIn} - ${timeOut}</span></span>`
                            : `<span class="text-muted small"><em>{{ __('No times set') }}</em></span>`;

                        const dateBadge = (s.start_date || s.end_date)
                            ? `<span class="sec-badge sec-badge-schedule"><i class="far fa-calendar-alt"></i> <span>${s.start_date || '---'} &rarr; ${s.end_date || '---'}</span></span>`
                            : `<span class="text-muted small"><em>{{ __('No dates set') }}</em></span>`;

                        const teacherHtml = s.teacher_name
                            ? `<div class="d-flex align-items-center"><div class="rounded-circle bg-light border d-flex align-items-center justify-content-center mr-2" style="width: 26px; height: 26px; font-size: 0.72rem;"><i class="fas fa-user-tie text-muted"></i></div><span class="font-weight-600">${s.teacher_name}</span></div>`
                            : `<span class="badge badge-light border text-muted"><i class="fas fa-user-slash mr-1"></i> {{ __('No Teacher') }}</span>`;

                        const actionHtml = canManage ? `
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius: 8px;">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right shadow-sm border-0" style="border-radius: 10px;">
                                    <button type="button" class="dropdown-item text-primary font-weight-500 py-2" data-toggle="modal" data-target="#editSectionModal${s.section_id}">
                                        <i class="fas fa-edit mr-2"></i> {{ __('Edit Section') }}
                                    </button>
                                    <div class="dropdown-divider"></div>
                                    <form action="/section/destroy/${s.section_id}" method="POST" class="delete-section-form" data-name="${s.section_name || ''}">
                                        <input type="hidden" name="_token" value="${csrfToken}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="button" class="dropdown-item text-danger font-weight-500 py-2 delete-section-btn">
                                            <i class="fas fa-trash-alt mr-2"></i> {{ __('Delete Section') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        ` : `<span class="badge badge-light border text-muted">{{ __('Read-Only') }}</span>`;

                        tr.innerHTML = `
                            <td class="text-muted font-weight-bold" style="font-size: 0.8rem;">${index + 1}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="sec-avatar mr-2.5">${initials}</div>
                                    <div>
                                        <div class="font-weight-bold text-dark dark:text-white" style="font-size: 0.92rem;">${s.section_name}</div>
                                        ${s.nick_name ? `<span class="badge badge-light border text-secondary" style="font-size: 0.75rem;"><i class="fas fa-tag mr-1 text-muted"></i>${s.nick_name}</span>` : `<span class="text-muted small"><em>{{ __('ID') }}: #${s.section_id}</em></span>`}
                                    </div>
                                </div>
                            </td>
                            <td>${teacherHtml}</td>
                            <td>${dateBadge}</td>
                            <td>${timeBadge}</td>
                            <td class="text-center">
                                <span class="sec-badge sec-badge-student">
                                    <i class="fas fa-user-graduate"></i>
                                    <span>${s.students_count || 0}</span>
                                </span>
                            </td>
                            <td class="text-right">${actionHtml}</td>
                        `;
                        tableBody.appendChild(tr);

                        // Build Dynamic Edit Modal for this section
                        if (canManage && modalContainer) {
                            const teacherOptions = (data.teachers || []).map(t =>
                                `<option value="${t.teacher_id}" ${String(t.teacher_id) === String(s.teacher_id) ? 'selected' : ''}>${t.name}</option>`
                            ).join('');

                            const modalDiv = document.createElement('div');
                            modalDiv.innerHTML = `
                                <div class="modal fade sec-modal" id="editSectionModal${s.section_id}" tabindex="-1" role="dialog" aria-labelledby="editSectionModalLabel${s.section_id}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <form action="/section/update/${s.section_id}" method="POST" onsubmit="if (typeof showOverlay === 'function') showOverlay();">
                                                <input type="hidden" name="_token" value="${csrfToken}">
                                                <input type="hidden" name="_method" value="PUT">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editSectionModalLabel${s.section_id}">
                                                        <i class="fas fa-edit text-primary"></i>
                                                        {{ __('Edit Section') }}: ${s.section_name}
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <div class="row">
                                                        <div class="col-md-6 form-group mb-3">
                                                            <label class="font-weight-bold text-sm">{{ __('Section Name') }} <span class="text-danger">*</span></label>
                                                            <div class="input-group sec-input-group">
                                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-layer-group"></i></span></div>
                                                                <input type="text" class="form-control" name="section_name" value="${s.section_name || ''}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 form-group mb-3">
                                                            <label class="font-weight-bold text-sm">{{ __('Nick Name / Alias') }}</label>
                                                            <div class="input-group sec-input-group">
                                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-tag"></i></span></div>
                                                                <input type="text" class="form-control" name="nick_name" value="${s.nick_name || ''}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 form-group mb-3">
                                                            <label class="font-weight-bold text-sm">{{ __('Section Teacher') }}</label>
                                                            <div class="input-group sec-input-group">
                                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user-tie"></i></span></div>
                                                                <select class="form-control" name="teacher_id">
                                                                    <option value="">-- {{ __('No Teacher Assigned') }} --</option>
                                                                    ${teacherOptions}
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row pt-2 border-top">
                                                        <div class="col-12 mb-2">
                                                            <span class="font-weight-bold text-sm text-secondary">
                                                                <i class="far fa-calendar-alt mr-1 text-primary"></i> {{ __('Academic Schedule Period') }}
                                                            </span>
                                                        </div>
                                                        <div class="col-md-6 form-group mb-3">
                                                            <label class="font-weight-600 text-xs text-muted">{{ __('Start Date') }}</label>
                                                            <input type="date" class="form-control" name="start_date" value="${s.start_date || ''}">
                                                        </div>
                                                        <div class="col-md-6 form-group mb-3">
                                                            <label class="font-weight-600 text-xs text-muted">{{ __('End Date') }}</label>
                                                            <input type="date" class="form-control" name="end_date" value="${s.end_date || ''}">
                                                        </div>
                                                    </div>
                                                    <div class="row pt-2 border-top">
                                                        <div class="col-12 mb-2">
                                                            <span class="font-weight-bold text-sm text-secondary">
                                                                <i class="far fa-clock mr-1 text-success"></i> {{ __('Daily Class Hours (24H)') }}
                                                            </span>
                                                        </div>
                                                        <div class="col-md-6 form-group mb-2">
                                                            <label class="font-weight-600 text-xs text-muted">{{ __('Time In (Start)') }}</label>
                                                            <input type="time" class="form-control" name="start_time" value="${timeIn}">
                                                        </div>
                                                        <div class="col-md-6 form-group mb-2">
                                                            <label class="font-weight-600 text-xs text-muted">{{ __('Time Out (End)') }}</label>
                                                            <input type="time" class="form-control" name="end_time" value="${timeOut}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">{{ __('Close') }}</button>
                                                    <button type="submit" class="btn btn-primary px-4 font-weight-bold"><i class="fas fa-save mr-1"></i> {{ __('Save Changes') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>`;
                            modalContainer.appendChild(modalDiv.firstElementChild);
                        }
                    });

                    // Append the noSearchResultRow
                    const searchRow = document.createElement('tr');
                    searchRow.id = 'noSearchSectionRow';
                    searchRow.style.display = 'none';
                    searchRow.innerHTML = `
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-search fa-2x mb-2 text-secondary opacity-50"></i>
                            <p class="font-weight-bold mb-0">{{ __('No matching sections found') }}</p>
                            <small>{{ __('Try searching with another keyword.') }}</small>
                        </td>`;
                    tableBody.appendChild(searchRow);
                } else {
                    tableBody.innerHTML = `
                        <tr id="emptySectionRow">
                            <td colspan="7" class="text-center py-5 text-muted">
                                <div class="py-4">
                                    <i class="fas fa-layer-group fa-3x mb-3 text-secondary opacity-50"></i>
                                    <p class="font-weight-bold mb-1">{{ __('No sections found for this class') }}</p>
                                    <p class="small text-muted mb-3">{{ __('Add a section to create schedules and enroll students.') }}</p>
                                    ${canManage ? `
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addSectionModal">
                                            <i class="fas fa-plus mr-1"></i> {{ __('Add Section') }}
                                        </button>` : ''}
                                </div>
                            </td>
                        </tr>`;
                }

                if (sectionCountBadge) {
                    sectionCountBadge.textContent = `${data.sections ? data.sections.length : 0} {{ __('Sections') }}`;
                }

                attachDeleteHandlers();
                setupSearch();
            })
            .catch(err => {
                console.error('Error fetching sections:', err);
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center py-5 text-danger">
                            <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                            <p class="font-weight-bold mb-0">{{ __('Failed to load sections.') }}</p>
                            <small>{{ __('Please refresh or try again later.') }}</small>
                        </td>
                    </tr>`;
            });
    };

    // Change listener on Class selector
    if (classSelect) {
        classSelect.addEventListener('change', function () {
            const classId = this.value;
            if (classId) {
                fetchSections(classId);
            }
        });
    }
});
</script>

@endsection
