@extends('layout.main')

@section('content')

    <style>
        @media print {
            body {
                margin: 0;
                padding: 0;
                font-size: 12px;
                /*-webkit-print-color-adjust: exact !important; !* Ensures colors print *!*/
                /*print-color-adjust: exact !important;*/
            }

            .container {
                width: 100%;
                max-width: 100%;
                /*padding: 20px;*/
            }
            p{
                font-size: 20px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                border: 3px solid black !important; /* Increase outer border thickness */
            }

            th, td {
                border: 2px solid black !important; /* Make inner borders thinner */
                padding: 8px;
                font-size: 15px;
                text-align: center;
            }
            .text-right {
                text-align: right !important;
            }

            .btn, .d-flex {
                display: none !important; /* Hide Buttons */
            }

            .p_head p {
                margin: 2px 0;
                padding: 0; /* Removes any extra padding */
            }

            tfoot tr {
                border: none !important;
            }

            tfoot td {
                border: none !important;
            }
            .no-border {
                border: none !important;
            }

            .no-border td {
                border: none !important;
            }

            @page {
                size: A4 portrait;  /* Defines A5 size in portrait orientation */
                margin: 0;
                margin-top: -30px;
                /*margin: 10mm;  !* Sets uniform margins on all sides *!*/
                /*bleed: 3mm; !* (Optional) Adds a bleed for printing *!*/
                /*marks: crop; !* (Optional) Adds crop marks for printing *!*/
            }

        }
    </style>

    <style>
        * {
            box-sizing: border-box;
        }

        .p_head p {
            margin: 2px 0;
            padding: 0; /* Removes any extra padding */
        }

        tfoot tr {
            border: none !important;
        }

        tfoot td {
            border: none !important;
        }
        .no-border {
            border: none !important;
        }

        .no-border td {
            border: none !important;
        }

    </style>

    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <div class="row">
                    <div class="col-md-3 float-right">
                        <img src="{{ asset('logo-txt.png') }}" alt="MAWARID LOGO" style="width: 250px; height: auto;">
                    </div>
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-6 float-left" style="margin-top: 20px">
                        <h3><b>PURCHASE REQUISITION FORM</b></h3>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row p_head">
                    <div class="col-md-4">
                        <p><strong>Requisitioner:</strong><b> {{ $purchase->requisitioner }}</b></p>
                        <p><strong>Department:</strong> {{ $purchase->department }}</p>
                        <p><strong>Purpose:</strong> {{ $purchase->purpose }}</p>
                    </div>
                    <div class="col-md-3"></div>
                    <div class="col-md-4 float-right">
                        <p><strong>Purchase Request No:</strong> {{ $purchase->request_no }}</p>
                        <p><strong>Date Prepared:</strong> {{ $purchase->date_prepared }}</p>
                        <p><strong>Date Needed:</strong> {{ $purchase->date_needed }}</p>
                    </div>
                </div>

                <table class="table table-bordered dtr-inline mt-3" style="border: 3px solid black;">
{{--                    <thead style="background-color: darkred !important; color: white !important;">--}}
                    <thead class="thead-light">
                    <tr align="center">
                            <th>No.</th>
                            <th>Description</th>
{{--                            <th>Asset Class</th>--}}
                            <th>Qty</th>
                            <th>Unit</th>
                            <th>Unit Price</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $grandTotal = 0; @endphp
                    @foreach ($items as $index => $purchases)
                        <tr>
                            <td style="border: 3px solid black;">{{ $index + 1}}</td>
                            <td style="border: 3px solid black;">{{ $purchases->description }}</td>
{{--                            <td style="border: 3px solid black;">{{ $purchases->asset_class }}</td>--}}
                            <td style="border: 3px solid black;">{{ $purchases->qty }}</td>
                            <td style="border: 3px solid black;">{{ $purchases->unit ?? ' '}}</td>
                            <td style="border: 3px solid black;">${{ number_format($purchases->unit_price, 2) }}</td>
                            <td style="border: 3px solid black;">${{ number_format($purchases->total_price, 2) }}</td>
                        </tr>
                        @php $grandTotal += $purchases->total_price; @endphp
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="no-border">
                            <td colspan="5" class="text-right"><strong>Total Amount:</strong></td>
                            <td align="center"><strong>${{ number_format($grandTotal, 2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
                <div class="row mt-4"></div>
                <div class="col-md-6">
                    <p><strong>Vendor: </strong>{{ $purchase->vendor ?? 'No Assigned' }}</p>
                </div>
                <div class="row mt-4"></div>
                <div class="row mt-4"></div>
                <div class="row mt-4"></div>

                <div class="row mt-4">

                    <div class="col-md-6">
                        <p><strong>Authorized By:</strong> {{ $purchase->approver_name ?? 'Pending' }}</p>
                    </div>
                </div>
                <div class="row mt-4"></div>
                <p class="text-muted">
                    Note: This form has been approved by <strong>Admin</strong>.
                    So there's no <strong>Signature</strong> from Authorize.
                </p>
            </div>
        </div>
        <button onclick="window.print()" class="btn btn-success mt-3 float-right"><i class="fas fa-print"></i> Print</button>
{{--        <button type="button" class="btn btn-primary mt-3 float-right" style="margin-right: 5px;">--}}
{{--            <i class="fas fa-download"></i> Generate PDF--}}
{{--        </button>--}}
        <a href="{{ route('purchase_req.index') }}" class="btn btn-secondary mt-3">Back to List</a>
    </div>
@endsection
