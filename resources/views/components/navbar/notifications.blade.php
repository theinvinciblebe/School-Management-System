<li class="nav-item dropdown">
    <a class="nav-link" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="far fa-bell"></i>
        <span id="notification-badge" class="badge badge-warning navbar-badge" style="display: none;">0</span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" aria-labelledby="notificationDropdown">
        <span class="dropdown-item dropdown-header">Notifications</span>
        <div class="dropdown-divider"></div>

        <!-- Notification List -->
        <div id="notification-list" class="list-group">
            <p class="dropdown-item text-center">No new notifications</p>
        </div>

        <div class="dropdown-divider"></div>
        @if(Auth::check() && (Auth::user()->role == 0 || Auth::user()->role == 3))
            <a href="{{ Auth::user()->role == 0 ? '/inbox' : '/Userinbox' }}" class="dropdown-item dropdown-footer">
                See All Notifications
            </a>
        @endif

    </div>
</li>
