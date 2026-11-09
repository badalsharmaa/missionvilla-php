@php
    /** @var array $data  Normalised by App\Content\Sections\HeroCinematicSection */
    $site = config('missionvilla');
    $slides = $data['slides'];
    $first = $slides[0];
    $guide = $data['care_guide'];
    $client = \App\Content\Sections\HeroCinematicSection::clientSlides($data);
@endphp
@push('preload')
    <link rel="preload" as="image" href="{{ asset(ltrim($first['image']['src_mobile'] ?? $first['image']['src'], '/')) }}" media="(max-width: 1023px)" fetchpriority="high">
    <link rel="preload" as="image" href="{{ asset(ltrim($first['image']['src'], '/')) }}" media="(min-width: 1024px)" fetchpriority="high">
@endpush
@push('section-assets')
    @vite(['resources/css/sections/hero-cinematic.css', 'resources/js/sections/hero-cinematic.js'])
@endpush
{{--
    APPROVED CINEMATIC HERO — ported from mission_villa_cinematic_hero_final.html.
    Markup classes are kept identical to the approved prototype. Do not redesign.
--}}
<section
  class="hero-viewport"
  data-hero-cinematic
  data-autoplay-seconds="{{ $data['autoplay_seconds'] }}"
  aria-label="Mission Villa Senior Living Stories"
  id="heroSection"
>

  {{-- PLANE 1: FULL-BLEED BACKGROUND PHOTOGRAPHY STAGE (z-index: 1) --}}
  <div class="bg-stage" id="bgStage">
    @foreach ($slides as $i => $slide)
      {{-- Image provenance: {{ $slide['image']['provenance'] }}@if ($slide['image']['source_url']) · source: {{ $slide['image']['source_url'] }}@endif --}}
      <div class="bg-slide" data-index="{{ $i }}" data-provenance="{{ $slide['image']['provenance'] }}" style="z-index: {{ 3 - $i }};">
        <picture>
          @if ($slide['image']['src_mobile'])
            <source media="(max-width: 1023px)" srcset="{{ asset(ltrim($slide['image']['src_mobile'], '/')) }}">
          @endif
          <img
            src="{{ asset(ltrim($slide['image']['src'], '/')) }}"
            alt="{{ $slide['image']['alt'] }}"
            data-fallback-index="{{ $i }}"
            decoding="async"
            fetchpriority="{{ $i === 0 ? 'high' : 'low' }}"
          />
        </picture>
      </div>
    @endforeach
  </div>

  {{-- CRITICAL LAYER: DARK-PLUM-TO-TRANSPARENT MULTI-STOP SCRIM (z-index: 5) --}}
  <div class="editorial-scrim" aria-hidden="true"></div>

  {{-- SUBTLE ARCHITECTURAL HAIRLINES (z-index: 6) --}}
  <div class="architectural-hairlines" aria-hidden="true">
    <div class="architectural-hairlines-inner"></div>
  </div>

  {{-- ======================================================================
       FOREGROUND CONTENT STAGE (z-index: 10)
       ====================================================================== --}}
  <div class="hero-grid">

    {{-- LEFT COLUMN: CHOREOGRAPHED EDITORIAL STORYTELLING & CONVERSION --}}
    <div class="flex flex-col justify-center max-w-2xl">

      {{-- Chapter Eyebrow & Service Tag --}}
      <div class="flex flex-wrap items-center gap-2.5 mb-3 lg:mb-[1.6svh]">
        <span
          id="slideChapterPill"
          class="inline-flex items-center gap-2 px-3 py-1 rounded-md text-[11px] font-semibold uppercase tracking-[0.14em] bg-[#F9F5F0]/10 text-[#F3C6B6] border border-[#F9F5F0]/15"
        >
          <span class="w-1.5 h-1.5 rounded-full bg-[#C86D51]"></span>
          <span id="slideEyebrowText">{{ $first['eyebrow'] }}</span>
        </span>
        <span class="text-xs font-medium tracking-wide text-[#F9F5F0]/75">
          {{ $site['locality'] }}
        </span>
      </div>

      {{-- Masked 3-Line Editorial Serif Headline (46–54px Desktop, Weight 600) --}}
      <h1 class="hero-headline mb-3.5 lg:mb-[2svh]" aria-live="polite">
        <span class="block headline-mask">
          <span id="headlineLine1" class="block">{!! $client[0]['line1'] !!}</span>
        </span>
        <span class="block headline-mask">
          <span id="headlineLine2" class="block">{!! $client[0]['line2'] !!}</span>
        </span>
        <span class="block headline-mask">
          <span id="headlineLine3" class="block">{!! $client[0]['line3'] !!}</span>
        </span>
      </h1>

      {{-- Supporting Copy with High-Contrast Protection --}}
      <p id="slideBodyCopy" class="hero-body-copy mb-5 lg:mb-[2.8svh]">
        {!! $client[0]['body'] !!}
      </p>

      {{-- Primary & Secondary Conversion CTAs (Consistent 9px Radius) --}}
      <div class="flex flex-wrap items-center gap-3.5 mb-5 lg:mb-[2.8svh]">
        <button
          type="button"
          data-hero-action="open-visit"
          class="btn-primary-visit"
        >
          <span id="primaryCtaLabel">{{ $first['cta'] }}</span>
          <svg class="w-4 h-4 cta-arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M7 17L17 7M17 7H8M17 7V16" />
          </svg>
        </button>

        <a
          href="{{ $site['phone']['href'] }}"
          class="btn-secondary-phone"
          title="Call Mission Villa Daly City directly"
        >
          <svg class="w-4 h-4 text-[#F3C6B6]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
          </svg>
          <span>{{ $site['phone']['display'] }}</span>
        </a>
      </div>

      {{-- Subtle Conversational Entry Point --}}
      <div class="pt-3.5 border-t border-[#F9F5F0]/15 max-w-lg">
        <button
          type="button"
          data-hero-action="open-care-chat"
          class="group text-left inline-flex flex-wrap items-center gap-x-2.5 gap-y-1 py-1 text-sm text-[#F9F5F0]/90 hover:text-white transition-colors"
        >
          <span class="inline-flex items-center gap-2 font-medium text-[#F3C6B6]">
            <span class="w-2 h-2 rounded-full bg-[#6E8F7D] ring-4 ring-[#6E8F7D]/20"></span>
            <span>Need help exploring care options?</span>
          </span>
          <span class="underline decoration-[#F3C6B6]/50 underline-offset-4 group-hover:decoration-[#F3C6B6] font-medium">
            Let’s walk through it together &rarr;
          </span>
        </button>
      </div>

    </div>

    {{-- RIGHT COLUMN: COMPACT CARE GUIDE ENTRY — not a decorative photo card --}}
    <div class="hidden lg:flex flex-col items-end justify-center">
      <aside id="careGuidePreview" class="care-guide-preview" aria-labelledby="careGuidePreviewTitle">
        <div class="flex items-center justify-between gap-3 mb-3">
          <div class="inline-flex items-center gap-2.5">
            <div class="guide-mark" aria-hidden="true">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 11.5a7.5 7.5 0 0 1-7.5 7.5H8l-4 2v-5a7.5 7.5 0 1 1 16-4.5Z"/><path d="M8.4 11.7h.01M12 11.7h.01M15.6 11.7h.01" stroke-width="2.4"/>
              </svg>
            </div>
            <div>
              <p class="guide-kicker">{{ $guide['kicker'] }}</p>
              <p class="guide-brand">{{ $guide['brand'] }}</p>
            </div>
          </div>
          <span class="guide-preview-tag">{{ $guide['tag'] }}</span>
        </div>

        <h2 id="careGuidePreviewTitle" class="font-serif-editorial guide-title">{{ $guide['title'] }}</h2>
        <p class="guide-description">{{ $guide['description'] }}</p>

        <div class="guide-choice-list" aria-label="Suggested questions">
            @foreach ($guide['choices'] as $choice)
            <button type="button" class="guide-choice" data-hero-action="open-care-chat" data-question="{{ $choice['question'] }}">
              <span>{{ $choice['label'] }}</span><span aria-hidden="true" class="guide-arrow">↗</span>
            </button>
            @endforeach
        </div>

        <form class="guide-ask-row" id="carePreviewForm">
          <label class="sr-only" for="carePreviewQuestion">Ask your own question</label>
          <input id="carePreviewQuestion" type="text" maxlength="300" autocomplete="off" placeholder="{{ $guide['placeholder'] }}" aria-label="Ask your own care question" required />
          <button type="submit" aria-label="Open care guide with your question" title="Ask the care guide">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-6-6 6 6-6 6" /></svg>
          </button>
        </form>
        <p class="guide-footnote">{{ $guide['footnote'] }}</p>
      </aside>
    </div>

  </div>

  {{-- ======================================================================
       BOTTOM ARCHITECTURAL CHAPTER BAR & FACTUAL PROVENANCE LEDGER (z-index: 10)
       ====================================================================== --}}
  <div class="relative z-10 w-full border-t border-[#F9F5F0]/14 bg-[#180F17]/80 backdrop-blur-md px-[var(--pad-x)] py-2.5 lg:py-[1.3svh]">
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3">

      {{-- 3 Interactive Story Chapter Selectors --}}
      <div class="grid grid-cols-3 gap-2 sm:gap-4 flex-1 max-w-3xl" role="tablist" aria-label="Mission Villa Living Stories">
        @foreach ($slides as $i => $slide)
          <button
            type="button"
            role="tab"
            id="chapterBtn{{ $i }}"
            aria-selected="{{ $i === 0 ? 'true' : 'false' }}"
            data-hero-action="go-to-slide" data-slide="{{ $i }}"
            class="chapter-tab"
          >
            <div class="flex items-center gap-2">
              <span class="text-[11px] font-mono font-semibold text-[#F3C6B6]">{{ str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) }}</span>
              <span class="text-xs sm:text-[13px] {{ $i === 0 ? 'font-semibold text-white' : 'font-medium text-[#F9F5F0]/80' }} truncate">{{ $slide['chapter_title'] }}</span>
            </div>
            <p class="hidden sm:block text-[11px] text-[#F9F5F0]/65 truncate mt-0.5">
              {{ $slide['chapter_subtitle'] }}
            </p>
            <div class="chapter-progress-track">
              <div id="progressFill{{ $i }}" class="chapter-progress-fill" @if ($i === 0) style="transform: scaleX(1);" @endif></div>
            </div>
          </button>
        @endforeach
      </div>

      {{-- Right Controls & Factual Licensure Strip --}}
      <div class="flex flex-wrap items-center justify-between lg:justify-end gap-4 pt-1 lg:pt-0 border-t lg:border-t-0 border-[#F9F5F0]/10">

        {{-- Factual Address & RCFE License --}}
        <div class="text-[11px] text-[#F9F5F0]/75 flex flex-wrap items-center gap-x-3 gap-y-1">
          <span>{{ $site['address']['street_short'] }}, {{ $site['address']['city'] }}, {{ $site['address']['region'] }} {{ $site['address']['postal_code'] }}</span>
          <span class="text-[#F9F5F0]/30">&middot;</span>
          <span>{{ $site['license']['label'] }} #{{ $site['license']['number'] }}</span>
        </div>

        {{-- Slider Prev / Next / Autoplay Pause Controls (8px Radius) --}}
        <div class="flex items-center gap-1.5" aria-label="Slide navigation controls">
          <button
            type="button"
            data-hero-action="prev-slide"
            class="slider-ctrl-btn"
            aria-label="Previous story chapter"
            title="Previous story (Left Arrow)"
          >
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
          </button>

          <button
            type="button"
            id="autoplayToggleBtn"
            data-hero-action="toggle-autoplay"
            class="slider-ctrl-btn !w-auto px-2.5 text-[11px] font-medium gap-1.5"
            aria-label="Pause or resume story cycling"
            title="Pause or resume automatic story advance"
          >
            <span id="autoplayStatusDot" class="w-1.5 h-1.5 rounded-full bg-[#6E8F7D]"></span>
            <span id="autoplayStatusText">Auto</span>
          </button>

          <button
            type="button"
            data-hero-action="next-slide"
            class="slider-ctrl-btn"
            aria-label="Next story chapter"
            title="Next story (Right Arrow)"
          >
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
          </button>
        </div>

      </div>

    </div>
  </div>

</section>

<script type="application/json" id="heroSlidesData">@json($client, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP)</script>

@include('sections.hero-cinematic.care-chat')
@include('sections.hero-cinematic.concierge')
@include('sections.hero-cinematic.visit')
