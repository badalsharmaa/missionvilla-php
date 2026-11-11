@php
    /** @var array $data Normalised by App\Content\Sections\SuitesFloorPlansDiagramSection */
    $diagram = $data['diagram'];
    $highlights = $data['highlights'];
    $disclosure = $data['disclosure'];
    $action = $data['action'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/suites-floor-plans-diagram.css'])
@endpush
{{--
    SUITES & FLOOR PLANS SECTION 03 · AUTHENTIC DIAGRAM & TRANSPARENCY
    Warm cream section highlighting the authentic Companion Unit diagram,
    spatial layout highlights, and our honest policy on tour inspections.
--}}
<section class="sfp-diagram" id="floor-plans" aria-labelledby="sfp-diagram-title" data-sfp-diagram>
    <div class="sfp-diagram__inner">
        <div class="sfp-diagram__head">
            <p class="mv-eyebrow sfp-diagram__eyebrow">
                <span class="mv-eyebrow__rule sfp-diagram__rule" aria-hidden="true"></span>
                <span>{{ $data['eyebrow'] }}</span>
            </p>
            <h2 id="sfp-diagram-title" class="mv-title sfp-diagram__title">
                {!! $data['heading'] !!}
            </h2>
            <p class="sfp-diagram__intro">
                {{ $data['intro'] }}
            </p>
        </div>

        <div class="sfp-diagram__content-grid">
            {{-- Left column: High-resolution official floor plan diagram --}}
            <div class="sfp-diagram__media-col">
                <div class="sfp-diagram__frame">
                    <div class="sfp-diagram__badge-bar">
                        <span class="sfp-diagram__badge">{{ $diagram['badge'] }}</span>
                    </div>
                    <img
                        src="{{ asset(ltrim($diagram['image']['src'], '/')) }}"
                        alt="{{ $diagram['image']['alt'] }}"
                        width="{{ $diagram['image']['width'] }}"
                        height="{{ $diagram['image']['height'] }}"
                        class="sfp-diagram__img"
                        loading="lazy"
                        decoding="async"
                    >
                    <div class="sfp-diagram__caption">
                        <span>{{ $diagram['image']['label'] }}</span>
                    </div>
                </div>
            </div>

            {{-- Right column: Spatial notes & highlights --}}
            <div class="sfp-diagram__info-col">
                <div class="sfp-diagram__meta">
                    <h3 class="sfp-diagram__name">{{ $diagram['title'] }}</h3>
                    <p class="sfp-diagram__sub">{{ $diagram['subtitle'] }}</p>
                    <p class="sfp-diagram__desc">{{ $diagram['description'] }}</p>
                </div>

                <div class="sfp-diagram__highlights">
                    <h4 class="sfp-diagram__highlights-title">Layout Highlights:</h4>
                    <div class="sfp-diagram__highlights-grid">
                        @foreach ($highlights as $item)
                            <div class="sfp-diagram__highlight-card">
                                <h5 class="sfp-diagram__highlight-head">{{ $item['title'] }}</h5>
                                <p class="sfp-diagram__highlight-body">{{ $item['desc'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="sfp-diagram__disclosure">
                    <div class="sfp-diagram__disclosure-icon" aria-hidden="true">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="16" x2="12" y2="12"/>
                            <line x1="12" y1="8" x2="12.01" y2="8"/>
                        </svg>
                    </div>
                    <div class="sfp-diagram__disclosure-body">
                        <span class="sfp-diagram__disclosure-badge">{{ $disclosure['badge'] }}</span>
                        <p class="sfp-diagram__disclosure-text">{{ $disclosure['text'] }}</p>
                    </div>
                </div>

                <div class="sfp-diagram__action-bar">
                    <button
                        type="button"
                        class="sfp-diagram__action-btn"
                        data-inquiry="{{ $action['intent'] }}"
                        data-inquiry-source="sfp-diagram"
                        data-inquiry-care="{{ $action['care'] }}"
                    >
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="2" x2="21" y2="10"/>
                        </svg>
                        <span>{{ $action['label'] }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
