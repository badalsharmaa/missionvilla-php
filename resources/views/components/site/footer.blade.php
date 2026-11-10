@php
    /*
     * Global site footer, rendered by the site layout on every page.
     * Content: config/navigation.php → footer (future CMS menus) + verified
     * business facts from config/missionvilla.php. Links are resolved by
     * App\Support\FooterNavigation, so unbuilt pages fall back to an existing
     * homepage anchor or are left out; legal links appear only once routed.
     */
    $site = config('missionvilla');
    $footer = config('navigation.footer');
    $groups = \App\Support\FooterNavigation::groups($footer['groups'] ?? []);
    $legal = \App\Support\FooterNavigation::links($footer['legal'] ?? []);
    $logo = $footer['logo'];
    $addr = $site['address'];
    $link = fn (string $href) => str_starts_with($href, '/') ? url($href) : $href;
@endphp
<footer class="site-footer" aria-labelledby="site-footer-heading">
  <h2 id="site-footer-heading" class="sr-only">{{ $site['name'] }}: site information</h2>
  <div class="sf__main">
    <div class="sf__brand">
      <a href="{{ url('/') }}" class="sf__logo-plate">
        <img
          src="{{ asset(ltrim($logo['src'], '/')) }}"
          alt="{{ $logo['alt'] }}"
          width="{{ $logo['width'] }}"
          height="{{ $logo['height'] }}"
          class="sf__logo"
          loading="lazy"
          decoding="async"
        >
      </a>
      <p class="sf__description">{{ $footer['description'] }}</p>
      @if (! empty($footer['social']))
        <ul class="sf__social" aria-label="Mission Villa on social media">
          @foreach ($footer['social'] as $social)
            <li>
              <a href="{{ $social['href'] }}" class="sf__social-link" aria-label="{{ $social['label'] }}"
                 @if ($social['href'] !== '#') target="_blank" rel="noopener noreferrer" @endif>
                @include('partials.icon', ['name' => $social['icon'], 'class' => 'sf__social-icon', 'stroke' => 1.6])
              </a>
            </li>
          @endforeach
        </ul>
      @endif
    </div>

    @foreach ($groups as $group)
      <nav class="sf__group" aria-label="{{ $group['title'] }}">
        <h3 class="sf__heading">{{ $group['title'] }}</h3>
        <ul class="sf__links">
          @foreach ($group['links'] as $item)
            <li><a href="{{ $link($item['href']) }}" class="sf__link">{{ $item['label'] }}</a></li>
          @endforeach
        </ul>
      </nav>
    @endforeach

    <div class="sf__group sf__contact">
      <h3 class="sf__heading">Visit &amp; Contact</h3>
      <address class="sf__address">
        <span class="sf__line">
          @include('partials.icon', ['name' => 'pin', 'class' => 'sf__icon', 'stroke' => 1.4])
          <span>{{ $addr['street'] }}<br>{{ $addr['city'] }}, {{ $addr['region'] }} {{ $addr['postal_code'] }}</span>
        </span>
        <a href="{{ $site['phone']['href'] }}" class="sf__line sf__phone">
          @include('partials.icon', ['name' => 'phone', 'class' => 'sf__icon', 'stroke' => 1.4])
          <span>{{ $site['phone']['display'] }}</span>
        </a>
      </address>
      <p class="sf__license">
        @include('partials.icon', ['name' => 'shield', 'class' => 'sf__icon', 'stroke' => 1.4])
        <span>California RCFE License #{{ $site['license']['number'] }}</span>
      </p>
      <a href="{{ $site['phone']['href'] }}" class="sf__visit" data-inquiry="schedule_visit">
        <span>Schedule a Visit</span>
        @include('partials.icon', ['name' => 'arrow', 'class' => 'sf__visit-arrow', 'stroke' => 2])
      </a>
    </div>
  </div>

  <div class="sf__bar">
    <p class="sf__copy">© {{ now()->year }} {{ $site['name'] }} · {{ $site['license']['label'] }} #{{ $site['license']['number'] }}</p>
    @if ($legal !== [])
      <ul class="sf__legal">
        @foreach ($legal as $item)
          <li><a href="{{ $link($item['href']) }}" class="sf__link">{{ $item['label'] }}</a></li>
        @endforeach
      </ul>
    @endif
  </div>
</footer>
