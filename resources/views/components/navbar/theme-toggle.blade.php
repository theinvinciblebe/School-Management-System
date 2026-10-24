@php
    $themeCookie = request()->cookie('theme') ?? ($_COOKIE['theme'] ?? null);
    $isDark = ($themeCookie === 'dark-mode');
@endphp

<li class="nav-item d-flex align-items-center mx-1" id="navbarThemeToggleItem">
    <button type="button" 
            id="navbarThemeToggle"
            aria-label="{{ $isDark ? __('Switch to light theme') : __('Switch to dark theme') }}" 
            class="focus-ring relative inline-flex h-8 w-8 cursor-pointer items-center justify-center rounded-full bg-background ring-1 ring-foreground/8 transition-colors {{ $isDark ? 'is-dark' : 'is-light' }}" 
            aria-pressed="{{ $isDark ? 'true' : 'false' }}"
            title="{{ $isDark ? __('Switch to light theme') : __('Switch to dark theme') }}">
        <span aria-hidden="true" class="relative h-4 w-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sun absolute inset-0 h-4 w-4 text-foreground transition-all duration-300 {{ $isDark ? '-rotate-90 scale-0 opacity-0' : 'rotate-0 scale-100 opacity-100' }}" aria-hidden="true">
                <circle cx="12" cy="12" r="4"></circle>
                <path d="M12 2v2"></path>
                <path d="M12 20v2"></path>
                <path d="m4.93 4.93 1.41 1.41"></path>
                <path d="m17.66 17.66 1.41 1.41"></path>
                <path d="M2 12h2"></path>
                <path d="M20 12h2"></path>
                <path d="m6.34 17.66-1.41 1.41"></path>
                <path d="m19.07 4.93-1.41 1.41"></path>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-moon absolute inset-0 h-4 w-4 text-foreground transition-all duration-300 {{ $isDark ? 'rotate-0 scale-100 opacity-100' : 'rotate-90 scale-0 opacity-0' }}" aria-hidden="true">
                <path d="M20.985 12.486a9 9 0 1 1-9.473-9.472c.405-.022.617.46.402.803a6 6 0 0 0 8.268 8.268c.344-.215.825-.004.803.401"></path>
            </svg>
        </span>
    </button>
</li>
