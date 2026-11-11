@php
    /** @var array $data Normalised by App\Content\Sections\SuitesFloorPlansFormatsSection */
    $suites = $data['suites'];
    $cta = $data['cta'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/suites-floor-plans-formats.css'])
@endpush
{{--
    SUITES & FLOOR PLANS SECTION 02 · SUITE FORMATS & ACCOMMODATIONS
    Deep-plum visual centerpiece displaying three prominent photographic cards
    with top-left clipped image corners and integrated label tabs.
--}}
<section class="sfp-formats" id="suite-formats" aria-labelledby="sfp-formats-title" data-sfp-formats>
    {{-- Decorative organic wave divider from hero --}}
    <svg class="sfp-formats__wave" viewBox="0 0 1440 60" preserveAspectRatio="none" aria-hidden="true" focusable="false">
        <path class="sfp-formats__wave-fill" d="M0,0 C320,50 640,60 960,30 C1200,8 1360,20 1440,36 L1440,60 L0,60 Z"/>
    </svg>

    <div class="sfp-formats__inner">
        <div class="sfp-formats__head">
            <p class="mv-eyebrow sfp-formats__eyebrow">
                <span class="mv-eyebrow__rule sfp-formats__rule" aria-hidden="true"></span>
                <span>{{ $data['eyebrow'] }}</span>
            </p>
            <h2 id="sfp-formats-title" class="mv-title sfp-formats__title">
                {!! $data['heading'] !!}
            </h2>
            <p class="sfp-formats__intro">
                {{ $data['intro'] }}
            </p>
        </div>

        <div class="sfp-formats__grid">
            @foreach ($suites as $suite)
                <article class="sfp-formats__card" id="suite-{{ $suite['id'] }}" aria-labelledby="suite-title-{{ $suite['id'] }}">
                    <div class="sfp-formats__media">
                        <img
                            src="{{ asset(ltrim($suite['image']['src'], '/')) }}"
                            alt="{{ $suite['image']['alt'] }}"
                            width="{{ $suite['image']['width'] }}"
                            height="{{ $suite['image']['height'] }}"
                            class="sfp-formats__img"
                            loading="lazy"
                            decoding="async"
                        >
                        <div class="sfp-formats__cutout" aria-hidden="true">
                            <span class="sfp-formats__cutout-label">{{ $suite['cutout_label'] }}</span>
                        </div>
                    </div>

                    <div class="sfp-formats__body">
                        <div class="sfp-formats__meta">
                            <span class="sfp-formats__code">{{ $suite['code'] }}</span>
                            <span class="sfp-formats__bathroom">{{ $suite['bathroom'] }}</span>
                        </div>

                        <h3 id="suite-title-{{ $suite['id'] }}" class="sfp-formats__card-title">
                            {{ $suite['title'] }}
                        </h3>

                        <p class="sfp-formats__summary">
                            {{ $suite['summary'] }}
                        </p>

                        <div class="sfp-formats__features">
                            <span class="sfp-formats__features-label">Suite Highlights:</span>
                            <ul class="sfp-formats__features-list">
                                @foreach ($suite['features'] as $feature)
                                    <li class="sfp-formats__feature-item">
                                        <svg class="sfp-formats__check" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <polyline points="20 6 9 17 4 12"/>
                                        </svg>
                                        <span>{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="sfp-formats__card-actions">
                            <button
                                type="button"
                                class="sfp-formats__card-btn"
                                data-inquiry="request_availability"
                                data-inquiry-source="sfp-formats-card"
                                data-inquiry-suite="{{ $suite['inquiry_suite'] }}"
                                data-inquiry-care="exploring"
                            >
                                <span>Inquire About This Format</span>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </button>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="sfp-formats__foot">
            <button
                type="button"
                class="sfp-formats__foot-btn"
                data-inquiry="{{ $cta['intent'] }}"
                data-inquiry-source="sfp-formats-foot"
                data-inquiry-care="exploring"
            >
                <span>{{ $cta['label'] }}</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </button>
            <p class="sfp-formats__foot-note">
                {{ $cta['note'] }}
            </p>
        </div>
    </div>
</section>
