@php
    /** @var array $data Normalised by App\Content\Sections\AboutGeographySection */
    $site = config('missionvilla');
    $categories = $data['categories'];
    $landmarks = $data['landmarks'];
    $activeLandmark = $landmarks[0];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/about-geography.css', 'resources/js/sections/about-geography.js'])
@endpush
{{--
    ABOUT SECTION 03 · DALY CITY & PENINSULA GEOGRAPHY
--}}
<section class="about-geo" aria-labelledby="about-geo-heading" id="daly-city-geography" data-about-geo>
    <div class="about-geo__inner">
        {{-- Header --}}
        <div class="about-geo__header">
            <div class="about-geo__header-lead">
                <span class="about-geo__kicker font-script">{{ $data['eyebrow'] }}</span>
                <h2 id="about-geo-heading" class="about-geo__title">
                    {!! $data['heading'] !!}
                </h2>
            </div>
            <div class="about-geo__header-intro">
                <p>{{ $data['intro'] }}</p>
            </div>
        </div>

        {{-- Filter Buttons & Address Bar --}}
        <div class="about-geo__toolbar">
            <div role="group" aria-label="Filter neighborhood landmarks" class="about-geo__filters">
                @foreach ($categories as $idx => $cat)
                    <button
                        type="button"
                        class="about-geo__filter-btn {{ $idx === 0 ? 'about-geo__filter-btn--active' : '' }}"
                        data-geo-filter="{{ $cat }}"
                    >
                        {{ $cat }}
                    </button>
                @endforeach
            </div>

            <div class="about-geo__address">
                <svg class="about-geo__pin-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                    <circle cx="12" cy="10" r="3"/>
                </svg>
                <span>{{ $data['address'] }}</span>
            </div>
        </div>

        {{-- 12-Column Atlas Layout --}}
        <div class="about-geo__grid">
            {{-- Left 5 Columns: Interactive Landmark Cards --}}
            <div class="about-geo__list" role="region" aria-label="Landmark Selection">
                @foreach ($landmarks as $idx => $landmark)
                    <button
                        type="button"
                        class="about-geo__item {{ $idx === 0 ? 'about-geo__item--active' : '' }}"
                        data-geo-item="{{ $landmark['id'] }}"
                        data-geo-category="{{ $landmark['category'] }}"
                        aria-pressed="{{ $idx === 0 ? 'true' : 'false' }}"
                    >
                        <div class="about-geo__item-header">
                            <span class="about-geo__item-code">{{ $landmark['index_code'] }} · {{ $landmark['category'] }}</span>
                            <svg class="about-geo__item-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <polyline points="9 18 15 12 9 6"/>
                            </svg>
                        </div>
                        <h3 class="about-geo__item-title">{{ $landmark['title'] }}</h3>
                        <p class="about-geo__item-prox">{{ $landmark['proximity_context'] }}</p>
                    </button>
                @endforeach
            </div>

            {{-- Right 7 Columns: Dynamic Spotlight Card --}}
            <div class="about-geo__spotlight" aria-live="polite">
                @foreach ($landmarks as $idx => $landmark)
                    <div
                        class="about-geo__card {{ $idx === 0 ? 'about-geo__card--active' : '' }}"
                        data-geo-card="{{ $landmark['id'] }}"
                        {{ $idx !== 0 ? 'hidden' : '' }}
                    >
                        {{-- Top Image Header --}}
                        <div class="about-geo__card-media">
                            <img
                                src="{{ $landmark['image']['src'] }}"
                                width="{{ $landmark['image']['width'] }}"
                                height="{{ $landmark['image']['height'] }}"
                                alt="{{ $landmark['image']['alt'] }}"
                                loading="lazy"
                                class="about-geo__card-img"
                            >
                            <div class="about-geo__card-scrim" aria-hidden="true"></div>

                            <div class="about-geo__card-badges">
                                <span class="about-geo__card-index">
                                    {{ $landmark['index_code'] }} · {{ $landmark['category'] }}
                                </span>
                                <span class="about-geo__card-status">
                                    {{ $landmark['image']['status'] }}
                                </span>
                            </div>

                            <div class="about-geo__card-header-text">
                                <span class="about-geo__card-sub">{{ $landmark['subtitle'] }}</span>
                                <h3 class="about-geo__card-name">{{ $landmark['title'] }}</h3>
                            </div>
                        </div>

                        {{-- Bottom Narrative & Reasons --}}
                        <div class="about-geo__card-body">
                            <p class="about-geo__card-desc">{{ $landmark['description'] }}</p>

                            <div class="about-geo__card-reasons">
                                <h4 class="about-geo__reasons-title">
                                    Why This Location Matters for Residents &amp; Families:
                                </h4>
                                <ul class="about-geo__reasons-list">
                                    @foreach ($landmark['why_it_matters'] as $reason)
                                        <li class="about-geo__reason-item">
                                            <svg class="about-geo__check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                                <polyline points="20 6 9 17 4 12"/>
                                            </svg>
                                            <span>{{ $reason }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            {{-- Footer CTA --}}
                            <div class="about-geo__card-footer">
                                <span class="about-geo__card-addr">
                                    <strong>Address:</strong> {{ $data['address'] }}
                                </span>

                                <button
                                    type="button"
                                    class="about-geo__card-btn"
                                    data-inquiry="schedule_visit"
                                    data-inquiry-source="about-geography"
                                    data-care="memory_care"
                                    data-note="{{ $landmark['inquiry_note'] }}"
                                >
                                    <svg class="about-geo__btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/>
                                    </svg>
                                    <span>Plan Your Visit to Daly City</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
