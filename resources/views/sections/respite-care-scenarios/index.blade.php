@php
    /** @var array $data  Normalised by App\Content\Sections\RespiteCareScenariosSection */
    $scenarios = $data['scenarios'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/respite-care-scenarios.css', 'resources/js/sections/respite-care-scenarios.js'])
@endpush
{{--
    RESPITE CARE SECTION 02 · WHEN FAMILIES CHOOSE RESPITE CARE
    4-scenario interactive selector with active content panel and supporting photography.
    Grid-stacked panels prevent any layout shifts when switching scenarios.
--}}
<section class="rc-scenarios" id="respite-scenarios" aria-labelledby="scenarios-title" data-rc-scenarios>
    <span class="mv-leaf rc-scenarios__leaf" aria-hidden="true"></span>

    <div class="rc-scenarios__inner">
        {{-- Section Head --}}
        <div class="rc-scenarios__head">
            <p class="mv-eyebrow">
                <span class="mv-eyebrow__rule" aria-hidden="true"></span>
                <span>{{ $data['eyebrow'] }}</span>
            </p>
            <h2 id="scenarios-title" class="mv-title rc-scenarios__title">
                {!! $data['heading'] !!}
            </h2>
            <p class="rc-scenarios__intro">
                {{ $data['intro'] }}
            </p>
        </div>

        {{-- Scenario Tab Selector (4 items) --}}
        <div class="rc-scenarios__tablist" role="tablist" aria-label="When families choose respite care">
            @foreach ($scenarios as $i => $s)
                @php $selected = $i === 0; @endphp
                <button
                    type="button"
                    role="tab"
                    id="rc-tab-{{ $s['id'] }}"
                    aria-selected="{{ $selected ? 'true' : 'false' }}"
                    aria-controls="rc-panel-{{ $s['id'] }}"
                    tabindex="{{ $selected ? '0' : '-1' }}"
                    class="rc-scenarios__tab {{ $selected ? 'is-active' : '' }}"
                    data-rc-tab="{{ $s['id'] }}"
                >
                    <span class="rc-scenarios__tab-icon" aria-hidden="true">
                        @include('partials.icon', ['name' => $s['icon'], 'class' => 'mv-icon', 'stroke' => 1.5])
                    </span>
                    <span class="rc-scenarios__tab-label">{{ $s['tab_label'] }}</span>
                </button>
            @endforeach
        </div>

        {{-- Panel Stage: Grid-Stacked Panels (Stable Height) --}}
        <div class="rc-scenarios__stage">
            @foreach ($scenarios as $i => $s)
                @php $active = $i === 0; @endphp
                <article
                    id="rc-panel-{{ $s['id'] }}"
                    role="tabpanel"
                    aria-labelledby="rc-tab-{{ $s['id'] }}"
                    class="rc-scenarios__panel {{ $active ? 'is-active' : '' }}"
                    data-rc-panel="{{ $s['id'] }}"
                    @if (! $active) inert @endif
                >
                    {{-- Narrative Left Column --}}
                    <div class="rc-scenarios__narrative">
                        <div class="rc-scenarios__panel-head">
                            <span class="rc-scenarios__panel-kicker">{{ $s['kicker'] }}</span>
                            <h3 class="rc-scenarios__panel-title">{{ $s['title'] }}</h3>
                            <p class="rc-scenarios__panel-sub">{{ $s['subtitle'] }}</p>
                        </div>

                        <p class="rc-scenarios__panel-desc">{{ $s['narrative'] }}</p>

                        <div class="rc-scenarios__points-wrap">
                            <ul class="rc-scenarios__points-list">
                                @foreach ($s['points'] as $point)
                                    <li class="rc-scenarios__point-item">
                                        @include('partials.icon', ['name' => 'check', 'class' => 'rc-scenarios__check', 'stroke' => 2])
                                        <span>{{ $point }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    {{-- Photography Right Column --}}
                    <div class="rc-scenarios__visual">
                        <div class="rc-scenarios__photo-frame">
                            <picture>
                                @if ($s['image']['src_mobile'])
                                    <source media="(max-width: 639px)" srcset="{{ asset(ltrim($s['image']['src_mobile'], '/')) }}">
                                @endif
                                <img
                                    src="{{ asset(ltrim($s['image']['src'], '/')) }}"
                                    alt="{{ $s['image']['alt'] }}"
                                    width="{{ $s['image']['width'] }}"
                                    height="{{ $s['image']['height'] }}"
                                    class="rc-scenarios__img"
                                    loading="lazy"
                                    decoding="async"
                                    data-provenance="{{ $s['image']['provenance'] }}"
                                    data-rights="{{ $s['image']['rights'] }}"
                                >
                            </picture>

                            <span class="rc-scenarios__provenance">{{ $s['image']['label'] }}</span>
                        </div>
                        <p class="rc-scenarios__caption">
                            <em>{{ $s['image']['caption'] }}</em>
                        </p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
