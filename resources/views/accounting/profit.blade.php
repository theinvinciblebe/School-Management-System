@extends('layout.main')

@section('title', 'FinancialReport_' . $selectedYear)

@section('content')

@php
    $brandLogo = $customizes->brand_logo ?? null;
    if (!empty($brandLogo) && str_starts_with($brandLogo, 'data:')) {
        $logoUrl = $brandLogo;
    } else {
        $logoUrl = (!empty($brandLogo) && file_exists(public_path('customize_images/' . $brandLogo)))
            ? asset('customize_images/' . $brandLogo)
            : (file_exists(public_path('logo-final.png'))
                ? asset('logo-final.png')
                : (file_exists(public_path('customize_images/noimg.jpg'))
                    ? asset('customize_images/noimg.jpg')
                    : asset('assets/dist/img/mawaridLogo.jpg')));
    }

    $schoolName    = $customizes->brand_title ?? 'School System';
    $schoolAddress = $customizes->school_address ?? 'No.32, Street 606, Tuol Kork, Phnom Penh, Cambodia';
    $schoolPhone   = $customizes->school_phone ?? '+855 12 801 470 / +855 71 220 6315';
    $schoolEmail   = $customizes->school_email ?? 'info@schoolsystem.edu.kh';
@endphp

<style>
/* ══════════════════════════════════════════════════════════════════
   PROFITS & EXPENSES – Executive Financial Report Layout
══════════════════════════════════════════════════════════════════ */

.fin-screen-wrap {
    max-width: 1140px;
    margin: 1rem auto 3rem;
    padding: 0 1rem;
}

/* Action Toolbar (Screen Only) */
.fin-action-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
}
html.dark-mode .fin-action-bar {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 25px -2px rgba(0, 0, 0, 0.35);
}

.fin-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1.25rem;
    border-radius: 10px;
    font-size: 0.88rem;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none !important;
    transition: all 0.2s ease;
    border: none;
}
.fin-btn-primary {
    background: linear-gradient(135deg, #10b981, #059669);
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}
.fin-btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
}
.fin-btn-secondary {
    background: #f1f5f9;
    color: #475569 !important;
    border: 1px solid #cbd5e1;
}
.fin-btn-secondary:hover { background: #e2e8f0; }
html.dark-mode .fin-btn-secondary {
    background: #252c42;
    border-color: #333d5d;
    color: #cbd5e1 !important;
}

/* Report Card Container */
.fin-report-card {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 20px;
    padding: 2.25rem;
    box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.08);
    color: #0f172a;
    position: relative;
    margin-bottom: 2rem;
}
html.dark-mode .fin-report-card {
    background: #1e2235;
    border-color: #2e354f;
    color: #f8fafc;
}

/* Report Header */
.fin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 2px solid #e2e8f0;
}
html.dark-mode .fin-header { border-bottom-color: #2e354f; }
.fin-brand {
    display: flex;
    align-items: center;
    gap: 1.25rem;
}
.fin-logo {
    width: 72px;
    height: 72px;
    border-radius: 14px;
    object-fit: cover;
    border: 1px solid #cbd5e1;
}
.fin-school-details h2 {
    font-size: 1.45rem;
    font-weight: 800;
    margin: 0;
    color: #0f172a;
    letter-spacing: -0.01em;
}
html.dark-mode .fin-school-details h2 { color: #f8fafc; }
.fin-school-details p {
    font-size: 0.82rem;
    color: #64748b;
    margin: 0.2rem 0 0;
}
html.dark-mode .fin-school-details p { color: #94a3b8; }

.fin-doc-title-box {
    text-align: right;
}
.fin-doc-title {
    font-size: 1.15rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #10b981;
    margin: 0;
}
.fin-badge-fiscal {
    display: inline-block;
    padding: 0.35rem 0.85rem;
    border-radius: 9999px;
    font-size: 0.82rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin-top: 0.4rem;
    background: #ecfdf5;
    color: #047857;
    border: 1px solid #a7f3d0;
}
html.dark-mode .fin-badge-fiscal {
    background: #064e3b35;
    color: #34d399;
    border-color: #065f46;
}

/* KPI Summary Ribbon */
.fin-kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem;
    margin: 1.75rem 0;
}
.fin-kpi-card {
    padding: 1.25rem;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    background: #f8fafc;
    position: relative;
    overflow: hidden;
    transition: transform 0.2s ease;
}
html.dark-mode .fin-kpi-card {
    background: #171a2a;
    border-color: #2a314b;
}
.fin-kpi-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    width: 4px;
}
.fin-kpi-profit::before { background: #10b981; }
.fin-kpi-expense::before { background: #ef4444; }
.fin-kpi-net::before { background: #3b82f6; }
.fin-kpi-margin::before { background: #8b5cf6; }

.fin-kpi-label {
    font-size: 0.76rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #64748b;
    margin-bottom: 0.35rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.fin-kpi-val {
    font-size: 1.45rem;
    font-weight: 800;
    letter-spacing: -0.02em;
    color: #0f172a;
    line-height: 1.2;
}
html.dark-mode .fin-kpi-val { color: #f8fafc; }
.fin-kpi-sub {
    font-size: 0.72rem;
    color: #64748b;
    margin-top: 0.35rem;
}

/* Category Breakdown Comparative Cards */
.fin-breakdown-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.25rem;
    margin-bottom: 2rem;
}
@media (max-width: 768px) {
    .fin-breakdown-row { grid-template-columns: 1fr; }
}
.fin-breakdown-card {
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 1.25rem;
    background: #ffffff;
}
html.dark-mode .fin-breakdown-card {
    background: #171a2a;
    border-color: #2a314b;
}
.fin-breakdown-title {
    font-size: 0.95rem;
    font-weight: 800;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-bottom: 0.5rem;
    border-bottom: 1px dashed #e2e8f0;
}
html.dark-mode .fin-breakdown-title { border-bottom-color: #2a314b; }

.fin-cat-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    margin-bottom: 0.75rem;
}
.fin-cat-header {
    display: flex;
    justify-content: space-between;
    font-size: 0.84rem;
    font-weight: 700;
}
.fin-progress-bar-wrap {
    height: 6px;
    background: #e2e8f0;
    border-radius: 9999px;
    overflow: hidden;
}
html.dark-mode .fin-progress-bar-wrap { background: #2a314b; }
.fin-progress-bar-fill {
    height: 100%;
    border-radius: 9999px;
    transition: width 0.5s ease;
}

/* Transaction Ledger Table */
.fin-table-wrap {
    overflow-x: auto;
    margin: 1.5rem 0;
}
.fin-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.88rem;
}
.fin-table th {
    background: #0f172a;
    color: #ffffff;
    font-weight: 800;
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 0.75rem 1rem;
    border: 1px solid #0f172a;
}
html.dark-mode .fin-table th {
    background: #111422;
    border-color: #272d45;
}
.fin-table td {
    padding: 0.75rem 1rem;
    border: 1px solid #cbd5e1;
    vertical-align: middle;
}
html.dark-mode .fin-table td { border-color: #2c334b; }
.fin-table tbody tr:nth-child(even) { background: #f8fafc; }
html.dark-mode .fin-table tbody tr:nth-child(even) { background: #171a2a; }

.fin-badge-type {
    display: inline-block;
    padding: 0.2rem 0.6rem;
    border-radius: 6px;
    font-size: 0.72rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.fin-badge-profit  { background: #dcfce7; color: #15803d; }
.fin-badge-expense { background: #fee2e2; color: #b91c1c; }

.fin-total-row td {
    background: #f0fdf4 !important;
    font-weight: 800;
    font-size: 1.05rem;
    border-top: 2px solid #10b981;
}
html.dark-mode .fin-total-row td {
    background: #064e3b30 !important;
    color: #34d399;
}

/* Executive Signatures */
.fin-signatures {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
    margin-top: 2.5rem;
    padding-top: 1.5rem;
    border-top: 1px dashed #cbd5e1;
}
html.dark-mode .fin-signatures { border-top-color: #2e354f; }
.fin-sig-box {
    text-align: center;
}
.fin-sig-line {
    border-bottom: 1.5px solid #0f172a;
    height: 50px;
    margin-bottom: 0.5rem;
}
html.dark-mode .fin-sig-line { border-bottom-color: #cbd5e1; }
.fin-sig-title {
    font-size: 0.82rem;
    font-weight: 800;
    color: #0f172a;
    display: block;
}
html.dark-mode .fin-sig-title { color: #f8fafc; }
.fin-sig-sub {
    font-size: 0.72rem;
    color: #64748b;
}

.fin-disclaimer {
    font-size: 0.75rem;
    color: #64748b;
    border-top: 1px solid #e2e8f0;
    padding-top: 1rem;
    margin-top: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.5rem;
}

/* ══════════════════════════════════════════════════════════════════
   PRINT MEDIA STYLES (A4 Portrait Financial Report)
══════════════════════════════════════════════════════════════════ */
@media print {
    @page {
        size: A4 portrait;
        margin: 8mm 10mm;
    }
    html, body {
        background: #ffffff !important;
        color: #000000 !important;
        font-size: 10px !important;
        margin: 0 !important;
        padding: 0 !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
    .main-header, 
    .main-sidebar, 
    .main-footer, 
    .fin-action-bar, 
    .navbar, 
    .sidebar, 
    #systemPreloader, 
    .system-preloader, 
    .overlay, 
    #contentOverlay,
    .content-header,
    .dataTables_filter,
    .dataTables_length,
    .dataTables_paginate,
    .dataTables_info,
    .floating-button,
    .btn-edit,
    .btn-group,
    th:last-child,
    td:last-child {
        display: none !important;
    }
    .content-wrapper, .wrapper, section.content {
        margin: 0 !important;
        padding: 0 !important;
        background: transparent !important;
        min-height: auto !important;
        display: block !important;
    }
    .fin-screen-wrap {
        display: block !important;
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .fin-report-card {
        display: block !important;
        border: 1.5px solid #000000 !important;
        box-shadow: none !important;
        border-radius: 0 !important;
        padding: 12px !important;
        margin-bottom: 0 !important;
    }
    .fin-header {
        border-bottom: 1.5px solid #000000 !important;
        padding-bottom: 10px !important;
    }
    .fin-logo {
        width: 55px !important;
        height: 55px !important;
        border-radius: 6px !important;
        border: 1px solid #000000 !important;
    }
    .fin-kpi-card {
        border: 1px solid #000000 !important;
        background: #ffffff !important;
        padding: 8px 10px !important;
    }
    .fin-breakdown-card {
        border: 1px solid #000000 !important;
        background: #ffffff !important;
        padding: 8px 10px !important;
    }
    .fin-table th {
        background: #000000 !important;
        color: #ffffff !important;
        border-color: #000000 !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
    .fin-table td {
        border-color: #64748b !important;
        padding: 5px 8px !important;
    }
    .fin-badge-profit {
        background: #ffffff !important;
        color: #000000 !important;
        border: 1px solid #000000 !important;
    }
    .fin-badge-expense {
        background: #000000 !important;
        color: #ffffff !important;
        border: 1px solid #000000 !important;
    }
    .fin-signatures {
        page-break-inside: avoid !important;
        margin-top: 15px !important;
        padding-top: 10px !important;
    }
}
</style>

<section class="content py-3">
    <div class="fin-screen-wrap">

        {{-- ── Action Toolbar (Screen Only) ─────────────────────────── --}}
        <div class="fin-action-bar">
            <div class="d-flex align-items-center flex-wrap" style="gap: 0.75rem;">
                <a href="{{ route('accounting.index') }}" class="fin-btn fin-btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    <span>{{ __('Back to Accounting') }}</span>
                </a>
                <div class="d-flex align-items-center" style="gap: 0.4rem;">
                    <label for="year-filter" class="mb-0 font-weight-bold text-muted small">{{ __('Fiscal Year:') }}</label>
                    <select id="year-filter" class="form-control form-control-sm font-weight-bold" style="width: 110px; border-radius: 8px;">
                        @foreach( $years as $year)
                            <option value="{{ $year }}" {{ (int)$selectedYear === (int)$year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="d-flex align-items-center flex-wrap" style="gap: 0.6rem;">
                <button type="button" class="fin-btn fin-btn-primary" onclick="printFinancialReport()">
                    <i class="fas fa-print"></i>
                    <span>{{ __('Print Financial Report') }}</span>
                </button>
                @if (Auth::user()->role == 0 || Auth::user()->role == 3)
                <button type="button" class="fin-btn fin-btn-secondary" data-toggle="modal" data-target="#createTransactionModal">
                    <i class="fas fa-plus-circle text-primary"></i>
                    <span>{{ __('Add Transaction') }}</span>
                </button>
                @endif
            </div>
        </div>

        {{-- ── Executive Financial Report Card ──────────────────────── --}}
        <div class="fin-report-card">

            {{-- 1. Official Header --}}
            <div class="fin-header">
                <div class="fin-brand">
                    <img src="{{ $logoUrl }}" alt="{{ $schoolName }} Logo" class="fin-logo">
                    <div class="fin-school-details">
                        <h2>{{ $schoolName }}</h2>
                        <p><i class="fas fa-map-marker-alt mr-1"></i>{{ $schoolAddress }}</p>
                        <p><i class="fas fa-phone mr-1"></i>{{ $schoolPhone }} · <i class="fas fa-envelope mr-1"></i>{{ $schoolEmail }}</p>
                    </div>
                </div>
                <div class="fin-doc-title-box">
                    <h3 class="fin-doc-title">{{ __('Financial Statement') }}</h3>
                    <div style="font-size:0.84rem; font-weight:700; color:#64748b; margin-top:2px;">
                        {{ __('Statement of Profits & Expenses') }}
                    </div>
                    <span class="fin-badge-fiscal">
                        ● {{ __('Fiscal Year') }} <span id="kpi-year-badge">{{ $selectedYear }}</span>
                    </span>
                </div>
            </div>

            {{-- 2. Executive KPI Ribbon --}}
            <div class="fin-kpi-grid">
                <div class="fin-kpi-card fin-kpi-profit">
                    <div class="fin-kpi-label">
                        <span>{{ __('Total Revenues (Profits)') }}</span>
                        <i class="fas fa-arrow-trend-up text-success"></i>
                    </div>
                    <div class="fin-kpi-val text-success" id="kpi-total-profit">${{ number_format($totalProfit, 2) }}</div>
                    <div class="fin-kpi-sub">{{ __('Total inflow from tuition, fees & operations') }}</div>
                </div>

                <div class="fin-kpi-card fin-kpi-expense">
                    <div class="fin-kpi-label">
                        <span>{{ __('Total Expenditures') }}</span>
                        <i class="fas fa-arrow-trend-down text-danger"></i>
                    </div>
                    <div class="fin-kpi-val text-danger" id="kpi-total-expense">${{ number_format($totalExpense, 2) }}</div>
                    <div class="fin-kpi-sub">{{ __('Salaries, utilities, labs & maintenance') }}</div>
                </div>

                <div class="fin-kpi-card fin-kpi-net">
                    <div class="fin-kpi-label">
                        <span id="kpi-net-label">{{ $netBalance >= 0 ? __('Net Operating Surplus') : __('Net Operating Deficit') }}</span>
                        <i class="fas fa-scale-balanced text-primary"></i>
                    </div>
                    <div class="fin-kpi-val {{ $netBalance >= 0 ? 'text-primary' : 'text-danger' }}" id="kpi-net-balance">
                        ${{ number_format($netBalance, 2) }}
                    </div>
                    <div class="fin-kpi-sub" id="kpi-net-desc">{{ $netBalance >= 0 ? __('Surplus retained for operations') : __('Deficit requiring adjustment') }}</div>
                </div>

                <div class="fin-kpi-card fin-kpi-margin">
                    <div class="fin-kpi-label">
                        <span>{{ __('Profitability Margin') }}</span>
                        <i class="fas fa-percent text-purple"></i>
                    </div>
                    <div class="fin-kpi-val" id="kpi-profit-margin" style="color: #8b5cf6;">
                        {{ $profitMargin }}%
                    </div>
                    <div class="fin-kpi-sub">{{ __('Net operating return on revenue') }}</div>
                </div>
            </div>

            {{-- 3. Category Breakdown (Revenues vs Expenditures) --}}
            <div class="fin-breakdown-row" id="breakdownSection">
                <!-- Revenue Breakdown -->
                <div class="fin-breakdown-card">
                    <div class="fin-breakdown-title text-success">
                        <span><i class="fas fa-circle-dot mr-1"></i> {{ __('Revenues by Category') }}</span>
                        <span class="badge badge-success px-2 py-1" id="breakdown-profit-sum">${{ number_format($totalProfit, 2) }}</span>
                    </div>
                    <div id="profit-category-list">
                        @forelse($profitByCategory as $cat => $amt)
                            @php
                                $pct = $totalProfit > 0 ? round(($amt / $totalProfit) * 100, 1) : 0;
                            @endphp
                            <div class="fin-cat-item">
                                <div class="fin-cat-header">
                                    <span>{{ $cat }}</span>
                                    <span class="text-success font-weight-bold">${{ number_format($amt, 2) }} <small class="text-muted">({{ $pct }}%)</small></span>
                                </div>
                                <div class="fin-progress-bar-wrap">
                                    <div class="fin-progress-bar-fill bg-success" style="width: {{ $pct }}%;"></div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted small mb-0">{{ __('No profit records logged for this fiscal year.') }}</p>
                        @endforelse
                    </div>
                </div>

                <!-- Expense Breakdown -->
                <div class="fin-breakdown-card">
                    <div class="fin-breakdown-title text-danger">
                        <span><i class="fas fa-circle-dot mr-1"></i> {{ __('Expenditures by Category') }}</span>
                        <span class="badge badge-danger px-2 py-1" id="breakdown-expense-sum">${{ number_format($totalExpense, 2) }}</span>
                    </div>
                    <div id="expense-category-list">
                        @forelse($expenseByCategory as $cat => $amt)
                            @php
                                $pct = $totalExpense > 0 ? round(($amt / $totalExpense) * 100, 1) : 0;
                            @endphp
                            <div class="fin-cat-item">
                                <div class="fin-cat-header">
                                    <span>{{ $cat }}</span>
                                    <span class="text-danger font-weight-bold">${{ number_format($amt, 2) }} <small class="text-muted">({{ $pct }}%)</small></span>
                                </div>
                                <div class="fin-progress-bar-wrap">
                                    <div class="fin-progress-bar-fill bg-danger" style="width: {{ $pct }}%;"></div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted small mb-0">{{ __('No expense records logged for this fiscal year.') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- 4. Itemized Transaction Ledger Table --}}
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="font-weight-bold mb-0 text-dark">
                    <i class="fas fa-book-open mr-1 text-primary"></i> {{ __('Itemized Financial Ledger') }}
                </h5>
                <span class="text-muted small">
                    {{ __('Fiscal Period') }}: <strong id="ledgerYearSub">{{ $selectedYear }}</strong>
                </span>
            </div>

            <div class="fin-table-wrap">
                <table id="Profitdata" class="fin-table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 14%;">{{ __('Date') }}</th>
                            <th style="width: 12%;">{{ __('Type') }}</th>
                            <th style="width: 22%;">{{ __('Category') }}</th>
                            <th style="width: 25%;">{{ __('Description / Note') }}</th>
                            <th style="width: 12%; text-align: right;">{{ __('Amount ($)') }}</th>
                            <th style="width: 10%; text-align: center;">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody id="TableBody">
                        {{-- DataTables Ajax Populates Rows --}}
                    </tbody>
                    <tfoot>
                        <tr class="fin-total-row">
                            <td colspan="4" style="text-align: right;">{{ __('Total Net Margin:') }}</td>
                            <td id="tfoot-net-desc" style="font-weight: 700;">{{ $netBalance >= 0 ? __('Operating Surplus') : __('Operating Deficit') }}</td>
                            <td id="tfoot-net-amt" style="text-align: right; font-weight: 800; font-size: 1.05rem;">
                                ${{ number_format($netBalance, 2) }}
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {{-- 5. Executive Signatures Block --}}
            <div class="fin-signatures">
                <div class="fin-sig-box">
                    <div class="fin-sig-line"></div>
                    <span class="fin-sig-title">{{ __('Bursar / Senior Accountant') }}</span>
                    <span class="fin-sig-sub">{{ __('Prepared & Reconciled') }}</span>
                </div>
                <div class="fin-sig-box">
                    <div class="fin-sig-line"></div>
                    <span class="fin-sig-title">{{ __('Director of Finance') }}</span>
                    <span class="fin-sig-sub">{{ __('Verified & Audited') }}</span>
                </div>
                <div class="fin-sig-box">
                    <div class="fin-sig-line"></div>
                    <span class="fin-sig-title">{{ __('School Administrator / Principal') }}</span>
                    <span class="fin-sig-sub">{{ __('Official Authorization') }}</span>
                </div>
            </div>

            {{-- 6. Report Disclaimer / Certification --}}
            <div class="fin-disclaimer">
                <span>
                    <i class="fas fa-shield-alt mr-1 text-success"></i>
                    {{ __('Official Certified Statement. Generated automatically from School Accounting Database.') }}
                </span>
                <span>
                    {{ __('Generated on:') }} {{ date('F d, Y · h:i A') }}
                </span>
            </div>

        </div>

    </div>
</section>

{{-- ── Transaction Add Modal ────────────────────────────────────── --}}
<div class="modal fade" id="createTransactionModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf
            <div class="modal-content" style="border-radius: 16px; overflow: hidden; border: none;">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold" id="createModalLabel">
                        <i class="fas fa-plus-circle mr-1"></i> {{ __('Add New Transaction') }}
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body p-4">
                    <div class="form-group">
                        <label for="type" class="font-weight-bold text-dark">{{ __('Transaction Type') }} <span class="text-danger">*</span></label>
                        <select name="type" class="form-control" required style="border-radius: 8px;">
                            <option value="">-- {{ __('Select Type') }} --</option>
                            <option value="profit">{{ __('Profit / Revenue (Inflow)') }}</option>
                            <option value="expense">{{ __('Expense (Outflow)') }}</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="category" class="font-weight-bold text-dark">{{ __('Category') }} <span class="text-danger">*</span></label>
                        <input type="text" name="category" class="form-control" placeholder="e.g. Tuition Fees, Salaries, Utilities" required style="border-radius: 8px;">
                    </div>

                    <div class="form-group">
                        <label for="date" class="font-weight-bold text-dark">{{ __('Date') }} <span class="text-danger">*</span></label>
                        <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required style="border-radius: 8px;">
                    </div>

                    <div class="form-group">
                        <label for="amount" class="font-weight-bold text-dark">{{ __('Amount ($ USD)') }} <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" name="amount" class="form-control" placeholder="0.00" required style="border-radius: 8px;">
                    </div>

                    <div class="form-group mb-0">
                        <label for="note" class="font-weight-bold text-dark">{{ __('Description / Note') }}</label>
                        <textarea name="note" class="form-control" rows="2" placeholder="Optional details..." style="border-radius: 8px;"></textarea>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-success font-weight-bold px-4">
                        <i class="fas fa-check mr-1"></i> {{ __('Save Transaction') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ── Transaction Edit Modal ───────────────────────────────────── --}}
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content" style="border-radius: 16px; overflow: hidden; border: none;">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title font-weight-bold" id="editModalLabel">
                        <i class="fas fa-edit mr-1"></i> {{ __('Edit Transaction') }}
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body p-4">
                    <input type="hidden" name="id" id="edit-id">

                    <div class="form-group">
                        <label class="font-weight-bold text-dark">{{ __('Transaction Type') }} <span class="text-danger">*</span></label>
                        <select name="type" id="edit-type" class="form-control" required style="border-radius: 8px;">
                            <option value="profit">{{ __('Profit / Revenue (Inflow)') }}</option>
                            <option value="expense">{{ __('Expense (Outflow)') }}</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold text-dark">{{ __('Category') }} <span class="text-danger">*</span></label>
                        <input type="text" name="category" id="edit-category" class="form-control" required style="border-radius: 8px;">
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold text-dark">{{ __('Date') }} <span class="text-danger">*</span></label>
                        <input type="date" name="date" id="edit-date" class="form-control" required style="border-radius: 8px;">
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold text-dark">{{ __('Amount ($ USD)') }} <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" name="amount" id="edit-amount" class="form-control" required style="border-radius: 8px;">
                    </div>

                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark">{{ __('Description / Note') }}</label>
                        <textarea name="note" id="edit-note" class="form-control" rows="2" style="border-radius: 8px;"></textarea>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary font-weight-bold px-4">
                        <i class="fas fa-save mr-1"></i> {{ __('Update Transaction') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Print Financial Report with auto-suggested filename
    function printFinancialReport() {
        var originalTitle = document.title;
        var selectedYear = $('#year-filter').val() || '{{ $selectedYear }}';
        var printFilename = 'FinancialReport_' + selectedYear;
        document.title = printFilename;
        window.print();
        window.addEventListener('afterprint', function onAfterPrint() {
            document.title = originalTitle;
            window.removeEventListener('afterprint', onAfterPrint);
        }, { once: true });
        setTimeout(function() {
            document.title = originalTitle;
        }, 3000);
    }

    $(document).ready(function () {
        const table = $('#Profitdata').DataTable({
            responsive: true,
            lengthChange: true,
            autoWidth: false,
            searching: true,
            ordering: true,
            info: true,
            paging: true,
            pageLength: 15,
            ajax: {
                url: `/transaction/data?year=${$('#year-filter').val()}`,
                dataSrc: function(json) {
                    // Update KPI and breakdown dynamically if summary is returned
                    if (json.summary) {
                        updateReportSummary(json.summary);
                    }
                    return json.transactions || [];
                }
            },
            columns: [
                { data: null, render: (data, type, row, meta) => meta.row + 1 },
                { data: 'date', render: data => `<strong>${data}</strong>` },
                { 
                    data: 'type', 
                    render: data => {
                        if (data === 'profit') {
                            return `<span class="fin-badge-type fin-badge-profit"><i class="fas fa-arrow-up mr-1"></i>Profit</span>`;
                        } else {
                            return `<span class="fin-badge-type fin-badge-expense"><i class="fas fa-arrow-down mr-1"></i>Expense</span>`;
                        }
                    }
                },
                { data: 'category', render: data => `<span class="font-weight-bold">${data}</span>` },
                { data: 'note', render: data => data ? data : `<span class="text-muted font-italic">-</span>` },
                { 
                    data: 'amount', 
                    render: (data, type, row) => {
                        const formatted = parseFloat(data).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                        if (row.type === 'profit') {
                            return `<span class="font-weight-bold text-success" style="font-size:0.95rem;">+$${formatted}</span>`;
                        } else {
                            return `<span class="font-weight-bold text-danger" style="font-size:0.95rem;">-$${formatted}</span>`;
                        }
                    },
                    className: 'text-right'
                },
                {
                    data: null,
                    className: 'text-center',
                    render: (data, type, row) => `
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right shadow-sm" role="menu">
                                <button class="dropdown-item text-primary btn-edit"
                                    data-id="${row.id}"
                                    data-type="${row.type}"
                                    data-category="${row.category}"
                                    data-date="${row.date}"
                                    data-amount="${row.amount}"
                                    data-note="${row.note || ''}"
                                ><i class="fas fa-edit mr-2"></i> {{ __('Edit') }}</button>
                                <div class="dropdown-divider"></div>
                                <form action="/transaction/delete/${row.id}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this transaction?') }}');" style="display:inline;">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="dropdown-item text-danger"><i class="fas fa-trash mr-2"></i> {{ __('Delete') }}</button>
                                </form>
                            </div>
                        </div>
                    `
                }
            ]
        });

        // Function to update dynamic summary elements
        function updateReportSummary(summary) {
            const formatMoney = num => '$' + parseFloat(num).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

            $('#kpi-year-badge').text(summary.year);
            $('#ledgerYearSub').text(summary.year);
            $('#kpi-total-profit').text(formatMoney(summary.total_profit));
            $('#kpi-total-expense').text(formatMoney(summary.total_expense));
            
            const net = parseFloat(summary.net_balance);
            const netElem = $('#kpi-net-balance');
            netElem.text(formatMoney(net));
            if (net >= 0) {
                netElem.removeClass('text-danger').addClass('text-primary');
                $('#kpi-net-label').text('{{ __("Net Operating Surplus") }}');
                $('#kpi-net-desc').text('{{ __("Surplus retained for operations") }}');
                $('#tfoot-net-desc').text('{{ __("Operating Surplus") }}');
            } else {
                netElem.removeClass('text-primary').addClass('text-danger');
                $('#kpi-net-label').text('{{ __("Net Operating Deficit") }}');
                $('#kpi-net-desc').text('{{ __("Deficit requiring adjustment") }}');
                $('#tfoot-net-desc').text('{{ __("Operating Deficit") }}');
            }

            $('#tfoot-net-amt').text(formatMoney(net));
            $('#kpi-profit-margin').text(summary.profit_margin + '%');
            $('#breakdown-profit-sum').text(formatMoney(summary.total_profit));
            $('#breakdown-expense-sum').text(formatMoney(summary.total_expense));

            // Render dynamic profit breakdown
            let profitHtml = '';
            const profitCats = summary.profit_by_category || {};
            const totalP = parseFloat(summary.total_profit) || 1;
            const pKeys = Object.keys(profitCats);
            if (pKeys.length === 0) {
                profitHtml = '<p class="text-muted small mb-0">{{ __("No profit records logged for this fiscal year.") }}</p>';
            } else {
                pKeys.forEach(cat => {
                    const amt = profitCats[cat];
                    const pct = totalP > 0 ? ((amt / totalP) * 100).toFixed(1) : 0;
                    profitHtml += `
                        <div class="fin-cat-item">
                            <div class="fin-cat-header">
                                <span>${cat}</span>
                                <span class="text-success font-weight-bold">${formatMoney(amt)} <small class="text-muted">(${pct}%)</small></span>
                            </div>
                            <div class="fin-progress-bar-wrap">
                                <div class="fin-progress-bar-fill bg-success" style="width: ${pct}%;"></div>
                            </div>
                        </div>
                    `;
                });
            }
            $('#profit-category-list').html(profitHtml);

            // Render dynamic expense breakdown
            let expenseHtml = '';
            const expenseCats = summary.expense_by_category || {};
            const totalE = parseFloat(summary.total_expense) || 1;
            const eKeys = Object.keys(expenseCats);
            if (eKeys.length === 0) {
                expenseHtml = '<p class="text-muted small mb-0">{{ __("No expense records logged for this fiscal year.") }}</p>';
            } else {
                eKeys.forEach(cat => {
                    const amt = expenseCats[cat];
                    const pct = totalE > 0 ? ((amt / totalE) * 100).toFixed(1) : 0;
                    expenseHtml += `
                        <div class="fin-cat-item">
                            <div class="fin-cat-header">
                                <span>${cat}</span>
                                <span class="text-danger font-weight-bold">${formatMoney(amt)} <small class="text-muted">(${pct}%)</small></span>
                            </div>
                            <div class="fin-progress-bar-wrap">
                                <div class="fin-progress-bar-fill bg-danger" style="width: ${pct}%;"></div>
                            </div>
                        </div>
                    `;
                });
            }
            $('#expense-category-list').html(expenseHtml);
        }

        // Filter on Year Change
        $('#year-filter').on('change', function () {
            const selectedYear = $(this).val();
            table.ajax.url(`/transaction/data?year=${selectedYear}`).load();
        });

        // Edit Button Handler
        $(document).on('click', '.btn-edit', function () {
            const button = $(this);
            $('#edit-id').val(button.data('id'));
            $('#edit-type').val(button.data('type'));
            $('#edit-category').val(button.data('category'));
            $('#edit-date').val(button.data('date'));
            $('#edit-amount').val(button.data('amount'));
            $('#edit-note').val(button.data('note'));
            $('#editForm').attr('action', `/transaction/update/${button.data('id')}`);
            $('#editModal').modal('show');
        });
    });
</script>

@endsection
