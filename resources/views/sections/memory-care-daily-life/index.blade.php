@php
    /** @var array $data  Normalised by App\Content\Sections\MemoryCareDailyLifeSection */
    $scenes = $data['scenes'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/memory-care-daily-life.css'])
@endpush
{{--
    MEMORY CARE SECTION 03 · DAILY LIFE IN MEMORY CARE
    Three-scene rhythm sequence (Morning, Midday, Evening).
    Editorial visual cards with natural photography, narrative, and verified highlights.
--}}
<section class="mc-daily" id="daily-life" aria-labelledby="daily-life-title" data-mc-daily>
    <div class="mc-daily__inner">
        {{-- Section Head --}}
        <div class="mc-daily__head">
            <p class="mv-eyebrow">
                <span class="mv-eyebrow__rule" aria-hidden="true"></span>
                <span>{{ $data['eyebrow'] }}</span>
            </p>
            <h2 id="daily-life-title" class="mv-title mc-daily__title">
                {!! $data['heading'] !!}
            </h2>
            <p class="mc-daily__intro">
                {{ $data['intro'] }}
            </p>
        </div>

        {{-- Three-Scene Cards Grid --}}
        <div class="mc-daily__grid">
            @foreach ($scenes as $scene)
                <article class="mc-daily__card" id="scene-{{ $scene['id'] }}">
                    {{-- Scene Image --}}
                    <div class="mc-daily__media">
                        <picture>
                            @if ($scene['image']['src_mobile'])
                                <source media="(max-width: 639px)" srcset="{{ asset(ltrim($scene['image']['src_mobile'], '/')) }}">
                            @endif
                            <img
                                src="{{ asset(ltrim($scene['image']['src'], '/')) }}"
                                alt="{{ $scene['image']['alt'] }}"
                                width="{{ $scene['image']['width'] }}"
                                height="{{ $scene['image']['height'] }}"
                                class="mc-daily__img"
                                loading="lazy"
                                decoding="async"
                                data-provenance="{{ $scene['image']['provenance'] }}"
                                data-rights="{{ $scene['image']['rights'] }}"
                            >
                        </picture>
                        <div class="mc-daily__media-scrim" aria-hidden="true"></div>

                        {{-- Rhythm Badge --}}
                        <div class="mc-daily__badge">
                            <span class="mc-daily__badge-text">{{ $scene['rhythm'] }}</span>
                        </div>

                        {{-- Provenance Pill --}}
                        <span class="mc-daily__provenance">{{ $scene['image']['label'] }}</span>
                    </div>

                    {{-- Scene Body --}}
                    <div class="mc-daily__body">
                        <h3 class="mc-daily__scene-title">{{ $scene['title'] }}</h3>
                        <p class="mc-daily__scene-narrative">{{ $scene['narrative'] }}</p>

                        <ul class="mc-daily__highlights">
                            @foreach ($scene['highlights'] as $highlight)
                                <li class="mc-daily__highlight-item">
                                    @include('partials.icon', ['name' => 'check', 'class' => 'mc-daily__check', 'stroke' => 2])
                                    <span>{{ $highlight }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
