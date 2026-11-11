@php
    /** @var array $data Normalised by App\Content\Sections\ForFamiliesHeroSection */
    $site = config('missionvilla');
    $pillars = $data['pillars'];
    $actions = $data['actions'];
    $folio = $data['folio'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/for-families-hero.css'])
@endpush
{{--
    FOR FAMILIES SECTION 01 · EMPATHETIC HERO & COMPANION FOLIO
--}}
<section class="ff-hero" aria-labelledby="ff-hero-heading" data-ff-hero id="for-families-hero">
    <div class="ff-hero__inner">
        {{-- Top Bar: Breadcrumbs & Licensing --}}
        <div class="ff-hero__topbar">
            <nav aria-label="Breadcrumb" class="ff-hero__breadcrumbs">
                <a href="/" class="ff-hero__crumb">Home</a>
                <span class="ff-hero__crumb-sep" aria-hidden="true">/</span>
                <span class="ff-hero__crumb ff-hero__crumb--active" aria-current="page">For Families &amp; FAQs</span>
            </nav>
            <div class="ff-hero__badge">
                <span class="ff-hero__badge-label">{{ $data['eyebrow'] }}</span>
                <span class="ff-hero__badge-dot" aria-hidden="true">·</span>
                <span class="ff-hero__badge-license">{{ $data['license'] }}</span>
            </div>
        </div>

        {{-- Center 12-Column Grid --}}
        <div class="ff-hero__grid">
            {{-- Left 6 Columns: Narrative, Pillars & CTAs --}}
            <div class="ff-hero__copy">
                <div class="ff-hero__heading-group">
                    <span class="ff-hero__tagline font-script">{{ $data['tagline'] }}</span>
                    <h1 id="ff-hero-heading" class="ff-hero__title">
                        {!! $data['heading'] !!}
                    </h1>
                    <div class="ff-hero__lead">
                        {!! $data['lead'] !!}
                    </div>
                </div>

                {{-- 3-Column Pillars Strip --}}
                <div class="ff-hero__pillars">
                    @foreach ($pillars as $p)
                        <div class="ff-hero__pillar">
                            <span class="ff-hero__pillar-code">{{ $p['code'] }}</span>
                            <strong class="ff-hero__pillar-title">{{ $p['title'] }}</strong>
                            <span class="ff-hero__pillar-summary">{{ $p['summary'] }}</span>
                        </div>
                    @endforeach
                </div>

                {{-- Actions --}}
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
                                <svg class="ff-hero__btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                    <line x1="16" y1="2" x2="16" y2="6"/>
                                    <line x1="8" y1="2" x2="8" y2="6"/>
                                    <line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                                <span>{{ $action['label'] }}</span>
                            </button>
                        @elseif ($action['style'] === 'jump')
                            <a
                                href="#{{ $action['target'] }}"
                                class="ff-hero__btn ff-hero__btn--jump"
                            >
                                <span>{{ $action['label'] }}</span>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Right 6 Columns: Family Companion Folio & Quick Index --}}
            <div class="ff-hero__visuals">
                <div class="ff-hero__folio herbarium-mount">
                    <div class="ff-hero__folio-header">
                        <div class="ff-hero__folio-titles">
                            <span class="ff-hero__folio-eyebrow">{{ $folio['eyebrow'] }}</span>
                            <h2 class="ff-hero__folio-heading">{{ $folio['title'] }}</h2>
                        </div>
                        <a href="{{ $site['phone']['href'] }}" class="ff-hero__folio-phone">
                            <svg class="ff-hero__folio-phone-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                            </svg>
                            <span>{{ $site['phone']['display'] }}</span>
                        </a>
                    </div>

                    {{-- Property Photo Plate --}}
                    <div class="ff-hero__folio-media">
                        <img
                            src="{{ $folio['image']['src'] }}"
                            width="{{ $folio['image']['width'] }}"
                            height="{{ $folio['image']['height'] }}"
                            alt="{{ $folio['image']['alt'] }}"
                            loading="eager"
                            class="ff-hero__folio-img"
                        >
                        <div class="ff-hero__folio-scrim" aria-hidden="true"></div>
                        <div class="ff-hero__folio-caption-box">
                            <span class="ff-hero__folio-tag">{{ $folio['caption'] }}</span>
                            <p class="ff-hero__folio-quote">“{{ $folio['quote'] }}”</p>
                        </div>
                    </div>

                    {{-- Quick Jump Index Rows --}}
                    <div class="ff-hero__folio-index">
                        @foreach ($folio['items'] as $item)
                            <a href="#{{ $item['target'] }}" class="ff-hero__folio-row">
                                <div class="ff-hero__folio-row-main">
                                    <span class="ff-hero__folio-num">{{ $item['code'] }}.</span>
                                    <div class="ff-hero__folio-texts">
                                        <span class="ff-hero__folio-title">{{ $item['title'] }}</span>
                                        <span class="ff-hero__folio-meta">{{ $item['meta'] }}</span>
                                    </div>
                                </div>
                                <svg class="ff-hero__folio-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <line x1="7" y1="17" x2="17" y2="7"/>
                                    <polyline points="7 7 17 7 17 17"/>
                                </svg>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom Transparency Strip --}}
        <div class="ff-hero__footer">
            <span>{{ $data['transparency_note'] }}</span>
        </div>
    </div>
</section>
