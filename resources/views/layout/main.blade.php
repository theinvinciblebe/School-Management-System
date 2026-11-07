@php
    $themeCookie = request()->cookie('theme') ?? ($_COOKIE['theme'] ?? null);
    $isDark = ($themeCookie === 'dark-mode');
    $sidebarCookie = request()->cookie('sidebar_collapsed') ?? ($_COOKIE['sidebar_collapsed'] ?? null);
    $isSidebarCollapsed = ($sidebarCookie === '1');
    $compactCookie = request()->cookie('pc_compact_mode') ?? ($_COOKIE['pc_compact_mode'] ?? null);
    $isCompactMode = ($compactCookie === '1');
@endphp
@include("layout.head")

<body id="mainBody" class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed {{ $isDark ? 'dark-mode' : '' }} {{ $isSidebarCollapsed ? 'sidebar-collapse' : '' }} {{ $isCompactMode ? 'pc-compact-mode' : '' }} {{ $customizes->accent_color ?? '' }} {{ app()->getLocale() === 'km' ? 'lang-km' : '' }}" style="{{ $isDark ? 'background-color: #232323 !important;' : '' }}; height: auto;">
<script>
    (function () {
        try {
            var theme = localStorage.getItem('theme');
            if (!theme) {
                var m = document.cookie.match(/(?:^|; )theme=([^;]*)/);
                if (m) theme = m[1];
            }
            var isDark = theme === 'dark-mode' || (!theme && window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches);
            var b = document.getElementById('mainBody');
            if (isDark) {
                document.documentElement.classList.add('dark-mode');
                document.documentElement.style.backgroundColor = '#232323';
                document.documentElement.style.colorScheme = 'dark';
                if (b) {
                    b.classList.add('dark-mode');
                    b.classList.remove('light-mode');
                    b.style.backgroundColor = '#232323';
                }
            } else if (theme === 'light-mode') {
                document.documentElement.classList.remove('dark-mode');
                document.documentElement.style.backgroundColor = '';
                document.documentElement.style.colorScheme = 'light';
                if (b) {
                    b.classList.remove('dark-mode');
                    b.classList.add('light-mode');
                    b.style.backgroundColor = '';
                }
            }

            // Apply PC Sidebar Collapse preference (strictly for Desktop >= 992px)
            var sidebarCollapsed = localStorage.getItem('sidebar_collapsed');
            if (b) {
                if (window.innerWidth < 992) {
                    b.classList.remove('sidebar-collapse');
                    document.documentElement.classList.remove('sidebar-collapse', 'sidebar-is-collapsed');
                } else {
                    if (sidebarCollapsed === '1') {
                        b.classList.add('sidebar-collapse');
                    } else if (sidebarCollapsed === '0') {
                        b.classList.remove('sidebar-collapse');
                    }
                }
            }

            // Apply PC Compact Mode preference
            var compactMode = localStorage.getItem('pc_compact_mode');
            if (b) {
                if (compactMode === '1') {
                    b.classList.add('pc-compact-mode');
                } else if (compactMode === '0') {
                    b.classList.remove('pc-compact-mode');
                }
            }
        } catch(e) {}
    })();
</script>

<div class="wrapper">
    <!-- System Preloader: Runs on Fresh Start of System, suppressed during internal route changes -->
    @php
        $brandLogoFile = $customizes->brand_logo ?? null;
        $preloaderLogo = (!empty($brandLogoFile) && file_exists(public_path('customize_images/' . $brandLogoFile)))
            ? asset('customize_images/' . $brandLogoFile)
            : (!empty($brandLogoFile) ? asset('customize_images/' . $brandLogoFile) : asset('assets/dist/img/mawaridLogo.jpg'));
    @endphp
    <div id="systemPreloader" class="system-preloader flex-column justify-content-center align-items-center" style="{{ $isDark ? 'background-color: #232323 !important;' : '' }}">
        <img class="img-circle elevation-3 preloader-brand-img animation__wobble"
             src="{{ $preloaderLogo }}"
             alt="{{ $customizes->brand_title ?? 'Brand Logo' }}"
             height="120"
             width="120">
    </div>
    <script>
        (function() {
            try {
                // If moving between routes internally, immediately remove preloader so it never flashes
                if (sessionStorage.getItem('is_route_navigating') === '1') {
                    var p = document.getElementById('systemPreloader');
                    if (p) {
                        p.style.display = 'none';
                        p.remove();
                    }
                }
            } catch(e) {}
        })();
    </script>

    <!-- Navbar -->
    <nav id="mainNav" class="main-header navbar navbar-expand navbar-dark {{ $customizes->nav_color ?? '' }}">
        <!-- Left navbar links -->
        <ul class="navbar-nav align-items-center">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button" title="{{ __('Toggle Sidebar (Alt + S)') }}"><i class="fas fa-bars"></i></a>
            </li>

            <!-- PC Desktop Quick Command & Search -->
            @include('components.navbar.pc-quick-search')
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto align-items-center">
            <!-- PC Compact Table Density Toggle -->
            @include('components.navbar.pc-density-toggle')

            <!-- PC Keyboard Shortcuts Helper Button -->
            @include('components.navbar.pc-shortcuts-btn')

            <!-- Dark / Light Mode Toggle -->
            @include('components.navbar.theme-toggle')

            <!-- Language Switcher Dropdown -->
            @include('components.navbar.language-switch')

            <!-- Notifications Dropdown Menu -->
            @include('components.navbar.notifications')

            <!-- User Profile & Quick Logout in Top Navbar -->
            @include('components.navbar.user-menu')
        </ul>
    </nav>
    <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar {{ $customizes->dark_sidebar_variants ?? 'sidebar-dark-primary' }} elevation-4 {{ $customizes->sidebar_color ?? 'bg-dark' }} modern-main-sidebar sidebar-no-expand">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link modern-brand-header">
      <div class="modern-brand-logo">
        <img src="{{ asset('customize_images/' . ($customizes->brand_logo ?? 'noimg.jpg')) }}" alt="Brand Logo" class="brand-image img-circle">
      </div>
      <div class="modern-brand-details">
        <span class="brand-text modern-brand-title">{{ $customizes->brand_title ?? 'School MS' }}</span>
        <span class="modern-brand-pill">{{ __('v2.0') }}</span>
      </div>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      @php
          $authUser = Auth::user();
          $userRole = $authUser->role ?? null;
          $roleTitle = match((int)$userRole) {
              0 => __('Administrator'),
              1 => __('Teacher'),
              2 => __('Student'),
              3 => __('Accountant'),
              4 => __('Receptionist'),
              default => __('User'),
          };
          $roleBadgeClass = match((int)$userRole) {
              0 => 'role-admin',
              1 => 'role-teacher',
              2 => 'role-student',
              3 => 'role-accountant',
              4 => 'role-reception',
              default => 'role-default',
          };
      @endphp

      <!-- Modern Floating User Profile Card -->
      <a href="{{ route('user.profile') }}" class="modern-user-card" id="user-panel" title="{{ __('View Profile') }}">
        <div class="modern-user-avatar-wrap">
          <img id="profilePhoto" src="{{ $authUser->photo_url ?? asset('noimg.jpg') }}"
               class="modern-user-avatar"
               alt="{{ $authUser->name ?? 'User' }}">
          <span class="modern-avatar-status" title="{{ __('Online') }}"></span>
        </div>
        <div class="modern-user-info">
          <div class="modern-user-name" title="{{ $authUser->name ?? '' }}">
            {{ $authUser->name ?? __('User') }}
          </div>
          <div class="modern-user-role-wrap">
            <span class="modern-user-role-badge {{ $roleBadgeClass }}">
              {{ (strcasecmp($authUser->name ?? '', $roleTitle) === 0 && (int)$userRole === 0) ? __('Super Admin') : $roleTitle }}
            </span>
          </div>
        </div>
        <div class="modern-user-arrow">
          <i class="fas fa-chevron-right"></i>
        </div>
      </a>

      <!-- Modern Smart Sidebar Search Form -->
      <div class="modern-sidebar-search-container" id="smartSidebarSearchContainer">
        <div class="modern-search-pill" id="smartSidebarSearchWrapper">
          <span class="modern-search-prefix">
            <i class="fas fa-search" id="smartSearchIcon"></i>
          </span>
          <input class="modern-search-input" 
                 id="smartSidebarSearchInput"
                 type="text" 
                 placeholder="{{ __('Filter menus (/)...') }}" 
                 aria-label="{{ __('Filter navigation') }}"
                 spellcheck="false"
                 autocomplete="off">
          <div class="modern-search-actions">
            <span class="badge smart-search-count-badge d-none" id="smartSearchCount">0</span>
            <button class="btn modern-search-clear-btn d-none" id="smartSearchClearBtn" type="button" aria-label="{{ __('Clear') }}" title="{{ __('Clear search (Esc)') }}">
              <i class="fas fa-times"></i>
            </button>
            <!-- <span class="modern-search-kbd" onclick="if(window.openPcCommandPalette){ window.openPcCommandPalette(); }" title="{{ __('Command Palette (Ctrl + K)') }}">
              <kbd>Ctrl K</kbd>
            </span> -->
          </div>
        </div>
        <div id="smartSearchEmpty" class="smart-search-empty d-none">
          <i class="fas fa-search-minus mr-1"></i>
          <span>{{ __('No matching menus found') }}</span>
          <div class="smart-search-empty-hint">{{ __('Press Esc to reset') }}</div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      @includeWhen(Auth::check() && Auth::user()->role === 0, 'components.sidebar.admin')
      @includeWhen(Auth::check() && Auth::user()->role === 1, 'components.sidebar.teacher')
      @includeWhen(Auth::check() && Auth::user()->role === 2, 'components.sidebar.student')
      @includeWhen(Auth::check() && Auth::user()->role === 3, 'components.sidebar.accountant')
      @includeWhen(Auth::check() && Auth::user()->role === 4, 'components.sidebar.reception')

    </div>
    <!-- /.sidebar -->
    <script>
      (function() {
        try {
          var y = sessionStorage.getItem('adminlte_sidebar_scroll_pos');
          if (y) {
            var sb = document.querySelector('.main-sidebar .sidebar');
            if (sb) sb.scrollTop = parseInt(y, 10);
          }
        } catch(e) {}
      })();
    </script>
  </aside>

  <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper {{ $isDark ? 'dark-mode' : '' }}" id="contentWrapper" style="{{ $isDark ? 'background-color: #232323 !important;' : '' }}">
        <div class="overlay-wrapper" id="mainOverlayWrapper">
            <!-- Main Content Section -->
            <section class="content pb-4">
                <div class="container-fluid">
                    @yield('content')

                    <!-- Include Global Toastr Notifications -->
                    @include('layout.toastr')
                </div><!-- /.container-fluid -->
            </section><!-- /.content -->
        </div><!-- /.overlay-wrapper -->
    </div><!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

    <!-- PC Desktop Efficiency Components -->
    @include('components.pc-command-palette')
    @include('components.pc-shortcuts-modal')

</div>
<!-- ./wrapper -->

<script>
    (function () {
        function updateThemeUI(isDark) {
            const body = document.getElementById('mainBody');
            const contentWrapper = document.getElementById('contentWrapper');
            const themeSwitch = document.getElementById('themeSwitch');
            const navbarThemeToggle = document.getElementById('navbarThemeToggle');

            if (isDark) {
                document.documentElement.classList.add('dark-mode');
                document.documentElement.style.backgroundColor = '#232323';
                document.documentElement.style.colorScheme = 'dark';
                if (body) {
                    body.classList.remove('light-mode');
                    body.classList.add('dark-mode');
                    body.style.backgroundColor = '#232323';
                }
                if (contentWrapper) {
                    contentWrapper.classList.remove('light-mode');
                    contentWrapper.classList.add('dark-mode');
                    contentWrapper.style.backgroundColor = '#232323';
                }
                document.querySelectorAll('input[name="theme-switch"]').forEach(function (el) { el.checked = true; });
                if (navbarThemeToggle) {
                    navbarThemeToggle.classList.add('is-dark');
                    navbarThemeToggle.classList.remove('is-light');
                    navbarThemeToggle.setAttribute('title', '{{ __("Switch to light theme") }}');
                    navbarThemeToggle.setAttribute('aria-label', '{{ __("Switch to light theme") }}');
                    navbarThemeToggle.setAttribute('aria-pressed', 'true');
                    const sun = navbarThemeToggle.querySelector('.lucide-sun');
                    const moon = navbarThemeToggle.querySelector('.lucide-moon');
                    if (sun) {
                        sun.classList.remove('rotate-0', 'scale-100', 'opacity-100');
                        sun.classList.add('-rotate-90', 'scale-0', 'opacity-0');
                    }
                    if (moon) {
                        moon.classList.remove('rotate-90', 'scale-0', 'opacity-0');
                        moon.classList.add('rotate-0', 'scale-100', 'opacity-100');
                    }
                }
                document.querySelectorAll('.theme-icon-sun').forEach(function (el) { el.classList.add('d-none'); });
                document.querySelectorAll('.theme-icon-moon').forEach(function (el) { el.classList.remove('d-none'); });
                document.querySelectorAll('#themeLabelText').forEach(function (el) { el.textContent = '{{ __("Dark Mode") }}'; });
            } else {
                document.documentElement.classList.remove('dark-mode');
                document.documentElement.style.backgroundColor = '';
                document.documentElement.style.colorScheme = 'light';
                if (body) {
                    body.classList.remove('dark-mode');
                    body.classList.add('light-mode');
                    body.style.backgroundColor = '';
                }
                if (contentWrapper) {
                    contentWrapper.classList.remove('dark-mode');
                    contentWrapper.classList.add('light-mode');
                    contentWrapper.style.backgroundColor = '';
                }
                document.querySelectorAll('input[name="theme-switch"]').forEach(function (el) { el.checked = false; });
                if (navbarThemeToggle) {
                    navbarThemeToggle.classList.remove('is-dark');
                    navbarThemeToggle.classList.add('is-light');
                    navbarThemeToggle.setAttribute('title', '{{ __("Switch to dark theme") }}');
                    navbarThemeToggle.setAttribute('aria-label', '{{ __("Switch to dark theme") }}');
                    navbarThemeToggle.setAttribute('aria-pressed', 'false');
                    const sun = navbarThemeToggle.querySelector('.lucide-sun');
                    const moon = navbarThemeToggle.querySelector('.lucide-moon');
                    if (sun) {
                        sun.classList.remove('-rotate-90', 'scale-0', 'opacity-0');
                        sun.classList.add('rotate-0', 'scale-100', 'opacity-100');
                    }
                    if (moon) {
                        moon.classList.remove('rotate-0', 'scale-100', 'opacity-100');
                        moon.classList.add('rotate-90', 'scale-0', 'opacity-0');
                    }
                }
                document.querySelectorAll('.theme-icon-sun').forEach(function (el) { el.classList.remove('d-none'); });
                document.querySelectorAll('.theme-icon-moon').forEach(function (el) { el.classList.add('d-none'); });
                document.querySelectorAll('#themeLabelText').forEach(function (el) { el.textContent = '{{ __("Light Mode") }}'; });
            }
        }

        function toggleTheme(enableDark) {
            const body = document.getElementById('mainBody');
            if (body) body.classList.add('theme-transitioning');

            updateThemeUI(enableDark);
            try {
                localStorage.setItem('theme', enableDark ? 'dark-mode' : 'light-mode');
                document.cookie = "theme=" + (enableDark ? "dark-mode" : "light-mode") + "; path=/; max-age=31536000; SameSite=Lax";
            } catch(e) {}

            // Dispatch event for charts (dashboard) and listeners
            const themeSwitch = document.getElementById('themeSwitch');
            if (themeSwitch) {
                themeSwitch.dispatchEvent(new Event('change'));
            }
            window.dispatchEvent(new CustomEvent('themeChanged', { detail: { isDark: enableDark } }));

            setTimeout(() => {
                if (body) body.classList.remove('theme-transitioning');
            }, 350);
        }
        window.toggleTheme = toggleTheme;

        const savedTheme = localStorage.getItem('theme');
        const isDark = savedTheme === 'dark-mode' || (!savedTheme && document.documentElement.classList.contains('dark-mode'));

        document.addEventListener('DOMContentLoaded', function () {
            updateThemeUI(isDark);

            const themeSwitch = document.getElementById('themeSwitch');
            const wrapper = document.getElementById('themeToggleWrapper');
            const navbarThemeToggle = document.getElementById('navbarThemeToggle');

            if (navbarThemeToggle) {
                navbarThemeToggle.addEventListener('click', function (e) {
                    e.preventDefault();
                    const willBeDark = !document.documentElement.classList.contains('dark-mode');
                    toggleTheme(willBeDark);
                });
            }

            document.querySelectorAll('input[name="theme-switch"]').forEach(function (sw) {
                sw.addEventListener('change', function () {
                    toggleTheme(this.checked);
                });
            });

            document.querySelectorAll('.theme-mode-wrapper').forEach(function (wrap) {
                wrap.addEventListener('click', function (e) {
                    if (e.target.closest('.modern-theme-switch')) return;
                    const willBeDark = !document.documentElement.classList.contains('dark-mode');
                    toggleTheme(willBeDark);
                });

                wrap.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        const willBeDark = !document.documentElement.classList.contains('dark-mode');
                        toggleTheme(willBeDark);
                    }
                });
            });
        });
    })();
</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        fetch("{{ route('profile.getPhoto') }}") // Fetch JSON response
            .then(response => response.json())
            .then(data => {
                if (data.photo) {
                    document.getElementById("profilePhoto").src = data.photo;
                }
            })
            .catch(error => console.error("Error loading profile photo:", error));
    });
</script>

@if(Auth::check())

    <audio id="notif-sound" src="{{ asset('audio/notify.mp3') }}" preload="auto"></audio>

    <script>
        function fetchNotifications() {
            let route = "{{ Auth::user()->role == 0 ? '/notifications' : '/user-notifications' }}";

            fetch(route)
                .then(response => response.json())
                .then(data => {
                    let notificationList = document.getElementById('notification-list');
                    let notificationBadge = document.getElementById('notification-badge');
                    let headerCount = document.getElementById('notification-header-count');

                    if (!notificationList || !notificationBadge) return;

                    notificationList.innerHTML = '';

                    let previousCount = parseInt(localStorage.getItem('previousNotificationCount')) || 0;
                    let currentCount = Array.isArray(data) ? data.length : 0;

                    // 🔔 Play sound only on increase
                    if (currentCount > previousCount && previousCount >= 0) {
                        let audio = document.getElementById('notif-sound');
                        if (audio) {
                            audio.play().catch(e => console.log('Audio autoplay prevented'));
                        }
                        if (typeof toastr !== 'undefined') {
                            toastr.info(`📢 You have ${currentCount - previousCount} new notification(s)!`);
                        }
                    }

                    localStorage.setItem('previousNotificationCount', currentCount);

                    if (headerCount) {
                        headerCount.textContent = currentCount;
                    }

                    if (currentCount > 0) {
                        notificationBadge.textContent = currentCount > 99 ? '99+' : currentCount;
                        notificationBadge.style.display = 'inline-block';

                        data.forEach(notification => {
                            let notificationItem = document.createElement('a');
                            notificationItem.href = notification.action_url || "{{ route('message.inbox') }}";
                            notificationItem.className = "dropdown-item py-2 px-3 border-bottom d-flex align-items-start";
                            notificationItem.style.whiteSpace = "normal";

                            let iconClass = notification.icon || 'fas fa-bell';
                            let statusColor = notification.status_color || 'primary';
                            let statusBadge = '';
                            if (notification.status && notification.status !== 'info') {
                                statusBadge = `<span class="badge badge-${statusColor} text-uppercase px-1 ml-1" style="font-size: 9px;">${notification.status}</span>`;
                            }

                            notificationItem.innerHTML = `
                                <div class="mr-3 mt-1">
                                    <span class="btn btn-sm btn-${statusColor} btn-circle p-1" style="width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="${iconClass}" style="font-size: 11px;"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="font-weight-bold text-dark text-truncate" style="font-size: 13px; max-width: 140px;">
                                            ${notification.type || 'Notification'}
                                        </span>
                                        ${statusBadge}
                                    </div>
                                    <p class="text-muted mb-1 text-sm text-truncate" style="max-width: 200px; font-size: 12px; margin: 0;">
                                        ${notification.message}
                                    </p>
                                    <span class="text-xs text-muted" style="font-size: 10px;">
                                        <i class="far fa-clock mr-1"></i>${notification.time_ago || 'recently'}
                                    </span>
                                </div>
                            `;

                            notificationItem.addEventListener('click', function (e) {
                                fetch(`/notifications/read/${notification.id}`, {
                                    method: 'PUT',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                    }
                                });
                            });

                            notificationList.appendChild(notificationItem);
                        });
                    } else {
                        notificationBadge.style.display = 'none';
                        notificationList.innerHTML = `
                            <p class="dropdown-item text-center text-muted py-4 mb-0">
                                <i class="fas fa-bell-slash fa-2x mb-2 text-secondary d-block"></i>
                                No new notifications
                            </p>
                        `;
                    }
                })
                .catch(error => console.error('Error fetching notifications:', error));
        }

        document.addEventListener('DOMContentLoaded', function () {
            fetchNotifications();
            setInterval(fetchNotifications, 12000);

            // Handle Mark all read button
            let markAllBtn = document.getElementById('mark-all-read-btn');
            if (markAllBtn) {
                markAllBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    fetch('/notifications/mark-all-read', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(r => r.json())
                    .then(res => {
                        if (res.success) {
                            if (typeof toastr !== 'undefined') toastr.success('All marked as read');
                            fetchNotifications();
                        }
                    });
                });
            }
        });
    </script>
@endif


<!-- REQUIRED SCRIPTS -->
@include('layout.foot')
