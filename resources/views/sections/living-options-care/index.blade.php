@php
    /** @var array $data  Normalised by App\Content\Sections\LivingOptionsCareSection */
    $site = config('missionvilla');
    $options = $data['options'];
    $comp = $data['comparison'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/living-options-care.css', 'resources/js/sections/living-options-care.js'])
@endpush
{{--
    LIVING OPTIONS SECTION 02 · CHOOSE THE CARE THAT FITS YOUR NEEDS
    Interactive two-option selector (Memory Care vs Respite Care) with
    dedicated photography, key distinction callout, who it supports, and links,
    plus an at-a-glance comparison table below.
--}}
<section class="lo-care" id="choose-care" aria-labelledby="lo-care-title" data-lo-care>
    <span class="mv-leaf lo-care__leaf" aria-hidden="true"></span>

    <div class="lo-care__inner">
        {{-- Section Header --}}
        <div class="lo-care__head">
            <p class="mv-eyebrow">
                <span class="mv-eyebrow__rule" aria-hidden="true"></span>
                <span>{{ $data['eyebrow'] }}</span>
            </p>
            <h2 id="lo-care-title" class="mv-title lo-care__title">
                {!! $data['heading'] !!}
            </h2>
            <p class="lo-care__intro">
                {{ $data['intro'] }}
            </p>

            {{-- Segmented 2-Option Selector Control --}}
            <div class="lo-care__controls" role="tablist" aria-label="Care program options">
                @foreach ($options as $i => $opt)
                    @php $active = $i === 0; @endphp
                    <button
                        type="button"
                        class="lo-care__tab {{ $active ? 'is-active' : '' }}"
                        role="tab"
                        id="tab-{{ $opt['id'] }}"
                        aria-selected="{{ $active ? 'true' : 'false' }}"
                        aria-controls="panel-{{ $opt['id'] }}"
                        tabindex="{{ $active ? '0' : '-1' }}"
                        data-care-tab="{{ $opt['id'] }}"
                    >
                        @include('partials.icon', ['name' => $opt['id'] === 'memory-care' ? 'heart' : 'calendar', 'class' => 'lo-care__tab-icon', 'stroke' => 1.6])
                        <span class="lo-care__tab-text">
                            <span class="lo-care__tab-number">{{ $opt['number'] }}</span>
                            <span class="lo-care__tab-label">{{ $opt['title'] }}</span>
                        </span>
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Interactive Option Panels --}}
        <div class="lo-care__stage">
            @foreach ($options as $i => $opt)
                @php $active = $i === 0; @endphp
                <div
                    class="lo-care__panel {{ $active ? 'is-active' : '' }}"
                    id="panel-{{ $opt['id'] }}"
                    role="tabpanel"
                    aria-labelledby="tab-{{ $opt['id'] }}"
                    @if (! $active) hidden @endif
                    data-care-panel="{{ $opt['id'] }}"
                >
                    <div class="lo-care__card">
                        {{-- Left Column: Media & Visual Framing --}}
                        <div class="lo-care__media">
                            <div class="lo-care__img-wrap">
                                <img
                                    src="{{ asset(ltrim($opt['image']['src'], '/')) }}"
                                    alt="{{ $opt['image']['alt'] }}"
                                    width="{{ $opt['image']['width'] }}"
                                    height="{{ $opt['image']['height'] }}"
                                    class="lo-care__img"
                                    loading="lazy"
                                    decoding="async"
                                    data-provenance="{{ $opt['image']['provenance'] }}"
                                    data-rights="{{ $opt['image']['rights'] }}"
                                >
                                <div class="lo-care__img-scrim" aria-hidden="true"></div>
                                <span class="lo-care__tag">{{ $opt['tag'] }}</span>
                                <span class="lo-care__provenance">{{ $opt['image']['label'] }}</span>
                            </div>
                            <p class="lo-care__caption">{{ $opt['image']['caption'] }}</p>
                        </div>

                        {{-- Right Column: Detailed Narrative & Inclusions --}}
                        <div class="lo-care__body">
                            <div class="lo-care__meta">
                                <span class="lo-care__number-pill">{{ $opt['number'] }}</span>
                                <h3 class="lo-care__card-title">{{ $opt['title'] }}</h3>
                                <p class="lo-care__headline">{{ $opt['headline'] }}</p>
                            </div>

                            <p class="lo-care__lead">{{ $opt['lead'] }}</p>

                            {{-- Key Distinction Callout --}}
                            <div class="lo-care__distinction">
                                <span class="lo-care__distinction-icon" aria-hidden="true">
                                    @include('partials.icon', ['name' => 'sparkles', 'class' => 'mv-icon', 'stroke' => 1.8])
                                </span>
                                <div class="lo-care__distinction-content">
                                    <span class="lo-care__distinction-label">Core Distinction</span>
                                    <p class="lo-care__distinction-text">{{ $opt['key_distinction'] }}</p>
                                </div>
                            </div>

                            {{-- Who It Supports --}}
                            <div class="lo-care__ideal">
                                <h4 class="lo-care__subheading">Designed for:</h4>
                                <ul class="lo-care__list">
                                    @foreach ($opt['ideal_for'] as $point)
                                        <li class="lo-care__list-item">
                                            @include('partials.icon', ['name' => 'check', 'class' => 'lo-care__list-check', 'stroke' => 2])
                                            <span>{{ $point }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            {{-- What's Included --}}
                            <div class="lo-care__inclusions">
                                <h4 class="lo-care__subheading">Included Support & Living Features:</h4>
                                <ul class="lo-care__inclusions-grid">
                                    @foreach ($opt['inclusions'] as $inc)
                                        <li class="lo-care__inclusion-pill">
                                            @include('partials.icon', ['name' => 'check-circle', 'class' => 'lo-care__inclusion-icon', 'stroke' => 1.6])
                                            <span>{{ $inc }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            {{-- Card Action Buttons --}}
                            <div class="lo-care__actions">
                                <a href="{{ $opt['route_href'] }}" class="mv-btn mv-btn--primary">
                                    <span>{{ $opt['route_label'] }}</span>
                                    @include('partials.icon', ['name' => 'arrow', 'class' => 'mv-icon mv-btn__arrow', 'stroke' => 2])
                                </a>

                                <a
                                    href="{{ $site['phone']['href'] }}"
                                    class="mv-btn mv-btn--plum"
                                    data-inquiry="{{ $opt['inquiry_intent'] }}"
                                    data-inquiry-care="{{ $opt['inquiry_care'] }}"
                                    data-inquiry-source="lo-care"
                                >
                                    @include('partials.icon', ['name' => 'calendar', 'class' => 'mv-icon', 'stroke' => 1.6])
                                    <span>{{ $opt['inquiry_label'] }}</span>
                                    @include('partials.icon', ['name' => 'arrow', 'class' => 'mv-icon mv-btn__arrow', 'stroke' => 2])
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Compact At-a-Glance Comparison Table --}}
        <div class="lo-care__comparison" id="care-comparison" role="region" aria-labelledby="lo-comp-heading">
            <div class="lo-care__comp-head">
                <h3 id="lo-comp-heading" class="lo-care__comp-title">{{ $comp['heading'] }}</h3>
                <p class="lo-care__comp-intro">{{ $comp['intro'] }}</p>
            </div>

            <div class="lo-care__table-wrap">
                <table class="lo-care__table">
                    <thead>
                        <tr>
                            <th scope="col" class="lo-care__th lo-care__th--dim">Care Dimension</th>
                            <th scope="col" class="lo-care__th lo-care__th--mc">Legacies™ Memory Care</th>
                            <th scope="col" class="lo-care__th lo-care__th--rc">Short-Term Respite Care</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comp['rows'] as $row)
                            <tr class="lo-care__tr">
                                <th scope="row" class="lo-care__td lo-care__td--dim">
                                    <span class="lo-care__row-icon" aria-hidden="true">
                                        @include('partials.icon', ['name' => 'check-circle', 'class' => 'mv-icon', 'stroke' => 1.5])
                                    </span>
                                    <span>{{ $row['dimension'] }}</span>
                                </th>
                                <td class="lo-care__td lo-care__td--mc" data-label="Memory Care">
                                    {{ $row['memory_care'] }}
                                </td>
                                <td class="lo-care__td lo-care__td--rc" data-label="Respite Care">
                                    {{ $row['respite_care'] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Shared Foundation Note --}}
            <div class="lo-care__shared-note">
                <span class="lo-care__shared-icon" aria-hidden="true">
                    @include('partials.icon', ['name' => 'shield', 'class' => 'mv-icon', 'stroke' => 1.6])
                </span>
                <p class="lo-care__shared-text">
                    <strong>Shared Foundation:</strong> {{ $comp['shared_foundation'] }}
                </p>
            </div>
        </div>
    </div>
</section>
