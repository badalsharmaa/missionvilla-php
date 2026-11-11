@php
    /** @var array $data Normalised by App\Content\Sections\GalleryVirtualTourSection */
    $site = config('missionvilla');
    $stops = $data['stops'];
    $actionBox = $data['action_box'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/gallery-virtual-tour.css'])
@endpush
{{--
    GALLERY SECTION 03 · VIRTUAL TOUR STAGE
--}}
<section class="gvt-tour" id="virtual-tour" aria-labelledby="gvt-tour-title" data-gvt-tour>
    <div class="gvt-tour__inner">
        {{-- Section Head --}}
        <div class="gvt-tour__head">
            <p class="mv-eyebrow gvt-tour__eyebrow">
                <span class="mv-eyebrow__rule gvt-tour__rule" aria-hidden="true"></span>
                <span>{{ $data['eyebrow'] }}</span>
            </p>
            <h2 id="gvt-tour-title" class="mv-title gvt-tour__title">
                {!! $data['heading'] !!}
            </h2>
            <p class="gvt-tour__intro">
                {{ $data['intro'] }}
            </p>
        </div>

        {{-- 12-Column Grid: 8 Columns Guided Walkthrough Stops + 4 Columns Video Walkthrough Box --}}
        <div class="gvt-tour__grid">
            {{-- Left 8 Columns: 4 Spatial Tour Stops --}}
            <div class="gvt-tour__stops">
                @foreach ($stops as $stop)
                    <article class="gvt-stop" id="stop-{{ strtolower(str_replace(' ', '-', $stop['stop_index'])) }}">
                        <div class="gvt-stop__media">
                            <img
                                src="{{ asset(ltrim($stop['image']['src'], '/')) }}"
                                alt="{{ $stop['image']['alt'] }}"
                                width="{{ $stop['image']['width'] }}"
                                height="{{ $stop['image']['height'] }}"
                                class="gvt-stop__img"
                                loading="lazy"
                                decoding="async"
                            >
                            <div class="gvt-stop__cutout">
                                <span>{{ $stop['stop_index'] }}</span>
                            </div>
                        </div>

                        <div class="gvt-stop__body">
                            <div class="gvt-stop__location">
                                <span>{{ $stop['location_label'] }}</span>
                            </div>

                            <h3 class="gvt-stop__title">{{ $stop['title'] }}</h3>
                            <p class="gvt-stop__summary">{{ $stop['summary'] }}</p>

                            <div class="gvt-stop__highlights">
                                <span class="gvt-stop__kicker">KEY SPATIAL HIGHLIGHTS:</span>
                                <ul class="gvt-stop__list">
                                    @foreach ($stop['highlights'] as $highlight)
                                        <li class="gvt-stop__list-item">
                                            <svg class="mv-icon gvt-stop__check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                                            <span>{{ $highlight }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="gvt-stop__lookfor">
                                <svg class="mv-icon gvt-stop__lookfor-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                                <div>
                                    <strong class="gvt-stop__lookfor-strong">What to look for:</strong>
                                    <span>{{ $stop['look_for'] }}</span>
                                </div>
                            </div>

                            <div class="gvt-stop__footer">
                                <a href="{{ $stop['route_href'] }}" class="gvt-stop__link">
                                    <span>{{ $stop['route_label'] }}</span>
                                    <svg class="mv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                                </a>
                                <span class="gvt-stop__prov">
                                    {{ $stop['image']['provenance'] === 'facility' ? 'Facility photo' : 'Illustrative' }}
                                </span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Right 4 Columns: Live Video Tour Consultation Box --}}
            <aside class="gvt-tour__sidebar">
                <div class="gvt-tour__action-box">
                    <div class="gvt-tour__action-badge">
                        <svg class="mv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polygon points="23 7 16 12 23 17 23 7"/><rect width="15" height="14" x="1" y="5" rx="2" ry="2"/></svg>
                        <span>REMOTE TOUR OPTION</span>
                    </div>

                    <h3 class="gvt-tour__action-title">{{ $actionBox['title'] }}</h3>
                    <p class="gvt-tour__action-text">{{ $actionBox['text'] }}</p>

                    <div class="gvt-tour__action-btns">
                        <a
                            href="{{ $site['phone']['href'] }}"
                            class="gvt-tour__btn gvt-tour__btn--primary"
                            data-inquiry="{{ $actionBox['cta_intent'] }}"
                            data-care="exploring"
                        >
                            <span>{{ $actionBox['cta_label'] }}</span>
                            <svg class="mv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>

                        <a
                            href="{{ $site['phone']['href'] }}"
                            class="gvt-tour__btn gvt-tour__btn--call"
                        >
                            <svg class="mv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            <span>{{ $actionBox['phone_label'] }}</span>
                        </a>
                    </div>

                    <div class="gvt-tour__action-note">
                        <span>Personalized 1-on-1 walkthrough conducted by our Daly City community director</span>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>
