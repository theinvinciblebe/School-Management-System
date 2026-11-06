@extends('layout.main')

@section('content')

@php
    $brandLogo = $customizes->brand_logo ?? null;
    $logoUrl = (!empty($brandLogo) && file_exists(public_path('customize_images/' . $brandLogo)))
        ? asset('customize_images/' . $brandLogo)
        : (file_exists(public_path('logo-final.png'))
            ? asset('logo-final.png')
            : (file_exists(public_path('customize_images/noimg.jpg'))
                ? asset('customize_images/noimg.jpg')
                : asset('assets/dist/img/mawaridLogo.jpg')));

    $schoolName    = $customizes->brand_title ?? 'School System';
    $schoolAddress = $customizes->school_address ?? 'No.32, Street 606, Tuol Kork, Phnom Penh, Cambodia';
    $schoolPhone   = $customizes->school_phone ?? '+855 12 801 470 / +855 71 220 6315';
    $schoolEmail   = $customizes->school_email ?? 'info@schoolsystem.edu.kh';
@endphp

<style>
/* ══════════════════════════════════════════════════════════════════
   PURCHASE REQUISITION VOUCHER – Modern Screen & Print Layout
══════════════════════════════════════════════════════════════════ */

.pr-screen-wrap {
    max-width: 980px;
    margin: 1.5rem auto 4rem;
    padding: 0 1rem;
}

/* Action Toolbar (Screen Only) */
.pr-action-bar {
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
html.dark-mode .pr-action-bar {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 25px -2px rgba(0, 0, 0, 0.35);
}

.pr-btn {
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
.pr-btn-primary {
    background: linear-gradient(135deg, #0ea5e9, #0284c7);
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
}
.pr-btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(14, 165, 233, 0.4);
}
.pr-btn-secondary {
    background: #f1f5f9;
    color: #475569 !important;
    border: 1px solid #cbd5e1;
}
.pr-btn-secondary:hover { background: #e2e8f0; }
html.dark-mode .pr-btn-secondary {
    background: #252c42;
    border-color: #333d5d;
    color: #cbd5e1 !important;
}

/* Document Voucher Card */
.pr-voucher-card {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 20px;
    padding: 2.25rem;
    box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.08);
    color: #0f172a;
    position: relative;
}
html.dark-mode .pr-voucher-card {
    background: #1e2235;
    border-color: #2e354f;
    color: #f8fafc;
}

/* Voucher Header */
.pr-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 2px solid #e2e8f0;
}
html.dark-mode .pr-header { border-bottom-color: #2e354f; }
.pr-brand {
    display: flex;
    align-items: center;
    gap: 1.25rem;
}
.pr-logo {
    width: 72px;
    height: 72px;
    border-radius: 14px;
    object-fit: cover;
    border: 1px solid #cbd5e1;
}
.pr-school-details h2 {
    font-size: 1.45rem;
    font-weight: 800;
    margin: 0;
    color: #0f172a;
    letter-spacing: -0.01em;
}
html.dark-mode .pr-school-details h2 { color: #f8fafc; }
.pr-school-details p {
    font-size: 0.82rem;
    color: #64748b;
    margin: 0.2rem 0 0;
}
html.dark-mode .pr-school-details p { color: #94a3b8; }

.pr-doc-title-box {
    text-align: right;
}
.pr-doc-title {
    font-size: 1.15rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #0ea5e9;
    margin: 0;
}
.pr-badge-status {
    display: inline-block;
    padding: 0.35rem 0.85rem;
    border-radius: 9999px;
    font-size: 0.78rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin-top: 0.4rem;
}
.pr-status-approved { background: #dcfce7; color: #15803d; }
.pr-status-pending  { background: #fef3c7; color: #b45309; }
.pr-status-rejected { background: #fee2e2; color: #b91c1c; }

/* Metadata Grid */
.pr-meta-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin: 1.5rem 0;
    padding: 1.25rem;
    background: #f8fafc;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
}
html.dark-mode .pr-meta-grid {
    background: #171a2a;
    border-color: #2a314b;
}
.pr-meta-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}
.pr-meta-lbl {
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #64748b;
}
.pr-meta-val {
    font-size: 0.92rem;
    font-weight: 700;
    color: #0f172a;
}
html.dark-mode .pr-meta-val { color: #f8fafc; }

/* Items Table */
.pr-table-wrap {
    overflow-x: auto;
    margin: 1.5rem 0;
}
.pr-items-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.88rem;
}
.pr-items-table th {
    background: #0f172a;
    color: #ffffff;
    font-weight: 800;
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 0.75rem 1rem;
    border: 1px solid #0f172a;
}
html.dark-mode .pr-items-table th {
    background: #111422;
    border-color: #272d45;
}
.pr-items-table td {
    padding: 0.75rem 1rem;
    border: 1px solid #cbd5e1;
    vertical-align: middle;
}
html.dark-mode .pr-items-table td {
    border-color: #2c334b;
}
.pr-items-table tbody tr:nth-child(even) {
    background: #f8fafc;
}
html.dark-mode .pr-items-table tbody tr:nth-child(even) {
    background: #171a2a;
}
.pr-grand-total-row td {
    background: #f0fdf4 !important;
    font-weight: 800;
    font-size: 1.05rem;
    color: #15803d;
    border-top: 2px solid #10b981;
}
html.dark-mode .pr-grand-total-row td {
    background: #064e3b30 !important;
    color: #34d399;
}

/* Signatures */
.pr-signatures {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e2e8f0;
    text-align: center;
}
html.dark-mode .pr-signatures { border-top-color: #2e354f; }
.pr-sig-box {
    display: flex;
    flex-direction: column;
    align-items: center;
}
.pr-sig-line {
    width: 180px;
    border-top: 1.5px dashed #64748b;
    margin-bottom: 0.5rem;
}
.pr-sig-title {
    font-size: 0.8rem;
    font-weight: 700;
    color: #334155;
}
html.dark-mode .pr-sig-title { color: #cbd5e1; }
.pr-sig-sub {
    font-size: 0.72rem;
    color: #64748b;
}

/* Print Styles */
@media print {
    @page {
        size: A4 portrait;
        margin: 12mm;
    }
    html, body {
        background: #ffffff !important;
        color: #000000 !important;
        font-size: 11px !important;
        margin: 0 !important;
        padding: 0 !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
    .main-header, .main-sidebar, .main-footer, .pr-action-bar, .content-header {
        display: none !important;
    }
    .content-wrapper {
        margin: 0 !important;
        padding: 0 !important;
        background: transparent !important;
    }
    .pr-screen-wrap {
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .pr-voucher-card {
        border: 1.5px solid #000000 !important;
        box-shadow: none !important;
        border-radius: 0 !important;
        padding: 15px !important;
    }
    .pr-items-table th {
        background: #000000 !important;
        color: #ffffff !important;
        border-color: #000000 !important;
    }
}
</style>

<div class="content-header pb-0">
    <div class="pr-screen-wrap">

        {{-- ── Action Toolbar (Screen Only) ─────────────────────────── --}}
        <div class="pr-action-bar">
            <div class="d-flex align-items-center" style="gap: 0.75rem;">
                <a href="{{ route('purchase_req.index') }}" class="pr-btn pr-btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    <span>{{ __('Back to Requests') }}</span>
                </a>
                <span class="badge badge-pill badge-info px-3 py-2" style="font-size:0.85rem;">
                    <i class="fas fa-file-invoice mr-1"></i> {{ __('Req #') }}{{ $purchase->request_no }}
                </span>
            </div>
            <div class="d-flex align-items-center" style="gap: 0.6rem;">
                <button type="button" class="pr-btn pr-btn-primary" onclick="window.print()">
                    <i class="fas fa-print"></i>
                    <span>{{ __('Print Voucher') }}</span>
                </button>
            </div>
        </div>

        {{-- ── Document Voucher ─────────────────────────────────────── --}}
        <div class="pr-voucher-card">
            <div class="pr-header">
                <div class="pr-brand">
                    <img src="{{ $logoUrl }}" alt="{{ $schoolName }} Logo" class="pr-logo">
                    <div class="pr-school-details">
                        <h2>{{ $schoolName }}</h2>
                        <p><i class="fas fa-map-marker-alt mr-1"></i>{{ $schoolAddress }}</p>
                        <p><i class="fas fa-phone mr-1"></i>{{ $schoolPhone }} · <i class="fas fa-envelope mr-1"></i>{{ $schoolEmail }}</p>
                    </div>
                </div>
                <div class="pr-doc-title-box">
                    <h3 class="pr-doc-title">{{ __('Purchase Requisition') }}</h3>
                    <div style="font-size:0.82rem; font-weight:700; color:#64748b; margin-top:2px;">
                        NO: {{ $purchase->request_no }}
                    </div>
                    @php
                        $statusClass = match($purchase->status ?? 'pending') {
                            'approved' => 'pr-status-approved',
                            'rejected' => 'pr-status-rejected',
                            default    => 'pr-status-pending',
                        };
                    @endphp
                    <span class="pr-badge-status {{ $statusClass }}">
                        ● {{ ucfirst($purchase->status ?? 'Pending') }}
                    </span>
                </div>
            </div>

            {{-- Metadata Grid --}}
            <div class="pr-meta-grid">
                <div class="pr-meta-item">
                    <span class="pr-meta-lbl">{{ __('Requisitioner') }}</span>
                    <span class="pr-meta-val">{{ $purchase->requisitioner }}</span>
                </div>
                <div class="pr-meta-item">
                    <span class="pr-meta-lbl">{{ __('Department') }}</span>
                    <span class="pr-meta-val">{{ $purchase->department ?? 'General' }}</span>
                </div>
                <div class="pr-meta-item">
                    <span class="pr-meta-lbl">{{ __('Date Prepared') }}</span>
                    <span class="pr-meta-val">{{ date('M d, Y', strtotime($purchase->date_prepared)) }}</span>
                </div>
                <div class="pr-meta-item">
                    <span class="pr-meta-lbl">{{ __('Date Needed') }}</span>
                    <span class="pr-meta-val">{{ !empty($purchase->date_needed) ? date('M d, Y', strtotime($purchase->date_needed)) : 'As Soon As Possible' }}</span>
                </div>
                <div class="pr-meta-item" style="grid-column: 1 / -1;">
                    <span class="pr-meta-lbl">{{ __('Purpose / Justification') }}</span>
                    <span class="pr-meta-val" style="font-weight:500;">{{ $purchase->purpose ?? 'Not specified' }}</span>
                </div>
                @if(!empty($purchase->vendor))
                <div class="pr-meta-item" style="grid-column: 1 / -1;">
                    <span class="pr-meta-lbl">{{ __('Preferred Vendor / Supplier') }}</span>
                    <span class="pr-meta-val">{{ $purchase->vendor }}</span>
                </div>
                @endif
            </div>

            {{-- Items Table --}}
            <div class="pr-table-wrap">
                <table class="pr-items-table">
                    <thead>
                        <tr>
                            <th style="width: 50px; text-align: center;">#</th>
                            <th>{{ __('Item Description & Specifications') }}</th>
                            <th style="width: 90px; text-align: center;">{{ __('Qty') }}</th>
                            <th style="width: 90px; text-align: center;">{{ __('Unit') }}</th>
                            <th style="width: 140px; text-align: right;">{{ __('Unit Price') }}</th>
                            <th style="width: 150px; text-align: right;">{{ __('Total Amount') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $grandTotal = 0; @endphp
                        @forelse ($items as $index => $item)
                            <tr>
                                <td style="text-align: center;">{{ $index + 1 }}</td>
                                <td><strong>{{ $item->description }}</strong></td>
                                <td style="text-align: center;">{{ $item->qty }}</td>
                                <td style="text-align: center;">{{ $item->unit ?? 'Pcs' }}</td>
                                <td style="text-align: right;">${{ number_format($item->unit_price, 2) }}</td>
                                <td style="text-align: right;">${{ number_format($item->total_price, 2) }}</td>
                            </tr>
                            @php $grandTotal += $item->total_price; @endphp
                        @empty
                            <tr>
                                <td colspan="6" style="text-align:center; padding:1.5rem; color:#94a3b8;">
                                    {{ __('No line items recorded.') }}
                                </td>
                            </tr>
                        @endforelse
                        <tr class="pr-grand-total-row">
                            <td colspan="5" style="text-align: right;">{{ __('Grand Total Estimated Amount:') }}</td>
                            <td style="text-align: right;">${{ number_format($grandTotal, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Signatures Section --}}
            <div class="pr-signatures">
                <div class="pr-sig-box">
                    <div class="pr-sig-line"></div>
                    <span class="pr-sig-title">{{ $purchase->requisitioner }}</span>
                    <span class="pr-sig-sub">{{ __('Requisitioner') }}</span>
                </div>
                <div class="pr-sig-box">
                    <div class="pr-sig-line"></div>
                    <span class="pr-sig-title">{{ $purchase->department ?? 'Department Head' }}</span>
                    <span class="pr-sig-sub">{{ __('Department Verified') }}</span>
                </div>
                <div class="pr-sig-box">
                    <div class="pr-sig-line"></div>
                    <span class="pr-sig-title">{{ $purchase->approver_name ?? 'School Administration' }}</span>
                    <span class="pr-sig-sub">{{ __('Authorized Approval') }}</span>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
