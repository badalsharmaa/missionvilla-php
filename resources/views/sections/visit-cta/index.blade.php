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
    Approved mockup "Mission Villa Suites, FAQs & Visits" (bottom band, corrected 2026-11-10).
    Independent full-width deep-plum section. Left: invitation, three vertical actions, contact.
    Right: the inline cream inquiry card (shared form, components/inquiry/form).
    The three actions open the shared inquiry MODAL with their intent (website-wide rule: form CTAs
    never scroll to a form). Without JavaScript they call the community; the inline form still posts.
--}}
<section class="visit-cta" id="visit" aria-labelledby="visit-cta-title">
  <svg class="vc__wave" viewBox="0 0 1440 80" preserveAspectRatio="none" aria-hidden="true" focusable="false">
    <path class="vc__wave-fill" d="M0 52 C 260 30, 560 22, 860 40 C 1110 55, 1290 30, 1440 6 L 1440 80 L 0 80 Z"/>
  </svg>

  <div class="vc__inner" @if (! $data['form']) data-no-form @endif>
    <img src="{{ $leaf }}" alt="" class="vc__leaf" aria-hidden="true" loading="lazy" decoding="async">

    <div class="vc__story">
      <p class="vc__script">{{ $data['script'] }}</p>
      <h2 id="visit-cta-title" class="vc__title">{{ $data['heading'] }}</h2>
      <p class="vc__body">{{ $data['body'] }}</p>

      <div class="vc__actions">
        @foreach ($data['actions'] as $action)
          <a
            href="{{ $site['phone']['href'] }}"
            class="mv-btn {{ $action['primary'] ? 'mv-btn--primary' : 'mv-btn--ghost-light' }} vc__btn"
            data-inquiry="{{ $action['intent'] }}"
            @if (! empty($data['care'])) data-inquiry-care="{{ $data['care'] }}" @endif
            data-inquiry-source="visit-cta"
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
              <span class="vc__name">{{ $site['name'] }}</span>
              <span>{{ $addr['street'] }}</span>
              <span>{{ $addr['city'] }}, {{ $addr['region'] }} {{ $addr['postal_code'] }}</span>
            </address>
          </li>
          <li class="vc__contact-item">
            @include('partials.icon', ['name' => 'phone', 'class' => 'vc__contact-icon', 'stroke' => 1.4])
            <a href="{{ $site['phone']['href'] }}" class="vc__phone" aria-label="Call Mission Villa at {{ $site['phone']['display'] }}">{{ $site['phone']['display'] }}</a>
          </li>
        </ul>
      @endif
    </div>

    @if ($data['form'])
      <span class="vc__divider" aria-hidden="true"></span>

      <div class="vc__card" id="visit-form" aria-labelledby="visit-form-title" role="region" data-inquiry-inline>
        <h3 class="vc__card-title" id="visit-form-title">{{ $data['form']['heading'] }}</h3>
        <p class="vc__card-lede">{{ $data['form']['lede'] }}</p>
        @if (is_array($notice) && isset($notice['message']))
          {{-- Shown after a form post without JavaScript (InquiryController redirects back here). --}}
          <p class="vc__notice" role="status" data-status="{{ $notice['status'] ?? '' }}">{{ $notice['message'] }}</p>
        @endif
        <x-inquiry.form instance="inline" :source="! empty($data['care']) ? ($data['care'] === 'respite_care' ? 'rc-cta' : 'mc-cta') : 'visit-form'" :care="$data['care'] ?? null" />
      </div>
    @elseif (is_array($notice) && isset($notice['message']))
      <p class="vc__notice" role="status">{{ $notice['message'] }}</p>
    @endif
  </div>
</section>
