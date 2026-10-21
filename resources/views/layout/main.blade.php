@php
    $themeCookie = request()->cookie('theme') ?? ($_COOKIE['theme'] ?? null);
    $isDark = ($themeCookie === 'dark-mode');
@endphp
@include("layout.head")

<body id="mainBody" class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed {{ $isDark ? 'dark-mode' : '' }} {{ $customizes->accent_color ?? '' }}" style="{{ $isDark ? 'background-color: #232323 !important;' : '' }}; height: auto;">
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
    <!-- Navbar -->
    <nav id="mainNav" class="main-header navbar navbar-expand navbar-dark {{ $customizes->nav_color ?? '' }}">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/dashboard" class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="https://mawaridtech.com/" class="nav-link">Contact</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Notifications Dropdown Menu -->
            @include('components.navbar.notifications')

            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                    <i class="fas fa-th-large"></i>
                </a>
            </li>
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
                  <p>Welcome, {{ Auth::user()->name }}!</p>
              @endif
          </a>
        </div>
      </div>

        <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
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

            <!-- Include Toastr JS -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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
                document.querySelectorAll('.theme-icon-sun').forEach(function (el) { el.classList.add('d-none'); });
                document.querySelectorAll('.theme-icon-moon').forEach(function (el) { el.classList.remove('d-none'); });
                document.querySelectorAll('#themeLabelText').forEach(function (el) { el.textContent = 'Dark Mode'; });
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
                document.querySelectorAll('.theme-icon-sun').forEach(function (el) { el.classList.remove('d-none'); });
                document.querySelectorAll('.theme-icon-moon').forEach(function (el) { el.classList.add('d-none'); });
                document.querySelectorAll('#themeLabelText').forEach(function (el) { el.textContent = 'Light Mode'; });
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

            setTimeout(() => {
                if (body) body.classList.remove('theme-transitioning');
            }, 350);
        }

        const savedTheme = localStorage.getItem('theme');
        const isDark = savedTheme === 'dark-mode' || (!savedTheme && document.documentElement.classList.contains('dark-mode'));

        document.addEventListener('DOMContentLoaded', function () {
            updateThemeUI(isDark);

            const themeSwitch = document.getElementById('themeSwitch');
            const wrapper = document.getElementById('themeToggleWrapper');

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
                    }
                });

                wrapper.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        if (themeSwitch) {
                            themeSwitch.checked = !themeSwitch.checked;
                            toggleTheme(themeSwitch.checked);
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

@if(Auth::check() && (Auth::user()->role == 0 || Auth::user()->role == 3))

    <audio id="notif-sound" src="{{ asset('audio/notify.mp3') }}" preload="auto"></audio>

    <script>
        function fetchNotifications() {
            let route = "{{ Auth::user()->role == 0 ? '/notifications' : '/user-notifications' }}";

            fetch(route)
                .then(response => response.json())
                .then(data => {
                    let notificationList = document.getElementById('notification-list');
                    let notificationBadge = document.getElementById('notification-badge');

                    notificationList.innerHTML = '';

                    let previousCount = parseInt(localStorage.getItem('previousNotificationCount')) || 0;
                    let currentCount = data.length;

                    // 🔔 Only play sound when there are new notifications
                    if (currentCount > previousCount) {
                        document.getElementById('notif-sound').play();
                        toastr.info(`📢 You have ${currentCount - previousCount} new notification(s)!`);
                    }

                    // Save the current count for next time
                    localStorage.setItem('previousNotificationCount', currentCount);

                    if (currentCount > 0) {
                        notificationBadge.textContent = currentCount;
                        notificationBadge.style.display = 'inline-block';

                        data.forEach(notification => {
                            let notificationItem = document.createElement('a');
                            notificationItem.href = "{{ Auth::user()->role == 0 ? '/inbox' : '/Userinbox' }}";
                            notificationItem.className = "dropdown-item text-truncate";
                            notificationItem.style.maxWidth = "250px";
                            notificationItem.title = notification.message;
                            notificationItem.innerHTML = `<i class="fas fa-envelope mr-2"></i> ${notification.message.substring(0, 35)}...`;
                            notificationList.appendChild(notificationItem);
                        });
                    } else {
                        notificationBadge.style.display = 'none';
                        notificationList.innerHTML = `<p class="dropdown-item text-center">No new notifications</p>`;
                    }
                })
                .catch(error => console.error('Error fetching notifications:', error));
        }

        // Call immediately and every 10 seconds
        fetchNotifications();
        setInterval(fetchNotifications, 10000);
    </script>


@endif


<!-- REQUIRED SCRIPTS -->
@include('layout.foot')
