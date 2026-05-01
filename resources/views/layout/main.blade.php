@extends('layout.head')

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Bootstrap Switch -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/css/bootstrap3/bootstrap-switch.min.css">

<style>
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

</style>

<!-- Preloader -->
<style>
    .preloader {
        background-color: #ffffff; /* Change the background color */
        /*display: none !important;*/
    }

    .animation__wobble {
        animation: myCustomWobble 0.1s infinite; /* Customize animation */
    }

</style>

<style>

    #notification-list  {
        display: flex;
        align-items: center;
        white-space: nowrap;  /* Prevent text from wrapping */
        overflow: hidden;  /* Hide overflow text */
        text-overflow: ellipsis;  /* Add '...' for overflowing text */
        max-width: 320px; /* Adjust width to fit */

    }
</style>

<body id="mainBody" class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed {{ $customizes->accent_color ?? '' }}" style="height: auto;">

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
      <img src="{{ asset('customize_images/' . ($customizes->brand_logo ?? 'noimg.jpg')) }}" alt="Mawarid Logo" class="brand-image img-circle elevation-3">
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
    <div class="content-wrapper light-mode" id="contentWrapper">
        <div class="overlay-wrapper">
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
    document.addEventListener('DOMContentLoaded', function () {
        const themeSwitch = document.getElementById('themeSwitch');
        const contentWrapper = document.getElementById('mainBody');

        // Load the saved theme from localStorage
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark-mode') {
            contentWrapper.classList.remove('light-mode');
            contentWrapper.classList.add('dark-mode');
            themeSwitch.checked = true;
        }

        // Initialize the Bootstrap Switch
        $('[data-bootstrap-switch]').bootstrapSwitch();

        // Add event listener for the switch
        $(themeSwitch).on('switchChange.bootstrapSwitch', function (event, state) {
            if (state) {
                contentWrapper.classList.remove('light-mode');
                contentWrapper.classList.add('dark-mode');
                localStorage.setItem('theme', 'dark-mode'); // Save theme preference
            } else {
                contentWrapper.classList.remove('dark-mode');
                contentWrapper.classList.add('light-mode');
                localStorage.setItem('theme', 'light-mode'); // Save theme preference
            }
        });
    });
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
@extends('layout.foot')
