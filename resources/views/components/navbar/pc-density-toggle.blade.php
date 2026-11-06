@php
    $compactCookie = request()->cookie('pc_compact_mode') ?? ($_COOKIE['pc_compact_mode'] ?? null);
    $isCompact = ($compactCookie === '1');
@endphp

<li class="nav-item d-none d-md-flex align-items-center mx-1">
    <button type="button" 
            id="navbarPcDensityToggle"
            onclick="togglePcCompactMode()" 
            class="btn-pc-nav-action {{ $isCompact ? 'active' : '' }}"
            title="{{ $isCompact ? __('Switch to Comfortable display (Alt + C)') : __('Switch to Compact display (Alt + C)') }}"
            aria-label="{{ __('Toggle Display Density') }}">
        <i class="fas {{ $isCompact ? 'fa-expand-arrows-alt' : 'fa-compress-arrows-alt' }}" id="pcDensityIcon"></i>
    </button>
</li>

