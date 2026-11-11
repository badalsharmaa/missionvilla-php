@php
    /** @var array $data Normalised by App\Content\Sections\GalleryMasonrySection */
    $plates = $data['plates'];
@endphp
@push('section-assets')
    @vite([
        'resources/css/sections/gallery-masonry.css',
        'resources/js/sections/gallery-masonry.js'
    ])
@endpush
{{--
    GALLERY SECTION 02 · EDITORIAL MASONRY MONOGRAPH
--}}
<section class="gm-masonry" id="editorial-masonry-gallery" aria-labelledby="gm-masonry-title" data-gm-masonry>
    <div class="gm-masonry__inner">
        {{-- Section Head --}}
        <div class="gm-masonry__head">
            <div class="gm-masonry__head-copy">
                <p class="mv-eyebrow gm-masonry__eyebrow">
                    <span class="mv-eyebrow__rule gm-masonry__rule" aria-hidden="true"></span>
                    <span>{{ $data['eyebrow'] }}</span>
                </p>
                <h2 id="gm-masonry-title" class="mv-title gm-masonry__title">
                    {!! $data['heading'] !!}
                </h2>
                <p class="gm-masonry__intro">
                    {{ $data['intro'] }}
                </p>
            </div>

            {{-- Category Filter Bar --}}
            <div class="gm-masonry__filter-bar" role="tablist" aria-label="Filter visual plates by space">
                <button
                    type="button"
                    role="tab"
                    aria-selected="true"
                    class="gm-masonry__filter-btn gm-masonry__filter-btn--active"
                    data-gm-filter="all"
                >
                    <span>All Plates ({{ count($plates) }})</span>
                </button>
                <button
                    type="button"
                    role="tab"
                    aria-selected="false"
                    class="gm-masonry__filter-btn"
                    data-gm-filter="Rooms"
                    id="gallery-category-rooms"
                >
                    <span>Rooms</span>
                </button>
                <button
                    type="button"
                    role="tab"
                    aria-selected="false"
                    class="gm-masonry__filter-btn"
                    data-gm-filter="Dining"
                    id="gallery-category-dining"
                >
                    <span>Dining</span>
                </button>
                <button
                    type="button"
                    role="tab"
                    aria-selected="false"
                    class="gm-masonry__filter-btn"
                    data-gm-filter="Common Areas"
                    id="gallery-category-common-areas"
                >
                    <span>Common Areas</span>
                </button>
                <button
                    type="button"
                    role="tab"
                    aria-selected="false"
                    class="gm-masonry__filter-btn"
                    data-gm-filter="Outdoor Spaces"
                    id="gallery-category-outdoor-spaces"
                >
                    <span>Outdoor Spaces</span>
                </button>
                <button
                    type="button"
                    role="tab"
                    aria-selected="false"
                    class="gm-masonry__filter-btn"
                    data-gm-filter="Activities"
                    id="gallery-category-activities"
                >
                    <span>Activities</span>
                </button>
            </div>
        </div>

        {{-- Visual Plates Grid --}}
        <div class="gm-masonry__grid" data-gm-grid>
            @foreach ($plates as $plate)
                <article
                    class="gm-plate"
                    id="{{ $plate['id'] }}"
                    data-gm-plate
                    data-category="{{ $plate['category'] }}"
                >
                    {{-- Media Frame (Clickable for Lightbox) --}}
                    <div class="gm-plate__media-wrap">
                        <button
                            type="button"
                            class="gm-plate__lightbox-trigger"
                            aria-label="Inspect {{ $plate['title'] }} full size"
                            data-gm-trigger
                            data-img-src="{{ asset(ltrim($plate['image']['src'], '/')) }}"
                            data-img-alt="{{ $plate['image']['alt'] }}"
                            data-img-title="{{ $plate['title'] }}"
                            data-img-caption="{{ $plate['caption'] }}"
                            data-img-prov="{{ $plate['image']['provenance'] === 'facility' ? 'Mission Villa facility photograph' : 'Illustrative community photograph' }}"
                        >
                            <img
                                src="{{ asset(ltrim($plate['image']['src'], '/')) }}"
                                alt="{{ $plate['image']['alt'] }}"
                                width="{{ $plate['image']['width'] }}"
                                height="{{ $plate['image']['height'] }}"
                                class="gm-plate__img"
                                loading="lazy"
                                decoding="async"
                            >
                            <div class="gm-plate__hover-overlay">
                                <span class="gm-plate__zoom-icon" aria-hidden="true">
                                    <svg class="mv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/><path d="M11 8v6"/><path d="M8 11h6"/></svg>
                                </span>
                                <span class="gm-plate__zoom-text">Click to Expand</span>
                            </div>
                        </button>

                        <div class="gm-plate__cutout">
                            <span>{{ $plate['cutout_badge'] }}</span>
                        </div>
                    </div>

                    {{-- Plate Details Card --}}
                    <div class="gm-plate__body">
                        <div class="gm-plate__meta">
                            <span class="gm-plate__code">{{ $plate['code'] }}</span>
                            <span class="gm-plate__context">{{ $plate['spatial_context'] }}</span>
                        </div>

                        <h3 class="gm-plate__title">{{ $plate['title'] }}</h3>
                        <p class="gm-plate__subtitle">{{ $plate['subtitle'] }}</p>
                        <p class="gm-plate__caption">{{ $plate['caption'] }}</p>

                        {{-- What Families Notice --}}
                        <div class="gm-plate__notice">
                            <span class="gm-plate__notice-kicker">WHAT FAMILIES NOTICE:</span>
                            <ul class="gm-plate__list">
                                @foreach ($plate['highlights'] as $highlight)
                                    <li class="gm-plate__list-item">
                                        <svg class="mv-icon gm-plate__check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                                        <span>{{ $highlight }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- Footer: Route Link & Provenance --}}
                        <div class="gm-plate__footer">
                            <a href="{{ $plate['route_href'] }}" class="gm-plate__link">
                                <span>{{ $plate['route_label'] }}</span>
                                <svg class="mv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </a>
                            <span class="gm-plate__provenance">
                                {{ $plate['image']['provenance'] === 'facility' ? 'Facility photo' : 'Illustrative' }}
                            </span>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>

    {{-- Accessible Lightbox Dialog --}}
    <dialog class="gm-lightbox" data-gm-dialog aria-label="Photo inspection lightbox">
        <div class="gm-lightbox__backdrop" data-gm-close></div>
        <div class="gm-lightbox__container">
            <button type="button" class="gm-lightbox__close" aria-label="Close photo inspection" data-gm-close>
                <svg class="mv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
            <div class="gm-lightbox__media">
                <img src="" alt="" class="gm-lightbox__img" data-gm-dialog-img>
            </div>
            <div class="gm-lightbox__caption">
                <h4 class="gm-lightbox__title" data-gm-dialog-title></h4>
                <p class="gm-lightbox__desc" data-gm-dialog-caption></p>
                <span class="gm-lightbox__prov" data-gm-dialog-prov></span>
            </div>
        </div>
    </dialog>
</section>
