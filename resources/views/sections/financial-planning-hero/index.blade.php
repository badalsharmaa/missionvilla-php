@php
    /** @var array $data Normalised by App\Content\Sections\FinancialPlanningHeroSection */
    $site = config('missionvilla');
    $folio = $data['folio'];
@endphp
@push('section-assets')
    <link href="https://fonts.googleapis.com/css2?family=Allura&display=swap" rel="stylesheet">
    @vite(['resources/css/sections/financial-planning-hero.css'])
@endpush
{{--
    FINANCIAL PLANNING SECTION 01 · COST CLARITY HERO & TRUST LEDGER
--}}
<section class="fp-hero" aria-labelledby="fp-hero-heading" id="financial-planning-hero" data-fp-hero>
    <div class="fp-hero__glow" aria-hidden="true"></div>
    <div class="fp-hero__inner">
        {{-- Top Badges --}}
        <div class="fp-hero__badge-row">
            <span class="fp-hero__kicker font-script">{{ $data['eyebrow'] }}</span>
            <span class="fp-hero__badge-license">{{ $data['license'] }}</span>
        </div>

        {{-- Main 12-Column Grid --}}
        <div class="fp-hero__grid">
            {{-- Left 7 Columns: Editorial Story --}}
            <div class="fp-hero__story">
                <span class="fp-hero__tagline">{{ $data['tagline'] }}</span>
                <h1 id="fp-hero-heading" class="fp-hero__title">
                    {!! $data['heading'] !!}
                </h1>
                <div class="fp-hero__lead">
                    {!! $data['lead'] !!}
                </div>

                {{-- 3 Pillars Grid --}}
                <div class="fp-hero__pillars">
                    @foreach ($data['pillars'] as $pillar)
                        <div class="fp-hero__pillar herbarium-mount">
                            <span class="fp-hero__pillar-code">{{ $pillar['code'] }}</span>
                            <h2 class="fp-hero__pillar-title">{{ $pillar['title'] }}</h2>
                            <p class="fp-hero__pillar-summary">{{ $pillar['summary'] }}</p>
                        </div>
                    @endforeach
                </div>

                {{-- Action Buttons --}}
                <div class="fp-hero__actions">
                    @foreach ($data['actions'] as $action)
                        @if ($action['style'] === 'primary')
                            <button
                                type="button"
                                class="fp-hero__btn fp-hero__btn--primary"
                                data-inquiry="{{ $action['intent'] ?? 'schedule_visit' }}"
                                data-inquiry-source="fp-hero"
                                data-care="{{ $action['care'] ?? 'memory_care' }}"
                                data-note="Interested in financial planning and care assessment consultation"
                            >
                                <svg class="fp-hero__btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                    <line x1="16" y1="2" x2="16" y2="6"/>
                                    <line x1="8" y1="2" x2="8" y2="6"/>
                                    <line x1="3" y1="10" x2="21" y2="10"/>
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
                </div>
            </div>

            {{-- Right 5 Columns: Archival Trust Ledger Folio --}}
            <div class="fp-hero__folio herbarium-mount">
                <div class="fp-hero__folio-media">
                    <img
                        src="{{ $folio['image']['src'] }}"
                        width="{{ $folio['image']['width'] }}"
                        height="{{ $folio['image']['height'] }}"
                        alt="{{ $folio['image']['alt'] }}"
                        fetchpriority="high"
                        class="fp-hero__folio-img"
                    >
                    <div class="fp-hero__folio-scrim" aria-hidden="true"></div>
                    <div class="fp-hero__folio-badge">
                        <span>{{ $folio['caption'] }}</span>
                    </div>
                </div>

                <div class="fp-hero__folio-body">
                    <div class="fp-hero__folio-header">
                        <span class="fp-hero__folio-kicker">{{ $folio['eyebrow'] }}</span>
                        <h2 class="fp-hero__folio-title">{{ $folio['title'] }}</h2>
                        <p class="fp-hero__folio-quote">“{{ $folio['quote'] }}”</p>
                    </div>

                    <div class="fp-hero__folio-list">
                        @foreach ($folio['items'] as $item)
                            <a href="#{{ $item['target'] }}" class="fp-hero__folio-item">
                                <span class="fp-hero__folio-code">{{ $item['code'] }}</span>
                                <div class="fp-hero__folio-item-copy">
                                    <span class="fp-hero__folio-item-title">{{ $item['title'] }}</span>
                                    <span class="fp-hero__folio-item-meta">{{ $item['meta'] }}</span>
                                </div>
                                <svg class="fp-hero__folio-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                    <line x1="7" y1="17" x2="17" y2="7"/>
                                    <polyline points="7 7 17 7 17 17"/>
                                </svg>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Transparency Footer Note --}}
        <div class="fp-hero__transparency">
            <svg class="fp-hero__transparency-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="16" x2="12" y2="12"/>
                <line x1="12" y1="8" x2="12.01" y2="8"/>
            </svg>
            <p>{{ $data['transparency_note'] }}</p>
        </div>
    </div>
</section>
