<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Report - {{ $class->name }} ({{ $date }})</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 12px;
            color: #333333;
            margin: 20px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 12px;
            margin-bottom: 18px;
        }
        .school-title {
            font-size: 20px;
            font-weight: bold;
            color: #1a252f;
            margin: 0 0 4px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .report-subtitle {
            font-size: 13px;
            font-weight: 600;
            color: #007bff;
            margin: 0 0 4px 0;
        }
        .meta-date {
            font-size: 11px;
            color: #666666;
            margin: 0;
        }
        .info-grid {
            width: 100%;
            margin-bottom: 16px;
            border-collapse: collapse;
        }
        .info-grid td {
            padding: 6px 10px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            font-size: 11px;
        }
        .info-grid strong {
            color: #1e293b;
        }
        .summary-cards {
            width: 100%;
            margin-bottom: 16px;
            border-collapse: collapse;
        }
        .summary-card {
            padding: 8px;
            text-align: center;
            border: 1px solid #cbd5e1;
            background: #ffffff;
        }
        .summary-val {
            font-size: 16px;
            font-weight: bold;
            display: block;
        }
        .summary-lbl {
            font-size: 9px;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 0.5px;
        }
        .card-total { border-top: 3px solid #3b82f6; }
        .card-present { border-top: 3px solid #22c55e; }
        .card-absent { border-top: 3px solid #ef4444; }
        .card-late { border-top: 3px solid #f59e0b; }
        .card-medical { border-top: 3px solid #06b6d4; }
        .card-rate { border-top: 3px solid #8b5cf6; }

        .table-records {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        .table-records th {
            background-color: #0f172a;
            color: #ffffff;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 7px 8px;
            border: 1px solid #0f172a;
            text-align: left;
        }
        .table-records td {
            padding: 6px 8px;
            border: 1px solid #cbd5e1;
            font-size: 11px;
        }
        .table-records tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .badge-present { background-color: #dcfce7; color: #15803d; }
        .badge-absent { background-color: #fee2e2; color: #b91c1c; }
        .badge-late { background-color: #fef3c7; color: #b45309; }
        .badge-medical { background-color: #cffafe; color: #0e7490; }
        .badge-undefined { background-color: #f1f5f9; color: #64748b; }

        .signatures {
            width: 100%;
            margin-top: 40px;
            border-collapse: collapse;
        }
        .signatures td {
            width: 50%;
            padding: 0 30px;
            text-align: center;
        }
        .sig-line {
            border-top: 1px solid #333333;
            margin-top: 50px;
            padding-top: 5px;
            font-weight: bold;
            font-size: 11px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            border-top: 1px dashed #cbd5e1;
            padding-top: 8px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1 class="school-title">{{ $schoolName }}</h1>
        <div class="report-subtitle">DAILY ATTENDANCE RECORD & AUDIT REPORT</div>
        <p class="meta-date">Report Generated on {{ \Carbon\Carbon::now()->format('F d, Y \a\t h:i A') }}</p>
    </div>

    <table class="info-grid">
        <tr>
            <td width="25%"><strong>Academic Class:</strong> {{ $class->name }}</td>
            <td width="25%"><strong>Class Code:</strong> {{ $class->class_code ?? 'N/A' }}</td>
            <td width="25%"><strong>Attendance Date:</strong> {{ \Carbon\Carbon::parse($date)->format('M d, Y (l)') }}</td>
            <td width="25%"><strong>Room / Hall:</strong> {{ $class->class_room ?? 'Main Campus' }}</td>
        </tr>
    </table>

    <table class="summary-cards">
        <tr>
            <td class="summary-card card-total" width="16%">
                <span class="summary-val">{{ $total }}</span>
                <span class="summary-lbl">Total Enrolled</span>
            </td>
            <td class="summary-card card-present" width="16%">
                <span class="summary-val" style="color: #16a34a;">{{ $present }}</span>
                <span class="summary-lbl">Present</span>
            </td>
            <td class="summary-card card-absent" width="16%">
                <span class="summary-val" style="color: #dc2626;">{{ $absent }}</span>
                <span class="summary-lbl">Absent</span>
            </td>
            <td class="summary-card card-late" width="16%">
                <span class="summary-val" style="color: #d97706;">{{ $late }}</span>
                <span class="summary-lbl">Late</span>
            </td>
            <td class="summary-card card-medical" width="16%">
                <span class="summary-val" style="color: #0891b2;">{{ $medical }}</span>
                <span class="summary-lbl">Medical</span>
            </td>
            <td class="summary-card card-rate" width="20%">
                <span class="summary-val" style="color: #7c3aed;">{{ $rate }}%</span>
                <span class="summary-lbl">Attendance Rate</span>
            </td>
        </tr>
    </table>

    <table class="table-records">
        <thead>
            <tr>
                <th width="5%" style="text-align: center;">#</th>
                <th width="10%">Roll</th>
                <th width="40%">Student Name</th>
                <th width="20%">Section</th>
                <th width="25%" style="text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $index => $r)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td><strong>#{{ $r->roll ?? ($index + 1) }}</strong></td>
                    <td>{{ $r->student_name }}</td>
                    <td>{{ $r->section_name ?? 'Default Section' }}</td>
                    <td style="text-align: center;">
                        @if($r->status === 1)
                            <span class="badge badge-present">Present</span>
                        @elseif($r->status === 2)
                            <span class="badge badge-absent">Absent</span>
                        @elseif($r->status === 3)
                            <span class="badge badge-medical">Medical</span>
                        @elseif($r->status === 4)
                            <span class="badge badge-late">Late</span>
                        @else
                            <span class="badge badge-undefined">Unmarked</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 20px; color: #64748b;">
                        No student attendance records recorded for this date.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="signatures">
        <tr>
            <td>
                <div class="sig-line">Class Instructor / Teacher Signature</div>
                <div style="font-size: 10px; color: #64748b; margin-top: 3px;">Date: ________________________</div>
            </td>
            <td>
                <div class="sig-line">School Principal / Academic Registrar</div>
                <div style="font-size: 10px; color: #64748b; margin-top: 3px;">Verified & Approved</div>
            </td>
        </tr>
    </table>

    <div class="footer">
        Confidential School Record — Generated automatically by {{ $schoolName }} Management System.
    </div>

</body>
</html>
