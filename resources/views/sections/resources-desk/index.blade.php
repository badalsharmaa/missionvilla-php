@php
    /** @var array $data Normalised by App\Content\Sections\ResourcesDeskSection */
    $categories = $data['categories'];
    $items = $data['items'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/resources-desk.css', 'resources/js/sections/resources-desk.js'])
@endpush
{{--
    RESOURCES SECTION 02 · INTERACTIVE FAMILY RESOURCE DESK & TOPIC EXPLORER
--}}
<section class="res-desk fluid-canvas" aria-labelledby="resource-desk-heading" id="resource-pillars-desk" data-res-desk>
    <div class="res-desk__inner">
        {{-- Section Header & Search --}}
        <div class="res-desk__header-grid">
            <div class="res-desk__header-copy">
                <span class="res-desk__kicker font-script">{{ $data['eyebrow'] }}</span>
                <h2 id="resource-desk-heading" class="res-desk__title">
                    {!! $data['heading'] !!}
                </h2>
                <div class="res-desk__intro">
                    {!! $data['intro'] !!}
                </div>
            </div>

            <div class="res-desk__search-wrap">
                <label for="res-desk-search" class="res-desk__search-label">Search Family Resources &amp; Guides</label>
                <div class="res-desk__search-field">
                    <svg class="res-desk__search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input
                        id="res-desk-search"
                        type="search"
                        placeholder="Search e.g., Paper-Ledger, FAQs, Brochure, Blog, Respite..."
                        class="res-desk__search-input"
                        data-desk-search
                    >
                </div>
            </div>
        </div>

        {{-- Category Filter Tabs --}}
        <div role="tablist" aria-label="Filter family resources by category" class="res-desk__tabs">
            @foreach ($categories as $idx => $cat)
                <button
                    type="button"
                    role="tab"
                    aria-selected="{{ $idx === 0 ? 'true' : 'false' }}"
                    class="res-desk__tab-btn {{ $idx === 0 ? 'res-desk__tab-btn--active' : '' }}"
                    data-desk-filter="{{ $cat }}"
                >
                    {{ $cat }}
                </button>
            @endforeach

            <button
                type="button"
                class="res-desk__reset-btn"
                data-desk-reset
                hidden
            >
                Reset Filter
            </button>
        </div>

        {{-- Empty Search State --}}
        <div class="res-desk__empty" data-desk-empty hidden>
            <p class="res-desk__empty-title">No resources matched your search query.</p>
            <p class="res-desk__empty-sub">Try searching for broader terms or switch back to All Resources.</p>
            <button type="button" class="res-desk__empty-btn" data-desk-show-all>
                Show All 6 Family Resource Folios
            </button>
        </div>

        {{-- 12-Column Layout: Left 5 Selectable List + Right 7 Reader Spotlight --}}
        <div class="res-desk__content-grid" data-desk-content>
            {{-- Left 5 Columns: Selectable Folio Index List --}}
            <div class="res-desk__list" data-desk-list>
                @foreach ($items as $idx => $item)
                    @php
                        $isSelected = ($idx === 0);
                    @endphp
                    <button
                        type="button"
                        class="res-desk__card {{ $isSelected ? 'res-desk__card--selected' : '' }}"
                        data-desk-item="{{ $item['id'] }}"
                        data-desk-category="{{ $item['category'] }}"
                        data-desk-haystack="{{ strtolower($item['folioCode'].' '.$item['category'].' '.$item['statusBadge'].' '.$item['title'].' '.$item['subtitle'].' '.$item['summary'].' '.implode(' ', $item['keyTakeaways'])) }}"
                    >
                        <div class="res-desk__card-meta">
                            <span class="res-desk__card-code">{{ $item['folioCode'] }} · {{ $item['category'] }}</span>
                            <span class="res-desk__card-badge">{{ $item['statusBadge'] }}</span>
                        </div>
                        <h3 class="res-desk__card-title">{{ $item['title'] }}</h3>
                        <p class="res-desk__card-sub">{{ $item['subtitle'] }}</p>
                    </button>
                @endforeach
            </div>

            {{-- Right 7 Columns: Synchronized Folio Spotlight Reader --}}
            <div class="res-desk__spotlight">
                @foreach ($items as $idx => $item)
                    @php
                        $isFirst = ($idx === 0);
                        $isAnchor = str_starts_with($item['primaryHref'], '#');
                    @endphp
                    <article
                        class="res-desk__reader herbarium-mount {{ $isFirst ? 'res-desk__reader--active' : '' }}"
                        data-desk-reader="{{ $item['id'] }}"
                        {{ $isFirst ? '' : 'hidden' }}
                    >
                        {{-- Top Editorial Photo Pairing --}}
                        <div class="res-desk__reader-media">
                            <img
                                src="{{ $item['placeholderImage']['src'] }}"
                                alt="{{ $item['placeholderImage']['alt'] }}"
                                class="res-desk__reader-img"
                                loading="lazy"
                            >
                            <div class="res-desk__reader-gradient"></div>

                            <div class="res-desk__reader-pill">
                                <span>{{ $item['folioCode'] }} · {{ $item['statusBadge'] }}</span>
                            </div>

                            <div class="res-desk__reader-headings">
                                <span class="res-desk__reader-cat">{{ $item['category'] }}</span>
                                <h3 class="res-desk__reader-title">{{ $item['title'] }}</h3>
                            </div>
                        </div>

                        {{-- Status Ribbon --}}
                        <div class="res-desk__reader-ribbon">
                            <span class="res-desk__ribbon-status">{{ $item['placeholderImage']['status'] }}</span>
                            <span class="res-desk__ribbon-caption">{{ $item['placeholderImage']['caption'] }}</span>
                        </div>

                        {{-- Reader Body --}}
                        <div class="res-desk__reader-body">
                            <p class="res-desk__reader-summary">{{ $item['summary'] }}</p>

                            <div class="res-desk__takeaways">
                                <h4 class="res-desk__takeaways-title">What You Will Find Inside This Resource</h4>
                                <ul class="res-desk__takeaways-list">
                                    @foreach ($item['keyTakeaways'] as $point)
                                        <li class="res-desk__takeaways-item">
                                            <svg class="res-desk__check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                                <polyline points="20 6 9 17 4 12"/>
                                            </svg>
                                            <span>{{ $point }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            @if (!empty($item['verificationNote']))
                                <div class="res-desk__note-box">
                                    <strong class="res-desk__note-title">Editorial &amp; Pre-Launch Verification Note:</strong>
                                    <p class="res-desk__note-text">{{ $item['verificationNote'] }}</p>
                                </div>
                            @endif

                            {{-- Reader CTAs --}}
                            <div class="res-desk__reader-ctas">
                                @if ($isAnchor)
                                    <a
                                        href="{{ $item['primaryHref'] }}"
                                        class="res-desk__cta-primary"
                                    >
                                        <span>{{ $item['primaryCtaLabel'] }}</span>
                                        <svg class="res-desk__cta-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <line x1="7" y1="17" x2="17" y2="7"/>
                                            <polyline points="7 7 17 7 17 17"/>
                                        </svg>
                                    </a>
                                @else
                                    <a
                                        href="{{ url($item['primaryHref']) }}"
                                        class="res-desk__cta-primary"
                                    >
                                        <span>{{ $item['primaryCtaLabel'] }}</span>
                                        <svg class="res-desk__cta-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <line x1="7" y1="17" x2="17" y2="7"/>
                                            <polyline points="7 7 17 7 17 17"/>
                                        </svg>
                                    </a>
                                @endif

                                @if (!empty($item['secondaryHref']) && !empty($item['secondaryCtaLabel']))
                                    <a
                                        href="{{ url($item['secondaryHref']) }}"
                                        class="res-desk__cta-secondary"
                                    >
                                        <span>{{ $item['secondaryCtaLabel'] }}</span>
                                        <svg class="res-desk__cta-arrow res-desk__cta-arrow--secondary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <line x1="7" y1="17" x2="17" y2="7"/>
                                            <polyline points="7 7 17 7 17 17"/>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>
