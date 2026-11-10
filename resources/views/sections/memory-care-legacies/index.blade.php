@php
    /** @var array $data  Normalised by App\Content\Sections\MemoryCareLegaciesSection */
    $touchpoints = $data['touchpoints'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/memory-care-legacies.css', 'resources/js/sections/memory-care-legacies.js'])
@endpush
{{--
    MEMORY CARE SECTION 02 · THE LEGACIES™ DIFFERENCE
    4-chapter interactive selector with active content panel and supporting photography.
    Grid-stacked panels prevent any layout shifts when switching chapters.
--}}
<section class="mc-legacies" id="legacies-difference" aria-labelledby="legacies-title" data-mc-legacies>
    <span class="mv-leaf mc-legacies__leaf" aria-hidden="true"></span>

    <div class="mc-legacies__inner">
        {{-- Section Head --}}
        <div class="mc-legacies__head">
            <p class="mv-eyebrow">
                <span class="mv-eyebrow__rule" aria-hidden="true"></span>
                <span>{{ $data['eyebrow'] }}</span>
            </p>
            <h2 id="legacies-title" class="mv-title mc-legacies__title">
                {!! $data['heading'] !!}
            </h2>
            <p class="mc-legacies__intro">
                {{ $data['intro'] }}
            </p>
        </div>

        {{-- Chapter Tab Selector (4 items) --}}
        <div class="mc-legacies__tablist" role="tablist" aria-label="Legacies™ touchpoints">
            @foreach ($touchpoints as $i => $tp)
                @php $selected = $i === 0; @endphp
                <button
                    type="button"
                    role="tab"
                    id="mc-tab-{{ $tp['id'] }}"
                    aria-selected="{{ $selected ? 'true' : 'false' }}"
                    aria-controls="mc-panel-{{ $tp['id'] }}"
                    tabindex="{{ $selected ? '0' : '-1' }}"
                    class="mc-legacies__tab {{ $selected ? 'is-active' : '' }}"
                    data-mc-tab="{{ $tp['id'] }}"
                >
                    <span class="mc-legacies__tab-icon" aria-hidden="true">
                        @include('partials.icon', ['name' => $tp['icon'], 'class' => 'mv-icon', 'stroke' => 1.6])
                    </span>
                    <span class="mc-legacies__tab-text">
                        <span class="mc-legacies__tab-chapter">{{ $tp['chapter'] }}</span>
                        <span class="mc-legacies__tab-label">{{ $tp['tab_label'] }}</span>
                    </span>
                </button>
            @endforeach
        </div>

        {{-- Panel Stage: Grid-Stacked Panels (Stable Height) --}}
        <div class="mc-legacies__stage">
            @foreach ($touchpoints as $i => $tp)
                @php $active = $i === 0; @endphp
                <article
                    id="mc-panel-{{ $tp['id'] }}"
                    role="tabpanel"
                    aria-labelledby="mc-tab-{{ $tp['id'] }}"
                    class="mc-legacies__panel {{ $active ? 'is-active' : '' }}"
                    data-mc-panel="{{ $tp['id'] }}"
                    @if (! $active) inert @endif
                >
                    {{-- Narrative Left Column --}}
                    <div class="mc-legacies__narrative">
                        <div class="mc-legacies__panel-head">
                            <span class="mc-legacies__panel-kicker">{{ $tp['chapter'] }} · {{ $tp['tab_label'] }}</span>
                            <h3 class="mc-legacies__panel-title">{{ $tp['title'] }}</h3>
                            <p class="mc-legacies__panel-sub">{{ $tp['subtitle'] }}</p>
                        </div>

                        <p class="mc-legacies__panel-desc">{{ $tp['description'] }}</p>

                        <div class="mc-legacies__in-practice">
                            <h4 class="mc-legacies__practice-head">How This Comes to Life at Mission Villa</h4>
                            <ul class="mc-legacies__practice-list">
                                @foreach ($tp['in_practice'] as $point)
                                    <li class="mc-legacies__practice-item">
                                        @include('partials.icon', ['name' => 'check', 'class' => 'mc-legacies__check', 'stroke' => 2])
                                        <span>{{ $point }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- Family Takeaway Box --}}
                        <div class="mc-legacies__takeaway">
                            <span class="mc-legacies__takeaway-kicker">What This Means for Your Family</span>
                            <p class="mc-legacies__takeaway-text">{{ $tp['takeaway'] }}</p>
                        </div>
                    </div>

                    {{-- Photography Right Column --}}
                    <div class="mc-legacies__visual">
                        <div class="mc-legacies__photo-frame">
                            <picture>
                                @if ($tp['image']['src_mobile'])
                                    <source media="(max-width: 767px)" srcset="{{ asset(ltrim($tp['image']['src_mobile'], '/')) }}">
                                @endif
                                <img
                                    src="{{ asset(ltrim($tp['image']['src'], '/')) }}"
                                    alt="{{ $tp['image']['alt'] }}"
                                    width="{{ $tp['image']['width'] }}"
                                    height="{{ $tp['image']['height'] }}"
                                    class="mc-legacies__photo"
                                    loading="lazy"
                                    decoding="async"
                                    data-provenance="{{ $tp['image']['provenance'] }}"
                                    data-rights="{{ $tp['image']['rights'] }}"
                                >
                            </picture>

                            <div class="mc-legacies__photo-scrim" aria-hidden="true"></div>

                            {{-- Provenance Pill --}}
                            <span class="mc-legacies__provenance">{{ $tp['image']['label'] }}</span>

                            {{-- Photo Caption & CTA --}}
                            <div class="mc-legacies__photo-meta">
                                <p class="mc-legacies__photo-caption">“{{ $tp['image']['caption'] }}”</p>
                                <a
                                    href="{{ config('missionvilla.phone.href') }}"
                                    class="mv-btn mv-btn--primary mc-legacies__photo-cta"
                                    data-inquiry="{{ $tp['cta_intent'] }}"
                                    data-inquiry-care="memory_care"
                                    data-inquiry-source="mc-legacies"
                                >
                                    <span>{{ $tp['cta_label'] }}</span>
                                    @include('partials.icon', ['name' => 'arrow', 'class' => 'mv-icon mv-btn__arrow', 'stroke' => 2])
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
