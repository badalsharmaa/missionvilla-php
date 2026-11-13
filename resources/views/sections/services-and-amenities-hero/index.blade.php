@php
    /** @var array $data Normalised by App\Content\Sections\ServicesAmenitiesHeroSection */
    $site = config('missionvilla');
    $dock = $data['categories_dock'];
    $actions = $data['actions'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/services-and-amenities-hero.css'])
@endpush
{{--
    SERVICES & AMENITIES SECTION 01 · OPTION A CINEMATIC PHOTO HERO
--}}
<section class="sa-hero" aria-labelledby="sa-hero-heading" data-sa-hero>
    {{-- Full-Bleed Photographic Background Stage --}}
    <div class="sa-hero__backdrop" aria-hidden="true">
        <picture>
            <img
                src="{{ asset('images/suites/community-lounge-facility-899.webp') }}"
                alt=""
                width="899"
                height="600"
                class="sa-hero__bg-img"
                loading="eager"
                fetchpriority="high"
                decoding="async"
            >
        </picture>
        <div class="sa-hero__scrim"></div>
    </div>

    {{-- Top-Right Authentic Facility Provenance Badge --}}
    <div class="sa-hero__provenance" aria-label="Photography authenticity badge">
        <span class="sa-hero__prov-dot" aria-hidden="true"></span>
        <span class="sa-hero__prov-text">MISSION VILLA · COMMUNITY LOUNGE FACILITY PHOTO</span>
    </div>

    <div class="sa-hero__inner">
        {{-- Top Bar: Breadcrumbs --}}
        <div class="sa-hero__topbar">
            <nav aria-label="Breadcrumb" class="sa-hero__breadcrumbs">
                <a href="/" class="sa-hero__crumb">Home</a>
                <span class="sa-hero__crumb-sep" aria-hidden="true">·</span>
                <a href="/life-at-mission-villa" class="sa-hero__crumb">Life at Mission Villa</a>
                <span class="sa-hero__crumb-sep" aria-hidden="true">·</span>
                <span class="sa-hero__crumb sa-hero__crumb--active" aria-current="page">Services &amp; Amenities</span>
            </nav>
            <div class="sa-hero__badge">
                <span>Daly City, CA</span>
                <span class="sa-hero__badge-dot" aria-hidden="true"></span>
                <span>RCFE #415601046</span>
            </div>
        </div>

        {{-- Hero Content Grid --}}
        <div class="sa-hero__content">
            <div class="sa-hero__copy">
                <p class="mv-eyebrow sa-hero__eyebrow">
                    <span class="mv-eyebrow__rule sa-hero__rule" aria-hidden="true"></span>
                    <span>{{ $data['eyebrow'] }}</span>
                </p>

                <h1 id="sa-hero-heading" class="sa-hero__title">
                    {!! $data['heading'] !!}
                </h1>

                <p class="sa-hero__editorial">
                    {{ $data['editorial'] }}
                </p>

                <p class="sa-hero__intro">
                    {{ $data['intro'] }}
                </p>

                {{-- Action Triggers --}}
                <div class="sa-hero__actions">
                    @foreach ($actions as $action)
                        @if ($action['style'] === 'phone')
                            <a
                                href="{{ $site['phone']['href'] }}"
                                class="sa-hero__btn sa-hero__btn--phone"
                            >
                                <svg class="mv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                <span>{{ $action['label'] }}</span>
                            </a>
                        @elseif ($action['style'] === 'primary')
                            <a
                                href="{{ $site['phone']['href'] }}"
                                class="sa-hero__btn sa-hero__btn--primary"
                                data-inquiry="{{ $action['intent'] ?? 'schedule_visit' }}"
                                data-care="{{ $action['care'] ?? 'exploring' }}"
                            >
                                <span>{{ $action['label'] }}</span>
                                <svg class="mv-icon sa-hero__btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </a>
                        @else
                            <a
                                href="{{ $site['phone']['href'] }}"
                                class="sa-hero__btn sa-hero__btn--secondary"
                                data-inquiry="{{ $action['intent'] ?? 'general_inquiry' }}"
                                data-care="{{ $action['care'] ?? 'exploring' }}"
                            >
                                <span>{{ $action['label'] }}</span>
                                <svg class="mv-icon sa-hero__btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Right Column: Asymmetric Dual-Frame Photo Pairing & Archival Ledger --}}
            <div class="sa-hero__media">
                <div class="sa-hero__media-grid">
                    {{-- Frame A: Full-Table Dining Bento --}}
                    <div class="sa-hero__bento">
                        <img
                            src="{{ asset('images/illustrative/hero-life.webp') }}"
                            alt="Illustrative photograph: Restaurant-style dining hospitality at Mission Villa"
                            width="900"
                            height="600"
                            class="sa-hero__bento-img"
                            loading="eager"
                        >
                        <div class="sa-hero__bento-overlay" aria-hidden="true"></div>

                        {{-- Bento Top Header --}}
                        <div class="sa-hero__bento-top">
                            <span class="sa-hero__bento-kicker">01 · Dining &amp; Hospitality</span>
                            <span class="sa-hero__bento-prov">Illustrative photo</span>
                        </div>

                        <div class="sa-hero__bento-caption">
                            <blockquote class="sa-hero__bento-quote">
                                “Chef-prepared meals with full-table service, private family dining, and tailored dietary options.”
                            </blockquote>
                            <p class="sa-hero__bento-note">Illustrative community life photography</p>
                        </div>
                    </div>

                    {{-- Frame B: Botanical Arch Courtyard + Archival Summary Ledger --}}
                    <div class="sa-hero__aside">
                        <div class="sa-hero__arch">
                            <img
                                src="{{ asset('images/property/courtyard-patio.webp') }}"
                                alt="Mission Villa sunny outdoor courtyard with patio tables and garden borders"
                                width="600"
                                height="450"
                                class="sa-hero__arch-img"
                                loading="eager"
                            >
                            <div class="sa-hero__arch-overlay" aria-hidden="true"></div>

                            <div class="sa-hero__arch-top">
                                <span class="sa-hero__arch-prov">Mission Villa photo</span>
                            </div>

                            <div class="sa-hero__arch-caption">
                                <span class="sa-hero__arch-kicker">COURTYARD &amp; PATIO</span>
                                <p class="sa-hero__arch-subtitle">Homelike indoor &amp; outdoor gathering</p>
                            </div>
                        </div>

                        {{-- Archival Summary Ledger Box --}}
                        <div class="sa-hero__ledger">
                            <div class="sa-hero__ledger-top">
                                <span class="sa-hero__ledger-kicker">AT A GLANCE</span>
                                <span class="sa-hero__ledger-count">5 Categories</span>
                            </div>
                            <p class="sa-hero__ledger-title">9 Core Services · 9 Community Amenities</p>
                            <p class="sa-hero__ledger-text">Grounded in Mission Villa’s authentic Daly City offerings at 995 East Market Street.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 5-Category Quick Jump Command Dock Bar --}}
        <div class="sa-hero__dock" id="sa-quick-dock">
            <div class="sa-hero__dock-inner">
                <div class="sa-hero__dock-header">
                    <span class="sa-hero__dock-kicker">DIRECTORY OVERVIEW</span>
                    <h2 class="sa-hero__dock-title">Five Core Pillars of Care &amp; Hospitality</h2>
                </div>
                <div class="sa-hero__dock-grid">
                    @foreach ($dock as $item)
                        <a href="#category-{{ $item['id'] }}" class="sa-hero__dock-card">
                            <span class="sa-hero__dock-idx">{{ $item['index'] }}</span>
                            <div class="sa-hero__dock-label-wrap">
                                <span class="sa-hero__dock-label">{{ $item['label'] }}</span>
                            </div>
                            <svg class="mv-icon sa-hero__dock-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        </div>
    </div>
</section>
