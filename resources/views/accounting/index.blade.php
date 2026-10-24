@extends('layout.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Modern Accounting Section Design System */
    :root {
        --acc-primary: #3b82f6;
        --acc-primary-dark: #1d4ed8;
        --acc-success: #10b981;
        --acc-danger: #ef4444;
        --acc-warning: #f59e0b;
        --acc-info: #06b6d4;
        --acc-purple: #8b5cf6;
        --acc-card-bg: #ffffff;
        --acc-card-border: rgba(0, 0, 0, 0.07);
        --acc-text-main: #1e293b;
        --acc-text-muted: #64748b;
        --acc-subtle-bg: #f8fafc;
    }

    body.dark-mode, .dark-mode {
        --acc-primary: #60a5fa;
        --acc-primary-dark: #3b82f6;
        --acc-success: #34d399;
        --acc-danger: #f87171;
        --acc-warning: #fbbf24;
        --acc-info: #22d3ee;
        --acc-purple: #a78bfa;
        --acc-card-bg: #2b2d30;
        --acc-card-border: rgba(255, 255, 255, 0.08);
        --acc-text-main: #f1f5f9;
        --acc-text-muted: #94a3b8;
        --acc-subtle-bg: #1e1e1e;
    }

    .accounting-dashboard {
        color: var(--acc-text-main);
        padding-top: 10px;
    }

    /* Top Hero Header */
    .acc-hero-card {
        background: var(--acc-card-bg);
        border: 1px solid var(--acc-card-border);
        border-radius: 16px;
        padding: 24px 28px;
        margin-bottom: 24px;
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
        position: relative;
        overflow: hidden;
    }
    .acc-hero-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 6px;
        height: 100%;
        background: linear-gradient(180deg, #3b82f6, #8b5cf6);
    }
    .acc-hero-title {
        font-size: 1.65rem;
        font-weight: 700;
        margin-bottom: 4px;
        letter-spacing: -0.02em;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .acc-hero-subtitle {
        color: var(--acc-text-muted);
        font-size: 0.95rem;
        margin-bottom: 0;
    }

    /* Metric Cards */
    .acc-metric-card {
        background: var(--acc-card-bg);
        border: 1px solid var(--acc-card-border);
        border-radius: 14px;
        padding: 20px;
        height: 100%;
        position: relative;
        overflow: hidden;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 2px 12px -2px rgba(0, 0, 0, 0.04);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .acc-metric-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px -4px rgba(0, 0, 0, 0.08);
        border-color: rgba(59, 130, 246, 0.3);
    }
    .acc-metric-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
    }
    .acc-metric-title {
        font-size: 0.82rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--acc-text-muted);
        margin-bottom: 6px;
    }
    .acc-metric-value {
        font-size: 1.85rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        line-height: 1.1;
    }
    .acc-metric-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }
    .acc-metric-footer {
        margin-top: 14px;
        padding-top: 12px;
        border-top: 1px dashed var(--acc-card-border);
        font-size: 0.8rem;
        color: var(--acc-text-muted);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* Module Hub Cards */
    .acc-module-card {
        background: var(--acc-card-bg);
        border: 1px solid var(--acc-card-border);
        border-radius: 14px;
        padding: 22px;
        transition: all 0.25s ease;
        position: relative;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .acc-module-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px -2px rgba(0, 0, 0, 0.06);
    }
    .acc-module-badge {
        font-size: 0.72rem;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 6px;
        text-transform: uppercase;
    }

    /* Card Panels */
    .acc-panel {
        background: var(--acc-card-bg);
        border: 1px solid var(--acc-card-border);
        border-radius: 14px;
        box-shadow: 0 2px 12px -2px rgba(0, 0, 0, 0.04);
        margin-bottom: 24px;
        overflow: hidden;
    }
    .acc-panel-header {
        padding: 18px 24px;
        border-bottom: 1px solid var(--acc-card-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .acc-panel-title {
        font-size: 1.05rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .acc-panel-body {
        padding: 20px 24px;
    }

    /* Tabs */
    .acc-tabs {
        border-bottom: 1px solid var(--acc-card-border);
        padding: 0 20px;
        gap: 8px;
    }
    .acc-tabs .nav-link {
        border: none;
        border-bottom: 3px solid transparent;
        color: var(--acc-text-muted);
        font-weight: 600;
        font-size: 0.9rem;
        padding: 14px 18px;
        border-radius: 0;
        background: transparent;
        transition: all 0.2s ease;
    }
    .acc-tabs .nav-link:hover {
        color: var(--acc-primary);
    }
    .acc-tabs .nav-link.active {
        color: var(--acc-primary);
        border-bottom-color: var(--acc-primary);
        background: transparent;
    }

    /* Tables */
    .acc-table {
        margin-bottom: 0;
        width: 100%;
        color: var(--acc-text-main);
    }
    .acc-table th {
        background: var(--acc-subtle-bg);
        color: var(--acc-text-muted);
        font-size: 0.76rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 12px 16px;
        border-top: none;
        border-bottom: 1px solid var(--acc-card-border);
    }
    .acc-table td {
        padding: 14px 16px;
        vertical-align: middle;
        border-top: 1px solid var(--acc-card-border);
        font-size: 0.88rem;
    }
    .acc-table tbody tr {
        transition: background-color 0.15s ease;
    }
    .acc-table tbody tr:hover {
        background-color: rgba(59, 130, 246, 0.03);
    }
    .dark-mode .acc-table tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.03);
    }

    /* Badges */
    .badge-status {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .badge-status.approved {
        background-color: rgba(16, 185, 129, 0.15);
        color: #10b981;
    }
    .dark-mode .badge-status.approved {
        background-color: rgba(16, 185, 129, 0.25);
        color: #34d399;
    }
    .badge-status.pending {
        background-color: rgba(245, 158, 11, 0.15);
        color: #d97706;
    }
    .dark-mode .badge-status.pending {
        background-color: rgba(245, 158, 11, 0.25);
        color: #fbbf24;
    }
    .badge-status.rejected {
        background-color: rgba(239, 68, 68, 0.15);
        color: #ef4444;
    }
    .dark-mode .badge-status.rejected {
        background-color: rgba(239, 68, 68, 0.25);
        color: #f87171;
    }

    /* Action Buttons */
    .btn-acc {
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 8px 16px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }
    .btn-acc-primary {
        background: #3b82f6;
        color: #fff;
        border: 1px solid #3b82f6;
    }
    .btn-acc-primary:hover {
        background: #2563eb;
        color: #fff;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }
    .btn-acc-outline {
        background: transparent;
        color: var(--acc-text-main);
        border: 1px solid var(--acc-card-border);
    }
    .btn-acc-outline:hover {
        background: var(--acc-subtle-bg);
        color: var(--acc-text-main);
    }

    .btn-action-sm {
        padding: 4px 10px;
        font-size: 0.78rem;
        font-weight: 600;
        border-radius: 6px;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.15s ease;
    }
    .btn-action-approve {
        background: #10b981;
        color: #fff;
    }
    .btn-action-approve:hover {
        background: #059669;
        color: #fff;
    }
    .btn-action-reject {
        background: #ef4444;
        color: #fff;
    }
    .btn-action-reject:hover {
        background: #dc2626;
        color: #fff;
    }

    /* Modal Form Dark Mode */
    .dark-mode .modal-content {
        background-color: #2b2d30 !important;
        color: #f1f5f9;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .dark-mode .modal-header,
    .dark-mode .modal-footer {
        border-color: rgba(255, 255, 255, 0.08);
    }
    .dark-mode .form-control,
    .dark-mode .custom-select {
        background-color: #1e1e1e;
        border-color: rgba(255, 255, 255, 0.12);
        color: #f1f5f9;
    }
    .dark-mode .form-control:focus,
    .dark-mode .custom-select:focus {
        background-color: #1e1e1e;
        border-color: #3b82f6;
        color: #f1f5f9;
    }

    /* Pulse animation */
    @keyframes pulseGlow {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(239, 68, 68, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
    }
    .pulse-badge {
        animation: pulseGlow 2s infinite;
        border-radius: 50%;
        display: inline-block;
        width: 8px;
        height: 8px;
        background-color: #ef4444;
    }
</style>

<div class="accounting-dashboard">

    <!-- 1. Hero Header & Quick Controls -->
    <div class="acc-hero-card">
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-6 mb-3 mb-md-0">
                <h1 class="acc-hero-title">
                    <i class="fas fa-chart-pie text-primary"></i>
                    Financial & Accounting Hub
                    <span class="badge badge-primary px-3 py-1 font-weight-normal" style="font-size: 0.75rem; border-radius: 20px;">
                        FY {{ $selectedYear }}
                    </span>
                </h1>
                <p class="acc-hero-subtitle">
                    Real-time general ledger, student tuition cash flow, procurement approvals, and expense controls.
                </p>
            </div>
            <div class="col-lg-5 col-md-6 text-md-right d-flex flex-wrap align-items-center justify-content-md-end gap-2">
                <!-- Year selector form -->
                <form action="{{ route('accounting.index') }}" method="GET" class="mr-2 mb-2 mb-sm-0" id="yearFilterForm">
                    <select name="year" class="form-control form-control-sm font-weight-bold" onchange="document.getElementById('yearFilterForm').submit()" style="border-radius: 8px; width: 110px; display: inline-block;">
                        @foreach($availableYears as $yr)
                            <option value="{{ $yr }}" {{ $selectedYear == $yr ? 'selected' : '' }}>FY {{ $yr }}</option>
                        @endforeach
                    </select>
                </form>

                @if(in_array(Auth::user()->role, [0, 3]))
                <button type="button" class="btn btn-acc btn-acc-primary mr-2 mb-2 mb-sm-0" data-toggle="modal" data-target="#quickAddTransactionModal">
                    <i class="fas fa-plus-circle"></i> Quick Record
                </button>
                @endif

                <a href="{{ route('accounting.transactions') }}" class="btn btn-acc btn-acc-outline mb-2 mb-sm-0">
                    <i class="fas fa-book-open"></i> Full Ledger
                </a>
            </div>
        </div>
    </div>

    <!-- 2. Primary Financial KPIs (4 Columns) -->
    <div class="row mb-4">
        <!-- Total Inflow / Profit -->
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="acc-metric-card">
                <div>
                    <div class="acc-metric-header">
                        <div>
                            <div class="acc-metric-title">Total Revenue</div>
                            <div class="acc-metric-value text-success">
                                ${{ number_format($totalIncome, 2) }}
                            </div>
                        </div>
                        <div class="acc-metric-icon" style="background: rgba(16, 185, 129, 0.12); color: #10b981;">
                            <i class="fas fa-arrow-trend-up"></i>
                        </div>
                    </div>
                </div>
                <div class="acc-metric-footer">
                    <span><i class="fas fa-calendar-day mr-1"></i> Current Month:</span>
                    <strong class="text-success">+${{ number_format($monthIncome, 2) }}</strong>
                </div>
            </div>
        </div>

        <!-- Total Outflow / Expenses -->
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="acc-metric-card">
                <div>
                    <div class="acc-metric-header">
                        <div>
                            <div class="acc-metric-title">Operating Expenses</div>
                            <div class="acc-metric-value text-danger">
                                ${{ number_format($totalExpense, 2) }}
                            </div>
                        </div>
                        <div class="acc-metric-icon" style="background: rgba(239, 68, 68, 0.12); color: #ef4444;">
                            <i class="fas fa-arrow-trend-down"></i>
                        </div>
                    </div>
                </div>
                <div class="acc-metric-footer">
                    <span><i class="fas fa-calendar-day mr-1"></i> Current Month:</span>
                    <strong class="text-danger">-${{ number_format($monthExpense, 2) }}</strong>
                </div>
            </div>
        </div>

        <!-- Net Financial Balance -->
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="acc-metric-card">
                <div>
                    <div class="acc-metric-header">
                        <div>
                            <div class="acc-metric-title">Net Ledger Balance</div>
                            <div class="acc-metric-value {{ $netBalance >= 0 ? 'text-primary' : 'text-danger' }}">
                                ${{ number_format($netBalance, 2) }}
                            </div>
                        </div>
                        <div class="acc-metric-icon" style="background: rgba(59, 130, 246, 0.12); color: #3b82f6;">
                            <i class="fas fa-scale-balanced"></i>
                        </div>
                    </div>
                </div>
                <div class="acc-metric-footer">
                    <span><i class="fas fa-chart-line mr-1"></i> Month Margin:</span>
                    <strong class="{{ $monthNet >= 0 ? 'text-success' : 'text-danger' }}">
                        {{ $monthNet >= 0 ? '+' : '' }}${{ number_format($monthNet, 2) }}
                    </strong>
                </div>
            </div>
        </div>

        <!-- Pending Approvals & Collection -->
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="acc-metric-card">
                <div>
                    <div class="acc-metric-header">
                        <div>
                            <div class="acc-metric-title">Pending Approvals</div>
                            <div class="acc-metric-value {{ ($pendingPRCount + $pendingFRCount) > 0 ? 'text-warning' : 'text-muted' }}">
                                {{ $pendingPRCount + $pendingFRCount }} <span style="font-size: 0.95rem; font-weight: 600;">Items</span>
                            </div>
                        </div>
                        <div class="acc-metric-icon" style="background: rgba(245, 158, 11, 0.12); color: #f59e0b;">
                            <i class="fas fa-clock-rotate-left"></i>
                        </div>
                    </div>
                </div>
                <div class="acc-metric-footer">
                    <span>Pending Value:</span>
                    <strong class="text-warning">${{ number_format($pendingPRAmount + $pendingFRAmount, 2) }}</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Workflow Launchers (3 Fast-Navigation Cards) -->
    <div class="row mb-4">
        <!-- Purchase Requests Card -->
        <div class="col-lg-4 col-md-6 mb-3 mb-lg-0">
            <div class="acc-module-card">
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <div class="acc-metric-icon mr-3" style="background: rgba(6, 182, 212, 0.12); color: #06b6d4;">
                                <i class="fas fa-cart-shopping"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 font-weight-bold">Purchase Requests</h5>
                                <small class="text-muted">Procurement & Vendors</small>
                            </div>
                        </div>
                        @if($pendingPRCount > 0)
                            <span class="badge badge-warning acc-module-badge">{{ $pendingPRCount }} Pending</span>
                        @else
                            <span class="badge badge-success acc-module-badge">All Cleared</span>
                        @endif
                    </div>
                    <p class="text-muted small mb-3">
                        Submit departmental asset requisitions, track vendor quotes, and route approvals for institutional purchases.
                    </p>
                    <div class="row text-center mb-3 py-2" style="background: var(--acc-subtle-bg); border-radius: 8px;">
                        <div class="col-6 border-right">
                            <span class="d-block small text-muted">Total Requests</span>
                            <strong class="h6 mb-0">{{ $totalPRCount }}</strong>
                        </div>
                        <div class="col-6">
                            <span class="d-block small text-muted">Approved Value</span>
                            <strong class="h6 mb-0 text-success">${{ number_format($approvedPRAmount, 0) }}</strong>
                        </div>
                    </div>
                </div>
                <div>
                    <a href="{{ route('purchase_req.index') }}" class="btn btn-block btn-acc btn-acc-outline justify-content-center">
                        Manage Purchase Requests <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Student Fee Invoicing Card -->
        <div class="col-lg-4 col-md-6 mb-3 mb-lg-0">
            <div class="acc-module-card">
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <div class="acc-metric-icon mr-3" style="background: rgba(16, 185, 129, 0.12); color: #10b981;">
                                <i class="fas fa-receipt"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 font-weight-bold">Fee Receipts & Billing</h5>
                                <small class="text-muted">Tuition & Invoicing</small>
                            </div>
                        </div>
                        @if($pendingFRCount > 0)
                            <span class="badge badge-warning acc-module-badge">{{ $pendingFRCount }} Pending</span>
                        @else
                            <span class="badge badge-success acc-module-badge">Reconciled</span>
                        @endif
                    </div>
                    <p class="text-muted small mb-3">
                        Generate official student tuition invoices, record payments via ABA Payway & Cash, and track installment balances.
                    </p>
                    <div class="row text-center mb-3 py-2" style="background: var(--acc-subtle-bg); border-radius: 8px;">
                        <div class="col-6 border-right">
                            <span class="d-block small text-muted">Collected Fees</span>
                            <strong class="h6 mb-0 text-success">${{ number_format($totalCollectedFees, 0) }}</strong>
                        </div>
                        <div class="col-6">
                            <span class="d-block small text-muted">Outstanding Bal.</span>
                            <strong class="h6 mb-0 text-danger">${{ number_format($totalOutstandingFees, 0) }}</strong>
                        </div>
                    </div>
                </div>
                <div>
                    <a href="{{ route('fee_receipt.index') }}" class="btn btn-block btn-acc btn-acc-outline justify-content-center">
                        Manage Fee Receipts <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Profit & Loss General Ledger Card -->
        <div class="col-lg-4 col-md-12">
            <div class="acc-module-card">
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <div class="acc-metric-icon mr-3" style="background: rgba(139, 92, 246, 0.12); color: #8b5cf6;">
                                <i class="fas fa-vault"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 font-weight-bold">General Ledger & P&L</h5>
                                <small class="text-muted">Accounting Books</small>
                            </div>
                        </div>
                        <span class="badge badge-info acc-module-badge">Annual Books</span>
                    </div>
                    <p class="text-muted small mb-3">
                        Complete double-entry accounting records, salary disbursements, utilities, facility upkeep, and tax compliance entries.
                    </p>
                    <div class="row text-center mb-3 py-2" style="background: var(--acc-subtle-bg); border-radius: 8px;">
                        <div class="col-6 border-right">
                            <span class="d-block small text-muted">Total Ledger Entries</span>
                            <strong class="h6 mb-0">{{ count($recentTransactions) }} Records</strong>
                        </div>
                        <div class="col-6">
                            <span class="d-block small text-muted">Ledger Health</span>
                            <strong class="h6 mb-0 text-primary">Balanced</strong>
                        </div>
                    </div>
                </div>
                <div>
                    <a href="{{ route('accounting.transactions') }}" class="btn btn-block btn-acc btn-acc-outline justify-content-center">
                        Open Profit & Loss Ledger <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. Interactive Financial Visual Analytics -->
    <div class="row mb-4">
        <!-- Monthly Cash Flow Chart -->
        <div class="col-lg-8 mb-3 mb-lg-0">
            <div class="acc-panel h-100">
                <div class="acc-panel-header">
                    <h5 class="acc-panel-title">
                        <i class="fas fa-chart-line text-primary"></i>
                        Monthly Revenue & Expense Trends (FY {{ $selectedYear }})
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge badge-light px-2 py-1 text-muted border">
                            <i class="fas fa-circle text-success mr-1" style="font-size: 8px;"></i> Revenue
                        </span>
                        <span class="badge badge-light px-2 py-1 text-muted border ml-1">
                            <i class="fas fa-circle text-danger mr-1" style="font-size: 8px;"></i> Expenses
                        </span>
                    </div>
                </div>
                <div class="acc-panel-body">
                    <div style="height: 310px; position: relative;">
                        <canvas id="monthlyCashflowChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categorical Expense Allocation Chart -->
        <div class="col-lg-4">
            <div class="acc-panel h-100">
                <div class="acc-panel-header">
                    <h5 class="acc-panel-title">
                        <i class="fas fa-chart-pie text-purple"></i>
                        Expense Allocation
                    </h5>
                </div>
                <div class="acc-panel-body">
                    <div style="height: 210px; position: relative; margin-bottom: 15px;">
                        <canvas id="expenseCategoryChart"></canvas>
                    </div>
                    <div class="acc-category-breakdown small">
                        @forelse($expenseCategories->take(4) as $cat)
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-truncate mr-2" style="max-width: 170px;">
                                <i class="fas fa-caret-right text-muted mr-1"></i> {{ $cat->category }}
                            </span>
                            <span class="font-weight-bold text-danger">${{ number_format($cat->total, 2) }}</span>
                        </div>
                        @empty
                        <p class="text-muted text-center py-2 mb-0">No expense records found.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. Tabbed Activity & Approvals Management -->
    <div class="acc-panel">
        <ul class="nav acc-tabs" id="accountingTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pending-tab" data-toggle="tab" href="#pendingApprovalsPane" role="tab">
                    <i class="fas fa-bell mr-1"></i>
                    Pending Approvals
                    @if(($pendingPRCount + $pendingFRCount) > 0)
                        <span class="badge badge-danger ml-2">{{ $pendingPRCount + $pendingFRCount }}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="transactions-tab" data-toggle="tab" href="#recentTransactionsPane" role="tab">
                    <i class="fas fa-list-check mr-1"></i> Recent Transactions
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="purchase-tab" data-toggle="tab" href="#recentPurchasePane" role="tab">
                    <i class="fas fa-cart-flatbed mr-1"></i> Purchase Requests
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="fees-tab" data-toggle="tab" href="#recentFeesPane" role="tab">
                    <i class="fas fa-receipt mr-1"></i> Student Fee Receipts
                </a>
            </li>
        </ul>

        <div class="tab-content" id="accountingTabsContent">

            <!-- TAB 1: PENDING APPROVALS (Actionable 1-Click Approve/Reject) -->
            <div class="tab-pane fade show active" id="pendingApprovalsPane" role="tabpanel">
                <div class="table-responsive">
                    <table class="table acc-table mb-0">
                        <thead>
                            <tr>
                                <th>Type / Reference</th>
                                <th>Requester / Student</th>
                                <th>Department / Details</th>
                                <th>Date Needed / Paid Via</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $hasPending = false; @endphp

                            <!-- Pending Purchase Requests -->
                            @foreach($pendingPurchaseRequests as $pr)
                                @php $hasPending = true; @endphp
                                <tr id="pr-row-{{ $pr->id }}">
                                    <td>
                                        <div class="font-weight-bold text-primary">
                                            <i class="fas fa-cart-shopping mr-1 text-cyan"></i> {{ $pr->request_no }}
                                        </div>
                                        <small class="text-muted">Purchase Request</small>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold">{{ $pr->requisitioner }}</div>
                                        <small class="text-muted">ID: #{{ $pr->user_id ?? 'N/A' }}</small>
                                    </td>
                                    <td>
                                        <div>{{ $pr->department }}</div>
                                        <small class="text-muted text-truncate d-inline-block" style="max-width: 250px;">{{ $pr->purpose }}</small>
                                    </td>
                                    <td>
                                        <div>{{ $pr->date_needed ?? $pr->date_prepared }}</div>
                                        <small class="text-muted">Vendor: {{ $pr->vendor ?? 'General' }}</small>
                                    </td>
                                    <td>
                                        <strong class="text-danger">${{ number_format($pr->total, 2) }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge-status pending">
                                            <span class="pulse-badge"></span> Pending Review
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('purchase_req.show', $pr->id) }}" class="btn btn-outline-secondary mr-1" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if(in_array(Auth::user()->role, [0, 3]))
                                            <button type="button" class="btn btn-action-approve btn-action-sm mr-1" onclick="handleQuickApprove('pr', {{ $pr->id }})">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                            <button type="button" class="btn btn-action-reject btn-action-sm" onclick="handleQuickReject('pr', {{ $pr->id }})">
                                                <i class="fas fa-xmark"></i> Reject
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            <!-- Pending Fee Receipts -->
                            @foreach($pendingFeeReceipts as $fr)
                                @php $hasPending = true; @endphp
                                <tr id="fr-row-{{ $fr->id }}">
                                    <td>
                                        <div class="font-weight-bold text-success">
                                            <i class="fas fa-receipt mr-1 text-success"></i> {{ $fr->receipt_no ?? ('REC-'.$fr->id) }}
                                        </div>
                                        <small class="text-muted">Fee Receipt</small>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold">{{ $fr->student_name ?? 'Student' }}</div>
                                        <small class="text-muted">Class: {{ $fr->class_name ?? 'N/A' }}</small>
                                    </td>
                                    <td>
                                        <div>Tuition & School Services</div>
                                        <small class="text-muted">Remaining Bal: ${{ number_format($fr->remaining_balance, 2) }}</small>
                                    </td>
                                    <td>
                                        <div>{{ $fr->date }}</div>
                                        <small class="text-muted">Via: {{ $fr->paid_via }}</small>
                                    </td>
                                    <td>
                                        <strong class="text-success">${{ number_format($fr->paid, 2) }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge-status pending">
                                            <span class="pulse-badge"></span> Pending Review
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('fee_receipt.show', $fr->id) }}" class="btn btn-outline-secondary mr-1" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if(in_array(Auth::user()->role, [0, 3]))
                                            <button type="button" class="btn btn-action-approve btn-action-sm mr-1" onclick="handleQuickApprove('fr', {{ $fr->id }})">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                            <button type="button" class="btn btn-action-reject btn-action-sm" onclick="handleQuickReject('fr', {{ $fr->id }})">
                                                <i class="fas fa-xmark"></i> Reject
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            @if(!$hasPending)
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <div class="mb-2"><i class="fas fa-circle-check text-success" style="font-size: 2.5rem;"></i></div>
                                        <h6 class="font-weight-bold">All Financial Items Up-to-Date</h6>
                                        <p class="small mb-0">No purchase requisitions or fee receipts are currently awaiting approval.</p>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB 2: RECENT TRANSACTIONS -->
            <div class="tab-pane fade" id="recentTransactionsPane" role="tabpanel">
                <div class="table-responsive">
                    <table class="table acc-table mb-0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Flow Type</th>
                                <th>Category</th>
                                <th>Description / Memo</th>
                                <th class="text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTransactions as $tx)
                                <tr>
                                    <td>
                                        <div class="font-weight-bold">{{ \Carbon\Carbon::parse($tx->date)->format('M d, Y') }}</div>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($tx->date)->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        @if($tx->type === 'profit')
                                            <span class="badge badge-success px-2 py-1 font-weight-normal">
                                                <i class="fas fa-arrow-up mr-1"></i> Inflow
                                            </span>
                                        @else
                                            <span class="badge badge-danger px-2 py-1 font-weight-normal">
                                                <i class="fas fa-arrow-down mr-1"></i> Outflow
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="font-weight-bold">{{ $tx->category }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $tx->note ?? '-' }}</span>
                                    </td>
                                    <td class="text-right">
                                        <strong class="{{ $tx->type === 'profit' ? 'text-success' : 'text-danger' }}">
                                            {{ $tx->type === 'profit' ? '+' : '-' }}${{ number_format($tx->amount, 2) }}
                                        </strong>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No transactions recorded yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB 3: RECENT PURCHASE REQUESTS -->
            <div class="tab-pane fade" id="recentPurchasePane" role="tabpanel">
                <div class="table-responsive">
                    <table class="table acc-table mb-0">
                        <thead>
                            <tr>
                                <th>Request #</th>
                                <th>Requisitioner</th>
                                <th>Department</th>
                                <th>Purpose</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th class="text-right">View</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentPurchaseRequests as $pr)
                                <tr>
                                    <td><strong>{{ $pr->request_no }}</strong></td>
                                    <td>{{ $pr->requisitioner }}</td>
                                    <td><span class="badge badge-light border">{{ $pr->department }}</span></td>
                                    <td class="text-truncate" style="max-width: 250px;">{{ $pr->purpose }}</td>
                                    <td><strong>${{ number_format($pr->total, 2) }}</strong></td>
                                    <td>
                                        <span class="badge-status {{ $pr->status }}">
                                            {{ ucfirst($pr->status) }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('purchase_req.show', $pr->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-folder-open"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">No purchase requests found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB 4: RECENT FEE RECEIPTS -->
            <div class="tab-pane fade" id="recentFeesPane" role="tabpanel">
                <div class="table-responsive">
                    <table class="table acc-table mb-0">
                        <thead>
                            <tr>
                                <th>Receipt #</th>
                                <th>Student Name</th>
                                <th>Class</th>
                                <th>Payment Method</th>
                                <th>Amount Paid</th>
                                <th>Balance</th>
                                <th>Status</th>
                                <th class="text-right">PDF</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentFeeReceipts as $fr)
                                <tr>
                                    <td><strong>{{ $fr->receipt_no ?? ('REC-'.$fr->id) }}</strong></td>
                                    <td>{{ $fr->student_name ?? 'N/A' }}</td>
                                    <td><span class="badge badge-light border">{{ $fr->class_name ?? 'N/A' }}</span></td>
                                    <td><i class="fas fa-credit-card mr-1 text-muted"></i> {{ $fr->paid_via }}</td>
                                    <td><strong class="text-success">${{ number_format($fr->paid, 2) }}</strong></td>
                                    <td>${{ number_format($fr->remaining_balance, 2) }}</td>
                                    <td>
                                        <span class="badge-status {{ $fr->status }}">
                                            {{ ucfirst($fr->status) }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('fee_receipt.pdf', $fr->id) }}" target="_blank" class="btn btn-sm btn-outline-danger" title="Download Official PDF">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">No fee receipts found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</div>

<!-- Quick Add Transaction Modal -->
@if(in_array(Auth::user()->role, [0, 3]))
<div class="modal fade" id="quickAddTransactionModal" tabindex="-1" role="dialog" aria-labelledby="quickAddModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="quickAddModalLabel">
                        <i class="fas fa-plus-circle text-primary mr-1"></i> Record Financial Entry
                    </h5>
                    <button type="button" class="close text-muted" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Transaction Type <span class="text-danger">*</span></label>
                        <select name="type" class="custom-select font-weight-bold" required>
                            <option value="expense" selected>Expense (Outflow)</option>
                            <option value="profit">Income / Profit (Inflow)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Category <span class="text-danger">*</span></label>
                        <input type="text" name="category" list="categoryOptions" class="form-control" placeholder="e.g. Staff Salaries, Lab Equipment, Utilities" required>
                        <datalist id="categoryOptions">
                            <option value="Staff Salaries">
                            <option value="Electricity & Utilities">
                            <option value="Building Maintenance">
                            <option value="IT Infrastructure">
                            <option value="Office Supplies">
                            <option value="Laboratory Supplies">
                            <option value="Tuition Fees">
                            <option value="Library Subscriptions">
                            <option value="Sports & Extracurricular">
                            <option value="Transportation Fees">
                        </datalist>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">Amount ($) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="number" step="0.01" min="0.01" name="amount" class="form-control font-weight-bold" placeholder="0.00" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <label class="font-weight-bold">Memo / Description</label>
                        <textarea name="note" class="form-control" rows="2" placeholder="Optional context or reference notes..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">
                        <i class="fas fa-check mr-1"></i> Save Entry
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Deterministic tab switcher
    if (window.jQuery) {
        $('#accountingTabs a').on('click', function (e) {
            e.preventDefault();
            const target = $(this).attr('href');
            $('#accountingTabs a').removeClass('active');
            $(this).addClass('active');
            $('#accountingTabsContent > .tab-pane').removeClass('show active');
            $(target).addClass('show active');
        });

        $('[data-target="#quickAddTransactionModal"]').on('click', function (e) {
            e.preventDefault();
            $('#quickAddTransactionModal').modal('show');
        });
    }

    // 1. Chart Theme Colors
    const isDark = document.body.classList.contains('dark-mode') || document.querySelector('.content-wrapper.dark-mode');
    const textColor = isDark ? '#94a3b8' : '#64748b';
    const gridColor = isDark ? 'rgba(255, 255, 255, 0.06)' : 'rgba(0, 0, 0, 0.05)';

    // 2. Monthly Cashflow Bar Chart
    const cashflowCtx = document.getElementById('monthlyCashflowChart').getContext('2d');
    const monthLabels = {!! json_encode($monthNames) !!};
    const incomeData = {!! json_encode($monthlyIncomeData) !!};
    const expenseData = {!! json_encode($monthlyExpenseData) !!};

    new Chart(cashflowCtx, {
        type: 'bar',
        data: {
            labels: monthLabels,
            datasets: [
                {
                    label: 'Revenue ($)',
                    data: incomeData,
                    backgroundColor: 'rgba(16, 185, 129, 0.85)',
                    borderColor: '#10b981',
                    borderWidth: 1,
                    borderRadius: 6,
                    barPercentage: 0.65,
                    categoryPercentage: 0.7,
                },
                {
                    label: 'Expenses ($)',
                    data: expenseData,
                    backgroundColor: 'rgba(239, 68, 68, 0.85)',
                    borderColor: '#ef4444',
                    borderWidth: 1,
                    borderRadius: 6,
                    barPercentage: 0.65,
                    categoryPercentage: 0.7,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    display: false,
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return context.dataset.label + ': $' + Number(context.raw).toLocaleString(undefined, { minimumFractionDigits: 2 });
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                        color: gridColor
                    },
                    ticks: {
                        color: textColor,
                        font: { size: 11, weight: '600' }
                    }
                },
                y: {
                    grid: {
                        color: gridColor,
                        borderDash: [4, 4]
                    },
                    ticks: {
                        color: textColor,
                        font: { size: 11 },
                        callback: function (val) {
                            return '$' + (val >= 1000 ? (val / 1000) + 'k' : val);
                        }
                    }
                }
            }
        }
    });

    // 3. Expense Categorical Doughnut Chart
    const categoryCtx = document.getElementById('expenseCategoryChart').getContext('2d');
    @php
        $catLabels = $expenseCategories->pluck('category')->toArray();
        $catValues = $expenseCategories->pluck('total')->toArray();
    @endphp
    const catLabels = {!! json_encode($catLabels) !!};
    const catValues = {!! json_encode($catValues) !!};

    const donutColors = [
        '#ef4444', '#f59e0b', '#3b82f6', '#8b5cf6', '#06b6d4', '#10b981'
    ];

    if (catValues.length > 0) {
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: catLabels,
                datasets: [{
                    data: catValues,
                    backgroundColor: donutColors.slice(0, catValues.length),
                    borderWidth: 2,
                    borderColor: isDark ? '#2b2d30' : '#ffffff',
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '72%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return ' ' + context.label + ': $' + Number(context.raw).toLocaleString(undefined, { minimumFractionDigits: 2 });
                            }
                        }
                    }
                }
            }
        });
    }
});

// Quick 1-Click Approve / Reject Handler with CSRF Protection
function handleQuickApprove(type, id) {
    if (!confirm('Are you sure you want to approve this ' + (type === 'pr' ? 'Purchase Request' : 'Fee Receipt') + '?')) {
        return;
    }

    const url = type === 'pr' ? `/purchase-req/${id}/approve` : `/fee-receipt/${id}/approve`;
    const token = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : '{{ csrf_token() }}';

    fetch(url, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': token,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (typeof toastr !== 'undefined') {
            toastr.success(data.success || 'Item successfully approved!');
        } else {
            alert(data.success || 'Approved successfully!');
        }
        // Remove or update the row smoothly
        const row = document.getElementById(`${type}-row-${id}`);
        if (row) {
            row.style.transition = 'all 0.4s ease';
            row.style.opacity = '0';
            row.style.transform = 'scale(0.95)';
            setTimeout(() => {
                row.remove();
                // If table is now empty, reload to update KPI cards
                setTimeout(() => location.reload(), 600);
            }, 400);
        } else {
            location.reload();
        }
    })
    .catch(err => {
        console.error(err);
        if (typeof toastr !== 'undefined') {
            toastr.error('Failed to process approval.');
        } else {
            alert('Failed to process approval.');
        }
    });
}

function handleQuickReject(type, id) {
    if (!confirm('Are you sure you want to reject this ' + (type === 'pr' ? 'Purchase Request' : 'Fee Receipt') + '?')) {
        return;
    }

    const url = type === 'pr' ? `/purchase-req/${id}/reject` : `/fee-receipt/${id}/reject`;
    const token = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : '{{ csrf_token() }}';

    fetch(url, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': token,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (typeof toastr !== 'undefined') {
            toastr.warning(data.success || 'Item has been rejected.');
        } else {
            alert(data.success || 'Item rejected.');
        }
        const row = document.getElementById(`${type}-row-${id}`);
        if (row) {
            row.style.transition = 'all 0.4s ease';
            row.style.opacity = '0';
            setTimeout(() => {
                row.remove();
                setTimeout(() => location.reload(), 600);
            }, 400);
        } else {
            location.reload();
        }
    })
    .catch(err => {
        console.error(err);
        if (typeof toastr !== 'undefined') {
            toastr.error('Failed to process rejection.');
        } else {
            alert('Failed to process rejection.');
        }
    });
}
</script>
@endsection
