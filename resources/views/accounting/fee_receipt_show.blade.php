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

            /*.container {*/
            /*    width: 100%;*/
            /*    max-width: 100%;*/
            /*    padding: 20px;*/
            /*}*/
            /*p{*/
            /*    font-size: 20px;*/
            /*}*/

            /*table {*/
            /*    width: 100%;*/
            /*    border-collapse: collapse;*/
            /*    border: 3px solid black !important; !* Increase outer border thickness *!*/
            /*}*/

            /*th, td {*/
            /*    border: 2px solid black !important; !* Make inner borders thinner *!*/
            /*    font-size: 15px;*/
            /*    text-align: center;*/
            /*}*/
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

{{--    <style>--}}
{{--        * {--}}
{{--            box-sizing: border-box;--}}
{{--        }--}}

{{--        .p_head p {--}}
{{--            margin: 2px 0;--}}
{{--            padding: 0; /* Removes any extra padding */--}}
{{--        }--}}
{{--    </style>--}}

    <style>
        body {
            color: black !important;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #FFFFFFFF;
        }

        .receipt-container {
            max-width: 90%;
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


{{--    <div class="print-container">--}}
{{--        <div class="receipt">--}}
{{--            <!-- First Receipt -->--}}
{{--            <div class="container">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header text-center">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-md-3 float-right">--}}
{{--                                <img src="{{ asset('logo-txt.png') }}" alt="MAWARID LOGO" style="width: 250px; height: auto;">--}}
{{--                            </div>--}}
{{--                            <div class="col-md-3"></div>--}}
{{--                            <div class="col-md-6 float-left" style="margin-top: 10px">--}}
{{--                                <b>No.32, Street 606, Khan Toul Kork, Phnom Penh, Cambodia</b><br>--}}
{{--                                <b>Phone: 012 801 470 / 071 220 6315</b>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-md-12">--}}
{{--                                <h3 align="center"><b>FEE RECEIPT</b></h3>--}}
{{--                                <hr>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row p_head">--}}
{{--                            <div class="col-md-4">--}}
{{--                                <p><strong>Student Name: </strong> <b>{{ $fees->student_name }}</b></p>--}}
{{--                                <p><strong>Gender: </strong>--}}
{{--                                    @if($fees->sex)--}}
{{--                                        Male--}}
{{--                                    @else--}}
{{--                                        Female--}}
{{--                                    @endif</p>--}}
{{--                                <p><strong>Student Roll: </strong> {{ $fees->roll }}</p>--}}
{{--                                <p><strong>Course: </strong> {{ $fees->class_name }}</p>--}}
{{--                                <p><strong>Course Duration: </strong> {{ $fees->section_duration_months }} Months</p>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-3"></div>--}}
{{--                            <div class="col-md-4 float-right">--}}
{{--                                <p><strong>Receipt No: </strong> {{ $fees->receipt_no }}</p>--}}
{{--                                <p><strong>Date: </strong> {{ date_format(date_create($fees->receipt_date), 'F d, Y') }}</p>--}}
{{--                                <p><strong>Term: </strong></p>--}}
{{--                                <p><strong>Shift: </strong>{{ $fees->section_name }}</p>--}}
{{--                                <p><strong>Start Date: </strong>{{ date_format(date_create($fees->start_date), 'F d, Y') }}</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <table class="table dtr-inline mt-3" style="border: 3px solid black;">--}}
{{--                            <thead class="thead-light">--}}
{{--                            <tr align="center">--}}
{{--                                <th>No.</th>--}}
{{--                                <th>Description</th>--}}
{{--                                <th>Qty</th>--}}
{{--                                <th>Price</th>--}}
{{--                                <th>Discount(%)</th>--}}
{{--                                <th>Months</th>--}}
{{--                                <th>Total</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            @php $grandTotal = 0; @endphp--}}
{{--                            @foreach ($items as $index => $item)--}}
{{--                                <tr>--}}
{{--                                    <td style="border: 3px solid black;">{{ $index + 1}}</td>--}}
{{--                                    <td style="border: 3px solid black;">{{ $item->description }}</td>--}}
{{--                                    <td style="border: 3px solid black;">{{ $item->qty }}</td>--}}
{{--                                    <td style="border: 3px solid black;">{{ $item->price }}</td>--}}
{{--                                    <td style="border: 3px solid black;">{{ $item->discount }}</td>--}}
{{--                                    <td style="border: 3px solid black;">{{ $item->duration }}</td>--}}
{{--                                    <td style="border: 3px solid black;">${{ number_format($item->total, 2) }}</td>--}}
{{--                                </tr>--}}
{{--                                @php $grandTotal += $item->total; @endphp--}}
{{--                            @endforeach--}}
{{--                            </tbody>--}}
{{--                            <tfoot>--}}
{{--                                <tr>--}}
{{--                                    <td colspan="6" class="text-right"><strong>Total Amount:</strong></td>--}}
{{--                                    <td align="center"><strong>${{ number_format($grandTotal, 2) }}</strong></td>--}}
{{--                                </tr>--}}
{{--                                @if($fees->remaining_balance != 0)--}}
{{--                                    <tr id="prev_balance">--}}
{{--                                        <td colspan="6" class="text-right"><strong>Previous Balance:</strong></td>--}}
{{--                                        <td align="center"><strong>${{ number_format($fees->remaining_balance, 2)}}</strong></td>--}}
{{--                                    </tr>--}}
{{--                                @endif--}}

{{--                                <tr>--}}
{{--                                    <td colspan="6" class="text-right"><strong>Total Paid:</strong></td>--}}
{{--                                    <td align="center"><strong>${{ number_format($fees->paid, 2) }}</strong></td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                                            @php--}}
{{--                                                                $balance = ($fees->previous_balance + $grandTotal) - $fees->paid;--}}
{{--                                                            @endphp--}}
{{--                                    <td colspan="6" class="text-right"><strong>Remaining Balance: </strong></td>--}}
{{--                                    <td align="center"><strong>${{ number_format($fees->previous_balance, 2) }}</strong></td>--}}
{{--                                </tr>--}}
{{--                            </tfoot>--}}
{{--                        </table>--}}
{{--                        <div class="row mt-4"></div>--}}
{{--                        <div class="col-md-6">--}}
{{--                            <p><strong>Payment Method: </strong>{{ $fees->paid_via ?? 'N/A' }}</p>--}}
{{--                        </div>--}}
{{--                        <div class="row mt-4"></div>--}}

{{--                        <div class="row mt-4">--}}
{{--                            <div class="col-md-6">--}}
{{--                                <p><strong>Accountant Signature:</strong> ______________________</p>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-6 text-end"> <!-- Bootstrap 5 -->--}}
{{--                                <p><strong>Authorized Signature:</strong> ______________________</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="row mt-4"></div>--}}
{{--                        <p class="text-muted">--}}
{{--                            *Note: Payment made is <strong>non-refundable and non-transferable</strong>.--}}
{{--                        </p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="receipt">--}}
{{--            <!-- Second Receipt (Duplicate) -->--}}
{{--            <div class="container">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header text-center">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-md-3 float-right">--}}
{{--                                <img src="{{ asset('logo-txt.png') }}" alt="MAWARID LOGO" style="width: 250px; height: auto;">--}}
{{--                            </div>--}}
{{--                            <div class="col-md-3"></div>--}}
{{--                            <div class="col-md-6 float-left" style="margin-top: 10px">--}}
{{--                                <b>No.32, Street 606, Khan Toul Kork, Phnom Penh, Cambodia</b><br>--}}
{{--                                <b>Phone: 012 801 470 / 071 220 6315</b>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-md-12">--}}
{{--                                <h3 align="center"><b>FEE RECEIPT</b></h3>--}}
{{--                                <hr>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row p_head">--}}
{{--                            <div class="col-md-4">--}}
{{--                                <p><strong>Student Name: </strong> <b>{{ $fees->student_name }}</b></p>--}}
{{--                                <p><strong>Gender: </strong>--}}
{{--                                    @if($fees->sex)--}}
{{--                                        Male--}}
{{--                                    @else--}}
{{--                                        Female--}}
{{--                                    @endif</p>--}}
{{--                                <p><strong>Student Roll: </strong> {{ $fees->roll }}</p>--}}
{{--                                <p><strong>Course: </strong> {{ $fees->class_name }}</p>--}}
{{--                                <p><strong>Course Duration: </strong> {{ $fees->section_duration_months }} Months</p>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-3"></div>--}}
{{--                            <div class="col-md-4 float-right">--}}
{{--                                <p><strong>Receipt No: </strong> {{ $fees->receipt_no }}</p>--}}
{{--                                <p><strong>Date: </strong> {{ date_format(date_create($fees->receipt_date), 'F d, Y') }}</p>--}}
{{--                                <p><strong>Term: </strong></p>--}}
{{--                                <p><strong>Shift: </strong>{{ $fees->section_name }}</p>--}}
{{--                                <p><strong>Start Date: </strong>{{ date_format(date_create($fees->start_date), 'F d, Y') }}</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <table class="table dtr-inline mt-3" style="border: 3px solid black;">--}}
{{--                            <thead class="thead-light">--}}
{{--                            <tr align="center">--}}
{{--                                <th>No.</th>--}}
{{--                                <th>Description</th>--}}
{{--                                <th>Qty</th>--}}
{{--                                <th>Price</th>--}}
{{--                                <th>Discount(%)</th>--}}
{{--                                <th>Months</th>--}}
{{--                                <th>Total</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            @php $grandTotal = 0; @endphp--}}
{{--                            @foreach ($items as $index => $item)--}}
{{--                                <tr>--}}
{{--                                    <td style="border: 3px solid black;">{{ $index + 1}}</td>--}}
{{--                                    <td style="border: 3px solid black;">{{ $item->description }}</td>--}}
{{--                                    <td style="border: 3px solid black;">{{ $item->qty }}</td>--}}
{{--                                    <td style="border: 3px solid black;">{{ $item->price }}</td>--}}
{{--                                    <td style="border: 3px solid black;">{{ $item->discount }}</td>--}}
{{--                                    <td style="border: 3px solid black;">{{ $item->duration }}</td>--}}
{{--                                    <td style="border: 3px solid black;">${{ number_format($item->total, 2) }}</td>--}}
{{--                                </tr>--}}
{{--                                @php $grandTotal += $item->total; @endphp--}}
{{--                            @endforeach--}}
{{--                            </tbody>--}}
{{--                            <tfoot>--}}
{{--                                <tr>--}}
{{--                                    <td colspan="6" class="text-right"><strong>Total Amount:</strong></td>--}}
{{--                                    <td align="center"><strong>${{ number_format($grandTotal, 2) }}</strong></td>--}}
{{--                                </tr>--}}
{{--                                @if($fees->remaining_balance != 0)--}}
{{--                                    <tr id="prev_balance">--}}
{{--                                        <td colspan="6" class="text-right"><strong>Previous Balance:</strong></td>--}}
{{--                                        <td align="center"><strong>${{ number_format($fees->remaining_balance, 2)}}</strong></td>--}}
{{--                                    </tr>--}}
{{--                                @endif--}}

{{--                                <tr>--}}
{{--                                    <td colspan="6" class="text-right"><strong>Total Paid:</strong></td>--}}
{{--                                    <td align="center"><strong>${{ number_format($fees->paid, 2) }}</strong></td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                                            @php--}}
{{--                                                                $balance = ($fees->previous_balance + $grandTotal) - $fees->paid;--}}
{{--                                                            @endphp--}}
{{--                                    <td colspan="6" class="text-right"><strong>Remaining Balance: </strong></td>--}}
{{--                                    <td align="center"><strong>${{ number_format($fees->previous_balance, 2) }}</strong></td>--}}
{{--                                </tr>--}}
{{--                            </tfoot>--}}
{{--                        </table>--}}
{{--                        <div class="row mt-4"></div>--}}
{{--                        <div class="col-md-6">--}}
{{--                            <p><strong>Payment Method: </strong>{{ $fees->paid_via ?? 'N/A' }}</p>--}}
{{--                        </div>--}}
{{--                        <div class="row mt-4"></div>--}}

{{--                        <div class="row mt-4">--}}
{{--                            <div class="col-md-6">--}}
{{--                                <p><strong>Accountant Signature:</strong> ______________________</p>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-6 text-end"> <!-- Bootstrap 5 -->--}}
{{--                                <p><strong>Authorized Signature:</strong> ______________________</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="row mt-4"></div>--}}
{{--                        <p class="text-muted">--}}
{{--                            *Note: Payment made is <strong>non-refundable and non-transferable</strong>.<br>--}}
{{--                            *Note: Receipt made is <strong>for accountant</strong>.--}}
{{--                        </p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <button onclick="window.print()" class="btn btn-success mt-3 float-right"><i class="fas fa-print"></i> Print</button>--}}
{{--                        <button type="button" class="btn btn-primary mt-3 float-right" style="margin-right: 5px;">--}}
{{--                            <i class="fas fa-download"></i> Generate PDF--}}
{{--                        </button>--}}
{{--                <a href="{{ route('fee_receipt.index') }}" class="btn btn-secondary mt-3">Back to List</a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="print-container">
        <div class="receipt" id="receipt" style="display: none;">
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
            <div class="receipt-title">Fee Receipt</div>
                <p class="text-muted">
                    *Note: Receipt for Student.
                </p>
        <table class="info-table">
            <tr>
                <th>Receipt No.</th>
                <td >{{ $fees->receipt_no }}</td>
                <th>Date</th>
                <td id="date">{{ date_format(date_create($fees->receipt_date), 'F d, Y') }}</td>
            </tr>
            <tr>
                <th>Student Name</th>
                <td id="studentName">{{ $fees->student_name }}</td>
                <th>Father/Guardian Name</th>
                <td>{{ $fees->parent_name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Course</th>
                <td id="course">{{ $fees->class_name }}</td>
                <th>Duration</th>
                <td>{{ $fees->section_duration_months }} Months</td>
            </tr>
            <tr>
                <th>Shift</th>
                <td id="shift">{{ $fees->section_name }}</td>
                <th>Start Date</th>
                <td id="startDate">{{ $fees->start_date }}</td>
            </tr>
        </table>
        <table class="info-table">
            <tr>
                <th>Student's Fees Details</th>
                <th>Amount</th>
            </tr>
            <tr>
                <td>Total Fee</td>
                <td><strong>${{ number_format($fees->grand_total, 2) }}</strong></td>
            </tr>
            @if($fees->remaining_balance != 0)
                <tr id="prev_balance">
                    <td>Previous Balance</td>
                    <td id="previousFee"><strong>${{ number_format($fees->remaining_balance, 2)}}</strong></td>
                </tr>
            @endif
            <tr>
                <td>Paid Fee</td>
                <td id="paidFee"><strong>${{ number_format($fees->paid, 2) }}</strong></td>
            </tr>
            <tr>
                <td>Balance Fee</td>
                <td id="balanceFee"><strong>${{ number_format($fees->previous_balance, 2) }}</strong></td>
            </tr>
        </table>

        <div class="qr-terms-container">
            <div class="qr-code">
                <div id="qr-code">
                {!! QrCode::size(100)->generate("
                    Student Name: {$fees->student_name}
                    Course: {$fees->class_name}
                    Shift: {$fees->section_name}
                    Start Date: {$fees->start_date}
                    Total Fee: \${$fees->grand_total}
                    Paid Fee: \${$fees->paid}
                    Previous Balance: \${$fees->remaining_balance}
                    Remaining Balance: \${$fees->previous_balance}
                    Paid On: {$fees->receipt_date}
                    School: Mawarid Tech Academy
                    ") !!}
                </div>
                <p style="text-align: left; font-size: 14px; margin-top: 5px; color: black;">Scan for Details</p>
            </div>
            <div class="terms">
                <p><strong>Terms:</strong></p>
                <p>1. Fee once paid is non-refundable.</p>
                <p>2. Receipt must be retained for any future references.</p>
                <p>3. For any queries, please contact the administration.</p>
            </div>
        </div>
    </div>
        </div>
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
                <div class="receipt-title">Fee Receipt</div>
                <p class="text-muted">
                    *Note: Receipt for Accountant.
                </p>
                <table class="info-table">
                    <tr>
                        <th>Receipt No.</th>
                        <td >{{ $fees->receipt_no }}</td>
                        <th>Date</th>
                        <td id="date">{{ date_format(date_create($fees->receipt_date), 'F d, Y') }}</td>
                    </tr>
                    <tr>
                        <th>Student Name</th>
                        <td id="studentName">{{ $fees->student_name }}</td>
                        <th>Father/Guardian Name</th>
                        <td>{{ $fees->parent_name ?? 'N/A'}}</td>
                    </tr>
                    <tr>
                        <th>Course</th>
                        <td id="course">{{ $fees->class_name }}</td>
                        <th>Duration</th>
                        <td>{{ $fees->section_duration_months }} Months</td>
                    </tr>
                    <tr>
                        <th>Shift</th>
                        <td id="shift">{{ $fees->section_name }}</td>
                        <th>Start Date</th>
                        <td id="startDate">{{ $fees->start_date }}</td>
                    </tr>
                </table>
                <table class="info-table">
                    <tr>
                        <th>Student's Fees Details</th>
                        <th>Amount</th>
                    </tr>
                    <tr>
                        <td>Total Fee</td>
                        <td><strong>${{ number_format($fees->grand_total, 2) }}</strong></td>
                    </tr>
                    @if($fees->remaining_balance != 0)
                        <tr id="prev_balance">
                            <td>Previous Balance</td>
                            <td id="previousFee"><strong>${{ number_format($fees->remaining_balance, 2)}}</strong></td>
                        </tr>
                    @endif
                    <tr>
                        <td>Paid Fee</td>
                        <td id="paidFee"><strong>${{ number_format($fees->paid, 2) }}</strong></td>
                    </tr>
                    <tr>
                        <td>Balance Fee</td>
                        <td id="balanceFee"><strong>${{ number_format($fees->previous_balance, 2) }}</strong></td>
                    </tr>
                </table>

                <div class="qr-terms-container">
                    <div class="qr-code2">
                        <div id="qr-code2">
                        {!! QrCode::size(100)->generate("
                            Student Name: {$fees->student_name}
                            Course: {$fees->class_name}
                            Shift: {$fees->section_name}
                            Start Date: {$fees->start_date}
                            Total Fee: {$fees->grand_total}
                            Paid Fee: \${$fees->paid}
                            Previous Balance: \${$fees->remaining_balance}
                            Remaining Balance: \${$fees->previous_balance}
                            Paid On: {$fees->receipt_date}
                            School: Mawarid Tech Academy
                            ") !!}
                        </div>
                        <p style="text-align: left; font-size: 14px; margin-top: 5px; color: black;">Scan for Details</p>
                    </div>
                    <div class="terms">
                        <p><strong>Terms:</strong></p>
                        <p>1. Fee once paid is non-refundable.</p>
                        <p>2. Receipt must be retained for any future references.</p>
                        <p>3. For any queries, please contact the administration.</p>
                    </div>

                </div>

                <button class="print-btn" onclick="printReceipt()"><i class="fas fa-print"></i> Print Receipt</button>
                <a href="{{ route('fee_receipt.index') }}" class="btn btn-secondary mt-3"><i class="fas fa-back"></i>Back to List</a>
                <a href="{{ route('fee_receipt.pdf', $fees->receipt_id) }}" class="btn btn-primary mt-3"><i class="fas fa-download"></i>Generate PDF</a>
            </div>
        </div>
    </div>

    <script>
        function printReceipt() {
            var receipt = document.getElementById('receipt');
            receipt.style.display = 'block';
            window.print();
            receipt.style.display = 'none';
        }
    </script>


{{--<script>--}}
{{--    document.addEventListener("DOMContentLoaded", function() {--}}

{{--        // Generate QR Code with all the details--}}
{{--        const qrContent = `--}}
{{--                    Student Name: ${studentName}--}}
{{--                    Course: ${course}--}}
{{--                    Paid Fee: $${paidFee}--}}
{{--                    @if($fees->remaining_balance != 0)--}}
{{--                        Previous Fee: $${previousFee}--}}
{{--                    @endif--}}
{{--                    Balance: $${balanceFee}--}}
{{--                    Paid On: ${date}--}}
{{--                    School: Mawarid Tech Academy--}}
{{--                `;    --}}

{{--        const qrContent = `--}}
{{--                    {!! QrCode::size(200)->generate("--}}
{{--                    Student Name: {$fees->student_name}--}}
{{--                    Course: {$fees->class_name}--}}
{{--                    Paid Fee: \${$fees->paid}--}}
{{--                    Previous Balance: \${$fees->previous_balance}--}}
{{--                    Remaining Balance: \${$fees->remaining_balance}--}}
{{--                    Paid On: {$fees->receipt_date}--}}
{{--                    School: Mawarid Tech Academy--}}
{{--                    ") !!}--}}
{{--                `;--}}
{{--        new QRCode(document.getElementById('qr-code'), {--}}
{{--            text: qrContent,--}}
{{--            width: 100,--}}
{{--            height: 100--}}
{{--        });--}}
{{--        new QRCode(document.getElementById('qr-code2'), {--}}
{{--            text: qrContent,--}}
{{--            width: 100,--}}
{{--            height: 100--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}


@endsection
