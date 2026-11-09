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

                // Check for sidebar collapse state on PC (prevent layout shift / flicker)
                var sidebarCollapsed = localStorage.getItem('sidebar_collapsed');
                if (!sidebarCollapsed) {
                    var sm = document.cookie.match(/(?:^|; )sidebar_collapsed=([^;]*)/);
                    if (sm) sidebarCollapsed = sm[1];
                }
                if (sidebarCollapsed === '1' && window.innerWidth >= 992) {
                    document.documentElement.classList.add('sidebar-is-collapsed', 'sidebar-collapse');
                }

                // Check for compact table density mode on PC
                var compactMode = localStorage.getItem('pc_compact_mode');
                if (!compactMode) {
                    var cm = document.cookie.match(/(?:^|; )pc_compact_mode=([^;]*)/);
                    if (cm) compactMode = cm[1];
                }
                if (compactMode === '1') {
                    document.documentElement.classList.add('pc-compact-mode');
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

        /* Prevent layout shift when sidebar is collapsed on PC */
        @media (min-width: 992px) {
            html.sidebar-is-collapsed body:not(.sidebar-open) .main-sidebar,
            html.sidebar-collapse body:not(.sidebar-open) .main-sidebar,
            body.sidebar-collapse:not(.sidebar-open) .main-sidebar,
            body.sidebar-collapse .main-sidebar {
                width: 4.6rem !important;
            }
            html.sidebar-is-collapsed body:not(.sidebar-open) .main-header,
            html.sidebar-collapse body:not(.sidebar-open) .main-header,
            body.sidebar-collapse:not(.sidebar-open) .main-header,
            html.sidebar-is-collapsed body:not(.sidebar-open) .content-wrapper,
            html.sidebar-collapse body:not(.sidebar-open) .content-wrapper,
            body.sidebar-collapse:not(.sidebar-open) .content-wrapper,
            html.sidebar-is-collapsed body:not(.sidebar-open) .main-footer,
            html.sidebar-collapse body:not(.sidebar-open) .main-footer,
            body.sidebar-collapse:not(.sidebar-open) .main-footer {
                margin-left: 4.6rem !important;
            }
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

            // Never auto-show overlay on logout actions, dropdowns, modal triggers, or widgets
            if (a.classList.contains('logout-btn') || 
                a.closest('.logout-btn') || 
                href === '/logout' || 
                href.includes('/logout') ||
                a.hasAttribute('data-toggle') || 
                a.hasAttribute('data-widget') || 
                a.hasAttribute('data-dismiss') || 
                a.getAttribute('role') === 'button' ||
                a.classList.contains('no-overlay')) {
                return;
            }

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

    <title>@hasSection('title')@yield('title') - {{ $customizes->url_title ?? config('app.name') }}@else{{ $customizes->url_title ?? config('app.name') }}@endif</title>

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
                        opacity 0.28s cubic-bezier(0.2, 0, 0, 1) !important;
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
                        box-shadow 0.2s cubic-bezier(0.2, 0, 0, 1) !important;
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

        /* Ensure active and opening treeviews are rendered open immediately without slide/flicker (desktop expanded only) */
        body:not(.sidebar-collapse) .nav-sidebar .menu-open > .nav-treeview,
        body:not(.sidebar-collapse) .nav-sidebar .menu-is-opening > .nav-treeview {
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

        /* Modern Portfolio Theme Switch Button (from rbp-portfolio.vercel.app) */
        #navbarThemeToggle {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2rem;  /* 32px - h-8 w-8 */
            height: 2rem; /* 32px */
            cursor: pointer;
            border-radius: 9999px;
            background-color: #ffffff;
            color: #0a0a0a;
            border: none;
            outline: none;
            padding: 0;
            box-shadow: 0 0 0 1px rgba(10, 10, 10, 0.08);
            transition: background-color 0.3s cubic-bezier(0.16, 1, 0.3, 1),
                        box-shadow 0.3s cubic-bezier(0.16, 1, 0.3, 1),
                        color 0.3s cubic-bezier(0.16, 1, 0.3, 1),
                        transform 0.15s ease;
            user-select: none;
            -webkit-tap-highlight-color: transparent;
        }

        #navbarThemeToggle:hover {
            background-color: #f4f4f5;
            box-shadow: 0 0 0 1px rgba(10, 10, 10, 0.14);
        }

        #navbarThemeToggle:active {
            transform: scale(0.92);
        }

        #navbarThemeToggle:focus-visible,
        #navbarThemeToggle.focus-ring:focus-visible {
            outline: 2px solid #3b82f6;
            outline-offset: 2px;
        }

        /* Dark Mode Theme Switcher Styling */
        html.dark-mode #navbarThemeToggle,
        #navbarThemeToggle.is-dark {
            background-color: #171717;
            color: #fafafa;
            box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.12);
        }

        html.dark-mode #navbarThemeToggle:hover,
        #navbarThemeToggle.is-dark:hover {
            background-color: #262626;
            box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.22);
        }

        /* Inner Icon Container (relative h-4 w-4) */
        #navbarThemeToggle .relative.h-4.w-4,
        #navbarThemeToggle > span {
            position: relative;
            display: inline-block;
            width: 1rem;  /* 16px */
            height: 1rem; /* 16px */
        }

        /* Sun and Moon SVG Lucide Icons */
        #navbarThemeToggle svg.lucide {
            position: absolute;
            top: 0;
            left: 0;
            width: 1rem;
            height: 1rem;
            stroke: currentColor;
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1),
                        opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            transform-origin: center center;
        }

        /* Light Mode Icon States */
        #navbarThemeToggle .lucide-sun {
            transform: rotate(0deg) scale(1);
            opacity: 1;
        }

        #navbarThemeToggle .lucide-moon {
            transform: rotate(90deg) scale(0);
            opacity: 0;
            pointer-events: none;
        }

        /* Dark Mode Icon States */
        html.dark-mode #navbarThemeToggle .lucide-sun,
        #navbarThemeToggle.is-dark .lucide-sun {
            transform: rotate(-90deg) scale(0);
            opacity: 0;
            pointer-events: none;
        }

        html.dark-mode #navbarThemeToggle .lucide-moon,
        #navbarThemeToggle.is-dark .lucide-moon {
            transform: rotate(0deg) scale(1);
            opacity: 1;
            pointer-events: auto;
        }

        /* Explicit Light Mode Override when toggling via JS */
        #navbarThemeToggle.is-light .lucide-sun {
            transform: rotate(0deg) scale(1) !important;
            opacity: 1 !important;
            pointer-events: auto;
        }

        #navbarThemeToggle.is-light .lucide-moon {
            transform: rotate(90deg) scale(0) !important;
            opacity: 0 !important;
            pointer-events: none;
        }

        #navbarThemeToggle.is-dark .lucide-sun {
            transform: rotate(-90deg) scale(0) !important;
            opacity: 0 !important;
            pointer-events: none;
        }

        #navbarThemeToggle.is-dark .lucide-moon {
            transform: rotate(0deg) scale(1) !important;
            opacity: 1 !important;
            pointer-events: auto;
        }

        /* =========================================================
           PC & Desktop Efficiency & Responsiveness Suite
           ========================================================= */

        /* 1. PC Navbar Quick Search Trigger & Action Buttons */
        .btn-pc-search-trigger {
            display: inline-flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 20px;
            padding: 0.35rem 0.85rem;
            color: rgba(255, 255, 255, 0.85);
            font-size: 0.84rem;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            outline: none;
            user-select: none;
        }
        .btn-pc-search-trigger:hover {
            background: rgba(255, 255, 255, 0.22);
            border-color: rgba(255, 255, 255, 0.32);
            color: #ffffff;
            transform: translateY(-1px);
        }
        .btn-pc-search-placeholder {
            font-size: 0.82rem;
            letter-spacing: 0.2px;
        }
        .pc-kbd-badge {
            background: rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: 5px;
            padding: 1px 6px;
            font-size: 0.7rem;
            font-family: inherit;
            color: rgba(255, 255, 255, 0.85);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }
        .navbar-light .btn-pc-search-trigger {
            background: rgba(0, 0, 0, 0.05);
            border-color: rgba(0, 0, 0, 0.12);
            color: #495057;
        }
        .navbar-light .btn-pc-search-trigger:hover {
            background: rgba(0, 0, 0, 0.09);
            border-color: rgba(0, 0, 0, 0.2);
            color: #111827;
        }
        .navbar-light .pc-kbd-badge {
            background: #e2e8f0;
            border-color: #cbd5e1;
            color: #475569;
        }

        .btn-pc-nav-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.16);
            color: rgba(255, 255, 255, 0.85);
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            outline: none;
            padding: 0;
        }
        .btn-pc-nav-action:hover {
            background: rgba(255, 255, 255, 0.24);
            color: #ffffff;
            transform: scale(1.08);
        }
        .btn-pc-nav-action:active {
            transform: scale(0.94);
        }
        .btn-pc-nav-action.active {
            background: #007bff !important;
            border-color: #007bff !important;
            color: #ffffff !important;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
        }
        .navbar-light .btn-pc-nav-action {
            background: rgba(0, 0, 0, 0.05);
            border-color: rgba(0, 0, 0, 0.1);
            color: #495057;
        }
        .navbar-light .btn-pc-nav-action:hover {
            background: rgba(0, 0, 0, 0.1);
            color: #111827;
        }

        /* 2. PC Table Usability & Sticky Headers */
        @media (min-width: 992px) {
            .content-wrapper .content {
                padding: 1.25rem 1.4rem !important;
            }
            .content-wrapper .container-fluid {
                padding-left: 1.25rem !important;
                padding-right: 1.25rem !important;
            }

            /* Sticky Table Headers for DataTables and General Tables on PC */
            .table-responsive {
                max-height: calc(100vh - 230px);
                overflow-y: auto;
                position: relative;
            }
            .table-responsive thead th,
            .card-body > .table thead th,
            .card-body > .dataTables_wrapper thead th {
                position: sticky !important;
                top: 0 !important;
                z-index: 5 !important;
                background-color: #f8fafc !important;
                box-shadow: 0 1px 0 #dee2e6, 0 2px 4px rgba(0, 0, 0, 0.03) !important;
            }
            html.dark-mode .table-responsive thead th,
            html.dark-mode .card-body > .table thead th,
            html.dark-mode .card-body > .dataTables_wrapper thead th {
                background-color: #2b2b2b !important;
                color: #f8fafc !important;
                box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1), 0 2px 4px rgba(0, 0, 0, 0.2) !important;
            }

            /* DataTables Desktop Arrangement */
            .dataTables_wrapper .row:first-child {
                align-items: center;
                margin-bottom: 0.75rem;
            }
            .dataTables_wrapper .dataTables_filter {
                display: flex;
                justify-content: flex-end;
                align-items: center;
            }
            .dataTables_wrapper .dataTables_filter input {
                min-width: 230px;
                border-radius: 8px;
                padding: 0.35rem 0.75rem;
                border: 1px solid #cbd5e1;
                transition: border-color 0.2s, box-shadow 0.2s;
                outline: none;
            }
            .dataTables_wrapper .dataTables_filter input:focus {
                border-color: #3b82f6;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
            }
            html.dark-mode .dataTables_wrapper .dataTables_filter input {
                background-color: #2b2b2b;
                border-color: rgba(255, 255, 255, 0.15);
                color: #f1f5f9;
            }
            .dt-buttons .btn {
                border-radius: 6px !important;
                font-weight: 500;
                font-size: 0.84rem;
                padding: 0.32rem 0.75rem;
                margin-right: 4px;
                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            }

            /* Desktop Row Hover State */
            .table-hover tbody tr:hover {
                background-color: rgba(59, 130, 246, 0.04) !important;
                transition: background-color 0.12s ease;
            }
            html.dark-mode .table-hover tbody tr:hover {
                background-color: rgba(255, 255, 255, 0.04) !important;
            }

            /* Desktop modal centering */
            .modal-dialog {
                margin: 2.5rem auto;
            }
        }

        /* Large Monitor Layout Optimization */
        @media (min-width: 1400px) {
            .content-wrapper .content {
                padding: 1.5rem 1.85rem !important;
            }
            .content-wrapper .container-fluid {
                padding-left: 1.5rem !important;
                padding-right: 1.5rem !important;
            }
        }

        /* 3. PC Compact Density Mode */
        body.pc-compact-mode .table td,
        body.pc-compact-mode .table th,
        body.pc-compact-mode .table-bordered td,
        body.pc-compact-mode .table-bordered th {
            padding: 0.38rem 0.65rem !important;
            font-size: 0.86rem !important;
        }
        body.pc-compact-mode .table .user-table-avatar,
        body.pc-compact-mode .table .brand-image,
        body.pc-compact-mode .table img.img-circle {
            width: 32px !important;
            height: 32px !important;
        }
        body.pc-compact-mode .table .btn-sm {
            padding: 0.2rem 0.45rem !important;
            font-size: 0.78rem !important;
        }
        body.pc-compact-mode .card-body {
            padding: 1rem 1.15rem !important;
        }
        body.pc-compact-mode .dash-card {
            padding: 1rem 1.15rem !important;
        }
        body.pc-compact-mode .dash-card-value {
            font-size: 1.65rem !important;
            margin-bottom: 0.2rem !important;
        }

        /* 4. Command Palette Styles */
        .pc-palette-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.55);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 99999;
            display: none;
            align-items: flex-start;
            justify-content: center;
            padding-top: 10vh;
            animation: pcPaletteFadeIn 0.18s cubic-bezier(0.16, 1, 0.3, 1);
        }
        @keyframes pcPaletteFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .pc-palette-box {
            width: 100%;
            max-width: 620px;
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            animation: pcPalettePop 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        @keyframes pcPalettePop {
            from { transform: scale(0.96) translateY(-8px); opacity: 0; }
            to { transform: scale(1) translateY(0); opacity: 1; }
        }
        html.dark-mode .pc-palette-box {
            background: #1e1e1e;
            border-color: rgba(255, 255, 255, 0.12);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(255, 255, 255, 0.1);
            color: #f8fafc;
        }

        .pc-palette-search-wrapper {
            display: flex;
            align-items: center;
            padding: 0.85rem 1.25rem;
            border-bottom: 1px solid #e2e8f0;
            gap: 0.75rem;
        }
        html.dark-mode .pc-palette-search-wrapper {
            border-bottom-color: rgba(255, 255, 255, 0.08);
        }
        .pc-palette-input {
            flex: 1;
            border: none;
            outline: none;
            font-size: 1.02rem;
            font-weight: 500;
            color: #0f172a;
            background: transparent;
        }
        html.dark-mode .pc-palette-input {
            color: #f8fafc;
        }
        .pc-palette-input::placeholder {
            color: #94a3b8;
        }

        .pc-palette-list {
            max-height: 380px;
            overflow-y: auto;
            padding: 0.5rem;
            margin: 0;
            list-style: none;
        }
        .pc-palette-group-title {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #94a3b8;
            padding: 0.5rem 0.85rem 0.25rem;
        }
        .pc-palette-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.6rem 0.85rem;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none !important;
            color: #1e293b;
            transition: all 0.14s ease;
            user-select: none;
        }
        html.dark-mode .pc-palette-item {
            color: #f1f5f9;
        }
        .pc-palette-item:hover,
        .pc-palette-item.active {
            background: #f1f5f9;
            color: #2563eb;
            transform: translateX(2px);
        }
        html.dark-mode .pc-palette-item:hover,
        html.dark-mode .pc-palette-item.active {
            background: #2a2a2a;
            color: #60a5fa;
        }
        .pc-palette-item-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .pc-palette-item-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
            background: #e0e7ff;
            color: #4f46e5;
        }
        html.dark-mode .pc-palette-item-icon {
            background: #312e81;
            color: #a5b4fc;
        }
        .pc-palette-item-text {
            font-size: 0.92rem;
            font-weight: 500;
        }
        .pc-palette-item-shortcut {
            font-size: 0.75rem;
            font-family: inherit;
            color: #94a3b8;
            background: rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 4px;
            padding: 2px 6px;
        }
        html.dark-mode .pc-palette-item-shortcut {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.12);
            color: #cbd5e1;
        }

        .pc-palette-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.65rem 1.25rem;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            font-size: 0.78rem;
            color: #64748b;
        }
        html.dark-mode .pc-palette-footer {
            background: #171717;
            border-top-color: rgba(255, 255, 255, 0.08);
            color: #94a3b8;
        }
        .pc-palette-footer-hints {
            display: flex;
            align-items: center;
            gap: 0.85rem;
        }

        /* 5. Shortcuts Cheat Sheet Modal Styles */
        .pc-shortcuts-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.55);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 99999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            animation: pcPaletteFadeIn 0.18s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .pc-shortcuts-box {
            width: 100%;
            max-width: 540px;
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            animation: pcPalettePop 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        html.dark-mode .pc-shortcuts-box {
            background: #1e1e1e;
            border-color: rgba(255, 255, 255, 0.12);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
            color: #f8fafc;
        }
        .pc-shortcuts-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1.4rem;
            border-bottom: 1px solid #e2e8f0;
        }
        html.dark-mode .pc-shortcuts-header {
            border-bottom-color: rgba(255, 255, 255, 0.08);
        }
        .pc-shortcuts-body {
            padding: 1.25rem 1.4rem;
            max-height: 480px;
            overflow-y: auto;
        }
        .pc-shortcut-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.55rem 0;
            border-bottom: 1px solid #f1f5f9;
        }
        html.dark-mode .pc-shortcut-row {
            border-bottom-color: rgba(255, 255, 255, 0.06);
        }
        .pc-shortcut-row:last-child {
            border-bottom: none;
        }
        .pc-shortcut-keys {
            display: flex;
            gap: 0.35rem;
            align-items: center;
        }
        .pc-shortcut-kbd {
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 2px 8px;
            font-size: 0.78rem;
            font-family: inherit;
            font-weight: 600;
            color: #1e293b;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.06);
        }
        html.dark-mode .pc-shortcut-kbd {
            background: #2b2b2b;
            border-color: rgba(255, 255, 255, 0.15);
            color: #f1f5f9;
        }

        /* =========================================================
           Modern SaaS-Grade Sidebar UI Suite
           ========================================================= */
        @keyframes pulseOnlineDot {
            0% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            }
            70% {
                box-shadow: 0 0 0 6px rgba(16, 185, 129, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }

        .main-sidebar.modern-main-sidebar,
        .main-sidebar {
            border-right: 1px solid rgba(255, 255, 255, 0.08) !important;
            box-shadow: 4px 0 24px -2px rgba(0, 0, 0, 0.25) !important;
            transition: width 0.24s cubic-bezier(0.16, 1, 0.3, 1),
                        margin-left 0.24s cubic-bezier(0.16, 1, 0.3, 1),
                        transform 0.24s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }
        html:not(.dark-mode) .main-sidebar.sidebar-light,
        html:not(.dark-mode) [class*="sidebar-light-"] {
            border-right-color: rgba(0, 0, 0, 0.08) !important;
            box-shadow: 4px 0 20px -2px rgba(0, 0, 0, 0.06) !important;
        }
        .main-sidebar .sidebar {
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
            padding-bottom: 2rem !important;
        }

        /* Modern Brand Header */
        .brand-link.modern-brand-header {
            height: calc(3.5rem + 1px) !important;
            display: flex !important;
            align-items: center !important;
            padding: 0 1rem !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
            text-decoration: none !important;
            transition: width 0.24s cubic-bezier(0.16, 1, 0.3, 1), background-color 0.2s ease, border-color 0.2s ease;
            white-space: nowrap !important;
            overflow: hidden !important;
            box-sizing: border-box !important;
        }
        html:not(.dark-mode) .brand-link.modern-brand-header {
            border-bottom-color: rgba(0, 0, 0, 0.08) !important;
        }
        .brand-link.modern-brand-header:hover {
            background-color: rgba(255, 255, 255, 0.04);
        }
        html:not(.dark-mode) .brand-link.modern-brand-header:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }
        .modern-brand-logo {
            width: 36px;
            height: 36px;
            min-width: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.14);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            transition: transform 0.22s cubic-bezier(0.16, 1, 0.3, 1),
                        box-shadow 0.22s ease,
                        border-color 0.22s ease;
            flex-shrink: 0;
        }
        html:not(.dark-mode) .modern-brand-logo {
            background: #ffffff;
            border-color: rgba(0, 0, 0, 0.1);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }
        .modern-brand-header:hover .modern-brand-logo {
            transform: scale(1.06);
            border-color: rgba(99, 102, 241, 0.5);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25);
        }
        .modern-brand-logo .brand-image {
            width: 36px !important;
            height: 36px !important;
            max-width: 36px !important;
            max-height: 36px !important;
            min-width: 36px !important;
            min-height: 36px !important;
            border-radius: 9px !important;
            object-fit: cover !important;
            margin: 0 !important;
            float: none !important;
            display: block !important;
        }
        .modern-brand-details {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-grow: 1;
            margin-left: 0.75rem;
            min-width: 0;
            transition: opacity 0.2s ease;
        }
        .modern-brand-title {
            font-size: 0.98rem !important;
            font-weight: 700 !important;
            letter-spacing: -0.015em !important;
            color: #f8fafc !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            line-height: 1.25 !important;
        }
        html:not(.dark-mode) [class*="sidebar-light-"] .modern-brand-title {
            color: #0f172a !important;
        }
        .modern-brand-pill {
            font-size: 0.65rem;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 6px;
            background: rgba(99, 102, 241, 0.18);
            color: #818cf8;
            border: 1px solid rgba(99, 102, 241, 0.35);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-left: 0.5rem;
            flex-shrink: 0;
        }

        /* Elevated Floating User Profile Card */
        .modern-user-card {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 0.85rem 0.35rem 0.65rem 0.35rem;
            padding: 0.65rem 0.75rem;
            background: rgba(255, 255, 255, 0.035);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            text-decoration: none !important;
            cursor: pointer;
            transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }
        html:not(.dark-mode) [class*="sidebar-light-"] .modern-user-card {
            background: rgba(0, 0, 0, 0.03);
            border-color: rgba(0, 0, 0, 0.08);
        }
        .modern-user-card:hover {
            background: rgba(255, 255, 255, 0.075);
            border-color: rgba(99, 102, 241, 0.35);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.2);
        }
        html:not(.dark-mode) [class*="sidebar-light-"] .modern-user-card:hover {
            background: rgba(0, 0, 0, 0.05);
            border-color: rgba(99, 102, 241, 0.3);
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.06);
        }
        .modern-user-card:active {
            transform: translateY(0);
        }
        .modern-user-avatar-wrap {
            position: relative;
            width: 44px;
            height: 44px;
            min-width: 44px;
            flex-shrink: 0;
        }
        .modern-user-avatar {
            width: 44px !important;
            height: 44px !important;
            border-radius: 12px !important;
            object-fit: cover !important;
            border: 2px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.35), inset 0 1px 1px rgba(255, 255, 255, 0.4);
            display: block;
            transition: all 0.25s ease;
        }
        .modern-user-card:hover .modern-user-avatar {
            transform: scale(1.06);
            border-color: #818cf8;
            box-shadow: 0 6px 16px rgba(99, 102, 241, 0.35);
        }
        html:not(.dark-mode) [class*="sidebar-light-"] .modern-user-avatar {
            border-color: rgba(0, 0, 0, 0.12);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
        }
        .modern-avatar-status {
            position: absolute;
            bottom: -2px;
            right: -2px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #10b981;
            border: 2px solid #14171f;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.3);
            animation: pulseOnlineDot 2.2s infinite;
        }
        html:not(.dark-mode) [class*="sidebar-light-"] .modern-avatar-status {
            border-color: #ffffff;
        }
        .modern-user-info {
            display: flex;
            flex-direction: column;
            min-width: 0;
            flex-grow: 1;
        }
        .modern-user-name {
            font-size: 0.88rem;
            font-weight: 600;
            color: #f8fafc;
            line-height: 1.25;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        html:not(.dark-mode) [class*="sidebar-light-"] .modern-user-name {
            color: #0f172a;
        }
        .modern-user-role-wrap {
            margin-top: 3px;
            display: flex;
            align-items: center;
        }
        .modern-user-role-badge {
            font-size: 0.67rem;
            font-weight: 600;
            padding: 1.5px 7px;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            line-height: 1.25;
            letter-spacing: 0.02em;
        }
        .modern-user-role-badge.role-admin {
            background: rgba(99, 102, 241, 0.2);
            color: #a5b4fc;
            border: 1px solid rgba(99, 102, 241, 0.4);
        }
        .modern-user-role-badge.role-teacher {
            background: rgba(16, 185, 129, 0.2);
            color: #6ee7b7;
            border: 1px solid rgba(16, 185, 129, 0.4);
        }
        .modern-user-role-badge.role-student {
            background: rgba(14, 165, 233, 0.2);
            color: #7dd3fc;
            border: 1px solid rgba(14, 165, 233, 0.4);
        }
        .modern-user-role-badge.role-accountant {
            background: rgba(245, 158, 11, 0.2);
            color: #fcd34d;
            border: 1px solid rgba(245, 158, 11, 0.4);
        }
        .modern-user-role-badge.role-reception {
            background: rgba(244, 63, 94, 0.2);
            color: #fda4af;
            border: 1px solid rgba(244, 63, 94, 0.4);
        }
        .modern-user-role-badge.role-default {
            background: rgba(148, 163, 184, 0.2);
            color: #cbd5e1;
            border: 1px solid rgba(148, 163, 184, 0.4);
        }
        .modern-user-arrow {
            font-size: 0.72rem;
            color: rgba(255, 255, 255, 0.35);
            margin-left: auto;
            flex-shrink: 0;
            transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1), color 0.2s ease;
        }
        html:not(.dark-mode) [class*="sidebar-light-"] .modern-user-arrow {
            color: rgba(0, 0, 0, 0.35);
        }
        .modern-user-card:hover .modern-user-arrow {
            transform: translateX(3px);
            color: #818cf8;
        }

        /* Modern Sidebar Search Form */
        .modern-sidebar-search-container {
            margin: 0.35rem 0.35rem 0.85rem 0.35rem;
            position: relative;
        }
        .modern-search-pill {
            display: flex !important;
            align-items: center !important;
            background: rgba(255, 255, 255, 0.04) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            border-radius: 12px !important;
            padding: 2px 4px 2px 10px !important;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }
        html:not(.dark-mode) [class*="sidebar-light-"] .modern-search-pill {
            background: rgba(0, 0, 0, 0.035) !important;
            border-color: rgba(0, 0, 0, 0.08) !important;
        }
        .modern-search-pill:focus-within,
        .modern-search-pill:hover {
            background: rgba(255, 255, 255, 0.07) !important;
            border-color: rgba(99, 102, 241, 0.45) !important;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12) !important;
        }
        html:not(.dark-mode) [class*="sidebar-light-"] .modern-search-pill:focus-within,
        html:not(.dark-mode) [class*="sidebar-light-"] .modern-search-pill:hover {
            background: #ffffff !important;
            border-color: rgba(99, 102, 241, 0.4) !important;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1) !important;
        }
        .modern-search-prefix {
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.82rem;
            margin-right: 6px;
            display: flex;
            align-items: center;
        }
        html:not(.dark-mode) [class*="sidebar-light-"] .modern-search-prefix {
            color: rgba(0, 0, 0, 0.4);
        }
        .modern-search-input {
            background: transparent !important;
            border: none !important;
            color: #f8fafc !important;
            font-size: 0.82rem !important;
            padding: 0.42rem 0.3rem !important;
            outline: none !important;
            box-shadow: none !important;
            height: auto !important;
            flex-grow: 1;
        }
        html:not(.dark-mode) [class*="sidebar-light-"] .modern-search-input {
            color: #0f172a !important;
        }
        .modern-search-input::placeholder {
            color: rgba(255, 255, 255, 0.38) !important;
            font-size: 0.82rem;
        }
        html:not(.dark-mode) [class*="sidebar-light-"] .modern-search-input::placeholder {
            color: rgba(0, 0, 0, 0.4) !important;
        }
        .modern-search-actions {
            display: flex;
            align-items: center;
            gap: 4px;
            margin-left: auto;
        }
        .modern-search-clear-btn {
            background: transparent !important;
            border: none !important;
            color: rgba(255, 255, 255, 0.4) !important;
            padding: 0.25rem 0.35rem !important;
            font-size: 0.75rem !important;
            cursor: pointer;
            box-shadow: none !important;
            transition: color 0.15s ease;
        }
        html:not(.dark-mode) [class*="sidebar-light-"] .modern-search-clear-btn {
            color: rgba(0, 0, 0, 0.4) !important;
        }
        .modern-search-clear-btn:hover {
            color: #f8fafc !important;
        }
        html:not(.dark-mode) [class*="sidebar-light-"] .modern-search-clear-btn:hover {
            color: #0f172a !important;
        }
        .modern-search-kbd {
            cursor: pointer;
            user-select: none;
        }
        .modern-search-kbd kbd {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: rgba(255, 255, 255, 0.65);
            font-size: 0.68rem;
            font-weight: 600;
            padding: 2px 6px;
            border-radius: 6px;
            transition: all 0.15s ease;
            font-family: inherit;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }
        html:not(.dark-mode) [class*="sidebar-light-"] .modern-search-kbd kbd {
            background: rgba(0, 0, 0, 0.06);
            border-color: rgba(0, 0, 0, 0.1);
            color: #475569;
        }
        .modern-search-kbd:hover kbd {
            background: #6366f1;
            color: #ffffff;
            border-color: #6366f1;
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.35);
        }
        .sidebar-search-results {
            background: #181b22 !important;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            border-radius: 12px !important;
            box-shadow: 0 16px 36px rgba(0, 0, 0, 0.45) !important;
            padding: 6px !important;
            margin-top: 6px !important;
            overflow: hidden;
        }
        html:not(.dark-mode) [class*="sidebar-light-"] .sidebar-search-results {
            background: #ffffff !important;
            border-color: rgba(0, 0, 0, 0.1) !important;
            box-shadow: 0 16px 36px rgba(0, 0, 0, 0.12) !important;
        }
        .sidebar-search-results .list-group-item {
            background: transparent !important;
            border: none !important;
            border-radius: 8px !important;
            padding: 0.5rem 0.75rem !important;
            color: #e2e8f0 !important;
            font-size: 0.82rem !important;
            transition: all 0.15s ease !important;
        }
        html:not(.dark-mode) [class*="sidebar-light-"] .sidebar-search-results .list-group-item {
            color: #334155 !important;
        }
        .sidebar-search-results .list-group-item:hover {
            background: rgba(99, 102, 241, 0.18) !important;
            color: #ffffff !important;
            transform: translateX(2px);
        }
        html:not(.dark-mode) [class*="sidebar-light-"] .sidebar-search-results .list-group-item:hover {
            background: rgba(99, 102, 241, 0.12) !important;
            color: #4338ca !important;
        }

        /* Capsule Navigation Items */
        .nav-sidebar .nav-item {
            margin-bottom: 2px;
            background: transparent !important;
            border: none !important;
            outline: none !important;
        }
        .nav-sidebar .nav-link {
            border-radius: 10px !important;
            margin: 2px 4px !important;
            padding: 0.52rem 0.75rem !important;
            display: flex !important;
            align-items: center !important;
            font-size: 0.865rem !important;
            font-weight: 500 !important;
            color: rgba(255, 255, 255, 0.72) !important;
            border: 1px solid transparent !important;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
            outline: none !important;
            overflow: hidden !important;
            position: relative;
        }
        /* Eradicate any active tabs, notches, jagged left indicators, or pseudo-elements */
        .nav-sidebar .nav-link::before,
        .nav-sidebar .nav-link::after,
        .nav-sidebar .nav-link.active::before,
        .nav-sidebar .nav-link.active::after,
        .nav-sidebar .nav-item::before,
        .nav-sidebar .nav-item::after,
        .nav-sidebar .nav-item.active::before,
        .nav-sidebar .nav-item.active::after,
        .nav-sidebar > .nav-item::before,
        .nav-sidebar > .nav-item::after,
        .nav-sidebar > .nav-item > .nav-link::before,
        .nav-sidebar > .nav-item > .nav-link::after,
        .nav-sidebar > .nav-item > .nav-link.active::before,
        .nav-sidebar > .nav-item > .nav-link.active::after,
        .nav-sidebar .nav-treeview .nav-link::before,
        .nav-sidebar .nav-treeview .nav-link::after,
        .nav-sidebar .nav-treeview .nav-link.active::before,
        .nav-sidebar .nav-treeview .nav-link.active::after,
        .nav-sidebar .nav-treeview .nav-item.active::before,
        .nav-sidebar .nav-treeview .nav-item.active::after {
            content: none !important;
            display: none !important;
            width: 0 !important;
            height: 0 !important;
            border: none !important;
            visibility: hidden !important;
            pointer-events: none !important;
        }
        html:not(.dark-mode) [class*="sidebar-light-"] .nav-sidebar .nav-link {
            color: #334155 !important;
        }
        /* ══════════════════════════════════════════════════════════════════
           3D MODERN SIDEBAR ICONS SYSTEM (Executive SaaS)
        ══════════════════════════════════════════════════════════════════ */
        .nav-sidebar .nav-link > .nav-icon {
            width: 34px !important;
            height: 34px !important;
            min-width: 34px !important;
            max-width: 34px !important;
            border-radius: 10px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin-right: 0.75rem !important;
            font-size: 0.95rem !important;
            position: relative !important;
            flex-shrink: 0 !important;
            transition: all 0.26s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
            transform: translateZ(0) !important;
            border: 1px solid rgba(255, 255, 255, 0.18) !important;
            box-shadow: 
                0 4px 10px -1px rgba(0, 0, 0, 0.4),
                0 2px 4px -1px rgba(0, 0, 0, 0.25),
                inset 0 1px 1px 0 rgba(255, 255, 255, 0.5),
                inset 0 -1.5px 1px 0 rgba(0, 0, 0, 0.3) !important;
            color: #ffffff !important;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.6) !important;
            background: linear-gradient(145deg, #475569 0%, #1e293b 100%) !important;
        }

        /* 3D Modern Gradient Color Coding by Module */
        /* 1. Dashboard */
        .nav-sidebar .nav-link > .nav-icon.fa-tachometer-alt,
        .nav-sidebar .nav-link > .nav-icon.fa-gauge,
        .nav-sidebar .nav-link > .nav-icon.fa-home {
            background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%) !important;
            border-color: rgba(165, 180, 252, 0.35) !important;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.42), inset 0 1px 1px rgba(255, 255, 255, 0.55), inset 0 -1.5px 1px rgba(0, 0, 0, 0.3) !important;
        }

        /* 2. Class & Sections */
        .nav-sidebar .nav-link > .nav-icon.fa-university,
        .nav-sidebar .nav-link > .nav-icon.fa-school {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
            border-color: rgba(147, 197, 253, 0.35) !important;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.42), inset 0 1px 1px rgba(255, 255, 255, 0.55), inset 0 -1.5px 1px rgba(0, 0, 0, 0.3) !important;
        }

        /* 3. Subjects */
        .nav-sidebar .nav-link > .nav-icon.fa-book-open,
        .nav-sidebar .nav-link > .nav-icon.fa-book,
        .nav-sidebar .nav-link > .nav-icon.fa-atlas {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
            border-color: rgba(165, 243, 252, 0.35) !important;
            box-shadow: 0 4px 12px rgba(6, 182, 212, 0.42), inset 0 1px 1px rgba(255, 255, 255, 0.55), inset 0 -1.5px 1px rgba(0, 0, 0, 0.3) !important;
        }

        /* 4. Class Routine */
        .nav-sidebar .nav-link > .nav-icon.fa-calendar-alt,
        .nav-sidebar .nav-link > .nav-icon.fa-calendar {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
            border-color: rgba(253, 230, 138, 0.35) !important;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.42), inset 0 1px 1px rgba(255, 255, 255, 0.55), inset 0 -1.5px 1px rgba(0, 0, 0, 0.3) !important;
        }

        /* 5. Class Materials (Cubes) */
        .nav-sidebar .nav-link > .nav-icon.fa-cubes,
        .nav-sidebar .nav-link > .nav-icon.fa-cube {
            background: linear-gradient(135deg, #a855f7 0%, #7e22ce 100%) !important;
            border-color: rgba(233, 213, 255, 0.35) !important;
            box-shadow: 0 4px 12px rgba(168, 85, 247, 0.42), inset 0 1px 1px rgba(255, 255, 255, 0.55), inset 0 -1.5px 1px rgba(0, 0, 0, 0.3) !important;
        }

        /* 6. Department & Staff */
        .nav-sidebar .nav-link > .nav-icon.fa-building,
        .nav-sidebar .nav-link > .nav-icon.fa-sitemap,
        .nav-sidebar .nav-link > .nav-icon.fa-user-tie {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%) !important;
            border-color: rgba(186, 230, 253, 0.35) !important;
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.42), inset 0 1px 1px rgba(255, 255, 255, 0.55), inset 0 -1.5px 1px rgba(0, 0, 0, 0.3) !important;
        }

        /* 7. Accounting & Financial Section */
        .nav-sidebar .nav-link > .nav-icon.fa-file-invoice-dollar,
        .nav-sidebar .nav-link > .nav-icon.fa-receipt,
        .nav-sidebar .nav-link > .nav-icon.fa-coins,
        .nav-sidebar .nav-link > .nav-icon.fa-wallet,
        .nav-sidebar .nav-link > .nav-icon.fa-cash-register,
        .nav-sidebar .nav-link > .nav-icon.fa-calculator {
            background: linear-gradient(135deg, #10b981 0%, #047857 100%) !important;
            border-color: rgba(167, 243, 208, 0.35) !important;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.42), inset 0 1px 1px rgba(255, 255, 255, 0.55), inset 0 -1.5px 1px rgba(0, 0, 0, 0.3) !important;
        }

        /* 8. Students & Admissions */
        .nav-sidebar .nav-link > .nav-icon.fa-user-graduate,
        .nav-sidebar .nav-link > .nav-icon.fa-graduation-cap,
        .nav-sidebar .nav-link > .nav-icon.fa-id-card,
        .nav-sidebar .nav-link > .nav-icon.fa-user-plus {
            background: linear-gradient(135deg, #f43f5e 0%, #be123c 100%) !important;
            border-color: rgba(254, 205, 211, 0.35) !important;
            box-shadow: 0 4px 12px rgba(244, 63, 94, 0.42), inset 0 1px 1px rgba(255, 255, 255, 0.55), inset 0 -1.5px 1px rgba(0, 0, 0, 0.3) !important;
        }

        /* 9. Teachers & Faculty */
        .nav-sidebar .nav-link > .nav-icon.fa-chalkboard-teacher,
        .nav-sidebar .nav-link > .nav-icon.fa-chalkboard {
            background: linear-gradient(135deg, #38bdf8 0%, #2563eb 100%) !important;
            border-color: rgba(191, 219, 254, 0.35) !important;
            box-shadow: 0 4px 12px rgba(56, 189, 248, 0.42), inset 0 1px 1px rgba(255, 255, 255, 0.55), inset 0 -1.5px 1px rgba(0, 0, 0, 0.3) !important;
        }

        /* 10. Parents & Guardians */
        .nav-sidebar .nav-link > .nav-icon.fa-user-friends,
        .nav-sidebar .nav-link > .nav-icon.fa-users-cog {
            background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%) !important;
            border-color: rgba(221, 214, 254, 0.35) !important;
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.42), inset 0 1px 1px rgba(255, 255, 255, 0.55), inset 0 -1.5px 1px rgba(0, 0, 0, 0.3) !important;
        }

        /* 11. Attendance Tracking */
        .nav-sidebar .nav-link > .nav-icon.fa-calendar-check,
        .nav-sidebar .nav-link > .nav-icon.fa-user-check,
        .nav-sidebar .nav-link > .nav-icon.fa-clipboard-check {
            background: linear-gradient(135deg, #14b8a6 0%, #0f766e 100%) !important;
            border-color: rgba(153, 246, 228, 0.35) !important;
            box-shadow: 0 4px 12px rgba(20, 184, 166, 0.42), inset 0 1px 1px rgba(255, 255, 255, 0.55), inset 0 -1.5px 1px rgba(0, 0, 0, 0.3) !important;
        }

        /* 12. Exams, Marks & Grades */
        .nav-sidebar .nav-link > .nav-icon.fa-award,
        .nav-sidebar .nav-link > .nav-icon.fa-medal,
        .nav-sidebar .nav-link > .nav-icon.fa-star,
        .nav-sidebar .nav-link > .nav-icon.fa-pencil-alt {
            background: linear-gradient(135deg, #eab308 0%, #a16207 100%) !important;
            border-color: rgba(254, 240, 138, 0.35) !important;
            box-shadow: 0 4px 12px rgba(234, 179, 8, 0.42), inset 0 1px 1px rgba(255, 255, 255, 0.55), inset 0 -1.5px 1px rgba(0, 0, 0, 0.3) !important;
        }

        /* 13. Messages & Inbox */
        .nav-sidebar .nav-link > .nav-icon.fa-envelope,
        .nav-sidebar .nav-link > .nav-icon.fa-comments,
        .nav-sidebar .nav-link > .nav-icon.fa-paper-plane {
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%) !important;
            border-color: rgba(186, 230, 253, 0.35) !important;
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.42), inset 0 1px 1px rgba(255, 255, 255, 0.55), inset 0 -1.5px 1px rgba(0, 0, 0, 0.3) !important;
        }

        /* 14. Settings, System & Customization */
        .nav-sidebar .nav-link > .nav-icon.fa-cog,
        .nav-sidebar .nav-link > .nav-icon.fa-cogs,
        .nav-sidebar .nav-link > .nav-icon.fa-puzzle-piece {
            background: linear-gradient(135deg, #64748b 0%, #334155 100%) !important;
            border-color: rgba(203, 213, 225, 0.35) !important;
            box-shadow: 0 4px 12px rgba(100, 116, 139, 0.42), inset 0 1px 1px rgba(255, 255, 255, 0.55), inset 0 -1.5px 1px rgba(0, 0, 0, 0.3) !important;
        }

        /* 15. User Management */
        .nav-sidebar .nav-link > .nav-icon.fa-users,
        .nav-sidebar .nav-link > .nav-icon.fa-user-shield {
            background: linear-gradient(135deg, #ec4899 0%, #9d174d 100%) !important;
            border-color: rgba(251, 207, 232, 0.35) !important;
            box-shadow: 0 4px 12px rgba(236, 72, 153, 0.42), inset 0 1px 1px rgba(255, 255, 255, 0.55), inset 0 -1.5px 1px rgba(0, 0, 0, 0.3) !important;
        }

        /* 16. Activity Logs */
        .nav-sidebar .nav-link > .nav-icon.fa-podcast,
        .nav-sidebar .nav-link > .nav-icon.fa-history {
            background: linear-gradient(135deg, #475569 0%, #1e293b 100%) !important;
            border-color: rgba(203, 213, 225, 0.35) !important;
            box-shadow: 0 4px 12px rgba(71, 85, 105, 0.42), inset 0 1px 1px rgba(255, 255, 255, 0.55), inset 0 -1.5px 1px rgba(0, 0, 0, 0.3) !important;
        }

        /* 17. User Profile & Account */
        .nav-sidebar .nav-link > .nav-icon.fa-user-circle {
            background: linear-gradient(135deg, #8b5cf6 0%, #4f46e5 100%) !important;
            border-color: rgba(221, 214, 254, 0.35) !important;
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.42), inset 0 1px 1px rgba(255, 255, 255, 0.55), inset 0 -1.5px 1px rgba(0, 0, 0, 0.3) !important;
        }

        /* 18. Logout */
        .nav-sidebar .nav-link > .nav-icon.fa-sign-out-alt {
            background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%) !important;
            border-color: rgba(254, 202, 202, 0.35) !important;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.42), inset 0 1px 1px rgba(255, 255, 255, 0.55), inset 0 -1.5px 1px rgba(0, 0, 0, 0.3) !important;
        }

        /* 3D Hover Spring Effect */
        .nav-sidebar .nav-link:hover > .nav-icon {
            transform: translateY(-2px) scale(1.1) !important;
            filter: brightness(1.15) !important;
            box-shadow: 
                0 6px 16px -2px rgba(0, 0, 0, 0.5),
                0 0 14px rgba(255, 255, 255, 0.28),
                inset 0 1px 2px rgba(255, 255, 255, 0.7),
                inset 0 -1.5px 1px rgba(0, 0, 0, 0.4) !important;
            border-color: rgba(255, 255, 255, 0.45) !important;
        }

        /* Active Nav item 3D state */
        .nav-sidebar .nav-link.active > .nav-icon {
            transform: scale(1.08) translateY(-1px) !important;
            border-color: #ffffff !important;
            box-shadow: 
                0 6px 18px rgba(0, 0, 0, 0.45),
                0 0 14px rgba(255, 255, 255, 0.45),
                inset 0 1px 2px rgba(255, 255, 255, 0.8),
                inset 0 -1.5px 1px rgba(0, 0, 0, 0.4) !important;
        }

        .nav-sidebar .nav-link p {
            margin-bottom: 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            flex-grow: 1 !important;
            line-height: 1.35 !important;
        }
        .nav-sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.075) !important;
            color: #ffffff !important;
            transform: translateX(3px) !important;
        }
        html:not(.dark-mode) [class*="sidebar-light-"] .nav-sidebar .nav-link:hover {
            background-color: rgba(0, 0, 0, 0.045) !important;
            color: #0f172a !important;
        }

        /* Active state */
        .nav-sidebar .nav-link.active {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%) !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            box-shadow: 0 4px 14px -1px rgba(79, 70, 229, 0.45) !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            border-radius: 10px !important;
            transform: none !important;
            outline: none !important;
            overflow: hidden !important;
        }
        .nav-sidebar .nav-link.active p,
        .nav-sidebar .nav-link.active .right {
            color: #ffffff !important;
        }

        /* Open treeview parent */
        .nav-sidebar .menu-open > .nav-link:not(.active),
        .nav-sidebar .menu-is-opening > .nav-link:not(.active) {
            background: rgba(255, 255, 255, 0.04) !important;
            color: #f8fafc !important;
        }
        html:not(.dark-mode) [class*="sidebar-light-"] .nav-sidebar .menu-open > .nav-link:not(.active),
        html:not(.dark-mode) [class*="sidebar-light-"] .nav-sidebar .menu-is-opening > .nav-link:not(.active) {
            background: rgba(0, 0, 0, 0.03) !important;
            color: #0f172a !important;
        }

        .nav-sidebar .nav-link .right.fas.fa-angle-left {
            font-size: 0.72rem !important;
            transition: transform 0.22s cubic-bezier(0.16, 1, 0.3, 1) !important;
            color: rgba(255, 255, 255, 0.4) !important;
        }
        html:not(.dark-mode) [class*="sidebar-light-"] .nav-sidebar .nav-link .right.fas.fa-angle-left {
            color: rgba(0, 0, 0, 0.4) !important;
        }
        .nav-sidebar .menu-open > .nav-link .right.fas.fa-angle-left {
            transform: rotate(-90deg) !important;
            color: #818cf8 !important;
        }

        /* Modern Treeview Submenus */
        .nav-sidebar .nav-treeview {
            margin-left: 1.65rem !important;
            padding-left: 0.65rem !important;
            border-left: 1.5px solid rgba(255, 255, 255, 0.1) !important;
            margin-top: 0.25rem !important;
            margin-bottom: 0.4rem !important;
            list-style: none !important;
        }
        html:not(.dark-mode) [class*="sidebar-light-"] .nav-sidebar .nav-treeview {
            border-left-color: rgba(0, 0, 0, 0.1) !important;
        }
        .nav-sidebar .nav-treeview .nav-link {
            padding: 0.42rem 0.65rem !important;
            margin: 2px 0 !important;
            font-size: 0.83rem !important;
            border-radius: 8px !important;
            color: rgba(255, 255, 255, 0.65) !important;
            border: 1px solid transparent !important;
            outline: none !important;
        }
        html:not(.dark-mode) [class*="sidebar-light-"] .nav-sidebar .nav-treeview .nav-link {
            color: #475569 !important;
        }
        /* Treeview 3D Glowing Orbs / Beads */
        .nav-sidebar .nav-treeview .nav-link > .nav-icon {
            width: 10px !important;
            height: 10px !important;
            min-width: 10px !important;
            max-width: 10px !important;
            border-radius: 50% !important;
            background: radial-gradient(circle at 35% 35%, #cbd5e1 0%, #64748b 100%) !important;
            border: 1px solid rgba(255, 255, 255, 0.45) !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.35), inset 0 1px 1px rgba(255, 255, 255, 0.7) !important;
            margin-right: 0.65rem !important;
            display: inline-block !important;
            flex-shrink: 0 !important;
            transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
            font-size: 0 !important;
            opacity: 0.75 !important;
        }
        html:not(.dark-mode) [class*="sidebar-light-"] .nav-sidebar .nav-treeview .nav-link > .nav-icon {
            background: radial-gradient(circle at 35% 35%, #94a3b8 0%, #475569 100%) !important;
            border-color: rgba(0, 0, 0, 0.15) !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15), inset 0 1px 1px rgba(255, 255, 255, 0.8) !important;
        }
        .nav-sidebar .nav-treeview .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.06) !important;
            color: #f8fafc !important;
            transform: translateX(3px) !important;
        }
        html:not(.dark-mode) [class*="sidebar-light-"] .nav-sidebar .nav-treeview .nav-link:hover {
            background-color: rgba(0, 0, 0, 0.04) !important;
            color: #0f172a !important;
        }
        .nav-sidebar .nav-treeview .nav-link:hover > .nav-icon {
            opacity: 1 !important;
            transform: scale(1.3) !important;
            background: radial-gradient(circle at 35% 35%, #60a5fa 0%, #3b82f6 100%) !important;
            box-shadow: 0 0 8px rgba(59, 130, 246, 0.7), inset 0 1px 1px rgba(255, 255, 255, 0.8) !important;
            border-color: #ffffff !important;
        }
        .nav-sidebar .nav-treeview .nav-link.active {
            background: rgba(99, 102, 241, 0.18) !important;
            color: #a5b4fc !important;
            font-weight: 600 !important;
            border: 1px solid rgba(99, 102, 241, 0.35) !important;
            box-shadow: none !important;
            transform: none !important;
            outline: none !important;
        }
        html:not(.dark-mode) [class*="sidebar-light-"] .nav-sidebar .nav-treeview .nav-link.active {
            background: rgba(99, 102, 241, 0.12) !important;
            color: #4338ca !important;
            border-color: rgba(99, 102, 241, 0.25) !important;
        }
        .nav-sidebar .nav-treeview .nav-link.active > .nav-icon {
            opacity: 1 !important;
            transform: scale(1.4) !important;
            background: radial-gradient(circle at 35% 35%, #818cf8 0%, #4f46e5 100%) !important;
            border-color: #ffffff !important;
            box-shadow: 0 0 10px rgba(99, 102, 241, 0.9), 0 2px 4px rgba(0, 0, 0, 0.3), inset 0 1px 1px rgba(255, 255, 255, 0.9) !important;
        }

        /* Named 3D Icons inside treeview (e.g., Setting submenus like Customizes, User Management, Activity Logs) */
        .nav-sidebar .nav-treeview .nav-link > .nav-icon:not(.fa-circle) {
            width: 26px !important;
            height: 26px !important;
            min-width: 26px !important;
            max-width: 26px !important;
            border-radius: 8px !important;
            font-size: 0.78rem !important;
            opacity: 1 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.3), inset 0 1px 1px rgba(255, 255, 255, 0.5) !important;
        }

        .nav-sidebar .nav-treeview .nav-item {
            position: relative;
        }
        .nav-sidebar .nav-treeview .nav-item::before {
            content: '';
            position: absolute;
            left: -0.65rem;
            top: 50%;
            width: 0.45rem;
            height: 1px;
            background: rgba(255, 255, 255, 0.12);
        }
        html:not(.dark-mode) [class*="sidebar-light-"] .nav-sidebar .nav-treeview .nav-item::before {
            background: rgba(0, 0, 0, 0.1);
        }

        /* Modern Category Headers with Clean Horizontal Divider */
        .nav-sidebar .nav-header {
            font-size: 0.68rem !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.08em !important;
            color: rgba(255, 255, 255, 0.38) !important;
            padding: 1.15rem 0.85rem 0.35rem 0.85rem !important;
            margin-top: 0.4rem !important;
            display: flex !important;
            align-items: center !important;
            gap: 0.65rem !important;
        }
        .nav-sidebar .nav-header::after {
            content: '' !important;
            flex-grow: 1 !important;
            height: 1px !important;
            background: rgba(255, 255, 255, 0.08) !important;
        }
        html:not(.dark-mode) [class*="sidebar-light-"] .nav-sidebar .nav-header {
            color: #64748b !important;
        }
        html:not(.dark-mode) [class*="sidebar-light-"] .nav-sidebar .nav-header::after {
            background: rgba(0, 0, 0, 0.08) !important;
        }

        /* Smart Search Match Highlight & Empty State */
        mark.smart-search-hl {
            background: rgba(99, 102, 241, 0.35) !important;
            color: #ffffff !important;
            padding: 1px 4px !important;
            border-radius: 4px !important;
            border: 1px solid rgba(99, 102, 241, 0.5) !important;
            font-weight: 700 !important;
        }
        html:not(.dark-mode) [class*="sidebar-light-"] mark.smart-search-hl {
            background: rgba(99, 102, 241, 0.18) !important;
            color: #4338ca !important;
            border-color: rgba(99, 102, 241, 0.35) !important;
        }
        .smart-search-count-badge {
            background: rgba(99, 102, 241, 0.25) !important;
            color: #a5b4fc !important;
            border: 1px solid rgba(99, 102, 241, 0.4) !important;
            font-size: 0.68rem !important;
            font-weight: 700 !important;
            padding: 2px 7px !important;
            border-radius: 9999px !important;
            line-height: 1 !important;
        }
        .smart-search-empty {
            padding: 0.85rem 0.5rem;
            text-align: center;
            font-size: 0.82rem;
            color: rgba(255, 255, 255, 0.65);
            background: rgba(255, 255, 255, 0.03);
            border: 1px dashed rgba(255, 255, 255, 0.12);
            border-radius: 10px;
            margin-top: 0.5rem;
        }
        html:not(.dark-mode) [class*="sidebar-light-"] .smart-search-empty {
            color: #64748b;
            background: rgba(0, 0, 0, 0.02);
            border-color: rgba(0, 0, 0, 0.1);
        }
        .smart-search-empty-hint {
            font-size: 0.72rem;
            color: rgba(255, 255, 255, 0.4);
            margin-top: 3px;
        }
        html:not(.dark-mode) [class*="sidebar-light-"] .smart-search-empty-hint {
            color: #94a3b8;
        }

        /* Smart Floating Tooltip in Mini Collapsed Mode */
        .smart-sidebar-tooltip {
            position: fixed;
            z-index: 99999;
            pointer-events: none;
            transform: translateY(-50%) translateX(-6px);
            background: #181b22;
            color: #f8fafc;
            border: 1px solid rgba(255, 255, 255, 0.16);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.45);
            padding: 0.42rem 0.85rem;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.15s cubic-bezier(0.16, 1, 0.3, 1),
                        transform 0.15s cubic-bezier(0.16, 1, 0.3, 1),
                        visibility 0.15s ease;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .smart-sidebar-tooltip::before {
            content: '';
            position: absolute;
            left: -5px;
            top: 50%;
            transform: translateY(-50%);
            border-top: 5px solid transparent;
            border-bottom: 5px solid transparent;
            border-right: 5px solid #181b22;
        }
        html:not(.dark-mode) .smart-sidebar-tooltip {
            background: #0f172a;
            color: #ffffff;
            border-color: rgba(0, 0, 0, 0.18);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.18);
        }
        html:not(.dark-mode) .smart-sidebar-tooltip::before {
            border-right-color: #0f172a;
        }
        .smart-sidebar-tooltip.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(-50%) translateX(0);
        }

        /* Logout Accent */
        .nav-sidebar .nav-link.logout-btn {
            color: #f87171 !important;
            margin-top: 0.5rem !important;
            border-color: rgba(239, 68, 68, 0.15) !important;
        }
        .nav-sidebar .nav-link.logout-btn > .nav-icon {
            background: rgba(239, 68, 68, 0.12) !important;
            color: #f87171 !important;
            border-color: rgba(239, 68, 68, 0.2) !important;
        }
        .nav-sidebar .nav-link.logout-btn:hover {
            background: rgba(239, 68, 68, 0.16) !important;
            color: #ef4444 !important;
            border-color: rgba(239, 68, 68, 0.3) !important;
        }
        .nav-sidebar .nav-link.logout-btn:hover > .nav-icon {
            background: rgba(239, 68, 68, 0.25) !important;
            color: #ef4444 !important;
        }

        /* Top Navbar User Menu & Quick Logout Button */
        .navbar-user-avatar {
            width: 30px;
            height: 30px;
            object-fit: cover;
            border: 1.5px solid rgba(255, 255, 255, 0.5);
            transition: transform 0.2s ease, border-color 0.2s ease;
        }
        .user-menu-btn:hover .navbar-user-avatar {
            transform: scale(1.08);
            border-color: #ffffff;
        }
        .navbar-quick-logout-btn {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 36px;
            height: 36px;
            border-radius: 10px;
            margin: auto 3px;
            padding: 0 !important;
            color: #ef4444 !important;
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.25);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .navbar-quick-logout-btn:hover {
            background: #ef4444 !important;
            color: #ffffff !important;
            border-color: #ef4444 !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.35);
        }
        .navbar-quick-logout-btn:hover i {
            color: #ffffff !important;
        }
        html.dark-mode .dropdown-user-header {
            background: linear-gradient(135deg, #3730a3, #4338ca) !important;
        }
        html.dark-mode .modern-user-dropdown-menu {
            background: #1e2235 !important;
            border: 1px solid #2e354f !important;
            color: #f8fafc !important;
        }
        html.dark-mode .modern-user-dropdown-menu .dropdown-item {
            color: #cbd5e1 !important;
        }
        html.dark-mode .modern-user-dropdown-menu .dropdown-item:hover {
            background: #252c42 !important;
            color: #ffffff !important;
        }
        html.dark-mode .modern-user-dropdown-menu .bg-light {
            background: #171a2a !important;
            border-top: 1px solid #2e354f !important;
        }

        /* Collapsed Mini-Sidebar Mode (PC Desktop Only >= 992px) */
        @media (min-width: 992px) {
            html.sidebar-collapse .main-sidebar,
            html.sidebar-is-collapsed .main-sidebar,
            body.sidebar-collapse .main-sidebar {
                width: 4.6rem !important;
            }

            html.sidebar-collapse .main-sidebar .brand-link,
            html.sidebar-is-collapsed .main-sidebar .brand-link,
            body.sidebar-collapse .main-sidebar .brand-link,
            .sidebar-mini.sidebar-collapse .main-sidebar .brand-link,
            .layout-navbar-fixed.sidebar-mini.sidebar-collapse .wrapper .brand-link,
            body.sidebar-collapse .main-sidebar .brand-link.modern-brand-header,
            html.sidebar-is-collapsed .main-sidebar .brand-link.modern-brand-header,
            html.sidebar-collapse .main-sidebar .brand-link.modern-brand-header {
                width: 4.6rem !important;
                max-width: 4.6rem !important;
                min-width: 4.6rem !important;
                padding: 0 !important;
                justify-content: center !important;
                overflow: hidden !important;
                height: calc(3.5rem + 1px) !important;
            }

            /* Prevent any hover expansion on brand-link when sidebar is collapsed */
            body.sidebar-collapse .main-sidebar:hover .brand-link,
            html.sidebar-is-collapsed .main-sidebar:hover .brand-link,
            html.sidebar-collapse .main-sidebar:hover .brand-link,
            .sidebar-mini.sidebar-collapse .main-sidebar:hover .brand-link {
                width: 4.6rem !important;
                max-width: 4.6rem !important;
                min-width: 4.6rem !important;
                justify-content: center !important;
                padding: 0 !important;
            }

            html.sidebar-collapse .modern-brand-details,
            html.sidebar-is-collapsed .modern-brand-details,
            body.sidebar-collapse .modern-brand-details,
            .sidebar-mini.sidebar-collapse .modern-brand-details,
            body.sidebar-collapse .main-sidebar:hover .modern-brand-details,
            html.sidebar-is-collapsed .main-sidebar:hover .modern-brand-details,
            html.sidebar-collapse .main-sidebar:hover .modern-brand-details {
                display: none !important;
                opacity: 0 !important;
                visibility: hidden !important;
                width: 0 !important;
                height: 0 !important;
                pointer-events: none !important;
            }

            html.sidebar-collapse .modern-brand-logo,
            html.sidebar-is-collapsed .modern-brand-logo,
            body.sidebar-collapse .modern-brand-logo,
            .sidebar-mini.sidebar-collapse .modern-brand-logo,
            body.sidebar-collapse .main-sidebar:hover .modern-brand-logo,
            html.sidebar-is-collapsed .main-sidebar:hover .modern-brand-logo {
                margin: 0 auto !important;
            }

            body.sidebar-collapse .modern-user-card,
            html.sidebar-is-collapsed body:not(.sidebar-open) .modern-user-card,
            html.sidebar-collapse body:not(.sidebar-open) .modern-user-card {
                margin: 0.65rem auto !important;
                padding: 0 !important;
                width: 44px !important;
                height: 44px !important;
                justify-content: center !important;
                border-radius: 12px !important;
            }

            body.sidebar-collapse .modern-user-info,
            body.sidebar-collapse .modern-user-arrow,
            html.sidebar-is-collapsed body:not(.sidebar-open) .modern-user-info,
            html.sidebar-is-collapsed body:not(.sidebar-open) .modern-user-arrow,
            html.sidebar-collapse body:not(.sidebar-open) .modern-user-info,
            html.sidebar-collapse body:not(.sidebar-open) .modern-user-arrow {
                display: none !important;
            }

            /* Mini Search Pill (Magnifying Glass Button in Mini Mode) */
            body.sidebar-collapse .modern-sidebar-search-container,
            html.sidebar-is-collapsed body:not(.sidebar-open) .modern-sidebar-search-container,
            html.sidebar-collapse body:not(.sidebar-open) .modern-sidebar-search-container {
                margin: 0.35rem auto 0.75rem auto !important;
                width: 44px !important;
            }

            body.sidebar-collapse .modern-search-pill,
            html.sidebar-is-collapsed body:not(.sidebar-open) .modern-search-pill,
            html.sidebar-collapse body:not(.sidebar-open) .modern-search-pill {
                padding: 0 !important;
                justify-content: center !important;
                width: 44px !important;
                height: 40px !important;
                margin: 0 auto !important;
                cursor: pointer !important;
                display: flex !important;
                align-items: center !important;
            }

            body.sidebar-collapse .modern-search-prefix,
            html.sidebar-is-collapsed body:not(.sidebar-open) .modern-search-prefix,
            html.sidebar-collapse body:not(.sidebar-open) .modern-search-prefix {
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                width: 100% !important;
                margin: 0 !important;
                color: rgba(255, 255, 255, 0.65) !important;
            }
            html:not(.dark-mode) body.sidebar-collapse .modern-search-prefix,
            html:not(.dark-mode) html.sidebar-is-collapsed body:not(.sidebar-open) .modern-search-prefix,
            html:not(.dark-mode) html.sidebar-collapse body:not(.sidebar-open) .modern-search-prefix {
                color: #475569 !important;
            }

            body.sidebar-collapse .modern-search-input,
            body.sidebar-collapse .modern-search-actions,
            body.sidebar-collapse .modern-search-clear-btn,
            body.sidebar-collapse .modern-search-kbd,
            body.sidebar-collapse .smart-search-count-badge,
            body.sidebar-collapse .smart-search-empty,
            html.sidebar-is-collapsed body:not(.sidebar-open) .modern-search-input,
            html.sidebar-is-collapsed body:not(.sidebar-open) .modern-search-actions,
            html.sidebar-is-collapsed body:not(.sidebar-open) .modern-search-clear-btn,
            html.sidebar-is-collapsed body:not(.sidebar-open) .modern-search-kbd,
            html.sidebar-is-collapsed body:not(.sidebar-open) .smart-search-count-badge,
            html.sidebar-is-collapsed body:not(.sidebar-open) .smart-search-empty,
            html.sidebar-collapse body:not(.sidebar-open) .modern-search-input,
            html.sidebar-collapse body:not(.sidebar-open) .modern-search-actions,
            html.sidebar-collapse body:not(.sidebar-open) .modern-search-clear-btn,
            html.sidebar-collapse body:not(.sidebar-open) .modern-search-kbd,
            html.sidebar-collapse body:not(.sidebar-open) .smart-search-count-badge,
            html.sidebar-collapse body:not(.sidebar-open) .smart-search-empty {
                display: none !important;
            }

            /* Strictly Destroy Submenus in Collapsed Mini Mode (Prevent Tree Dangle, Lines & Circles) */
            body.sidebar-collapse .nav-sidebar .nav-treeview,
            body.sidebar-collapse .nav-sidebar .nav-treeview *,
            body.sidebar-collapse .nav-sidebar .menu-open > .nav-treeview,
            body.sidebar-collapse .nav-sidebar .menu-is-opening > .nav-treeview,
            body.sidebar-collapse .main-sidebar .nav-sidebar .nav-treeview,
            body.sidebar-collapse .main-sidebar:hover .nav-sidebar .nav-treeview,
            body.sidebar-collapse .nav-sidebar [class*="nav-treeview"],
            /* Target AdminLTE inline style="display:block" override */
            body.sidebar-collapse .nav-sidebar .nav-treeview[style],
            body.sidebar-collapse .nav-sidebar .menu-open > .nav-treeview[style],
            .sidebar-mini.sidebar-collapse .main-sidebar .nav-sidebar .nav-treeview,
            .sidebar-mini.sidebar-collapse .main-sidebar .nav-sidebar .menu-open > .nav-treeview,
            .sidebar-mini.sidebar-collapse .main-sidebar:hover .nav-sidebar .nav-treeview,
            .sidebar-mini.sidebar-collapse .nav-sidebar .nav-treeview[style],
            html.sidebar-collapse .nav-sidebar .nav-treeview,
            html.sidebar-collapse .nav-sidebar .nav-treeview *,
            html.sidebar-collapse .nav-sidebar .menu-open > .nav-treeview,
            html.sidebar-collapse .nav-sidebar .menu-is-opening > .nav-treeview,
            html.sidebar-collapse .main-sidebar:hover .nav-sidebar .nav-treeview,
            html.sidebar-collapse .nav-sidebar .nav-treeview[style],
            html.sidebar-is-collapsed .nav-sidebar .nav-treeview,
            html.sidebar-is-collapsed .nav-sidebar .nav-treeview *,
            html.sidebar-is-collapsed .nav-sidebar .menu-open > .nav-treeview,
            html.sidebar-is-collapsed .nav-sidebar .menu-is-opening > .nav-treeview,
            html.sidebar-is-collapsed .main-sidebar:hover .nav-sidebar .nav-treeview,
            html.sidebar-is-collapsed .nav-sidebar .nav-treeview[style] {
                display: none !important;
                visibility: hidden !important;
                height: 0 !important;
                max-height: 0 !important;
                opacity: 0 !important;
                overflow: hidden !important;
                pointer-events: none !important;
                border: none !important;
                border-left: none !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            body.sidebar-collapse .nav-sidebar .nav-treeview .nav-item::before,
            body.sidebar-collapse .nav-sidebar .nav-treeview .nav-item::after,
            html.sidebar-collapse .nav-sidebar .nav-treeview .nav-item::before,
            html.sidebar-collapse .nav-sidebar .nav-treeview .nav-item::after,
            html.sidebar-is-collapsed .nav-sidebar .nav-treeview .nav-item::before,
            html.sidebar-is-collapsed .nav-sidebar .nav-treeview .nav-item::after {
                display: none !important;
                content: none !important;
                border: none !important;
            }

            /* Navigation Links in Mini Mode: Centered 44x44 Rounded Squares with Zero Overflow */
            body.sidebar-collapse .nav-sidebar .nav-item,
            html.sidebar-is-collapsed body:not(.sidebar-open) .nav-sidebar .nav-item,
            html.sidebar-collapse body:not(.sidebar-open) .nav-sidebar .nav-item {
                width: 100% !important;
                display: flex !important;
                flex-direction: column !important;
                justify-content: center !important;
                align-items: center !important;
                overflow: hidden !important;
                position: relative !important;
            }

            /* Suppress AdminLTE hover-popup treeview (floats to the right of icon in mini mode) */
            body.sidebar-collapse .nav-sidebar .nav-item:hover > .nav-treeview,
            html.sidebar-collapse .nav-sidebar .nav-item:hover > .nav-treeview,
            html.sidebar-is-collapsed .nav-sidebar .nav-item:hover > .nav-treeview,
            body.sidebar-collapse .nav-sidebar .nav-item > .nav-treeview[style],
            html.sidebar-collapse .nav-sidebar .nav-item > .nav-treeview[style],
            html.sidebar-is-collapsed .nav-sidebar .nav-item > .nav-treeview[style] {
                display: none !important;
                visibility: hidden !important;
                opacity: 0 !important;
                pointer-events: none !important;
                position: static !important;
            }

            body.sidebar-collapse .nav-sidebar .nav-item .nav-link,
            html.sidebar-is-collapsed body:not(.sidebar-open) .nav-sidebar .nav-item .nav-link,
            html.sidebar-collapse body:not(.sidebar-open) .nav-sidebar .nav-item .nav-link,
            body.sidebar-collapse .nav-sidebar .nav-link.active,
            html.sidebar-is-collapsed body:not(.sidebar-open) .nav-sidebar .nav-link.active,
            html.sidebar-collapse body:not(.sidebar-open) .nav-sidebar .nav-link.active {
                width: 44px !important;
                height: 44px !important;
                max-width: 44px !important;
                min-width: 44px !important;
                margin: 4px auto !important;
                padding: 0 !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                border-radius: 10px !important;
                box-sizing: border-box !important;
                overflow: hidden !important;
            }

            body.sidebar-collapse .nav-sidebar .nav-link > .nav-icon,
            html.sidebar-is-collapsed body:not(.sidebar-open) .nav-sidebar .nav-link > .nav-icon,
            html.sidebar-collapse body:not(.sidebar-open) .nav-sidebar .nav-link > .nav-icon {
                margin: 0 !important;
                width: 32px !important;
                height: 32px !important;
            }

            body.sidebar-collapse .nav-sidebar .nav-link p,
            body.sidebar-collapse .nav-sidebar .nav-link .right,
            html.sidebar-is-collapsed body:not(.sidebar-open) .nav-sidebar .nav-link p,
            html.sidebar-is-collapsed body:not(.sidebar-open) .nav-sidebar .nav-link .right {
                display: none !important;
            }

            body.sidebar-collapse .nav-sidebar .nav-header,
            html.sidebar-is-collapsed body:not(.sidebar-open) .nav-sidebar .nav-header,
            html.sidebar-collapse body:not(.sidebar-open) .nav-sidebar .nav-header {
                display: none !important;
            }
        }

        /* =========================================================
           Responsive / Mobile (< 992px) Off-Canvas Drawer Architecture
           ========================================================= */
        @media (max-width: 991.98px) {
            /* 1. Brand Link MUST NEVER be fixed or float detached on mobile */
            .layout-navbar-fixed .wrapper .brand-link,
            .layout-navbar-fixed .wrapper .main-sidebar .brand-link,
            .layout-navbar-fixed.sidebar-mini.sidebar-collapse .wrapper .brand-link,
            .layout-navbar-fixed .main-sidebar .brand-link,
            .layout-navbar-fixed .brand-link,
            .main-sidebar .brand-link,
            .brand-link,
            .brand-link.modern-brand-header {
                position: relative !important;
                top: auto !important;
                left: auto !important;
                right: auto !important;
                bottom: auto !important;
                width: 100% !important;
                max-width: 100% !important;
                min-width: 0 !important;
                z-index: 1 !important;
                float: none !important;
            }

            /* 2. When sidebar is closed on mobile, completely remove it from screen flow */
            body:not(.sidebar-open) .main-sidebar,
            html:not(.sidebar-open) .main-sidebar,
            body:not(.sidebar-open) aside.main-sidebar,
            html:not(.sidebar-open) aside.main-sidebar {
                display: none !important;
                visibility: hidden !important;
                transform: translateX(-100%) !important;
                -webkit-transform: translateX(-100%) !important;
                margin-left: 0 !important;
                width: 0 !important;
                max-width: 0 !important;
                pointer-events: none !important;
                box-shadow: none !important;
            }
            body:not(.sidebar-open) .main-sidebar .brand-link,
            body:not(.sidebar-open) .brand-link.modern-brand-header {
                display: none !important;
                visibility: hidden !important;
                pointer-events: none !important;
            }

            /* 3. When sidebar is open on mobile, it slides in cleanly as a 270px drawer */
            body.sidebar-open .main-sidebar,
            html.sidebar-open .main-sidebar,
            body.sidebar-open aside.main-sidebar {
                display: block !important;
                visibility: visible !important;
                transform: translateX(0) !important;
                -webkit-transform: translateX(0) !important;
                width: 270px !important;
                max-width: 85vw !important;
                margin-left: 0 !important;
                box-shadow: 6px 0 30px rgba(0, 0, 0, 0.45) !important;
                z-index: 1045 !important;
                pointer-events: auto !important;
            }
            body.sidebar-open .main-sidebar .brand-link,
            body.sidebar-open .brand-link.modern-brand-header {
                display: flex !important;
                visibility: visible !important;
                width: 100% !important;
            }
            body.sidebar-open .modern-brand-details {
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
                width: auto !important;
            }
            body.sidebar-open .modern-user-info,
            body.sidebar-open .modern-user-arrow {
                display: flex !important;
            }
            body.sidebar-open .nav-sidebar .nav-link p {
                display: flex !important;
            }

            /* 4. Completely neutralize desktop mini-mode classes on mobile */
            body.sidebar-collapse .main-sidebar,
            html.sidebar-collapse .main-sidebar,
            html.sidebar-is-collapsed .main-sidebar {
                width: 270px !important;
                max-width: 85vw !important;
            }
            body.sidebar-collapse:not(.sidebar-open) .main-sidebar,
            html.sidebar-collapse body:not(.sidebar-open) .main-sidebar,
            html.sidebar-is-collapsed body:not(.sidebar-open) .main-sidebar {
                display: none !important;
                visibility: hidden !important;
                transform: translateX(-100%) !important;
                pointer-events: none !important;
                width: 0 !important;
            }

            /* 5. Content wrapper, header, footer always 100% width with 0 left margin on mobile */
            .main-header,
            .content-wrapper,
            .main-footer,
            body.sidebar-collapse .main-header,
            body.sidebar-collapse .content-wrapper,
            body.sidebar-collapse .main-footer {
                margin-left: 0 !important;
                width: 100% !important;
            }
        }
    </style>

    @stack('styles')
</head>


