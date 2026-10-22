@php
    $themeCookie = request()->cookie('theme') ?? ($_COOKIE['theme'] ?? null);
    $isDark = ($themeCookie === 'dark-mode');
@endphp
@include("layout.head")

<body id="mainBody" class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed {{ $isDark ? 'dark-mode' : '' }} {{ $customizes->accent_color ?? '' }} {{ app()->getLocale() === 'km' ? 'lang-km' : '' }}" style="{{ $isDark ? 'background-color: #232323 !important;' : '' }}; height: auto;">
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
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/dashboard" class="nav-link">{{ __('Home') }}</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">{{ __('Contact') }}</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto align-items-center">
            <!-- Dark / Light Mode Toggle -->
            @include('components.navbar.theme-toggle')

            <!-- Language Switcher Dropdown -->
            @include('components.navbar.language-switch')

            <!-- Notifications Dropdown Menu -->
            @include('components.navbar.notifications')

            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                    <i class="fas fa-th-large"></i>
                </a>
            </li> -->
        </ul>
    </nav>
    <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar {{ $customizes->dark_sidebar_variants ?? 'sidebar-dark-primary' }} elevation-4 {{ $customizes->sidebar_color ?? 'bg-dark' }} ">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
      <img src="{{ asset('customize_images/' . ($customizes->brand_logo ?? 'noimg.jpg')) }}" alt="Brand Logo" class="brand-image img-circle elevation-3" style="width: 33px; height: 33px; object-fit: cover; border-radius: 50%;">
      <span class="brand-text font-weight-light">{{ $customizes->brand_title ?? 'N/A'}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 mb-3 d-flex" id="user-panel" style="cursor: pointer;">
        <div class="image" >
            <img id="profilePhoto" src="{{ asset('noimg.jpg') }}"
                 class="img-circle elevation-2"
                 alt="User Image"
                 width="50" height="50">

        </div>
        <div class="info">
          <a href="{{ route('user.profile') }}" class="d-block">
              @if (Auth::check())
                  <p>{{ __('Welcome') }}, {{ Auth::user()->name }}!</p>
              @endif
          </a>
        </div>
      </div>

        <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="{{ __('Search') }}" aria-label="{{ __('Search') }}">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>
        @stack('scripts')

      <!-- Sidebar Menu -->
        @includeWhen(Auth::check() && Auth::user()->role === 0, 'components.sidebar.admin')
        @includeWhen(Auth::check() && Auth::user()->role === 1, 'components.sidebar.teacher')
        @includeWhen(Auth::check() && Auth::user()->role === 2, 'components.sidebar.student')
        @includeWhen(Auth::check() && Auth::user()->role === 3, 'components.sidebar.accountant')
        @includeWhen(Auth::check() && Auth::user()->role === 4, 'components.sidebar.reception')

    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper {{ $isDark ? 'dark-mode' : '' }}" id="contentWrapper" style="{{ $isDark ? 'background-color: #232323 !important;' : '' }}">
        <div class="overlay-wrapper" id="mainOverlayWrapper">
            @yield('content')

            <!-- Include Global Toastr Notifications -->
            @include('layout.toastr')
        </div>
    </div>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

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
                if (themeSwitch) themeSwitch.checked = true;
                if (navbarThemeToggle) {
                    navbarThemeToggle.classList.add('is-dark');
                    navbarThemeToggle.classList.remove('is-light');
                    navbarThemeToggle.setAttribute('title', '{{ __("Switch to Light Mode") }}');
                    navbarThemeToggle.setAttribute('aria-label', '{{ __("Switch to Light Mode") }}');
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
                if (themeSwitch) themeSwitch.checked = false;
                if (navbarThemeToggle) {
                    navbarThemeToggle.classList.remove('is-dark');
                    navbarThemeToggle.classList.add('is-light');
                    navbarThemeToggle.setAttribute('title', '{{ __("Switch to Dark Mode") }}');
                    navbarThemeToggle.setAttribute('aria-label', '{{ __("Switch to Dark Mode") }}');
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

            if (themeSwitch) {
                themeSwitch.addEventListener('change', function () {
                    toggleTheme(this.checked);
                });
            }

            if (wrapper) {
                wrapper.addEventListener('click', function (e) {
                    if (e.target.closest('.modern-theme-switch')) return;
                    if (themeSwitch) {
                        themeSwitch.checked = !themeSwitch.checked;
                        toggleTheme(themeSwitch.checked);
                    } else {
                        const willBeDark = !document.documentElement.classList.contains('dark-mode');
                        toggleTheme(willBeDark);
                    }
                });

                wrapper.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        if (themeSwitch) {
                            themeSwitch.checked = !themeSwitch.checked;
                            toggleTheme(themeSwitch.checked);
                        } else {
                            const willBeDark = !document.documentElement.classList.contains('dark-mode');
                            toggleTheme(willBeDark);
                        }
                    }
                });
            }
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
