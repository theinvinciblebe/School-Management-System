<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>FeeReceipt_{{ preg_replace('/[^A-Za-z0-9\-_]/', '', $fees->receipt_no ?? 'Receipt') }}_{{ \Illuminate\Support\Str::slug($fees->student_name ?? 'Student') }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 10px;
            color: #0f172a;
            font-size: 11px;
            background: #ffffff;
        }

        .receipt-card {
            border: 2px solid #312e81;
            border-radius: 8px;
            padding: 14px 18px;
            margin-bottom: 16px;
            page-break-inside: avoid;
        }

        .header-table {
            width: 100%;
            border-bottom: 2px solid #312e81;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .logo-img {
            width: 60px;
            height: 60px;
            border-radius: 8px;
        }

        .school-title {
            font-size: 16px;
            font-weight: bold;
            color: #1e1b4b;
            margin: 0 0 2px 0;
        }

        .school-meta {
            font-size: 9.5px;
            color: #475569;
            margin: 1px 0;
        }

        .receipt-badge {
            background-color: #312e81;
            color: #ffffff;
            font-size: 10px;
            font-weight: bold;
            padding: 4px 8px;
            border-radius: 4px;
            text-transform: uppercase;
            text-align: right;
            display: inline-block;
        }

        .copy-type {
            font-size: 9px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: bold;
            margin-top: 3px;
            text-align: right;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .info-table td {
            padding: 4px 6px;
            border: 1px solid #cbd5e1;
            font-size: 10px;
        }

        .info-label {
            background-color: #f8fafc;
            font-weight: bold;
            color: #334155;
            width: 20%;
        }

        .info-val {
            color: #0f172a;
            width: 30%;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .items-table th {
            background-color: #312e81;
            color: #ffffff;
            font-size: 10px;
            font-weight: bold;
            padding: 5px 8px;
            border: 1px solid #312e81;
            text-transform: uppercase;
        }

        .items-table td {
            padding: 5px 8px;
            border: 1px solid #cbd5e1;
            font-size: 10.5px;
        }

        .footer-table {
            width: 100%;
            margin-top: 8px;
        }

        .terms-text {
            font-size: 8.5px;
            color: #64748b;
            line-height: 1.35;
        }

        .sig-line {
            width: 120px;
            border-top: 1px dashed #334155;
            text-align: center;
            font-size: 9px;
            font-weight: bold;
            padding-top: 3px;
        }
    </style>
</head>
<body>

@php
    $brandLogo = $customizes->brand_logo ?? null;
    if (!empty($brandLogo) && str_starts_with($brandLogo, 'data:')) {
        $logoBase64 = $brandLogo;
    } else {
        $logoPath = (!empty($brandLogo) && file_exists(public_path('customize_images/' . $brandLogo)))
            ? public_path('customize_images/' . $brandLogo)
            : (file_exists(public_path('logo-final.png'))
                ? public_path('logo-final.png')
                : (file_exists(public_path('customize_images/noimg.jpg'))
                    ? public_path('customize_images/noimg.jpg')
                    : public_path('assets/dist/img/mawaridLogo.jpg')));

        $logoBase64 = file_exists($logoPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath)) : '';
    }
    $schoolName    = $customizes->brand_title ?? 'School System';
    $schoolAddress = $customizes->school_address ?? 'No.32, Street 606, Tuol Kork, Phnom Penh, Cambodia';
    $schoolPhone   = $customizes->school_phone ?? '+855 12 801 470 / +855 71 220 6315';
    $schoolEmail   = $customizes->school_email ?? 'info@schoolsystem.edu.kh';
@endphp

{{-- ══════════════════════════════════════════════════════════════════
     STUDENT COPY
══════════════════════════════════════════════════════════════════ --}}
<div class="receipt-card">
    <table class="header-table">
        <tr>
            @if(!empty($logoBase64))
            <td style="width: 70px; vertical-align: middle;">
                <img src="{{ $logoBase64 }}" class="logo-img" alt="Logo">
            </td>
            @endif
            <td style="vertical-align: middle;">
                <div class="school-title">{{ $schoolName }}</div>
                <div class="school-meta">{{ $schoolAddress }}</div>
                <div class="school-meta">Phone: {{ $schoolPhone }} | Email: {{ $schoolEmail }}</div>
            </td>
            <td style="width: 170px; text-align: right; vertical-align: middle;">
                <div class="receipt-badge">Official Fee Receipt</div>
                <div class="copy-type">Student Copy</div>
            </td>
        </tr>
    </table>

    <table class="info-table">
        <tr>
            <td class="info-label">Receipt No.</td>
            <td class="info-val"><strong>{{ $fees->receipt_no }}</strong></td>
            <td class="info-label">Date</td>
            <td class="info-val">{{ date('F d, Y', strtotime($fees->receipt_date)) }}</td>
        </tr>
        <tr>
            <td class="info-label">Student Name</td>
            <td class="info-val"><strong>{{ $fees->student_name }}</strong></td>
            <td class="info-label">Guardian / Parent</td>
            <td class="info-val">{{ $fees->parent_name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="info-label">Class / Grade</td>
            <td class="info-val">{{ $fees->class_name }}</td>
            <td class="info-label">Section / Shift</td>
            <td class="info-val">{{ $fees->section_name ?? 'Regular' }}</td>
        </tr>
        <tr>
            <td class="info-label">Roll Number</td>
            <td class="info-val">{{ $fees->roll ?? 'N/A' }}</td>
            <td class="info-label">Payment Method</td>
            <td class="info-val">{{ $fees->paid_via ?? 'Cash' }}</td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 55%;">{{ __('Description') }}</th>
                <th style="width: 20%; text-align: center;">{{ __('Duration') }}</th>
                <th style="width: 25%; text-align: right;">{{ __('Amount (USD)') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Tuition Fee & Academic Services ({{ $fees->class_name }})</strong></td>
                <td style="text-align: center;">{{ $fees->section_duration_months ?? 1 }} Months</td>
                <td style="text-align: right;">${{ number_format($fees->grand_total, 2) }}</td>
            </tr>
            @if($fees->remaining_balance != 0)
            <tr style="background-color: #fffbeb;">
                <td colspan="2" style="text-align: right;"><strong>Previous Balance:</strong></td>
                <td style="text-align: right; color: #b45309;">${{ number_format($fees->remaining_balance, 2) }}</td>
            </tr>
            @endif
            <tr style="background-color: #f0fdf4;">
                <td colspan="2" style="text-align: right;"><strong>Total Paid:</strong></td>
                <td style="text-align: right; color: #15803d; font-weight: bold; font-size: 12px;">${{ number_format($fees->paid, 2) }}</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: right;"><strong>Remaining Balance:</strong></td>
                <td style="text-align: right; font-weight: bold;">${{ number_format($fees->previous_balance, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <table class="footer-table">
        <tr>
            <td style="width: 90px; vertical-align: top;">
                @if(!empty($qrCodeBase64))
                    <img src="{{ $qrCodeBase64 }}" style="width: 75px; height: 75px;" alt="QR Code">
                @endif
            </td>
            <td style="vertical-align: top; padding-left: 10px;">
                <div class="terms-text">
                    <strong>Notice:</strong><br>
                    • Fees once paid are non-refundable and non-transferable.<br>
                    • Please retain this official receipt for future administrative reference.
                </div>
            </td>
            <td style="width: 140px; text-align: center; vertical-align: bottom;">
                <div class="sig-line">Cashier / Accountant</div>
            </td>
            <td style="width: 140px; text-align: center; vertical-align: bottom;">
                <div class="sig-line">Student / Guardian</div>
            </td>
        </tr>
    </table>
</div>

{{-- ══════════════════════════════════════════════════════════════════
     ACCOUNTANT COPY
══════════════════════════════════════════════════════════════════ --}}
<div class="receipt-card">
    <table class="header-table">
        <tr>
            @if(!empty($logoBase64))
            <td style="width: 70px; vertical-align: middle;">
                <img src="{{ $logoBase64 }}" class="logo-img" alt="Logo">
            </td>
            @endif
            <td style="vertical-align: middle;">
                <div class="school-title">{{ $schoolName }}</div>
                <div class="school-meta">{{ $schoolAddress }}</div>
                <div class="school-meta">Phone: {{ $schoolPhone }} | Email: {{ $schoolEmail }}</div>
            </td>
            <td style="width: 170px; text-align: right; vertical-align: middle;">
                <div class="receipt-badge" style="background-color: #4338ca;">Official Fee Receipt</div>
                <div class="copy-type">Accountant Copy</div>
            </td>
        </tr>
    </table>

    <table class="info-table">
        <tr>
            <td class="info-label">Receipt No.</td>
            <td class="info-val"><strong>{{ $fees->receipt_no }}</strong></td>
            <td class="info-label">Date</td>
            <td class="info-val">{{ date('F d, Y', strtotime($fees->receipt_date)) }}</td>
        </tr>
        <tr>
            <td class="info-label">Student Name</td>
            <td class="info-val"><strong>{{ $fees->student_name }}</strong></td>
            <td class="info-label">Guardian / Parent</td>
            <td class="info-val">{{ $fees->parent_name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="info-label">Class / Grade</td>
            <td class="info-val">{{ $fees->class_name }}</td>
            <td class="info-label">Section / Shift</td>
            <td class="info-val">{{ $fees->section_name ?? 'Regular' }}</td>
        </tr>
        <tr>
            <td class="info-label">Roll Number</td>
            <td class="info-val">{{ $fees->roll ?? 'N/A' }}</td>
            <td class="info-label">Payment Method</td>
            <td class="info-val">{{ $fees->paid_via ?? 'Cash' }}</td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 55%;">{{ __('Description') }}</th>
                <th style="width: 20%; text-align: center;">{{ __('Duration') }}</th>
                <th style="width: 25%; text-align: right;">{{ __('Amount (USD)') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Tuition Fee & Academic Services ({{ $fees->class_name }})</strong></td>
                <td style="text-align: center;">{{ $fees->section_duration_months ?? 1 }} Months</td>
                <td style="text-align: right;">${{ number_format($fees->grand_total, 2) }}</td>
            </tr>
            @if($fees->remaining_balance != 0)
            <tr style="background-color: #fffbeb;">
                <td colspan="2" style="text-align: right;"><strong>Previous Balance:</strong></td>
                <td style="text-align: right; color: #b45309;">${{ number_format($fees->remaining_balance, 2) }}</td>
            </tr>
            @endif
            <tr style="background-color: #f0fdf4;">
                <td colspan="2" style="text-align: right;"><strong>Total Paid:</strong></td>
                <td style="text-align: right; color: #15803d; font-weight: bold; font-size: 12px;">${{ number_format($fees->paid, 2) }}</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: right;"><strong>Remaining Balance:</strong></td>
                <td style="text-align: right; font-weight: bold;">${{ number_format($fees->previous_balance, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <table class="footer-table">
        <tr>
            <td style="width: 90px; vertical-align: top;">
                @if(!empty($qrCodeBase64))
                    <img src="{{ $qrCodeBase64 }}" style="width: 75px; height: 75px;" alt="QR Code">
                @endif
            </td>
            <td style="vertical-align: top; padding-left: 10px;">
                <div class="terms-text">
                    <strong>Internal Audit Record:</strong><br>
                    • Verified against General Ledger.<br>
                    • Authorized official school accounts verification.
                </div>
            </td>
            <td style="width: 140px; text-align: center; vertical-align: bottom;">
                <div class="sig-line">Accounting Officer</div>
            </td>
            <td style="width: 140px; text-align: center; vertical-align: bottom;">
                <div class="sig-line">Authorized Signatory</div>
            </td>
        </tr>
    </table>
</div>

</body>
</html>
