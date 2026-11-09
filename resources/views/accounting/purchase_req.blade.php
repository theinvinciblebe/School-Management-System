@extends('layout.main')

@section('title', __('Purchase Requests & Procurement'))

@section('content')

<style>
/* ══════════════════════════════════════════════════════════════════
   PURCHASE REQUESTS – Executive SaaS Design System
══════════════════════════════════════════════════════════════════ */
.acc-pr-wrapper {
    padding: 0.5rem 0.25rem 2.5rem;
}

/* Header Box */
.acc-pr-header {
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
.acc-pr-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 5px;
    height: 100%;
    background: linear-gradient(180deg, #0ea5e9, #6366f1);
}
html.dark-mode .acc-pr-header {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 24px -2px rgba(0, 0, 0, 0.35);
}

.acc-pr-title {
    font-size: 1.35rem;
    font-weight: 800;
    margin-bottom: 0.2rem;
    display: flex;
    align-items: center;
    gap: 0.65rem;
    color: #1e293b;
}
html.dark-mode .acc-pr-title {
    color: #f8fafc;
}

.acc-pr-subtitle {
    font-size: 0.85rem;
    color: #64748b;
    margin: 0;
}
html.dark-mode .acc-pr-subtitle {
    color: #94a3b8;
}

.acc-pr-actions {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    flex-wrap: wrap;
}

.btn-acc {
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
.btn-acc-primary {
    background: linear-gradient(135deg, #0ea5e9, #0284c7);
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(14, 165, 233, 0.25);
}
.btn-acc-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(14, 165, 233, 0.35);
    background: linear-gradient(135deg, #0284c7, #0369a1);
}
.btn-acc-secondary {
    background: #f1f5f9;
    color: #334155 !important;
    border-color: #cbd5e1;
}
.btn-acc-secondary:hover {
    background: #e2e8f0;
    color: #0f172a !important;
}
html.dark-mode .btn-acc-secondary {
    background: #282f48;
    color: #e2e8f0 !important;
    border-color: #3b4261;
}
html.dark-mode .btn-acc-secondary:hover {
    background: #333c5e;
}

/* KPI Cards Grid */
.acc-pr-kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem;
    margin-bottom: 1.25rem;
}

.acc-pr-kpi-card {
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
.acc-pr-kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
}
html.dark-mode .acc-pr-kpi-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.25);
}

.acc-pr-kpi-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}
.kpi-sky    { background: rgba(14, 165, 233, 0.12); color: #0ea5e9; }
.kpi-emerald{ background: rgba(16, 185, 129, 0.12); color: #10b981; }
.kpi-amber  { background: rgba(245, 158, 11, 0.12); color: #f59e0b; }
.kpi-indigo { background: rgba(99, 102, 241, 0.12); color: #6366f1; }

.acc-pr-kpi-value {
    font-size: 1.55rem;
    font-weight: 800;
    line-height: 1.1;
    color: #0f172a;
}
html.dark-mode .acc-pr-kpi-value {
    color: #f8fafc;
}
.acc-pr-kpi-label {
    font-size: 0.78rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: #64748b;
    margin-top: 0.15rem;
}
html.dark-mode .acc-pr-kpi-label {
    color: #94a3b8;
}

/* Main Table Card */
.acc-pr-main-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.04);
}
html.dark-mode .acc-pr-main-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 24px -2px rgba(0, 0, 0, 0.35);
}

.acc-pr-toolbar {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.85rem;
    background: #f8fafc;
}
html.dark-mode .acc-pr-toolbar {
    background: #191c2b;
    border-color: #2e354f;
}

.acc-filter-tabs {
    display: flex;
    align-items: center;
    gap: 0.35rem;
    background: #e2e8f0;
    padding: 0.25rem;
    border-radius: 10px;
}
html.dark-mode .acc-filter-tabs {
    background: #252a3d;
}
.acc-filter-pill {
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
.acc-filter-pill:hover {
    color: #1e293b;
}
.acc-filter-pill.active {
    background: #ffffff;
    color: #0284c7;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
}
html.dark-mode .acc-filter-pill {
    color: #94a3b8;
}
html.dark-mode .acc-filter-pill.active {
    background: #1e2235;
    color: #38bdf8;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
}
.acc-filter-count {
    font-size: 0.72rem;
    padding: 0.1rem 0.4rem;
    border-radius: 10px;
    background: rgba(100, 116, 139, 0.15);
}
.acc-filter-pill.active .acc-filter-count {
    background: rgba(14, 165, 233, 0.15);
}

.acc-search-box {
    position: relative;
    min-width: 250px;
    max-width: 380px;
    flex: 1;
}
.acc-search-input {
    width: 100%;
    padding: 0.45rem 1rem 0.45rem 2.25rem;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 0.875rem;
    background: #ffffff;
    color: #1e293b;
    transition: all 0.2s;
}
.acc-search-input:focus {
    outline: none;
    border-color: #0ea5e9;
    box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.15);
}
html.dark-mode .acc-search-input {
    background: #252a3d;
    border-color: #3b4261;
    color: #f1f5f9;
}
.acc-search-icon {
    position: absolute;
    left: 0.8rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.85rem;
    pointer-events: none;
}

/* Modern Table */
.acc-table {
    margin: 0;
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}
.acc-table thead th {
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
html.dark-mode .acc-table thead th {
    background: #191c2b;
    color: #94a3b8;
    border-color: #2e354f;
}
.acc-table tbody td {
    padding: 0.95rem 1rem;
    vertical-align: middle;
    border-top: none;
    border-bottom: 1px solid #f1f5f9;
    font-size: 0.88rem;
    color: #334155;
}
html.dark-mode .acc-table tbody td {
    border-color: #262c44;
    color: #cbd5e1;
}
.acc-table tbody tr:hover {
    background: #f8fafc;
}
html.dark-mode .acc-table tbody tr:hover {
    background: #22273c;
}

/* Requisitioner Avatar & Tags */
.acc-staff-avatar {
    width: 38px;
    height: 38px;
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
html.dark-mode .acc-staff-avatar {
    background: linear-gradient(135deg, #075985, #0284c7);
    color: #e0f2fe;
}
.acc-staff-name {
    font-weight: 700;
    color: #0f172a;
    font-size: 0.92rem;
    line-height: 1.2;
}
html.dark-mode .acc-staff-name {
    color: #f8fafc;
}

.acc-request-no {
    font-family: monospace;
    font-weight: 700;
    font-size: 0.78rem;
    padding: 0.15rem 0.5rem;
    border-radius: 6px;
    background: #f1f5f9;
    color: #0f172a;
    border: 1px solid #e2e8f0;
}
html.dark-mode .acc-request-no {
    background: #252a3d;
    color: #38bdf8;
    border-color: #3b4261;
}

.dept-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.2rem 0.6rem;
    border-radius: 8px;
    font-size: 0.78rem;
    font-weight: 600;
    background: rgba(99, 102, 241, 0.1);
    color: #4f46e5;
    border: 1px solid rgba(99, 102, 241, 0.2);
}
html.dark-mode .dept-badge {
    background: rgba(99, 102, 241, 0.2);
    color: #a5b4fc;
}

.vendor-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.15rem 0.5rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
    background: #f8fafc;
    color: #475569;
    border: 1px solid #cbd5e1;
}
html.dark-mode .vendor-badge {
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
.pulse-dot-amber { background: #f59e0b; box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.3); animation: pulseAnim 1.6s infinite; }
.pulse-dot-red   { background: #ef4444; box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.3); }
@keyframes pulseAnim {
    0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.5); }
    70% { transform: scale(1.05); box-shadow: 0 0 0 6px rgba(245, 158, 11, 0); }
    100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
}

/* Action Icon Buttons */
.acc-actions-group {
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
.btn-action-icon:hover {
    transform: translateY(-1px);
}
.btn-action-view:hover { background: #e0f2fe; color: #0284c7; border-color: #bae6fd; }
.btn-action-edit:hover { background: #fef3c7; color: #d97706; border-color: #fde68a; }
.btn-action-delete:hover { background: #fee2e2; color: #dc2626; border-color: #fca5a5; }
.btn-action-approve:hover { background: #dcfce7; color: #16a34a; border-color: #bbf7d0; }
.btn-action-reject:hover { background: #fee2e2; color: #dc2626; border-color: #fca5a5; }

html.dark-mode .btn-action-icon {
    background: #252a3d;
    border-color: #3b4261;
    color: #94a3b8;
}
html.dark-mode .btn-action-view:hover { background: #0369a1; color: #ffffff; }
html.dark-mode .btn-action-edit:hover { background: #b45309; color: #ffffff; }
html.dark-mode .btn-action-delete:hover { background: #b91c1c; color: #ffffff; }
html.dark-mode .btn-action-approve:hover { background: #15803d; color: #ffffff; }
html.dark-mode .btn-action-reject:hover { background: #b91c1c; color: #ffffff; }

/* Modals */
.acc-modal .modal-content {
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}
html.dark-mode .acc-modal .modal-content {
    background: #1e2235;
    border-color: #2e354f;
    color: #f1f5f9;
}
.acc-modal .modal-header {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 1.15rem 1.5rem;
}
html.dark-mode .acc-modal .modal-header {
    background: #191c2b;
    border-color: #2e354f;
}
.acc-modal .modal-footer {
    border-top: 1px solid #e2e8f0;
    background: #f8fafc;
    padding: 0.95rem 1.5rem;
}
html.dark-mode .acc-modal .modal-footer {
    border-color: #2e354f;
    background: #191c2b;
}

.acc-items-table {
    width: 100%;
    margin-top: 0.5rem;
    border-collapse: separate;
    border-spacing: 0;
}
.acc-items-table th {
    background: #f1f5f9;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    color: #475569;
    padding: 0.6rem 0.75rem;
    border-bottom: 1px solid #cbd5e1;
}
html.dark-mode .acc-items-table th {
    background: #252a3d;
    color: #94a3b8;
    border-color: #3b4261;
}
.acc-items-table td {
    padding: 0.5rem 0.5rem;
    vertical-align: middle;
}

.acc-total-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 0.85rem 1.25rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 1rem;
}
html.dark-mode .acc-total-box {
    background: #252a3d;
    border-color: #3b4261;
}
</style>

@php
    $totalRequisitions = count($purchases);
    $approvedPurchases = $purchases->where('status', 'approved');
    $pendingPurchases = $purchases->where('status', 'pending');
    $rejectedPurchases = $purchases->where('status', 'rejected');

    $approvedCount = $approvedPurchases->count();
    $pendingCount = $pendingPurchases->count();
    $rejectedCount = $rejectedPurchases->count();

    $approvedTotal = $approvedPurchases->sum('total');
    $grandTotalRequisitions = $purchases->sum('total');
@endphp

<div class="acc-pr-wrapper">
    <!-- Header Banner -->
    <div class="acc-pr-header">
        <div>
            <div class="acc-pr-title">
                <i class="fas fa-file-invoice text-info"></i>
                {{ __('Purchase Requests & Procurement') }}
            </div>
            <p class="acc-pr-subtitle">
                {{ __('Initiate departmental purchase orders, track procurement expenditures, and oversee approvals.') }}
            </p>
        </div>

        <div class="acc-pr-actions">
            <a href="{{ route('accounting.index') }}" class="btn-acc btn-acc-secondary" title="{{ __('Back to Accounting Hub') }}">
                <i class="fas fa-arrow-left"></i>
                <span>{{ __('Accounting Hub') }}</span>
            </a>

            <button type="button" class="btn-acc btn-acc-primary" data-toggle="modal" data-target="#addPurchaseRequestModal">
                <i class="fas fa-plus"></i>
                <span>{{ __('Make New Purchase Request') }}</span>
            </button>
        </div>
    </div>

    <!-- Top KPI Metric Cards -->
    <div class="acc-pr-kpi-grid">
        <div class="acc-pr-kpi-card">
            <div class="acc-pr-kpi-icon kpi-sky">
                <i class="fas fa-file-invoice"></i>
            </div>
            <div>
                <div class="acc-pr-kpi-value">{{ $totalRequisitions }}</div>
                <div class="acc-pr-kpi-label">{{ __('Total Requisitions') }}</div>
            </div>
        </div>

        <div class="acc-pr-kpi-card">
            <div class="acc-pr-kpi-icon kpi-emerald">
                <i class="fas fa-check-double"></i>
            </div>
            <div>
                <div class="acc-pr-kpi-value">${{ number_format($approvedTotal, 2) }}</div>
                <div class="acc-pr-kpi-label">{{ __('Approved Purchases') }}</div>
            </div>
        </div>

        <div class="acc-pr-kpi-card">
            <div class="acc-pr-kpi-icon kpi-amber">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <div class="acc-pr-kpi-value">{{ $pendingCount }}</div>
                <div class="acc-pr-kpi-label">{{ __('Pending Review') }}</div>
            </div>
        </div>

        <div class="acc-pr-kpi-card">
            <div class="acc-pr-kpi-icon kpi-indigo">
                <i class="fas fa-calculator"></i>
            </div>
            <div>
                <div class="acc-pr-kpi-value">${{ number_format($grandTotalRequisitions, 2) }}</div>
                <div class="acc-pr-kpi-label">{{ __('Requested Volume') }}</div>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="acc-pr-main-card">
        <!-- Toolbar -->
        <div class="acc-pr-toolbar">
            <div class="acc-filter-tabs">
                <button type="button" class="acc-filter-pill active" data-filter="all">
                    <span>{{ __('All') }}</span>
                    <span class="acc-filter-count">{{ $totalRequisitions }}</span>
                </button>
                <button type="button" class="acc-filter-pill" data-filter="pending">
                    <span>{{ __('Pending') }}</span>
                    <span class="acc-filter-count">{{ $pendingCount }}</span>
                </button>
                <button type="button" class="acc-filter-pill" data-filter="approved">
                    <span>{{ __('Approved') }}</span>
                    <span class="acc-filter-count">{{ $approvedCount }}</span>
                </button>
                <button type="button" class="acc-filter-pill" data-filter="rejected">
                    <span>{{ __('Rejected') }}</span>
                    <span class="acc-filter-count">{{ $rejectedCount }}</span>
                </button>
            </div>

            <div class="acc-search-box">
                <i class="fas fa-search acc-search-icon"></i>
                <input type="text" id="prSearchInput" class="acc-search-input" placeholder="{{ __('Search requisitioner, request #, department, vendor...') }}" autocomplete="off">
            </div>
        </div>

        <!-- Responsive Table -->
        <div class="table-responsive">
            <table class="table acc-table" id="purchaseMasterTable">
                <thead>
                    <tr>
                        <th style="width: 45px;">#</th>
                        <th>{{ __('Requisitioner') }}</th>
                        <th>{{ __('Department') }}</th>
                        <th>{{ __('Purpose & Vendor') }}</th>
                        <th>{{ __('Requisition Amount') }}</th>
                        <th>{{ __('Timelines') }}</th>
                        <th>{{ __('Approval Status') }}</th>
                        <th style="width: 140px;" class="text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody id="prTableBody">
                    @forelse ($purchases as $index => $item)
                        @php
                            $searchBlob = strtolower(implode(' ', [
                                $item->requisitioner ?? '',
                                $item->department ?? '',
                                $item->purpose ?? '',
                                $item->vendor ?? '',
                                $item->request_no ?? '',
                                $item->status ?? '',
                            ]));
                        @endphp
                        <tr class="pr-row"
                            data-search="{{ $searchBlob }}"
                            data-status="{{ $item->status ?? 'pending' }}"
                            data-department="{{ $item->department ?? '' }}">
                            <td class="text-muted font-weight-bold" style="font-size: 0.8rem;">
                                {{ $index + 1 }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="acc-staff-avatar mr-2.5">
                                        {{ strtoupper(mb_substr($item->requisitioner ?? 'R', 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="acc-staff-name">{{ $item->requisitioner }}</div>
                                        <div class="mt-0.5">
                                            <span class="acc-request-no" title="{{ __('Request No') }}">
                                                {{ $item->request_no ?? ('REQ-' . $item->id) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="dept-badge">
                                    <i class="fas fa-building"></i>
                                    {{ $item->department ?? __('N/A') }}
                                </span>
                            </td>
                            <td>
                                <div class="font-weight-bold text-dark text-truncate" style="max-width: 220px;" title="{{ $item->purpose }}">
                                    {{ $item->purpose ?: __('No purpose stated') }}
                                </div>
                                <div class="mt-1">
                                    @if($item->vendor)
                                        <span class="vendor-badge">
                                            <i class="fas fa-store text-secondary"></i>
                                            {{ $item->vendor }}
                                        </span>
                                    @else
                                        <span class="text-muted small"><em>{{ __('Vendor not specified') }}</em></span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="font-weight-bold text-dark" style="font-size: 0.95rem;">
                                    ${{ number_format($item->total ?? 0, 2) }}
                                </div>
                            </td>
                            <td>
                                <div class="small text-muted">
                                    <span title="{{ __('Date Prepared') }}"><i class="far fa-calendar-alt text-primary mr-1"></i>{{ $item->date_prepared }}</span>
                                </div>
                                @if($item->date_needed)
                                    <div class="small mt-0.5 text-danger font-weight-600" title="{{ __('Date Needed') }}">
                                        <i class="far fa-clock mr-1"></i>{{ $item->date_needed }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if($item->status == 'approved')
                                    <span class="status-pill status-approved">
                                        <span class="pulse-dot pulse-dot-green"></span>
                                        {{ __('Approved') }}
                                    </span>
                                @elseif($item->status == 'rejected')
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
                                <div class="acc-actions-group">
                                    @if(Auth::user()->role == 0 && $item->status == 'pending')
                                        <button type="button" class="btn-action-icon btn-action-approve approve-btn" data-id="{{ $item->id }}" title="{{ __('Approve Requisition') }}">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button type="button" class="btn-action-icon btn-action-reject reject-btn" data-id="{{ $item->id }}" title="{{ __('Reject Requisition') }}">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif

                                    @if (Auth::user()->role == 0 || ((Auth::user()->role == 3 || Auth::user()->role == 4) && $item->status == 'approved'))
                                        <a href="{{ route('purchase_req.show', $item->id) }}" class="btn-action-icon btn-action-view" title="{{ __('View Details') }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @endif

                                    @if(Auth::user()->role != 4)
                                        <button type="button" class="btn-action-icon btn-action-edit edit-btn"
                                                data-id="{{ $item->id }}"
                                                data-requisitioner="{{ $item->requisitioner }}"
                                                data-department="{{ $item->department }}"
                                                data-purpose="{{ $item->purpose }}"
                                                data-vendor="{{ $item->vendor }}"
                                                data-date_prepared="{{ $item->date_prepared }}"
                                                data-date_needed="{{ $item->date_needed }}"
                                                title="{{ __('Edit Request') }}">
                                            <i class="fas fa-pen"></i>
                                        </button>

                                        <form action="{{ route('purchase_req.destroy', $item->id) }}" method="POST" class="d-inline delete-pr-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action-icon btn-action-delete" title="{{ __('Delete Request') }}">
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
                                <i class="fas fa-file-invoice fa-3x mb-3 text-secondary opacity-50 d-block"></i>
                                <h6>{{ __('No purchase requests found') }}</h6>
                                <p class="small text-muted mb-0">{{ __('Create a new purchase request by clicking the button above.') }}</p>
                            </td>
                        </tr>
                    @endforelse
                    <tr id="noResultsRow" style="display: none;">
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="fas fa-search fa-2x mb-2 text-secondary opacity-50 d-block"></i>
                            <h6>{{ __('No matching requests found') }}</h6>
                            <p class="small text-muted mb-0">{{ __('Try adjusting your search query or filters.') }}</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- =====================================================================
     ADD PURCHASE REQUEST MODAL
===================================================================== -->
<div class="modal fade acc-modal" id="addPurchaseRequestModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="addModalLabel">
                    <i class="fas fa-cart-plus text-info mr-1.5"></i>
                    {{ __('Create Purchase Request') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('purchase_req.store') }}" method="POST" id="createPrForm">
                @csrf
                <div class="modal-body p-4">
                    <!-- Auto-generated Request No -->
                    <input type="hidden" name="request_no" id="request_no" value="{{ 'REQ-' . substr(uniqid(), -6) }}">

                    <div class="row">
                        <!-- Requisitioner -->
                        <div class="col-md-6 mb-3">
                            <label for="requisitioner" class="font-weight-bold text-sm">
                                {{ __('Requisitioner') }} <span class="text-danger">*</span>
                            </label>
                            <select name="requisitioner" id="requisitioner" class="form-control" required>
                                <option value="">{{ __('-- Select Requisitioner --') }}</option>
                                @foreach($staffs as $staff)
                                    <option value="{{ $staff->name }}" data-department="{{ $staff->department_name }}">
                                        {{ $staff->name }} ({{ $staff->department_name ?? __('General') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Department -->
                        <div class="col-md-6 mb-3">
                            <label for="department" class="font-weight-bold text-sm">
                                {{ __('Department') }} <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control bg-light font-weight-bold" name="department" id="department" placeholder="{{ __('Auto-filled from staff record') }}" required readonly>
                        </div>

                        <!-- Vendor -->
                        <div class="col-md-6 mb-3">
                            <label for="vendor" class="font-weight-bold text-sm">
                                {{ __('Vendor / Supplier') }}
                            </label>
                            <input type="text" class="form-control" name="vendor" id="vendor" placeholder="{{ __('e.g. Acme Office Supplies Ltd.') }}">
                        </div>

                        <!-- Purpose -->
                        <div class="col-md-6 mb-3">
                            <label for="purpose" class="font-weight-bold text-sm">
                                {{ __('Purpose / Justification') }}
                            </label>
                            <input type="text" class="form-control" name="purpose" id="purpose" placeholder="{{ __('e.g. Science lab consumable restock') }}">
                        </div>

                        <!-- Date Prepared -->
                        <div class="col-md-6 mb-3">
                            <label for="date_prepared" class="font-weight-bold text-sm">
                                {{ __('Date Prepared') }} <span class="text-danger">*</span>
                            </label>
                            <input type="date" class="form-control" name="date_prepared" id="date_prepared" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <!-- Date Needed -->
                        <div class="col-md-6 mb-3">
                            <label for="date_needed" class="font-weight-bold text-sm">
                                {{ __('Date Needed') }}
                            </label>
                            <input type="date" class="form-control" name="date_needed" id="date_needed">
                        </div>
                    </div>

                    <!-- Items Repeater -->
                    <div class="d-flex align-items-center justify-content-between mb-2 mt-2">
                        <h6 class="font-weight-bold text-dark mb-0">
                            <i class="fas fa-boxes mr-1 text-info"></i> {{ __('Purchase Items List') }}
                        </h6>
                        <button type="button" class="btn btn-sm btn-outline-info font-weight-bold" id="addItem">
                            <i class="fas fa-plus mr-1"></i> {{ __('Add Item') }}
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table acc-items-table" id="itemsTable">
                            <thead>
                                <tr>
                                    <th style="min-width: 240px;">{{ __('Description') }} <span class="text-danger">*</span></th>
                                    <th style="width: 110px;">{{ __('Qty') }} <span class="text-danger">*</span></th>
                                    <th style="width: 120px;">{{ __('Unit') }}</th>
                                    <th style="width: 140px;">{{ __('Unit Price ($)') }} <span class="text-danger">*</span></th>
                                    <th style="width: 140px;">{{ __('Total Price ($)') }}</th>
                                    <th style="width: 60px;" class="text-center">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody id="itemsBody">
                                <tr>
                                    <td>
                                        <input type="text" name="items[0][description]" class="form-control" placeholder="{{ __('e.g. Whiteboard Markers Pack') }}" required>
                                    </td>
                                    <td>
                                        <input type="number" name="items[0][qty]" class="form-control qty" value="1" min="1" required>
                                    </td>
                                    <td>
                                        <input type="text" name="items[0][unit]" class="form-control" placeholder="{{ __('e.g. boxes, pcs') }}">
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" name="items[0][unit_price]" class="form-control unit_price" placeholder="0.00" min="0" required>
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" name="items[0][total_price]" class="form-control total_price font-weight-bold bg-light" value="0.00" readonly>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-danger removeItem" title="{{ __('Remove Item') }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Grand Total Banner -->
                    <div class="acc-total-box">
                        <span class="font-weight-bold text-muted text-uppercase text-xs letter-spacing-1">
                            {{ __('Computed Requisition Grand Total') }}
                        </span>
                        <h4 class="font-weight-bold text-info mb-0" id="createGrandTotalDisplay">$0.00</h4>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">
                        {{ __('Close') }}
                    </button>
                    <button type="submit" class="btn btn-primary font-weight-bold">
                        <i class="fas fa-save mr-1"></i> {{ __('Save Request') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- =====================================================================
     EDIT PURCHASE REQUEST MODAL
===================================================================== -->
<div class="modal fade acc-modal" id="editPurchaseRequestModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="editModalLabel">
                    <i class="fas fa-edit text-warning mr-1.5"></i>
                    {{ __('Edit Purchase Request') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit_id">

                <div class="modal-body p-4">
                    <div class="row">
                        <!-- Requisitioner -->
                        <div class="col-md-6 mb-3">
                            <label for="edit_requisitioner" class="font-weight-bold text-sm">
                                {{ __('Requisitioner') }} <span class="text-danger">*</span>
                            </label>
                            <select name="requisitioner" id="edit_requisitioner" class="form-control" required>
                                <option value="">{{ __('-- Select Requisitioner --') }}</option>
                                @foreach($staffs as $staff)
                                    <option value="{{ $staff->name }}" data-department="{{ $staff->department_name }}">
                                        {{ $staff->name }} ({{ $staff->department_name ?? __('General') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Department -->
                        <div class="col-md-6 mb-3">
                            <label for="edit_department" class="font-weight-bold text-sm">
                                {{ __('Department') }} <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control bg-light font-weight-bold" name="department" id="edit_department" required readonly>
                        </div>

                        <!-- Vendor -->
                        <div class="col-md-6 mb-3">
                            <label for="edit_vendor" class="font-weight-bold text-sm">
                                {{ __('Vendor / Supplier') }}
                            </label>
                            <input type="text" class="form-control" name="vendor" id="edit_vendor">
                        </div>

                        <!-- Purpose -->
                        <div class="col-md-6 mb-3">
                            <label for="edit_purpose" class="font-weight-bold text-sm">
                                {{ __('Purpose / Justification') }}
                            </label>
                            <input type="text" class="form-control" name="purpose" id="edit_purpose">
                        </div>

                        <!-- Date Prepared -->
                        <div class="col-md-6 mb-3">
                            <label for="edit_date_prepared" class="font-weight-bold text-sm">
                                {{ __('Date Prepared') }} <span class="text-danger">*</span>
                            </label>
                            <input type="date" class="form-control" name="date_prepared" id="edit_date_prepared" required>
                        </div>

                        <!-- Date Needed -->
                        <div class="col-md-6 mb-3">
                            <label for="edit_date_needed" class="font-weight-bold text-sm">
                                {{ __('Date Needed') }}
                            </label>
                            <input type="date" class="form-control" name="date_needed" id="edit_date_needed">
                        </div>
                    </div>

                    <!-- Items Repeater -->
                    <div class="d-flex align-items-center justify-content-between mb-2 mt-2">
                        <h6 class="font-weight-bold text-dark mb-0">
                            <i class="fas fa-boxes mr-1 text-warning"></i> {{ __('Purchase Items List') }}
                        </h6>
                        <button type="button" class="btn btn-sm btn-outline-info font-weight-bold" id="addEditItem">
                            <i class="fas fa-plus mr-1"></i> {{ __('Add Item') }}
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table acc-items-table" id="editItemsTable">
                            <thead>
                                <tr>
                                    <th style="min-width: 240px;">{{ __('Description') }} <span class="text-danger">*</span></th>
                                    <th style="width: 110px;">{{ __('Qty') }} <span class="text-danger">*</span></th>
                                    <th style="width: 120px;">{{ __('Unit') }}</th>
                                    <th style="width: 140px;">{{ __('Unit Price ($)') }} <span class="text-danger">*</span></th>
                                    <th style="width: 140px;">{{ __('Total Price ($)') }}</th>
                                    <th style="width: 60px;" class="text-center">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody id="editItemsBody">
                            </tbody>
                        </table>
                    </div>

                    <!-- Grand Total Banner -->
                    <div class="acc-total-box">
                        <span class="font-weight-bold text-muted text-uppercase text-xs letter-spacing-1">
                            {{ __('Computed Requisition Grand Total') }}
                        </span>
                        <h4 class="font-weight-bold text-warning mb-0" id="editGrandTotalDisplay">$0.00</h4>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">
                        {{ __('Close') }}
                    </button>
                    <button type="submit" class="btn btn-primary font-weight-bold">
                        <i class="fas fa-save mr-1"></i> {{ __('Save Changes') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // ══════════════════════════════════════════════════════════════════
    // Instant Live Filtering & Search
    // ══════════════════════════════════════════════════════════════════
    const searchInput = document.getElementById('prSearchInput');
    const filterPills = document.querySelectorAll('.acc-filter-pill');
    const tableRows = document.querySelectorAll('.pr-row');
    const noResultsRow = document.getElementById('noResultsRow');

    let currentFilter = 'all';

    function applyFilters() {
        const query = (searchInput.value || '').trim().toLowerCase();
        let visibleCount = 0;

        tableRows.forEach(row => {
            const rowSearch = row.getAttribute('data-search') || '';
            const rowStatus = row.getAttribute('data-status') || '';

            const matchesSearch = !query || rowSearch.includes(query);
            const matchesFilter = (currentFilter === 'all') || (rowStatus.toLowerCase() === currentFilter);

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
    // Department Auto-population for Requisitioner (Create)
    // ══════════════════════════════════════════════════════════════════
    const reqSelect = document.getElementById('requisitioner');
    if (reqSelect) {
        reqSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const deptFromData = selectedOption.getAttribute('data-department');
            if (deptFromData) {
                document.getElementById('department').value = deptFromData;
            } else if (this.value) {
                fetch(`/get-department/${this.value}`)
                    .then(r => r.json())
                    .then(data => {
                        document.getElementById('department').value = data.department || 'N/A';
                    })
                    .catch(() => {
                        document.getElementById('department').value = '';
                    });
            } else {
                document.getElementById('department').value = '';
            }
        });
    }

    // ══════════════════════════════════════════════════════════════════
    // Department Auto-population for Requisitioner (Edit)
    // ══════════════════════════════════════════════════════════════════
    const editReqSelect = document.getElementById('edit_requisitioner');
    if (editReqSelect) {
        editReqSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const deptFromData = selectedOption.getAttribute('data-department');
            if (deptFromData) {
                document.getElementById('edit_department').value = deptFromData;
            } else if (this.value) {
                fetch(`/get-department/${this.value}`)
                    .then(r => r.json())
                    .then(data => {
                        document.getElementById('edit_department').value = data.department || 'N/A';
                    })
                    .catch(() => {
                        document.getElementById('edit_department').value = '';
                    });
            } else {
                document.getElementById('edit_department').value = '';
            }
        });
    }

    // ══════════════════════════════════════════════════════════════════
    // Dynamic Items Repeater - CREATE MODAL
    // ══════════════════════════════════════════════════════════════════
    let itemCount = 1;
    const addItemBtn = document.getElementById('addItem');
    const itemsBody = document.getElementById('itemsBody');

    if (addItemBtn && itemsBody) {
        addItemBtn.addEventListener('click', function () {
            const newRow = `
                <tr>
                    <td><input type="text" name="items[${itemCount}][description]" class="form-control" placeholder="{{ __('e.g. Item description') }}" required></td>
                    <td><input type="number" name="items[${itemCount}][qty]" class="form-control qty" value="1" min="1" required></td>
                    <td><input type="text" name="items[${itemCount}][unit]" class="form-control" placeholder="{{ __('e.g. pcs, sets') }}"></td>
                    <td><input type="number" step="0.01" name="items[${itemCount}][unit_price]" class="form-control unit_price" placeholder="0.00" min="0" required></td>
                    <td><input type="number" step="0.01" name="items[${itemCount}][total_price]" class="form-control total_price font-weight-bold bg-light" value="0.00" readonly></td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-danger removeItem" title="{{ __('Remove Item') }}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
            `;
            itemsBody.insertAdjacentHTML('beforeend', newRow);
            itemCount++;
            attachItemCalculationListeners();
        });

        itemsBody.addEventListener('click', function (e) {
            const removeBtn = e.target.closest('.removeItem');
            if (removeBtn) {
                const tr = removeBtn.closest('tr');
                if (itemsBody.querySelectorAll('tr').length > 1) {
                    tr.remove();
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: '{{ __("Line Item Required") }}',
                        text: '{{ __("A purchase request must contain at least one line item.") }}',
                        confirmButtonText: '{{ __("OK") }}'
                    });
                }
                recalculateCreateGrandTotal();
            }
        });
    }

    function calculateRowTotal(row) {
        const qty = parseFloat(row.querySelector('.qty')?.value) || 0;
        const unitPrice = parseFloat(row.querySelector('.unit_price')?.value) || 0;
        const totalPriceField = row.querySelector('.total_price');
        if (totalPriceField) {
            totalPriceField.value = (qty * unitPrice).toFixed(2);
        }
    }

    function recalculateCreateGrandTotal() {
        let grandTotal = 0;
        itemsBody.querySelectorAll('tr').forEach(row => {
            const lineTotal = parseFloat(row.querySelector('.total_price')?.value) || 0;
            grandTotal += lineTotal;
        });

        const displayEl = document.getElementById('createGrandTotalDisplay');
        if (displayEl) displayEl.textContent = '$' + grandTotal.toFixed(2);
    }

    function attachItemCalculationListeners() {
        document.querySelectorAll('#itemsBody .qty, #itemsBody .unit_price').forEach(input => {
            input.removeEventListener('input', onQtyOrPriceChange);
            input.addEventListener('input', onQtyOrPriceChange);
        });
    }

    function onQtyOrPriceChange(e) {
        const row = e.target.closest('tr');
        if (row) {
            calculateRowTotal(row);
            recalculateCreateGrandTotal();
        }
    }

    attachItemCalculationListeners();

    // ══════════════════════════════════════════════════════════════════
    // Dynamic Items Repeater - EDIT MODAL
    // ══════════════════════════════════════════════════════════════════
    const addEditItemBtn = document.getElementById('addEditItem');
    const editItemsBody = document.getElementById('editItemsBody');

    if (addEditItemBtn && editItemsBody) {
        addEditItemBtn.addEventListener('click', function () {
            const currentItemCount = editItemsBody.querySelectorAll('tr').length;
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input type="hidden" name="items[${currentItemCount}][id]" value="">
                    <input type="text" name="items[${currentItemCount}][description]" class="form-control" placeholder="{{ __('e.g. Item description') }}" required></td>
                <td><input type="number" name="items[${currentItemCount}][qty]" class="form-control edit-qty" value="1" min="1" required></td>
                <td><input type="text" name="items[${currentItemCount}][unit]" class="form-control" placeholder="{{ __('e.g. pcs') }}"></td>
                <td><input type="number" step="0.01" name="items[${currentItemCount}][unit_price]" class="form-control edit-unit-price" placeholder="0.00" min="0" required></td>
                <td><input type="number" step="0.01" name="items[${currentItemCount}][total_price]" class="form-control edit-total-price font-weight-bold bg-light" value="0.00" readonly></td>
                <td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger removeEditItem"><i class="fas fa-trash-alt"></i></button></td>
            `;
            editItemsBody.appendChild(newRow);
            attachEditItemCalculationListeners();
        });

        editItemsBody.addEventListener('click', function (e) {
            const removeBtn = e.target.closest('.removeEditItem');
            if (removeBtn) {
                removeBtn.closest('tr').remove();
                recalculateEditGrandTotal();
            }
        });
    }

    function calculateEditRowTotal(row) {
        const qty = parseFloat(row.querySelector('.edit-qty')?.value) || 0;
        const unitPrice = parseFloat(row.querySelector('.edit-unit-price')?.value) || 0;
        const totalPriceField = row.querySelector('.edit-total-price');
        if (totalPriceField) {
            totalPriceField.value = (qty * unitPrice).toFixed(2);
        }
    }

    function recalculateEditGrandTotal() {
        let grandTotal = 0;
        editItemsBody.querySelectorAll('tr').forEach(row => {
            const lineTotal = parseFloat(row.querySelector('.edit-total-price')?.value) || 0;
            grandTotal += lineTotal;
        });

        const displayEl = document.getElementById('editGrandTotalDisplay');
        if (displayEl) displayEl.textContent = '$' + grandTotal.toFixed(2);
    }

    function attachEditItemCalculationListeners() {
        document.querySelectorAll('#editItemsBody .edit-qty, #editItemsBody .edit-unit-price').forEach(input => {
            input.removeEventListener('input', onEditQtyOrPriceChange);
            input.addEventListener('input', onEditQtyOrPriceChange);
        });
    }

    function onEditQtyOrPriceChange(e) {
        const row = e.target.closest('tr');
        if (row) {
            calculateEditRowTotal(row);
            recalculateEditGrandTotal();
        }
    }

    // ══════════════════════════════════════════════════════════════════
    // Fetch & Open Edit Modal
    // ══════════════════════════════════════════════════════════════════
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');

            document.getElementById('edit_id').value = id;
            document.getElementById('edit_requisitioner').value = this.getAttribute('data-requisitioner');
            document.getElementById('edit_department').value = this.getAttribute('data-department');
            document.getElementById('edit_purpose').value = this.getAttribute('data-purpose');
            document.getElementById('edit_vendor').value = this.getAttribute('data-vendor');
            document.getElementById('edit_date_prepared').value = this.getAttribute('data-date_prepared');
            document.getElementById('edit_date_needed').value = this.getAttribute('data-date_needed');

            document.getElementById('editForm').action = `/purchase-req/${id}`;

            Swal.fire({
                title: '{{ __("Loading Purchase Items") }}...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            fetch(`/purchase-requests/${id}/items`)
                .then(response => response.json())
                .then(data => {
                    Swal.close();
                    editItemsBody.innerHTML = '';

                    (data || []).forEach((item, index) => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td><input type="hidden" name="items[${index}][id]" value="${item.id}">
                                <input type="text" name="items[${index}][description]" class="form-control" value="${item.description}" required></td>
                            <td><input type="number" name="items[${index}][qty]" class="form-control edit-qty" value="${item.qty}" min="1" required></td>
                            <td><input type="text" name="items[${index}][unit]" class="form-control" value="${item.unit || ''}"></td>
                            <td><input type="number" step="0.01" name="items[${index}][unit_price]" class="form-control edit-unit-price" value="${item.unit_price}" min="0" required></td>
                            <td><input type="number" step="0.01" name="items[${index}][total_price]" class="form-control edit-total-price font-weight-bold bg-light" value="${item.total_price || 0}" readonly></td>
                            <td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger removeEditItem"><i class="fas fa-trash-alt"></i></button></td>
                        `;
                        editItemsBody.appendChild(tr);
                    });

                    attachEditItemCalculationListeners();
                    recalculateEditGrandTotal();

                    $('#editPurchaseRequestModal').modal('show');
                })
                .catch(err => {
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __("Error") }}',
                        text: '{{ __("Failed to load purchase request items.") }}'
                    });
                });
        });
    });

    // ══════════════════════════════════════════════════════════════════
    // Quick Approve & Reject with SweetAlert2
    // ══════════════════════════════════════════════════════════════════
    document.querySelectorAll('.approve-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.getAttribute('data-id');

            Swal.fire({
                title: '{{ __("Approve Purchase Request?") }}',
                text: '{{ __("Are you sure you want to approve this purchase request?") }}',
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

                    fetch(`/purchase-req/${id}/approve`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        Swal.fire({
                            icon: 'success',
                            title: '{{ __("Approved!") }}',
                            text: data.success || '{{ __("Purchase request approved successfully.") }}',
                            confirmButtonText: '{{ __("OK") }}'
                        }).then(() => location.reload());
                    })
                    .catch(err => {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __("Error") }}',
                            text: '{{ __("Failed to approve purchase request.") }}'
                        });
                    });
                }
            });
        });
    });

    document.querySelectorAll('.reject-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.getAttribute('data-id');

            Swal.fire({
                title: '{{ __("Reject Purchase Request?") }}',
                text: '{{ __("Are you sure you want to reject this purchase request?") }}',
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

                    fetch(`/purchase-req/${id}/reject`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        Swal.fire({
                            icon: 'success',
                            title: '{{ __("Rejected") }}',
                            text: data.success || '{{ __("Purchase request has been rejected.") }}',
                            confirmButtonText: '{{ __("OK") }}'
                        }).then(() => location.reload());
                    })
                    .catch(err => {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __("Error") }}',
                            text: '{{ __("Failed to reject purchase request.") }}'
                        });
                    });
                }
            });
        });
    });

    // ══════════════════════════════════════════════════════════════════
    // Delete Confirmation with SweetAlert2
    // ══════════════════════════════════════════════════════════════════
    document.querySelectorAll('.delete-pr-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: '{{ __("Delete Purchase Request?") }}',
                text: '{{ __("Are you sure you want to permanently delete this purchase request?") }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: '{{ __("Yes, Delete") }}',
                cancelButtonText: '{{ __("Cancel") }}'
            }).then((res) => {
                if (res.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>

@endsection
