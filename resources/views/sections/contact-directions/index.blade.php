@php
    /** @var array $data Normalised by App\Content\Sections\ContactDirectionsSection */
    $categories = $data['categories'];
    $corridors = $data['corridors'];
    $orientation = $data['orientation_image'];
    $anchors = $data['neighborhood_anchors'];
    $activeCorridor = $corridors[0];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/contact-directions.css', 'resources/js/sections/contact-directions.js'])
@endpush
{{--
    CONTACT SECTION 03 · GROUNDED MAP, PENINSULA DIRECTIONS & ACCESSIBLE ARRIVAL (#map-and-directions)
--}}
<section class="contact-directions fluid-canvas" aria-labelledby="contact-directions-heading" id="map-and-directions" data-contact-directions>
    <div class="contact-directions__inner">
        {{-- Section Header --}}
        <div class="contact-directions__header">
            <div class="contact-directions__header-left">
                <span class="contact-directions__script">{{ $data['script_title'] }}</span>
                <h2 id="contact-directions-heading" class="contact-directions__title">
                    {!! $data['heading'] !!}
                </h2>
            </div>
            <div class="contact-directions__header-right">
                <p class="contact-directions__lead">
                    {!! $data['intro'] !!}
                </p>
            </div>
        </div>

        {{-- Category Filter Bar --}}
        <div class="contact-directions__filter-bar">
            <div class="contact-directions__tabs" role="tablist" aria-label="Filter arrival and direction corridors">
                @foreach ($categories as $cat)
                    <button
                        type="button"
                        role="tab"
                        aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                        class="contact-directions__tab {{ $loop->first ? 'contact-directions__tab--active' : '' }}"
                        data-category-filter="{{ $cat }}"
                    >
                        {{ $cat }}
                    </button>
                @endforeach
            </div>

            <div class="contact-directions__filter-actions">
                <a href="{{ $data['maps_url'] }}" target="_blank" rel="noopener noreferrer" class="contact-directions__maps-btn">
                    <svg class="contact-directions__btn-icon contact-directions__btn-icon--gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                    <span>Open in Google Maps</span>
                    <svg class="contact-directions__arrow-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M7 17L17 7"/>
                        <path d="M7 7h10v10"/>
                    </svg>
                </a>
            </div>
        </div>

        {{-- 12-Column Split: Corridor Selector Cards (Left 6) + Grounded Map & Arrival Plate (Right 6) --}}
        <div class="contact-directions__grid">
            {{-- Left 6 Columns: Corridor Cards --}}
            <div class="contact-directions__corridors-col">
                <div class="contact-directions__corridors-list">
                    @foreach ($corridors as $corridor)
                        <div
                            class="contact-directions__corridor-card {{ $loop->first ? 'contact-directions__corridor-card--selected' : '' }}"
                            data-corridor-id="{{ $corridor['id'] }}"
                            data-corridor-category="{{ $corridor['category'] }}"
                            data-corridor-title="{{ $corridor['title'] }}"
                            data-corridor-tip="{{ $corridor['arrival_tip'] }}"
                        >
                            <div class="contact-directions__corridor-top">
                                <span class="contact-directions__corridor-code">{{ $corridor['code'] }} · {{ $corridor['category'] }}</span>
                                <button type="button" class="contact-directions__inspect-link" data-corridor-inspect>
                                    <span class="contact-directions__inspect-text">{{ $loop->first ? 'Selected Route Context' : 'Inspect Route Details →' }}</span>
                                </button>
                            </div>

                            <h3 class="contact-directions__corridor-title">{{ $corridor['title'] }}</h3>
                            <p class="contact-directions__corridor-summary">{{ $corridor['route_summary'] }}</p>

                            <div class="contact-directions__corridor-details" {{ $loop->first ? '' : 'hidden' }}>
                                <ul class="contact-directions__landmarks-list">
                                    @foreach ($corridor['landmarks_and_streets'] as $point)
                                        <li class="contact-directions__landmark-item">
                                            <span class="contact-directions__bullet" aria-hidden="true">·</span>
                                            <span>{{ $point }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="contact-directions__tip-box">
                                    <strong>Visitor Arrival Tip:</strong> {{ $corridor['arrival_tip'] }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Right 6 Columns: Grounded Map & Architectural Arrival Companion --}}
            <div class="contact-directions__companion-col">
                <div class="contact-directions__companion-card herbarium-mount">
                    {{-- Top Bar: Mode Switcher --}}
                    <div class="contact-directions__companion-top">
                        <div>
                            <span class="contact-directions__companion-tag">Grounded Location Context</span>
                            <h3 class="contact-directions__companion-address">995 East Market Street, Daly City, CA 94014</h3>
                        </div>

                        <div class="contact-directions__mode-switch">
                            <button
                                type="button"
                                class="contact-directions__mode-btn contact-directions__mode-btn--active"
                                data-map-mode="editorial"
                            >
                                Editorial Orientation
                            </button>
                            <button
                                type="button"
                                class="contact-directions__mode-btn"
                                data-map-mode="embed"
                            >
                                Interactive Map Frame
                            </button>
                        </div>
                    </div>

                    {{-- Visual Canvas: Mode 1 (Editorial Orientation) --}}
                    <div class="contact-directions__canvas contact-directions__canvas--editorial" data-canvas-editorial>
                        <div class="contact-directions__photo-plate">
                            <img
                                src="{{ asset($orientation['src']) }}"
                                alt="{{ $orientation['alt'] }}"
                                class="contact-directions__photo-img"
                                loading="lazy"
                            />
                            <div class="contact-directions__photo-overlay" aria-hidden="true"></div>
                            <div class="contact-directions__photo-badge">{{ $orientation['badge'] }}</div>
                            <div class="contact-directions__photo-caption">
                                <div>
                                    <span class="contact-directions__caption-sub">{{ $orientation['subtitle'] }}</span>
                                    <p class="contact-directions__caption-title">{{ $orientation['title'] }}</p>
                                </div>
                                <span class="contact-directions__caption-phone tabular-nums">{{ $orientation['phone'] }}</span>
                            </div>
                        </div>

                        {{-- Neighborhood Compass Grid --}}
                        <div class="contact-directions__compass-grid">
                            @foreach ($anchors as $anchor)
                                <div class="contact-directions__compass-card">
                                    <div class="contact-directions__compass-head">
                                        @if ($anchor['icon'] === 'car')
                                            <svg class="contact-directions__compass-icon contact-directions__compass-icon--terracotta" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/>
                                                <circle cx="7" cy="17" r="2"/>
                                                <path d="M9 17h6"/>
                                                <circle cx="17" cy="17" r="2"/>
                                            </svg>
                                        @else
                                            <svg class="contact-directions__compass-icon contact-directions__compass-icon--green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <rect width="16" height="16" x="4" y="4" rx="2"/>
                                                <path d="M4 10h16"/>
                                                <path d="M12 4v16"/>
                                                <path d="m8 20-2 2"/>
                                                <path d="m16 20 2 2"/>
                                                <circle cx="8" cy="15" r="1"/>
                                                <circle cx="16" cy="15" r="1"/>
                                            </svg>
                                        @endif
                                        <span>{{ $anchor['title'] }}</span>
                                    </div>
                                    <p class="contact-directions__compass-text">{{ $anchor['description'] }}</p>
                                </div>
                            @endforeach

                            {{-- Dynamic Active Route Focus Card --}}
                            <div class="contact-directions__compass-card contact-directions__compass-card--focus">
                                <div class="contact-directions__compass-head">
                                    <svg class="contact-directions__compass-icon contact-directions__compass-icon--purple" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <circle cx="16" cy="4" r="1"/>
                                        <path d="m18 19 1-7-6 1"/>
                                        <path d="m5 8 3-3 5.5 3-2.36 3.5"/>
                                        <path d="M4.24 14.5a5 5 0 0 0 6.88 6"/>
                                        <path d="M13.76 17.5a5 5 0 0 0-4-7.5"/>
                                    </svg>
                                    <span data-active-route-label>Selected Route Focus: {{ $activeCorridor['title'] }}</span>
                                </div>
                                <p class="contact-directions__compass-text" data-active-route-tip>{{ $activeCorridor['arrival_tip'] }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Visual Canvas: Mode 2 (Interactive Map Frame) --}}
                    <div class="contact-directions__canvas contact-directions__canvas--embed" data-canvas-embed hidden>
                        <div class="contact-directions__iframe-frame">
                            <iframe
                                title="Google Map for Mission Villa Senior Living at 995 East Market Street, Daly City, CA 94014"
                                src="{{ $data['maps_embed_url'] }}"
                                class="contact-directions__iframe"
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                            ></iframe>
                        </div>
                        <p class="contact-directions__iframe-caption">
                            Map centered on verified community address: <strong class="text-[#3B2348]">995 East Market Street, Daly City, CA 94014</strong>. If your browser blocks embedded third-party maps, use the direct Google Maps link below.
                        </p>
                    </div>

                    {{-- Bottom Action Bar --}}
                    <div class="contact-directions__companion-footer">
                        <div class="contact-directions__footer-actions">
                            <button type="button" class="contact-directions__footer-btn contact-directions__footer-btn--copy" data-copy-address="995 East Market Street, Daly City, CA 94014">
                                <svg class="contact-directions__footer-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <rect width="14" height="14" x="8" y="8" rx="2" ry="2"/>
                                    <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/>
                                </svg>
                                <span>Copy Verified Address</span>
                            </button>

                            <a href="{{ $data['maps_url'] }}" target="_blank" rel="noopener noreferrer" class="contact-directions__footer-btn contact-directions__footer-btn--turn">
                                <span>Turn-by-Turn on Google Maps</span>
                                <svg class="contact-directions__arrow-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path d="M7 17L17 7"/>
                                    <path d="M7 7h10v10"/>
                                </svg>
                            </a>
                        </div>

                        <a href="tel:16507561995" class="contact-directions__arrival-phone tabular-nums">
                            Arrival Desk: 650-756-1995
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
