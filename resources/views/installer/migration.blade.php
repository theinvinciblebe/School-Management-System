<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="{{ (request()->cookie('theme') === 'dark-mode' || (!request()->cookie('theme') && false)) ? 'dark-mode' : '' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Database Operations Console') }} | {{ config('app.name', 'School MS') }}</title>

    <!-- Google Font: Inter & Kantumruy Pro for Khmer -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;600&family=Inter:wght@400;500;600;700;800&family=Kantumruy+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">

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
            --terminal-bg: #0b1120;
            --terminal-header: #1e293b;
            --terminal-text: #e2e8f0;
        }

        html.dark-mode {
            --brand-surface: #1e293b;
            --brand-bg: #0f172a;
            --brand-text: #f8fafc;
            --brand-muted: #94a3b8;
            --brand-border: #334155;
            --terminal-bg: #030712;
            --terminal-header: #111827;
            --terminal-text: #f3f4f6;
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
            opacity: 0.25;
            animation: orbFloat 18s ease-in-out infinite alternate;
        }
        .mesh-orb-1 { width: 550px; height: 550px; background: #6366f1; top: -120px; left: -100px; }
        .mesh-orb-2 { width: 500px; height: 500px; background: #10b981; bottom: -100px; right: -80px; animation-duration: 22s; }
        .mesh-orb-3 { width: 350px; height: 350px; background: #06b6d4; top: 40%; left: 50%; transform: translate(-50%, -50%); opacity: 0.15; }

        @keyframes orbFloat {
            0% { transform: translateY(0) scale(1); }
            100% { transform: translateY(50px) scale(1.08); }
        }

        /* Header */
        .console-navbar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--brand-border);
            position: sticky;
            top: 0;
            z-index: 100;
            transition: background-color 0.3s ease;
        }
        html.dark-mode .console-navbar {
            background: rgba(30, 41, 59, 0.85);
        }

        .console-card {
            background: var(--brand-surface);
            border: 1px solid var(--brand-border);
            border-radius: 1.25rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.03);
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        /* Terminal Window */
        .terminal-box {
            background-color: var(--terminal-bg);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
        }
        .terminal-header {
            background-color: var(--terminal-header);
            padding: 0.75rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .terminal-dots {
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        .terminal-dot {
            width: 0.75rem;
            height: 0.75rem;
            border-radius: 50%;
            display: inline-block;
        }
        .dot-red { background: #ef4444; }
        .dot-yellow { background: #f59e0b; }
        .dot-green { background: #10b981; }

        .terminal-title {
            color: #94a3b8;
            font-size: 0.82rem;
            font-family: 'Fira Code', monospace;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .terminal-body {
            padding: 1.25rem 1.5rem;
            color: var(--terminal-text);
            font-family: 'Fira Code', Menlo, Monaco, Consolas, monospace;
            font-size: 0.86rem;
            line-height: 1.6;
            max-height: 480px;
            overflow-y: auto;
            white-space: pre-wrap;
            word-break: break-all;
        }

        /* Custom Scrollbar for Terminal */
        .terminal-body::-webkit-scrollbar {
            width: 8px;
        }
        .terminal-body::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.03);
        }
        .terminal-body::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.18);
            border-radius: 4px;
        }
        .terminal-body::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .badge-driver {
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            padding: 0.35rem 0.65rem;
            border-radius: 0.5rem;
            letter-spacing: 0.05em;
        }
        .driver-pgsql { background-color: #336791; color: #ffffff; }
        .driver-mysql { background-color: #00758f; color: #ffffff; }
        .driver-sqlite { background-color: #003b57; color: #ffffff; }

        .action-btn {
            border-radius: 0.75rem;
            font-weight: 600;
            padding: 0.6rem 1.2rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
        }
        .action-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        }

        .theme-toggle-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--brand-border);
            background: var(--brand-surface);
            color: var(--brand-text);
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .theme-toggle-btn:hover {
            background: var(--brand-border);
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

    <!-- Navigation Header -->
    <header class="console-navbar py-3">
        <div class="container-fluid px-lg-5 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <div class="bg-primary text-white rounded-xl d-flex align-items-center justify-content-center shadow-sm mr-3" style="width: 44px; height: 44px; border-radius: 12px;">
                    <i class="fas fa-database fa-lg"></i>
                </div>
                <div>
                    <h5 class="font-weight-bold mb-0" style="letter-spacing: -0.02em;">
                        {{ __('Database Operations Console') }}
                    </h5>
                    <small class="text-muted">{{ __('Migration & Seeding Tool') }}</small>
                </div>
            </div>

            <div class="d-flex align-items-center" style="gap: 0.75rem;">
                <!-- Language Switcher -->
                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle rounded-pill px-3" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-globe mr-1"></i>
                        {{ app()->getLocale() === 'km' ? 'ភាសាខ្មែរ' : 'English' }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right shadow-sm border-0 rounded-xl">
                        <a class="dropdown-item d-flex align-items-center py-2" href="{{ route('lang.switch', ['locale' => 'km']) }}">
                            <span class="mr-2">🇰🇭</span> ភាសាខ្មែរ (Khmer)
                        </a>
                        <a class="dropdown-item d-flex align-items-center py-2" href="{{ route('lang.switch', ['locale' => 'en']) }}">
                            <span class="mr-2">🇺🇸</span> English
                        </a>
                    </div>
                </div>

                <!-- Dark Mode Toggle -->
                <button type="button" class="theme-toggle-btn" id="themeToggleBtn" title="Toggle Theme">
                    <i class="fas fa-moon" id="themeIcon"></i>
                </button>

                <!-- Navigation Links -->
                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 font-weight-bold">
                    <i class="fas fa-sign-in-alt mr-1"></i> {{ __('Login') }}
                </a>
                <a href="{{ route('install.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 font-weight-bold">
                    <i class="fas fa-magic mr-1"></i> {{ __('Installation Wizard') }}
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="container-fluid px-lg-5 py-4 flex-grow-1">

        <!-- Serverless Info Banner -->
        @if (!empty($dbInfo['isServerless']))
            <div class="alert alert-info border-0 rounded-xl py-3 px-4 mb-4 d-flex align-items-center shadow-sm">
                <i class="fas fa-cloud text-primary mr-3 fa-2x"></i>
                <div class="flex-grow-1">
                    <strong class="d-block mb-1">{{ __('Vercel Serverless Architecture') }}</strong>
                    <span class="small">
                        {{ __('Notice: For serverless deployments (such as Vercel), this web route allows running artisan migrations and seeders without SSH terminal access.') }}
                    </span>
                </div>
            </div>
        @endif

        <!-- Database Info Card -->
        <div class="console-card p-4 mb-4">
            <div class="row align-items-center">
                <div class="col-md-7 mb-3 mb-md-0">
                    <div class="d-flex align-items-center flex-wrap" style="gap: 0.75rem;">
                        <span class="badge-driver driver-{{ $dbInfo['driver'] }}">
                            <i class="fas fa-server mr-1"></i> {{ $dbInfo['driver'] }}
                        </span>
                        <h5 class="font-weight-bold mb-0 text-dark dark:text-white">
                            {{ $dbInfo['database'] }}
                        </h5>
                        <span class="badge badge-pill badge-light border text-muted">
                            <i class="fas fa-network-wired mr-1"></i> {{ $dbInfo['host'] }}:{{ $dbInfo['port'] }}
                        </span>
                        <span class="badge badge-pill badge-secondary">
                            {{ $dbInfo['environment'] }}
                        </span>
                    </div>
                    <div class="small text-muted mt-2">
                        <i class="fas fa-info-circle mr-1"></i>
                        {{ __('Database Connection') }}: <code>{{ $dbInfo['driver'] }}://{{ $dbInfo['username'] ?: 'default' }}@{{ $dbInfo['host'] }}/{{ $dbInfo['database'] }}</code>
                    </div>
                </div>

                <div class="col-md-5 text-md-right">
                    @if ($duration !== null)
                        <div class="d-inline-flex align-items-center bg-light dark:bg-dark py-2 px-3 rounded-lg border">
                            <i class="fas fa-stopwatch text-primary mr-2"></i>
                            <span class="small font-weight-bold mr-1">{{ __('Execution Duration') }}:</span>
                            <span class="badge badge-pill badge-info font-weight-bold">{{ $duration }}s</span>
                        </div>
                    @endif
                </div>
            </div>

            <hr class="my-3" style="border-color: var(--brand-border);">

            <!-- Action Buttons Toolbar -->
            <div class="d-flex flex-wrap align-items-center justify-content-between" style="gap: 0.5rem;">
                <div class="d-flex flex-wrap align-items-center" style="gap: 0.5rem;">
                    <!-- 1. Migrate & Seed (Combined) -->
                    <a href="{{ route('system.migrate-seed') }}" class="btn btn-primary action-btn shadow-sm" onclick="showLoading('{{ __('Migrate & Seed') }}')">
                        <i class="fas fa-bolt"></i> {{ __('Migrate & Seed') }}
                    </a>

                    <!-- 2. Run Migrations -->
                    <a href="{{ route('system.migrate') }}" class="btn btn-success action-btn shadow-sm" onclick="showLoading('{{ __('Run Migrations') }}')">
                        <i class="fas fa-hammer"></i> {{ __('Run Migrations') }}
                    </a>

                    <!-- 3. Run Seeders -->
                    <a href="{{ route('system.seed') }}" class="btn btn-info action-btn shadow-sm" onclick="showLoading('{{ __('Run Seeders') }}')">
                        <i class="fas fa-seedling"></i> {{ __('Run Seeders') }}
                    </a>

                    <!-- 4. Check Status -->
                    <a href="{{ route('system.migrate-status') }}" class="btn btn-outline-secondary action-btn" onclick="showLoading('{{ __('Migration Status') }}')">
                        <i class="fas fa-list-check"></i> {{ __('Migration Status') }}
                    </a>
                </div>

                <div class="d-flex align-items-center" style="gap: 0.5rem;">
                    <!-- 5. Fresh Migration (Destructive) -->
                    <button type="button" class="btn btn-outline-danger action-btn" data-toggle="modal" data-target="#freshModal">
                        <i class="fas fa-trash-alt"></i> {{ __('Fresh Migration & Seed') }}
                    </button>

                    <!-- Console Reset -->
                    <a href="{{ route('system.migrate-console') }}" class="btn btn-light border action-btn" title="{{ __('Clear Output') }}">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Operation Status Alert -->
        @if ($action !== 'console')
            <div class="alert {{ $success ? 'alert-success' : 'alert-danger' }} border-0 rounded-xl py-3 px-4 mb-4 d-flex align-items-center shadow-sm">
                <i class="fas {{ $success ? 'fa-check-circle' : 'fa-exclamation-triangle' }} fa-2x mr-3"></i>
                <div class="flex-grow-1">
                    <strong class="d-block font-weight-bold mb-1" style="font-size: 1.05rem;">
                        {{ $success ? __('Success') : __('Failed') }}
                    </strong>
                    <span>{{ $message }}</span>
                </div>
                @if ($duration !== null)
                    <div class="badge badge-pill {{ $success ? 'badge-light' : 'badge-dark' }} px-3 py-2">
                        <i class="fas fa-clock mr-1"></i> {{ $duration }}s
                    </div>
                @endif
            </div>
        @endif

        <!-- Terminal Output Box -->
        <div class="terminal-box">
            <div class="terminal-header">
                <div class="d-flex align-items-center" style="gap: 0.75rem;">
                    <div class="terminal-dots">
                        <span class="terminal-dot dot-red"></span>
                        <span class="terminal-dot dot-yellow"></span>
                        <span class="terminal-dot dot-green"></span>
                    </div>
                    <div class="terminal-title">
                        <i class="fas fa-terminal"></i>
                        <span>artisan {{ $action === 'console' ? 'ready' : $action }}</span>
                    </div>
                </div>

                <div class="d-flex align-items-center" style="gap: 0.5rem;">
                    <button type="button" class="btn btn-sm btn-dark text-muted border-0 py-1 px-3 rounded-pill" id="copyBtn" onclick="copyTerminalOutput()">
                        <i class="far fa-copy mr-1"></i> <span id="copyBtnText">{{ __('Copy Output') }}</span>
                    </button>
                </div>
            </div>

            <pre class="terminal-body mb-0" id="terminalOutput">{{ $output ?: __('No console output available. Select an action above to execute.') }}</pre>
        </div>

    </main>

    <!-- Confirmation Modal for Fresh Migration -->
    <div class="modal fade" id="freshModal" tabindex="-1" role="dialog" aria-labelledby="freshModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 rounded-xl shadow-lg">
                <div class="modal-header bg-danger text-white border-0 py-3 px-4" style="border-radius: 1rem 1rem 0 0;">
                    <h5 class="modal-title font-weight-bold" id="freshModalLabel">
                        <i class="fas fa-exclamation-triangle mr-2"></i> {{ __('Confirm Fresh Migration') }}
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4 text-dark dark:text-white">
                    <p class="font-weight-bold mb-2 text-danger">
                        {{ __('Are you sure you want to drop all tables and re-seed the database? All existing data will be lost!') }}
                    </p>
                    <p class="small text-muted mb-0">
                        {{ __('This command runs: php artisan migrate:fresh --seed --force') }}
                    </p>
                </div>
                <div class="modal-footer border-0 p-3 bg-light dark:bg-dark" style="border-radius: 0 0 1rem 1rem;">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <a href="{{ route('system.migrate-fresh', ['confirm' => 'yes']) }}" class="btn btn-danger rounded-pill px-4 font-weight-bold" onclick="showLoading('{{ __('Fresh Migration & Seed') }}')">
                        <i class="fas fa-trash-alt mr-1"></i> {{ __('Confirm Fresh Migration') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Modal -->
    <div class="modal fade" id="loadingModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content border-0 rounded-xl p-4 text-center shadow-lg" style="background: var(--brand-surface);">
                <div class="spinner-border text-primary mb-3" style="width: 3.5rem; height: 3.5rem;" role="status">
                    <span class="sr-only">{{ __('Loading...') }}</span>
                </div>
                <h6 class="font-weight-bold mb-1" id="loadingActionTitle">{{ __('Running operation...') }}</h6>
                <small class="text-muted">{{ __('Please wait while the database operation executes. Do not close this page.') }}</small>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="/assets/plugins/jquery/jquery.min.js"></script>
    <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/plugins/toastr/toastr.min.js"></script>

    <script>
        // Theme Toggle Functionality
        const themeToggleBtn = document.getElementById('themeToggleBtn');
        const themeIcon = document.getElementById('themeIcon');
        const htmlElement = document.documentElement;

        function updateThemeIcon() {
            if (htmlElement.classList.contains('dark-mode')) {
                themeIcon.className = 'fas fa-sun text-warning';
            } else {
                themeIcon.className = 'fas fa-moon';
            }
        }
        updateThemeIcon();

        themeToggleBtn.addEventListener('click', function() {
            htmlElement.classList.toggle('dark-mode');
            const isDark = htmlElement.classList.contains('dark-mode');
            document.cookie = "theme=" + (isDark ? "dark-mode" : "light-mode") + "; path=/; max-age=" + (60*60*24*365);
            updateThemeIcon();
        });

        // Copy Terminal Output
        function copyTerminalOutput() {
            const outputText = document.getElementById('terminalOutput').innerText;
            navigator.clipboard.writeText(outputText).then(() => {
                const btnText = document.getElementById('copyBtnText');
                const orig = btnText.innerText;
                btnText.innerText = "{{ __('Copied!') }}";
                toastr.success("{{ __('Copied to clipboard!') }}");
                setTimeout(() => { btnText.innerText = orig; }, 2000);
            }).catch(err => {
                toastr.error("{{ __('Failed to copy to clipboard.') }}");
            });
        }

        // Show Loading Modal on action click
        function showLoading(actionName) {
            document.getElementById('loadingActionTitle').innerText = actionName;
            $('#loadingModal').modal('show');
        }
    </script>
</body>
</html>
