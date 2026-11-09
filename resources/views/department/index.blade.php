@extends('layout.main')

@section('title', __('Department Management'))

@section('content')

<style>
/* ══════════════════════════════════════════════════════════════════
   DEPARTMENT MANAGEMENT – Executive SaaS Design System
══════════════════════════════════════════════════════════════════ */
.dept-dashboard-wrapper {
    padding: 0.5rem 0.25rem 2.5rem;
}

/* Header Box */
.dept-header-box {
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
html.dark-mode .dept-header-box {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 24px -2px rgba(0, 0, 0, 0.35);
}

.dept-header-title {
    font-size: 1.35rem;
    font-weight: 800;
    margin-bottom: 0.2rem;
    display: flex;
    align-items: center;
    gap: 0.65rem;
    color: #1e293b;
}
html.dark-mode .dept-header-title {
    color: #f8fafc;
}

.dept-header-subtitle {
    font-size: 0.85rem;
    color: #64748b;
    margin: 0;
}
html.dark-mode .dept-header-subtitle {
    color: #94a3b8;
}

.dept-action-btn-group {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    flex-wrap: wrap;
}

.dept-btn {
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
.dept-btn-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
}
.dept-btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
}
.dept-btn-secondary {
    background: #f1f5f9;
    color: #334155 !important;
    border-color: #cbd5e1;
}
.dept-btn-secondary:hover {
    background: #e2e8f0;
    color: #0f172a !important;
}
html.dark-mode .dept-btn-secondary {
    background: #282f48;
    color: #e2e8f0 !important;
    border-color: #3b4261;
}
html.dark-mode .dept-btn-secondary:hover {
    background: #333c5e;
}

/* KPI Cards Grid */
.dept-kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem;
    margin-bottom: 1.25rem;
}

.dept-kpi-card {
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
.dept-kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
}
html.dark-mode .dept-kpi-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.25);
}

.dept-kpi-icon {
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
.kpi-emerald { background: rgba(16, 185, 129, 0.12); color: #10b981; }
.kpi-sky     { background: rgba(14, 165, 233, 0.12); color: #0ea5e9; }
.kpi-amber   { background: rgba(245, 158, 11, 0.12); color: #f59e0b; }

.dept-kpi-value {
    font-size: 1.6rem;
    font-weight: 800;
    line-height: 1.1;
    color: #0f172a;
}
html.dark-mode .dept-kpi-value {
    color: #f8fafc;
}
.dept-kpi-label {
    font-size: 0.78rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: #64748b;
    margin-top: 0.15rem;
}
html.dark-mode .dept-kpi-label {
    color: #94a3b8;
}

/* Main Table Card */
.dept-main-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.04);
}
html.dark-mode .dept-main-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 24px -2px rgba(0, 0, 0, 0.35);
}

.dept-card-toolbar {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.85rem;
    background: #f8fafc;
}
html.dark-mode .dept-card-toolbar {
    background: #191c2b;
    border-color: #2e354f;
}

.dept-search-box {
    position: relative;
    min-width: 240px;
    max-width: 360px;
    flex: 1;
}
.dept-search-input {
    width: 100%;
    padding: 0.45rem 1rem 0.45rem 2.25rem;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 0.875rem;
    background: #ffffff;
    color: #1e293b;
    transition: all 0.2s;
}
.dept-search-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}
html.dark-mode .dept-search-input {
    background: #252a3d;
    border-color: #3b4261;
    color: #f1f5f9;
}
.dept-search-icon {
    position: absolute;
    left: 0.8rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.85rem;
    pointer-events: none;
}

/* Table Styling */
.dept-table {
    margin: 0;
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}
.dept-table thead th {
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
html.dark-mode .dept-table thead th {
    background: #191c2b;
    color: #94a3b8;
    border-color: #2e354f;
}
.dept-table tbody td {
    padding: 0.95rem 1rem;
    vertical-align: middle;
    border-top: none;
    border-bottom: 1px solid #f1f5f9;
    font-size: 0.88rem;
    color: #334155;
}
html.dark-mode .dept-table tbody td {
    border-color: #262c44;
    color: #cbd5e1;
}
.dept-table tbody tr:hover {
    background: #f8fafc;
}
html.dark-mode .dept-table tbody tr:hover {
    background: #22273c;
}

.dept-avatar {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: linear-gradient(135deg, #ede9fe, #ddd6fe);
    color: #6d28d9;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.85rem;
    flex-shrink: 0;
}
html.dark-mode .dept-avatar {
    background: linear-gradient(135deg, #3730a3, #4338ca);
    color: #c7d2fe;
}

.dept-staff-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.3rem 0.75rem;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 600;
    background: rgba(59, 130, 246, 0.1);
    color: #2563eb;
    border: 1px solid rgba(59, 130, 246, 0.2);
    text-decoration: none !important;
    transition: all 0.15s ease;
}
.dept-staff-badge:hover {
    background: #2563eb;
    color: #ffffff !important;
    transform: translateY(-1px);
    box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
}
html.dark-mode .dept-staff-badge {
    background: rgba(59, 130, 246, 0.18);
    color: #60a5fa;
    border-color: rgba(59, 130, 246, 0.35);
}
html.dark-mode .dept-staff-badge:hover {
    background: #3b82f6;
    color: #ffffff !important;
}

/* Modals */
.dept-modal .modal-content {
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}
html.dark-mode .dept-modal .modal-content {
    background: #1e2235;
    border-color: #2e354f;
    color: #f1f5f9;
}
.dept-modal .modal-header {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 1rem 1.25rem;
}
html.dark-mode .dept-modal .modal-header {
    background: #191c2b;
    border-color: #2e354f;
}
.dept-modal .modal-footer {
    border-top: 1px solid #e2e8f0;
    background: #f8fafc;
    padding: 0.85rem 1.25rem;
}
html.dark-mode .dept-modal .modal-footer {
    border-color: #2e354f;
    background: #191c2b;
}

.dept-input-group .input-group-text {
    background: #f8fafc;
    border-color: #cbd5e1;
    color: #64748b;
    border-radius: 10px 0 0 10px;
}
html.dark-mode .dept-input-group .input-group-text {
    background: #252a3d;
    border-color: #3b4261;
    color: #94a3b8;
}
.dept-input-group .form-control {
    border-color: #cbd5e1;
    border-radius: 0 10px 10px 0;
}
html.dark-mode .dept-input-group .form-control {
    background: #1b1e2e;
    border-color: #3b4261;
    color: #f1f5f9;
}
.dept-input-group .form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}
</style>

<div class="dept-dashboard-wrapper">
    <!-- Header Action Banner -->
    <div class="dept-header-box">
        <div>
            <div class="dept-header-title">
                <i class="fas fa-sitemap text-primary"></i>
                {{ __('Department Management') }}
            </div>
            <p class="dept-header-subtitle">
                {{ __('Organize organizational divisions, operational faculties, and oversee staffing allocations.') }}
            </p>
        </div>

        <div class="dept-action-btn-group">
            <a href="{{ route('staffs.index') }}" class="dept-btn dept-btn-secondary" title="{{ __('View Staff Directory') }}">
                <i class="fas fa-user-tie text-primary"></i>
                <span>{{ __('Staff Directory') }}</span>
            </a>

            <button type="button" class="dept-btn dept-btn-primary" data-toggle="modal" data-target="#addDepartmentModal">
                <i class="fas fa-plus"></i>
                <span>{{ __('Add Department') }}</span>
            </button>
        </div>
    </div>

    <!-- Top KPI Metric Cards -->
    <div class="dept-kpi-grid">
        <div class="dept-kpi-card">
            <div class="dept-kpi-icon kpi-indigo">
                <i class="fas fa-sitemap"></i>
            </div>
            <div>
                <div class="dept-kpi-value">{{ $metrics['total_departments'] ?? count($departments) }}</div>
                <div class="dept-kpi-label">{{ __('Total Departments') }}</div>
            </div>
        </div>

        <div class="dept-kpi-card">
            <div class="dept-kpi-icon kpi-emerald">
                <i class="fas fa-user-tie"></i>
            </div>
            <div>
                <div class="dept-kpi-value">{{ $metrics['total_staff'] ?? 0 }}</div>
                <div class="dept-kpi-label">{{ __('Total Personnel') }}</div>
            </div>
        </div>

        <div class="dept-kpi-card">
            <div class="dept-kpi-icon kpi-sky">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <div class="dept-kpi-value">{{ $metrics['staffed_depts'] ?? 0 }}</div>
                <div class="dept-kpi-label">{{ __('Staffed Divisions') }}</div>
            </div>
        </div>

        <div class="dept-kpi-card">
            <div class="dept-kpi-icon kpi-amber">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div>
                <div class="dept-kpi-value">{{ $metrics['vacant_depts'] ?? 0 }}</div>
                <div class="dept-kpi-label">{{ __('Unstaffed Divisions') }}</div>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="dept-main-card">
        <!-- Card Toolbar -->
        <div class="dept-card-toolbar">
            <div class="d-flex align-items-center gap-2">
                <h5 class="mb-0 font-weight-bold" style="font-size: 1rem;">
                    {{ __('Departments Directory') }}
                </h5>
                <span class="badge badge-light border ml-2" id="deptCountBadge" style="font-size: 0.78rem;">
                    {{ count($departments) }} {{ __('Departments') }}
                </span>
            </div>

            <!-- Real-time Filter/Search -->
            <div class="dept-search-box">
                <i class="fas fa-search dept-search-icon"></i>
                <input type="text" id="deptSearchInput" class="dept-search-input" placeholder="{{ __('Search department name...') }}" autocomplete="off">
            </div>
        </div>

        <!-- Table View -->
        <div class="table-responsive">
            <table class="table dept-table" id="departmentMasterTable">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>{{ __('Department Name') }}</th>
                        <th class="text-center">{{ __('Staff Allocation') }}</th>
                        <th>{{ __('Created Date') }}</th>
                        <th style="width: 110px;" class="text-right">{{ __('Options') }}</th>
                    </tr>
                </thead>
                <tbody id="deptTableBody">
                    @forelse($departments as $index => $item)
                        <tr class="dept-row" data-search="{{ strtolower($item->name) }}">
                            <td class="text-muted font-weight-bold" style="font-size: 0.8rem;">
                                {{ $index + 1 }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="dept-avatar mr-2.5">
                                        {{ strtoupper(mb_substr($item->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="font-weight-bold text-dark dark:text-white" style="font-size: 0.95rem;">
                                            {{ $item->name }}
                                        </div>
                                        <div class="text-muted small">
                                            ID: #{{ $item->id }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('staffs.index', ['department_id' => $item->id]) }}" class="dept-staff-badge" title="{{ __('View staff in this department') }}">
                                    <i class="fas fa-users"></i>
                                    <span>{{ $item->staff_count ?? 0 }} {{ __('Staff') }}</span>
                                </a>
                            </td>
                            <td>
                                <span class="text-muted small">
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    {{ !empty($item->created_at) ? date('M d, Y', strtotime($item->created_at)) : 'N/A' }}
                                </span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius: 8px;">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right shadow-sm border-0" style="border-radius: 10px;">
                                        <button type="button" class="dropdown-item text-primary font-weight-500 py-2" data-toggle="modal" data-target="#editModal{{ $item->id }}">
                                            <i class="fas fa-edit mr-2"></i> {{ __('Edit Department') }}
                                        </button>
                                        <a class="dropdown-item text-info font-weight-500 py-2" href="{{ route('staffs.index', ['department_id' => $item->id]) }}">
                                            <i class="fas fa-user-tie mr-2"></i> {{ __('View Staff Members') }}
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <form action="{{ route('departments.destroy', $item->id) }}" method="POST" class="delete-dept-form" data-name="{{ $item->name }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="dropdown-item text-danger font-weight-500 py-2 delete-dept-btn">
                                                <i class="fas fa-trash-alt mr-2"></i> {{ __('Delete Department') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr id="emptyDeptRow">
                            <td colspan="5" class="text-center py-5 text-muted">
                                <div class="py-4">
                                    <i class="fas fa-sitemap fa-3x mb-3 text-secondary opacity-50"></i>
                                    <p class="font-weight-bold mb-1">{{ __('No departments found') }}</p>
                                    <p class="small text-muted mb-3">{{ __('Get started by creating your first academic or operational department.') }}</p>
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addDepartmentModal">
                                        <i class="fas fa-plus mr-1"></i> {{ __('Add Department') }}
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    <tr id="noSearchDeptRow" style="display: none;">
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-search fa-2x mb-2 text-secondary opacity-50"></i>
                            <p class="font-weight-bold mb-0">{{ __('No matching departments found') }}</p>
                            <small>{{ __('Try searching with another keyword.') }}</small>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL: ADD DEPARTMENT                                          -->
<!-- ============================================================== -->
<div class="modal fade dept-modal" id="addDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="addDepartmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('departments.store') }}" method="POST" onsubmit="if (typeof showOverlay === 'function') showOverlay();">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="addDepartmentModalLabel">
                        <i class="fas fa-plus-circle text-primary mr-1"></i>
                        {{ __('Add New Department') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="form-group mb-0">
                        <label for="dept_name" class="font-weight-bold text-sm">
                            {{ __('Department Name') }} <span class="text-danger">*</span>
                        </label>
                        <div class="input-group dept-input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-building"></i></span>
                            </div>
                            <input type="text" class="form-control" id="dept_name" name="name" placeholder="{{ __('e.g., Human Resources, IT Services') }}" required autofocus>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary px-4 font-weight-bold">
                        <i class="fas fa-check mr-1"></i> {{ __('Create Department') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- EDIT DEPARTMENT MODALS                                         -->
<!-- ============================================================== -->
@foreach ($departments as $item)
    <div class="modal fade dept-modal" id="editModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('departments.update', $item->id) }}" method="POST" onsubmit="if (typeof showOverlay === 'function') showOverlay();">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold" id="editModalLabel{{ $item->id }}">
                            <i class="fas fa-edit text-primary mr-1"></i>
                            {{ __('Edit Department') }}: {{ $item->name }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="form-group mb-0">
                            <label for="edit_dept_name_{{ $item->id }}" class="font-weight-bold text-sm">
                                {{ __('Department Name') }} <span class="text-danger">*</span>
                            </label>
                            <div class="input-group dept-input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                                </div>
                                <input type="text" class="form-control" id="edit_dept_name_{{ $item->id }}" name="name" value="{{ $item->name }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary px-4 font-weight-bold">
                            <i class="fas fa-save mr-1"></i> {{ __('Save Changes') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Live Client-Side Search Filter
    const searchInput = document.getElementById('deptSearchInput');
    const tableRows = document.querySelectorAll('.dept-row');
    const noResultRow = document.getElementById('noSearchDeptRow');
    const countBadge = document.getElementById('deptCountBadge');

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
                countBadge.textContent = `${visibleCount} {{ __('Departments') }}`;
            }
        });
    }

    // 2. SweetAlert2 Delete Confirmation
    document.querySelectorAll('.delete-dept-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('form');
            const deptName = form.getAttribute('data-name') || 'this department';

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: '{{ __("Delete Department?") }}',
                    html: `{{ __("Are you sure you want to delete") }} <strong>${deptName}</strong>?<br><small class="text-danger">{{ __("Assigned staff members may become unassigned.") }}</small>`,
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
                if (confirm(`{{ __("Are you sure you want to delete") }} "${deptName}"?`)) {
                    if (typeof showOverlay === 'function') showOverlay();
                    form.submit();
                }
            }
        });
    });
});
</script>

@endsection
