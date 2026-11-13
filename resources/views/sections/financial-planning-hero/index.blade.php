@php
    /** @var array $data Normalised by App\Content\Sections\FinancialPlanningHeroSection */
    $site = config('missionvilla');
    $pillars = $data['pillars'];
    $actions = $data['actions'];
    $folio = $data['folio'];
    $img = $folio['image'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/financial-planning-hero.css'])
@endpush
{{--
    FINANCIAL PLANNING SECTION 01 · FULL-BLEED CINEMATIC HERO
    Full-width background image with gradient overlay, Newsreader title,
    Plus Jakarta Sans eyebrow with terracotta dot, primary visit CTA, phone call link,
    and 3-column docked feature strip.
--}}
<section class="fp-hero" aria-labelledby="fp-hero-heading" id="financial-planning-hero" data-fp-hero>
    <div class="fp-hero__backdrop" aria-hidden="true">
        <picture>
            <img
                src="{{ asset(ltrim($img['src'], '/')) }}"
                alt=""
                width="{{ $img['width'] }}"
                height="{{ $img['height'] }}"
                class="fp-hero__bg-img"
                loading="eager"
                fetchpriority="high"
                decoding="async"
            >
        </picture>
        <div class="fp-hero__scrim"></div>
    </div>

    <div class="fp-hero__content">
        <div class="fp-hero__badge">
            <span class="fp-hero__badge-dot" aria-hidden="true"></span>
            <span>{{ $data['tagline'] }} · {{ $data['license'] }}</span>
        </div>

        <h1 id="fp-hero-heading" class="fp-hero__title">
            {!! $data['heading'] !!}
        </h1>

        <p class="fp-hero__editorial">
            Transparent pricing grounded in personal care assessments—never generic online calculators.
        </p>

        <p class="fp-hero__intro">
            {{ strip_tags($data['lead']) }}
        </p>

        <div class="fp-hero__actions">
            @foreach ($actions as $action)
                @if ($action['style'] === 'primary')
                    <button
                        type="button"
                        class="fp-hero__btn fp-hero__btn--primary"
                        data-inquiry="{{ $action['intent'] ?? 'schedule_visit' }}"
                        data-inquiry-source="fp-hero"
                        data-care="{{ $action['care'] ?? 'memory_care' }}"
                        data-note="Interested in financial planning and care assessment consultation"
                    >
                        <svg class="fp-hero__btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                            <line x1="16" x2="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" x2="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" x2="21" y1="10" y2="10"/>
                        </svg>
                        <span>{{ $action['label'] }}</span>
                    </button>
                @else
                    <a
                        href="#{{ $action['target'] }}"
                        class="fp-hero__btn fp-hero__btn--secondary"
                    >
                        <span>{{ $action['label'] }}</span>
                    </a>
                @endif
            @endforeach
            <a
                href="{{ $site['phone']['href'] }}"
                class="fp-hero__btn fp-hero__btn--phone"
                aria-label="Call Mission Villa at {{ $site['phone']['display'] }}"
            >
                <svg class="fp-hero__btn-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                </svg>
                <span>{{ $site['phone']['display'] }}</span>
            </a>
        </div>

        @if (!empty($pillars))
            <div class="fp-hero__strip" role="list">
                @foreach ($pillars as $idx => $pillar)
                    <div class="fp-hero__strip-item" role="listitem">
                        <div class="fp-hero__strip-icon" aria-hidden="true">
                            @if ($idx === 0)
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                    <line x1="16" y1="13" x2="8" y2="13"/>
                                    <line x1="16" y1="17" x2="8" y2="17"/>
                                    <polyline points="10 9 9 9 8 9"/>
                                </svg>
                            @elseif ($idx === 1)
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="18" height="18" x="3" y="3" rx="2"/>
                                    <path d="m9 12 2 2 4-4"/>
                                </svg>
                            @else
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="16" height="20" x="4" y="2" rx="2"/>
                                    <line x1="8" x2="16" y1="6" y2="6"/>
                                    <line x1="16" x2="16" y1="14" y2="18"/>
                                    <path d="M16 10h.01"/>
                                    <path d="M12 10h.01"/>
                                    <path d="M8 10h.01"/>
                                    <path d="M12 14h.01"/>
                                    <path d="M8 14h.01"/>
                                    <path d="M12 18h.01"/>
                                    <path d="M8 18h.01"/>
                                </svg>
                            @endif
                        </div>
                        <div class="fp-hero__strip-text">
                            <span class="fp-hero__strip-kicker">{{ $pillar['code'] }}</span>
                            <span class="fp-hero__strip-title">{{ $pillar['title'] }}</span>
                            <span class="fp-hero__strip-desc">{{ $pillar['summary'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="fp-hero__provenance">
        <span class="fp-hero__provenance-badge">Mission Villa facility photograph · Daly City, CA</span>
    </div>
</section>
