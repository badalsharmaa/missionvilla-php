@php
    /** @var array $data Normalised by App\Content\Sections\SuitesFloorPlansFeaturesSection */
    $features = $data['features'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/suites-floor-plans-features.css'])
@endpush
{{--
    SUITES & FLOOR PLANS SECTION 04 · SAFETY, PRIVACY & SPECS
    Light cream section featuring 4 core specification cards.
--}}
<section class="sfp-features" id="suite-features" aria-labelledby="sfp-features-title" data-sfp-features>
    <div class="sfp-features__inner">
        <div class="sfp-features__head">
            <p class="mv-eyebrow sfp-features__eyebrow">
                <span class="mv-eyebrow__rule sfp-features__rule" aria-hidden="true"></span>
                <span>{{ $data['eyebrow'] }}</span>
            </p>
            <h2 id="sfp-features-title" class="mv-title sfp-features__title">
                {!! $data['heading'] !!}
            </h2>
            <p class="sfp-features__intro">
                {{ $data['intro'] }}
            </p>
        </div>

        <div class="sfp-features__grid">
            @foreach ($features as $feature)
                <div class="sfp-features__card">
                    <div class="sfp-features__icon-bar">
                        <div class="sfp-features__icon-box" aria-hidden="true">
                            @if ($feature['icon'] === 'bath')
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 6h6"/>
                                    <path d="M7 12h10"/>
                                    <path d="M4 12v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-6"/>
                                    <path d="M6 8a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v4H6Z"/>
                                </svg>
                            @elseif ($feature['icon'] === 'heart')
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
                                </svg>
                            @elseif ($feature['icon'] === 'shield')
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                </svg>
                            @else
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/>
                                </svg>
                            @endif
                        </div>
                        <span class="sfp-features__code">{{ $feature['code'] }}</span>
                    </div>

                    <div class="sfp-features__body">
                        <h3 class="sfp-features__card-title">{{ $feature['title'] }}</h3>
                        <p class="sfp-features__card-lead">{{ $feature['lead'] }}</p>
                        <p class="sfp-features__card-desc">{{ $feature['body'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
