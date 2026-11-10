@php
    /** @var array $data  Normalised by App\Content\Sections\LivingOptionsSuitesSection */
    $site = config('missionvilla');
    $suites = $data['suites'];
    $cta = $data['cta'];
    $hasFloorPlansPage = \App\Support\InternalLink::isAvailable($cta['href']);
@endphp
@push('section-assets')
    @vite(['resources/css/sections/living-options-suites.css'])
@endpush
{{--
    LIVING OPTIONS SECTION 03 · SUITES & FLOOR-PLAN OPTIONS
    Deep-plum visual centerpiece displaying three prominent photographic cards
    with top-left clipped image corners and integrated label tabs.
--}}
<section class="lo-suites" id="suites-floor-plans" aria-labelledby="lo-suites-title" data-lo-suites>
    {{-- Wave transition from previous cream section --}}
    <svg class="lo-suites__wave" viewBox="0 0 1440 80" preserveAspectRatio="none" aria-hidden="true" focusable="false">
        <path class="lo-suites__wave-fill" d="M0 52 C 260 30, 560 22, 860 40 C 1110 55, 1290 30, 1440 6 L 1440 80 L 0 80 Z"/>
    </svg>

    <div class="lo-suites__inner">
        {{-- Section Header --}}
        <div class="lo-suites__head">
            <p class="mv-eyebrow lo-suites__eyebrow">
                <span class="mv-eyebrow__rule lo-suites__rule" aria-hidden="true"></span>
                <span>{{ $data['eyebrow'] }}</span>
            </p>
            <h2 id="lo-suites-title" class="mv-title lo-suites__title">
                {!! $data['heading'] !!}
            </h2>
            <p class="lo-suites__intro">
                {{ $data['intro'] }}
            </p>
        </div>

        {{-- 3 Suite Cards Grid --}}
        <div class="lo-suites__grid">
            @foreach ($suites as $suite)
                <article class="lo-suites__card" id="suite-{{ $suite['id'] }}" aria-labelledby="suite-title-{{ $suite['id'] }}">
                    {{-- Photographic Top Frame with Clipped Corner Cutout --}}
                    <div class="lo-suites__media">
                        <img
                            src="{{ asset(ltrim($suite['image']['src'], '/')) }}"
                            alt="{{ $suite['image']['alt'] }}"
                            width="{{ $suite['image']['width'] }}"
                            height="{{ $suite['image']['height'] }}"
                            class="lo-suites__img"
                            loading="lazy"
                            decoding="async"
                            data-provenance="{{ $suite['image']['provenance'] }}"
                            data-rights="{{ $suite['image']['rights'] }}"
                        >

                        {{-- Top-Left Inverted Clipped Corner Tab --}}
                        <div class="lo-suites__cutout" aria-hidden="true">
                            <span class="lo-suites__cutout-badge">{{ $suite['cutout_label'] }}</span>
                        </div>

                        {{-- Top-Right Provenance Tag --}}
                        <span class="lo-suites__provenance">{{ $suite['image']['label'] }}</span>

                        {{-- Bottom Image Overlay Meta --}}
                        <div class="lo-suites__overlay-meta">
                            <span class="lo-suites__program-badge">{{ $suite['badge'] }}</span>
                            <h3 id="suite-title-{{ $suite['id'] }}" class="lo-suites__card-title">{{ $suite['title'] }}</h3>
                        </div>
                    </div>

                    {{-- Card Narrative & Features --}}
                    <div class="lo-suites__content">
                        {{-- Bathroom configuration --}}
                        <div class="lo-suites__bathroom-detail">
                            <span class="lo-suites__bathroom-icon" aria-hidden="true">
                                @include('partials.icon', ['name' => 'armchair', 'class' => 'mv-icon', 'stroke' => 1.5])
                            </span>
                            <span class="lo-suites__bathroom-text">{{ $suite['bathroom'] }}</span>
                        </div>

                        <p class="lo-suites__summary">{{ $suite['summary'] }}</p>

                        {{-- Features list --}}
                        <ul class="lo-suites__features">
                            @foreach ($suite['features'] as $feature)
                                <li class="lo-suites__feature-item">
                                    @include('partials.icon', ['name' => 'check', 'class' => 'lo-suites__check', 'stroke' => 2])
                                    <span>{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>

                        {{-- Inquire about this format --}}
                        <div class="lo-suites__card-footer">
                            <a
                                href="{{ $site['phone']['href'] }}"
                                class="mv-btn mv-btn--ghost-light lo-suites__inquire-btn"
                                data-inquiry="request_availability"
                                data-inquiry-suite="{{ $suite['inquiry_suite'] }}"
                                data-inquiry-care="exploring"
                                data-inquiry-source="lo-suites"
                            >
                                @include('partials.icon', ['name' => 'calendar', 'class' => 'mv-icon', 'stroke' => 1.5])
                                <span>Inquire About This Format</span>
                                @include('partials.icon', ['name' => 'arrow', 'class' => 'mv-icon mv-btn__arrow', 'stroke' => 2])
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        {{-- Section Footer CTA Bar --}}
        <div class="lo-suites__action-bar">
            <div class="lo-suites__action-info">
                <p class="lo-suites__action-note">{{ $cta['note'] }}</p>
            </div>
            <div class="lo-suites__action-cta">
                @if ($hasFloorPlansPage)
                    <a href="{{ $cta['href'] }}" class="mv-btn mv-btn--primary">
                        <span>{{ $cta['label'] }}</span>
                        @include('partials.icon', ['name' => 'arrow', 'class' => 'mv-icon mv-btn__arrow', 'stroke' => 2])
                    </a>
                @else
                    <a
                        href="{{ $site['phone']['href'] }}"
                        class="mv-btn mv-btn--primary"
                        data-inquiry="{{ $cta['fallback_inquiry'] }}"
                        data-inquiry-care="exploring"
                        data-inquiry-source="lo-suites"
                    >
                        @include('partials.icon', ['name' => 'calendar', 'class' => 'mv-icon', 'stroke' => 1.6])
                        <span>{{ $cta['label'] }}</span>
                        @include('partials.icon', ['name' => 'arrow', 'class' => 'mv-icon mv-btn__arrow', 'stroke' => 2])
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>
