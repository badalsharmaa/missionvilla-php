@php
    /** @var array $data  Normalised by App\Content\Sections\MemoryCareHeroSection */
    $site = config('missionvilla');
    $img = $data['image'];
    $leaf = asset('images/decor/botanical-leaf-shadow.svg');
@endphp
@push('preload')
    <link rel="preload" as="image" href="{{ asset(ltrim($img['src_mobile'] ?? $img['src'], '/')) }}" media="(max-width: 1023px)" fetchpriority="high">
    <link rel="preload" as="image" href="{{ asset(ltrim($img['src'], '/')) }}" media="(min-width: 1024px)" fetchpriority="high">
@endpush
@push('section-assets')
    @vite(['resources/css/sections/memory-care-hero.css'])
@endpush
{{--
    MEMORY CARE SECTION 01 · EDITORIAL PHOTOGRAPHIC HERO
    Single authentic/illustrative photographic stage with deep plum gradient for high text contrast.
    Honours the approved Mission Villa typography, gutters, and modal inquiry rules.
--}}
<section class="mc-hero" id="mc-hero" aria-labelledby="mc-hero-title" data-mc-hero>
    {{-- Background photography stage --}}
    <div class="mc-hero__stage">
        {{-- Image provenance: {{ $img['provenance'] }}@if ($img['source_url']) · source: {{ $img['source_url'] }}@endif --}}
        <picture>
            @if ($img['src_mobile'])
                <source media="(max-width: 1023px)" srcset="{{ asset(ltrim($img['src_mobile'], '/')) }}">
            @endif
            <img
                src="{{ asset(ltrim($img['src'], '/')) }}"
                alt="{{ $img['alt'] }}"
                width="{{ $img['width'] }}"
                height="{{ $img['height'] }}"
                class="mc-hero__img"
                data-provenance="{{ $img['provenance'] }}"
                data-rights="{{ $img['rights'] }}"
                fetchpriority="high"
                decoding="async"
            >
        </picture>
        <div class="mc-hero__scrim" aria-hidden="true"></div>
    </div>

    {{-- Corner botanical leaf --}}
    <span class="mv-leaf mc-hero__leaf" aria-hidden="true"></span>

    <div class="mc-hero__inner">
        {{-- Breadcrumb navigation --}}
        <nav aria-label="Breadcrumb" class="mc-hero__breadcrumb">
            <ol class="mc-hero__crumbs">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li aria-hidden="true" class="mc-hero__crumb-sep">/</li>
                <li><span>Living Options</span></li>
                <li aria-hidden="true" class="mc-hero__crumb-sep">/</li>
                <li aria-current="page"><span>Memory Care</span></li>
            </ol>
        </nav>

        <div class="mc-hero__content">
            <p class="mv-eyebrow mc-hero__eyebrow">
                <span class="mv-eyebrow__rule mc-hero__rule" aria-hidden="true"></span>
                <span>{{ $data['eyebrow'] }}</span>
            </p>

            <h1 id="mc-hero-title" class="mc-hero__title">
                {!! $data['heading'] !!}
            </h1>

            <p class="mc-hero__editorial">
                {!! $data['editorial'] !!}
            </p>

            <p class="mc-hero__intro">
                {{ $data['intro'] }}
            </p>

            {{-- CTAs --}}
            <div class="mc-hero__actions">
                @foreach ($data['actions'] as $action)
                    @if ($action['style'] === 'primary')
                        <a
                            href="{{ $site['phone']['href'] }}"
                            class="mv-btn mv-btn--primary mc-hero__btn-primary"
                            data-inquiry="{{ $action['intent'] ?? 'schedule_visit' }}"
                            data-inquiry-care="{{ $action['care'] ?? 'memory_care' }}"
                            data-inquiry-source="mc-hero"
                        >
                            @include('partials.icon', ['name' => $action['icon'] ?? 'calendar', 'class' => 'mv-icon', 'stroke' => 1.6])
                            <span>{{ $action['label'] }}</span>
                            @include('partials.icon', ['name' => 'arrow', 'class' => 'mv-icon mv-btn__arrow', 'stroke' => 2])
                        </a>
                    @elseif ($action['style'] === 'phone')
                        <a href="{{ $site['phone']['href'] }}" class="mc-hero__phone">
                            @include('partials.icon', ['name' => 'phone', 'class' => 'mv-icon', 'stroke' => 1.6])
                            <span>{{ $site['phone']['display'] }}</span>
                        </a>
                    @else
                        <a
                            href="{{ $action['href'] ?? '#legacies-difference' }}"
                            class="mv-btn mv-btn--ghost-light mc-hero__btn-ghost"
                        >
                            <span>{{ $action['label'] }}</span>
                            @include('partials.icon', ['name' => 'arrow', 'class' => 'mv-icon mv-btn__arrow', 'stroke' => 2])
                        </a>
                    @endif
                @endforeach
            </div>

            {{-- Provenance Pill --}}
            <div class="mc-hero__meta">
                <span class="mc-hero__provenance-badge">{{ $img['label'] }}</span>
            </div>
        </div>

        {{-- Bottom Reassurance Strip (Herbarium Note) --}}
        @if (! empty($data['badges']))
            <div class="mc-hero__badges" role="region" aria-label="Memory Care Key Highlights">
                @foreach ($data['badges'] as $badge)
                    <div class="mc-hero__badge">
                        <span class="mc-hero__badge-kicker">{{ $badge['kicker'] }}</span>
                        <h2 class="mc-hero__badge-title">{{ $badge['title'] }}</h2>
                        <p class="mc-hero__badge-desc">{{ $badge['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
