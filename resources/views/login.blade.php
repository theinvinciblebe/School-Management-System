@php
    $customizes = $customizes ?? \Illuminate\Support\Facades\DB::table('customize')->first();
    $brandLogoFile = $customizes->brand_logo ?? null;
    $brandLogo = (!empty($brandLogoFile) && file_exists(public_path('customize_images/' . $brandLogoFile)))
        ? asset('customize_images/' . $brandLogoFile)
        : (file_exists(public_path('logo-final.png')) ? asset('logo-final.png') : asset('assets/dist/img/mawaridLogo.jpg'));
    $brandTitle = $customizes->brand_title ?? 'School Management System';
    $rawFavicon = $customizes->url_icon ?? 'favicon.ico';
    $faviconVer = file_exists(public_path($rawFavicon)) ? filemtime(public_path($rawFavicon)) : time();
    $currentLang = app()->getLocale();
    $themeCookie = request()->cookie('theme') ?? ($_COOKIE['theme'] ?? null);
    $isDark = ($themeCookie === 'dark-mode');

    // Test accounts for quick role-testing
    $testAccounts = [
        [
            'role' => 0,
            'role_name' => 'Admin',
            'display_role' => __('Admin'),
            'name' => 'Administrator',
            'email' => 'admin@mail.com',
            'password' => '123456',
            'badge' => __('Full Access'),
            'icon' => 'fas fa-user-shield',
            'color' => '#ef4444',
            'bg' => 'rgba(239, 68, 68, 0.12)',
            'border' => 'rgba(239, 68, 68, 0.3)'
        ],
        [
            'role' => 1,
            'role_name' => 'Teacher',
            'display_role' => __('Teacher'),
            'name' => 'TeacherTest',
            'email' => 'TeacherTest@gmail.com',
            'password' => '123456',
            'badge' => __('Teaching & Marks'),
            'icon' => 'fas fa-chalkboard-teacher',
            'color' => '#3b82f6',
            'bg' => 'rgba(59, 130, 246, 0.12)',
            'border' => 'rgba(59, 130, 246, 0.3)'
        ],
        [
            'role' => 2,
            'role_name' => 'Student',
            'display_role' => __('Student'),
            'name' => 'StudentTest',
            'email' => 'StudentTest@gmail.com',
            'password' => '123456',
            'badge' => __('Learning & Marks'),
            'icon' => 'fas fa-user-graduate',
            'color' => '#10b981',
            'bg' => 'rgba(16, 185, 129, 0.12)',
            'border' => 'rgba(16, 185, 129, 0.3)'
        ],
        [
            'role' => 3,
            'role_name' => 'Accountant',
            'display_role' => __('Accountant'),
            'name' => 'phy',
            'email' => 'phy@gmail.com',
            'password' => '123456',
            'badge' => __('Fees & Expenses'),
            'icon' => 'fas fa-file-invoice-dollar',
            'color' => '#f59e0b',
            'bg' => 'rgba(245, 158, 11, 0.12)',
            'border' => 'rgba(245, 158, 11, 0.3)'
        ],
        [
            'role' => 4,
            'role_name' => 'Receptionist',
            'display_role' => __('Receptionist'),
            'name' => 'ReceptionistTest',
            'email' => 'ReceptionistTest@gmail.com',
            'password' => '123456',
            'badge' => __('Front Desk & Staff'),
            'icon' => 'fas fa-concierge-bell',
            'color' => '#8b5cf6',
            'bg' => 'rgba(139, 92, 246, 0.12)',
            'border' => 'rgba(139, 92, 246, 0.3)'
        ]
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ $currentLang }}" class="{{ $isDark ? 'dark-mode' : '' }} {{ $currentLang === 'km' ? 'lang-km' : '' }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Login') }} - {{ $brandTitle }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset($rawFavicon) }}?v={{ $faviconVer }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:ital,wght@0,300..700;1,300..700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- Flag Icon CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/flag-icon-css/css/flag-icon.min.css') }}">

    <style>
        :root {
            --font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            --accent-glow: rgba(79, 70, 229, 0.25);
            --bg-color: #f8fafc;
            --card-bg: #ffffff;
            --card-border: rgba(226, 232, 240, 0.8);
            --text-main: #0f172a;
            --text-muted: #64748b;
            --input-bg: #f8fafc;
            --input-border: #e2e8f0;
            --input-focus-border: #6366f1;
            --shadow-card: 0 20px 45px -10px rgba(15, 23, 42, 0.1), 0 8px 16px -6px rgba(15, 23, 42, 0.04);
            --glass-bg: rgba(255, 255, 255, 0.85);
            --glass-border: rgba(255, 255, 255, 0.6);
        }

        html.lang-km, body.lang-km {
            --font-family: 'Kantumruy Pro', sans-serif !important;
        }

        html.dark-mode {
            --bg-color: #0b0f19;
            --card-bg: #111827;
            --card-border: rgba(255, 255, 255, 0.08);
            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
            --input-bg: #1e293b;
            --input-border: #334155;
            --input-focus-border: #818cf8;
            --shadow-card: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.06);
            --glass-bg: rgba(17, 24, 39, 0.82);
            --glass-border: rgba(255, 255, 255, 0.1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-family);
            background-color: var(--bg-color);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            transition: background-color 0.3s ease, color 0.3s ease;
            position: relative;
        }

        /* Ambient background subtle lighting */
        .ambient-glow {
            position: fixed;
            width: 550px;
            height: 550px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.18) 0%, rgba(139, 92, 246, 0.05) 50%, transparent 70%);
            filter: blur(60px);
            pointer-events: none;
            z-index: 0;
        }
        .glow-1 { top: -150px; left: -100px; }
        .glow-2 { bottom: -180px; right: -120px; }

        /* Top control bar: Language & Theme */
        .top-nav-controls {
            position: fixed;
            top: 20px;
            right: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 100;
        }

        .control-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 30px;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-main);
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .control-pill:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
            color: var(--primary);
        }

        /* Split-screen Layout */
        .auth-container {
            width: 100%;
            max-width: 1240px;
            min-height: 90vh;
            margin: 20px;
            display: grid;
            grid-template-columns: 1.15fr 1fr;
            border-radius: 28px;
            overflow: hidden;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            box-shadow: var(--shadow-card);
            z-index: 1;
            position: relative;
        }

        @media (max-width: 992px) {
            .auth-container {
                grid-template-columns: 1fr;
                max-width: 540px;
                min-height: auto;
                margin: 70px 16px 24px;
            }
            .auth-showcase {
                display: none !important;
            }
        }

        /* Left Showcase Column */
        .auth-showcase {
            position: relative;
            background-image: linear-gradient(135deg, rgba(15, 23, 42, 0.88), rgba(30, 41, 59, 0.94)), url('/login_Mesa.jpg');
            background-size: cover;
            background-position: center;
            padding: 56px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: #ffffff;
            overflow: hidden;
        }

        .showcase-brand-header {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .showcase-brand-logo {
            width: 64px;
            height: 64px;
            object-fit: cover;
            border-radius: 18px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.35);
            border: 2px solid rgba(255, 255, 255, 0.3);
            background: #ffffff;
            padding: 4px;
        }

        .showcase-brand-text h2 {
            font-size: 1.6rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            line-height: 1.2;
            color: #ffffff;
        }

        .showcase-brand-text p {
            font-size: 0.875rem;
            color: #94a3b8;
            font-weight: 500;
        }

        .showcase-hero-content {
            margin: 40px 0;
        }

        .showcase-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            background: rgba(99, 102, 241, 0.2);
            border: 1px solid rgba(129, 140, 248, 0.35);
            border-radius: 20px;
            font-size: 0.82rem;
            font-weight: 600;
            color: #c7d2fe;
            margin-bottom: 20px;
            backdrop-filter: blur(8px);
        }

        .showcase-title {
            font-size: 2.35rem;
            font-weight: 800;
            line-height: 1.25;
            letter-spacing: -0.8px;
            margin-bottom: 16px;
            color: #ffffff;
        }

        .showcase-subtitle {
            font-size: 1.05rem;
            line-height: 1.6;
            color: #cbd5e1;
            max-width: 480px;
        }

        .feature-pills {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-top: 32px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(10px);
            padding: 12px 16px;
            border-radius: 14px;
            font-size: 0.88rem;
            font-weight: 600;
            color: #f1f5f9;
            transition: all 0.25s ease;
        }

        .feature-item:hover {
            background: rgba(255, 255, 255, 0.12);
            transform: translateY(-2px);
        }

        .feature-item i {
            font-size: 1.15rem;
            color: #818cf8;
        }

        .showcase-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.82rem;
            color: #94a3b8;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
        }

        /* Right Form Column */
        .auth-form-side {
            padding: 48px 44px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: var(--card-bg);
            overflow-y: auto;
        }

        @media (max-width: 576px) {
            .auth-form-side {
                padding: 32px 22px;
            }
        }

        /* Mobile Logo Header */
        .mobile-brand-header {
            display: none;
            align-items: center;
            gap: 14px;
            margin-bottom: 24px;
        }

        @media (max-width: 992px) {
            .mobile-brand-header {
                display: flex;
            }
        }

        .mobile-logo {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            object-fit: cover;
            border: 2px solid var(--primary);
            padding: 3px;
            background: #fff;
        }

        .mobile-brand-text h2 {
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--text-main);
            line-height: 1.2;
        }

        .mobile-brand-text p {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .form-header {
            margin-bottom: 24px;
        }

        .form-header h1 {
            font-size: 1.85rem;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.5px;
            margin-bottom: 6px;
        }

        .form-header p {
            font-size: 0.95rem;
            color: var(--text-muted);
        }

        /* Quick Demo Test Accounts Box */
        .test-accounts-panel {
            background: var(--input-bg);
            border: 1px dashed var(--input-border);
            border-radius: 18px;
            padding: 18px;
            margin-bottom: 24px;
            transition: border-color 0.2s ease;
        }

        .test-accounts-panel:hover {
            border-color: var(--primary);
        }

        .panel-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .panel-title {
            font-size: 0.82rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .panel-hint {
            font-size: 0.76rem;
            color: var(--primary);
            font-weight: 600;
        }

        .role-cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(95px, 1fr));
            gap: 8px;
        }

        .role-pill-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 5px;
            padding: 10px 8px;
            background: var(--card-bg);
            border: 1.5px solid var(--input-border);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            text-align: center;
            user-select: none;
        }

        .role-pill-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-color: var(--role-color, var(--primary));
        }

        .role-pill-btn.active {
            border-color: var(--role-color, var(--primary)) !important;
            background: var(--role-bg, rgba(99, 102, 241, 0.1)) !important;
            box-shadow: 0 0 0 2px var(--role-border, rgba(99, 102, 241, 0.25));
        }

        .role-pill-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
            color: var(--role-color, var(--primary));
            background: var(--role-bg, rgba(99, 102, 241, 0.1));
            transition: transform 0.2s ease;
        }

        .role-pill-btn:hover .role-pill-icon {
            transform: scale(1.1);
        }

        .role-pill-label {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--text-main);
            line-height: 1.1;
        }

        .role-pill-badge {
            font-size: 0.65rem;
            color: var(--text-muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 90px;
        }

        /* Selected Role Feedback Banner */
        .selected-account-banner {
            display: none;
            margin-top: 10px;
            padding: 8px 12px;
            background: rgba(99, 102, 241, 0.08);
            border-radius: 10px;
            font-size: 0.8rem;
            color: var(--text-main);
            align-items: center;
            justify-content: space-between;
            animation: fadeIn 0.3s ease;
        }

        .selected-account-banner.active {
            display: flex;
        }

        /* Form Inputs */
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            color: var(--text-muted);
            font-size: 1rem;
            pointer-events: none;
            transition: color 0.2s ease;
        }

        .form-control-modern {
            width: 100%;
            height: 52px;
            padding: 12px 16px 12px 46px;
            background: var(--input-bg);
            border: 1.5px solid var(--input-border);
            border-radius: 14px;
            font-size: 0.95rem;
            color: var(--text-main);
            font-family: inherit;
            transition: all 0.25s ease;
            outline: none;
        }

        .form-control-modern:focus {
            background: var(--card-bg);
            border-color: var(--input-focus-border);
            box-shadow: 0 0 0 4px var(--accent-glow);
        }

        .input-wrapper:focus-within .input-icon {
            color: var(--primary);
        }

        /* Password Toggle */
        .password-toggle-btn {
            position: absolute;
            right: 14px;
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 6px;
            font-size: 1rem;
            transition: color 0.2s ease;
        }

        .password-toggle-btn:hover {
            color: var(--text-main);
        }

        /* Form Auxiliary row (Remember me & Forgot pwd) */
        .form-auxiliary {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            font-size: 0.875rem;
        }

        .custom-checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            user-select: none;
            color: var(--text-muted);
            font-weight: 500;
        }

        .custom-checkbox-label input {
            accent-color: var(--primary);
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .forgot-link {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        /* Submit Button */
        .btn-submit-login {
            width: 100%;
            height: 54px;
            background: var(--primary-gradient);
            border: none;
            border-radius: 14px;
            color: #ffffff;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 0.3px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.4);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .btn-submit-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 28px -5px rgba(79, 70, 229, 0.55);
        }

        .btn-submit-login:active {
            transform: translateY(0);
        }

        /* Alert Notifications */
        .custom-alert {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            border-radius: 14px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            font-weight: 500;
            animation: shake 0.4s ease-in-out;
        }

        .custom-alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.25);
            color: #ef4444;
        }

        /* Footer link to admission */
        .admission-footer-link {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid var(--input-border);
            text-align: center;
            font-size: 0.88rem;
            color: var(--text-muted);
        }

        .admission-footer-link a {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
            margin-left: 4px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .admission-footer-link a:hover {
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-6px); }
            40%, 80% { transform: translateX(6px); }
        }
    </style>
</head>

<body>
    <!-- Ambient glow lights -->
    <div class="ambient-glow glow-1"></div>
    <div class="ambient-glow glow-2"></div>

    <!-- Top Controls: Language Switcher & Dark Mode Toggle -->
    <div class="top-nav-controls">
        <!-- Language Switcher -->
        @if ($currentLang === 'km')
            <a href="{{ route('lang.switch', 'en') }}" class="control-pill" title="Switch to English">
                <span class="flag-icon flag-icon-us"></span>
                <span>English</span>
            </a>
        @else
            <a href="{{ route('lang.switch', 'km') }}" class="control-pill" title="ប្តូរទៅភាសាខ្មែរ">
                <span class="flag-icon flag-icon-kh"></span>
                <span>ភាសាខ្មែរ</span>
            </a>
        @endif

        <!-- Theme Toggle -->
        <button type="button" id="loginThemeToggle" class="control-pill" title="Toggle Theme" aria-label="Toggle Theme">
            <i class="fas {{ $isDark ? 'fa-sun text-warning' : 'fa-moon text-primary' }}" id="loginThemeIcon"></i>
            <span id="loginThemeLabel">{{ $isDark ? __('Light Mode') : __('Dark Mode') }}</span>
        </button>
    </div>

    <!-- Main Container -->
    <div class="auth-container">
        <!-- LEFT: Showcase Branding Side -->
        <div class="auth-showcase">
            <div class="showcase-brand-header">
                <img src="{{ $brandLogo }}" alt="{{ $brandTitle }}" class="showcase-brand-logo">
                <div class="showcase-brand-text">
                    <h2>{{ $brandTitle }}</h2>
                    <p>{{ __('Academic Management Online') }}</p>
                </div>
            </div>

            <div class="showcase-hero-content">
                <div class="showcase-badge">
                    <i class="fas fa-sparkles"></i>
                    <span>Next-Gen School Portal</span>
                </div>
                <h1 class="showcase-title">
                    Empowering Modern Education & School Management
                </h1>
                <p class="showcase-subtitle">
                    Seamlessly connect administrators, faculty, accountants, and students on a unified, high-performance platform.
                </p>

                <div class="feature-pills">
                    <div class="feature-item">
                        <i class="fas fa-user-check"></i>
                        <span>{{ __('Daily Attendance') }}</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-graduation-cap"></i>
                        <span>{{ __('Manage Marks') }}</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span>{{ __('Financials') }}</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-cubes"></i>
                        <span>{{ __('Class Material') }}</span>
                    </div>
                </div>
            </div>

            <div class="showcase-footer">
                <span>&copy; {{ date('Y') }} {{ $brandTitle }}. All rights reserved.</span>
                <span>v2.5 Stable</span>
            </div>
        </div>

        <!-- RIGHT: Interactive Form Side -->
        <div class="auth-form-side">
            <!-- Mobile Brand Header -->
            <div class="mobile-brand-header">
                <img src="{{ $brandLogo }}" alt="{{ $brandTitle }}" class="mobile-logo">
                <div class="mobile-brand-text">
                    <h2>{{ $brandTitle }}</h2>
                    <p>{{ __('Academic Management Online') }}</p>
                </div>
            </div>

            <div class="form-header">
                <h1>{{ __('Sign in to your account') }}</h1>
                <p>{{ __('Select a test account below or enter your credentials') }}</p>
            </div>

            <!-- QUICK TEST ACCOUNTS SELECTOR -->
            <div class="test-accounts-panel">
                <div class="panel-heading">
                    <span class="panel-title">
                        <i class="fas fa-vial text-primary"></i>
                        {{ __('Quick Test Accounts') }}
                    </span>
                    <span class="panel-hint">
                        <i class="fas fa-mouse-pointer"></i> 1-Click Fill
                    </span>
                </div>

                <div class="role-cards-grid">
                    @foreach($testAccounts as $account)
                        <button type="button"
                                class="role-pill-btn {{ $loop->first ? 'active' : '' }}"
                                data-role="{{ $account['role'] }}"
                                data-email="{{ $account['email'] }}"
                                data-password="{{ $account['password'] }}"
                                data-name="{{ $account['name'] }}"
                                data-rolename="{{ $account['display_role'] }}"
                                style="--role-color: {{ $account['color'] }}; --role-bg: {{ $account['bg'] }}; --role-border: {{ $account['border'] }};"
                                title="Auto-fill {{ $account['display_role'] }} ({{ $account['email'] }})">
                            <div class="role-pill-icon">
                                <i class="{{ $account['icon'] }}"></i>
                            </div>
                            <span class="role-pill-label">{{ $account['display_role'] }}</span>
                            <span class="role-pill-badge">{{ $account['badge'] }}</span>
                        </button>
                    @endforeach
                </div>

                <div id="selectedAccountBanner" class="selected-account-banner active">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-check-circle text-success" id="bannerCheckIcon"></i>
                        <span>
                            Loaded: <strong id="bannerRoleName">Admin</strong> (<span id="bannerEmail" style="opacity: 0.85;">admin@mail.com</span>)
                        </span>
                    </div>
                    <span style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600;">PWD: 123456</span>
                </div>
            </div>

            <!-- Login Error Status Banner -->
            @if(session('status'))
                <div class="custom-alert custom-alert-danger" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>{{ session('status') }}</div>
                </div>
            @endif

            @if(isset($errors) && $errors->any())
                <div class="custom-alert custom-alert-danger" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>{{ $errors->first() }}</div>
                </div>
            @endif

            <!-- LOGIN FORM -->
            <form id="loginForm" method="POST" action="{{ route('do_login') }}" novalidate>
                @csrf

                <!-- Email Input -->
                <div class="form-group">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email', 'admin@mail.com') }}"
                            placeholder="name@school.edu"
                            class="form-control-modern"
                            autocomplete="username"
                            required
                            enterkeyhint="next">
                    </div>
                </div>

                <!-- Password Input -->
                <div class="form-group">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            value="123456"
                            placeholder="••••••••"
                            class="form-control-modern"
                            autocomplete="current-password"
                            required
                            enterkeyhint="done">
                        <button type="button" id="togglePasswordBtn" class="password-toggle-btn" aria-label="Show password" title="Toggle password visibility">
                            <i class="far fa-eye" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Auxiliary Controls -->
                <div class="form-auxiliary">
                    <label class="custom-checkbox-label">
                        <input type="checkbox" name="remember" id="remember" checked>
                        <span>{{ __('Remember me') }}</span>
                    </label>

                    <a href="javascript:void(0)" onclick="alert('For password resets, please contact the administrator.')" class="forgot-link">
                        {{ __('Forgot password?') }}
                    </a>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="submitBtn" class="btn-submit-login">
                    <span id="submitBtnText">{{ __('Sign In') }}</span>
                    <i class="fas fa-arrow-right" id="submitBtnIcon"></i>
                </button>
            </form>

            <!-- Admission Registration Link -->
            <div class="admission-footer-link">
                <span>{{ __('Need to enroll as a new student?') }}</span>
                <a href="{{ url('/admission-form') }}">
                    {{ __('Apply Here') }}
                    <i class="fas fa-external-link-alt" style="font-size: 0.75rem;"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const togglePasswordBtn = document.getElementById('togglePasswordBtn');
            const togglePasswordIcon = document.getElementById('togglePasswordIcon');
            const roleButtons = document.querySelectorAll('.role-pill-btn');
            const bannerRoleName = document.getElementById('bannerRoleName');
            const bannerEmail = document.getElementById('bannerEmail');
            const loginForm = document.getElementById('loginForm');
            const submitBtn = document.getElementById('submitBtn');
            const submitBtnText = document.getElementById('submitBtnText');
            const submitBtnIcon = document.getElementById('submitBtnIcon');

            // 1. Password Visibility Toggle
            if (togglePasswordBtn && passwordInput && togglePasswordIcon) {
                togglePasswordBtn.addEventListener('click', function () {
                    const isPassword = passwordInput.getAttribute('type') === 'password';
                    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                    togglePasswordIcon.classList.toggle('fa-eye', !isPassword);
                    togglePasswordIcon.classList.toggle('fa-eye-slash', isPassword);
                    togglePasswordBtn.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
                });
            }

            // 2. Role Selector (Quick 1-Click Credentials Populator)
            roleButtons.forEach(btn => {
                btn.addEventListener('click', function () {
                    roleButtons.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    const email = this.getAttribute('data-email');
                    const password = this.getAttribute('data-password');
                    const roleName = this.getAttribute('data-rolename');

                    emailInput.value = email;
                    passwordInput.value = password;

                    // Update loaded indicator banner
                    if (bannerRoleName && bannerEmail) {
                        bannerRoleName.textContent = roleName;
                        bannerEmail.textContent = email;
                    }

                    // Gentle highlight feedback animation
                    [emailInput, passwordInput].forEach(input => {
                        input.style.transition = 'all 0.15s ease';
                        input.style.borderColor = 'var(--primary)';
                        input.style.backgroundColor = 'var(--input-bg)';
                        setTimeout(() => {
                            input.style.borderColor = '';
                        }, 400);
                    });
                });
            });

            // 3. Form Submit Feedback Spinner
            if (loginForm && submitBtn) {
                loginForm.addEventListener('submit', function (e) {
                    if (!emailInput.value || !passwordInput.value) {
                        return; // Let browser HTML5 validation prompt
                    }
                    submitBtn.disabled = true;
                    submitBtn.style.opacity = '0.85';
                    submitBtn.style.cursor = 'wait';
                    submitBtnText.textContent = 'Signing in...';
                    submitBtnIcon.className = 'fas fa-spinner fa-spin';
                });
            }

            // 4. Dark / Light Theme Toggle Handler
            const themeToggleBtn = document.getElementById('loginThemeToggle');
            const themeIcon = document.getElementById('loginThemeIcon');
            const themeLabel = document.getElementById('loginThemeLabel');

            function applyTheme(isDark) {
                if (isDark) {
                    document.documentElement.classList.add('dark-mode');
                    document.cookie = "theme=dark-mode; path=/; max-age=31536000; SameSite=Lax";
                    localStorage.setItem('theme', 'dark-mode');
                    if (themeIcon) {
                        themeIcon.className = 'fas fa-sun text-warning';
                    }
                    if (themeLabel) {
                        themeLabel.textContent = '{{ __("Light Mode") }}';
                    }
                } else {
                    document.documentElement.classList.remove('dark-mode');
                    document.cookie = "theme=light-mode; path=/; max-age=31536000; SameSite=Lax";
                    localStorage.setItem('theme', 'light-mode');
                    if (themeIcon) {
                        themeIcon.className = 'fas fa-moon text-primary';
                    }
                    if (themeLabel) {
                        themeLabel.textContent = '{{ __("Dark Mode") }}';
                    }
                }
            }

            // Sync with existing stored preference
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark-mode') {
                applyTheme(true);
            } else if (savedTheme === 'light-mode') {
                applyTheme(false);
            }

            if (themeToggleBtn) {
                themeToggleBtn.addEventListener('click', function () {
                    const isCurrentlyDark = document.documentElement.classList.contains('dark-mode');
                    applyTheme(!isCurrentlyDark);
                });
            }
        });
    </script>
</body>
</html>
