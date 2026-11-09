@props(['variant' => 'overlay'])
@php
    $site = config('missionvilla');
    $items = config('navigation.primary');
    $current = '/'.ltrim(request()->path(), '/');
    $isActive = function (array $item) use ($current): bool {
        $path = strtok($item['href'], '#');
        if ($path === $current) {
            return true;
        }
        foreach ($item['children'] ?? [] as $child) {
            if (strtok($child['href'], '#') === $current) {
                return true;
            }
        }
        return false;
    };
@endphp
{{--
    Global site header. "overlay" variant sits transparently over a full-bleed
    hero (inside the hero's reserved 18svh safe area) and gains a solid plum
    surface once the page scrolls.
--}}
<header class="site-header" data-site-header data-variant="{{ $variant }}">
    <div class="site-header__bar">
        <a href="/" class="site-header__brand" aria-label="{{ $site['name'] }} — Home">
            {{-- Official Mission Villa leaf mark (from the brand PDF, via the React reference public/brand). --}}
            <img src="{{ asset('images/brand/mission-villa-mark-160.webp') }}" alt="" width="160" height="102" class="site-header__mark">
            <span class="site-header__wordmark">
                <span class="site-header__name">MISSION VILLA</span>
                <span class="site-header__tagline">Senior Living<span class="site-header__tagline-place"> · Daly City</span></span>
            </span>
        </a>

        <nav class="site-header__nav" aria-label="Primary">
            <ul class="site-nav">
                @foreach ($items as $i => $item)
                    @php $active = $isActive($item); @endphp
                    <li class="site-nav__item">
                        @if (! empty($item['children']))
                            <button type="button" class="site-nav__link site-nav__toggle {{ $active ? 'is-active' : '' }}"
                                    aria-expanded="false" aria-controls="site-nav-menu-{{ $i }}" data-nav-toggle>
                                <span>{{ $item['label'] }}</span>
                                <svg class="site-nav__chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
                            </button>
                            <div class="site-nav__menu" id="site-nav-menu-{{ $i }}" hidden>
                                <ul class="site-nav__panel">
                                    @foreach ($item['children'] as $child)
                                        <li>
                                            <a href="{{ $child['href'] }}" class="site-nav__menu-link" @if (strtok($child['href'], '#') === $current) aria-current="page" @endif>
                                                <span>
                                                    <span class="site-nav__menu-label">{{ $child['label'] }}</span>
                                                    @isset($child['description'])
                                                        <span class="site-nav__menu-desc">{{ $child['description'] }}</span>
                                                    @endisset
                                                </span>
                                                <span class="site-nav__menu-arrow" aria-hidden="true">↗</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <a href="{{ $item['href'] }}" class="site-nav__link {{ $active ? 'is-active' : '' }}" @if ($active) aria-current="page" @endif>{{ $item['label'] }}</a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </nav>

        <div class="site-header__actions">
            <a href="{{ $site['phone']['href'] }}" class="site-header__phone">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                <span>{{ $site['phone']['display'] }}</span>
            </a>
            {{-- Opens the on-page visit dialog when present; otherwise navigates to the contact page. --}}
            <a href="{{ $site['visit_url'] }}" class="site-header__cta" data-open-visit>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3.5" y="5" width="17" height="15.5" rx="2"/><path stroke-linecap="round" d="M3.5 9.5h17M8 3v4M16 3v4"/></svg>
                <span>Schedule a Visit</span>
            </a>
            <button type="button" class="site-header__menu-btn" aria-expanded="false" aria-controls="site-mobile-nav" data-mobile-nav-toggle>
                <span class="sr-only" data-mobile-nav-label>Open navigation menu</span>
                <svg class="icon-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
                <svg class="icon-close" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" d="M6 6l12 12M18 6 6 18"/></svg>
            </button>
        </div>
    </div>

    {{-- Mobile / tablet navigation drawer (below xl). --}}
    <div class="site-mobile-nav" id="site-mobile-nav" hidden>
        <nav aria-label="Mobile">
            <ul class="site-mobile-nav__list">
                @foreach ($items as $item)
                    @if (! empty($item['children']))
                        <li class="site-mobile-nav__group">
                            <p class="site-mobile-nav__heading">{{ $item['label'] }}</p>
                            <ul>
                                @foreach ($item['children'] as $child)
                                    <li><a href="{{ $child['href'] }}" class="site-mobile-nav__sublink">{{ $child['label'] }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @elseif (! collect($items)->pluck('children')->flatten(1)->pluck('href')->contains($item['href']))
                        <li><a href="{{ $item['href'] }}" class="site-mobile-nav__link" @if ($isActive($item)) aria-current="page" @endif>{{ $item['label'] }}</a></li>
                    @endif
                @endforeach
            </ul>
        </nav>
        <div class="site-mobile-nav__footer">
            <a href="{{ $site['visit_url'] }}" class="site-header__cta site-header__cta--block" data-open-visit>Schedule a Visit</a>
            <a href="{{ $site['phone']['href'] }}" class="site-mobile-nav__phone">Call {{ $site['phone']['display'] }}</a>
            <p class="site-mobile-nav__meta">{{ $site['address']['street'] }}, {{ $site['address']['city'] }}, {{ $site['address']['region'] }} {{ $site['address']['postal_code'] }} · {{ $site['license']['label'] }} #{{ $site['license']['number'] }}</p>
        </div>
    </div>
</header>
