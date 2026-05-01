@extends('layout.main')

@section('content')

    <style>
        @media print {
            html, body {
                overflow: hidden !important;
                width: 100% !important;
                background-color: #ffffff;
                margin: 0!important;
                padding: 0!important;
                font-size: 12px;
                -webkit-print-color-adjust: exact !important; /* Ensures colors print */
                print-color-adjust: exact !important;
            }

            .text-right {
                text-align: right !important;
            }

            .btn, .print-btn, .d-flex {
                display: none !important; /* Hide Buttons */
            }

            .p_head p {
                font-size: 15px;
                margin: 2px 0;
                padding: 0; /* Removes any extra padding */
            }

            @page {
                size: A4 portrait;  /* Defines A5 size in portrait orientation */
                margin: 0;
                overflow: hidden;
                /*bleed: 3mm; !* (Optional) Adds a bleed for printing *!*/
                /*marks: crop; !* (Optional) Adds crop marks for printing *!*/
            }
            .print-container {
                overflow: hidden !important;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: start;
                height: 100vh; /* Ensure full height of A4 */
                width: 100% !important;
            }

            .receipt {
                display: block !important;
                box-shadow: none;
                width: 100% !important;
                height: 50vh; /* Half of A4 page */
                margin: 0 !important; /* Removes extra space between receipts */
                padding: 1px 0 !important; /* Reduces spacing inside receipt */
                box-sizing: border-box;
                /*border-bottom: 2px dashed black; !* Optional: Separate receipts visually *!*/
                overflow: hidden !important;
            }
            ::-webkit-scrollbar {
                display: none !important; /* Hides the scrollbar */
            }
        }
    </style>

    <style>
        body {
            color: black !important;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #FFFFFFFF;
        }

        .receipt-container {
            max-width: 95%;
            margin: auto;
            background: #FFFFFFFF;
            padding: 20px;
            border: 2px solid maroon;
            border-radius: 5px;
            position: relative;
            overflow: hidden;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid maroon;
            padding-bottom: 10px;
        }

        .header img {
            width: 80px;
            height: auto;
            margin-bottom: 10px;
        }

        .header h1 {
            color: maroon;
            margin: 5px 0;
        }

        .header p {
            color: black;
            font-size: 14px;
            margin: 3px 0;
        }
        .col-2 {
            vertical-align: top; /* Align logo to the top */
            width: 20%; /* Adjust width as needed */
        }

        .col-10 {
            width: 80%; /* Adjust width as needed */
            text-align: center; /* Center the text */
        }
        .center-text {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100%; /* Ensure the text is centered vertically */
        }

        .receipt-title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin: 10px 0;
            text-transform: uppercase;
            color: maroon;
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
            color: #FFFFFFFF;
        }

        .footer {
            text-align: center;
            margin-top: 10px;
            font-size: 12px;
            color: #333;
        }

        .qr-terms-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        /*.qr-code {*/
        /*    text-align: center;*/
        /*    width: 45%;*/
        /*}*/

        .terms {
            width: 45%;
            font-size: 12px;
            text-align: left;
            color: #444;
        }

        .terms p {
            margin-bottom: 5px;
        }

        .print-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: maroon;
            color: #FFFFFFFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            font-size: 16px;
        }

        .print-btn:hover{
            background-color: darkred;
        }

    </style>

    <div class="print-container">
        <div class="receipt">
            <div id="receipt-container" class="receipt-container">
                <div class="header">
                    <table style=" width: 100%; border-collapse: collapse;">
                        <tbody>
                        <tr>
                            <td class="col-3">
                                <img src="{{ asset('logo-final.png') }}" alt="Mawarid Tech Academy Logo" style="width: 80px; height: auto;">
                            </td>

                            <td class="col-1"></td>
                            <td class="col-9">
                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="col-12">
                                            <div class="center-text">
                                                <h1>Mawarid Tech Academy</h1>
                                                <p>No.32, Street 606, Tuol Kork, Phnom Penh</p>
                                                <p>Phone: +855 1280 1470 | Email: info@mawaridtech.com</p>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="receipt-title">Staff Attendance Record</div>
{{--                <p class="text-muted">--}}
{{--                    *Note: Receipt for Accountant.--}}
{{--                </p>--}}
                <table class="info-table">
                    <tr>
                        <th class="col-6">Date</th>
                        <td class="col-6">
                            <strong>{{ \Carbon\Carbon::parse($date)->format('D, d M Y') }}</strong>
                        </td>
                    </tr>
                </table>
                <table class="info-table">
                    <tr>
                        <th>S.No</th>
                        <th>Employee Name</th>
                        <th>Status</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                    </tr>
                    @forelse ($attendance as $index => $record)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $record->name }}</td>
                            <td style="color: @if($record->status == 'Present') green
                                @elseif($record->status == 'Absent') red
                                @elseif($record->status == 'Undefined') gray
                                @else black
                                @endif">
                                <b>{{ $record->status  }}</b>
                            </td>
                            <td>{{ $record->time_in ?? '-' }}</td>
                            <td>{{ $record->time_out ?? '-' }}</td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No attendance records found.</td>
                        </tr>
                    @endforelse
                </table>

{{--                <div class="qr-terms-container">--}}
{{--                    <div class="qr-code2">--}}
{{--                        <div id="qr-code2">--}}
{{--                        {!! QrCode::size(100)->generate("--}}
{{--                            Student Name: {$fees->student_name}--}}
{{--                            Course: {$fees->class_name}--}}
{{--                            Shift: {$fees->section_name}--}}
{{--                            Start Date: {$fees->start_date}--}}
{{--                            Total Fee: {$fees->grand_total}--}}
{{--                            Paid Fee: \${$fees->paid}--}}
{{--                            Previous Balance: \${$fees->remaining_balance}--}}
{{--                            Remaining Balance: \${$fees->previous_balance}--}}
{{--                            Paid On: {$fees->receipt_date}--}}
{{--                            School: Mawarid Tech Academy--}}
{{--                            ") !!}--}}
{{--                        </div>--}}
{{--                        <p style="text-align: left; font-size: 14px; margin-top: 5px; color: black;">Scan for Details</p>--}}
{{--                    </div>--}}
{{--                    <div class="terms">--}}
{{--                        <p><strong>Terms:</strong></p>--}}
{{--                        <p>1. Fee once paid is non-refundable.</p>--}}
{{--                        <p>2. Receipt must be retained for any future references.</p>--}}
{{--                        <p>3. For any queries, please contact the administration.</p>--}}
{{--                    </div>--}}

{{--                </div>--}}

                <button class="print-btn" onclick="window.print();"><i class="fas fa-print"></i> Print</button>
                <a href="{{ route('staffAttendance.index') }}" class="btn btn-secondary mt-3"><i class="fas fa-back"></i>Back to List</a>
                <a href="{{ route('staffAttendance.pdf', $date) }}" class="btn btn-primary mt-3">
                    <i class="fas fa-download"></i> Generate PDF
                </a>
            </div>
        </div>
    </div>




@endsection
