<!DOCTYPE html>
<html>
<head>
    <title>Mawarid Tech Academy - FeeReceipt.pdf</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" >
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .receipt-container {
            max-width: 720px;
            margin: auto;
            background: #fff;
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
            color: #fff;
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

        .qr-code {
            text-align: center;
            width: 45%;
        }

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
            color: #fff;
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
</head>
<body>
    <div class="print-container">
        <div class="receipt">
            <div id="receipt-container" class="receipt-container">
                <div class="header">
{{--                    <img src="{{ asset('logo-final.png') }}" alt="Mawarid Tech Academy Logo" style="width: 80px; height: auto;">--}}
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logo-final.png'))) }}" alt="Mawarid Tech Academy Logo" style="width: 80px; height: auto;">

                    {{--            <img src="https://mawaridtech.com/w2/img/logo.png" alt="Mawarid Tech Academy Logo" class="logo">--}}
                    <h1>Mawarid Tech Academy</h1>
                    <p>No.32, Street 606, Tuol Kork, Phnom Penh</p>
                    <p>Phone: +855 1280 1470 | Email: info@mawaridtech.com</p>
                </div>
                <div class="receipt-title">Fee Receipt</div>
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
                        <td>{{ $fees->parent_name }}</td>
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
                            <img src="{{ $qrCodeBase64 }}" alt="QR Code">

{{--                        {!! QrCode::format('png')--}}
{{--                            ->size(100)--}}
{{--                            ->generate("--}}
{{--                                Student Name: {$fees->student_name}--}}S
{{--                                Course: {$fees->class_name}--}}
{{--                                Paid Fee: \${$fees->paid}--}}
{{--                                Previous Balance: \${$fees->remaining_balance}--}}
{{--                                Remaining Balance: \${$fees->previous_balance}--}}
{{--                                Paid On: {$fees->receipt_date}--}}
{{--                                School: Mawarid Tech Academy--}}
{{--                            ") !!}--}}
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

    </div>

{{--    <script>--}}
{{--        document.addEventListener("DOMContentLoaded", function() {--}}
{{--            // Generate QR Code with all the details--}}
{{--            const qrContent = `--}}
{{--                    Student Name: ${studentName}--}}
{{--                    Course: ${course}--}}
{{--                    Paid Fee: $${paidFee}--}}
{{--                    @if($fees->remaining_balance != 0)--}}
{{--            Previous Fee: $${previousFee}--}}
{{--                    @endif--}}
{{--            Balance: $${balanceFee}--}}
{{--                    Paid On: ${date}--}}
{{--                    School: Mawarid Tech Academy--}}
{{--                `;--}}
{{--            new QRCode(document.getElementById('qr-code'), {--}}
{{--                text: qrContent,--}}
{{--                width: 100,--}}
{{--                height: 100--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}

</body>
</html>
