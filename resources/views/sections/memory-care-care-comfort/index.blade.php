@php
    /** @var array $data  Normalised by App\Content\Sections\MemoryCareCareComfortSection */
    $site = config('missionvilla');
    $img = $data['image'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/memory-care-care-comfort.css'])
@endpush
{{--
    MEMORY CARE SECTION 04 · CARE, COMFORT & HOME
    Two-column editorial spread: verified support details, care planning reassurance,
    and a large authentic Mission Villa accommodation photograph.
--}}
<section class="mc-care" id="care-comfort" aria-labelledby="care-comfort-title" data-mc-care>
    <div class="mc-care__inner">
        {{-- Left Column: Narrative, Checklist & CTAs --}}
        <div class="mc-care__narrative">
            <p class="mv-eyebrow">
                <span class="mv-eyebrow__rule" aria-hidden="true"></span>
                <span>{{ $data['eyebrow'] }}</span>
            </p>
            <h2 id="care-comfort-title" class="mv-title mc-care__title">
                {!! $data['heading'] !!}
            </h2>
            <p class="mc-care__intro">
                {{ $data['intro'] }}
            </p>

            {{-- Support Checklist --}}
            <ul class="mc-care__checklist" role="list">
                @foreach ($data['checklist'] as $item)
                    <li class="mc-care__check-item">
                        <span class="mc-care__icon-wrap" aria-hidden="true">
                            @include('partials.icon', ['name' => 'check', 'class' => 'mc-care__check-icon', 'stroke' => 2])
                        </span>
                        <span class="mc-care__check-text">{{ $item }}</span>
                    </li>
                @endforeach
            </ul>

            {{-- Reassurance Box --}}
            @if ($data['reassurance_box'])
                <div class="mc-care__reassurance">
                    <div class="mc-care__reassurance-header">
                        @include('partials.icon', ['name' => 'shield', 'class' => 'mc-care__shield', 'stroke' => 1.6])
                        <h3 class="mc-care__reassurance-title">{{ $data['reassurance_box']['title'] }}</h3>
                    </div>
                    <p class="mc-care__reassurance-text">{{ $data['reassurance_box']['text'] }}</p>
                    <div class="mc-care__license-line">
                        <span>{{ $site['license']['label'] }} #{{ $site['license']['number'] }}</span>
                        <a href="{{ $site['phone']['href'] }}" class="mc-care__phone-link">{{ $site['phone']['display'] }}</a>
                    </div>
                </div>
            @endif

            {{-- Actions --}}
            <div class="mc-care__actions">
                @foreach ($data['actions'] as $action)
                    @if ($action['style'] === 'primary')
                        <a
                            href="{{ $site['phone']['href'] }}"
                            class="mv-btn mv-btn--primary mc-care__btn-primary"
                            data-inquiry="{{ $action['intent'] }}"
                            data-inquiry-care="{{ $action['care'] }}"
                            data-inquiry-source="mc-care"
                        >
                            @include('partials.icon', ['name' => $action['icon'] ?? 'calendar', 'class' => 'mv-icon', 'stroke' => 1.6])
                            <span>{{ $action['label'] }}</span>
                            @include('partials.icon', ['name' => 'arrow', 'class' => 'mv-icon mv-btn__arrow', 'stroke' => 2])
                        </a>
                    @else
                        <a
                            href="{{ $site['phone']['href'] }}"
                            class="mv-btn mv-btn--plum mc-care__btn-secondary"
                            data-inquiry="{{ $action['intent'] }}"
                            data-inquiry-care="{{ $action['care'] }}"
                            data-inquiry-source="mc-care"
                        >
                            <span>{{ $action['label'] }}</span>
                            @include('partials.icon', ['name' => 'arrow', 'class' => 'mv-icon mv-btn__arrow', 'stroke' => 2])
                        </a>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Right Column: Large Authentic Accommodation Photograph --}}
        <div class="mc-care__visual">
            <div class="mc-care__photo-frame">
                <picture>
                    @if ($img['src_mobile'])
                        <source media="(max-width: 767px)" srcset="{{ asset(ltrim($img['src_mobile'], '/')) }}">
                    @endif
                    <img
                        src="{{ asset(ltrim($img['src'], '/')) }}"
                        alt="{{ $img['alt'] }}"
                        width="{{ $img['width'] }}"
                        height="{{ $img['height'] }}"
                        class="mc-care__photo"
                        loading="lazy"
                        decoding="async"
                        data-provenance="{{ $img['provenance'] }}"
                        data-rights="{{ $img['rights'] }}"
                    >
                </picture>

                <div class="mc-care__photo-scrim" aria-hidden="true"></div>

                {{-- Provenance Pill --}}
                <span class="mc-care__provenance">{{ $img['label'] }}</span>

                {{-- Photo Caption --}}
                <div class="mc-care__caption-wrap">
                    <span class="mc-care__caption-kicker">Accommodations &amp; Community</span>
                    <p class="mc-care__caption-text">“{{ $img['caption'] }}”</p>
                </div>
            </div>
        </div>
    </div>
</section>
