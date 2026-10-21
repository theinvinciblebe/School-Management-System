@php
    $themeCookie = request()->cookie('theme') ?? ($_COOKIE['theme'] ?? null);
    $isDark = ($themeCookie === 'dark-mode');
@endphp
<!DOCTYPE html>
<html lang="en" class="{{ $isDark ? 'dark-mode' : '' }}" style="{{ $isDark ? 'background-color: #232323ff !important; color-scheme: dark !important;' : '' }}">
<head>
    <script>
        (function() {
            try {
                var theme = localStorage.getItem('theme');
                if (!theme) {
                    var m = document.cookie.match(/(?:^|; )theme=([^;]*)/);
                    if (m) theme = m[1];
                }
                var isDark = theme === 'dark-mode' || (!theme && window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches);
                if (isDark) {
                    document.documentElement.classList.add('dark-mode');
                    document.documentElement.style.backgroundColor = '#686868ff';
                    document.documentElement.style.colorScheme = 'dark';
                    if (!document.cookie.includes('theme=dark-mode')) {
                        document.cookie = "theme=dark-mode; path=/; max-age=31536000; SameSite=Lax";
                    }
                } else if (theme === 'light-mode') {
                    document.documentElement.classList.remove('dark-mode');
                    document.documentElement.style.backgroundColor = '';
                    document.documentElement.style.colorScheme = 'light';
                    if (!document.cookie.includes('theme=light-mode')) {
                        document.cookie = "theme=light-mode; path=/; max-age=31536000; SameSite=Lax";
                    }
                }
            } catch(e) {}
        })();
    </script>
    <style>
        /* Immediate baseline prevention of FOUC / white flicker */
        html.dark-mode {
            background-color: #232323 !important;
            color: #ffffff !important;
            color-scheme: dark !important;
        }
        html.dark-mode body,
        html.dark-mode #mainBody,
        html.dark-mode .wrapper,
        html.dark-mode .content-wrapper,
        html.dark-mode .preloader {
            background-color: #232323 !important;
            color: #ffffff !important;
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>
        function showOverlay() {
            var wrapper = document.getElementById('mainOverlayWrapper') || document.querySelector('.overlay-wrapper');
            if (!wrapper) return;
            var overlay = document.getElementById('contentOverlay');
            if (!overlay) {
                overlay = document.createElement('div');
                overlay.id = 'contentOverlay';
                overlay.className = 'overlay';
                overlay.innerHTML = `
                    <div class="overlay-content">
                        <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                        <div class="text-bold pt-2">Loading...</div>
                    </div>
                `;
                wrapper.appendChild(overlay);
            } else {
                overlay.style.display = 'flex';
            }
        }
        window.showOverlay = showOverlay;
    </script>

    <title>{{ $customizes->url_title ?? config('app.name') }}</title>

    @php
        $rawFavicon = $customizes->url_icon ?? 'favicon.ico';
        $faviconVer = file_exists(public_path($rawFavicon)) ? filemtime(public_path($rawFavicon)) : time();
    @endphp
    <!-- Favicon -->
    <link rel="icon"
          id="app-favicon"
          href="{{ asset($rawFavicon) }}?v={{ $faviconVer }}"
          type="image/x-icon">

    <!-- CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- jQuery -->
    <script src="/assets/plugins/jquery/jquery.min.js"></script>

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
        html:not(.dark-mode) body,
        .light-mode {
            background-color: #f4f6f9;
            color: #1f2d3d;
        }

        /* Dark Mode */
        html.dark-mode,
        html.dark-mode body,
        html.dark-mode #mainBody,
        html.dark-mode .content-wrapper,
        .dark-mode {
            background-color: #232323 !important;
            color: #ffffff !important;
        }

        /* =========================================================
           Modern Sidebar Dark/Light Mode Switch
           ========================================================= */
        .theme-mode-item {
            padding: 0.25rem 0.6rem !important;
            list-style: none;
        }

        .theme-mode-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.55rem 0.85rem;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            user-select: none;
            backdrop-filter: blur(8px);
        }

        .theme-mode-wrapper:hover {
            background: rgba(255, 255, 255, 0.16);
            border-color: rgba(255, 255, 255, 0.25);
            transform: translateY(-1px);
        }

        .sidebar-light .theme-mode-wrapper {
            background: rgba(0, 0, 0, 0.05);
            border-color: rgba(0, 0, 0, 0.1);
        }

        .sidebar-light .theme-mode-wrapper:hover {
            background: rgba(0, 0, 0, 0.08);
            border-color: rgba(0, 0, 0, 0.15);
        }

        .theme-mode-label {
            display: flex;
            align-items: center;
            gap: 0.55rem;
            margin: 0;
            color: #c2c7d0;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
        }

        .sidebar-light .theme-mode-label {
            color: #343a40;
        }

        .dark-mode .theme-mode-label {
            color: #f1f5f9;
        }

        .theme-icon-container {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 22px;
            height: 22px;
        }

        .theme-icon-sun {
            color: #f59e0b;
            font-size: 1rem;
            filter: drop-shadow(0 0 5px rgba(245, 158, 11, 0.5));
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .theme-icon-moon {
            color: #38bdf8;
            font-size: 1rem;
            filter: drop-shadow(0 0 6px rgba(56, 189, 248, 0.6));
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .theme-mode-wrapper:hover .theme-icon-sun {
            transform: rotate(30deg) scale(1.15);
        }

        .theme-mode-wrapper:hover .theme-icon-moon {
            transform: rotate(-15deg) scale(1.15);
        }

        /* The Pill Switch */
        .modern-theme-switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 25px;
            margin: 0;
            cursor: pointer;
        }

        .modern-theme-switch input {
            opacity: 0;
            width: 0;
            height: 0;
            position: absolute;
        }

        .theme-slider {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
            border: 1.5px solid #94a3b8;
            border-radius: 9999px;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.08);
        }

        .slider-icons {
            position: absolute;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 5px;
            font-size: 0.65rem;
            pointer-events: none;
            box-sizing: border-box;
        }

        .slider-sun {
            color: #f59e0b;
            opacity: 0.9;
            transition: all 0.3s ease;
        }

        .slider-moon {
            color: #cbd5e1;
            opacity: 0.3;
            transition: all 0.3s ease;
        }

        .slider-knob {
            position: absolute;
            content: "";
            height: 17px;
            width: 17px;
            left: 3px;
            bottom: 2.5px;
            background: #ffffff;
            border-radius: 50%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.25);
            transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        /* Checked: Dark Mode ON */
        .modern-theme-switch input:checked + .theme-slider {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);
            border-color: #6366f1;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.4), 0 0 8px rgba(99, 102, 241, 0.4);
        }

        .modern-theme-switch input:checked + .theme-slider .slider-knob {
            transform: translateX(23px);
            background: #ffffff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.4), 0 0 8px rgba(165, 180, 252, 0.6);
        }

        .modern-theme-switch input:checked + .theme-slider .slider-sun {
            opacity: 0.2;
            transform: scale(0.65);
        }

        .modern-theme-switch input:checked + .theme-slider .slider-moon {
            color: #38bdf8;
            opacity: 1;
            transform: scale(1.1);
            filter: drop-shadow(0 0 3px rgba(56, 189, 248, 0.5));
        }

        /* Smooth Theme Transitions across the page */
        body.theme-transitioning,
        body.theme-transitioning .main-header,
        body.theme-transitioning .main-sidebar,
        body.theme-transitioning .content-wrapper,
        body.theme-transitioning .card,
        body.theme-transitioning .table,
        body.theme-transitioning .nav-link {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease !important;
        }

        .preloader {
            background-color: #f4f6f9;
        }

        html.dark-mode .preloader,
        body.dark-mode .preloader,
        .dark-mode .preloader {
            background-color: #232323 !important;
            color: #ffffff !important;
        }

        @keyframes preloaderWobble {
            0%, 100% {
                transform: scale(1) rotate(0deg);
            }
            20% {
                transform: scale(1.04) rotate(-3deg);
            }
            40% {
                transform: scale(0.98) rotate(3deg);
            }
            60% {
                transform: scale(1.02) rotate(-2deg);
            }
            80% {
                transform: scale(0.99) rotate(2deg);
            }
        }

        .animation__wobble {
            animation: preloaderWobble 1.5s ease-in-out infinite !important;
        }

        .preloader-brand-img {
            width: 120px !important;
            height: 120px !important;
            max-width: 120px !important;
            max-height: 120px !important;
            min-width: 120px !important;
            min-height: 120px !important;
            object-fit: cover !important;
            border-radius: 50% !important;
            aspect-ratio: 1 / 1 !important;
            background-color: #ffffff;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
        }

        #notification-list  {
            display: flex;
            align-items: center;
            white-space: nowrap;  /* Prevent text from wrapping */
            overflow: hidden;  /* Hide overflow text */
            text-overflow: ellipsis;  /* Add '...' for overflowing text */
            max-width: 320px; /* Adjust width to fit */

        }

        /* =========================================================
           Sidebar OverlayScrollbars & Track Positioning & Styling
           ========================================================= */
        .main-sidebar .sidebar .os-scrollbar-vertical {
            width: 7px !important;
            right: 2px !important;
            top: 2px !important;
            bottom: 4px !important;
            z-index: 1050;
            transition: width 0.2s ease, opacity 0.2s ease;
        }

        .main-sidebar .sidebar .os-scrollbar-vertical:hover {
            width: 9px !important;
        }

        /* Visible track groove consistent with sidebar selected position and background */
        .main-sidebar .sidebar .os-scrollbar-track {
            background: rgba(255, 255, 255, 0.06) !important;
            border-radius: 9999px !important;
            width: 100% !important;
            transition: background 0.2s ease;
        }

        .main-sidebar.sidebar-light .sidebar .os-scrollbar-track,
        .sidebar-light-primary .sidebar .os-scrollbar-track,
        [class*="sidebar-light-"] .sidebar .os-scrollbar-track {
            background: rgba(0, 0, 0, 0.07) !important;
        }

        /* Handle styling */
        .main-sidebar .sidebar .os-scrollbar-handle {
            border-radius: 9999px !important;
            background: rgba(255, 255, 255, 0.3) !important;
            transition: background-color 0.2s ease;
        }

        .main-sidebar .sidebar:hover .os-scrollbar-handle {
            background: rgba(255, 255, 255, 0.45) !important;
        }

        .main-sidebar .sidebar .os-scrollbar-handle:hover,
        .main-sidebar .sidebar .os-scrollbar-handle.active {
            background: rgba(255, 255, 255, 0.7) !important;
        }

        /* Light sidebar handle styles */
        [class*="sidebar-light-"] .sidebar .os-scrollbar-handle,
        .main-sidebar.sidebar-light .sidebar .os-scrollbar-handle {
            background: rgba(0, 0, 0, 0.28) !important;
        }

        [class*="sidebar-light-"] .sidebar:hover .os-scrollbar-handle,
        .main-sidebar.sidebar-light .sidebar:hover .os-scrollbar-handle {
            background: rgba(0, 0, 0, 0.45) !important;
        }

        [class*="sidebar-light-"] .sidebar .os-scrollbar-handle:hover,
        [class*="sidebar-light-"] .sidebar .os-scrollbar-handle.active {
            background: rgba(0, 0, 0, 0.65) !important;
        }

        /* =========================================================
           Brand Logo Perfect Circle
           ========================================================= */
        .brand-link .brand-image,
        .brand-link .brand-image.img-circle,
        .main-sidebar .brand-link .brand-image {
            width: 33px !important;
            height: 33px !important;
            max-width: 33px !important;
            max-height: 33px !important;
            min-width: 33px !important;
            min-height: 33px !important;
            border-radius: 50% !important;
            object-fit: cover !important;
            aspect-ratio: 1 / 1 !important;
            background-color: #ffffff;
            display: inline-block;
        }

        /* =========================================================
           Overlay-Wrapper Data Loader Styling (AdminLTE Scoped Loader)
           Covers ONLY .overlay-wrapper content, never sidebar/navbar/logo
           ========================================================= */
        .content-wrapper > .overlay-wrapper,
        .overlay-wrapper {
            position: relative !important;
            min-height: calc(100vh - 120px);
        }

        .overlay-wrapper > .overlay {
            position: absolute !important;
            top: 0;
            left: 0;
            width: 100% !important;
            height: 100% !important;
            min-height: 100% !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: center !important;
            align-items: center !important;
            z-index: 1040 !important;
            background-color: rgba(244, 246, 249, 0.78) !important;
            backdrop-filter: blur(2px);
            color: #495057 !important;
            border-radius: 0.25rem;
        }

        html.dark-mode .overlay-wrapper > .overlay,
        body.dark-mode .overlay-wrapper > .overlay,
        .dark-mode .overlay-wrapper > .overlay {
            background-color: rgba(35, 35, 35, 0.85) !important;
            color: #ffffff !important;
        }

        .overlay-wrapper > .overlay .overlay-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .overlay-wrapper > .overlay i {
            font-size: 2.2rem;
            margin-bottom: 0.6rem;
            color: #007bff;
        }

        html.dark-mode .overlay-wrapper > .overlay i,
        body.dark-mode .overlay-wrapper > .overlay i {
            color: #3f9aff;
        }

        /* Ensure active and opening treeviews are rendered open immediately without slide/flicker */
        .nav-sidebar .menu-open > .nav-treeview,
        .nav-sidebar .menu-is-opening > .nav-treeview {
            display: block !important;
        }
    </style>

    @stack('styles')
</head>


