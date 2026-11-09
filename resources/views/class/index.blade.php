@extends('layout.main')

@section('title', __('Class Management'))

@section('content')

<style>
/* ══════════════════════════════════════════════════════════════════
   CLASS MANAGEMENT – Executive SaaS Design System
══════════════════════════════════════════════════════════════════ */
.cls-dashboard-wrapper {
    padding: 0.5rem 0.25rem 2.5rem;
}

/* Header Action Banner */
.cls-header-box {
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
html.dark-mode .cls-header-box {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 24px -2px rgba(0, 0, 0, 0.35);
}

.cls-header-title {
    font-size: 1.35rem;
    font-weight: 800;
    margin-bottom: 0.2rem;
    display: flex;
    align-items: center;
    gap: 0.65rem;
    color: #1e293b;
}
html.dark-mode .cls-header-title {
    color: #f8fafc;
}

.cls-header-subtitle {
    font-size: 0.85rem;
    color: #64748b;
    margin: 0;
}
html.dark-mode .cls-header-subtitle {
    color: #94a3b8;
}

.cls-action-btn-group {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    flex-wrap: wrap;
}

.cls-btn {
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
.cls-btn-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
}
.cls-btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
}
.cls-btn-secondary {
    background: #f1f5f9;
    color: #334155 !important;
    border-color: #cbd5e1;
}
.cls-btn-secondary:hover {
    background: #e2e8f0;
    color: #0f172a !important;
}
html.dark-mode .cls-btn-secondary {
    background: #282f48;
    color: #e2e8f0 !important;
    border-color: #3b4261;
}
html.dark-mode .cls-btn-secondary:hover {
    background: #333c5e;
}

/* KPI Cards Grid */
.cls-kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem;
    margin-bottom: 1.25rem;
}

.cls-kpi-card {
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
.cls-kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
}
html.dark-mode .cls-kpi-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.25);
}

.cls-kpi-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}
.kpi-blue    { background: rgba(59, 130, 246, 0.12); color: #3b82f6; }
.kpi-emerald { background: rgba(16, 185, 129, 0.12); color: #10b981; }
.kpi-violet  { background: rgba(139, 92, 246, 0.12); color: #8b5cf6; }
.kpi-amber   { background: rgba(245, 158, 11, 0.12); color: #f59e0b; }

.cls-kpi-value {
    font-size: 1.6rem;
    font-weight: 800;
    line-height: 1.1;
    color: #0f172a;
}
html.dark-mode .cls-kpi-value {
    color: #f8fafc;
}
.cls-kpi-label {
    font-size: 0.78rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: #64748b;
    margin-top: 0.15rem;
}
html.dark-mode .cls-kpi-label {
    color: #94a3b8;
}

/* Main Content Card */
.cls-main-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.04);
}
html.dark-mode .cls-main-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 24px -2px rgba(0, 0, 0, 0.35);
}

.cls-card-toolbar {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.85rem;
    background: #f8fafc;
}
html.dark-mode .cls-card-toolbar {
    background: #191c2b;
    border-color: #2e354f;
}

.cls-search-box {
    position: relative;
    min-width: 260px;
    max-width: 380px;
    flex: 1;
}
.cls-search-input {
    width: 100%;
    padding: 0.5rem 1rem 0.5rem 2.25rem;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 0.875rem;
    background: #ffffff;
    color: #1e293b;
    transition: all 0.2s;
}
.cls-search-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}
html.dark-mode .cls-search-input {
    background: #252a3d;
    border-color: #3b4261;
    color: #f1f5f9;
}
.cls-search-icon {
    position: absolute;
    left: 0.8rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.875rem;
    pointer-events: none;
}

/* Table Styling */
.cls-table {
    margin: 0;
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}
.cls-table thead th {
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
html.dark-mode .cls-table thead th {
    background: #191c2b;
    color: #94a3b8;
    border-color: #2e354f;
}
.cls-table tbody td {
    padding: 0.9rem 1rem;
    vertical-align: middle;
    border-top: none;
    border-bottom: 1px solid #f1f5f9;
    font-size: 0.88rem;
    color: #334155;
}
html.dark-mode .cls-table tbody td {
    border-color: #262c44;
    color: #cbd5e1;
}
.cls-table tbody tr:hover {
    background: #f8fafc;
}
html.dark-mode .cls-table tbody tr:hover {
    background: #22273c;
}

/* Custom Table Badges & Elements */
.cls-avatar {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
    color: #3730a3;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.85rem;
    flex-shrink: 0;
}
html.dark-mode .cls-avatar {
    background: linear-gradient(135deg, #2e3558, #3b426b);
    color: #a5b4fc;
}

.cls-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.25rem 0.65rem;
    border-radius: 8px;
    font-size: 0.78rem;
    font-weight: 600;
    line-height: 1.2;
}
.cls-badge-code {
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #e2e8f0;
    font-family: monospace;
    font-size: 0.8rem;
}
html.dark-mode .cls-badge-code {
    background: #252a3d;
    color: #cbd5e1;
    border-color: #3b4261;
}
.cls-badge-room {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
    border: 1px solid rgba(16, 185, 129, 0.2);
}
html.dark-mode .cls-badge-room {
    background: rgba(16, 185, 129, 0.15);
    color: #34d399;
    border-color: rgba(16, 185, 129, 0.3);
}
.cls-badge-section {
    background: rgba(59, 130, 246, 0.1);
    color: #2563eb;
    border: 1px solid rgba(59, 130, 246, 0.2);
    text-decoration: none !important;
    transition: all 0.15s ease;
}
.cls-badge-section:hover {
    background: #2563eb;
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
}
html.dark-mode .cls-badge-section {
    background: rgba(59, 130, 246, 0.18);
    color: #60a5fa;
    border-color: rgba(59, 130, 246, 0.35);
}
html.dark-mode .cls-badge-section:hover {
    background: #3b82f6;
    color: #ffffff;
}
.cls-badge-student {
    background: rgba(139, 92, 246, 0.1);
    color: #7c3aed;
    border: 1px solid rgba(139, 92, 246, 0.2);
}
html.dark-mode .cls-badge-student {
    background: rgba(139, 92, 246, 0.18);
    color: #a78bfa;
    border-color: rgba(139, 92, 246, 0.35);
}

.cls-teacher-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}
.cls-teacher-avatar {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: #e2e8f0;
    color: #475569;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.72rem;
}
html.dark-mode .cls-teacher-avatar {
    background: #2e354f;
    color: #94a3b8;
}

/* Modals */
.cls-modal .modal-content {
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}
html.dark-mode .cls-modal .modal-content {
    background: #1e2235;
    border-color: #2e354f;
    color: #f1f5f9;
}
.cls-modal .modal-header {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 1rem 1.25rem;
}
html.dark-mode .cls-modal .modal-header {
    background: #191c2b;
    border-color: #2e354f;
}
.cls-modal .modal-title {
    font-weight: 700;
    font-size: 1.15rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.cls-modal .modal-footer {
    border-top: 1px solid #e2e8f0;
    background: #f8fafc;
    padding: 0.85rem 1.25rem;
}
html.dark-mode .cls-modal .modal-footer {
    border-color: #2e354f;
    background: #191c2b;
}

.cls-input-group .input-group-text {
    background: #f8fafc;
    border-color: #cbd5e1;
    color: #64748b;
    border-radius: 10px 0 0 10px;
}
html.dark-mode .cls-input-group .input-group-text {
    background: #252a3d;
    border-color: #3b4261;
    color: #94a3b8;
}
.cls-input-group .form-control {
    border-color: #cbd5e1;
    border-radius: 0 10px 10px 0;
}
html.dark-mode .cls-input-group .form-control {
    background: #1b1e2e;
    border-color: #3b4261;
    color: #f1f5f9;
}
.cls-input-group .form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}
</style>

<div class="cls-dashboard-wrapper">
    <!-- Breadcrumb & Header Box -->
    <div class="cls-header-box">
        <div>
            <div class="cls-header-title">
                <i class="fas fa-chalkboard text-primary"></i>
                {{ __('Class Management') }}
            </div>
            <p class="cls-header-subtitle">
                {{ __('Manage academic classes, assigned classrooms, faculty in-charge, and linked sections.') }}
            </p>
        </div>

        <div class="cls-action-btn-group">
            <a href="{{ route('sections.index') }}" class="cls-btn cls-btn-secondary" title="{{ __('View Section Directory') }}">
                <i class="fas fa-layer-group text-primary"></i>
                <span>{{ __('Section Directory') }}</span>
            </a>

            @if (in_array((int)Auth::user()->role, [0, 3]))
                <button type="button" class="cls-btn cls-btn-primary" data-toggle="modal" data-target="#addClassModal">
                    <i class="fas fa-plus"></i>
                    <span>{{ __('Add Class') }}</span>
                </button>
            @endif
        </div>
    </div>

    <!-- Top KPI Metric Cards -->
    <div class="cls-kpi-grid">
        <div class="cls-kpi-card">
            <div class="cls-kpi-icon kpi-blue">
                <i class="fas fa-chalkboard"></i>
            </div>
            <div>
                <div class="cls-kpi-value">{{ $metrics['total_classes'] ?? count($tbl) }}</div>
                <div class="cls-kpi-label">{{ __('Total Classes') }}</div>
            </div>
        </div>

        <div class="cls-kpi-card">
            <div class="cls-kpi-icon kpi-emerald">
                <i class="fas fa-layer-group"></i>
            </div>
            <div>
                <div class="cls-kpi-value">{{ $metrics['total_sections'] ?? 0 }}</div>
                <div class="cls-kpi-label">{{ __('Active Sections') }}</div>
            </div>
        </div>

        <div class="cls-kpi-card">
            <div class="cls-kpi-icon kpi-violet">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div>
                <div class="cls-kpi-value">{{ $metrics['total_students'] ?? 0 }}</div>
                <div class="cls-kpi-label">{{ __('Enrolled Students') }}</div>
            </div>
        </div>

        <div class="cls-kpi-card">
            <div class="cls-kpi-icon kpi-amber">
                <i class="fas fa-user-tie"></i>
            </div>
            <div>
                <div class="cls-kpi-value">{{ $metrics['assigned_teachers'] ?? 0 }}</div>
                <div class="cls-kpi-label">{{ __('Assigned Teachers') }}</div>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="cls-main-card">
        <!-- Card Toolbar -->
        <div class="cls-card-toolbar">
            <div class="d-flex align-items-center gap-2">
                <h5 class="mb-0 font-weight-bold" style="font-size: 1rem;">
                    {{ __('Class Directory') }}
                </h5>
                <span class="badge badge-light border ml-2" id="classCountBadge" style="font-size: 0.78rem;">
                    {{ count($tbl) }} {{ __('Classes') }}
                </span>
            </div>

            <!-- Real-time Filter/Search -->
            <div class="cls-search-box">
                <i class="fas fa-search cls-search-icon"></i>
                <input type="text" id="classSearchInput" class="cls-search-input" placeholder="{{ __('Search class name, code, room, teacher...') }}" autocomplete="off">
            </div>
        </div>

        <!-- Table View -->
        <div class="table-responsive">
            <table class="table cls-table" id="classMasterTable">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>{{ __('Class Information') }}</th>
                        <th>{{ __('Class Code') }}</th>
                        <th>{{ __('Class Room') }}</th>
                        <th>{{ __('Teacher in Charge') }}</th>
                        <th class="text-center">{{ __('Sections') }}</th>
                        <th class="text-center">{{ __('Students') }}</th>
                        <th style="width: 110px;" class="text-right">{{ __('Options') }}</th>
                    </tr>
                </thead>
                <tbody id="classTableBody">
                    @forelse($tbl as $index => $item)
                        <tr class="class-row" data-search="{{ strtolower($item->name . ' ' . ($item->class_code ?? '') . ' ' . ($item->class_room ?? '') . ' ' . ($item->teacher_name ?? '')) }}">
                            <td class="text-muted font-weight-bold" style="font-size: 0.8rem;">
                                {{ $index + 1 }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="cls-avatar mr-2.5">
                                        {{ strtoupper(mb_substr($item->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="font-weight-bold text-dark dark:text-white" style="font-size: 0.92rem;">
                                            {{ $item->name }}
                                        </div>
                                        <div class="text-muted small">
                                            ID: #{{ $item->class_id }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if(!empty($item->class_code))
                                    <span class="cls-badge cls-badge-code">
                                        <i class="fas fa-barcode text-muted"></i>
                                        {{ $item->class_code }}
                                    </span>
                                @else
                                    <span class="text-muted small"><em>{{ __('None') }}</em></span>
                                @endif
                            </td>
                            <td>
                                @if(!empty($item->class_room))
                                    <span class="cls-badge cls-badge-room">
                                        <i class="fas fa-door-open"></i>
                                        {{ $item->class_room }}
                                    </span>
                                @else
                                    <span class="text-muted small"><em>{{ __('Unassigned') }}</em></span>
                                @endif
                            </td>
                            <td>
                                @if(!empty($item->teacher_name))
                                    <div class="cls-teacher-pill">
                                        <div class="cls-teacher-avatar">
                                            <i class="fas fa-user-tie"></i>
                                        </div>
                                        <span class="font-weight-600">{{ $item->teacher_name }}</span>
                                    </div>
                                @else
                                    <span class="badge badge-light border text-muted">
                                        <i class="fas fa-user-slash mr-1"></i> {{ __('No Teacher') }}
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('sections.index', ['class_id' => $item->class_id]) }}" class="cls-badge cls-badge-section" title="{{ __('View sections for this class') }}">
                                    <i class="fas fa-layer-group"></i>
                                    <span>{{ $item->sections_count ?? 0 }} {{ __('Sections') }}</span>
                                </a>
                            </td>
                            <td class="text-center">
                                <span class="cls-badge cls-badge-student">
                                    <i class="fas fa-user-graduate"></i>
                                    <span>{{ $item->students_count ?? 0 }}</span>
                                </span>
                            </td>
                            <td class="text-right">
                                @if (in_array((int)Auth::user()->role, [0, 3]))
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius: 8px;">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right shadow-sm border-0" style="border-radius: 10px;">
                                            <a class="dropdown-item text-primary font-weight-500 py-2" href="javascript:void(0)" data-toggle="modal" data-target="#editModal{{ $item->class_id }}">
                                                <i class="fas fa-edit mr-2"></i> {{ __('Edit Class') }}
                                            </a>
                                            <a class="dropdown-item text-info font-weight-500 py-2" href="{{ route('sections.index', ['class_id' => $item->class_id]) }}">
                                                <i class="fas fa-layer-group mr-2"></i> {{ __('Manage Sections') }}
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('class.destroy', $item->class_id) }}" method="POST" class="delete-class-form" data-name="{{ $item->name }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="dropdown-item text-danger font-weight-500 py-2 delete-confirm-btn">
                                                    <i class="fas fa-trash-alt mr-2"></i> {{ __('Delete Class') }}
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
                        <tr id="noDataRow">
                            <td colspan="8" class="text-center py-5 text-muted">
                                <div class="py-4">
                                    <i class="fas fa-chalkboard fa-3x mb-3 text-secondary opacity-50"></i>
                                    <p class="font-weight-bold mb-1">{{ __('No classes found') }}</p>
                                    <p class="small text-muted mb-3">{{ __('Get started by adding your first academic class.') }}</p>
                                    @if (in_array((int)Auth::user()->role, [0, 3]))
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addClassModal">
                                            <i class="fas fa-plus mr-1"></i> {{ __('Add Class') }}
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    <tr id="noSearchResultRow" style="display: none;">
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="fas fa-search fa-2x mb-2 text-secondary opacity-50"></i>
                            <p class="font-weight-bold mb-0">{{ __('No matching classes found') }}</p>
                            <small>{{ __('Try searching with another keyword.') }}</small>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- INLINE MODAL: ADD CLASS                                        -->
<!-- ============================================================== -->
@if (in_array((int)Auth::user()->role, [0, 3]))
<div class="modal fade cls-modal" id="addClassModal" tabindex="-1" role="dialog" aria-labelledby="addClassModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('class.store') }}" method="POST" onsubmit="if (typeof showOverlay === 'function') showOverlay();">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addClassModalLabel">
                        <i class="fas fa-plus-circle text-primary"></i>
                        {{ __('Add New Class') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <!-- Class Name -->
                    <div class="form-group mb-3">
                        <label for="new_class_name" class="font-weight-bold text-sm">
                            {{ __('Class Name') }} <span class="text-danger">*</span>
                        </label>
                        <div class="input-group cls-input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                            </div>
                            <input type="text" class="form-control" id="new_class_name" name="name" placeholder="{{ __('e.g., Grade 10 - Science') }}" required>
                        </div>
                    </div>

                    <!-- Class Code -->
                    <div class="form-group mb-3">
                        <label for="new_class_code" class="font-weight-bold text-sm">
                            {{ __('Class Code') }}
                        </label>
                        <div class="input-group cls-input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                            </div>
                            <input type="text" class="form-control" id="new_class_code" name="class_code" placeholder="{{ __('e.g., CLS-10A') }}">
                        </div>
                    </div>

                    <!-- Class Room -->
                    <div class="form-group mb-3">
                        <label for="new_class_room" class="font-weight-bold text-sm">
                            {{ __('Class Room') }}
                        </label>
                        <div class="input-group cls-input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-door-open"></i></span>
                            </div>
                            <input type="text" class="form-control" id="new_class_room" name="class_room" placeholder="{{ __('e.g., Room 302, Building B') }}">
                        </div>
                    </div>

                    <!-- Teacher in charge -->
                    <div class="form-group mb-0">
                        <label for="new_teacher_id" class="font-weight-bold text-sm">
                            {{ __('Teacher in Charge') }}
                        </label>
                        <div class="input-group cls-input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                            </div>
                            <select class="form-control" id="new_teacher_id" name="teacher_id">
                                <option value="">-- {{ __('No Teacher Assigned') }} --</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->teacher_id }}">
                                        {{ $teacher->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" class="btn btn-primary px-4 font-weight-bold">
                        <i class="fas fa-check mr-1"></i> {{ __('Create Class') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- ============================================================== -->
<!-- EDIT CLASS MODALS                                              -->
<!-- ============================================================== -->
@if (in_array((int)Auth::user()->role, [0, 3]))
    @foreach ($tbl as $item)
        <div class="modal fade cls-modal" id="editModal{{ $item->class_id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $item->class_id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form action="{{ route('class.update', $item->class_id) }}" method="POST" onsubmit="if (typeof showOverlay === 'function') showOverlay();">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel{{ $item->class_id }}">
                                <i class="fas fa-edit text-primary"></i>
                                {{ __('Edit Class') }}: {{ $item->name }}
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body p-4">
                            <!-- Class Name -->
                            <div class="form-group mb-3">
                                <label for="edit_name_{{ $item->class_id }}" class="font-weight-bold text-sm">
                                    {{ __('Class Name') }} <span class="text-danger">*</span>
                                </label>
                                <div class="input-group cls-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="edit_name_{{ $item->class_id }}" name="name" value="{{ $item->name }}" required>
                                </div>
                            </div>

                            <!-- Class Code -->
                            <div class="form-group mb-3">
                                <label for="edit_code_{{ $item->class_id }}" class="font-weight-bold text-sm">
                                    {{ __('Class Code') }}
                                </label>
                                <div class="input-group cls-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="edit_code_{{ $item->class_id }}" name="class_code" value="{{ $item->class_code }}">
                                </div>
                            </div>

                            <!-- Class Room -->
                            <div class="form-group mb-3">
                                <label for="edit_room_{{ $item->class_id }}" class="font-weight-bold text-sm">
                                    {{ __('Class Room') }}
                                </label>
                                <div class="input-group cls-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-door-open"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="edit_room_{{ $item->class_id }}" name="class_room" value="{{ $item->class_room }}">
                                </div>
                            </div>

                            <!-- Teacher -->
                            <div class="form-group mb-0">
                                <label for="edit_teacher_{{ $item->class_id }}" class="font-weight-bold text-sm">
                                    {{ __('Teacher in Charge') }}
                                </label>
                                <div class="input-group cls-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                    </div>
                                    <select class="form-control" id="edit_teacher_{{ $item->class_id }}" name="teacher_id">
                                        <option value="">-- {{ __('No Teacher Assigned') }} --</option>
                                        @foreach ($teachers as $teacher)
                                            <option value="{{ $teacher->teacher_id }}" {{ (string)$item->teacher_id === (string)$teacher->teacher_id ? 'selected' : '' }}>
                                                {{ $teacher->name }}
                                            </option>
                                        @endforeach
                                    </select>
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Real-time Search Filter for Class Table
    const searchInput = document.getElementById('classSearchInput');
    const tableRows = document.querySelectorAll('.class-row');
    const noResultRow = document.getElementById('noSearchResultRow');
    const countBadge = document.getElementById('classCountBadge');

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const query = this.value.trim().toLowerCase();
            let visibleCount = 0;

            tableRows.forEach(row => {
                const searchData = row.getAttribute('data-search') || '';
                if (searchData.includes(query)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            if (noResultRow) {
                noResultRow.style.display = (visibleCount === 0 && tableRows.length > 0) ? '' : 'none';
            }

            if (countBadge) {
                countBadge.textContent = `${visibleCount} {{ __('Classes') }}`;
            }
        });
    }

    // 2. SweetAlert2 Delete Confirmation
    document.querySelectorAll('.delete-confirm-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('form');
            const className = form.getAttribute('data-name') || 'this class';

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: '{{ __("Delete Class?") }}',
                    html: `{{ __("Are you sure you want to delete") }} <strong>${className}</strong>?<br><small class="text-danger">{{ __("Linked sections and attendance records may be impacted.") }}</small>`,
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
                if (confirm(`{{ __("Are you sure you want to delete") }} "${className}"?`)) {
                    if (typeof showOverlay === 'function') showOverlay();
                    form.submit();
                }
            }
        });
    });
});
</script>

@endsection
