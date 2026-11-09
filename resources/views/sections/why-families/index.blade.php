@php
    /** @var array $data  Normalised by App\Content\Sections\WhyFamiliesSection */
    $img = $data['image'];
    $tour = $data['tour_cta'];
    $leaf = asset('images/decor/botanical-leaf-shadow.svg');
    $mark = asset('images/brand/mission-villa-mark-160.webp');
    $href = fn (string $h) => str_starts_with($h, '#') ? $h : (str_starts_with($h, '/') ? url($h) : $h);
@endphp
@push('section-assets')
    @vite(['resources/css/sections/why-families.css', 'resources/js/sections/why-families.js'])
@endpush
{{--
    HOMEPAGE SECTION 04 · WHY FAMILIES CHOOSE MISSION VILLA
    Approved mockup "A Trusted Partner in Care" (2026-11-09). Static by design:
    no scroll-driven reveals, parallax, counters or carousels. Hover states only.
    Image provenance: {{ $img['provenance'] }} · rights: {{ $img['rights'] }}@if ($img['source_url']) · source: {{ $img['source_url'] }}@endif
--}}
<section class="why-families" id="why-families" aria-labelledby="why-families-title" data-why-families>
  <div class="wf__stage">
    {{-- Courtyard photograph. Decorative washes keep the headline readable; the photo itself is not colour-graded. --}}
    <figure class="wf__media" data-provenance="{{ $img['provenance'] }}" data-rights="{{ $img['rights'] }}">
      <picture>
        @if ($img['src_mobile'])
          <source media="(max-width: 767px)" srcset="{{ asset(ltrim($img['src_mobile'], '/')) }}">
        @endif
        <img
          src="{{ asset(ltrim($img['src'], '/')) }}"
          alt="{{ $img['alt'] }}"
          width="1024"
          height="683"
          loading="lazy"
          decoding="async"
          style="object-position: {{ $img['position'] }};"
        >
      </picture>
      @if ($img['caption'])
        <figcaption class="wf__caption">{{ $img['caption'] }}</figcaption>
      @endif
    </figure>
    <div class="wf__wash" aria-hidden="true"></div>

    <div class="wf__layout">
      <div class="wf__story">
        <p class="wf__eyebrow">
          <span class="wf__rule" aria-hidden="true"></span>
          <span>{{ $data['eyebrow'] }}</span>
          <span class="wf__rule" aria-hidden="true"></span>
        </p>
        <h2 id="why-families-title" class="wf__title">{!! \App\Content\InlineText::render($data['heading']) !!}</h2>
        <p class="wf__body">{{ $data['body'] }}</p>

        <div class="wf__actions">
          {{-- Opens the hero's visit dialog when present (window.MissionVilla.openVisit); otherwise follows the link. --}}
          <a href="{{ $href($data['primary_cta']['href']) }}" class="wf-btn wf-btn--primary" data-wf-visit>
            <span>{{ $data['primary_cta']['label'] }}</span>
            @include('sections.why-families.icon', ['name' => 'arrow', 'class' => 'wf-btn__arrow', 'stroke' => 2])
          </a>
          @if ($tour)
            <a href="{{ $href($tour['href']) }}" class="wf-tour" data-wf-tour @if ($tour['pending']) data-pending="true" aria-describedby="wf-tour-note" @endif>
              @include('sections.why-families.icon', ['name' => 'play', 'class' => 'wf-tour__icon', 'stroke' => 1.5])
              <span class="wf-tour__text">
                <span class="wf-tour__label">{{ $tour['label'] }}</span>
                @if ($tour['pending'] && $tour['pending_note'])
                  <span class="wf-tour__note" id="wf-tour-note">{{ $tour['pending_note'] }}</span>
                @endif
              </span>
            </a>
          @endif
        </div>
      </div>

      <aside class="wf-glance" aria-labelledby="wf-glance-title">
        <header class="wf-glance__head">
          <img src="{{ $mark }}" alt="" class="wf-glance__mark" width="40" height="40" loading="lazy" decoding="async">
          <h3 id="wf-glance-title" class="wf-glance__title">
            <span class="wf-glance__kicker">{{ $data['glance']['kicker'] }}</span>
            <span class="wf-glance__sub">{{ $data['glance']['title'] }}</span>
          </h3>
        </header>
        <ul class="wf-glance__list">
          @foreach ($data['glance']['facts'] as $fact)
            <li class="wf-fact">
              @include('sections.why-families.icon', ['name' => $fact['icon'], 'class' => 'wf-fact__icon', 'stroke' => 1.4])
              <div>
                <p class="wf-fact__title">{{ $fact['title'] }}</p>
                <p class="wf-fact__text">{{ $fact['text'] }}</p>
              </div>
            </li>
          @endforeach
        </ul>
      </aside>
    </div>
  </div>

  <div class="wf-values">
    {{-- Wave edge with a fine warm hairline (decorative). --}}
    <svg class="wf-values__wave" viewBox="0 0 1440 80" preserveAspectRatio="none" aria-hidden="true" focusable="false">
      <path class="wf-values__wave-fill" d="M0 34 C 170 4, 420 8, 720 46 C 980 78, 1210 62, 1440 26 L 1440 80 L 0 80 Z"/>
      <path class="wf-values__wave-line" d="M0 34 C 170 4, 420 8, 720 46 C 980 78, 1210 62, 1440 26"/>
    </svg>
    <img src="{{ $leaf }}" alt="" class="wf-values__leaf" aria-hidden="true" loading="lazy" decoding="async">
    <h3 class="wf-values__heading">Our values</h3>
    <ul class="wf-values__list">
      @foreach ($data['values'] as $value)
        <li class="wf-value">
          @include('sections.why-families.icon', ['name' => $value['icon'], 'class' => 'wf-value__icon', 'stroke' => 1.3])
          <p class="wf-value__title">{{ $value['title'] }}</p>
          <p class="wf-value__text">{{ $value['text'] }}</p>
        </li>
      @endforeach
    </ul>
  </div>
</section>
