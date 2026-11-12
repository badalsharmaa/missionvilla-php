@php
    /** @var array $data Normalised by App\Content\Sections\GalleryHeroSection */
    $site = config('missionvilla');
    $previews = $data['previews'];
    $categories = $data['categories'];
    $actions = $data['actions'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/gallery-hero.css'])
@endpush
{{--
    GALLERY SECTION 01 · EXHIBITION HERO
--}}
<section class="gh-hero" aria-labelledby="gh-hero-heading" data-gh-hero>
    <div class="gh-hero__glow" aria-hidden="true"></div>
    <div class="gh-hero__inner">
        {{-- Top Bar: Breadcrumbs --}}
        <div class="gh-hero__topbar">
            <nav aria-label="Breadcrumb" class="gh-hero__breadcrumbs">
                <a href="/" class="gh-hero__crumb">Home</a>
                <span class="gh-hero__crumb-sep" aria-hidden="true">·</span>
                <a href="/life-at-mission-villa" class="gh-hero__crumb">Life at Mission Villa</a>
                <span class="gh-hero__crumb-sep" aria-hidden="true">·</span>
                <span class="gh-hero__crumb gh-hero__crumb--active" aria-current="page">Gallery &amp; Virtual Tour</span>
            </nav>
            <div class="gh-hero__badge">
                <span>Visual Monograph</span>
                <span class="gh-hero__badge-dot" aria-hidden="true"></span>
                <span>Daly City, CA</span>
            </div>
        </div>

        {{-- 12-Column Grid: Left Copy & Categories, Right 3-Plate Aperture Preview --}}
        <div class="gh-hero__grid">
            {{-- Left 7 Columns --}}
            <div class="gh-hero__copy">
                <p class="mv-eyebrow gh-hero__eyebrow">
                    <span class="mv-eyebrow__rule gh-hero__rule" aria-hidden="true"></span>
                    <span>{{ $data['eyebrow'] }}</span>
                </p>

                <h1 id="gh-hero-heading" class="gh-hero__title">
                    {!! $data['heading'] !!}
                </h1>

                <p class="gh-hero__editorial">
                    {{ $data['editorial'] }}
                </p>

                <p class="gh-hero__intro">
                    {{ $data['intro'] }}
                </p>

                {{-- Action Buttons --}}
                <div class="gh-hero__actions">
                    @foreach ($actions as $action)
                        @if ($action['style'] === 'phone')
                            <a
                                href="{{ $site['phone']['href'] }}"
                                class="gh-hero__btn gh-hero__btn--phone"
                            >
                                <svg class="mv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                <span>{{ $action['label'] }}</span>
                            </a>
                        @elseif ($action['style'] === 'primary')
                            <a
                                href="{{ $site['phone']['href'] }}"
                                class="gh-hero__btn gh-hero__btn--primary"
                                data-inquiry="{{ $action['intent'] ?? 'schedule_visit' }}"
                                data-care="{{ $action['care'] ?? 'exploring' }}"
                            >
                                <span>{{ $action['label'] }}</span>
                                <svg class="mv-icon gh-hero__btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </a>
                        @else
                            <a
                                href="#virtual-tour"
                                class="gh-hero__btn gh-hero__btn--secondary"
                            >
                                <span>{{ $action['label'] }}</span>
                                <svg class="mv-icon gh-hero__btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </a>
                        @endif
                    @endforeach
                </div>

                {{-- Category Jump Chips --}}
                <div class="gh-hero__cats">
                    <span class="gh-hero__cats-kicker">CURATED CATEGORIES:</span>
                    <div class="gh-hero__cats-list">
                        @foreach ($categories as $cat)
                            <a href="#gallery-category-{{ $cat['id'] }}" class="gh-hero__cat-chip">
                                <span>{{ $cat['label'] }}</span>
                                <span class="gh-hero__cat-count">({{ $cat['count'] }})</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Right 5 Columns: 3-Plate Aperture Triptych --}}
            <div class="gh-hero__aperture">
                <div class="gh-hero__triptych">
                    @foreach ($previews as $idx => $prev)
                        <div class="gh-hero__plate gh-hero__plate--{{ $idx + 1 }}">
                            <img
                                src="{{ asset(ltrim($prev['image']['src'], '/')) }}"
                                alt="{{ $prev['image']['alt'] }}"
                                width="{{ $prev['image']['width'] }}"
                                height="{{ $prev['image']['height'] }}"
                                class="gh-hero__plate-img"
                                loading="eager"
                                decoding="async"
                            >
                            <div class="gh-hero__plate-tag">
                                <span>{{ $prev['cutout_label'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="gh-hero__aperture-note">
                    <svg class="mv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                    <span>Authentic photography captured on-site at 995 East Market Street</span>
                </div>
            </div>
        </div>
    </div>
</section>
