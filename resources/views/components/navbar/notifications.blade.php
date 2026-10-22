<li class="nav-item dropdown">
    <a class="nav-link" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Notifications">
        <i class="far fa-bell"></i>
        <span id="notification-badge" class="badge badge-warning navbar-badge" style="display: none;">0</span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right shadow-lg border-0" aria-labelledby="notificationDropdown" style="min-width: 320px; border-radius: 12px; overflow: hidden;">
        <div class="dropdown-item dropdown-header d-flex justify-content-between align-items-center py-2 px-3 bg-light border-bottom">
            <span class="font-weight-bold text-dark">
                <i class="fas fa-bell mr-1 text-primary"></i> Notifications
                <span id="notification-header-count" class="badge badge-primary ml-1">0</span>
            </span>
            <button id="mark-all-read-btn" class="btn btn-link btn-xs p-0 text-muted" title="Mark all as read" style="text-decoration: none;">
                <i class="fas fa-check-double mr-1"></i>Mark read
            </button>
        </div>

        <!-- Notification List -->
        <div id="notification-list" class="list-group list-group-flush" style="max-height: 350px; overflow-y: auto;">
            <p class="dropdown-item text-center text-muted py-4 mb-0">
                <i class="fas fa-bell-slash fa-2x mb-2 text-secondary d-block"></i>
                No new notifications
            </p>
        </div>

        <div class="dropdown-divider m-0"></div>
        <a href="{{ route('message.inbox') }}" class="dropdown-item dropdown-footer text-center py-2 font-weight-bold text-primary bg-light">
            <i class="fas fa-inbox mr-1"></i> Open Inbox & Approvals
        </a>
    </div>
</li>
