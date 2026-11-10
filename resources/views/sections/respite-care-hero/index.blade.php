@php
    /** @var array $data  Normalised by App\Content\Sections\RespiteCareHeroSection */
    $site = config('missionvilla');
    $img = $data['image'];
    $leaf = asset('images/decor/botanical-leaf-shadow.svg');
@endphp
@push('preload')
    <link rel="preload" as="image" href="{{ asset(ltrim($img['src_mobile'] ?? $img['src'], '/')) }}" media="(max-width: 1023px)" fetchpriority="high">
    <link rel="preload" as="image" href="{{ asset(ltrim($img['src'], '/')) }}" media="(min-width: 1024px)" fetchpriority="high">
@endpush
@push('section-assets')
    @vite(['resources/css/sections/respite-care-hero.css'])
@endpush
{{--
    RESPITE CARE SECTION 01 · EDITORIAL PHOTOGRAPHIC HERO
    Single photographic internal-page hero with dark plum gradient scrim.
    Honours the approved Mission Villa typography scale, gutters, and modal inquiry rules.
--}}
<section class="rc-hero" id="rc-hero" aria-labelledby="rc-hero-title" data-rc-hero>
    {{-- Background photography stage --}}
    <div class="rc-hero__stage">
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
                class="rc-hero__img"
                data-provenance="{{ $img['provenance'] }}"
                data-rights="{{ $img['rights'] }}"
                fetchpriority="high"
                decoding="async"
            >
        </picture>
        <div class="rc-hero__scrim" aria-hidden="true"></div>
    </div>

    {{-- Corner botanical leaf --}}
    <span class="mv-leaf rc-hero__leaf" aria-hidden="true"></span>

    <div class="rc-hero__inner">
        {{-- Breadcrumb navigation --}}
        <nav aria-label="Breadcrumb" class="rc-hero__breadcrumb">
            <ol class="rc-hero__crumbs">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li aria-hidden="true" class="rc-hero__crumb-sep">/</li>
                <li><span>Living Options</span></li>
                <li aria-hidden="true" class="rc-hero__crumb-sep">/</li>
                <li aria-current="page"><span>Respite Care</span></li>
            </ol>
        </nav>

        <div class="rc-hero__content">
            <p class="mv-eyebrow rc-hero__eyebrow">
                <span class="mv-eyebrow__rule rc-hero__rule" aria-hidden="true"></span>
                <span>{{ $data['eyebrow'] }}</span>
            </p>

            <h1 id="rc-hero-title" class="rc-hero__title">
                {!! $data['heading'] !!}
            </h1>

            <p class="rc-hero__editorial">
                {!! $data['editorial'] !!}
            </p>

            <p class="rc-hero__intro">
                {{ $data['intro'] }}
            </p>

            {{-- CTAs --}}
            <div class="rc-hero__actions">
                @foreach ($data['actions'] as $action)
                    @if ($action['style'] === 'primary')
                        <a
                            href="{{ $site['phone']['href'] }}"
                            class="mv-btn mv-btn--primary rc-hero__btn-primary"
                            data-inquiry="{{ $action['intent'] ?? 'request_availability' }}"
                            data-inquiry-care="{{ $action['care'] ?? 'respite_care' }}"
                            data-inquiry-source="rc-hero"
                        >
                            @include('partials.icon', ['name' => $action['icon'] ?? 'calendar', 'class' => 'mv-icon', 'stroke' => 1.6])
                            <span>{{ $action['label'] }}</span>
                            @include('partials.icon', ['name' => 'arrow', 'class' => 'mv-icon mv-btn__arrow', 'stroke' => 2])
                        </a>
                    @elseif ($action['style'] === 'phone')
                        <a href="{{ $site['phone']['href'] }}" class="rc-hero__phone">
                            @include('partials.icon', ['name' => 'phone', 'class' => 'mv-icon', 'stroke' => 1.6])
                            <span>{{ $site['phone']['display'] }}</span>
                        </a>
                    @else
                        <a
                            href="{{ $action['href'] ?? '#respite-planning' }}"
                            class="mv-btn mv-btn--ghost-light rc-hero__btn-ghost"
                        >
                            <span>{{ $action['label'] }}</span>
                            @include('partials.icon', ['name' => 'arrow', 'class' => 'mv-icon mv-btn__arrow', 'stroke' => 2])
                        </a>
                    @endif
                @endforeach
            </div>

            {{-- Provenance Pill --}}
            <div class="rc-hero__meta">
                <span class="rc-hero__provenance-badge">{{ $img['label'] }}</span>
            </div>
        </div>

        {{-- Compact Information Strip --}}
        @if (! empty($data['strip']))
            <div class="rc-hero__strip" role="region" aria-label="Respite Care Key Details">
                @foreach ($data['strip'] as $item)
                    <div class="rc-hero__strip-item">
                        <span class="rc-hero__strip-icon" aria-hidden="true">
                            @include('partials.icon', ['name' => $item['icon'], 'class' => 'mv-icon', 'stroke' => 1.5])
                        </span>
                        <div class="rc-hero__strip-text">
                            <span class="rc-hero__strip-kicker">{{ $item['kicker'] }}</span>
                            <h2 class="rc-hero__strip-title">{{ $item['title'] }}</h2>
                            <p class="rc-hero__strip-desc">{{ $item['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
