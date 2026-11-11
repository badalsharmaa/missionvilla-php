@php
    /** @var array $data Normalised by App\Content\Sections\ResourcesHeroSection */
    $site = config('missionvilla');
    $pillars = $data['pillars'];
    $quickLinks = $data['quick_links'];
@endphp
@push('section-assets')
    <link href="https://fonts.googleapis.com/css2?family=Allura&display=swap" rel="stylesheet">
    @vite(['resources/css/sections/resources-hero.css'])
@endpush
{{--
    RESOURCES SECTION 01 · ARCHIVAL READING ROOM & FAMILY REFERENCE LIBRARY HERO
--}}
<section class="res-hero" aria-labelledby="resources-hero-heading" id="resources-hero" data-res-hero>
    <div class="res-hero__glow" aria-hidden="true"></div>
    <div class="res-hero__inner">
        {{-- Breadcrumb & Identity Bar --}}
        <div class="res-hero__top-bar">
            <nav aria-label="Breadcrumb" class="res-hero__breadcrumbs">
                <a href="{{ url('/') }}" class="res-hero__bc-link">Home</a>
                <span aria-hidden="true" class="res-hero__bc-sep">/</span>
                <span class="res-hero__bc-current" aria-current="page">Resources Overview</span>
            </nav>

            <div class="res-hero__identity">
                <span class="res-hero__badge-license">
                    <svg class="res-hero__shield-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        <path d="m9 12 2 2 4-4"/>
                    </svg>
                    <span>{{ $data['license'] }}</span>
                </span>
                <span aria-hidden="true" class="res-hero__dot">·</span>
                <span class="res-hero__address">{{ $data['address'] }}</span>
            </div>
        </div>

        {{-- 12-Column Hero Split --}}
        <div class="res-hero__grid">
            {{-- Left 6 Columns: Introduction & CTAs --}}
            <div class="res-hero__story">
                <div class="res-hero__header">
                    <span class="res-hero__kicker font-script">{{ $data['eyebrow'] }}</span>
                    <h1 id="resources-hero-heading" class="res-hero__title">
                        {!! $data['heading'] !!}
                    </h1>
                    <div class="res-hero__lead">
                        {!! $data['lead'] !!}
                    </div>
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
                                <svg class="res-hero__btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                    <line x1="16" y1="2" x2="16" y2="6"/>
                                    <line x1="8" y1="2" x2="8" y2="6"/>
                                    <line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                                <span>{{ $action['label'] }}</span>
                                <span aria-hidden="true" class="res-hero__btn-arrow">→</span>
                            </button>
                        @elseif ($action['style'] === 'jump')
                            <a
                                href="#{{ $action['target'] }}"
                                class="res-hero__btn res-hero__btn--secondary"
                            >
                                <svg class="res-hero__btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                                </svg>
                                <span>{{ $action['label'] }}</span>
                            </a>
                        @elseif ($action['style'] === 'phone')
                            <a
                                href="tel:16507561995"
                                class="res-hero__btn res-hero__btn--phone"
                            >
                                <svg class="res-hero__btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                </svg>
                                <span>{{ $action['label'] }}</span>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Right 6 Columns: 4-Folio Catalogue Grid --}}
            <div class="res-hero__folios">
                @foreach ($pillars as $idx => $pillar)
                    @php
                        $isDark = ($idx === 0 || $idx === 3);
                        $isAnchor = str_starts_with($pillar['primaryHref'], '#');
                    @endphp
                    <article class="res-hero__folio {{ $isDark ? 'res-hero__folio--dark' : 'res-hero__folio--light' }}" data-hero-folio="{{ $pillar['id'] }}">
                        <div class="res-hero__folio-head">
                            <span class="res-hero__folio-code">{{ $pillar['folioCode'] }}</span>
                            <span class="res-hero__folio-badge">{{ $pillar['statusBadge'] }}</span>
                        </div>

                        <h2 class="res-hero__folio-title">{{ $pillar['title'] }}</h2>
                        <p class="res-hero__folio-sub">{{ $pillar['subtitle'] }}</p>

                        <div class="res-hero__folio-action">
                            @if ($isAnchor)
                                <a
                                    href="{{ $pillar['primaryHref'] }}"
                                    class="res-hero__folio-btn {{ $isDark ? 'res-hero__folio-btn--gold' : 'res-hero__folio-btn--plum' }}"
                                >
                                    <span>{{ $pillar['primaryCtaLabel'] }}</span>
                                    <svg class="res-hero__arrow-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <line x1="7" y1="17" x2="17" y2="7"/>
                                        <polyline points="7 7 17 7 17 17"/>
                                    </svg>
                                </a>
                            @else
                                <a
                                    href="{{ $pillar['primaryHref'] }}"
                                    class="res-hero__folio-btn {{ $isDark ? 'res-hero__folio-btn--gold' : 'res-hero__folio-btn--plum' }}"
                                >
                                    <span>{{ $pillar['primaryCtaLabel'] }}</span>
                                    <svg class="res-hero__arrow-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <line x1="7" y1="17" x2="17" y2="7"/>
                                        <polyline points="7 7 17 7 17 17"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        </div>

        {{-- 5-Section Quick Jump Bar --}}
        <div class="res-hero__quick-bar">
            @foreach ($quickLinks as $item)
                <a
                    href="#{{ $item['target'] }}"
                    class="res-hero__quick-card"
                >
                    <div class="res-hero__quick-text">
                        <span class="res-hero__quick-idx">Section {{ $item['index'] }}</span>
                        <span class="res-hero__quick-label">{{ $item['label'] }}</span>
                    </div>
                    <svg class="res-hero__quick-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <line x1="7" y1="17" x2="17" y2="7"/>
                        <polyline points="7 7 17 7 17 17"/>
                    </svg>
                </a>
            @endforeach
        </div>
    </div>
</section>
