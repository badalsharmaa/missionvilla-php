@php
    /** @var array $data Normalised by App\Content\Sections\ResourcesHeroSection */
    $site = config('missionvilla');
    $pillars = $data['pillars'];
    $quickLinks = $data['quick_links'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/resources-hero.css'])
@endpush
{{--
    RESOURCES SECTION 01 · FULL-BLEED CINEMATIC HERO
    Full-width background image (authentic sitting-nook-detail.webp) with gradient overlay,
    Newsreader title, Plus Jakarta Sans eyebrow with terracotta dot, primary visit CTA,
    phone call link, editorial accuracy pledge, 4-folio docked strip, and 5-section quick jump bar.
--}}
<section class="res-hero" aria-labelledby="resources-hero-heading" id="resources-hero" data-res-hero>
    <div class="res-hero__backdrop" aria-hidden="true">
        <picture>
            <img
                src="{{ asset('images/property/sitting-nook-detail.webp') }}"
                alt=""
                width="1600"
                height="1067"
                class="res-hero__bg-img"
                loading="eager"
                fetchpriority="high"
                decoding="async"
            >
        </picture>
        <div class="res-hero__scrim"></div>
    </div>

    {{-- Top-Right Authentic Property Provenance Badge --}}
    <div class="res-hero__provenance" aria-label="Photography authenticity badge">
        <span class="res-hero__prov-dot" aria-hidden="true"></span>
        <span class="res-hero__prov-text">Mission Villa facility photograph · Daly City, CA</span>
    </div>

    <div class="res-hero__content">
        <div class="res-hero__badge">
            <span class="res-hero__badge-dot" aria-hidden="true"></span>
            <span>{{ $data['eyebrow'] }} · {{ $data['license'] }}</span>
        </div>

        <h1 id="resources-hero-heading" class="res-hero__title">
            {!! $data['heading'] !!}
        </h1>

        <p class="res-hero__editorial">
            Authentic family decision guides, transparent financial worksheets &amp; community resources.
        </p>

        <div class="res-hero__intro">
            {!! $data['lead'] !!}
        </div>

        {{-- Accuracy Commitment Card --}}
        <div class="res-hero__pledge herbarium-mount">
            <div class="res-hero__pledge-header">
                <span class="res-hero__pledge-title">{{ $data['accuracy_commitment']['title'] }}</span>
                <span class="res-hero__pledge-badge">{{ $data['accuracy_commitment']['badge'] }}</span>
            </div>
            <p class="res-hero__pledge-text">{{ $data['accuracy_commitment']['text'] }}</p>
        </div>

        {{-- Action Buttons --}}
        <div class="res-hero__actions">
            @foreach ($data['actions'] as $action)
                @if ($action['style'] === 'primary')
                    <button
                        type="button"
                        class="res-hero__btn res-hero__btn--primary"
                        data-inquiry="{{ $action['intent'] ?? 'schedule_visit' }}"
                        data-inquiry-source="res-hero"
                        data-care="{{ $action['care'] ?? 'exploring' }}"
                    >
                        <svg class="res-hero__btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                            <line x1="16" x2="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" x2="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" x2="21" y1="10" y2="10"/>
                        </svg>
                        <span>{{ $action['label'] }}</span>
                        <span aria-hidden="true" class="res-hero__btn-arrow">→</span>
                    </button>
                @elseif ($action['style'] === 'jump')
                    <a
                        href="#{{ $action['target'] }}"
                        class="res-hero__btn res-hero__btn--secondary"
                    >
                        <svg class="res-hero__btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                        </svg>
                        <span>{{ $action['label'] }}</span>
                    </a>
                @elseif ($action['style'] === 'phone')
                    <a
                        href="tel:16507561995"
                        class="res-hero__btn res-hero__btn--phone"
                        aria-label="Call Mission Villa at {{ $site['phone']['display'] }}"
                    >
                        <svg class="res-hero__btn-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                        <span>{{ $action['label'] }}</span>
                    </a>
                @endif
            @endforeach
        </div>

        {{-- 4-Folio Docked Strip --}}
        <div class="res-hero__strip" role="list">
            @foreach ($pillars as $idx => $pillar)
                <article class="res-hero__folio" data-hero-folio="{{ $pillar['id'] }}" role="listitem">
                    <div class="res-hero__folio-head">
                        <span class="res-hero__folio-code">{{ $pillar['folioCode'] }}</span>
                        <span class="res-hero__folio-badge">{{ $pillar['statusBadge'] }}</span>
                    </div>

                    <h2 class="res-hero__folio-title">{{ $pillar['title'] }}</h2>
                    <p class="res-hero__folio-sub">{{ $pillar['subtitle'] }}</p>

                    <div class="res-hero__folio-action">
                        <a
                            href="{{ $pillar['primaryHref'] }}"
                            class="res-hero__folio-btn"
                        >
                            <span>{{ $pillar['primaryCtaLabel'] }}</span>
                            <svg class="res-hero__arrow-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <line x1="7" y1="17" x2="17" y2="7"/>
                                <polyline points="7 7 17 7 17 17"/>
                            </svg>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        {{-- 5-Section Quick Jump Bar --}}
        <div class="res-hero__quick-bar" aria-label="Quick jump to sections">
            @foreach ($quickLinks as $item)
                <a
                    href="#{{ $item['target'] }}"
                    class="res-hero__quick-card"
                >
                    <div class="res-hero__quick-text">
                        <span class="res-hero__quick-idx">Section {{ $item['index'] }}</span>
                        <span class="res-hero__quick-label">{{ $item['label'] }}</span>
                    </div>
                    <svg class="res-hero__quick-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <line x1="7" y1="17" x2="17" y2="7"/>
                        <polyline points="7 7 17 7 17 17"/>
                    </svg>
                </a>
            @endforeach
        </div>
    </div>
</section>
