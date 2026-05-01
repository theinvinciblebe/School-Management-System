<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $customizes->url_title ?? 'N/A'}}</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
{{--    <link rel="icon" href="{{ asset('customize_images/' . ($customizes->url_icon ?? 'noimg.jpg')) }}?v={{ time() }}" type="image/x-icon">--}}

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="/assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Timepicker CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css">

    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/assets/plugins/daterangepicker/daterangepicker.css">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="/assets/plugins/bs-stepper/css/bs-stepper.min.css">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="/assets/plugins/dropzone/min/dropzone.min.css">

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="/assets/plugins/summernote/summernote-bs4.min.css">

    <link rel="stylesheet" href="/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <!-- Include Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Include Tailwind CSS -->
{{--    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">--}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Flatpickr CSS -->
{{--    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">--}}

    <style>
        .bg-darkred{
            background: #7c151f;
            border-color:#1b55e2;
            color: #fff;
        }

        .table .btn-group {
            /*width: 100%;*/
            /*display: flex;*/
            justify-content: center;
        }
        /*.table .dropdown-menu {*/
        /*    !*min-width: 120px;*!*/
        /*    padding: 0;*/
        /*}*/
        /*.table .dropdown-menu .dropdown-item {*/
        /*    padding: 8px 12px;*/
        /*    font-size: 14px;*/
        /*    display: flex;*/
        /*    align-items: center;*/
        /*}*/

        /*.table .dropdown-menu .dropdown-item i {*/
        /*    margin-right: 8px;*/
        /*}*/
    </style>

    <style>
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: white;
            z-index: 1000;
        }

        .system-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        display: none;
        z-index: 9999;
        justify-content: center;
        align-items: center;
        }

    .spinner-container {
        text-align: center;
    }

    .spinner-border {
        width: 4rem;
        height: 4rem;
    }

    @media (max-width: 768px) {
        .content-wrapper {
            overflow-x: auto;
        }
    }

    </style>

    <style>
        .small-box:hover {
            transform: scale(1.03);
            transition: 0.3s;
        }

        /*.small-box .inner h3 {*/
        /*    font-size: 1.5rem; !* Adjust size if needed *!*/
        /*    overflow-wrap: break-word;*/
        /*    word-wrap: break-word;*/
        /*    white-space: normal;*/
        /*    max-width: 100%;*/
        /*}*/

        .small-box .inner h3 {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
            display: block;
        }
    </style>

    <style>
        .floating-button {
            position: fixed;
            bottom: 50px; /* Distance from the bottom of the screen */
            right: 20px;  /* Distance from the right side of the screen */
            z-index: 9999; /* Ensures the button is on top of other elements */
            border-radius: 50%; /* Circular button */
            width: 60px; /* Width of the circle */
            height: 60px; /* Height of the circle */
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #28a745; /* Green color */
            color: white;
            font-size: 40px; /* Size of the icon */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Optional shadow for effect */
            transition: all 0.3s ease; /* Optional smooth transition for hover effects */
        }

        .floating-button:hover {
            background-color: #218838; /* Darker green on hover */
            transform: scale(1.1); /* Slightly enlarge button on hover */
        }

    </style>

</head>
