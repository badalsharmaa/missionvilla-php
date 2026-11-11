@php
    /** @var array $data Normalised by App\Content\Sections\SuitesFloorPlansHeroSection */
    $site = config('missionvilla');
    $img = $data['image'];
    $actions = $data['actions'];
    $strip = $data['strip'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/suites-floor-plans-hero.css'])
@endpush
{{--
    SUITES & FLOOR PLANS SECTION 01 · CINEMATIC HERO
    Full-width background image with gradient overlay, Newsreader title,
    editorial subhead, primary visit CTA, phone call link, and 3-column feature strip.
--}}
<section class="sfp-hero" aria-labelledby="sfp-hero-heading" data-sfp-hero>
    <div class="sfp-hero__backdrop" aria-hidden="true">
        <picture>
            @if ($img['src_mobile'])
                <source media="(max-width: 640px)" srcset="{{ asset(ltrim($img['src_mobile'], '/')) }}">
            @endif
            <img
                src="{{ asset(ltrim($img['src'], '/')) }}"
                alt=""
                width="{{ $img['width'] }}"
                height="{{ $img['height'] }}"
                class="sfp-hero__bg-img"
                loading="eager"
                fetchpriority="high"
                decoding="async"
            >
        </picture>
        <div class="sfp-hero__scrim"></div>
    </div>

    <div class="sfp-hero__content">
        <div class="sfp-hero__badge">
            <span class="sfp-hero__badge-dot" aria-hidden="true"></span>
            <span>{{ $data['eyebrow'] }}</span>
        </div>

        <h1 id="sfp-hero-heading" class="sfp-hero__title">
            {!! $data['heading'] !!}
        </h1>

        <p class="sfp-hero__editorial">
            {!! $data['editorial'] !!}
        </p>

        <p class="sfp-hero__intro">
            {{ $data['intro'] }}
        </p>

        <div class="sfp-hero__actions">
            @foreach ($actions as $action)
                @if ($action['style'] === 'primary')
                    <button
                        type="button"
                        class="sfp-hero__btn sfp-hero__btn--primary"
                        data-inquiry="{{ $action['intent'] }}"
                        data-inquiry-source="sfp-hero"
                        data-inquiry-care="{{ $action['care'] }}"
                    >
                        <svg class="sfp-hero__btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                            <line x1="16" x2="16" y1="2" y2="6"/>
                            <line x1="8" x2="8" y1="2" y2="6"/>
                            <line x1="3" x2="21" y1="10" y2="10"/>
                        </svg>
                        <span>{{ $action['label'] }}</span>
                    </button>
                @elseif ($action['style'] === 'secondary')
                    <button
                        type="button"
                        class="sfp-hero__btn sfp-hero__btn--secondary"
                        data-inquiry="{{ $action['intent'] }}"
                        data-inquiry-source="sfp-hero"
                        data-inquiry-care="{{ $action['care'] }}"
                    >
                        <span>{{ $action['label'] }}</span>
                        <svg class="sfp-hero__btn-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </button>
                @elseif ($action['style'] === 'phone')
                    <a
                        href="{{ $action['href'] ?? $site['phone']['href'] }}"
                        class="sfp-hero__btn sfp-hero__btn--phone"
                        aria-label="Call Mission Villa at {{ $site['phone']['display'] }}"
                    >
                        <svg class="sfp-hero__btn-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                        <span>{{ $action['label'] }}</span>
                    </a>
                @endif
            @endforeach
        </div>

        @if (!empty($strip))
            <div class="sfp-hero__strip" role="list">
                @foreach ($strip as $item)
                    <div class="sfp-hero__strip-item" role="listitem">
                        <div class="sfp-hero__strip-icon" aria-hidden="true">
                            @if ($item['icon'] === 'bath')
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 6h6"/>
                                    <path d="M7 12h10"/>
                                    <path d="M4 12v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-6"/>
                                    <path d="M6 8a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v4H6Z"/>
                                </svg>
                            @elseif ($item['icon'] === 'sun')
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="4"/>
                                    <path d="M12 2v2"/>
                                    <path d="M12 20v2"/>
                                    <path d="m4.93 4.93 1.41 1.41"/>
                                    <path d="m17.66 17.66 1.41 1.41"/>
                                    <path d="M2 12h2"/>
                                    <path d="M20 12h2"/>
                                    <path d="m6.34 17.66-1.41 1.41"/>
                                    <path d="m19.07 4.93-1.41 1.41"/>
                                </svg>
                            @else
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
                                </svg>
                            @endif
                        </div>
                        <div class="sfp-hero__strip-text">
                            <span class="sfp-hero__strip-kicker">{{ $item['kicker'] }}</span>
                            <span class="sfp-hero__strip-title">{{ $item['title'] }}</span>
                            <span class="sfp-hero__strip-desc">{{ $item['desc'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="sfp-hero__provenance">
        <span class="sfp-hero__provenance-badge">{{ $img['label'] }}</span>
    </div>
</section>
