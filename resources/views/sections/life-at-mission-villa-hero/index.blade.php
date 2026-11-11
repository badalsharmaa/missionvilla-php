@php
    /** @var array $data Normalised by App\Content\Sections\LifeAtMissionVillaHeroSection */
    $site = config('missionvilla');
    $img = $data['image'];
    $actions = $data['actions'];
    $strip = $data['strip'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/life-at-mission-villa-hero.css'])
@endpush
{{--
    LIFE AT MISSION VILLA SECTION 01 · CINEMATIC HERO
--}}
<section class="lmv-hero" aria-labelledby="lmv-hero-heading" data-lmv-hero>
    <div class="lmv-hero__backdrop" aria-hidden="true">
        <picture>
            @if ($img['src_mobile'])
                <source media="(max-width: 640px)" srcset="{{ asset(ltrim($img['src_mobile'], '/')) }}">
            @endif
            <img
                src="{{ asset(ltrim($img['src'], '/')) }}"
                alt=""
                width="{{ $img['width'] }}"
                height="{{ $img['height'] }}"
                class="lmv-hero__bg-img"
                loading="eager"
                fetchpriority="high"
                decoding="async"
            >
        </picture>
        <div class="lmv-hero__scrim"></div>
    </div>

    <div class="lmv-hero__content">
        <div class="lmv-hero__badge">
            <span class="lmv-hero__badge-dot" aria-hidden="true"></span>
            <span>{{ $data['eyebrow'] }}</span>
        </div>

        <h1 id="lmv-hero-heading" class="lmv-hero__title">
            {!! $data['heading'] !!}
        </h1>

        <p class="lmv-hero__editorial">
            {!! $data['editorial'] !!}
        </p>

        <p class="lmv-hero__intro">
            {{ $data['intro'] }}
        </p>

        <div class="lmv-hero__actions">
            @foreach ($actions as $action)
                @if ($action['style'] === 'primary')
                    <button
                        type="button"
                        class="lmv-hero__btn lmv-hero__btn--primary"
                        data-inquiry="{{ $action['intent'] }}"
                        data-inquiry-source="lmv-hero"
                        data-inquiry-care="{{ $action['care'] }}"
                    >
                        <svg class="lmv-hero__btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="2" x2="21" y2="10"/>
                        </svg>
                        <span>{{ $action['label'] }}</span>
                    </button>
                @elseif ($action['style'] === 'secondary')
                    <button
                        type="button"
                        class="lmv-hero__btn lmv-hero__btn--secondary"
                        data-inquiry="{{ $action['intent'] }}"
                        data-inquiry-source="lmv-hero"
                        data-inquiry-care="{{ $action['care'] }}"
                    >
                        <span>{{ $action['label'] }}</span>
                        <svg class="lmv-hero__btn-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </button>
                @elseif ($action['style'] === 'phone')
                    <a
                        href="{{ $action['href'] ?? $site['phone']['href'] }}"
                        class="lmv-hero__btn lmv-hero__btn--phone"
                        aria-label="Call Mission Villa at {{ $site['phone']['display'] }}"
                    >
                        <svg class="lmv-hero__btn-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                        <span>{{ $action['label'] }}</span>
                    </a>
                @endif
            @endforeach
        </div>

        @if (!empty($strip))
            <div class="lmv-hero__strip" role="list">
                @foreach ($strip as $item)
                    <div class="lmv-hero__strip-item" role="listitem">
                        <div class="lmv-hero__strip-icon" aria-hidden="true">
                            @if ($item['icon'] === 'utensils')
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M18 2v6a3 3 0 0 1-3 3 3 3 0 0 1-3-3V2"/>
                                    <path d="M15 2v19"/>
                                    <path d="M6 2v7a3 3 0 0 0 6 0V2"/>
                                </svg>
                            @elseif ($item['icon'] === 'sparkles')
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/>
                                </svg>
                            @else
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
                                </svg>
                            @endif
                        </div>
                        <div class="lmv-hero__strip-text">
                            <span class="lmv-hero__strip-kicker">{{ $item['kicker'] }}</span>
                            <span class="lmv-hero__strip-title">{{ $item['title'] }}</span>
                            <span class="lmv-hero__strip-desc">{{ $item['desc'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="lmv-hero__provenance">
        <span class="lmv-hero__provenance-badge">{{ $img['label'] }}</span>
    </div>
</section>
