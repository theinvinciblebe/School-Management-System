<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $customizes->url_title ?? config('app.name') }}</title>

    <!-- Favicon -->
    <link rel="icon"
          href="{{ asset(($customizes->url_icon ?? 'favicon.ico')) }}"
          type="image/x-icon">

    <!-- CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- Ionicons -->
    <link rel="stylesheet"
          href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Plugins -->
    <link rel="stylesheet"
          href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

    <link rel="stylesheet"
          href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">

    <link rel="stylesheet"
          href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css">

    <link rel="stylesheet"
          href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">

    <link rel="stylesheet"
          href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">

    <link rel="stylesheet"
          href="{{ asset('assets/plugins/bs-stepper/css/bs-stepper.min.css') }}">

    <link rel="stylesheet"
          href="{{ asset('assets/plugins/dropzone/min/dropzone.min.css') }}">

    <link rel="stylesheet"
          href="{{ asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

    <!-- DataTables -->
    <link rel="stylesheet"
          href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">

    <link rel="stylesheet"
          href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

    <link rel="stylesheet"
          href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <!-- Summernote -->
    <link rel="stylesheet"
          href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}">

    <!-- AdminLTE -->
    <link rel="stylesheet"
          href="{{ asset('assets/dist/css/adminlte.min.css') }}">

    <!-- Toastr -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Bootstrap Switch -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/css/bootstrap3/bootstrap-switch.min.css">

    <!-- QR Code -->
    <script defer
            src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

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
        .small-box:hover {
            transform: scale(1.03);
            transition: 0.3s;
        }
        .small-box .inner h3 {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
            display: block;
        }
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
        input:-webkit-autofill {
            background-color: transparent !important;
            -webkit-box-shadow: 0 0 0px 1000px #fff inset !important; /* Ensures background matches normal input */
            -webkit-text-fill-color: #000 !important; /* Ensures the text color remains normal */
            border-color: #ced4da !important; /* Optional: Adjust border if needed */
            transition: background-color 5000s ease-in-out 0s; /* Fix flickering issue */
        }

        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            background-color: transparent !important;
            -webkit-box-shadow: 0 0 0px 1000px #fff inset !important;
            -webkit-text-fill-color: #000 !important;
            border-color: #ced4da !important;
        }


        /* Light Mode */
        .light-mode {
            background-color: #f5f5f5;
            color: #000;
        }

        /* Dark Mode */
        .dark-mode {
            background-color: #1a1a1a;
            color: #fff;
        }

        .preloader {
            background-color: #ffffff !important; /* Change the background color */
            /*display: none !important;*/
        }

        .animation__wobble {
            animation: myCustomWobble 0.1s infinite !important; /* Customize animation */
        }

        #notification-list  {
            display: flex;
            align-items: center;
            white-space: nowrap;  /* Prevent text from wrapping */
            overflow: hidden;  /* Hide overflow text */
            text-overflow: ellipsis;  /* Add '...' for overflowing text */
            max-width: 320px; /* Adjust width to fit */

        }
    </style>

    @stack('styles')
</head>


