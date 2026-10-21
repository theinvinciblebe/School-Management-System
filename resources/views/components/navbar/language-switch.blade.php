@php
    $locale = app()->getLocale();
    $isKhmer = ($locale === 'km');
@endphp
<li class="nav-item dropdown" id="languageSwitcherNav">
    <a class="nav-link lang-dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" title="{{ $isKhmer ? 'ប្តូរភាសា' : 'Switch Language' }}">
        <span class="flag-icon {{ $isKhmer ? 'flag-icon-kh' : 'flag-icon-us' }}"></span>
        <span class="d-none d-md-inline" style="font-size: 0.88rem; font-weight: 600;">
            {{ $isKhmer ? 'ខ្មែរ' : 'EN' }}
        </span>
        <i class="fas fa-chevron-down ml-1" style="font-size: 0.65rem; opacity: 0.7;"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right lang-dropdown-menu">
        <a href="{{ route('lang.switch', 'en') }}" class="dropdown-item {{ !$isKhmer ? 'active' : '' }}">
            <span class="flag-icon flag-icon-us"></span>
            <span>English</span>
            @if(!$isKhmer)
                <i class="fas fa-check text-success ml-auto font-weight-bold" style="font-size: 0.82rem;"></i>
            @endif
        </a>
        <a href="{{ route('lang.switch', 'km') }}" class="dropdown-item {{ $isKhmer ? 'active' : '' }}">
            <span class="flag-icon flag-icon-kh"></span>
            <span>ភាសាខ្មែរ</span>
            @if($isKhmer)
                <i class="fas fa-check text-success ml-auto font-weight-bold" style="font-size: 0.82rem;"></i>
            @endif
        </a>
    </div>
</li>
