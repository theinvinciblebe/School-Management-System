@php
    $themeCookie = request()->cookie('theme') ?? ($_COOKIE['theme'] ?? null);
    $isDark = ($themeCookie === 'dark-mode');
    $currentLang = app()->getLocale();
@endphp
<!DOCTYPE html>
<html lang="{{ $currentLang }}" class="{{ $isDark ? 'dark-mode' : '' }} {{ $currentLang === 'km' ? 'lang-km' : '' }}" style="{{ $isDark ? 'background-color: #232323ff !important; color-scheme: dark !important;' : '' }}">
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
                    document.documentElement.style.backgroundColor = '#232323';
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

                // Check for reload vs internal route navigation
                var navEntry = (window.performance && performance.getEntriesByType) ? performance.getEntriesByType('navigation')[0] : null;
                if (navEntry && navEntry.type === 'reload') {
                    // Browser refresh (F5): treat as fresh reload, let preloader run
                    sessionStorage.removeItem('is_route_navigating');
                } else if (sessionStorage.getItem('is_route_navigating') === '1') {
                    // Internal route navigation: immediately suppress preloader before layout paint
                    document.documentElement.classList.add('hide-preloader');
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
        html.dark-mode .preloader,
        html.dark-mode .system-preloader {
            background-color: #232323 !important;
            color: #ffffff !important;
        }

        /* Instant suppression of preloader on route changes */
        html.hide-preloader #systemPreloader,
        html.hide-preloader .system-preloader,
        html.hide-preloader .preloader {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            pointer-events: none !important;
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- High Speed DNS Prefetch & Preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="https://code.ionicframework.com">

    <!-- Preload Critical Icon Webfonts for Instant Zero-FOIT Navigation -->
    <link rel="preload" href="{{ asset('assets/plugins/fontawesome-free/webfonts/fa-solid-900.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('assets/plugins/fontawesome-free/webfonts/fa-regular-400.woff2') }}" as="font" type="font/woff2" crossorigin>

    <!-- Speculation Rules: Blazing fast navigation on moderate/hover intent -->
    <script type="speculationrules">
    {
      "prefetch": [
        {
          "source": "document",
          "where": {
            "and": [
              { "href_matches": "/*" },
              { "not": { "href_matches": "*/logout*" } },
              { "not": { "href_matches": "*delete*" } },
              { "not": { "selector_matches": ".no-prefetch" } }
            ]
          },
          "eagerness": "moderate"
        }
      ]
    }
    </script>

    <!-- Global Unhandled Rejection Safeguard -->
    <script>
        window.addEventListener('unhandledrejection', function(event) {
            if (event.reason && (
                event.reason.name === 'InvalidStateError' ||
                (typeof event.reason.message === 'string' && event.reason.message.includes('Transition was aborted'))
            )) {
                event.preventDefault();
            }
        });
    </script>

    <script>
        function showOverlay() {
            try {
                sessionStorage.setItem('is_route_navigating', '1');
            } catch(e) {}
            var wrapper = document.getElementById('mainOverlayWrapper') || document.querySelector('.content-wrapper .overlay-wrapper') || document.querySelector('.overlay-wrapper');
            if (!wrapper) return;
            var overlay = document.getElementById('contentOverlay');
            if (!overlay) {
                overlay = document.createElement('div');
                overlay.id = 'contentOverlay';
                overlay.className = 'overlay';
                overlay.innerHTML = `
                    <div class="overlay-content">
                        <i class="fas fa-2x fa-spinner fa-spin"></i>
                        <div class="text-bold pt-2" style="font-size: 0.92rem; letter-spacing: 0.5px;">Loading...</div>
                    </div>
                `;
                wrapper.appendChild(overlay);
            } else {
                overlay.style.display = 'flex';
            }
        }
        window.showOverlay = showOverlay;

        function hideOverlay() {
            try {
                sessionStorage.removeItem('is_route_navigating');
            } catch(e) {}
            var overlay = document.getElementById('contentOverlay');
            if (overlay) {
                overlay.style.display = 'none';
                if (overlay.parentNode) {
                    overlay.parentNode.removeChild(overlay);
                }
            }
        }
        window.hideOverlay = hideOverlay;

        // Global link navigation tracker: ensures route changes never show the system preloader
        document.addEventListener('click', function(e) {
            var a = e.target.closest('a');
            if (!a || !a.href) return;
            var href = a.getAttribute('href') || '';
            if (a.target === '_blank' || href.startsWith('#') || href.startsWith('javascript:')) return;
            try {
                var url = new URL(a.href, window.location.origin);
                if (url.origin === window.location.origin) {
                    sessionStorage.setItem('is_route_navigating', '1');
                    // Automatically trigger the content loading overlay on sidebar or header navigation
                    if (a.closest('.main-sidebar') || a.closest('.main-header')) {
                        showOverlay();
                    }
                }
            } catch(err) {}
        }, true);

        // Forms navigation tracker: ensure form submissions don't trigger the system preloader
        document.addEventListener('submit', function(e) {
            if (e.target && (e.target.getAttribute('data-no-overlay') === 'true' || e.target.getAttribute('data-ajax') === 'true')) {
                return;
            }
            try {
                sessionStorage.setItem('is_route_navigating', '1');
                showOverlay();
            } catch(err) {}
        }, true);

        // Fresh Start preloader controller: gracefully fades out when page is fully ready
        function dismissPreloader() {
            var preloader = document.getElementById('systemPreloader') || document.querySelector('.system-preloader') || document.querySelector('.preloader');
            if (!preloader) return;
            preloader.classList.add('preloader-hidden');
            preloader.style.opacity = '0';
            preloader.style.pointerEvents = 'none';
            setTimeout(function() {
                if (preloader && preloader.parentNode) {
                    preloader.parentNode.removeChild(preloader);
                }
            }, 450);
        }
        window.dismissPreloader = dismissPreloader;

        // Dismiss on interactive/complete state, DOMContentLoaded, and window load
        if (document.readyState === 'complete' || document.readyState === 'interactive') {
            setTimeout(dismissPreloader, 100);
        }
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(dismissPreloader, 200);
            setTimeout(function() {
                try {
                    sessionStorage.removeItem('is_route_navigating');
                    document.documentElement.classList.remove('hide-preloader');
                } catch(e) {}
            }, 300);
        });
        window.addEventListener('load', function() {
            setTimeout(dismissPreloader, 100);
        });

        // Safety fallback timers so the preloader can NEVER remain stuck
        setTimeout(dismissPreloader, 500);
        setTimeout(dismissPreloader, 1000);
        setTimeout(dismissPreloader, 1800);
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

    <!-- Toastr (Loaded early after jQuery) -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Google Fonts -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:ital,wght@0,300..700;1,300..700&display=swap">

    <!-- Flag Icon CSS -->
    <link rel="stylesheet"
          href="{{ asset('assets/plugins/flag-icon-css/css/flag-icon.min.css') }}">

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
          href="{{ asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

    <!-- DataTables -->
    <link rel="stylesheet"
          href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">

    <link rel="stylesheet"
          href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

    <link rel="stylesheet"
          href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <!-- AdminLTE -->
    <link rel="stylesheet"
          href="{{ asset('assets/dist/css/adminlte.min.css') }}">

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

        @keyframes preloaderAutoDismiss {
            0%, 75% {
                opacity: 1;
                visibility: visible;
            }
            100% {
                opacity: 0;
                visibility: hidden;
                pointer-events: none;
            }
        }

        .system-preloader,
        .preloader {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            z-index: 999999 !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: center !important;
            align-items: center !important;
            background-color: #f4f6f9 !important;
            overflow: hidden !important;
            opacity: 1;
            visibility: visible;
            transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.4s ease !important;
            animation: preloaderAutoDismiss 1.8s ease 0.4s forwards !important;
        }

        .system-preloader.preloader-hidden,
        .preloader.preloader-hidden {
            opacity: 0 !important;
            visibility: hidden !important;
            pointer-events: none !important;
            animation: none !important;
        }

        html.dark-mode .system-preloader,
        body.dark-mode .system-preloader,
        .dark-mode .system-preloader,
        html.dark-mode .preloader,
        body.dark-mode .preloader,
        .dark-mode .preloader {
            background-color: #232323 !important;
            color: #ffffff !important;
        }

        @keyframes preloaderSmoothWobble {
            0%, 100% {
                transform: scale(1) rotate(0deg);
            }
            20% {
                transform: scale(1.08) rotate(-4deg);
            }
            40% {
                transform: scale(0.96) rotate(4deg);
            }
            60% {
                transform: scale(1.04) rotate(-2deg);
            }
            80% {
                transform: scale(0.98) rotate(1deg);
            }
        }

        .system-preloader .preloader-brand-img,
        .system-preloader .animation__wobble,
        .preloader .animation__wobble {
            animation: preloaderSmoothWobble 1.6s ease-in-out infinite !important;
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
           Modern Floating OverlayScrollbars Remake (.os-scrollbar)
           ========================================================= */
        /* Completely eliminate horizontal scrollbar on the sidebar */
        .main-sidebar .os-scrollbar-horizontal,
        .main-sidebar .sidebar .os-scrollbar-horizontal {
            display: none !important;
            visibility: hidden !important;
            height: 0 !important;
            pointer-events: none !important;
        }

        /* Vertical scrollbar container: floating pill with clean margin */
        .main-sidebar .sidebar .os-scrollbar-vertical,
        .os-scrollbar-vertical {
            width: 6px !important;
            right: 4px !important;
            top: 6px !important;
            bottom: 6px !important;
            padding: 0 !important;
            box-sizing: border-box !important;
            z-index: 1050;
            border-radius: 9999px !important;
            transition: width 0.22s cubic-bezier(0.2, 0, 0, 1),
                        opacity 0.28s cubic-bezier(0.2, 0, 0, 1),
                        transform 0.22s cubic-bezier(0.2, 0, 0, 1) !important;
        }

        /* Expand comfortably on sidebar or scrollbar hover for effortless grabbing */
        .main-sidebar:hover .sidebar .os-scrollbar-vertical,
        .main-sidebar .sidebar .os-scrollbar-vertical:hover,
        .os-scrollbar-vertical:hover {
            width: 8px !important;
        }

        /* Track groove styling */
        .main-sidebar .sidebar .os-scrollbar-track,
        .os-scrollbar-track {
            background: transparent !important;
            border-radius: 9999px !important;
            width: 100% !important;
            padding: 0 !important;
            border: none !important;
            transition: background-color 0.22s ease !important;
        }

        /* Reveal subtle groove on hover */
        .main-sidebar:hover .sidebar .os-scrollbar-track,
        .main-sidebar .sidebar .os-scrollbar-vertical:hover .os-scrollbar-track {
            background: rgba(255, 255, 255, 0.05) !important;
        }

        .main-sidebar.sidebar-light:hover .sidebar .os-scrollbar-track,
        .sidebar-light-primary:hover .sidebar .os-scrollbar-track,
        [class*="sidebar-light-"]:hover .sidebar .os-scrollbar-track,
        .main-sidebar.sidebar-light .sidebar .os-scrollbar-vertical:hover .os-scrollbar-track,
        [class*="sidebar-light-"] .sidebar .os-scrollbar-vertical:hover .os-scrollbar-track {
            background: rgba(0, 0, 0, 0.04) !important;
        }

        /* Handle (Thumb) capsule styling */
        .main-sidebar .sidebar .os-scrollbar-handle,
        .os-scrollbar-handle {
            border-radius: 9999px !important;
            background: rgba(255, 255, 255, 0.32) !important;
            width: 100% !important;
            min-height: 36px !important;
            transition: background-color 0.2s cubic-bezier(0.2, 0, 0, 1),
                        box-shadow 0.2s cubic-bezier(0.2, 0, 0, 1),
                        transform 0.15s ease !important;
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }

        /* Hover on sidebar reveals handle clearly */
        .main-sidebar:hover .sidebar .os-scrollbar-handle {
            background: rgba(255, 255, 255, 0.48) !important;
        }

        /* Direct hover on handle creates vibrant feedback */
        .main-sidebar .sidebar .os-scrollbar-handle:hover,
        .os-scrollbar-handle:hover {
            background: rgba(255, 255, 255, 0.8) !important;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.35);
        }

        /* Dragging active state */
        .main-sidebar .sidebar .os-scrollbar-handle.active,
        .os-scrollbar-handle.active,
        body.os-dragging .main-sidebar .sidebar .os-scrollbar-handle {
            background: #ffffff !important;
            box-shadow: 0 0 14px rgba(255, 255, 255, 0.6);
            transform: scale(1.05);
        }

        /* Light sidebar handle styles */
        .main-sidebar.sidebar-light .sidebar .os-scrollbar-handle,
        .sidebar-light-primary .sidebar .os-scrollbar-handle,
        [class*="sidebar-light-"] .sidebar .os-scrollbar-handle {
            background: rgba(0, 0, 0, 0.24) !important;
        }

        .main-sidebar.sidebar-light:hover .sidebar .os-scrollbar-handle,
        .sidebar-light-primary:hover .sidebar .os-scrollbar-handle,
        [class*="sidebar-light-"]:hover .sidebar .os-scrollbar-handle {
            background: rgba(0, 0, 0, 0.4) !important;
        }

        .main-sidebar.sidebar-light .sidebar .os-scrollbar-handle:hover,
        .sidebar-light-primary .sidebar .os-scrollbar-handle:hover,
        [class*="sidebar-light-"] .sidebar .os-scrollbar-handle:hover {
            background: rgba(0, 0, 0, 0.68) !important;
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.2);
        }

        .main-sidebar.sidebar-light .sidebar .os-scrollbar-handle.active,
        .sidebar-light-primary .sidebar .os-scrollbar-handle.active,
        [class*="sidebar-light-"] .sidebar .os-scrollbar-handle.active {
            background: rgba(0, 0, 0, 0.88) !important;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.3);
        }

        /* Prevent auto-hidden scrollbars from abruptly vanishing */
        .os-scrollbar.os-scrollbar-auto-hidden {
            opacity: 0 !important;
            visibility: hidden !important;
            pointer-events: none !important;
            transition: opacity 0.28s ease, visibility 0.28s ease !important;
        }

        /* Global System Scrollbars (WebKit & Firefox) matching the sleek pill aesthetic */
        * {
            scrollbar-width: thin;
            scrollbar-color: rgba(140, 140, 140, 0.35) transparent;
        }

        ::-webkit-scrollbar {
            width: 7px;
            height: 7px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background-color: rgba(140, 140, 140, 0.32);
            border-radius: 9999px;
            border: 2px solid transparent;
            background-clip: padding-box;
            transition: background-color 0.2s ease;
        }

        ::-webkit-scrollbar-thumb:hover {
            background-color: rgba(140, 140, 140, 0.6);
            background-clip: padding-box;
        }

        html.dark-mode * {
            scrollbar-color: rgba(255, 255, 255, 0.28) transparent;
        }

        html.dark-mode ::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.28);
            background-clip: padding-box;
        }

        html.dark-mode ::-webkit-scrollbar-thumb:hover {
            background-color: rgba(255, 255, 255, 0.5);
            background-clip: padding-box;
        }

        /* =========================================================
           Brand Logo & Preloader Perfect Circles
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

        .preloader-brand-img {
            width: 120px !important;
            height: 120px !important;
            max-width: 120px !important;
            max-height: 120px !important;
            min-width: 120px !important;
            min-height: 120px !important;
            border-radius: 50% !important;
            object-fit: cover !important;
            aspect-ratio: 1 / 1 !important;
            background-color: #ffffff;
        }

        /* =========================================================
           System Smoothness & Performance Acceleration
           ========================================================= */
        html {
            scroll-behavior: smooth;
        }

        @media (prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }
        }

        body {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
        }

        .main-header,
        .main-sidebar,
        .content-wrapper,
        .main-footer,
        .control-sidebar {
            transition: margin-left 0.24s cubic-bezier(0.2, 0, 0, 1),
                        transform 0.24s cubic-bezier(0.2, 0, 0, 1),
                        width 0.24s cubic-bezier(0.2, 0, 0, 1) !important;
            will-change: margin-left;
        }

        .content-wrapper {
            min-width: 0;
            overflow-x: clip;
        }
        @supports not (overflow-x: clip) {
            .content-wrapper {
                overflow-x: hidden;
            }
        }

        .nav-sidebar .nav-link {
            transition: background-color 0.18s cubic-bezier(0.2, 0, 0, 1),
                        color 0.18s cubic-bezier(0.2, 0, 0, 1),
                        transform 0.18s cubic-bezier(0.2, 0, 0, 1);
        }

        .nav-sidebar .nav-link:hover {
            transform: translateX(2px);
        }

        .card {
            transition: box-shadow 0.2s cubic-bezier(0.2, 0, 0, 1), transform 0.2s cubic-bezier(0.2, 0, 0, 1);
        }

        .btn {
            transition: all 0.18s cubic-bezier(0.2, 0, 0, 1) !important;
        }

        .btn:active {
            transform: scale(0.98);
        }

        .dropdown-menu.show {
            animation: smoothDropdownIn 0.18s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes smoothDropdownIn {
            from {
                opacity: 0;
                transform: translateY(4px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Silky Smooth Page Content Mount */
        #mainOverlayWrapper {
            animation: smoothContentMount 0.18s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes smoothContentMount {
            from {
                opacity: 0.92;
                transform: translateY(2px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* =========================================================
           Overlay-Wrapper Data Loader Styling (AdminLTE Scoped Loader)
           Covers ONLY #mainOverlayWrapper content, never sidebar/navbar/logo
           ========================================================= */
        .content-wrapper > .overlay-wrapper,
        #mainOverlayWrapper,
        .overlay-wrapper {
            position: relative !important;
            min-height: calc(100vh - 120px);
        }

        #mainOverlayWrapper > .overlay,
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
            background-color: rgba(244, 246, 249, 0.72) !important;
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            color: #495057 !important;
            border-radius: 0.35rem;
            animation: smoothOverlayFadeIn 0.16s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            pointer-events: all;
        }

        @keyframes smoothOverlayFadeIn {
            from {
                opacity: 0;
                transform: scale(0.995);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        html.dark-mode #mainOverlayWrapper > .overlay,
        body.dark-mode #mainOverlayWrapper > .overlay,
        .dark-mode #mainOverlayWrapper > .overlay,
        html.dark-mode .overlay-wrapper > .overlay,
        body.dark-mode .overlay-wrapper > .overlay,
        .dark-mode .overlay-wrapper > .overlay {
            background-color: rgba(35, 35, 35, 0.82) !important;
            color: #ffffff !important;
        }

        #mainOverlayWrapper > .overlay .overlay-content,
        .overlay-wrapper > .overlay .overlay-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 1.25rem 2rem;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.92);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.8);
        }

        html.dark-mode #mainOverlayWrapper > .overlay .overlay-content,
        body.dark-mode #mainOverlayWrapper > .overlay .overlay-content,
        .dark-mode #mainOverlayWrapper > .overlay .overlay-content,
        html.dark-mode .overlay-wrapper > .overlay .overlay-content,
        body.dark-mode .overlay-wrapper > .overlay .overlay-content,
        .dark-mode .overlay-wrapper > .overlay .overlay-content {
            background: rgba(30, 30, 30, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4);
            color: #f8fafc;
        }

        #mainOverlayWrapper > .overlay i,
        .overlay-wrapper > .overlay i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            color: #007bff;
        }

        html.dark-mode #mainOverlayWrapper > .overlay i,
        body.dark-mode #mainOverlayWrapper > .overlay i,
        .dark-mode #mainOverlayWrapper > .overlay i,
        html.dark-mode .overlay-wrapper > .overlay i,
        body.dark-mode .overlay-wrapper > .overlay i,
        .dark-mode .overlay-wrapper > .overlay i {
            color: #3b82f6;
        }

        /* Ensure active and opening treeviews are rendered open immediately without slide/flicker */
        .nav-sidebar .menu-open > .nav-treeview,
        .nav-sidebar .menu-is-opening > .nav-treeview {
            display: block !important;
        }

        /* Eliminate Font Awesome invisible text period (FOIT) & ensure instant glyph swap */
        @font-face {
            font-family: "Font Awesome 5 Free";
            font-style: normal;
            font-weight: 900;
            font-display: swap;
            src: url("{{ asset('assets/plugins/fontawesome-free/webfonts/fa-solid-900.woff2') }}") format("woff2");
        }
        @font-face {
            font-family: "Font Awesome 5 Free";
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url("{{ asset('assets/plugins/fontawesome-free/webfonts/fa-regular-400.woff2') }}") format("woff2");
        }

        /* Strictly anchor nav-icon box model to eliminate Cumulative Layout Shift (CLS) */
        .nav-sidebar .nav-link > .nav-icon {
            display: inline-block !important;
            width: 1.6rem !important;
            min-width: 1.6rem !important;
            text-align: center !important;
            vertical-align: middle !important;
            font-style: normal !important;
            line-height: 1 !important;
            font-variant: normal !important;
            text-rendering: auto !important;
            -webkit-font-smoothing: antialiased !important;
            -moz-osx-font-smoothing: grayscale !important;
        }
        /* Khmer Typography Modern Support */
        html[lang="km"],
        body.lang-km,
        .lang-km,
        .lang-km body,
        .lang-km button,
        .lang-km input,
        .lang-km select,
        .lang-km textarea,
        .lang-km .brand-text,
        .lang-km .nav-link,
        .lang-km h1, .lang-km h2, .lang-km h3, .lang-km h4, .lang-km h5, .lang-km h6 {
            font-family: 'Kantumruy Pro', 'Source Sans Pro', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
        }

        /* Language Switcher Navbar Styles */
        .lang-dropdown-toggle {
            display: inline-flex !important;
            align-items: center;
            gap: 7px;
            padding: 0.5rem 0.85rem !important;
            font-weight: 500;
            border-radius: 6px;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .lang-dropdown-toggle .flag-icon {
            font-size: 1.15rem;
            border-radius: 3px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.28);
            line-height: 1;
            vertical-align: middle;
        }
        .lang-dropdown-menu {
            min-width: 175px !important;
            border-radius: 8px !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25) !important;
            overflow: hidden;
            padding: 6px 0 !important;
            margin-top: 6px !important;
            border: 1px solid rgba(0, 0, 0, 0.1) !important;
        }
        .lang-dropdown-menu .dropdown-item {
            display: flex;
            align-items: center;
            padding: 9px 16px;
            font-size: 0.92rem;
            font-weight: 500;
            transition: background 0.15s ease, color 0.15s ease;
        }
        .lang-dropdown-menu .dropdown-item .flag-icon {
            font-size: 1.15rem;
            border-radius: 2.5px;
            margin-right: 10px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }
        .lang-dropdown-menu .dropdown-item:hover {
            background-color: rgba(0, 123, 255, 0.08);
            color: #007bff;
        }
        .lang-dropdown-menu .dropdown-item.active,
        .lang-dropdown-menu .dropdown-item:active {
            background-color: #007bff !important;
            color: #ffffff !important;
        }
        .lang-dropdown-menu .dropdown-item.active .text-success {
            color: #ffffff !important;
        }
        .dark-mode .lang-dropdown-menu {
            background-color: #2b2b2b !important;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
        }
        .dark-mode .lang-dropdown-menu .dropdown-item {
            color: #e4e6eb !important;
        }
        .dark-mode .lang-dropdown-menu .dropdown-item:hover {
            background-color: #383838 !important;
            color: #ffffff !important;
        }
        .dark-mode .lang-dropdown-menu .dropdown-item.active {
            background-color: #3f6791 !important;
            color: #ffffff !important;
        }

        /* Navbar Theme Switcher Pill */
        .navbar-theme-pill-btn {
            background: transparent;
            border: none;
            outline: none;
            padding: 4px 6px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .navbar-theme-pill-btn:hover {
            transform: scale(1.06);
        }
        .navbar-theme-pill-btn:active {
            transform: scale(0.94);
        }
        .navbar-theme-pill-btn:focus-visible {
            outline: 2px solid #6366f1;
            outline-offset: 2px;
        }

        .navbar-theme-track {
            position: relative;
            width: 48px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 5px;
            border-radius: 9999px;
            background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
            border: 1.5px solid #94a3b8;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.08);
            transition: background 0.35s cubic-bezier(0.4, 0, 0.2, 1),
                        border-color 0.35s cubic-bezier(0.4, 0, 0.2, 1),
                        box-shadow 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            box-sizing: border-box;
        }

        .navbar-theme-pill-btn.is-dark .navbar-theme-track,
        html.dark-mode .navbar-theme-track {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);
            border-color: #6366f1;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.4), 0 0 10px rgba(99, 102, 241, 0.35);
        }

        .navbar-theme-track .track-icon {
            font-size: 0.65rem;
            line-height: 1;
            pointer-events: none;
            z-index: 1;
            transition: opacity 0.3s ease, transform 0.3s ease, color 0.3s ease;
        }

        .navbar-theme-track .track-sun {
            color: #f59e0b;
            opacity: 0.9;
        }

        .navbar-theme-track .track-moon {
            color: #cbd5e1;
            opacity: 0.3;
        }

        .navbar-theme-pill-btn.is-dark .navbar-theme-track .track-sun,
        html.dark-mode .navbar-theme-track .track-sun {
            opacity: 0.2;
            transform: scale(0.7);
        }

        .navbar-theme-pill-btn.is-dark .navbar-theme-track .track-moon,
        html.dark-mode .navbar-theme-track .track-moon {
            color: #38bdf8;
            opacity: 1;
            transform: scale(1.1);
            filter: drop-shadow(0 0 3px rgba(56, 189, 248, 0.6));
        }

        .navbar-theme-knob {
            position: absolute;
            top: 2px;
            left: 2px;
            width: 18px;
            height: 18px;
            background: #ffffff;
            border-radius: 50%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1),
                        background-color 0.35s ease,
                        box-shadow 0.35s ease;
            z-index: 2;
        }

        .knob-icon-sun,
        .knob-icon-moon {
            font-size: 0.58rem;
            transition: opacity 0.25s ease, transform 0.25s ease;
        }

        .knob-icon-sun {
            color: #d97706;
            display: inline-block;
        }

        .knob-icon-moon {
            color: #4f46e5;
            display: none;
        }

        .navbar-theme-pill-btn.is-dark .navbar-theme-knob,
        html.dark-mode .navbar-theme-knob {
            transform: translateX(23px);
            background: #ffffff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.45), 0 0 10px rgba(165, 180, 252, 0.7);
        }

        .navbar-theme-pill-btn.is-dark .knob-icon-sun,
        html.dark-mode .navbar-theme-knob .knob-icon-sun {
            display: none;
        }

        .navbar-theme-pill-btn.is-dark .knob-icon-moon,
        html.dark-mode .navbar-theme-knob .knob-icon-moon {
            display: inline-block;
        }
    </style>

    @stack('styles')
</head>


