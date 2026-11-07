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
    $userPhoto = $authUser->photo_url ?? asset('noimg.jpg');
@endphp

<!-- User Profile Dropdown Menu in Top Navbar -->
<li class="nav-item dropdown user-menu-dropdown ml-1">
    <a class="nav-link d-flex align-items-center py-1 px-2 user-menu-btn" 
       href="#" 
       id="navbarUserDropdown" 
       role="button" 
       data-toggle="dropdown" 
       aria-haspopup="true" 
       aria-expanded="false"
       title="{{ $authUser->name ?? 'User Profile' }}">
        <img src="{{ $userPhoto }}" 
             class="navbar-user-avatar rounded-circle elevation-1" 
             alt="{{ $authUser->name ?? 'User' }}"
             onerror="this.onerror=null; this.src='{{ asset('assets/dist/img/avatar.png') }}'">
        <span class="d-none d-lg-inline-block font-weight-bold ml-2 text-truncate" style="max-width: 130px; font-size: 0.88rem;">
            {{ $authUser->name ?? __('User') }}
        </span>
        <i class="fas fa-angle-down ml-1 text-muted small"></i>
    </a>
    
    <div class="dropdown-menu dropdown-menu-right shadow-lg border-0 modern-user-dropdown-menu" 
         aria-labelledby="navbarUserDropdown" 
         style="min-width: 250px; border-radius: 14px; overflow: hidden; padding: 0;">
        
        <!-- User Info Header -->
        <div class="p-3 text-center dropdown-user-header" style="background: linear-gradient(135deg, #4f46e5, #6366f1); color: #ffffff;">
            <div class="position-relative d-inline-block mb-2">
                <img src="{{ $userPhoto }}" 
                     class="rounded-circle border border-white elevation-2" 
                     style="width: 52px; height: 52px; object-fit: cover;"
                     alt="{{ $authUser->name ?? 'User' }}"
                     onerror="this.onerror=null; this.src='{{ asset('assets/dist/img/avatar.png') }}'">
                <span class="position-absolute bg-success rounded-circle border border-white" 
                      style="width: 12px; height: 12px; bottom: 2px; right: 2px;" 
                      title="Online"></span>
            </div>
            <h6 class="font-weight-bold mb-0 text-white text-truncate">{{ $authUser->name ?? 'User' }}</h6>
            <small class="text-white-50 text-truncate d-block mb-1" style="font-size: 0.78rem;">{{ $authUser->email ?? '' }}</small>
            <span class="badge badge-pill badge-light px-2 py-1 font-weight-bold" style="font-size: 0.72rem; color: #4338ca;">
                {{ $roleTitle }}
            </span>
        </div>

        <!-- Quick Navigation Links -->
        <div class="py-2">
            <a href="{{ route('user.profile') }}" class="dropdown-item py-2 px-3 d-flex align-items-center">
                <i class="fas fa-id-badge text-primary mr-2" style="width: 18px;"></i>
                <span>{{ __('My Profile') }}</span>
            </a>
            @if((int)$userRole === 0)
                <a href="{{ route('customize.index') }}" class="dropdown-item py-2 px-3 d-flex align-items-center">
                    <i class="fas fa-paint-brush text-indigo mr-2" style="width: 18px;"></i>
                    <span>{{ __('Customize Theme') }}</span>
                </a>
                <a href="{{ route('activity.logs') }}" class="dropdown-item py-2 px-3 d-flex align-items-center">
                    <i class="fas fa-history text-secondary mr-2" style="width: 18px;"></i>
                    <span>{{ __('Activity Logs') }}</span>
                </a>
            @endif
        </div>

        <div class="dropdown-divider m-0"></div>

        <!-- Logout Action Button -->
        <div class="p-2 bg-light">
            <a href="/logout" class="btn btn-danger btn-block btn-sm logout-btn font-weight-bold d-flex align-items-center justify-content-center py-2" style="border-radius: 8px;">
                <i class="fas fa-sign-out-alt mr-2"></i> {{ __('Log Out') }}
            </a>
        </div>
    </div>
</li>

<!-- Quick Standalone Logout Icon Button in Top Navbar -->
<li class="nav-item ml-1">
    <a href="/logout" 
       class="nav-link logout-btn navbar-quick-logout-btn" 
       title="{{ __('Log Out') }}" 
       aria-label="{{ __('Log Out') }}">
        <i class="fas fa-power-off text-danger"></i>
    </a>
</li>

