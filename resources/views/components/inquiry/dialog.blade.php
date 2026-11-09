@php
    /*
     * Shared inquiry form: ONE form for Schedule a Visit, Request Pricing and
     * Request a Call. Rendered once per page by the site layout and opened by
     * any element with data-inquiry="<intent>" (resources/js/components/inquiry-dialog.js).
     *
     * Honesty rules (docs/INTEGRATION_PLAN.md):
     *  - store=false        → the form never posts and says "design preview, nothing was sent".
     *  - not connected      → the form posts and saves locally; the confirmation says it was
     *                         saved but NOT sent to Mission Villa's team.
     *  - destination wired  → confirmation says received (still not "delivered").
     */
    $site = config('missionvilla');
    $cfg = $site['inquiries'];
    $connected = ! app(\App\Integrations\Leads\LeadDestination::class) instanceof \App\Integrations\Leads\UnconfiguredLeadDestination;
    $mode = ! $cfg['store'] ? 'preview' : ($connected ? 'live' : 'local');
    $copy = [
        'schedule_visit' => [
            'title' => 'Schedule a Visit',
            'lede' => 'Tell us how to reach you and when suits you. We’ll arrange a time to walk through Mission Villa and meet the care team.',
            'submit' => 'Request a Visit',
            'time' => 'Preferred time to visit',
        ],
        'request_pricing' => [
            'title' => 'Request Pricing',
            'lede' => 'Pricing depends on care needs and suite type, so our team shares it personally. Tell us how to reach you.',
            'submit' => 'Request Pricing',
            'time' => 'Best time to reach you',
        ],
        'request_callback' => [
            'title' => 'Request a Call',
            'lede' => 'Leave your number and a good time to call. A member of our Daly City team can answer your questions.',
            'submit' => 'Request a Call',
            'time' => 'Best time to call',
        ],
    ];
@endphp
<dialog
  class="inquiry"
  id="inquiry-dialog"
  aria-labelledby="inquiry-title"
  aria-describedby="inquiry-lede"
  data-inquiry-dialog
  data-mode="{{ $mode }}"
  data-copy='@json($copy)'
>
  <div class="inquiry__card">
    <header class="inquiry__head">
      <div>
        <p class="inquiry__kicker">
          {{ $site['name'] }}
          @if ($mode !== 'live')
            <span class="inquiry__chip">{{ $mode === 'preview' ? 'Design preview' : 'Development site' }}</span>
          @endif
        </p>
        <h2 class="inquiry__title" id="inquiry-title" data-inquiry-title>{{ $copy['schedule_visit']['title'] }}</h2>
      </div>
      <button type="button" class="inquiry__close" data-inquiry-close aria-label="Close">
        @include('partials.icon', ['name' => 'x', 'class' => 'mv-icon', 'stroke' => 1.8])
      </button>
    </header>

    <div class="inquiry__body" data-inquiry-form-view>
      <p class="inquiry__lede" id="inquiry-lede" data-inquiry-lede>{{ $copy['schedule_visit']['lede'] }}</p>

      <form class="inquiry__form" method="post" action="{{ route('inquiries.store') }}" novalidate data-inquiry-form>
        @csrf
        <input type="hidden" name="idempotency_key" value="" data-inquiry-key>
        <input type="hidden" name="page_url" value="" data-inquiry-page>
        @foreach (['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'gclid', 'fbclid'] as $param)
          <input type="hidden" name="{{ $param }}" value="" data-inquiry-attr="{{ $param }}">
        @endforeach
        {{-- Honeypot (hidden from people and assistive technology). --}}
        <div class="inquiry__trap" aria-hidden="true">
          <label for="inquiry-company-website">Company website</label>
          <input type="text" id="inquiry-company-website" name="company_website" tabindex="-1" autocomplete="off">
        </div>

        <fieldset class="inquiry__intents">
          <legend class="inquiry__label">I’d like to</legend>
          <div class="inquiry__segmented">
            @foreach ($cfg['intents'] as $key => $intent)
              <label class="inquiry__seg">
                <input type="radio" name="intent" value="{{ $key }}" @checked($loop->first) data-inquiry-intent>
                <span>{{ $intent['label'] }}</span>
              </label>
            @endforeach
          </div>
        </fieldset>

        <div class="inquiry__field">
          <label class="inquiry__label" for="inquiry-name">Your name</label>
          <input class="inquiry__input" id="inquiry-name" name="name" type="text" autocomplete="name" maxlength="80" required aria-describedby="inquiry-name-error">
          <p class="inquiry__error" id="inquiry-name-error" data-error-for="name" hidden></p>
        </div>

        <div class="inquiry__row">
          <div class="inquiry__field">
            <label class="inquiry__label" for="inquiry-phone">Phone <span class="inquiry__hint" data-phone-hint>(or email)</span></label>
            <input class="inquiry__input" id="inquiry-phone" name="phone" type="tel" autocomplete="tel" inputmode="tel" maxlength="30" aria-describedby="inquiry-phone-error">
            <p class="inquiry__error" id="inquiry-phone-error" data-error-for="phone" hidden></p>
          </div>
          <div class="inquiry__field" data-show-for="schedule_visit request_pricing">
            <label class="inquiry__label" for="inquiry-email">Email <span class="inquiry__hint">(or phone)</span></label>
            <input class="inquiry__input" id="inquiry-email" name="email" type="email" autocomplete="email" maxlength="120" aria-describedby="inquiry-email-error">
            <p class="inquiry__error" id="inquiry-email-error" data-error-for="email" hidden></p>
          </div>
        </div>

        <div class="inquiry__row">
          <div class="inquiry__field">
            <label class="inquiry__label" for="inquiry-care">Care of interest</label>
            <select class="inquiry__input" id="inquiry-care" name="care_interest">
              <option value="">Choose one (optional)</option>
              @foreach ($cfg['care_interests'] as $key => $label)
                <option value="{{ $key }}">{{ $label }}</option>
              @endforeach
            </select>
          </div>
          <div class="inquiry__field" data-show-for="request_pricing">
            <label class="inquiry__label" for="inquiry-suite">Suite of interest</label>
            <select class="inquiry__input" id="inquiry-suite" name="suite_preference">
              <option value="">Choose one (optional)</option>
              @foreach ($cfg['suite_preferences'] as $key => $label)
                <option value="{{ $key }}">{{ $label }}</option>
              @endforeach
            </select>
          </div>
          <div class="inquiry__field" data-show-for="schedule_visit request_callback">
            <label class="inquiry__label" for="inquiry-time" data-inquiry-time-label>{{ $copy['schedule_visit']['time'] }}</label>
            <select class="inquiry__input" id="inquiry-time" name="contact_time">
              <option value="">Choose one (optional)</option>
              @foreach ($cfg['contact_times'] as $key => $label)
                <option value="{{ $key }}">{{ $label }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <label class="inquiry__check">
          <input type="checkbox" name="marketing_opt_in" value="1">
          <span>Optional: also send me occasional news and event invitations from Mission Villa. You can unsubscribe at any time.</span>
        </label>

        <p class="inquiry__privacy">
          We use these details only to respond to this request. Please don’t include medical information.
          @if ($mode === 'local')
            <strong>This development site saves requests locally and does not send them to Mission Villa yet.</strong>
          @elseif ($mode === 'preview')
            <strong>This is a design preview: nothing you enter is sent or stored.</strong>
          @endif
        </p>

        <p class="inquiry__alert" role="alert" tabindex="-1" data-inquiry-alert hidden></p>

        <div class="inquiry__actions">
          <button type="submit" class="mv-btn mv-btn--primary inquiry__submit" data-inquiry-submit>
            <span data-inquiry-submit-label>{{ $copy['schedule_visit']['submit'] }}</span>
          </button>
          <a href="{{ $site['phone']['href'] }}" class="inquiry__call">
            @include('partials.icon', ['name' => 'phone', 'class' => 'mv-icon', 'stroke' => 1.6])
            <span>Or call {{ $site['phone']['display'] }}</span>
          </a>
        </div>
      </form>
    </div>

    <div class="inquiry__done" data-inquiry-done hidden tabindex="-1">
      <span class="inquiry__done-icon" aria-hidden="true">
        @include('partials.icon', ['name' => 'check', 'class' => 'mv-icon', 'stroke' => 2])
      </span>
      <h3 class="inquiry__done-title" data-inquiry-done-title>Request saved</h3>
      <p class="inquiry__done-text" role="status" data-inquiry-done-text></p>
      <p class="inquiry__done-ref" data-inquiry-done-ref hidden></p>
      <div class="inquiry__actions">
        <a href="{{ $site['phone']['href'] }}" class="mv-btn mv-btn--plum">
          @include('partials.icon', ['name' => 'phone', 'class' => 'mv-icon', 'stroke' => 1.6])
          <span>Call {{ $site['phone']['display'] }}</span>
        </a>
        <button type="button" class="inquiry__link" data-inquiry-close>Close</button>
      </div>
    </div>
  </div>
</dialog>
