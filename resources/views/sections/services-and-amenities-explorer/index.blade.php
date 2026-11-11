@php
    /** @var array $data Normalised by App\Content\Sections\ServicesAmenitiesExplorerSection */
    $categories = $data['categories'];
@endphp
@push('section-assets')
    @vite([
        'resources/css/sections/services-and-amenities-explorer.css',
        'resources/js/sections/services-and-amenities-explorer.js'
    ])
@endpush
{{--
    SERVICES & AMENITIES SECTION 02 · CATEGORIZED DIRECTORY & EXPLORER
--}}
<section class="sa-explorer" id="services-explorer" aria-labelledby="sa-explorer-title" data-sa-explorer>
    <div class="sa-explorer__inner">
        {{-- Section Head --}}
        <div class="sa-explorer__head">
            <div class="sa-explorer__head-copy">
                <p class="mv-eyebrow sa-explorer__eyebrow">
                    <span class="mv-eyebrow__rule sa-explorer__rule" aria-hidden="true"></span>
                    <span>{{ $data['eyebrow'] }}</span>
                </p>
                <h2 id="sa-explorer-title" class="mv-title sa-explorer__title">
                    {!! $data['heading'] !!}
                </h2>
                <p class="sa-explorer__intro">
                    {{ $data['intro'] }}
                </p>
            </div>

            {{-- Live Filter / Search Input --}}
            <div class="sa-explorer__filter-dock">
                <div class="sa-explorer__search-wrap">
                    <svg class="mv-icon sa-explorer__search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    <input
                        type="search"
                        class="sa-explorer__search-input"
                        placeholder="Filter offerings (e.g. laundry, meals, Wi-Fi)..."
                        aria-label="Filter services and amenities"
                        data-sa-search
                    >
                </div>
            </div>
        </div>

        {{-- Category Switcher Tabs --}}
        <div class="sa-explorer__nav" role="tablist" aria-label="Services and Amenities Categories" data-sa-tabs>
            <button
                type="button"
                role="tab"
                id="sa-tab-all"
                aria-selected="false"
                aria-controls="sa-panel-all"
                class="sa-explorer__tab"
                data-sa-tab="all"
            >
                <span>View All (17)</span>
            </button>
            @foreach ($categories as $index => $cat)
                <button
                    type="button"
                    role="tab"
                    id="sa-tab-{{ $cat['id'] }}"
                    aria-selected="{{ $index === 0 ? 'true' : 'false' }}"
                    aria-controls="sa-panel-{{ $cat['id'] }}"
                    class="sa-explorer__tab {{ $index === 0 ? 'sa-explorer__tab--active' : '' }}"
                    data-sa-tab="{{ $cat['id'] }}"
                >
                    <span class="sa-explorer__tab-idx">{{ $cat['code'] }}</span>
                    <span>{{ $cat['label'] }}</span>
                    <span class="sa-explorer__tab-count">({{ count($cat['items']) }})</span>
                </button>
            @endforeach
        </div>

        {{-- Categories Container --}}
        <div class="sa-explorer__categories" data-sa-container>
            @foreach ($categories as $index => $cat)
                <div
                    class="sa-category {{ $index === 0 ? 'sa-category--active' : '' }}"
                    id="category-{{ $cat['id'] }}"
                    data-sa-category="{{ $cat['id'] }}"
                    role="tabpanel"
                    aria-labelledby="sa-tab-{{ $cat['id'] }}"
                >
                    {{-- Category Header --}}
                    <div class="sa-category__head">
                        <div class="sa-category__meta">
                            <span class="sa-category__code">CATEGORY {{ $cat['code'] }}</span>
                            <span class="sa-category__sep" aria-hidden="true">·</span>
                            <span class="sa-category__label">{{ $cat['label'] }}</span>
                        </div>
                        <h3 class="sa-category__title">{{ $cat['title'] }}</h3>
                        <p class="sa-category__subtitle">{{ $cat['subtitle'] }}</p>
                        <p class="sa-category__narrative">{{ $cat['narrative'] }}</p>
                        <div class="sa-category__reassurance">
                            <svg class="mv-icon sa-category__reassurance-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/></svg>
                            <span>{{ $cat['reassurance'] }}</span>
                        </div>
                    </div>

                    {{-- Category Content Split: Left Photo & Vignette, Right Item Ledger --}}
                    <div class="sa-category__split">
                        {{-- Side A: Editorial Photo Pairing & Vignette --}}
                        <div class="sa-category__aside">
                            <div class="sa-category__photo-card">
                                <div class="sa-category__img-wrap">
                                    <img
                                        src="{{ asset(ltrim($cat['pairing_image']['src'], '/')) }}"
                                        alt="{{ $cat['pairing_image']['alt'] }}"
                                        width="{{ $cat['pairing_image']['width'] }}"
                                        height="{{ $cat['pairing_image']['height'] }}"
                                        class="sa-category__img"
                                        loading="lazy"
                                        decoding="async"
                                    >
                                    <div class="sa-category__badge-cutout">
                                        <span class="sa-category__badge-text">{{ $cat['label'] }}</span>
                                    </div>
                                </div>
                                <div class="sa-category__photo-footer">
                                    <span class="sa-category__photo-label">{{ $cat['pairing_image']['label'] }}</span>
                                    <span class="sa-category__photo-prov">
                                        {{ $cat['pairing_image']['provenance'] === 'facility' ? 'Mission Villa facility photo' : 'Illustrative photo' }}
                                    </span>
                                </div>
                            </div>

                            {{-- Secondary Vignette Card --}}
                            <div class="sa-category__vignette">
                                <h4 class="sa-category__vignette-title">{{ $cat['vignette']['title'] }}</h4>
                                <p class="sa-category__vignette-detail">{{ $cat['vignette']['detail'] }}</p>
                            </div>
                        </div>

                        {{-- Side B: Item Ledger --}}
                        <div class="sa-category__ledger">
                            @foreach ($cat['items'] as $item)
                                <article class="sa-item" id="{{ $item['id'] }}" data-sa-item>
                                    <div class="sa-item__header">
                                        <div class="sa-item__badges">
                                            <span class="sa-item__code">{{ $item['code'] }}</span>
                                            <span class="sa-item__class {{ $item['classification'] === 'Community Service' ? 'sa-item__class--service' : 'sa-item__class--amenity' }}">
                                                {{ $item['classification'] }}
                                            </span>
                                        </div>
                                    </div>

                                    <h4 class="sa-item__title">{{ $item['title'] }}</h4>
                                    <p class="sa-item__subtitle">{{ $item['subtitle'] }}</p>
                                    <p class="sa-item__desc">{{ $item['description'] }}</p>

                                    {{-- How it supports residents --}}
                                    <div class="sa-item__supports">
                                        <span class="sa-item__supports-kicker">HOW IT SUPPORTS RESIDENTS &amp; FAMILIES:</span>
                                        <ul class="sa-item__list">
                                            @foreach ($item['supports'] as $bullet)
                                                <li class="sa-item__list-item">
                                                    <svg class="mv-icon sa-item__check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                                                    <span>{{ $bullet }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    {{-- Factual confirmation note --}}
                                    <div class="sa-item__confirmation">
                                        <svg class="mv-icon sa-item__info-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                                        <span>{{ $item['confirmation_note'] }}</span>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
