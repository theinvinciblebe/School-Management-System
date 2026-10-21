@php
    $themeCookie = request()->cookie('theme') ?? ($_COOKIE['theme'] ?? null);
    $isDark = ($themeCookie === 'dark-mode');
@endphp

<li class="nav-item d-flex align-items-center mx-1" id="navbarThemeToggleItem">
    <button type="button" 
            id="navbarThemeToggle"
            class="navbar-theme-pill-btn {{ $isDark ? 'is-dark' : 'is-light' }}"
            role="button"
            tabindex="0"
            aria-label="{{ $isDark ? __('Switch to Light Mode') : __('Switch to Dark Mode') }}"
            title="{{ $isDark ? __('Switch to Light Mode') : __('Switch to Dark Mode') }}">
        <span class="navbar-theme-track">
            <span class="track-icon track-sun" aria-hidden="true">
                <i class="fas fa-sun"></i>
            </span>
            <span class="track-icon track-moon" aria-hidden="true">
                <i class="fas fa-moon"></i>
            </span>
            <span class="navbar-theme-knob">
                <i class="fas fa-sun knob-icon-sun"></i>
                <i class="fas fa-moon knob-icon-moon"></i>
            </span>
        </span>
    </button>
</li>
