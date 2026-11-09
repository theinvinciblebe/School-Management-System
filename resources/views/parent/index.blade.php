@extends('layout.main')

@section('title', __('Parent Management'))

@section('content')

<style>
/* ══════════════════════════════════════════════════════════════════
   PARENT & GUARDIAN MANAGEMENT – Executive SaaS Design System
══════════════════════════════════════════════════════════════════ */
.parent-dashboard-wrapper {
    padding: 0.5rem 0.25rem 2.5rem;
}

/* Header Box */
.parent-header-box {
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
html.dark-mode .parent-header-box {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 24px -2px rgba(0, 0, 0, 0.35);
}

.parent-header-title {
    font-size: 1.35rem;
    font-weight: 800;
    margin-bottom: 0.2rem;
    display: flex;
    align-items: center;
    gap: 0.65rem;
    color: #1e293b;
}
html.dark-mode .parent-header-title {
    color: #f8fafc;
}

.parent-header-subtitle {
    font-size: 0.85rem;
    color: #64748b;
    margin: 0;
}
html.dark-mode .parent-header-subtitle {
    color: #94a3b8;
}

.parent-action-btn-group {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    flex-wrap: wrap;
}

.parent-btn {
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
.parent-btn-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
}
.parent-btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
}
.parent-btn-secondary {
    background: #f1f5f9;
    color: #334155 !important;
    border-color: #cbd5e1;
}
.parent-btn-secondary:hover {
    background: #e2e8f0;
    color: #0f172a !important;
}
html.dark-mode .parent-btn-secondary {
    background: #282f48;
    color: #e2e8f0 !important;
    border-color: #3b4261;
}
html.dark-mode .parent-btn-secondary:hover {
    background: #333c5e;
}

/* KPI Cards Grid */
.parent-kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem;
    margin-bottom: 1.25rem;
}

.parent-kpi-card {
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
.parent-kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
}
html.dark-mode .parent-kpi-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.25);
}

.parent-kpi-icon {
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

.parent-kpi-value {
    font-size: 1.6rem;
    font-weight: 800;
    line-height: 1.1;
    color: #0f172a;
}
html.dark-mode .parent-kpi-value {
    color: #f8fafc;
}
.parent-kpi-label {
    font-size: 0.8rem;
    font-weight: 600;
    color: #64748b;
    margin-top: 0.2rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
html.dark-mode .parent-kpi-label {
    color: #94a3b8;
}

/* Main Card */
.parent-main-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.04);
    overflow: hidden;
}
html.dark-mode .parent-main-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 24px -2px rgba(0, 0, 0, 0.35);
}

/* Card Toolbar & Filter Bar */
.parent-card-toolbar {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.85rem;
    background: #fbfcfe;
}
html.dark-mode .parent-card-toolbar {
    border-color: #2e354f;
    background: #191c2b;
}

.parent-filters-group {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    flex-wrap: wrap;
}

.parent-filter-select {
    height: 38px;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    background: #ffffff;
    color: #334155;
    font-size: 0.85rem;
    padding: 0 2.2rem 0 0.85rem;
    outline: none;
    transition: all 0.2s ease;
    cursor: pointer;
    background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2214%22%20height%3D%2214%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%2364748b%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpath%20d%3D%22m6%209%206%206%206-6%22%2F%3E%3C%2Fsvg%3E");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 14px;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}
.parent-filter-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}
html.dark-mode .parent-filter-select {
    background-color: #1b1e2e;
    border-color: #3b4261;
    color: #f1f5f9;
    background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2214%22%20height%3D%2214%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%2394a3b8%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpath%20d%3D%22m6%209%206%206%206-6%22%2F%3E%3C%2Fsvg%3E");
}

.parent-search-box {
    position: relative;
    min-width: 260px;
    flex-grow: 1;
    max-width: 360px;
}
.parent-search-icon {
    position: absolute;
    left: 0.85rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.85rem;
    pointer-events: none;
}
.parent-search-input {
    width: 100%;
    height: 38px;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    background: #ffffff;
    color: #1e293b;
    padding: 0 1rem 0 2.25rem;
    font-size: 0.85rem;
    transition: all 0.2s ease;
    outline: none;
}
.parent-search-input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}
html.dark-mode .parent-search-input {
    background: #1b1e2e;
    border-color: #3b4261;
    color: #f8fafc;
}
html.dark-mode .parent-search-input::placeholder {
    color: #64748b;
}

/* Parent Table */
.parent-table {
    margin-bottom: 0;
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}
.parent-table th {
    background: #f8fafc;
    color: #475569;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 0.85rem 1.15rem;
    border-top: none;
    border-bottom: 1px solid #e2e8f0;
    white-space: nowrap;
}
html.dark-mode .parent-table th {
    background: #191c2b;
    color: #94a3b8;
    border-color: #2e354f;
}

.parent-table td {
    padding: 0.95rem 1.15rem;
    vertical-align: middle;
    border-top: 1px solid #f1f5f9;
    color: #334155;
    font-size: 0.875rem;
    transition: background 0.15s ease;
}
html.dark-mode .parent-table td {
    border-color: #282f48;
    color: #cbd5e1;
}
.parent-table tbody tr:hover td {
    background-color: #f8fafc;
}
html.dark-mode .parent-table tbody tr:hover td {
    background-color: #252a3d;
}

/* Parent Avatar Initials */
.parent-avatar {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: linear-gradient(135deg, #3b82f6, #6366f1);
    color: #ffffff;
    font-weight: 700;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.25);
}

.parent-name {
    font-weight: 700;
    color: #0f172a;
    font-size: 0.95rem;
    line-height: 1.3;
}
html.dark-mode .parent-name {
    color: #f8fafc;
}

.parent-id-pill {
    font-size: 0.72rem;
    font-weight: 600;
    padding: 0.12rem 0.45rem;
    border-radius: 6px;
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #e2e8f0;
    font-family: monospace;
}
html.dark-mode .parent-id-pill {
    background: #252a3d;
    color: #94a3b8;
    border-color: #3b4261;
}

.parent-profession-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    font-size: 0.76rem;
    font-weight: 600;
    padding: 0.2rem 0.55rem;
    border-radius: 6px;
    background: rgba(14, 165, 233, 0.1);
    color: #0284c7;
    border: 1px solid rgba(14, 165, 233, 0.25);
    margin-top: 0.25rem;
}
html.dark-mode .parent-profession-pill {
    background: rgba(14, 165, 233, 0.18);
    color: #38bdf8;
    border-color: rgba(14, 165, 233, 0.35);
}

/* Child / Student Pills */
.child-chip {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.78rem;
    font-weight: 600;
    color: #10b981;
    background: rgba(16, 185, 129, 0.1);
    border: 1px solid rgba(16, 185, 129, 0.25);
    padding: 0.22rem 0.6rem;
    border-radius: 8px;
    margin: 0.15rem 0.25rem 0.15rem 0;
}
html.dark-mode .child-chip {
    background: rgba(16, 185, 129, 0.18);
    color: #34d399;
    border-color: rgba(16, 185, 129, 0.35);
}

/* Contact Items */
.parent-contact-item {
    font-size: 0.825rem;
    display: flex;
    align-items: center;
    gap: 0.45rem;
    margin-bottom: 0.25rem;
    color: #475569;
}
html.dark-mode .parent-contact-item {
    color: #cbd5e1;
}
.parent-contact-item a {
    color: inherit;
    text-decoration: none;
    transition: color 0.15s ease;
}
.parent-contact-item a:hover {
    color: #3b82f6;
    text-decoration: underline;
}

/* Modals */
.parent-modal .modal-content {
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}
html.dark-mode .parent-modal .modal-content {
    background: #1e2235;
    border-color: #2e354f;
    color: #f1f5f9;
}
.parent-modal .modal-header {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 1.15rem 1.5rem;
}
html.dark-mode .parent-modal .modal-header {
    background: #191c2b;
    border-color: #2e354f;
}
.parent-modal .modal-footer {
    border-top: 1px solid #e2e8f0;
    background: #f8fafc;
    padding: 0.95rem 1.5rem;
}
html.dark-mode .parent-modal .modal-footer {
    border-color: #2e354f;
    background: #191c2b;
}

.parent-input-group .input-group-text {
    background: #f8fafc;
    border-color: #cbd5e1;
    color: #64748b;
    border-radius: 10px 0 0 10px;
    width: 42px;
    justify-content: center;
}
html.dark-mode .parent-input-group .input-group-text {
    background: #252a3d;
    border-color: #3b4261;
    color: #94a3b8;
}
.parent-input-group .form-control {
    border-color: #cbd5e1;
    border-radius: 0 10px 10px 0;
    font-size: 0.875rem;
    height: 42px;
}
html.dark-mode .parent-input-group .form-control {
    background: #1b1e2e;
    border-color: #3b4261;
    color: #f1f5f9;
}
.parent-input-group .form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}
</style>

@php
    $canManage = in_array(Auth::user()->role, [0, 1]); // Admin and Teacher can manage
@endphp

<div class="parent-dashboard-wrapper">
    <!-- Header Action Banner -->
    <div class="parent-header-box">
        <div>
            <div class="parent-header-title">
                <i class="fas fa-users-cog text-primary"></i>
                {{ __('Parent & Guardian Directory') }}
            </div>
            <p class="parent-header-subtitle">
                {{ __('Manage student family records, guardian emergency contacts, professions, and ward relationships.') }}
            </p>
        </div>

        <div class="parent-action-btn-group">
            <a href="{{ route('students.index') }}" class="parent-btn parent-btn-secondary" title="{{ __('View Student Directory') }}">
                <i class="fas fa-user-graduate text-primary"></i>
                <span>{{ __('Student Directory') }}</span>
            </a>

            @if($canManage)
                <button type="button" class="parent-btn parent-btn-primary" data-toggle="modal" data-target="#addParentModal">
                    <i class="fas fa-user-plus"></i>
                    <span>{{ __('Add New Parent') }}</span>
                </button>
            @endif
        </div>
    </div>

    <!-- Top KPI Metric Cards -->
    <div class="parent-kpi-grid">
        <div class="parent-kpi-card">
            <div class="parent-kpi-icon kpi-indigo">
                <i class="fas fa-user-friends"></i>
            </div>
            <div>
                <div class="parent-kpi-value">{{ $metrics['total_parents'] ?? count($parents) }}</div>
                <div class="parent-kpi-label">{{ __('Registered Parents') }}</div>
            </div>
        </div>

        <div class="parent-kpi-card">
            <div class="parent-kpi-icon kpi-emerald">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div>
                <div class="parent-kpi-value">{{ $metrics['total_children_linked'] ?? 0 }}</div>
                <div class="parent-kpi-label">{{ __('Linked Students') }}</div>
            </div>
        </div>

        <div class="parent-kpi-card">
            <div class="parent-kpi-icon kpi-sky">
                <i class="fas fa-briefcase"></i>
            </div>
            <div>
                <div class="parent-kpi-value">{{ $metrics['professions_count'] ?? 0 }}</div>
                <div class="parent-kpi-label">{{ __('Unique Professions') }}</div>
            </div>
        </div>

        <div class="parent-kpi-card">
            <div class="parent-kpi-icon kpi-amber">
                <i class="fas fa-phone-alt"></i>
            </div>
            <div>
                <div class="parent-kpi-value">{{ $metrics['with_contacts'] ?? 0 }}</div>
                <div class="parent-kpi-label">{{ __('Contact Verified') }}</div>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="parent-main-card">
        <!-- Card Toolbar -->
        <div class="parent-card-toolbar">
            <div class="d-flex align-items-center gap-2">
                <h5 class="mb-0 font-weight-bold" style="font-size: 1rem;">
                    {{ __('Parents Roster') }}
                </h5>
                <span class="badge badge-light border ml-2" id="parentCountBadge" style="font-size: 0.78rem;">
                    {{ count($parents) }} {{ __('Records') }}
                </span>
            </div>

            <!-- Filter Controls -->
            <div class="parent-filters-group">
                <!-- Profession Selector Filter -->
                <select id="parentProfessionFilter" class="parent-filter-select" title="{{ __('Filter by Profession') }}">
                    <option value="all">{{ __('All Professions') }}</option>
                    @foreach($professions as $prof)
                        <option value="{{ strtolower($prof) }}">{{ $prof }}</option>
                    @endforeach
                </select>

                <!-- Children Filter -->
                <select id="parentChildrenFilter" class="parent-filter-select" title="{{ __('Filter by Linked Students') }}">
                    <option value="all">{{ __('All Families') }}</option>
                    <option value="has_children">{{ __('With Enrolled Students') }}</option>
                    <option value="no_children">{{ __('No Linked Students') }}</option>
                </select>

                <!-- Real-time Live Search -->
                <div class="parent-search-box">
                    <i class="fas fa-search parent-search-icon"></i>
                    <input type="text" id="parentSearchInput" class="parent-search-input" placeholder="{{ __('Search parent, child, phone, email...') }}" autocomplete="off">
                </div>
            </div>
        </div>

        <!-- Table View -->
        <div class="table-responsive">
            <table class="table parent-table" id="parentMasterTable">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>{{ __('Parent / Guardian') }}</th>
                        <th>{{ __('Associated Students (Children)') }}</th>
                        <th>{{ __('Contact Information') }}</th>
                        <th>{{ __('Residential Address') }}</th>
                        <th style="width: 100px;" class="text-right">{{ __('Options') }}</th>
                    </tr>
                </thead>
                <tbody id="parentTableBody">
                    @forelse($parents as $index => $parent)
                        @php
                            $childrenNames = $parent->children->pluck('name')->implode(' ');
                            $searchBlob = strtolower(implode(' ', [
                                $parent->name ?? '',
                                $parent->email ?? '',
                                $parent->phone ?? '',
                                $parent->profession ?? '',
                                $parent->address ?? '',
                                $childrenNames
                            ]));
                            $hasChildren = ($parent->children_count > 0);
                        @endphp
                        <tr class="parent-row"
                            data-search="{{ $searchBlob }}"
                            data-profession="{{ strtolower($parent->profession ?? '') }}"
                            data-children="{{ $hasChildren ? 'has_children' : 'no_children' }}">
                            <td class="text-muted font-weight-bold" style="font-size: 0.8rem;">
                                {{ $index + 1 }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="parent-avatar mr-3">
                                        {{ strtoupper(mb_substr($parent->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="parent-name">
                                            {{ $parent->name }}
                                        </div>
                                        <div class="d-flex align-items-center gap-1 mt-1">
                                            <span class="parent-id-pill" title="{{ __('Parent ID') }}">
                                                #P-{{ str_pad($parent->parent_id, 4, '0', STR_PAD_LEFT) }}
                                            </span>
                                            @if(!empty($parent->profession))
                                                <span class="parent-profession-pill">
                                                    <i class="fas fa-briefcase"></i>
                                                    {{ $parent->profession }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($hasChildren)
                                    <div class="d-flex flex-wrap align-items-center">
                                        @foreach($parent->children as $child)
                                            <span class="child-chip" title="{{ __('Enrolled Student') }}">
                                                <i class="fas fa-user-graduate"></i>
                                                {{ $child->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted small">
                                        <i class="fas fa-minus-circle opacity-50 mr-1"></i>
                                        {{ __('No students linked') }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="parent-contact-item">
                                    <i class="far fa-envelope text-primary"></i>
                                    @if(!empty($parent->email))
                                        <a href="mailto:{{ $parent->email }}">{{ $parent->email }}</a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                                <div class="parent-contact-item">
                                    <i class="fas fa-phone-alt text-success"></i>
                                    @if(!empty($parent->phone))
                                        <a href="tel:{{ $parent->phone }}">{{ $parent->phone }}</a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="text-muted small">
                                    <i class="fas fa-map-marker-alt text-danger mr-1"></i>
                                    {{ $parent->address ?: __('Address not registered') }}
                                </div>
                                @if(!empty($parent->created_at))
                                    <div class="text-muted small mt-1">
                                        <i class="far fa-calendar-alt text-info mr-1"></i>
                                        {{ date('M d, Y', strtotime($parent->created_at)) }}
                                    </div>
                                @endif
                            </td>
                            <td class="text-right">
                                @if($canManage)
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius: 8px;">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right shadow-sm border-0" style="border-radius: 10px;">
                                            <button type="button" class="dropdown-item text-primary font-weight-500 py-2" data-toggle="modal" data-target="#editParentModal{{ $parent->parent_id }}">
                                                <i class="fas fa-edit mr-2"></i> {{ __('Edit Parent') }}
                                            </button>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('parent.destroy', $parent->parent_id) }}" method="POST" class="delete-parent-form" data-name="{{ $parent->name }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="dropdown-item text-danger font-weight-500 py-2 delete-parent-btn">
                                                    <i class="fas fa-trash-alt mr-2"></i> {{ __('Delete Parent') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <span class="badge badge-light border text-muted">
                                        <i class="fas fa-eye mr-1"></i> {{ __('View Only') }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr id="emptyParentRow">
                            <td colspan="6" class="text-center py-5 text-muted">
                                <div class="py-4">
                                    <i class="fas fa-user-friends fa-3x mb-3 text-secondary opacity-50"></i>
                                    <p class="font-weight-bold mb-1">{{ __('No parents or guardians registered yet') }}</p>
                                    <p class="small text-muted mb-3">{{ __('Add parent profiles to associate family emergency contacts with enrolled students.') }}</p>
                                    @if($canManage)
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addParentModal">
                                            <i class="fas fa-plus mr-1"></i> {{ __('Add Parent Profile') }}
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    <tr id="noSearchParentRow" style="display: none;">
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-search fa-2x mb-2 text-secondary opacity-50"></i>
                            <p class="font-weight-bold mb-0">{{ __('No matching parents found') }}</p>
                            <small>{{ __('Try adjusting your search criteria or clear the filters.') }}</small>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($canManage)
    <!-- ============================================================== -->
    <!-- MODAL: ADD PARENT                                              -->
    <!-- ============================================================== -->
    <div class="modal fade parent-modal" id="addParentModal" tabindex="-1" role="dialog" aria-labelledby="addParentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('parent.store') }}" method="POST" onsubmit="if (typeof showOverlay === 'function') showOverlay();">
                    @csrf
                    <div class="modal-header">
                        <div>
                            <h5 class="modal-title font-weight-bold" id="addParentModalLabel">
                                <i class="fas fa-user-plus text-primary mr-1"></i>
                                {{ __('Add New Parent / Guardian') }}
                            </h5>
                            <p class="text-muted small mb-0">{{ __('Register family contact information and occupation details') }}</p>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body p-4">
                        <div class="form-row">
                            <!-- Parent Name -->
                            <div class="form-group col-md-6">
                                <label for="add_name" class="font-weight-bold text-sm">
                                    {{ __('Full Name') }} <span class="text-danger">*</span>
                                </label>
                                <div class="input-group parent-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="add_name" name="name" placeholder="{{ __('e.g., Robert Vance') }}" required autofocus>
                                </div>
                            </div>

                            <!-- Profession -->
                            <div class="form-group col-md-6">
                                <label for="add_profession" class="font-weight-bold text-sm">
                                    {{ __('Profession / Occupation') }}
                                </label>
                                <div class="input-group parent-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                    </div>
                                    <input type="text" list="professionList" class="form-control" id="add_profession" name="profession" placeholder="{{ __('e.g., Business Owner, Engineer') }}">
                                    <datalist id="professionList">
                                        <option value="Business Owner">
                                        <option value="Software Engineer">
                                        <option value="Doctor / Physician">
                                        <option value="Teacher / Educator">
                                        <option value="Civil Servant">
                                        <option value="Accountant / Auditor">
                                        <option value="Attorney / Lawyer">
                                        <option value="Merchant / Trader">
                                        <option value="Homemaker">
                                    </datalist>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="form-group col-md-6">
                                <label for="add_email" class="font-weight-bold text-sm">
                                    {{ __('Email Address') }} <span class="text-danger">*</span>
                                </label>
                                <div class="input-group parent-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email" class="form-control" id="add_email" name="email" placeholder="{{ __('e.g., r.vance@example.com') }}" required>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="form-group col-md-6">
                                <label for="add_phone" class="font-weight-bold text-sm">
                                    {{ __('Phone Number') }} <span class="text-danger">*</span>
                                </label>
                                <div class="input-group parent-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="add_phone" name="phone" placeholder="{{ __('e.g., +1 555 123 4567') }}" required>
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="form-group col-12">
                                <label for="add_address" class="font-weight-bold text-sm">
                                    {{ __('Residential Address') }} <span class="text-danger">*</span>
                                </label>
                                <div class="input-group parent-input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="add_address" name="address" placeholder="{{ __('Street, District, City') }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary px-4 font-weight-bold">
                            <i class="fas fa-check mr-1"></i> {{ __('Register Parent') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- EDIT PARENT MODALS                                             -->
    <!-- ============================================================== -->
    @foreach ($parents as $parent)
        <div class="modal fade parent-modal" id="editParentModal{{ $parent->parent_id }}" tabindex="-1" role="dialog" aria-labelledby="editParentModalLabel{{ $parent->parent_id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form action="{{ route('parent.update', $parent->parent_id) }}" method="POST" onsubmit="if (typeof showOverlay === 'function') showOverlay();">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <div>
                                <h5 class="modal-title font-weight-bold" id="editParentModalLabel{{ $parent->parent_id }}">
                                    <i class="fas fa-user-edit text-primary mr-1"></i>
                                    {{ __('Edit Parent') }}: {{ $parent->name }}
                                </h5>
                                <p class="text-muted small mb-0">{{ __('Update guardian contact details, profession, and residential location') }}</p>
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body p-4">
                            <div class="form-row">
                                <!-- Name -->
                                <div class="form-group col-md-6">
                                    <label for="edit_name_{{ $parent->parent_id }}" class="font-weight-bold text-sm">
                                        {{ __('Full Name') }} <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group parent-input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="edit_name_{{ $parent->parent_id }}" name="name" value="{{ $parent->name }}" required>
                                    </div>
                                </div>

                                <!-- Profession -->
                                <div class="form-group col-md-6">
                                    <label for="edit_profession_{{ $parent->parent_id }}" class="font-weight-bold text-sm">
                                        {{ __('Profession / Occupation') }}
                                    </label>
                                    <div class="input-group parent-input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                        </div>
                                        <input type="text" list="professionList" class="form-control" id="edit_profession_{{ $parent->parent_id }}" name="profession" value="{{ $parent->profession }}">
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="form-group col-md-6">
                                    <label for="edit_email_{{ $parent->parent_id }}" class="font-weight-bold text-sm">
                                        {{ __('Email Address') }} <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group parent-input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input type="email" class="form-control" id="edit_email_{{ $parent->parent_id }}" name="email" value="{{ $parent->email }}" required>
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div class="form-group col-md-6">
                                    <label for="edit_phone_{{ $parent->parent_id }}" class="font-weight-bold text-sm">
                                        {{ __('Phone Number') }} <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group parent-input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="edit_phone_{{ $parent->parent_id }}" name="phone" value="{{ $parent->phone }}" required>
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="form-group col-12">
                                    <label for="edit_address_{{ $parent->parent_id }}" class="font-weight-bold text-sm">
                                        {{ __('Residential Address') }} <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group parent-input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="edit_address_{{ $parent->parent_id }}" name="address" value="{{ $parent->address }}" required>
                                    </div>
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
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Live Client-Side Filtering & Search
    const searchInput = document.getElementById('parentSearchInput');
    const professionFilter = document.getElementById('parentProfessionFilter');
    const childrenFilter = document.getElementById('parentChildrenFilter');
    const rows = document.querySelectorAll('.parent-row');
    const noResultRow = document.getElementById('noSearchParentRow');
    const countBadge = document.getElementById('parentCountBadge');

    function applyFilters() {
        const query = (searchInput ? searchInput.value.trim().toLowerCase() : '');
        const selectedProf = (professionFilter ? professionFilter.value : 'all');
        const selectedChildren = (childrenFilter ? childrenFilter.value : 'all');

        let visibleCount = 0;

        rows.forEach(row => {
            const searchData = row.getAttribute('data-search') || '';
            const rowProf = row.getAttribute('data-profession') || '';
            const rowChildren = row.getAttribute('data-children') || '';

            const matchesQuery = !query || searchData.includes(query);
            const matchesProf = (selectedProf === 'all' || rowProf === selectedProf);
            const matchesChildren = (selectedChildren === 'all' || rowChildren === selectedChildren);

            if (matchesQuery && matchesProf && matchesChildren) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        if (noResultRow) {
            noResultRow.style.display = (visibleCount === 0 && rows.length > 0) ? '' : 'none';
        }

        if (countBadge) {
            countBadge.textContent = `${visibleCount} {{ __('Records') }}`;
        }
    }

    if (searchInput) searchInput.addEventListener('input', applyFilters);
    if (professionFilter) professionFilter.addEventListener('change', applyFilters);
    if (childrenFilter) childrenFilter.addEventListener('change', applyFilters);

    // 2. SweetAlert2 Delete Confirmation
    document.querySelectorAll('.delete-parent-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('form');
            const parentName = form.getAttribute('data-name') || 'this parent';

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: '{{ __("Delete Parent Profile?") }}',
                    html: `{{ __("Are you sure you want to delete") }} <strong>${parentName}</strong>?<br><small class="text-danger">{{ __("Any linked students will be safely detached.") }}</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: '<i class="fas fa-trash-alt mr-1"></i> {{ __("Yes, delete parent") }}',
                    cancelButtonText: '{{ __("Cancel") }}',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (typeof showOverlay === 'function') showOverlay();
                        form.submit();
                    }
                });
            } else {
                if (confirm(`{{ __("Are you sure you want to delete") }} "${parentName}"?`)) {
                    if (typeof showOverlay === 'function') showOverlay();
                    form.submit();
                }
            }
        });
    });
});
</script>

@endsection
