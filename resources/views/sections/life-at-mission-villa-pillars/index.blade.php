@php
    /** @var array $data Normalised by App\Content\Sections\LifeAtMissionVillaPillarsSection */
    $pillars = $data['pillars'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/life-at-mission-villa-pillars.css'])
@endpush
{{--
    LIFE AT MISSION VILLA SECTION 02 · LIFESTYLE PILLARS
--}}
<section class="lmv-pillars" id="lifestyle-pillars" aria-labelledby="lmv-pillars-title" data-lmv-pillars>
    <svg class="lmv-pillars__wave" viewBox="0 0 1440 60" preserveAspectRatio="none" aria-hidden="true" focusable="false">
        <path class="lmv-pillars__wave-fill" d="M0,0 C320,50 640,60 960,30 C1200,8 1360,20 1440,36 L1440,60 L0,60 Z"/>
    </svg>

    <div class="lmv-pillars__inner">
        <div class="lmv-pillars__head">
            <p class="mv-eyebrow lmv-pillars__eyebrow">
                <span class="mv-eyebrow__rule lmv-pillars__rule" aria-hidden="true"></span>
                <span>{{ $data['eyebrow'] }}</span>
            </p>
            <h2 id="lmv-pillars-title" class="mv-title lmv-pillars__title">
                {!! $data['heading'] !!}
            </h2>
            <p class="lmv-pillars__intro">
                {{ $data['intro'] }}
            </p>
        </div>

        <div class="lmv-pillars__grid">
            @foreach ($pillars as $pillar)
                <article class="lmv-pillars__card" id="pillar-{{ $pillar['id'] }}" aria-labelledby="pillar-title-{{ $pillar['id'] }}">
                    <div class="lmv-pillars__media">
                        <img
                            src="{{ asset(ltrim($pillar['image']['src'], '/')) }}"
                            alt="{{ $pillar['image']['alt'] }}"
                            width="{{ $pillar['image']['width'] }}"
                            height="{{ $pillar['image']['height'] }}"
                            class="lmv-pillars__img"
                            loading="lazy"
                            decoding="async"
                        >
                        <div class="lmv-pillars__cutout" aria-hidden="true">
                            <span class="lmv-pillars__cutout-label">{{ $pillar['cutout_label'] }}</span>
                        </div>
                    </div>

                    <div class="lmv-pillars__body">
                        <span class="lmv-pillars__code">{{ $pillar['code'] }}</span>
                        <h3 id="pillar-title-{{ $pillar['id'] }}" class="lmv-pillars__card-title">
                            {{ $pillar['title'] }}
                        </h3>
                        <p class="lmv-pillars__subtitle">{{ $pillar['subtitle'] }}</p>
                        <p class="lmv-pillars__summary">{{ $pillar['summary'] }}</p>

                        <div class="lmv-pillars__highlights">
                            <span class="lmv-pillars__highlights-label">Key Highlights:</span>
                            <ul class="lmv-pillars__highlights-list">
                                @foreach ($pillar['highlights'] as $highlight)
                                    <li class="lmv-pillars__highlight-item">
                                        <svg class="lmv-pillars__check" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <polyline points="20 6 9 17 4 12"/>
                                        </svg>
                                        <span>{{ $highlight }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
