@php
    /** @var array $data Normalised by App\Content\Sections\ServicesAmenitiesCareBridgeSection */
    $programs = $data['programs'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/services-and-amenities-care-bridge.css'])
@endpush
{{--
    SERVICES & AMENITIES SECTION 05 · CARE PROGRAMS BRIDGE
--}}
<section class="sa-bridge" id="care-programs-bridge" aria-labelledby="sa-bridge-title" data-sa-bridge>
    <div class="sa-bridge__inner">
        {{-- Section Head --}}
        <div class="sa-bridge__head">
            <div class="sa-bridge__head-copy">
                <p class="mv-eyebrow sa-bridge__eyebrow">
                    <span class="mv-eyebrow__rule sa-bridge__rule" aria-hidden="true"></span>
                    <span>{{ $data['eyebrow'] }}</span>
                </p>
                <h2 id="sa-bridge-title" class="mv-title sa-bridge__title">
                    {!! $data['heading'] !!}
                </h2>
                <p class="sa-bridge__intro">
                    {{ $data['intro'] }}
                </p>
            </div>
            <a href="/life-at-mission-villa" class="sa-bridge__back-link">
                <svg class="mv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg>
                <span>Return to Life at Mission Villa</span>
            </a>
        </div>

        {{-- Side-by-Side 2 Program Cards --}}
        <div class="sa-bridge__grid">
            @foreach ($programs as $prog)
                <div class="sa-bridge-card">
                    <div class="sa-bridge-card__top">
                        <div class="sa-bridge-card__meta">
                            <span class="sa-bridge-card__tag">{{ $prog['tag'] }}</span>
                            <span class="sa-bridge-card__badge">{{ $prog['page_badge'] }}</span>
                        </div>
                        <h3 class="sa-bridge-card__title">{{ $prog['title'] }}</h3>
                        <p class="sa-bridge-card__summary">{{ $prog['summary'] }}</p>

                        <div class="sa-bridge-card__highlights">
                            <ul class="sa-bridge-card__list">
                                @foreach ($prog['highlights'] as $highlight)
                                    <li class="sa-bridge-card__list-item">
                                        <svg class="mv-icon sa-bridge-card__check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                                        <span>{{ $highlight }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="sa-bridge-card__bottom">
                        <a href="{{ $prog['link_href'] }}" class="sa-bridge-card__btn">
                            <span>{{ $prog['link_label'] }}</span>
                            <svg class="mv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
