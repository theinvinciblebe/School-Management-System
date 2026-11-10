<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="{{ (request()->cookie('theme') === 'dark-mode' || (!request()->cookie('theme') && false)) ? 'dark-mode' : '' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Installation Wizard') }} | {{ config('app.name', 'School MS') }}</title>

    <!-- Google Font: Inter & Kantumruy Pro for Khmer -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Kantumruy+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Bootstrap 4 / AdminLTE Theme -->
    <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="/assets/plugins/toastr/toastr.min.css">

    <style>
        :root {
            --brand-primary: #4f46e5;
            --brand-primary-hover: #4338ca;
            --brand-surface: #ffffff;
            --brand-bg: #f8fafc;
            --brand-text: #0f172a;
            --brand-muted: #64748b;
            --brand-border: #e2e8f0;
        }

        html.dark-mode {
            --brand-surface: #1e293b;
            --brand-bg: #0f172a;
            --brand-text: #f8fafc;
            --brand-muted: #94a3b8;
            --brand-border: #334155;
        }

        body {
            font-family: 'Inter', 'Kantumruy Pro', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: var(--brand-bg);
            color: var(--brand-text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: background-color 0.3s ease, color 0.3s ease;
            position: relative;
            overflow-x: hidden;
        }

        /* Ambient Background Mesh */
        .ambient-mesh {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -1;
            pointer-events: none;
            overflow: hidden;
        }
        .mesh-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(90px);
            opacity: 0.28;
            animation: orbFloat 18s ease-in-out infinite alternate;
        }
        .mesh-orb-1 { width: 550px; height: 550px; background: #6366f1; top: -120px; left: -100px; }
        .mesh-orb-2 { width: 500px; height: 500px; background: #10b981; bottom: -100px; right: -80px; animation-duration: 22s; }
        .mesh-orb-3 { width: 350px; height: 350px; background: #f59e0b; top: 40%; left: 50%; transform: translate(-50%, -50%); opacity: 0.16; }

        @keyframes orbFloat {
            0% { transform: translateY(0) scale(1); }
            100% { transform: translateY(50px) scale(1.08); }
        }

        /* Top Navbar */
        .installer-navbar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--brand-border);
            padding: 0.85rem 2rem;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .dark-mode .installer-navbar {
            background: rgba(15, 23, 42, 0.85);
        }

        /* Main Container Card */
        .installer-card {
            background: var(--brand-surface);
            border: 1px solid var(--brand-border);
            border-radius: 1.5rem;
            box-shadow: 0 20px 45px -10px rgba(0, 0, 0, 0.08), 0 1px 3px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            backdrop-filter: blur(16px);
        }
        .dark-mode .installer-card {
            box-shadow: 0 20px 50px -10px rgba(0, 0, 0, 0.4);
        }

        /* Stepper Navigation */
        .installer-stepper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(248, 250, 252, 0.8);
            border-bottom: 1px solid var(--brand-border);
            padding: 1.25rem 2rem;
            overflow-x: auto;
        }
        .dark-mode .installer-stepper {
            background: rgba(15, 23, 42, 0.5);
        }
        .step-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            position: relative;
            flex-shrink: 0;
            user-select: none;
            transition: all 0.25s ease;
        }
        .step-bubble {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.95rem;
            background: #e2e8f0;
            color: #64748b;
            transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
            border: 2px solid transparent;
        }
        .dark-mode .step-bubble {
            background: #334155;
            color: #94a3b8;
        }
        .step-item.active .step-bubble {
            background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%);
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(99, 102, 241, 0.45);
            transform: scale(1.1);
        }
        .step-item.completed .step-bubble {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35);
        }
        .step-content {
            display: flex;
            flex-direction: column;
        }
        .step-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--brand-muted);
            transition: color 0.2s ease;
        }
        .step-item.active .step-title {
            color: #6366f1;
        }
        .dark-mode .step-item.active .step-title {
            color: #818cf8;
        }
        .step-item.completed .step-title {
            color: #10b981;
        }
        .step-divider {
            flex: 1;
            height: 2px;
            background: #e2e8f0;
            margin: 0 1rem;
            min-width: 24px;
        }
        .dark-mode .step-divider {
            background: #334155;
        }

        /* Step Panels */
        .step-pane {
            display: none;
            padding: 2.5rem;
            animation: fadeIn 0.3s ease-in-out;
        }
        .step-pane.active {
            display: block;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Diagnostic Badge */
        .diagnostic-card {
            background: rgba(248, 250, 252, 0.7);
            border: 1px solid var(--brand-border);
            border-radius: 1rem;
            padding: 1.25rem;
            transition: all 0.2s ease;
        }
        .dark-mode .diagnostic-card {
            background: rgba(15, 23, 42, 0.4);
        }

        /* Database Selection Cards */
        .db-card-option {
            border: 2px solid var(--brand-border);
            border-radius: 1rem;
            padding: 1.25rem;
            cursor: pointer;
            transition: all 0.22s ease;
            text-align: center;
            background: var(--brand-surface);
        }
        .db-card-option:hover {
            border-color: #6366f1;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.15);
        }
        .db-card-option.active {
            border-color: #6366f1;
            background: rgba(99, 102, 241, 0.05);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25);
        }

        /* Color Chooser Swatches */
        .theme-swatch {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border: 2px solid transparent;
        }
        .theme-swatch:hover {
            transform: scale(1.15);
        }
        .theme-swatch.active {
            border-color: var(--brand-text);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.4);
        }
    </style>
</head>
<body>

    <!-- Ambient Mesh Orbs -->
    <div class="ambient-mesh">
        <div class="mesh-orb mesh-orb-1"></div>
        <div class="mesh-orb mesh-orb-2"></div>
        <div class="mesh-orb mesh-orb-3"></div>
    </div>

    <!-- Top Navigation Bar -->
    <header class="installer-navbar d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <span class="mr-3 px-3 py-2 rounded-xl text-white shadow-sm" style="background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%);">
                <i class="fas fa-graduation-cap fa-lg"></i>
            </span>
            <div>
                <h1 class="h5 font-weight-bold mb-0 text-dark dark:text-white">{{ config('app.name', 'School MS') }}</h1>
                <span class="small text-muted">{{ __('Enterprise Installation & Setup Wizard v2.0') }}</span>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <!-- Language Switcher -->
            <div class="dropdown mr-2">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle rounded-pill px-3 font-weight-bold" type="button" id="langDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-globe mr-1 text-primary"></i> {{ app()->getLocale() === 'km' ? 'ភាសាខ្មែរ (KM)' : 'English (US)' }}
                </button>
                <div class="dropdown-menu dropdown-menu-right shadow-sm border-0 rounded-lg" aria-labelledby="langDropdown">
                    <a class="dropdown-item py-2 {{ app()->getLocale() === 'en' ? 'active font-weight-bold' : '' }}" href="{{ route('lang.switch', 'en') }}">
                        <span class="mr-2">🇺🇸</span> English (US)
                    </a>
                    <a class="dropdown-item py-2 {{ app()->getLocale() === 'km' ? 'active font-weight-bold' : '' }}" href="{{ route('lang.switch', 'km') }}">
                        <span class="mr-2">🇰🇭</span> ភាសាខ្មែរ (Khmer)
                    </a>
                </div>
            </div>

            <!-- Theme Toggle -->
            <button class="btn btn-outline-secondary btn-sm rounded-circle" id="themeToggleBtn" title="{{ __('Toggle Light/Dark Theme') }}" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;">
                <i class="fas fa-moon" id="themeIcon"></i>
            </button>
        </div>
    </header>

    <!-- Main Wizard Wrapper -->
    <main class="container my-5 flex-grow-1">
        <div class="installer-card">
            
            <!-- Stepper Progress Bar -->
            <div class="installer-stepper">
                <div class="step-item active" data-step="1" onclick="jumpToStep(1)">
                    <div class="step-bubble">1</div>
                    <div class="step-content d-none d-md-flex">
                        <span class="step-title">{{ __('Welcome') }}</span>
                    </div>
                </div>

                <div class="step-divider"></div>

                <div class="step-item" data-step="2" onclick="jumpToStep(2)">
                    <div class="step-bubble">2</div>
                    <div class="step-content d-none d-md-flex">
                        <span class="step-title">{{ __('Environment') }}</span>
                    </div>
                </div>

                <div class="step-divider"></div>

                <div class="step-item" data-step="3" onclick="jumpToStep(3)">
                    <div class="step-bubble">3</div>
                    <div class="step-content d-none d-md-flex">
                        <span class="step-title">{{ __('Database') }}</span>
                    </div>
                </div>

                <div class="step-divider"></div>

                <div class="step-item" data-step="4" onclick="jumpToStep(4)">
                    <div class="step-bubble">4</div>
                    <div class="step-content d-none d-md-flex">
                        <span class="step-title">{{ __('Institution') }}</span>
                    </div>
                </div>

                <div class="step-divider"></div>

                <div class="step-item" data-step="5" onclick="jumpToStep(5)">
                    <div class="step-bubble">5</div>
                    <div class="step-content d-none d-md-flex">
                        <span class="step-title">{{ __('Admin User') }}</span>
                    </div>
                </div>

                <div class="step-divider"></div>

                <div class="step-item" data-step="6" onclick="jumpToStep(6)">
                    <div class="step-bubble"><i class="fas fa-flag-checkered"></i></div>
                    <div class="step-content d-none d-md-flex">
                        <span class="step-title">{{ __('Launch') }}</span>
                    </div>
                </div>
            </div>

            <!-- =================================================================
                 STEP 1: WELCOME & OVERVIEW
                 ================================================================= -->
            <section class="step-pane active" id="paneStep1">
                <div class="text-center mb-5">
                    <div class="d-inline-flex p-3 rounded-2xl mb-3 shadow-lg" style="background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%);">
                        <i class="fas fa-magic fa-3x text-white"></i>
                    </div>
                    <h2 class="h3 font-weight-bold mb-2">{{ __('Welcome to School Management System') }}</h2>
                    <p class="text-muted max-w-xl mx-auto" style="max-width: 600px;">
                        {{ __('The modern, enterprise-ready platform for academic administration, automated student billing, examination grading, class schedules, and multi-role portals.') }}
                    </p>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="diagnostic-card h-100">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge badge-primary mr-2"><i class="fas fa-users-cog"></i></span>
                                <h6 class="font-weight-bold mb-0">{{ __('Multi-Role Portals') }}</h6>
                            </div>
                            <p class="small text-muted mb-0">{{ __('Dedicated executive dashboards for Administrators, Teachers, Students, Accountants, and Receptionists.') }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="diagnostic-card h-100">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge badge-success mr-2"><i class="fas fa-file-invoice-dollar"></i></span>
                                <h6 class="font-weight-bold mb-0">{{ __('Smart Accounting & Invoicing') }}</h6>
                            </div>
                            <p class="small text-muted mb-0">{{ __('Automated monthly student fee generation, purchase requests, profit analytics, and payment receipts.') }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="diagnostic-card h-100">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge badge-info mr-2"><i class="fas fa-language"></i></span>
                                <h6 class="font-weight-bold mb-0">{{ __('100% Khmer & English') }}</h6>
                            </div>
                            <p class="small text-muted mb-0">{{ __('Comprehensive bilingual localization with seamless live switching across all interfaces and reports.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="border rounded-xl p-3 mb-4 bg-light dark:bg-slate-800 d-flex align-items-center">
                    <div class="custom-control custom-checkbox mr-3">
                        <input type="checkbox" class="custom-control-input" id="termsCheck" checked>
                        <label class="custom-control-label font-weight-bold small text-dark dark:text-white" for="termsCheck">
                            {{ __('I accept the software license agreement and want to proceed with setup.') }}
                        </label>
                    </div>
                    <span class="badge badge-success ml-auto">{{ __('Version 2.0') }}</span>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-primary rounded-pill px-4 py-2 font-weight-bold shadow-sm" onclick="nextStep(2)">
                        {{ __('Get Started') }} <i class="fas fa-arrow-right ml-1"></i>
                    </button>
                </div>
            </section>

            <!-- =================================================================
                 STEP 2: SERVER & ENVIRONMENT DIAGNOSTICS
                 ================================================================= -->
            <section class="step-pane" id="paneStep2">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 pb-3 border-bottom">
                    <div>
                        <h3 class="h4 font-weight-bold mb-1">{{ __('Server & Environment Diagnostics') }}</h3>
                        <p class="text-muted small mb-0">{{ __('Verifying PHP version, required runtime extensions, and directory permissions.') }}</p>
                    </div>
                    <div>
                        @if ($systemReady)
                            <span class="badge badge-success px-3 py-2 rounded-pill font-weight-bold">
                                <i class="fas fa-check-circle mr-1"></i> {{ __('100% System Ready') }}
                            </span>
                        @else
                            <span class="badge badge-warning px-3 py-2 rounded-pill font-weight-bold">
                                <i class="fas fa-exclamation-triangle mr-1"></i> {{ __('Review Requirements') }}
                            </span>
                        @endif
                    </div>
                </div>

                <!-- PHP Version -->
                <div class="card mb-4 border rounded-xl overflow-hidden">
                    <div class="card-header bg-light dark:bg-slate-800 py-2 px-3 font-weight-bold d-flex justify-content-between align-items-center">
                        <span><i class="fab fa-php text-primary mr-2"></i> {{ __('PHP Runtime Engine') }}</span>
                        @if ($phpSatisfied)
                            <span class="badge badge-success">{{ __('Passed (v') }}{{ $currentPhpVersion }})</span>
                        @else
                            <span class="badge badge-danger">{{ __('Requires PHP >=') }} {{ $minPhpVersion }}</span>
                        @endif
                    </div>
                </div>

                <!-- PHP Extensions Grid -->
                <h6 class="font-weight-bold mb-2 text-dark dark:text-white">{{ __('Required PHP Extensions') }}</h6>
                <div class="row mb-4">
                    @foreach ($extensionResults as $ext)
                        <div class="col-sm-6 col-md-4 mb-2">
                            <div class="diagnostic-card d-flex align-items-center justify-content-between py-2 px-3">
                                <div>
                                    <span class="font-weight-bold small d-block">{{ $ext['name'] }}</span>
                                    <code class="text-muted small">{{ $ext['extension'] }}</code>
                                </div>
                                @if ($ext['satisfied'])
                                    <span class="badge badge-pill badge-success"><i class="fas fa-check"></i></span>
                                @else
                                    <span class="badge badge-pill badge-danger"><i class="fas fa-times"></i></span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Writable Directories -->
                <h6 class="font-weight-bold mb-2 text-dark dark:text-white">{{ __('Directory Permissions') }}</h6>
                <div class="row mb-4">
                    @foreach ($directoryResults as $dir)
                        <div class="col-sm-6 col-md-4 mb-2">
                            <div class="diagnostic-card d-flex align-items-center justify-content-between py-2 px-3">
                                <span class="font-weight-bold small"><code>{{ $dir['label'] }}</code></span>
                                @if ($dir['satisfied'])
                                    <span class="badge badge-pill badge-success"><i class="fas fa-check"></i> {{ __('Writable') }}</span>
                                @else
                                    <span class="badge badge-pill badge-danger"><i class="fas fa-times"></i> {{ __('Not Writable') }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-between pt-3 border-top">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="nextStep(1)">
                        <i class="fas fa-arrow-left mr-1"></i> {{ __('Back') }}
                    </button>
                    <button type="button" class="btn btn-primary rounded-pill px-4 font-weight-bold shadow-sm" onclick="nextStep(3)">
                        {{ __('Continue to Database') }} <i class="fas fa-arrow-right ml-1"></i>
                    </button>
                </div>
            </section>

            <!-- =================================================================
                 STEP 3: DATABASE CONFIGURATION
                 ================================================================= -->
            <section class="step-pane" id="paneStep3">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 pb-3 border-bottom">
                    <div>
                        <h3 class="h4 font-weight-bold mb-1">{{ __('Database Configuration & Migrations') }}</h3>
                        <p class="text-muted small mb-0">{{ __('Select your target database engine and test connectivity live.') }}</p>
                    </div>
                    <div>
                        @if ($dbConnected)
                            <span class="badge badge-success px-3 py-2 rounded-pill font-weight-bold">
                                <i class="fas fa-database mr-1"></i> {{ __('Active Connection') }}: {{ strtoupper(DB::getDriverName()) }}
                            </span>
                        @else
                            <span class="badge badge-danger px-3 py-2 rounded-pill font-weight-bold">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ __('Not Connected') }}
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Database Engine Selection Cards -->
                <div class="row mb-4">
                    <div class="col-md-4 mb-2">
                        <div class="db-card-option active" data-driver="sqlite" onclick="selectDbDriver('sqlite')">
                            <i class="fas fa-file-invoice text-primary fa-2x mb-2"></i>
                            <h6 class="font-weight-bold mb-1">SQLite</h6>
                            <p class="small text-muted mb-0">{{ __('Zero config, embedded file database.') }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <div class="db-card-option" data-driver="pgsql" onclick="selectDbDriver('pgsql')">
                            <i class="fas fa-server text-info fa-2x mb-2"></i>
                            <h6 class="font-weight-bold mb-1">PostgreSQL</h6>
                            <p class="small text-muted mb-0">{{ __('Supabase & enterprise cloud databases.') }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <div class="db-card-option" data-driver="mysql" onclick="selectDbDriver('mysql')">
                            <i class="fas fa-database text-warning fa-2x mb-2"></i>
                            <h6 class="font-weight-bold mb-1">MySQL / MariaDB</h6>
                            <p class="small text-muted mb-0">{{ __('Traditional relational production database.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- DB Form Fields -->
                <form id="dbConfigForm">
                    <input type="hidden" name="driver" id="selectedDbDriver" value="{{ DB::getDriverName() ?: 'sqlite' }}">
                    
                    <div id="remoteDbFields" style="display: none;">
                        <div class="row">
                            <div class="col-md-8 form-group">
                                <label class="small font-weight-bold">{{ __('Database Host') }}</label>
                                <input type="text" name="host" id="dbHost" class="form-control rounded-lg" value="{{ env('DB_HOST', '127.0.0.1') }}" placeholder="127.0.0.1">
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="small font-weight-bold">{{ __('Port') }}</label>
                                <input type="text" name="port" id="dbPort" class="form-control rounded-lg" value="{{ env('DB_PORT', '5432') }}" placeholder="5432">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="small font-weight-bold">{{ __('Database Name') }}</label>
                            <input type="text" name="database" id="dbName" class="form-control rounded-lg" value="{{ env('DB_DATABASE', 'school_db') }}" placeholder="school_db">
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="small font-weight-bold">{{ __('Username') }}</label>
                                <input type="text" name="username" id="dbUsername" class="form-control rounded-lg" value="{{ env('DB_USERNAME', 'postgres') }}">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="small font-weight-bold">{{ __('Password') }}</label>
                                <input type="password" name="password" id="dbPassword" class="form-control rounded-lg" value="{{ env('DB_PASSWORD', '') }}">
                            </div>
                        </div>
                    </div>

                    <div id="sqliteDbFields">
                        <div class="form-group">
                            <label class="small font-weight-bold">{{ __('SQLite Database File Path') }}</label>
                            <input type="text" name="database_sqlite" id="dbSqlitePath" class="form-control rounded-lg" value="database/database.sqlite" readonly>
                            <small class="text-muted">{{ __('Automatically managed in the database folder.') }}</small>
                        </div>
                    </div>

                    <!-- Test Connection Button & Status Box -->
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <button type="button" class="btn btn-outline-info rounded-pill px-4" id="btnTestDbConnection" onclick="testDbConnection()">
                            <i class="fas fa-plug mr-1"></i> {{ __('Test Connection') }}
                        </button>
                        <span id="dbTestStatusText" class="small font-weight-bold"></span>
                    </div>

                    <div class="custom-control custom-checkbox mb-4">
                        <input type="checkbox" class="custom-control-input" id="runMigrationsCheck" checked>
                        <label class="custom-control-label font-weight-bold small" for="runMigrationsCheck">
                            {{ __('Execute schema migrations & pre-seed school calendar & reference data.') }}
                        </label>
                    </div>

                    <div class="d-flex justify-content-between pt-3 border-top">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="nextStep(2)">
                            <i class="fas fa-arrow-left mr-1"></i> {{ __('Back') }}
                        </button>
                        <button type="button" class="btn btn-primary rounded-pill px-4 font-weight-bold shadow-sm" id="btnSetupDb" onclick="saveAndMigrateDb()">
                            {{ __('Save & Next Step') }} <i class="fas fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </form>
            </section>

            <!-- =================================================================
                 STEP 4: INSTITUTION PROFILE & BRANDING
                 ================================================================= -->
            <section class="step-pane" id="paneStep4">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 pb-3 border-bottom">
                    <div>
                        <h3 class="h4 font-weight-bold mb-1">{{ __('Institution Profile & Branding') }}</h3>
                        <p class="text-muted small mb-0">{{ __('Personalize school name, official contact details, currency, and theme colors.') }}</p>
                    </div>
                </div>

                <form id="schoolProfileForm">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">{{ __('School / Institution Name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="brand_title" id="schoolName" class="form-control rounded-lg" value="{{ $customize->brand_title ?? 'Royal Academy of Phnom Penh' }}" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">{{ __('Official Email') }}</label>
                            <input type="email" name="school_email" id="schoolEmail" class="form-control rounded-lg" value="{{ $customize->school_email ?? 'info@schoolsystem.edu.kh' }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">{{ __('Contact Phone Number') }}</label>
                            <input type="text" name="school_phone" id="schoolPhone" class="form-control rounded-lg" value="{{ $customize->school_phone ?? '+855 12 801 470 / +855 71 220 6315' }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">{{ __('Default Currency') }}</label>
                            <select class="form-control rounded-lg" id="schoolCurrency">
                                <option value="USD" selected>USD ($) - United States Dollar</option>
                                <option value="KHR">KHR (៛) - Cambodian Riel</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="small font-weight-bold">{{ __('Campus Address') }}</label>
                        <input type="text" name="school_address" id="schoolAddress" class="form-control rounded-lg" value="{{ $customize->school_address ?? 'No.32, Street 606, Tuol Kork, Phnom Penh, Cambodia' }}">
                    </div>

                    <!-- Theme Accent Color Palette -->
                    <div class="form-group mb-4">
                        <label class="small font-weight-bold d-block">{{ __('System Accent Color') }}</label>
                        <input type="hidden" name="accent_color" id="schoolAccentColor" value="{{ $customize->accent_color ?? 'accent-indigo' }}">
                        <div class="d-flex align-items-center gap-2 mt-1">
                            <span class="theme-swatch active mr-2" data-color="accent-indigo" style="background: #6366f1;" title="Indigo"><i class="fas fa-check text-white small"></i></span>
                            <span class="theme-swatch mr-2" data-color="accent-emerald" style="background: #10b981;" title="Emerald"></span>
                            <span class="theme-swatch mr-2" data-color="accent-amber" style="background: #f59e0b;" title="Amber"></span>
                            <span class="theme-swatch mr-2" data-color="accent-sky" style="background: #0ea5e9;" title="Sky"></span>
                            <span class="theme-swatch mr-2" data-color="accent-purple" style="background: #8b5cf6;" title="Purple"></span>
                            <span class="theme-swatch" data-color="accent-crimson" style="background: #ef4444;" title="Crimson"></span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between pt-3 border-top">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="nextStep(3)">
                            <i class="fas fa-arrow-left mr-1"></i> {{ __('Back') }}
                        </button>
                        <button type="button" class="btn btn-primary rounded-pill px-4 font-weight-bold shadow-sm" id="btnSaveSchool" onclick="saveSchoolProfile()">
                            {{ __('Save Profile & Next') }} <i class="fas fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </form>
            </section>

            <!-- =================================================================
                 STEP 5: SUPER ADMINISTRATOR ACCOUNT
                 ================================================================= -->
            <section class="step-pane" id="paneStep5">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 pb-3 border-bottom">
                    <div>
                        <h3 class="h4 font-weight-bold mb-1">{{ __('Super Administrator Account') }}</h3>
                        <p class="text-muted small mb-0">{{ __('Create or update the primary administrator account used to manage this school.') }}</p>
                    </div>
                    @if ($existingAdmin)
                        <span class="badge badge-info px-3 py-2 rounded-pill font-weight-bold">
                            <i class="fas fa-user-shield mr-1"></i> {{ __('Admin Registered') }}: {{ $existingAdmin->email }}
                        </span>
                    @endif
                </div>

                <form id="adminAccountForm">
                    <div class="form-group">
                        <label class="small font-weight-bold">{{ __('Administrator Full Name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="adminName" class="form-control rounded-lg" value="{{ $existingAdmin->name ?? 'System Administrator' }}" required>
                    </div>

                    <div class="form-group">
                        <label class="small font-weight-bold">{{ __('Administrator Email / Login') }} <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="adminEmail" class="form-control rounded-lg" value="{{ $existingAdmin->email ?? 'admin@gmail.com' }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">{{ __('Password') }} <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" name="password" id="adminPassword" class="form-control rounded-left-lg" value="123456" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassVisibility('adminPassword')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">{{ __('Confirm Password') }} <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" name="password_confirmation" id="adminPasswordConfirm" class="form-control rounded-left-lg" value="123456" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassVisibility('adminPasswordConfirm')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between pt-3 border-top">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="nextStep(4)">
                            <i class="fas fa-arrow-left mr-1"></i> {{ __('Back') }}
                        </button>
                        <button type="button" class="btn btn-primary rounded-pill px-4 font-weight-bold shadow-sm" id="btnSaveAdmin" onclick="saveAdminAccount()">
                            {{ __('Configure Admin & Next') }} <i class="fas fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </form>
            </section>

            <!-- =================================================================
                 STEP 6: LAUNCH & FINALIZE
                 ================================================================= -->
            <section class="step-pane" id="paneStep6">
                <div class="text-center py-4">
                    <div class="d-inline-flex p-4 rounded-circle mb-3 shadow-lg" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <i class="fas fa-rocket fa-4x text-white"></i>
                    </div>
                    <h2 class="h3 font-weight-bold mb-2">{{ __('Installation & Setup Completed!') }}</h2>
                    <p class="text-muted max-w-lg mx-auto" style="max-width: 550px;">
                        {{ __('Your School Management System v2.0 is fully deployed, configured, and ready for production operations.') }}
                    </p>

                    <!-- Summary Checkbox Cards -->
                    <div class="row text-left my-4 max-w-xl mx-auto" style="max-width: 650px;">
                        <div class="col-md-6 mb-2">
                            <div class="diagnostic-card py-2 px-3 d-flex align-items-center">
                                <i class="fas fa-check-circle text-success mr-2 fa-lg"></i>
                                <span class="small font-weight-bold">{{ __('Environment Diagnostics: Passed') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="diagnostic-card py-2 px-3 d-flex align-items-center">
                                <i class="fas fa-check-circle text-success mr-2 fa-lg"></i>
                                <span class="small font-weight-bold">{{ __('Database Schema & Seeding: Done') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="diagnostic-card py-2 px-3 d-flex align-items-center">
                                <i class="fas fa-check-circle text-success mr-2 fa-lg"></i>
                                <span class="small font-weight-bold">{{ __('School Profile & Branding: Ready') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="diagnostic-card py-2 px-3 d-flex align-items-center">
                                <i class="fas fa-check-circle text-success mr-2 fa-lg"></i>
                                <span class="small font-weight-bold">{{ __('Super Admin Account: Active') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center flex-wrap gap-3 mt-4">
                        <a href="/login" class="btn btn-outline-secondary rounded-pill px-4 py-2 font-weight-bold">
                            <i class="fas fa-sign-in-alt mr-1"></i> {{ __('Go to Login Page') }}
                        </a>
                        <a href="/dashboard" class="btn btn-primary rounded-pill px-5 py-2 font-weight-bold shadow-sm" onclick="finalizeInstallation()">
                            <i class="fas fa-tachometer-alt mr-1"></i> {{ __('Launch Admin Dashboard') }}
                        </a>
                    </div>
                </div>
            </section>

        </div>
    </main>

    <!-- Footer -->
    <footer class="text-center py-3 text-muted small">
        &copy; {{ date('Y') }} {{ config('app.name', 'School MS') }} — {{ __('Crafted for High Performance & Bilingual SaaS Operations') }}.
    </footer>

    <!-- jQuery & Bootstrap 4 -->
    <script src="/assets/plugins/jquery/jquery.min.js"></script>
    <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Toastr -->
    <script src="/assets/plugins/toastr/toastr.min.js"></script>

    <script>
        var currentStep = 1;
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Theme management
        $('#themeToggleBtn').click(function () {
            var html = $('html');
            if (html.hasClass('dark-mode')) {
                html.removeClass('dark-mode');
                document.cookie = "theme=light-mode;path=/;max-age=" + (60*60*24*365);
                $('#themeIcon').removeClass('fa-sun').addClass('fa-moon');
            } else {
                html.addClass('dark-mode');
                document.cookie = "theme=dark-mode;path=/;max-age=" + (60*60*24*365);
                $('#themeIcon').removeClass('fa-moon').addClass('fa-sun');
            }
        });

        // Initialize Theme Icon
        if ($('html').hasClass('dark-mode')) {
            $('#themeIcon').removeClass('fa-moon').addClass('fa-sun');
        }

        // Stepper Navigation Functions
        function jumpToStep(step) {
            if (step > currentStep && step > 2) {
                // allow freely moving forward or back
            }
            goToStep(step);
        }

        function nextStep(step) {
            goToStep(step);
        }

        function goToStep(step) {
            $('.step-pane').removeClass('active');
            $('#paneStep' + step).addClass('active');

            $('.step-item').each(function () {
                var s = parseInt($(this).attr('data-step'), 10);
                if (s === step) {
                    $(this).addClass('active').removeClass('completed');
                } else if (s < step) {
                    $(this).addClass('completed').removeClass('active');
                } else {
                    $(this).removeClass('active completed');
                }
            });

            currentStep = step;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Database Driver Selector
        function selectDbDriver(driver) {
            $('.db-card-option').removeClass('active');
            $('.db-card-option[data-driver="' + driver + '"]').addClass('active');
            $('#selectedDbDriver').val(driver);

            if (driver === 'sqlite') {
                $('#sqliteDbFields').show();
                $('#remoteDbFields').hide();
            } else {
                $('#sqliteDbFields').hide();
                $('#remoteDbFields').show();
                if (driver === 'pgsql') {
                    $('#dbPort').val('5432');
                    $('#dbUsername').val('postgres');
                } else {
                    $('#dbPort').val('3306');
                    $('#dbUsername').val('root');
                }
            }
        }

        // Test Live Database Connection
        function testDbConnection() {
            var driver = $('#selectedDbDriver').val();
            var statusEl = $('#dbTestStatusText');
            statusEl.html('<i class="fas fa-spinner fa-spin text-info"></i> {{ __("Testing connectivity...") }}').removeClass('text-success text-danger');

            var payload = {
                driver: driver,
                host: $('#dbHost').val(),
                port: $('#dbPort').val(),
                database: (driver === 'sqlite') ? $('#dbSqlitePath').val() : $('#dbName').val(),
                username: $('#dbUsername').val(),
                password: $('#dbPassword').val()
            };

            $.ajax({
                url: '/install/test-db',
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                data: payload,
                success: function (res) {
                    statusEl.html('<i class="fas fa-check-circle text-success"></i> ' + (res.message || '{{ __("Connected successfully!") }}')).addClass('text-success');
                    toastr.success(res.message || '{{ __("Database connection successful!") }}');
                },
                error: function (xhr) {
                    var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : '{{ __("Connection error") }}';
                    statusEl.html('<i class="fas fa-times-circle text-danger"></i> ' + msg).addClass('text-danger');
                    toastr.error(msg);
                }
            });
        }

        // Save & Migrate Database
        function saveAndMigrateDb() {
            var btn = $('#btnSetupDb');
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> {{ __("Configuring & Migrating...") }}');

            var payload = {
                driver: $('#selectedDbDriver').val(),
                host: $('#dbHost').val(),
                port: $('#dbPort').val(),
                database: ($('#selectedDbDriver').val() === 'sqlite') ? $('#dbSqlitePath').val() : $('#dbName').val(),
                username: $('#dbUsername').val(),
                password: $('#dbPassword').val()
            };

            $.ajax({
                url: '/install/setup-db',
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                data: payload,
                success: function (res) {
                    btn.prop('disabled', false).html('{{ __("Save & Next Step") }} <i class="fas fa-arrow-right ml-1"></i>');
                    toastr.success(res.message || '{{ __("Database configured & migrated successfully.") }}');
                    nextStep(4);
                },
                error: function (xhr) {
                    btn.prop('disabled', false).html('{{ __("Save & Next Step") }} <i class="fas fa-arrow-right ml-1"></i>');
                    var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : '{{ __("Failed to migrate database.") }}';
                    toastr.error(msg);
                }
            });
        }

        // Accent Color Selection
        $('.theme-swatch').click(function () {
            $('.theme-swatch').removeClass('active').html('');
            $(this).addClass('active').html('<i class="fas fa-check text-white small"></i>');
            $('#schoolAccentColor').val($(this).attr('data-color'));
        });

        // Save School Profile
        function saveSchoolProfile() {
            var btn = $('#btnSaveSchool');
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> {{ __("Saving...") }}');

            var payload = {
                brand_title: $('#schoolName').val(),
                school_email: $('#schoolEmail').val(),
                school_phone: $('#schoolPhone').val(),
                school_address: $('#schoolAddress').val(),
                accent_color: $('#schoolAccentColor').val()
            };

            $.ajax({
                url: '/install/save-school',
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                data: payload,
                success: function (res) {
                    btn.prop('disabled', false).html('{{ __("Save Profile & Next") }} <i class="fas fa-arrow-right ml-1"></i>');
                    toastr.success(res.message || '{{ __("School profile saved successfully.") }}');
                    nextStep(5);
                },
                error: function (xhr) {
                    btn.prop('disabled', false).html('{{ __("Save Profile & Next") }} <i class="fas fa-arrow-right ml-1"></i>');
                    var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : '{{ __("Failed to save school profile.") }}';
                    toastr.error(msg);
                }
            });
        }

        // Toggle Password Visibility
        function togglePassVisibility(inputId) {
            var input = document.getElementById(inputId);
            input.type = (input.type === 'password') ? 'text' : 'password';
        }

        // Save Super Admin
        function saveAdminAccount() {
            var btn = $('#btnSaveAdmin');
            var pass = $('#adminPassword').val();
            var confirmPass = $('#adminPasswordConfirm').val();

            if (pass !== confirmPass) {
                toastr.error('{{ __("Passwords do not match!") }}');
                return;
            }

            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> {{ __("Configuring...") }}');

            var payload = {
                name: $('#adminName').val(),
                email: $('#adminEmail').val(),
                password: pass,
                password_confirmation: confirmPass
            };

            $.ajax({
                url: '/install/create-admin',
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                data: payload,
                success: function (res) {
                    btn.prop('disabled', false).html('{{ __("Configure Admin & Next") }} <i class="fas fa-arrow-right ml-1"></i>');
                    toastr.success(res.message || '{{ __("Admin account created successfully.") }}');
                    nextStep(6);
                },
                error: function (xhr) {
                    btn.prop('disabled', false).html('{{ __("Configure Admin & Next") }} <i class="fas fa-arrow-right ml-1"></i>');
                    var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : '{{ __("Failed to configure admin account.") }}';
                    toastr.error(msg);
                }
            });
        }

        // Finalize Installation
        function finalizeInstallation() {
            $.ajax({
                url: '/install/finalize',
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken }
            });
        }

        // Initial check for active driver
        $(document).ready(function () {
            var curDriver = "{{ DB::getDriverName() ?: 'sqlite' }}";
            selectDbDriver(curDriver);
        });
    </script>
</body>
</html>

