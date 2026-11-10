@php
    /** @var array $data  Normalised by App\Content\Sections\CareOptionsSection */
    $site = config('missionvilla');
    $leaf = asset('images/decor/botanical-leaf-shadow.svg');
@endphp
@push('section-assets')
    @vite(['resources/css/sections/care-options.css', 'resources/js/sections/care-options.js'])
@endpush
{{--
    HOMEPAGE SECTION 02 · CARE OPTIONS
    Approved mockups (2026-11-09): front faces by default; hovering (desktop),
    clicking/tapping or pressing the corner toggle flips a card to its detail face.
    Static by design: no scroll-triggered or automatic motion.
--}}
<section class="care-options" id="care-options" aria-labelledby="care-options-title" data-care-options>
  {{-- Soft leaf shadows: botanical SVG softened with CSS blur + opacity (decorative). --}}
  <div class="care-options__leaves" aria-hidden="true">
    <img src="{{ $leaf }}" alt="" class="care-leaf care-leaf--top" loading="lazy" decoding="async">
    <img src="{{ $leaf }}" alt="" class="care-leaf care-leaf--low" loading="lazy" decoding="async">
  </div>

  <div class="care-options__inner">
    <header class="care-options__head">
      <p class="care-options__eyebrow">
        <span class="care-options__rule" aria-hidden="true"></span>
        <span>{{ $data['eyebrow'] }}</span>
        <span class="care-options__rule" aria-hidden="true"></span>
      </p>
      <h2 id="care-options-title" class="care-options__title">{!! \App\Content\InlineText::render($data['heading']) !!}</h2>
      <p class="care-options__sub">{{ $data['subheading'] }}</p>
    </header>

    <div class="care-options__grid">
      @foreach ($data['cards'] as $card)
        @php
          $id = 'care-'.$card['id'];
          $tone = $card['cta']['style'] === 'cream' ? 'warm' : 'plum';
        @endphp
        {{-- Image provenance: {{ $card['image']['provenance'] }}@if ($card['image']['source_url']) · source: {{ $card['image']['source_url'] }}@endif --}}
        <article class="care-card care-card--{{ $tone }}" data-care-card data-flipped="false" aria-labelledby="{{ $id }}-title">
          {{-- Keyboard / tap alternative to hover. Sits outside both faces so it never becomes inert. Revealed by JS. --}}
          <button
            type="button"
            class="care-card__toggle"
            data-care-toggle
            aria-pressed="false"
            aria-controls="{{ $id }}-back"
            aria-label="Show details: {{ $card['title'] }}"
            data-label-show="Show details: {{ $card['title'] }}"
            data-label-hide="Show summary: {{ $card['title'] }}"
            hidden
          >
            @include('sections.care-options.icon', ['name' => 'plus', 'class' => 'care-card__toggle-icon', 'stroke' => 1.8])
          </button>

          <div class="care-card__inner">
            {{-- FRONT FACE (mockup 1) --}}
            <div class="care-card__face care-card__face--front" data-face="front">
              <picture class="care-card__media" data-provenance="{{ $card['image']['provenance'] }}">
                @if ($card['image']['src_mobile'])
                  <source media="(max-width: 767px)" srcset="{{ asset(ltrim($card['image']['src_mobile'], '/')) }}">
                @endif
                <img
                  src="{{ asset(ltrim($card['image']['src'], '/')) }}"
                  alt="{{ $card['image']['alt'] }}"
                  loading="lazy"
                  decoding="async"
                  style="object-position: {{ $card['image']['position'] }};"
                >
              </picture>
              <div class="care-card__scrim" aria-hidden="true"></div>

              <div class="care-card__content">
                <span class="care-card__tile">@include('sections.care-options.icon', ['name' => $card['icon']])</span>
                <p class="care-card__kicker">{{ $card['kicker'] }}</p>
                <h3 id="{{ $id }}-title" class="care-card__title">{{ $card['title'] }}</h3>
                <p class="care-card__summary">{{ $card['summary'] }}</p>
                <a href="{{ $card['cta']['href'] }}" class="care-btn care-btn--{{ $card['cta']['style'] }}">
                  <span>{{ $card['cta']['label'] }}</span>
                  @include('sections.care-options.icon', ['name' => 'arrow', 'class' => 'care-btn__arrow', 'stroke' => 2])
                </a>
              </div>
            </div>

            {{-- BACK FACE (mockup 2) --}}
            <div class="care-card__face care-card__face--back" id="{{ $id }}-back" data-face="back" inert>
              <img src="{{ $leaf }}" alt="" class="care-card__back-leaf" aria-hidden="true" loading="lazy" decoding="async">
              <div class="care-card__back-body">
                <div class="care-card__back-head">
                  <span class="care-card__tile care-card__tile--sm">@include('sections.care-options.icon', ['name' => $card['icon']])</span>
                  <p class="care-card__kicker care-card__kicker--inline">{{ $card['back']['kicker'] }}</p>
                </div>
                <p class="care-card__statement">{{ $card['back']['statement'] }}</p>
                <ul class="care-card__benefits">
                  @foreach ($card['back']['benefits'] as $benefit)
                    <li>
                      @include('sections.care-options.icon', ['name' => $benefit['icon'], 'class' => 'care-card__benefit-icon', 'stroke' => 1.5])
                      <span>{{ $benefit['text'] }}</span>
                    </li>
                  @endforeach
                </ul>
                <div class="care-card__back-foot">
                  <div class="care-card__audience">
                    <p class="care-card__kicker care-card__kicker--small">{{ $card['back']['audience_label'] }}</p>
                    <p class="care-card__audience-text">{{ $card['back']['audience'] }}</p>
                  </div>
                  <a href="{{ $card['cta']['href'] }}" class="care-btn care-btn--{{ $card['cta']['style'] }}">
                    <span>{{ $card['cta']['label'] }}</span>
                    @include('sections.care-options.icon', ['name' => 'arrow', 'class' => 'care-btn__arrow', 'stroke' => 2])
                  </a>
                </div>
              </div>
            </div>
          </div>
        </article>
      @endforeach
    </div>

    <div class="care-options__actions">
      {{-- Opens the shared inquiry modal (visit intent). Without JavaScript it calls the community. --}}
      <a href="{{ $site['phone']['href'] }}" class="care-visit" data-care-visit data-inquiry="schedule_visit">
        @include('sections.care-options.icon', ['name' => 'calendar', 'class' => 'care-visit__icon', 'stroke' => 1.7])
        <span>{{ $data['visit_cta'] }}</span>
      </a>
      @if ($data['care_guide_cta'])
        {{-- Reuses the hero's Care Guide dialog via its delegated data-hero-action handler. Revealed by JS only when that dialog exists. --}}
        <button type="button" class="care-guide-link" data-hero-action="open-care-chat" data-care-guide hidden>
          @include('sections.care-options.icon', ['name' => 'chat', 'class' => 'care-guide-link__icon', 'stroke' => 1.7])
          <span>{{ $data['care_guide_cta'] }}</span>
        </button>
      @endif
    </div>
  </div>
</section>
