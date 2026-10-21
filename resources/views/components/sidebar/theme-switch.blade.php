@php
    $themeCookie = request()->cookie('theme') ?? ($_COOKIE['theme'] ?? null);
    $isDark = ($themeCookie === 'dark-mode');
@endphp
<li class="nav-item theme-mode-item">
    <div class="theme-mode-wrapper" 
         id="themeToggleWrapper" 
         role="button" 
         tabindex="0"
         title="Click to toggle Dark / Light mode">
        <div class="theme-mode-label">
            <span class="theme-icon-container">
                <i class="fas fa-sun theme-icon-sun {{ $isDark ? 'd-none' : '' }}"></i>
                <i class="fas fa-moon theme-icon-moon {{ $isDark ? '' : 'd-none' }}"></i>
            </span>
            <span class="theme-text" id="themeLabelText">{{ $isDark ? __('Dark Mode') : __('Light Mode') }}</span>
        </div>
        <div class="theme-switch-container">
            <label class="modern-theme-switch" for="themeSwitch" onclick="event.stopPropagation();">
                <input type="checkbox" id="themeSwitch" name="theme-switch" aria-label="Toggle dark/light theme mode" {{ $isDark ? 'checked' : '' }}>
                <span class="theme-slider">
                    <span class="slider-icons">
                        <i class="fas fa-sun slider-sun"></i>
                        <i class="fas fa-moon slider-moon"></i>
                    </span>
                    <span class="slider-knob"></span>
                </span>
            </label>
        </div>
    </div>
</li>
