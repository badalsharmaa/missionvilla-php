@php
    /** @var array $data  Normalised by App\Content\Sections\VisitCtaSection */
    $site = config('missionvilla');
    $addr = $site['address'];
    $leaf = asset('images/decor/botanical-leaf-shadow.svg');
    $notice = session('inquiry_notice');
@endphp
@push('section-assets')
    {{-- Script eyebrow uses Allura, the React reference's script face (also used by the opening shutters). --}}
    <link href="https://fonts.googleapis.com/css2?family=Allura&display=swap" rel="stylesheet">
    @vite(['resources/css/sections/visit-cta.css'])
@endpush
{{--
    HOMEPAGE SECTION 07 · COME SEE MISSION VILLA FOR YOURSELF
    Approved mockup "Mission Villa Suites, FAQ & Visit CTA" (bottom band, 2026-11-09).
    All three actions open the shared inquiry form (global, see components/inquiry/dialog)
    with their intent preselected. Without JavaScript they fall back to calling the community.
--}}
<section class="visit-cta" id="visit" aria-labelledby="visit-cta-title">
  <svg class="vc__wave" viewBox="0 0 1440 80" preserveAspectRatio="none" aria-hidden="true" focusable="false">
    <path class="vc__wave-fill" d="M0 52 C 260 30, 560 22, 860 40 C 1110 55, 1290 30, 1440 6 L 1440 80 L 0 80 Z"/>
  </svg>

  <div class="vc__inner">
    <img src="{{ $leaf }}" alt="" class="vc__leaf" aria-hidden="true" loading="lazy" decoding="async">
    <div class="vc__head">
      <p class="vc__script">{{ $data['script'] }}</p>
      <h2 id="visit-cta-title" class="vc__title">{{ $data['heading'] }}</h2>
    </div>

    <span class="vc__divider" aria-hidden="true"></span>

    <p class="vc__body">{{ $data['body'] }}</p>

    <div class="vc__side">
      <div class="vc__actions">
        @foreach ($data['actions'] as $action)
          <a
            href="{{ $site['phone']['href'] }}"
            class="mv-btn {{ $action['primary'] ? 'mv-btn--primary' : 'mv-btn--ghost-light' }} vc__btn"
            data-inquiry="{{ $action['intent'] }}"
          >
            @include('partials.icon', ['name' => $action['icon'], 'class' => 'mv-icon', 'stroke' => 1.6])
            <span>{{ $action['label'] }}</span>
            @include('partials.icon', ['name' => 'arrow', 'class' => 'mv-icon mv-btn__arrow', 'stroke' => 2])
          </a>
        @endforeach
      </div>

      @if ($data['show_contact'])
        <ul class="vc__contact">
          <li class="vc__contact-item">
            @include('partials.icon', ['name' => 'pin', 'class' => 'vc__contact-icon', 'stroke' => 1.4])
            <address class="vc__address">
              <span>{{ $addr['street'] }},</span>
              <span>{{ $addr['city'] }}, {{ $addr['region'] }} {{ $addr['postal_code'] }}</span>
            </address>
          </li>
          <li class="vc__contact-item">
            @include('partials.icon', ['name' => 'phone', 'class' => 'vc__contact-icon', 'stroke' => 1.4])
            <a href="{{ $site['phone']['href'] }}" class="vc__phone" aria-label="Call Mission Villa at {{ $site['phone']['display'] }}">{{ $site['phone']['display'] }}</a>
          </li>
        </ul>
      @endif

      @if (is_array($notice) && isset($notice['message']))
        {{-- Shown after a form post without JavaScript (InquiryController redirects back here). --}}
        <p class="vc__notice" role="status">{{ $notice['message'] }}</p>
      @endif
    </div>
  </div>
</section>
