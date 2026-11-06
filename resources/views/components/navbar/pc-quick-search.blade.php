<li class="nav-item d-none d-lg-flex align-items-center ml-2 mr-1">
    <button type="button" 
            id="navbarPcSearchBtn"
            onclick="openPcCommandPalette()" 
            class="btn-pc-search-trigger"
            title="{{ __('Quick Search or Command (Ctrl + K)') }}"
            aria-label="{{ __('Quick Search') }}">
        <i class="fas fa-search mr-2 text-muted" style="font-size: 0.82rem;"></i>
        <span class="btn-pc-search-placeholder">{{ __('Quick search...') }}</span>
        <kbd class="pc-kbd-badge ml-3">Ctrl K</kbd>
    </button>
</li>

