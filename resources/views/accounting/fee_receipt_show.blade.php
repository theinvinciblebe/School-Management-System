@extends('layout.main')

@section('title', 'FeeReceipt_' . preg_replace('/[^A-Za-z0-9\-_]/', '', $fees->receipt_no ?? 'Receipt') . '_' . \Illuminate\Support\Str::slug($fees->student_name ?? 'Student'))

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
   FEE RECEIPT – Modern Screen & Print Layout
══════════════════════════════════════════════════════════════════ */

.rc-screen-wrap {
    max-width: 960px;
    margin: 1rem auto 3rem;
    padding: 0 1rem;
}

/* Action Toolbar (Screen Only) */
.rc-action-bar {
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
html.dark-mode .rc-action-bar {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 25px -2px rgba(0, 0, 0, 0.35);
}

.rc-btn {
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
.rc-btn-primary {
    background: linear-gradient(135deg, #4f46e5, #6366f1);
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
}
.rc-btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(79, 70, 229, 0.4);
}
.rc-btn-secondary {
    background: #f1f5f9;
    color: #475569 !important;
    border: 1px solid #cbd5e1;
}
.rc-btn-secondary:hover {
    background: #e2e8f0;
}
html.dark-mode .rc-btn-secondary {
    background: #252c42;
    border-color: #333d5d;
    color: #cbd5e1 !important;
}

/* Receipt Card (Voucher look) */
.rc-voucher {
    background: #ffffff;
    border: 2px solid #312e81;
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 1.75rem;
    box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.08);
    position: relative;
    color: #0f172a;
    page-break-inside: avoid;
}

.rc-voucher-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-bottom: 1rem;
    border-bottom: 2px solid #312e81;
    gap: 1rem;
}
.rc-brand-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}
.rc-logo {
    width: 68px;
    height: 68px;
    border-radius: 12px;
    object-fit: cover;
    border: 1px solid #e2e8f0;
}
.rc-school-info h2 {
    font-size: 1.35rem;
    font-weight: 800;
    margin: 0;
    color: #1e1b4b;
    line-height: 1.2;
}
.rc-school-info p {
    font-size: 0.8rem;
    color: #475569;
    margin: 0.15rem 0 0;
    line-height: 1.35;
}

.rc-voucher-badge-wrap {
    text-align: right;
}
.rc-voucher-badge {
    display: inline-block;
    background: #312e81;
    color: #ffffff;
    font-size: 0.82rem;
    font-weight: 800;
    padding: 0.35rem 0.85rem;
    border-radius: 8px;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}
.rc-copy-label {
    font-size: 0.72rem;
    font-weight: 700;
    color: #64748b;
    margin-top: 0.25rem;
    text-transform: uppercase;
    letter-spacing: 0.06em;
}

/* Info Grid Table */
.rc-info-grid {
    width: 100%;
    margin-top: 1rem;
    border-collapse: collapse;
    font-size: 0.82rem;
}
.rc-info-grid td {
    padding: 0.45rem 0.65rem;
    border: 1px solid #cbd5e1;
    vertical-align: middle;
}
.rc-info-grid .rc-label {
    background: #f8fafc;
    font-weight: 700;
    color: #334155;
    width: 18%;
}
.rc-info-grid .rc-val {
    font-weight: 600;
    color: #0f172a;
    width: 32%;
}

/* Items Table */
.rc-items-table {
    width: 100%;
    margin-top: 1rem;
    border-collapse: collapse;
    font-size: 0.85rem;
}
.rc-items-table th {
    background: #312e81;
    color: #ffffff;
    font-weight: 800;
    font-size: 0.78rem;
    padding: 0.5rem 0.75rem;
    text-align: left;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    border: 1px solid #312e81;
}
.rc-items-table td {
    padding: 0.55rem 0.75rem;
    border: 1px solid #cbd5e1;
}

/* Footer Section */
.rc-footer-wrap {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-top: 1.25rem;
    gap: 1.5rem;
}
.rc-qr-box {
    display: flex;
    align-items: center;
    gap: 0.85rem;
}
.rc-terms-box {
    font-size: 0.72rem;
    color: #64748b;
    line-height: 1.4;
    max-width: 360px;
}
.rc-signatures {
    display: flex;
    gap: 2rem;
    text-align: center;
}
.rc-sig-block {
    width: 140px;
    border-top: 1.5px dashed #475569;
    padding-top: 0.35rem;
    font-size: 0.74rem;
    font-weight: 700;
    color: #334155;
}

/* ══════════════════════════════════════════════════════════════════
   PRINT MEDIA STYLES (Clean A4 Page split into 2 half receipts)
══════════════════════════════════════════════════════════════════ */
@media print {
    @page {
        size: A4 portrait;
        margin: 6mm 8mm;
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
    .main-header, 
    .main-sidebar, 
    .main-footer, 
    .rc-action-bar, 
    .navbar, 
    .sidebar, 
    #systemPreloader, 
    .system-preloader, 
    .overlay, 
    #contentOverlay,
    .content-header {
        display: none !important;
    }
    .content-wrapper, .wrapper, section.content {
        margin: 0 !important;
        padding: 0 !important;
        background: transparent !important;
        min-height: auto !important;
        display: block !important;
    }
    .rc-screen-wrap {
        display: block !important;
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .rc-voucher {
        display: block !important;
        border: 1.5px solid #000000 !important;
        box-shadow: none !important;
        padding: 10px 14px !important;
        margin-bottom: 12px !important;
        border-radius: 8px !important;
        page-break-inside: avoid !important;
    }
    .rc-voucher-header {
        border-bottom: 1.5px solid #000000 !important;
        padding-bottom: 8px !important;
    }
    .rc-voucher-badge {
        background: #000000 !important;
        color: #ffffff !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
    .rc-items-table th {
        background: #000000 !important;
        color: #ffffff !important;
        border-color: #000000 !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
    .rc-info-grid td, .rc-items-table td {
        border-color: #64748b !important;
    }
}
</style>

<section class="content py-3">
    <div class="rc-screen-wrap">

        {{-- ── Action Toolbar (Screen Only) ─────────────────────────── --}}
        <div class="rc-action-bar">
            <div class="d-flex align-items-center" style="gap: 0.75rem;">
                <a href="{{ route('fee_receipt.index') }}" class="rc-btn rc-btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    <span>{{ __('Back to List') }}</span>
                </a>
                <span class="badge badge-pill badge-primary px-3 py-2" style="font-size:0.85rem;">
                    <i class="fas fa-receipt mr-1"></i> {{ __('Receipt') }} #{{ $fees->receipt_no }}
                </span>
            </div>
            <div class="d-flex align-items-center" style="gap: 0.6rem;">
                <button type="button" class="rc-btn rc-btn-primary" onclick="printReceipt()">
                    <i class="fas fa-print"></i>
                    <span>{{ __('Print Receipt') }}</span>
                </button>
                <!-- <a href="{{ route('fee_receipt.pdf', $fees->receipt_id) }}" 
                   download="FeeReceipt_{{ preg_replace('/[^A-Za-z0-9\-_]/', '', $fees->receipt_no ?? 'Receipt') }}_{{ \Illuminate\Support\Str::slug($fees->student_name ?? 'Student') }}.pdf"
                   class="rc-btn rc-btn-secondary" 
                   target="_blank">
                    <i class="fas fa-file-pdf text-danger"></i>
                    <span>{{ __('Download PDF') }}</span>
                </a> -->
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════════
             VOUCHER 1: STUDENT COPY
        ══════════════════════════════════════════════════════════════ --}}
        <div class="rc-voucher">
            <div class="rc-voucher-header">
                <div class="rc-brand-left">
                    <img src="{{ $logoUrl }}" alt="{{ $schoolName }} Logo" class="rc-logo">
                    <div class="rc-school-info">
                        <h2>{{ $schoolName }}</h2>
                        <p><i class="fas fa-map-marker-alt mr-1"></i>{{ $schoolAddress }}</p>
                        <p><i class="fas fa-phone mr-1"></i>{{ $schoolPhone }} · <i class="fas fa-envelope mr-1"></i>{{ $schoolEmail }}</p>
                    </div>
                </div>
                <div class="rc-voucher-badge-wrap">
                    <span class="rc-voucher-badge">{{ __('Official Fee Receipt') }}</span>
                    <div class="rc-copy-label">{{ __('Student Copy') }}</div>
                </div>
            </div>

            {{-- Info Grid --}}
            <table class="rc-info-grid">
                <tr>
                    <td class="rc-label">{{ __('Receipt No.') }}</td>
                    <td class="rc-val"><strong>{{ $fees->receipt_no }}</strong></td>
                    <td class="rc-label">{{ __('Receipt Date') }}</td>
                    <td class="rc-val">{{ date('F d, Y', strtotime($fees->receipt_date)) }}</td>
                </tr>
                <tr>
                    <td class="rc-label">{{ __('Student Name') }}</td>
                    <td class="rc-val"><strong>{{ $fees->student_name }}</strong></td>
                    <td class="rc-label">{{ __('Guardian / Parent') }}</td>
                    <td class="rc-val">{{ $fees->parent_name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="rc-label">{{ __('Class / Grade') }}</td>
                    <td class="rc-val">{{ $fees->class_name }}</td>
                    <td class="rc-label">{{ __('Section / Shift') }}</td>
                    <td class="rc-val">{{ $fees->section_name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="rc-label">{{ __('Roll Number') }}</td>
                    <td class="rc-val">{{ $fees->roll ?? 'N/A' }}</td>
                    <td class="rc-label">{{ __('Payment Mode') }}</td>
                    <td class="rc-val">{{ $fees->paid_via ?? 'Cash' }}</td>
                </tr>
            </table>

            {{-- Fee Breakdown Table --}}
            <table class="rc-items-table">
                <thead>
                    <tr>
                        <th style="width: 50%;">{{ __('Description') }}</th>
                        <th style="text-align:center; width: 15%;">{{ __('Duration') }}</th>
                        <th style="text-align:right; width: 35%;">{{ __('Amount (USD)') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>{{ __('Tuition Fee') }} · {{ $fees->class_name }} ({{ $fees->section_name ?? 'Regular' }})</strong></td>
                        <td style="text-align:center;">{{ $fees->section_duration_months ?? 1 }} {{ __('Months') }}</td>
                        <td style="text-align:right;">${{ number_format($fees->grand_total, 2) }}</td>
                    </tr>
                    @if($fees->remaining_balance != 0)
                    <tr style="background:#fffbeb;">
                        <td colspan="2" style="text-align:right;"><strong>{{ __('Previous Outstanding Balance:') }}</strong></td>
                        <td style="text-align:right; color:#b45309;">${{ number_format($fees->remaining_balance, 2) }}</td>
                    </tr>
                    @endif
                    <tr style="background:#f0fdf4;">
                        <td colspan="2" style="text-align:right;"><strong>{{ __('Total Paid This Receipt:') }}</strong></td>
                        <td style="text-align:right; color:#15803d; font-weight:800; font-size:1rem;">${{ number_format($fees->paid, 2) }}</td>
                    </tr>
                    <tr style="background:#f8fafc;">
                        <td colspan="2" style="text-align:right;"><strong>{{ __('Remaining Balance:') }}</strong></td>
                        <td style="text-align:right; font-weight:700;">${{ number_format($fees->previous_balance, 2) }}</td>
                    </tr>
                </tbody>
            </table>

            {{-- Footer (QR Code, Terms, Signatures) --}}
            <div class="rc-footer-wrap">
                <div class="rc-qr-box">
                    {!! QrCode::size(80)->generate("
Student: {$fees->student_name}
Class: {$fees->class_name}
Receipt: {$fees->receipt_no}
Paid: \${$fees->paid}
Date: {$fees->receipt_date}
School: {$schoolName}
                    ") !!}
                    <div class="rc-terms-box">
                        <strong>{{ __('Notice:') }}</strong><br>
                        • {{ __('Fees once paid are non-refundable and non-transferable.') }}<br>
                        • {{ __('Please keep this official receipt for future reference.') }}
                    </div>
                </div>
                <div class="rc-signatures">
                    <div class="rc-sig-block">{{ __('Student / Parent') }}</div>
                    <div class="rc-sig-block">{{ __('Cashier / Accountant') }}</div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════════
             VOUCHER 2: ACCOUNTANT COPY (DUPLICATE FOR SCHOOL RECORDS)
        ══════════════════════════════════════════════════════════════ --}}
        <div class="rc-voucher">
            <div class="rc-voucher-header">
                <div class="rc-brand-left">
                    <img src="{{ $logoUrl }}" alt="{{ $schoolName }} Logo" class="rc-logo">
                    <div class="rc-school-info">
                        <h2>{{ $schoolName }}</h2>
                        <p><i class="fas fa-map-marker-alt mr-1"></i>{{ $schoolAddress }}</p>
                        <p><i class="fas fa-phone mr-1"></i>{{ $schoolPhone }} · <i class="fas fa-envelope mr-1"></i>{{ $schoolEmail }}</p>
                    </div>
                </div>
                <div class="rc-voucher-badge-wrap">
                    <span class="rc-voucher-badge" style="background:#4338ca;">{{ __('Official Fee Receipt') }}</span>
                    <div class="rc-copy-label">{{ __('School / Accountant Copy') }}</div>
                </div>
            </div>

            {{-- Info Grid --}}
            <table class="rc-info-grid">
                <tr>
                    <td class="rc-label">{{ __('Receipt No.') }}</td>
                    <td class="rc-val"><strong>{{ $fees->receipt_no }}</strong></td>
                    <td class="rc-label">{{ __('Receipt Date') }}</td>
                    <td class="rc-val">{{ date('F d, Y', strtotime($fees->receipt_date)) }}</td>
                </tr>
                <tr>
                    <td class="rc-label">{{ __('Student Name') }}</td>
                    <td class="rc-val"><strong>{{ $fees->student_name }}</strong></td>
                    <td class="rc-label">{{ __('Guardian / Parent') }}</td>
                    <td class="rc-val">{{ $fees->parent_name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="rc-label">{{ __('Class / Grade') }}</td>
                    <td class="rc-val">{{ $fees->class_name }}</td>
                    <td class="rc-label">{{ __('Section / Shift') }}</td>
                    <td class="rc-val">{{ $fees->section_name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="rc-label">{{ __('Roll Number') }}</td>
                    <td class="rc-val">{{ $fees->roll ?? 'N/A' }}</td>
                    <td class="rc-label">{{ __('Payment Mode') }}</td>
                    <td class="rc-val">{{ $fees->paid_via ?? 'Cash' }}</td>
                </tr>
            </table>

            {{-- Fee Breakdown Table --}}
            <table class="rc-items-table">
                <thead>
                    <tr>
                        <th style="width: 50%;">{{ __('Description') }}</th>
                        <th style="text-align:center; width: 15%;">{{ __('Duration') }}</th>
                        <th style="text-align:right; width: 35%;">{{ __('Amount (USD)') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>{{ __('Tuition Fee') }} · {{ $fees->class_name }} ({{ $fees->section_name ?? 'Regular' }})</strong></td>
                        <td style="text-align:center;">{{ $fees->section_duration_months ?? 1 }} {{ __('Months') }}</td>
                        <td style="text-align:right;">${{ number_format($fees->grand_total, 2) }}</td>
                    </tr>
                    @if($fees->remaining_balance != 0)
                    <tr style="background:#fffbeb;">
                        <td colspan="2" style="text-align:right;"><strong>{{ __('Previous Outstanding Balance:') }}</strong></td>
                        <td style="text-align:right; color:#b45309;">${{ number_format($fees->remaining_balance, 2) }}</td>
                    </tr>
                    @endif
                    <tr style="background:#f0fdf4;">
                        <td colspan="2" style="text-align:right;"><strong>{{ __('Total Paid This Receipt:') }}</strong></td>
                        <td style="text-align:right; color:#15803d; font-weight:800; font-size:1rem;">${{ number_format($fees->paid, 2) }}</td>
                    </tr>
                    <tr style="background:#f8fafc;">
                        <td colspan="2" style="text-align:right;"><strong>{{ __('Remaining Balance:') }}</strong></td>
                        <td style="text-align:right; font-weight:700;">${{ number_format($fees->previous_balance, 2) }}</td>
                    </tr>
                </tbody>
            </table>

            {{-- Footer (QR Code, Terms, Signatures) --}}
            <div class="rc-footer-wrap">
                <div class="rc-qr-box">
                    {!! QrCode::size(80)->generate("
Student: {$fees->student_name}
Class: {$fees->class_name}
Receipt: {$fees->receipt_no}
Paid: \${$fees->paid}
Date: {$fees->receipt_date}
School: {$schoolName}
                    ") !!}
                    <div class="rc-terms-box">
                        <strong>{{ __('Internal Records:') }}</strong><br>
                        • {{ __('Archived in School Accounting Database.') }}<br>
                        • {{ __('Authorized verification token validated.') }}
                    </div>
                </div>
                <div class="rc-signatures">
                    <div class="rc-sig-block">{{ __('Auditor / Controller') }}</div>
                    <div class="rc-sig-block">{{ __('Authorized Signature') }}</div>
                </div>
            </div>
        </div>

    </div>
</section>

<script>
    function printReceipt() {
        var originalTitle = document.title;
        var printFilename = "{{ 'FeeReceipt_' . preg_replace('/[^A-Za-z0-9\-_]/', '', $fees->receipt_no ?? 'Receipt') . '_' . \Illuminate\Support\Str::slug($fees->student_name ?? 'Student') }}";
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
</script>

@endsection
