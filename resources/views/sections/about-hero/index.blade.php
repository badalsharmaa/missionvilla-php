@php
    /** @var array $data Normalised by App\Content\Sections\AboutHeroSection */
    $site = config('missionvilla');
    $trustLedger = $data['trust_ledger'];
    $jumpLinks = $data['jump_links'];
    $actions = $data['actions'];
    $portrait = $data['portrait_card'];
    $geography = $data['geography_card'];
    $quoteCard = $data['family_quote_card'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/about-hero.css'])
@endpush
{{--
    ABOUT SECTION 01 · COMMUNITY MONOGRAPH HERO
--}}
<section class="about-hero" aria-labelledby="about-hero-heading" data-about-hero id="about-hero">
    <div class="about-hero__glow" aria-hidden="true"></div>
    <div class="about-hero__inner">
        {{-- Top Bar: Breadcrumbs & Licensing --}}
        <div class="about-hero__topbar">
            <nav aria-label="Breadcrumb" class="about-hero__breadcrumbs">
                <a href="/" class="about-hero__crumb">Home</a>
                <span class="about-hero__crumb-sep" aria-hidden="true">/</span>
                <span class="about-hero__crumb about-hero__crumb--active" aria-current="page">About Us</span>
            </nav>
            <div class="about-hero__badge">
                <span class="about-hero__badge-label">{{ $data['eyebrow'] }}</span>
                <span class="about-hero__badge-dot" aria-hidden="true">·</span>
                <span class="about-hero__badge-license">{{ $data['license'] }}</span>
            </div>
        </div>

        {{-- Center 12-Column Asymmetric Composition --}}
        <div class="about-hero__grid">
            {{-- Left Column: Mission Statement, Trust Ledger, and Conversion CTAs --}}
            <div class="about-hero__copy">
                <div class="about-hero__heading-group">
                    <span class="about-hero__tagline font-script">{{ $data['tagline'] }}</span>
                    <h1 id="about-hero-heading" class="about-hero__title">
                        {!! $data['heading'] !!}
                    </h1>
                    <div class="about-hero__lead">
                        {!! $data['lead'] !!}
                    </div>
                </div>

                {{-- Unboxed Editorial Trust Ledger (3 Columns) --}}
                <div class="about-hero__ledger">
                    @foreach ($trustLedger as $item)
                        <div class="about-hero__ledger-item">
                            <span class="about-hero__ledger-code">{{ $item['code'] }}</span>
                            <strong class="about-hero__ledger-title">{{ $item['title'] }}</strong>
                            <span class="about-hero__ledger-summary">{{ $item['summary'] }}</span>
                        </div>
                    @endforeach
                </div>

                {{-- In-Page Jump Anchors --}}
                <div class="about-hero__nav">
                    <span class="about-hero__nav-label">On This Page:</span>
                    <div class="about-hero__nav-links">
                        @foreach ($jumpLinks as $idx => $link)
                            @if ($idx > 0)
                                <span class="about-hero__nav-sep" aria-hidden="true">·</span>
                            @endif
                            <a href="#{{ $link['id'] }}" class="about-hero__nav-link">{{ $link['label'] }}</a>
                        @endforeach
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="about-hero__actions">
                    @foreach ($actions as $action)
                        @if ($action['style'] === 'phone')
                            <a
                                href="{{ $site['phone']['href'] }}"
                                class="about-hero__btn about-hero__btn--phone"
                            >
                                <svg class="about-hero__btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                </svg>
                                <span>{{ $site['phone']['display'] }}</span>
                            </a>
                        @elseif ($action['style'] === 'secondary')
                            <a
                                href="{{ $action['href'] ?? '#care-philosophy-narrative' }}"
                                class="about-hero__btn about-hero__btn--secondary"
                            >
                                <svg class="about-hero__btn-icon text-cognac" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                                </svg>
                                <span>{{ $action['label'] }}</span>
                            </a>
                        @else
                            <button
                                type="button"
                                class="about-hero__btn about-hero__btn--primary"
                                data-inquiry="{{ $action['intent'] ?? 'schedule_visit' }}"
                                data-inquiry-source="about-hero"
                                data-care="{{ $action['care'] ?? 'exploring' }}"
                            >
                                <svg class="about-hero__btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                    <line x1="16" y1="2" x2="16" y2="6"/>
                                    <line x1="8" y1="2" x2="8" y2="6"/>
                                    <line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                                <span>{{ $action['label'] }}</span>
                            </button>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Right Column: Arched Portrait-Led Study & Local Inset Cards --}}
            <div class="about-hero__visuals">
                {{-- Arched Study Plate --}}
                <div class="about-hero__portrait">
                    <img
                        src="{{ $portrait['image']['src'] }}"
                        width="{{ $portrait['image']['width'] }}"
                        height="{{ $portrait['image']['height'] }}"
                        alt="{{ $portrait['image']['alt'] }}"
                        loading="eager"
                        class="about-hero__portrait-img"
                    >
                    <div class="about-hero__portrait-scrim" aria-hidden="true"></div>

                    <div class="about-hero__portrait-badge">
                        <span>{{ $portrait['cutout_label'] }}</span>
                    </div>

                    <div class="about-hero__portrait-content">
                        <span class="about-hero__portrait-kicker">{{ $portrait['kicker'] }}</span>
                        <h2 class="about-hero__portrait-title">{{ $portrait['title'] }}</h2>
                        <p class="about-hero__portrait-text">{{ $portrait['text'] }}</p>
                        <span class="about-hero__portrait-caption">{{ $portrait['caption'] }}</span>
                    </div>
                </div>

                {{-- Right Stack Cards --}}
                <div class="about-hero__stack">
                    {{-- Local Geography Context Card --}}
                    <div class="about-hero__card about-hero__card--geo">
                        <img
                            src="{{ $geography['image']['src'] }}"
                            width="{{ $geography['image']['width'] }}"
                            height="{{ $geography['image']['height'] }}"
                            alt="{{ $geography['image']['alt'] }}"
                            loading="lazy"
                            class="about-hero__card-img"
                        >
                        <div class="about-hero__card-scrim" aria-hidden="true"></div>

                        <div class="about-hero__card-top">
                            <span class="about-hero__card-kicker">{{ $geography['kicker'] }}</span>
                            <svg class="about-hero__card-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                        </div>

                        <div class="about-hero__card-bottom">
                            <h3 class="about-hero__card-title">{{ $geography['title'] }}</h3>
                            <p class="about-hero__card-text">{{ $geography['text'] }}</p>
                            <a href="#{{ $geography['link_anchor'] }}" class="about-hero__card-link">
                                <span>{{ $geography['link_label'] }}</span>
                                <svg class="about-hero__card-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <line x1="7" y1="17" x2="17" y2="7"/>
                                    <polyline points="7 7 17 7 17 17"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    {{-- Family Reassurance Herbarium Card --}}
                    <div class="about-hero__card about-hero__card--quote herbarium-mount">
                        <div class="about-hero__quote-top">
                            <span class="about-hero__quote-kicker">{{ $quoteCard['kicker'] }}</span>
                            <svg class="about-hero__quote-heart" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                            </svg>
                        </div>
                        <p class="about-hero__quote-body">
                            “{{ $quoteCard['quote'] }}”
                        </p>
                        <div class="about-hero__quote-footer">
                            <span>{{ $quoteCard['service'] }}</span>
                            <span aria-hidden="true">·</span>
                            <span>{{ $quoteCard['location'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom Fact & Transparency Strip --}}
        <div class="about-hero__footer">
            <div class="about-hero__footer-note">
                <svg class="about-hero__footer-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="16" x2="12" y2="12"/>
                    <line x1="12" y1="8" x2="12.01" y2="8"/>
                </svg>
                <span><strong>Authenticity Notice:</strong> {!! $data['transparency_note'] !!}</span>
            </div>
            <div class="about-hero__footer-links">
                <a href="/memory-care" class="about-hero__footer-link">Legacies™ Memory Care →</a>
                <span class="about-hero__footer-sep" aria-hidden="true">·</span>
                <a href="/respite-care" class="about-hero__footer-link">Respite Care →</a>
            </div>
        </div>
    </div>
</section>
