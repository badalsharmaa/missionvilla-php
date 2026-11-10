@php
    /** @var array $data  Normalised by App\Content\Sections\LifeGallerySection */
    $site = config('missionvilla');
    $leaf = asset('images/decor/botanical-leaf-shadow.svg');
    $url = fn (?string $path) => $path ? asset(ltrim($path, '/')) : null;
    $clock = function (?float $s): string {
        if (! $s) return '0:00';
        $s = (int) round($s);
        return intdiv($s, 60).':'.str_pad((string) ($s % 60), 2, '0', STR_PAD_LEFT);
    };

    // Chapter data handed to the player script (URLs resolved, nothing editor-controlled reaches markup unescaped).
    $playerData = [
        'labels' => $data['labels'],
        'chapters' => array_map(fn ($c) => [
            'id' => $c['id'],
            'available' => $c['media']['available'],
            'title' => $c['media']['title'],
            'sources' => array_map(fn ($s) => ['src' => $url($s['src']), 'type' => $s['type'], 'width' => $s['width']], $c['media']['sources']),
            'poster' => [
                'src' => $url($c['media']['poster']['src']),
                'srcMobile' => $url($c['media']['poster']['src_mobile']),
                'alt' => $c['media']['poster']['alt'],
                'position' => $c['media']['poster']['position'],
            ],
            'captions' => array_map(fn ($t) => ['src' => $url($t['src']), 'srclang' => $t['srclang'], 'label' => $t['label'], 'kind' => $t['kind']], $c['media']['captions']),
            'duration' => $c['media']['duration_seconds'],
            'hasAudio' => $c['media']['has_audio'],
            'provenanceLabel' => $c['media']['provenance_label'],
        ], $data['chapters']),
    ];

    $first = $data['chapters'][0];
    $m = $first['media'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/life-gallery.css', 'resources/js/sections/life-gallery.js'])
@endpush
{{--
    HOMEPAGE SECTION 03 · LIFE AT MISSION VILLA
    Approved mockup (2026-11-09). Three user-selected chapters share one 16:9 player.
    Static by design: no scroll-triggered motion, no automatic chapter cycling, no autoplay.
    Media contract: docs/SECTION_03_VIDEO_CONTRACT.md
--}}
<section class="life-gallery" id="life-at-mission-villa" aria-labelledby="life-gallery-title" data-life-gallery>
  <div class="life-gallery__leaves" aria-hidden="true">
    <img src="{{ $leaf }}" alt="" class="life-leaf life-leaf--top" loading="lazy" decoding="async">
    <img src="{{ $leaf }}" alt="" class="life-leaf life-leaf--low" loading="lazy" decoding="async">
  </div>

  <div class="life-gallery__inner">
    <header class="life-gallery__head">
      <p class="life-gallery__eyebrow">
        <span class="life-gallery__rule" aria-hidden="true"></span>
        <span>{{ $data['eyebrow'] }}</span>
        <span class="life-gallery__rule" aria-hidden="true"></span>
      </p>
      <h2 id="life-gallery-title" class="life-gallery__title">{!! \App\Content\InlineText::render($data['heading']) !!}</h2>
      <p class="life-gallery__sub">{{ $data['subheading'] }}</p>
    </header>

    <div class="life-gallery__layout">
      {{-- Chapter selector: ARIA tabs (vertical on desktop, a compact row on small screens). --}}
      <div class="life-nav" role="tablist" aria-label="Choose a part of life at Mission Villa" aria-orientation="vertical" data-life-tablist>
        @foreach ($data['chapters'] as $i => $chapter)
          <button
            type="button"
            role="tab"
            class="life-nav__tab"
            id="life-tab-{{ $chapter['id'] }}"
            aria-selected="{{ $i === 0 ? 'true' : 'false' }}"
            aria-controls="life-panel"
            tabindex="{{ $i === 0 ? '0' : '-1' }}"
            data-life-tab="{{ $i }}"
          >
            <span class="life-nav__icon">@include('sections.life-gallery.icon', ['name' => $chapter['icon'], 'stroke' => 1.5])</span>
            <span class="life-nav__label">{{ $chapter['label'] }}</span>
            @include('sections.life-gallery.icon', ['name' => 'chevron', 'class' => 'life-nav__chevron', 'stroke' => 1.8])
          </button>
        @endforeach
      </div>

      <div class="life-gallery__panel" id="life-panel" role="tabpanel" aria-labelledby="life-tab-{{ $first['id'] }}" data-life-panel>
        {{-- PLAYER: poster image until the visitor presses play; one <video> reused by all chapters. --}}
        <div
          class="life-player"
          data-life-player
          data-state="{{ $m['available'] ? 'idle' : 'unavailable' }}"
          data-has-audio="{{ $m['has_audio'] ? 'true' : 'false' }}"
          data-has-captions="{{ $m['captions'] ? 'true' : 'false' }}"
          role="region"
          aria-label="Video player: {{ $m['title'] }}"
        >
          <div class="life-player__stage" data-life-stage>
            <picture class="life-player__poster" data-life-poster>
              <source media="(max-width: 767px)" srcset="{{ $url($m['poster']['src_mobile'] ?? $m['poster']['src']) }}" data-life-poster-mobile>
              <img
                src="{{ $url($m['poster']['src']) }}"
                alt="{{ $m['poster']['alt'] }}"
                width="1600" height="900"
                loading="lazy"
                decoding="async"
                style="object-position: {{ $m['poster']['position'] }};"
                data-life-poster-img
              >
            </picture>

            {{-- No sources are emitted for chapters whose film is not on disk yet, and the element stays hidden. --}}
            <video
              class="life-player__video"
              preload="none"
              playsinline
              @if ($m['available']) controls poster="{{ $url($m['poster']['src']) }}" @else hidden @endif
              @if ($m['description']) aria-description="{{ $m['description'] }}" @endif
              data-life-video
            >
              @foreach ($m['sources'] as $source)
                <source src="{{ $url($source['src']) }}" type="{{ $source['type'] }}">
              @endforeach
              @foreach ($m['captions'] as $track)
                <track kind="{{ $track['kind'] }}" src="{{ $url($track['src']) }}" srclang="{{ $track['srclang'] }}" label="{{ $track['label'] }}">
              @endforeach
            </video>

            <span class="life-player__badge" data-life-badge>{{ $m['provenance_label'] }}</span>

            <button type="button" class="life-player__bigplay" data-life-action="toggle" aria-label="Play video: {{ $m['title'] }}" hidden>
              @include('sections.life-gallery.icon', ['name' => 'play', 'class' => 'life-player__bigplay-icon'])
            </button>

            <div class="life-player__spinner" aria-hidden="true"></div>

            {{-- Honest status for chapters without a film yet, and for load errors. --}}
            <div class="life-player__notice" data-life-notice @if ($m['available']) hidden @endif>
              <span class="life-player__notice-icon" data-life-notice-icon>@include('sections.life-gallery.icon', ['name' => 'film', 'stroke' => 1.5])</span>
              <span class="life-player__notice-text">
                <strong data-life-notice-title>{{ $data['labels']['unavailable'] }}</strong>
                <span data-life-notice-detail>{{ $data['labels']['unavailable_detail'] }}</span>
              </span>
              <button type="button" class="life-player__retry" data-life-action="retry" hidden>Try again</button>
            </div>

            {{-- Custom controls (revealed by JS; native controls remain without JS). --}}
            <div class="life-player__controls" data-life-controls hidden>
              <button type="button" class="life-ctl" data-life-action="toggle" aria-label="Play">
                @include('sections.life-gallery.icon', ['name' => 'play', 'class' => 'life-ctl__icon life-ctl__icon--play'])
                @include('sections.life-gallery.icon', ['name' => 'pause', 'class' => 'life-ctl__icon life-ctl__icon--pause'])
                @include('sections.life-gallery.icon', ['name' => 'replay', 'class' => 'life-ctl__icon life-ctl__icon--replay', 'stroke' => 2])
              </button>
              <span class="life-player__time" aria-hidden="true"><span data-life-current>0:00</span> / <span data-life-duration>{{ $clock($m['duration_seconds']) }}</span></span>
              <input type="range" class="life-range life-player__seek" min="0" max="1000" step="1" value="0" aria-label="Seek" aria-valuetext="0:00 of {{ $clock($m['duration_seconds']) }}" data-life-seek>
              <span class="life-player__volume" data-life-volume-group>
                <button type="button" class="life-ctl" data-life-action="mute" aria-label="Mute" aria-pressed="false">
                  @include('sections.life-gallery.icon', ['name' => 'volume', 'class' => 'life-ctl__icon life-ctl__icon--vol'])
                  @include('sections.life-gallery.icon', ['name' => 'muted', 'class' => 'life-ctl__icon life-ctl__icon--muted'])
                </button>
                <input type="range" class="life-range life-player__vol" min="0" max="100" step="5" value="100" aria-label="Volume" data-life-volume>
              </span>
              <button type="button" class="life-ctl" data-life-action="captions" aria-label="Captions" aria-pressed="false" data-life-cc>
                @include('sections.life-gallery.icon', ['name' => 'captions', 'class' => 'life-ctl__icon'])
              </button>
              <button type="button" class="life-ctl" data-life-action="fullscreen" aria-label="Enter full screen" data-life-fs>
                @include('sections.life-gallery.icon', ['name' => 'fullscreen', 'class' => 'life-ctl__icon life-ctl__icon--fs-enter', 'stroke' => 1.8])
                @include('sections.life-gallery.icon', ['name' => 'exit-fullscreen', 'class' => 'life-ctl__icon life-ctl__icon--fs-exit', 'stroke' => 1.8])
              </button>
            </div>
          </div>
          <p class="life-player__sr" role="status" aria-live="polite" data-life-live></p>
        </div>

        {{-- INFO: all three panels share one grid cell so the card keeps the tallest panel's height (no layout jump). --}}
        <div class="life-info" data-life-info>
          @foreach ($data['chapters'] as $i => $chapter)
            @php
              $cta = $chapter['cta'];
              $ctaLive = $cta && \App\Support\InternalLink::isAvailable($cta['href']);
            @endphp
            <article class="life-info__item" data-life-info-item="{{ $i }}" @if ($i !== 0) inert aria-hidden="true" @else data-active @endif>
              <p class="life-info__kicker">{{ $chapter['kicker'] }}</p>
              <h3 class="life-info__title">{{ $chapter['title'] }}</h3>
              <p class="life-info__text">{{ $chapter['description'] }}</p>
              @if ($cta && $ctaLive)
                <a href="{{ $cta['href'] }}" class="life-btn">
                  <span>{{ $cta['label'] }}</span>
                  @include('sections.life-gallery.icon', ['name' => 'arrow', 'class' => 'life-btn__arrow', 'stroke' => 2])
                </a>
              @elseif ($cta && $cta['fallback_label'])
                {{-- Destination page ({{ $cta['href'] }}) is not built in PHP yet: open the visit dialog instead. --}}
                <a href="{{ $site['phone']['href'] }}" class="life-btn" data-life-visit data-inquiry="schedule_visit">
                  <span>{{ $cta['fallback_label'] }}</span>
                  @include('sections.life-gallery.icon', ['name' => 'arrow', 'class' => 'life-btn__arrow', 'stroke' => 2])
                </a>
              @endif
            </article>
          @endforeach
        </div>
      </div>
    </div>

    <div class="life-gallery__actions">
      {{-- Opens the shared inquiry modal (visit intent). Without JavaScript it calls the community. --}}
      <a href="{{ $site['phone']['href'] }}" class="life-visit" data-life-visit data-inquiry="schedule_visit">
        @include('sections.life-gallery.icon', ['name' => 'calendar', 'class' => 'life-visit__icon', 'stroke' => 1.7])
        <span>{{ $data['visit_cta'] }}</span>
      </a>
      @if ($data['care_guide_cta'])
        {{-- Reuses the hero's Care Guide dialog via its delegated data-hero-action handler. Revealed by JS only when that dialog exists. --}}
        <button type="button" class="life-guide-link" data-hero-action="open-care-chat" data-life-guide hidden>
          @include('sections.life-gallery.icon', ['name' => 'chat', 'class' => 'life-guide-link__icon', 'stroke' => 1.7])
          <span>{{ $data['care_guide_cta'] }}</span>
        </button>
      @endif
    </div>
  </div>

  <script type="application/json" data-life-data>@json($playerData, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES)</script>
</section>
