@php
    /** @var array $data Normalised by App\Content\Sections\ForFamiliesHeroSection */
    $site = config('missionvilla');
    $pillars = $data['pillars'];
    $actions = $data['actions'];
    $folio = $data['folio'];
    $img = $folio['image'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/for-families-hero.css'])
@endpush
{{--
    FOR FAMILIES SECTION 01 · FULL-BLEED CINEMATIC HERO
    Full-width background image with gradient overlay, Newsreader title,
    Plus Jakarta Sans eyebrow with terracotta dot, primary visit CTA, phone call link,
    and 3-column docked feature strip.
--}}
<section class="ff-hero" aria-labelledby="ff-hero-heading" data-ff-hero id="for-families-hero">
    <div class="ff-hero__backdrop" aria-hidden="true">
        <picture>
            <img
                src="{{ asset(ltrim($img['src'], '/')) }}"
                alt=""
                width="{{ $img['width'] }}"
                height="{{ $img['height'] }}"
                class="ff-hero__bg-img"
                loading="eager"
                fetchpriority="high"
                decoding="async"
            >
        </picture>
        <div class="ff-hero__scrim"></div>
    </div>

    <div class="ff-hero__content">
        <div class="ff-hero__badge">
            <span class="ff-hero__badge-dot" aria-hidden="true"></span>
            <span>{{ $data['tagline'] }} · {{ $data['license'] }}</span>
        </div>

        <h1 id="ff-hero-heading" class="ff-hero__title">
            {!! $data['heading'] !!}
        </h1>

        <p class="ff-hero__editorial">
            Guidance on memory support, tour questions, and daily community life in Daly City.
        </p>

        <p class="ff-hero__intro">
            {{ strip_tags($data['lead']) }}
        </p>

        <div class="ff-hero__actions">
            @foreach ($actions as $action)
                @if ($action['style'] === 'primary')
                    <button
                        type="button"
                        class="ff-hero__btn ff-hero__btn--primary"
                        data-inquiry="{{ $action['intent'] ?? 'schedule_visit' }}"
                        data-inquiry-source="ff-hero"
                        data-care="{{ $action['care'] ?? 'memory_care' }}"
                    >
                        <svg class="ff-hero__btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                            <line x1="16" x2="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" x2="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" x2="21" y1="10" y2="10"/>
                        </svg>
                        <span>{{ $action['label'] }}</span>
                    </button>
                @elseif ($action['style'] === 'jump')
                    <a
                        href="#{{ $action['target'] }}"
                        class="ff-hero__btn ff-hero__btn--secondary"
                    >
                        <span>{{ $action['label'] }}</span>
                    </a>
                @endif
            @endforeach
            <a
                href="{{ $site['phone']['href'] }}"
                class="ff-hero__btn ff-hero__btn--phone"
                aria-label="Call Mission Villa at {{ $site['phone']['display'] }}"
            >
                <svg class="ff-hero__btn-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                </svg>
                <span>{{ $site['phone']['display'] }}</span>
            </a>
        </div>

        @if (!empty($pillars))
            <div class="ff-hero__strip" role="list">
                @foreach ($pillars as $idx => $p)
                    <div class="ff-hero__strip-item" role="listitem">
                        <div class="ff-hero__strip-icon" aria-hidden="true">
                            @if ($idx === 0)
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/>
                                </svg>
                            @elseif ($idx === 1)
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
                                    <rect x="8" y="2" width="8" height="4" rx="1" ry="1"/>
                                </svg>
                            @else
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                                    <line x1="12" y1="17" x2="12.01" y2="17"/>
                                </svg>
                            @endif
                        </div>
                        <div class="ff-hero__strip-text">
                            <span class="ff-hero__strip-kicker">{{ $p['code'] }}</span>
                            <span class="ff-hero__strip-title">{{ $p['title'] }}</span>
                            <span class="ff-hero__strip-desc">{{ $p['summary'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="ff-hero__provenance">
        <span class="ff-hero__provenance-badge">Mission Villa facility photograph · Daly City, CA</span>
    </div>
</section>
