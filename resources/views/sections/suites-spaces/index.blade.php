@php
    /** @var array $data  Normalised by App\Content\Sections\SuitesSpacesSection */
    $options = $data['options'];
    $img = fn (string $p) => asset(ltrim($p, '/'));
@endphp
@push('section-assets')
    @vite(['resources/css/sections/suites-spaces.css', 'resources/js/sections/suites-spaces.js'])
@endpush
{{--
    HOMEPAGE SECTION 05 · SUITES & LIVING SPACES
    Approved mockup "Mission Villa Suites, FAQ & Visit CTA" (top band, 2026-11-09).
    Three ARIA tabs switch one photo frame (image, caption, CTA) with a short fade.
    User-initiated only: no cycling, no scroll-driven motion.
--}}
<section class="suites-spaces" id="suites" aria-labelledby="suites-title" data-suites>
  <div class="ss__inner">
    <div class="ss__story">
      <p class="mv-eyebrow ss__eyebrow">
        <span class="mv-eyebrow__rule" aria-hidden="true"></span>
        <span>{{ $data['eyebrow'] }}</span>
      </p>
      <h2 id="suites-title" class="mv-title ss__title">{!! \App\Content\InlineText::render($data['heading']) !!}</h2>
      <p class="ss__intro">{{ $data['intro'] }}</p>

      <div class="ss__tabs" role="tablist" aria-label="Suites and living spaces" data-ss-tablist>
        @foreach ($options as $i => $opt)
          <button
            type="button"
            role="tab"
            class="ss-tab"
            id="ss-tab-{{ $opt['id'] }}"
            aria-controls="ss-panel-{{ $opt['id'] }}"
            aria-selected="{{ $i === 0 ? 'true' : 'false' }}"
            tabindex="{{ $i === 0 ? '0' : '-1' }}"
            data-ss-tab
          >
            @include('partials.icon', ['name' => $opt['icon'], 'class' => 'ss-tab__icon', 'stroke' => 1.4])
            <span class="ss-tab__label">{{ $opt['label'] }}</span>
          </button>
        @endforeach
      </div>
    </div>

    <div class="ss__stage" data-ss-stage>
      @foreach ($options as $i => $opt)
        @php $im = $opt['image']; @endphp
        <figure
          class="ss-panel"
          role="tabpanel"
          id="ss-panel-{{ $opt['id'] }}"
          aria-labelledby="ss-tab-{{ $opt['id'] }}"
          tabindex="0"
          data-ss-panel
          data-active="{{ $i === 0 ? 'true' : 'false' }}"
          data-fit="{{ $im['fit'] }}"
          data-provenance="{{ $im['provenance'] }}"
          data-rights="{{ $im['rights'] }}"
          @if ($i !== 0) inert @endif
        >
          {{-- Image provenance: {{ $im['provenance'] }} · rights: {{ $im['rights'] }}@if ($im['source_url']) · source: {{ $im['source_url'] }}@endif --}}
          <picture class="ss-panel__media">
            @if ($im['src_mobile'])
              <source media="(max-width: 767px)" srcset="{{ $img($im['src_mobile']) }}">
            @endif
            <img
              src="{{ $img($im['src']) }}"
              alt="{{ $im['alt'] }}"
              width="{{ $im['width'] }}"
              height="{{ $im['height'] }}"
              loading="lazy"
              decoding="async"
              style="object-position: {{ $im['position'] }};"
            >
          </picture>
          <span class="ss-panel__badge">{{ $im['label'] }}</span>

          <figcaption class="ss-panel__caption">
            <span class="ss-panel__kicker">{{ $opt['kicker'] }}</span>
            <span class="ss-panel__line">{{ $opt['caption'] }}</span>
            @if ($opt['detail'])
              <span class="ss-panel__detail">{{ $opt['detail'] }}</span>
            @endif
          </figcaption>

          @if ($opt['cta'])
            @if ($opt['cta']['href'])
              <a href="{{ url($opt['cta']['href']) }}" class="ss-cta">
                <span>{{ $opt['cta']['label'] }}</span>
                @include('partials.icon', ['name' => 'arrow', 'class' => 'ss-cta__arrow', 'stroke' => 2])
              </a>
            @else
              {{-- Destination page not built yet: open the shared inquiry form instead (tel: without JavaScript). --}}
              <a
                href="{{ config('missionvilla.phone.href') }}"
                class="ss-cta"
                data-inquiry="{{ $opt['cta']['intent'] }}"
                data-inquiry-suite="{{ $opt['id'] }}"
              >
                <span>{{ $opt['cta']['label'] }}</span>
                @include('partials.icon', ['name' => 'arrow', 'class' => 'ss-cta__arrow', 'stroke' => 2])
              </a>
            @endif
          @endif
        </figure>
      @endforeach
    </div>
  </div>
</section>
