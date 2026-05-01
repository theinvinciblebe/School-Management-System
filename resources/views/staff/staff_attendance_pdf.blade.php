<!DOCTYPE html>
<html>
<head>
    <title>Mawarid Tech Academy - Staff Attendance</title>

    <style>
        /*html, body {*/
        /*    overflow: hidden !important;*/
        /*    width: 100% !important;*/
        /*    background-color: #ffffff;*/
        /*    margin: 0!important;*/
        /*    padding: 0!important;*/
        /*    font-size: 12px;*/
        /*    -webkit-print-color-adjust: exact !important; !* Ensures colors print *!*/
        /*    print-color-adjust: exact !important;*/
        /*}*/
        body {
            font-family: Arial, sans-serif;
            color: black;
            margin: 0!important;
            padding: 0!important;
            background: white;
        }

        .container {
            width: 95%;
            margin: 0!important;
            padding: 20px;
            border: 2px solid maroon;
            border-radius: 5px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: top;
        }

        .header-table .logo {
            width: 80px;
        }

        .center-text {
            text-align: center;
        }

        .receipt-title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin: 15px 0 5px;
            color: maroon;
            text-transform: uppercase;
        }

        .info-table {
            width: 100%;
            margin: 10px 0;
            border-collapse: collapse;
        }

        .info-table th, .info-table td {
            padding: 8px;
            border: 1px solid maroon;
            text-align: left;
            font-size: 14px;
        }

        .info-table th {
            background-color: maroon;
            color: white;
        }

        .status-present { color: green; font-weight: bold; }
        .status-absent { color: red; font-weight: bold; }
        .status-undefined { color: gray; font-weight: bold; }
        .status-other { color: black; font-weight: bold; }

        .text-center { text-align: center; }
    </style>
</head>
<body>

<div class="container">
    <!-- Header Section -->
    <table class="header-table">
        <tr>
            <td class="logo">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logo-final.png'))) }}" alt="Mawarid Logo" style="width: 80px;">
            </td>
            <td>
                <div class="center-text">
                    <h1 style="color: maroon; margin-bottom: 5px;">Mawarid Tech Academy</h1>
                    <p style="margin: 2px;">No.32, Street 606, Tuol Kork, Phnom Penh</p>
                    <p style="margin: 2px;">Phone: +855 1280 1470 | Email: info@mawaridtech.com</p>
                </div>
            </td>
        </tr>
    </table>

    <div class="receipt-title">Staff Attendance Record</div>

    <!-- Date Row -->
    <table class="info-table">
        <tr>
            <th style="width: 20%;">Date</th>
            <td style="width: 80%;"><strong>{{ \Carbon\Carbon::parse($date)->format('D, d M Y') }}</strong></td>
        </tr>
    </table>

    <!-- Attendance Table -->
    <table class="info-table">
        <thead>
        <tr>
            <th>S.No</th>
            <th>Employee Name</th>
            <th>Status</th>
            <th>Time In</th>
            <th>Time Out</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($attendance as $index => $record)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $record->name }}</td>
                <td class="@if($record->status == 'Present') status-present
                           @elseif($record->status == 'Absent') status-absent
                           @elseif($record->status == 'Undefined') status-undefined
                           @else status-other @endif">
                    {{ $record->status }}
                </td>
                <td>{{ $record->time_in ?? '-' }}</td>
                <td>{{ $record->time_out ?? '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">No attendance records found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

</body>
</html>
