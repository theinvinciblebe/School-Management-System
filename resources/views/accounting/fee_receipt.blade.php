@extends('layout.main')

@section('title', __('Fee Receipts & Student Billing'))

@section('content')

<style>
/* ══════════════════════════════════════════════════════════════════
   FEE RECEIPT MANAGEMENT – Executive SaaS Design System
══════════════════════════════════════════════════════════════════ */
.acc-fee-wrapper {
    padding: 0.5rem 0.25rem 2.5rem;
}

/* Header Box */
.acc-fee-header {
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
.acc-fee-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 5px;
    height: 100%;
    background: linear-gradient(180deg, #3b82f6, #10b981);
}
html.dark-mode .acc-fee-header {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 24px -2px rgba(0, 0, 0, 0.35);
}

.acc-fee-title {
    font-size: 1.35rem;
    font-weight: 800;
    margin-bottom: 0.2rem;
    display: flex;
    align-items: center;
    gap: 0.65rem;
    color: #1e293b;
}
html.dark-mode .acc-fee-title {
    color: #f8fafc;
}

.acc-fee-subtitle {
    font-size: 0.85rem;
    color: #64748b;
    margin: 0;
}
html.dark-mode .acc-fee-subtitle {
    color: #94a3b8;
}

.acc-fee-actions {
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
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
}
.btn-acc-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
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
.acc-fee-kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem;
    margin-bottom: 1.25rem;
}

.acc-fee-kpi-card {
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
.acc-fee-kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
}
html.dark-mode .acc-fee-kpi-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.25);
}

.acc-fee-kpi-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}
.kpi-blue   { background: rgba(59, 130, 246, 0.12); color: #3b82f6; }
.kpi-green  { background: rgba(16, 185, 129, 0.12); color: #10b981; }
.kpi-amber  { background: rgba(245, 158, 11, 0.12); color: #f59e0b; }
.kpi-purple { background: rgba(139, 92, 246, 0.12); color: #8b5cf6; }

.acc-fee-kpi-value {
    font-size: 1.55rem;
    font-weight: 800;
    line-height: 1.1;
    color: #0f172a;
}
html.dark-mode .acc-fee-kpi-value {
    color: #f8fafc;
}
.acc-fee-kpi-label {
    font-size: 0.78rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: #64748b;
    margin-top: 0.15rem;
}
html.dark-mode .acc-fee-kpi-label {
    color: #94a3b8;
}

/* Main Table Card */
.acc-fee-main-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.04);
}
html.dark-mode .acc-fee-main-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 24px -2px rgba(0, 0, 0, 0.35);
}

.acc-fee-toolbar {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.85rem;
    background: #f8fafc;
}
html.dark-mode .acc-fee-toolbar {
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
    color: #2563eb;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
}
html.dark-mode .acc-filter-pill {
    color: #94a3b8;
}
html.dark-mode .acc-filter-pill.active {
    background: #1e2235;
    color: #60a5fa;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
}
.acc-filter-count {
    font-size: 0.72rem;
    padding: 0.1rem 0.4rem;
    border-radius: 10px;
    background: rgba(100, 116, 139, 0.15);
}
.acc-filter-pill.active .acc-filter-count {
    background: rgba(37, 99, 235, 0.15);
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
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
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

/* Student Profile Pill & Badges */
.acc-student-avatar {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    color: #1e40af;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.85rem;
    flex-shrink: 0;
}
html.dark-mode .acc-student-avatar {
    background: linear-gradient(135deg, #1e3a8a, #2563eb);
    color: #bfdbfe;
}
.acc-student-name {
    font-weight: 700;
    color: #0f172a;
    font-size: 0.92rem;
    line-height: 1.2;
}
html.dark-mode .acc-student-name {
    color: #f8fafc;
}
.acc-badge-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.15rem 0.5rem;
    border-radius: 6px;
    font-size: 0.72rem;
    font-weight: 600;
}
.badge-gender-male {
    background: rgba(59, 130, 246, 0.1);
    color: #2563eb;
    border: 1px solid rgba(59, 130, 246, 0.2);
}
.badge-gender-female {
    background: rgba(244, 63, 94, 0.1);
    color: #e11d48;
    border: 1px solid rgba(244, 63, 94, 0.2);
}
.badge-roll {
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #e2e8f0;
}
html.dark-mode .badge-roll {
    background: #252a3d;
    color: #94a3b8;
    border-color: #3b4261;
}

.acc-receipt-no {
    font-family: monospace;
    font-weight: 700;
    font-size: 0.82rem;
    padding: 0.2rem 0.55rem;
    border-radius: 6px;
    background: #f1f5f9;
    color: #0f172a;
    border: 1px solid #e2e8f0;
}
html.dark-mode .acc-receipt-no {
    background: #252a3d;
    color: #60a5fa;
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

.acc-student-preview-card {
    background: #f8fafc;
    border: 1px dashed #cbd5e1;
    border-radius: 12px;
    padding: 1rem;
    margin-top: 0.75rem;
    margin-bottom: 1rem;
}
html.dark-mode .acc-student-preview-card {
    background: #252a3d;
    border-color: #3b4261;
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

.acc-summary-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    margin-top: 1rem;
}
html.dark-mode .acc-summary-box {
    background: #252a3d;
    border-color: #3b4261;
}
</style>

@php
    $totalCount = count($fees);
    $approvedCount = $fees->where('status', 'approved')->count();
    $pendingCount = $fees->where('status', 'pending')->count();
    $rejectedCount = $fees->where('status', 'rejected')->count();
    $totalCollected = $fees->where('status', 'approved')->sum('paid');
    $totalOutstanding = $fees->sum('remaining_balance');
@endphp

<div class="acc-fee-wrapper">
    <!-- Header Banner -->
    <div class="acc-fee-header">
        <div>
            <div class="acc-fee-title">
                <i class="fas fa-receipt text-primary"></i>
                {{ __('Fee Receipts & Student Billing') }}
            </div>
            <p class="acc-fee-subtitle">
                {{ __('Manage student tuition invoices, monitor settlement statuses, and maintain financial records.') }}
            </p>
        </div>

        <div class="acc-fee-actions">
            <a href="{{ route('accounting.index') }}" class="btn-acc btn-acc-secondary" title="{{ __('Back to Accounting Hub') }}">
                <i class="fas fa-arrow-left"></i>
                <span>{{ __('Accounting Hub') }}</span>
            </a>

            <button type="button" class="btn-acc btn-acc-primary" data-toggle="modal" data-target="#addFeeReceiptModal">
                <i class="fas fa-plus"></i>
                <span>{{ __('Make New Fee Receipt') }}</span>
            </button>
        </div>
    </div>

    <!-- Top KPI Metric Cards -->
    <div class="acc-fee-kpi-grid">
        <div class="acc-fee-kpi-card">
            <div class="acc-fee-kpi-icon kpi-blue">
                <i class="fas fa-file-invoice-dollar"></i>
            </div>
            <div>
                <div class="acc-fee-kpi-value">{{ $totalCount }}</div>
                <div class="acc-fee-kpi-label">{{ __('Total Receipts') }}</div>
            </div>
        </div>

        <div class="acc-fee-kpi-card">
            <div class="acc-fee-kpi-icon kpi-green">
                <i class="fas fa-hand-holding-usd"></i>
            </div>
            <div>
                <div class="acc-fee-kpi-value">${{ number_format($totalCollected, 2) }}</div>
                <div class="acc-fee-kpi-label">{{ __('Total Collected') }}</div>
            </div>
        </div>

        <div class="acc-fee-kpi-card">
            <div class="acc-fee-kpi-icon kpi-amber">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <div class="acc-fee-kpi-value">{{ $pendingCount }}</div>
                <div class="acc-fee-kpi-label">{{ __('Pending Approvals') }}</div>
            </div>
        </div>

        <div class="acc-fee-kpi-card">
            <div class="acc-fee-kpi-icon kpi-purple">
                <i class="fas fa-wallet"></i>
            </div>
            <div>
                <div class="acc-fee-kpi-value">${{ number_format($totalOutstanding, 2) }}</div>
                <div class="acc-fee-kpi-label">{{ __('Outstanding Balance') }}</div>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="acc-fee-main-card">
        <!-- Toolbar -->
        <div class="acc-fee-toolbar">
            <div class="acc-filter-tabs">
                <button type="button" class="acc-filter-pill active" data-filter="all">
                    <span>{{ __('All') }}</span>
                    <span class="acc-filter-count">{{ $totalCount }}</span>
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
                <input type="text" id="feeSearchInput" class="acc-search-input" placeholder="{{ __('Search student, receipt #, class, roll...') }}" autocomplete="off">
            </div>
        </div>

        <!-- Responsive Table -->
        <div class="table-responsive">
            <table class="table acc-table" id="feeMasterTable">
                <thead>
                    <tr>
                        <th style="width: 45px;">#</th>
                        <th>{{ __('Student Details') }}</th>
                        <th>{{ __('Class & Academic Program') }}</th>
                        <th>{{ __('Receipt Details') }}</th>
                        <th>{{ __('Financial Settlement') }}</th>
                        <th>{{ __('Approval Status') }}</th>
                        <th style="width: 140px;" class="text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody id="feeTableBody">
                    @forelse ($fees as $index => $item)
                        @php
                            $searchBlob = strtolower(implode(' ', [
                                $item->student_name ?? '',
                                $item->receipt_no ?? '',
                                $item->class_name ?? '',
                                $item->section_name ?? '',
                                $item->roll ?? '',
                                $item->paid_via ?? '',
                                $item->status ?? '',
                            ]));
                        @endphp
                        <tr class="fee-row"
                            data-search="{{ $searchBlob }}"
                            data-status="{{ $item->status ?? 'pending' }}"
                            data-payment="{{ $item->paid_via ?? '' }}">
                            <td class="text-muted font-weight-bold" style="font-size: 0.8rem;">
                                {{ $index + 1 }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="acc-student-avatar mr-2.5">
                                        {{ strtoupper(mb_substr($item->student_name ?? 'S', 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="acc-student-name">{{ $item->student_name }}</div>
                                        <div class="mt-1 d-flex align-items-center" style="gap: 0.35rem;">
                                            <span class="acc-badge-pill badge-roll" title="{{ __('Roll No') }}">
                                                #{{ $item->roll }}
                                            </span>
                                            @if($item->sex)
                                                <span class="acc-badge-pill badge-gender-male">
                                                    <i class="fas fa-mars mr-1"></i>{{ __('Male') }}
                                                </span>
                                            @else
                                                <span class="acc-badge-pill badge-gender-female">
                                                    <i class="fas fa-venus mr-1"></i>{{ __('Female') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="font-weight-bold text-dark mb-0.5">
                                    {{ $item->class_name ?? 'N/A' }}
                                </div>
                                <div class="text-muted small">
                                    <span class="mr-2"><i class="fas fa-layer-group mr-1 text-primary"></i>{{ $item->section_name ?? 'N/A' }}</span>
                                    <span><i class="far fa-clock mr-1 text-secondary"></i>{{ $item->section_duration_months ?? 'N/A' }} {{ __('Months') }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="mb-1">
                                    <span class="acc-receipt-no">
                                        <i class="fas fa-receipt mr-1 text-primary"></i>{{ $item->receipt_no }}
                                    </span>
                                </div>
                                <div class="text-muted small d-flex align-items-center" style="gap: 0.5rem;">
                                    <span><i class="far fa-calendar-alt mr-1"></i>{{ $item->receipt_date }}</span>
                                    @if($item->paid_via === 'Cash')
                                        <span class="badge badge-light border text-success"><i class="fas fa-money-bill-wave mr-1"></i>{{ __('Cash') }}</span>
                                    @elseif($item->paid_via === 'Bank Transfer')
                                        <span class="badge badge-light border text-info"><i class="fas fa-university mr-1"></i>{{ __('Bank Transfer') }}</span>
                                    @else
                                        <span class="badge badge-light border text-secondary">{{ $item->paid_via ?? __('N/A') }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="font-weight-bold text-success" style="font-size: 0.95rem;">
                                    ${{ number_format($item->paid ?? 0, 2) }}
                                </div>
                                <div class="text-muted small" style="font-size: 0.75rem;">
                                    {{ __('Balance:') }} ${{ number_format($item->remaining_balance ?? 0, 2) }}
                                </div>
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
                                        <button type="button" class="btn-action-icon btn-action-approve approve-btn" data-id="{{ $item->receipt_id }}" title="{{ __('Approve Receipt') }}">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button type="button" class="btn-action-icon btn-action-reject reject-btn" data-id="{{ $item->receipt_id }}" title="{{ __('Reject Receipt') }}">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif

                                    @if (Auth::user()->role == 0 || ((Auth::user()->role == 3 || Auth::user()->role == 4) && $item->status == 'approved'))
                                        <a href="{{ route('fee_receipt.show', $item->receipt_id) }}" class="btn-action-icon btn-action-view" title="{{ __('View Invoice') }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('fee_receipt.pdf', $item->receipt_id) }}" target="_blank" class="btn-action-icon" title="{{ __('Download PDF') }}">
                                            <i class="fas fa-file-pdf text-danger"></i>
                                        </a>
                                    @endif

                                    @if(Auth::user()->role != 4)
                                        <button type="button" class="btn-action-icon btn-action-edit edit-btn"
                                                data-id="{{ $item->receipt_id }}"
                                                data-student-id="{{ $item->student_class_id }}"
                                                data-name="{{ $item->student_name }}"
                                                data-sex="{{ $item->sex }}"
                                                data-roll="{{ $item->roll }}"
                                                data-receipt-no="{{ $item->receipt_no }}"
                                                data-class="{{ $item->class_name }}"
                                                data-section="{{ $item->section_name }}"
                                                data-duration="{{ $item->section_duration_months }}"
                                                data-receipt-date="{{ $item->receipt_date }}"
                                                data-start-date="{{ $item->start_date }}"
                                                title="{{ __('Edit Receipt') }}">
                                            <i class="fas fa-pen"></i>
                                        </button>

                                        <form action="{{ route('fee_receipt.destroy', $item->receipt_id) }}" method="POST" class="d-inline delete-fee-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action-icon btn-action-delete" title="{{ __('Delete Receipt') }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fas fa-receipt fa-3x mb-3 text-secondary opacity-50 d-block"></i>
                                <h6>{{ __('No fee receipts found') }}</h6>
                                <p class="small text-muted mb-0">{{ __('Create a new fee receipt by clicking the button above.') }}</p>
                            </td>
                        </tr>
                    @endforelse
                    <tr id="noResultsRow" style="display: none;">
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-search fa-2x mb-2 text-secondary opacity-50 d-block"></i>
                            <h6>{{ __('No matching receipts found') }}</h6>
                            <p class="small text-muted mb-0">{{ __('Try adjusting your search query or filters.') }}</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- =====================================================================
     CREATE NEW FEE RECEIPT MODAL
===================================================================== -->
<div class="modal fade acc-modal" id="addFeeReceiptModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="addModalLabel">
                    <i class="fas fa-plus-circle text-primary mr-1.5"></i>
                    {{ __('Create New Fee Receipt') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('fee_receipt.store') }}" method="POST" id="createFeeForm">
                @csrf
                <div class="modal-body p-4">
                    <!-- Hidden Receipt No (Auto-generated) -->
                    <input type="hidden" name="receipt_no" id="receipt_no" value="{{ 'REC-' . substr(uniqid(), -6) }}">

                    <!-- Hidden Fields to Store Student Data -->
                    <input type="hidden" id="student_name">
                    <input type="hidden" id="student_sex">
                    <input type="hidden" id="student_roll">
                    <input type="hidden" id="student_class">
                    <input type="hidden" id="student_section">
                    <input type="hidden" id="student_section_duration">

                    <div class="row">
                        <!-- Select Student -->
                        <div class="col-md-6 mb-3">
                            <label for="student_class_id" class="font-weight-bold text-sm">
                                {{ __('Select Student') }} <span class="text-danger">*</span>
                            </label>
                            <select name="student_class_id" id="student_class_id" class="form-control select2bs4" required>
                                <option value="">{{ __('-- Choose Student --') }}</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->student_class_id }}">
                                        {{ $student->student_name }} ({{ __('Roll:') }} {{ $student->roll }}, {{ $student->class_name ?? '' }} - {{ $student->section_name ?? '' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Receipt Date -->
                        <div class="col-md-3 mb-3">
                            <label for="date" class="font-weight-bold text-sm">
                                {{ __('Receipt Date') }} <span class="text-danger">*</span>
                            </label>
                            <input type="date" class="form-control" name="date" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <!-- Paid Via -->
                        <div class="col-md-3 mb-3">
                            <label for="paid_via" class="font-weight-bold text-sm">
                                {{ __('Paid Via') }} <span class="text-danger">*</span>
                            </label>
                            <select class="form-control" name="paid_via" id="paid_via" required>
                                <option value="Cash">{{ __('Cash') }}</option>
                                <option value="Bank Transfer">{{ __('Bank Transfer') }}</option>
                            </select>
                        </div>
                    </div>

                    <!-- Student Details Preview Card -->
                    <div id="studentPreviewCard" class="acc-student-preview-card" style="display: none;">
                        <div class="row">
                            <div class="col-md-2 col-6 mb-2">
                                <span class="text-muted small d-block">{{ __('Gender') }}</span>
                                <input type="text" id="display_sex" class="form-control form-control-sm font-weight-bold bg-white" readonly>
                            </div>
                            <div class="col-md-2 col-6 mb-2">
                                <span class="text-muted small d-block">{{ __('Roll Number') }}</span>
                                <input type="text" id="display_roll" class="form-control form-control-sm font-weight-bold bg-white" readonly>
                            </div>
                            <div class="col-md-2 col-6 mb-2">
                                <span class="text-muted small d-block">{{ __('Class') }}</span>
                                <input type="text" id="display_class" class="form-control form-control-sm font-weight-bold bg-white" readonly>
                            </div>
                            <div class="col-md-2 col-6 mb-2">
                                <span class="text-muted small d-block">{{ __('Section') }}</span>
                                <input type="text" id="display_section" class="form-control form-control-sm font-weight-bold bg-white" readonly>
                            </div>
                            <div class="col-md-2 col-6 mb-2">
                                <span class="text-muted small d-block">{{ __('Section Duration') }}</span>
                                <input type="text" id="display_section_duration" class="form-control form-control-sm font-weight-bold bg-white" readonly>
                            </div>
                            <div class="col-md-2 col-6 mb-2">
                                <span class="text-muted small d-block">{{ __('Previous Balance') }}</span>
                                <input type="number" step="0.01" class="form-control form-control-sm font-weight-bold bg-white text-danger" name="previous_balance" id="previous_balance" value="0.00" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h6 class="font-weight-bold text-dark mb-0">
                            <i class="fas fa-list-ol mr-1 text-primary"></i> {{ __('Invoice Line Items') }}
                        </h6>
                        <button type="button" class="btn btn-sm btn-outline-success font-weight-bold" id="addFeeItem">
                            <i class="fas fa-plus mr-1"></i> {{ __('Add Line Item') }}
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table acc-items-table" id="feeItemsTable">
                            <thead>
                                <tr>
                                    <th style="min-width: 220px;">{{ __('Description') }} <span class="text-danger">*</span></th>
                                    <th style="width: 100px;">{{ __('Qty') }} <span class="text-danger">*</span></th>
                                    <th style="width: 130px;">{{ __('Unit Price ($)') }} <span class="text-danger">*</span></th>
                                    <th style="width: 120px;">{{ __('Discount') }}</th>
                                    <th style="width: 120px;">{{ __('Duration') }}</th>
                                    <th style="width: 130px;">{{ __('Line Total ($)') }}</th>
                                    <th style="width: 60px;" class="text-center">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody id="feeItemsBody">
                                <tr>
                                    <td>
                                        <input type="text" name="items[0][description]" class="form-control" placeholder="{{ __('e.g. Tuition Fee Term 1') }}" required>
                                    </td>
                                    <td>
                                        <input type="number" name="items[0][qty]" class="form-control qty" value="1" min="1" required>
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" name="items[0][price]" class="form-control price" placeholder="0.00" min="0" required>
                                    </td>
                                    <td>
                                        <input type="text" name="items[0][discount]" class="form-control" placeholder="0%">
                                    </td>
                                    <td>
                                        <input type="text" name="items[0][duration]" class="form-control" placeholder="{{ __('e.g. 1 Month') }}">
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" name="items[0][total]" class="form-control total font-weight-bold bg-light" value="0.00" readonly>
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

                    <!-- Financial Summary & Settlement Box -->
                    <div class="acc-summary-box">
                        <div class="row align-items-center">
                            <div class="col-md-3 mb-2 mb-md-0">
                                <span class="text-muted small d-block">{{ __('Line Items Subtotal') }}</span>
                                <h5 class="font-weight-bold text-dark mb-0" id="createItemsSubtotal">$0.00</h5>
                            </div>
                            <div class="col-md-3 mb-2 mb-md-0">
                                <span class="text-muted small d-block">{{ __('Previous Balance') }}</span>
                                <h5 class="font-weight-bold text-secondary mb-0" id="createPrevBalanceDisplay">$0.00</h5>
                            </div>
                            <div class="col-md-3 mb-2 mb-md-0">
                                <label for="paid_amount_input" class="text-muted small d-block mb-1 font-weight-bold">
                                    {{ __('Paid Amount ($)') }} <span class="text-danger">*</span>
                                </label>
                                <input type="number" step="0.01" min="0" name="paid" id="paid_amount_input" class="form-control font-weight-bold text-success" placeholder="0.00" required>
                            </div>
                            <div class="col-md-3">
                                <span class="text-muted small d-block">{{ __('Net Remaining Balance') }}</span>
                                <h5 class="font-weight-bold text-primary mb-0" id="createRemainingBalanceDisplay">$0.00</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">
                        {{ __('Close') }}
                    </button>
                    <button type="submit" class="btn btn-primary font-weight-bold">
                        <i class="fas fa-save mr-1"></i> {{ __('Save Receipt') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- =====================================================================
     EDIT FEE RECEIPT MODAL
===================================================================== -->
<div class="modal fade acc-modal" id="editFeeModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="editModalLabel">
                    <i class="fas fa-edit text-warning mr-1.5"></i>
                    {{ __('Edit Fee Receipt') }}
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
                        <!-- Select Student -->
                        <div class="col-md-6 mb-3">
                            <label for="edit_student_class_id" class="font-weight-bold text-sm">
                                {{ __('Select Student') }} <span class="text-danger">*</span>
                            </label>
                            <select name="student_class_id" id="edit_student_class_id" class="form-control" required>
                                <option value="" disabled>{{ __('-- Choose Student --') }}</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->student_class_id }}">
                                        {{ $student->student_name }} ({{ __('Roll:') }} {{ $student->roll }}, {{ $student->class_name ?? '' }} - {{ $student->section_name ?? '' }})
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" id="edit_student_name">
                        </div>

                        <!-- Receipt Date -->
                        <div class="col-md-3 mb-3">
                            <label for="edit_receipt_date" class="font-weight-bold text-sm">
                                {{ __('Receipt Date') }} <span class="text-danger">*</span>
                            </label>
                            <input type="date" id="edit_receipt_date" class="form-control" name="date" required>
                        </div>

                        <!-- Paid Via -->
                        <div class="col-md-3 mb-3">
                            <label for="edit_paid_via" class="font-weight-bold text-sm">
                                {{ __('Paid Via') }} <span class="text-danger">*</span>
                            </label>
                            <select class="form-control" id="edit_paid_via" name="paid_via" required>
                                <option value="Cash">{{ __('Cash') }}</option>
                                <option value="Bank Transfer">{{ __('Bank Transfer') }}</option>
                            </select>
                        </div>
                    </div>

                    <!-- Student Metadata Box -->
                    <div class="acc-student-preview-card">
                        <div class="row">
                            <div class="col-md-2 col-6 mb-2">
                                <span class="text-muted small d-block">{{ __('Gender') }}</span>
                                <input type="text" id="edit_sex" class="form-control form-control-sm font-weight-bold bg-white" readonly>
                            </div>
                            <div class="col-md-2 col-6 mb-2">
                                <span class="text-muted small d-block">{{ __('Receipt No') }}</span>
                                <input type="text" id="edit_receipt_no" class="form-control form-control-sm font-weight-bold bg-white" readonly>
                            </div>
                            <div class="col-md-2 col-6 mb-2">
                                <span class="text-muted small d-block">{{ __('Roll No') }}</span>
                                <input type="text" id="edit_roll" class="form-control form-control-sm font-weight-bold bg-white" readonly>
                            </div>
                            <div class="col-md-2 col-6 mb-2">
                                <span class="text-muted small d-block">{{ __('Class') }}</span>
                                <input type="text" id="edit_class" class="form-control form-control-sm font-weight-bold bg-white" readonly>
                            </div>
                            <div class="col-md-2 col-6 mb-2">
                                <span class="text-muted small d-block">{{ __('Section') }}</span>
                                <input type="text" id="edit_section" class="form-control form-control-sm font-weight-bold bg-white" readonly>
                            </div>
                            <div class="col-md-2 col-6 mb-2">
                                <span class="text-muted small d-block">{{ __('Duration') }}</span>
                                <input type="text" id="edit_section_duration" class="form-control form-control-sm font-weight-bold bg-white" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h6 class="font-weight-bold text-dark mb-0">
                            <i class="fas fa-list-ol mr-1 text-warning"></i> {{ __('Invoice Line Items') }}
                        </h6>
                        <button type="button" class="btn btn-sm btn-outline-success font-weight-bold" id="addEditItem">
                            <i class="fas fa-plus mr-1"></i> {{ __('Add Line Item') }}
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table acc-items-table" id="editItemsTable">
                            <thead>
                                <tr>
                                    <th style="min-width: 220px;">{{ __('Description') }} <span class="text-danger">*</span></th>
                                    <th style="width: 100px;">{{ __('Qty') }} <span class="text-danger">*</span></th>
                                    <th style="width: 130px;">{{ __('Unit Price ($)') }} <span class="text-danger">*</span></th>
                                    <th style="width: 120px;">{{ __('Discount') }}</th>
                                    <th style="width: 120px;">{{ __('Duration') }}</th>
                                    <th style="width: 130px;">{{ __('Line Total ($)') }}</th>
                                    <th style="width: 60px;" class="text-center">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody id="editItemsBody">
                            </tbody>
                        </table>
                    </div>

                    <!-- Financial Balances in Edit -->
                    <div class="acc-summary-box">
                        <div class="row align-items-center">
                            <div class="col-md-3 mb-2 mb-md-0">
                                <span class="text-muted small d-block">{{ __('Line Items Subtotal') }}</span>
                                <h5 class="font-weight-bold text-dark mb-0" id="editItemsSubtotal">$0.00</h5>
                            </div>
                            <div class="col-md-3 mb-2 mb-md-0">
                                <span class="text-muted small d-block">{{ __('Previous Balance') }}</span>
                                <input type="number" step="0.01" id="edit_previous_balance" name="previous_balance" class="form-control form-control-sm font-weight-bold" readonly>
                            </div>
                            <div class="col-md-3 mb-2 mb-md-0">
                                <label for="edit_paid" class="text-muted small d-block mb-1 font-weight-bold">
                                    {{ __('Paid Amount ($)') }}
                                </label>
                                <input type="number" step="0.01" id="edit_paid" name="paid" class="form-control font-weight-bold text-success" required>
                            </div>
                            <div class="col-md-3">
                                <span class="text-muted small d-block">{{ __('Remaining Balance') }}</span>
                                <input type="number" step="0.01" id="edit_remaining_balance" name="remaining_balance" class="form-control form-control-sm font-weight-bold text-primary" readonly>
                            </div>
                        </div>
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
    const searchInput = document.getElementById('feeSearchInput');
    const filterPills = document.querySelectorAll('.acc-filter-pill');
    const tableRows = document.querySelectorAll('.fee-row');
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
    // Student Selection in Create Modal
    // ══════════════════════════════════════════════════════════════════
    const studentSelect = document.getElementById('student_class_id');
    const previewCard = document.getElementById('studentPreviewCard');

    if (studentSelect) {
        studentSelect.addEventListener('change', function () {
            const studentId = this.value;
            if (studentId) {
                fetch(`/get-student-details/${studentId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('student_sex').value = data.sex;
                        document.getElementById('student_roll').value = data.roll;
                        document.getElementById('student_class').value = data.class_name;
                        document.getElementById('student_section').value = data.section_name;
                        document.getElementById('student_section_duration').value = data.section_duration_months;

                        document.getElementById('display_sex').value = data.sex === 1 ? '{{ __("Male") }}' : '{{ __("Female") }}';
                        document.getElementById('display_roll').value = data.roll;
                        document.getElementById('display_class').value = data.class_name || 'N/A';
                        document.getElementById('display_section').value = data.section_name || 'N/A';
                        document.getElementById('display_section_duration').value = (data.section_duration_months || 0) + ' {{ __("Months") }}';

                        const prevBalance = parseFloat(data.previous_balance || 0);
                        document.getElementById("previous_balance").value = prevBalance.toFixed(2);
                        document.getElementById("createPrevBalanceDisplay").textContent = '$' + prevBalance.toFixed(2);

                        if (previewCard) previewCard.style.display = 'block';
                        recalculateCreateGrandTotal();
                    })
                    .catch(err => {
                        console.error('Error fetching student details:', err);
                    });
            } else {
                if (previewCard) previewCard.style.display = 'none';
                document.getElementById("previous_balance").value = '0.00';
                document.getElementById("createPrevBalanceDisplay").textContent = '$0.00';
                recalculateCreateGrandTotal();
            }
        });
    }

    // ══════════════════════════════════════════════════════════════════
    // Dynamic Items Repeater - CREATE MODAL
    // ══════════════════════════════════════════════════════════════════
    let feeItemCount = 1;
    const addFeeItemBtn = document.getElementById('addFeeItem');
    const feeItemsBody = document.getElementById('feeItemsBody');

    if (addFeeItemBtn && feeItemsBody) {
        addFeeItemBtn.addEventListener('click', function () {
            const newRow = `
                <tr>
                    <td><input type="text" name="items[${feeItemCount}][description]" class="form-control" placeholder="{{ __('e.g. Activity / Exam Fee') }}" required></td>
                    <td><input type="number" name="items[${feeItemCount}][qty]" class="form-control qty" value="1" min="1" required></td>
                    <td><input type="number" step="0.01" name="items[${feeItemCount}][price]" class="form-control price" placeholder="0.00" min="0" required></td>
                    <td><input type="text" name="items[${feeItemCount}][discount]" class="form-control" placeholder="0%"></td>
                    <td><input type="text" name="items[${feeItemCount}][duration]" class="form-control" placeholder="{{ __('e.g. 1 Month') }}"></td>
                    <td><input type="number" step="0.01" name="items[${feeItemCount}][total]" class="form-control total font-weight-bold bg-light" value="0.00" readonly></td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-danger removeItem" title="{{ __('Remove Item') }}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
            `;
            feeItemsBody.insertAdjacentHTML('beforeend', newRow);
            feeItemCount++;
            attachItemCalculationListeners();
        });

        feeItemsBody.addEventListener('click', function (e) {
            const removeBtn = e.target.closest('.removeItem');
            if (removeBtn) {
                const tr = removeBtn.closest('tr');
                if (feeItemsBody.querySelectorAll('tr').length > 1) {
                    tr.remove();
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: '{{ __("Line Item Required") }}',
                        text: '{{ __("A fee receipt must contain at least one line item.") }}',
                        confirmButtonText: '{{ __("OK") }}'
                    });
                }
                recalculateCreateGrandTotal();
            }
        });
    }

    function calculateRowTotal(row) {
        const qty = parseFloat(row.querySelector('.qty')?.value) || 0;
        const price = parseFloat(row.querySelector('.price')?.value) || 0;
        const totalField = row.querySelector('.total');
        if (totalField) {
            totalField.value = (qty * price).toFixed(2);
        }
    }

    function recalculateCreateGrandTotal() {
        let subtotal = 0;
        feeItemsBody.querySelectorAll('tr').forEach(row => {
            const lineTotal = parseFloat(row.querySelector('.total')?.value) || 0;
            subtotal += lineTotal;
        });

        const subtotalEl = document.getElementById('createItemsSubtotal');
        if (subtotalEl) subtotalEl.textContent = '$' + subtotal.toFixed(2);

        const prevBalance = parseFloat(document.getElementById('previous_balance')?.value) || 0;
        const paidInput = document.getElementById('paid_amount_input');
        const paid = parseFloat(paidInput?.value) || 0;

        const remaining = (subtotal + prevBalance) - paid;
        const remainingEl = document.getElementById('createRemainingBalanceDisplay');
        if (remainingEl) remainingEl.textContent = '$' + remaining.toFixed(2);
    }

    function attachItemCalculationListeners() {
        document.querySelectorAll('#feeItemsBody .qty, #feeItemsBody .price').forEach(input => {
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

    const paidAmountInput = document.getElementById('paid_amount_input');
    if (paidAmountInput) {
        paidAmountInput.addEventListener('input', recalculateCreateGrandTotal);
    }

    // ══════════════════════════════════════════════════════════════════
    // EDIT MODAL: Dynamic Items & AJAX Populate
    // ══════════════════════════════════════════════════════════════════
    const editStudentSelect = document.getElementById('edit_student_class_id');
    if (editStudentSelect) {
        editStudentSelect.addEventListener('change', function () {
            const studentId = this.value;
            if (studentId) {
                fetch(`/get-student-details/${studentId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('edit_student_name').value = data.student_name;
                        document.getElementById('edit_roll').value = data.roll;
                        document.getElementById('edit_class').value = data.class_name;
                        document.getElementById('edit_section').value = data.section_name;
                        document.getElementById('edit_section_duration').value = data.section_duration_months + " {{ __('Months') }}";
                        document.getElementById('edit_sex').value = data.sex === 1 ? '{{ __("Male") }}' : '{{ __("Female") }}';
                    })
                    .catch(err => console.error('Error fetching student details:', err));
            }
        });
    }

    const addEditItemBtn = document.getElementById('addEditItem');
    const editItemsBody = document.getElementById('editItemsBody');

    if (addEditItemBtn && editItemsBody) {
        addEditItemBtn.addEventListener('click', function () {
            const currentItemCount = editItemsBody.querySelectorAll('tr').length;
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input type="hidden" name="items[${currentItemCount}][id]" value="">
                    <input type="text" name="items[${currentItemCount}][description]" class="form-control" placeholder="{{ __('e.g. Line item description') }}" required></td>
                <td><input type="number" name="items[${currentItemCount}][qty]" class="form-control edit-qty" value="1" min="1" required></td>
                <td><input type="number" step="0.01" name="items[${currentItemCount}][price]" class="form-control edit-price" placeholder="0.00" min="0" required></td>
                <td><input type="text" name="items[${currentItemCount}][discount]" class="form-control"></td>
                <td><input type="text" name="items[${currentItemCount}][duration]" class="form-control"></td>
                <td><input type="number" step="0.01" name="items[${currentItemCount}][total]" class="form-control edit-total font-weight-bold bg-light" value="0.00" readonly></td>
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
        const price = parseFloat(row.querySelector('.edit-price')?.value) || 0;
        const totalField = row.querySelector('.edit-total');
        if (totalField) {
            totalField.value = (qty * price).toFixed(2);
        }
    }

    function recalculateEditGrandTotal() {
        let subtotal = 0;
        editItemsBody.querySelectorAll('tr').forEach(row => {
            const lineTotal = parseFloat(row.querySelector('.edit-total')?.value) || 0;
            subtotal += lineTotal;
        });

        const subtotalEl = document.getElementById('editItemsSubtotal');
        if (subtotalEl) subtotalEl.textContent = '$' + subtotal.toFixed(2);

        const prevBalance = parseFloat(document.getElementById('edit_previous_balance')?.value) || 0;
        const paid = parseFloat(document.getElementById('edit_paid')?.value) || 0;

        const remaining = (subtotal + prevBalance) - paid;
        const remainingField = document.getElementById('edit_remaining_balance');
        if (remainingField) remainingField.value = remaining.toFixed(2);
    }

    function attachEditItemCalculationListeners() {
        document.querySelectorAll('#editItemsBody .edit-qty, #editItemsBody .edit-price').forEach(input => {
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

    const editPaidInput = document.getElementById('edit_paid');
    if (editPaidInput) {
        editPaidInput.addEventListener('input', recalculateEditGrandTotal);
    }

    // ══════════════════════════════════════════════════════════════════
    // Fetch & Open Edit Modal
    // ══════════════════════════════════════════════════════════════════
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');

            Swal.fire({
                title: '{{ __("Loading Receipt Details") }}...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            fetch(`/fee-receipt/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    Swal.close();
                    const fee = data.fee;

                    document.getElementById('edit_id').value = fee.receipt_id;
                    document.getElementById('edit_student_class_id').value = fee.student_class_id;
                    document.getElementById('edit_sex').value = fee.sex === 1 ? '{{ __("Male") }}' : '{{ __("Female") }}';
                    document.getElementById('edit_roll').value = fee.roll;
                    document.getElementById('edit_receipt_no').value = fee.receipt_no;
                    document.getElementById('edit_class').value = fee.class_name;
                    document.getElementById('edit_section').value = fee.section_name;
                    document.getElementById('edit_section_duration').value = (fee.section_duration_months || 0) + " {{ __('Months') }}";
                    document.getElementById('edit_receipt_date').value = fee.receipt_date;
                    document.getElementById('edit_paid').value = fee.paid || 0;
                    document.getElementById('edit_paid_via').value = fee.paid_via || 'Cash';
                    document.getElementById('edit_previous_balance').value = fee.remaining_balance || 0;
                    document.getElementById('edit_remaining_balance').value = fee.previous_balance || 0;

                    editItemsBody.innerHTML = '';
                    (data.items || []).forEach((item, index) => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td><input type="hidden" name="items[${index}][id]" value="${item.id}">
                                <input type="text" name="items[${index}][description]" class="form-control" value="${item.description}" required></td>
                            <td><input type="number" name="items[${index}][qty]" class="form-control edit-qty" value="${item.qty}" min="1" required></td>
                            <td><input type="number" step="0.01" name="items[${index}][price]" class="form-control edit-price" value="${item.price}" min="0" required></td>
                            <td><input type="text" name="items[${index}][discount]" class="form-control" value="${item.discount || ''}"></td>
                            <td><input type="text" name="items[${index}][duration]" class="form-control" value="${item.duration || ''}"></td>
                            <td><input type="number" step="0.01" name="items[${index}][total]" class="form-control edit-total font-weight-bold bg-light" value="${item.total || 0}" readonly></td>
                            <td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger removeEditItem"><i class="fas fa-trash-alt"></i></button></td>
                        `;
                        editItemsBody.appendChild(tr);
                    });

                    attachEditItemCalculationListeners();
                    recalculateEditGrandTotal();

                    $('#editFeeModal').modal('show');
                })
                .catch(err => {
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __("Error") }}',
                        text: '{{ __("Failed to load fee receipt details.") }}'
                    });
                });
        });
    });

    // ══════════════════════════════════════════════════════════════════
    // Submit Edit Form via AJAX
    // ══════════════════════════════════════════════════════════════════
    const editForm = document.getElementById('editForm');
    if (editForm) {
        editForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const formData = new FormData(this);
            const id = document.getElementById('edit_id').value;

            Swal.fire({
                title: '{{ __("Updating Receipt") }}...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            fetch(`/fee-receipt/${id}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-HTTP-Method-Override': 'PUT'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '{{ __("Success") }}',
                        text: data.success || '{{ __("Fee receipt updated successfully!") }}',
                        confirmButtonText: '{{ __("OK") }}'
                    }).then(() => location.reload());
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __("Error") }}',
                        text: data.error || '{{ __("Error updating fee receipt!") }}'
                    });
                }
            })
            .catch(err => {
                Swal.fire({
                    icon: 'error',
                    title: '{{ __("Error") }}',
                    text: '{{ __("Failed to update fee receipt.") }}'
                });
            });
        });
    }

    // ══════════════════════════════════════════════════════════════════
    // Quick Approve & Reject with SweetAlert2
    // ══════════════════════════════════════════════════════════════════
    document.querySelectorAll('.approve-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.getAttribute('data-id');

            Swal.fire({
                title: '{{ __("Approve Fee Receipt?") }}',
                text: '{{ __("Are you sure you want to approve this fee receipt?") }}',
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

                    fetch(`/fee-receipt/${id}/approve`, {
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
                            text: data.success || '{{ __("Fee receipt approved successfully.") }}',
                            confirmButtonText: '{{ __("OK") }}'
                        }).then(() => location.reload());
                    })
                    .catch(err => {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __("Error") }}',
                            text: '{{ __("Failed to approve fee receipt.") }}'
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
                title: '{{ __("Reject Fee Receipt?") }}',
                text: '{{ __("Are you sure you want to reject this fee receipt?") }}',
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

                    fetch(`/fee-receipt/${id}/reject`, {
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
                            text: data.success || '{{ __("Fee receipt has been rejected.") }}',
                            confirmButtonText: '{{ __("OK") }}'
                        }).then(() => location.reload());
                    })
                    .catch(err => {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __("Error") }}',
                            text: '{{ __("Failed to reject fee receipt.") }}'
                        });
                    });
                }
            });
        });
    });

    // ══════════════════════════════════════════════════════════════════
    // Delete Confirmation with SweetAlert2
    // ══════════════════════════════════════════════════════════════════
    document.querySelectorAll('.delete-fee-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: '{{ __("Delete Fee Receipt?") }}',
                text: '{{ __("Are you sure you want to permanently delete this fee receipt?") }}',
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
