@props([
    // 'modal' (inside the shared dialog) or 'inline' (Section 07 card). Prefixes every id, so both can share a page.
    'instance' => 'modal',
    // Preselected intent (canonical key). Inline forms leave it empty so the visitor chooses.
    'intent' => null,
    // Non-sensitive context stored with the lead (config inquiries.sources). The modal's is set per opening.
    'source' => null,
])
@php
    /*
     * THE shared inquiry form. One definition of fields, labels, hints and
     * honesty notices for every inquiry path on the site:
     *   - the modal (components/inquiry/dialog) opened by any data-inquiry CTA;
     *   - the inline card in Section 07 (visible without JavaScript).
     * Validation: App\Http\Requests\InquiryRequest. Endpoint: POST /inquiries.
     * Behaviour (submit, errors, success): resources/js/components/inquiry-dialog.js.
     */
    $site = config('missionvilla');
    $cfg = $site['inquiries'];
    $p = 'inq-'.$instance;
    $inline = $instance === 'inline';
    $connected = ! app(\App\Integrations\Leads\LeadDestination::class) instanceof \App\Integrations\Leads\UnconfiguredLeadDestination;
    $mode = ! $cfg['store'] ? 'preview' : ($connected ? 'live' : 'local');
    // No-JavaScript round trip (validation errors) only applies to the inline form, which is the one that can post without JS.
    $old = fn (string $k, $default = null) => $inline ? old($k, $default) : $default;
    $err = fn (string $k) => $inline && $errors->has($k) ? $errors->first($k) : null;
    $selectedIntent = $old('intent', $intent);
    // Errors not tied to a visible field (honeypot, expired key, …) go to the alert line.
    $generalError = $inline
        ? collect($errors->getMessages())->except(['first_name', 'last_name', 'phone', 'email', 'intent'])->flatten()->first()
        : null;
@endphp
<form
  class="iq-form iq-form--{{ $instance }}"
  method="post"
  action="{{ route('inquiries.store') }}"
  novalidate
  data-inquiry-form
  data-instance="{{ $instance }}"
  data-mode="{{ $mode }}"
>
  @csrf
  <input type="hidden" name="idempotency_key" value="{{ (string) \Illuminate\Support\Str::uuid() }}" data-inquiry-key>
  <input type="hidden" name="page_url" value="" data-inquiry-page>
  <input type="hidden" name="source" value="{{ $source }}" data-inquiry-source>
  @foreach (['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'gclid', 'fbclid'] as $param)
    <input type="hidden" name="{{ $param }}" value="" data-inquiry-attr="{{ $param }}">
  @endforeach
  {{-- Honeypot (hidden from people and assistive technology). --}}
  <div class="iq-trap" aria-hidden="true">
    <label for="{{ $p }}-company-website">Company website</label>
    <input type="text" id="{{ $p }}-company-website" name="company_website" tabindex="-1" autocomplete="off">
  </div>

  <div class="iq-row">
    <div class="iq-field">
      <label class="iq-label" for="{{ $p }}-first">First name <span class="iq-req" aria-hidden="true">*</span></label>
      <input class="iq-input" id="{{ $p }}-first" name="first_name" type="text" autocomplete="given-name" maxlength="60" required
        value="{{ $old('first_name') }}" aria-describedby="{{ $p }}-first_name-error" @if ($err('first_name')) aria-invalid="true" @endif>
      <p class="iq-error" id="{{ $p }}-first_name-error" data-error-for="first_name" @unless ($err('first_name')) hidden @endunless>{{ $err('first_name') }}</p>
    </div>
    <div class="iq-field">
      <label class="iq-label" for="{{ $p }}-last">Last name</label>
      <input class="iq-input" id="{{ $p }}-last" name="last_name" type="text" autocomplete="family-name" maxlength="60"
        value="{{ $old('last_name') }}" aria-describedby="{{ $p }}-last_name-error">
      <p class="iq-error" id="{{ $p }}-last_name-error" data-error-for="last_name" @unless ($err('last_name')) hidden @endunless>{{ $err('last_name') }}</p>
    </div>
  </div>

  <div class="iq-row iq-row--contact">
    <div class="iq-field">
      <label class="iq-label" for="{{ $p }}-phone">Phone number <span class="iq-req" aria-hidden="true" data-phone-req hidden>*</span></label>
      <input class="iq-input" id="{{ $p }}-phone" name="phone" type="tel" autocomplete="tel" inputmode="tel" maxlength="30"
        value="{{ $old('phone') }}" aria-describedby="{{ $p }}-contact-hint {{ $p }}-phone-error" @if ($err('phone')) aria-invalid="true" @endif>
      <p class="iq-error" id="{{ $p }}-phone-error" data-error-for="phone" @unless ($err('phone')) hidden @endunless>{{ $err('phone') }}</p>
    </div>
    <div class="iq-field">
      <label class="iq-label" for="{{ $p }}-email">Email address</label>
      <input class="iq-input" id="{{ $p }}-email" name="email" type="email" autocomplete="email" maxlength="120"
        value="{{ $old('email') }}" aria-describedby="{{ $p }}-contact-hint {{ $p }}-email-error" @if ($err('email')) aria-invalid="true" @endif>
      <p class="iq-error" id="{{ $p }}-email-error" data-error-for="email" @unless ($err('email')) hidden @endunless>{{ $err('email') }}</p>
    </div>
    <p class="iq-hint" id="{{ $p }}-contact-hint" data-contact-hint>A phone number or email address, whichever you prefer.</p>
  </div>

  <div class="iq-field">
    <label class="iq-label" for="{{ $p }}-intent">How can we help? <span class="iq-req" aria-hidden="true">*</span></label>
    <select class="iq-input iq-select" id="{{ $p }}-intent" name="intent" required aria-describedby="{{ $p }}-intent-error" data-inquiry-intent @if ($err('intent')) aria-invalid="true" @endif>
      @if ($inline)
        <option value="" @selected(! $selectedIntent)>Choose one</option>
      @endif
      @foreach ($cfg['intents'] as $key => $def)
        <option value="{{ $key }}" @selected($selectedIntent === $key)>{{ $def['label'] }}</option>
      @endforeach
    </select>
    <p class="iq-error" id="{{ $p }}-intent-error" data-error-for="intent" @unless ($err('intent')) hidden @endunless>{{ $err('intent') }}</p>
  </div>

  @unless ($inline)
    {{-- Optional details, shown in the modal for the intents they apply to. The inline card stays compact (approved mockup). --}}
    <div class="iq-row">
      <div class="iq-field">
        <label class="iq-label" for="{{ $p }}-care">Care of interest <span class="iq-opt">(optional)</span></label>
        <select class="iq-input iq-select" id="{{ $p }}-care" name="care_interest">
          <option value="">Choose one</option>
          @foreach ($cfg['care_interests'] as $key => $label)
            <option value="{{ $key }}">{{ $label }}</option>
          @endforeach
        </select>
      </div>
      <div class="iq-field" data-show-for="request_pricing request_availability">
        <label class="iq-label" for="{{ $p }}-suite">Suite of interest <span class="iq-opt">(optional)</span></label>
        <select class="iq-input iq-select" id="{{ $p }}-suite" name="suite_preference">
          <option value="">Choose one</option>
          @foreach ($cfg['suite_preferences'] as $key => $label)
            <option value="{{ $key }}">{{ $label }}</option>
          @endforeach
        </select>
      </div>
      <div class="iq-field" data-show-for="schedule_visit request_callback">
        <label class="iq-label" for="{{ $p }}-time"><span data-time-label>Best time</span> <span class="iq-opt">(optional)</span></label>
        <select class="iq-input iq-select" id="{{ $p }}-time" name="contact_time">
          <option value="">Choose one</option>
          @foreach ($cfg['contact_times'] as $key => $label)
            <option value="{{ $key }}">{{ $label }}</option>
          @endforeach
        </select>
      </div>
    </div>
  @endunless

  <label class="iq-check">
    <input type="checkbox" name="marketing_opt_in" value="1" @checked($old('marketing_opt_in'))>
    <span>Optional: also send me occasional news and event invitations. You can unsubscribe at any time.</span>
  </label>

  <p class="iq-privacy">
    We use these details only to respond to this request. Please don’t include medical information.
    @if ($mode === 'local')
      <strong>This development site saves requests locally and does not send them to Mission Villa yet.</strong>
    @elseif ($mode === 'preview')
      <strong>This is a design preview: nothing you enter is sent or stored.</strong>
    @endif
  </p>

  <p class="iq-alert" role="alert" tabindex="-1" data-inquiry-alert @unless ($generalError) hidden @endunless>{{ $generalError }}</p>

  <button type="submit" class="iq-submit" data-inquiry-submit>
    <span data-inquiry-submit-label>{{ $inline ? 'Send Request' : ($cfg['intents'][$intent ?? 'schedule_visit']['submit'] ?? 'Send Request') }}</span>
    @include('partials.icon', ['name' => 'arrow', 'class' => 'iq-submit__arrow', 'stroke' => 2])
  </button>
</form>

{{-- Success / outcome view. Shows the server's own message, so the visitor only sees what really happened. --}}
<div class="iq-done" data-inquiry-done hidden tabindex="-1">
  <span class="iq-done__icon" aria-hidden="true">
    @include('partials.icon', ['name' => 'check', 'class' => 'mv-icon', 'stroke' => 2])
  </span>
  <h3 class="iq-done__title" data-inquiry-done-title>Request saved</h3>
  <p class="iq-done__text" role="status" data-inquiry-done-text></p>
  <p class="iq-done__ref" data-inquiry-done-ref hidden></p>
  <div class="iq-done__actions">
    <a href="{{ $site['phone']['href'] }}" class="iq-done__call">
      @include('partials.icon', ['name' => 'phone', 'class' => 'mv-icon', 'stroke' => 1.6])
      <span>Call {{ $site['phone']['display'] }}</span>
    </a>
    @if ($inline)
      <button type="button" class="iq-done__link" data-inquiry-again>Send another request</button>
    @else
      <button type="button" class="iq-done__link" data-inquiry-close>Close</button>
    @endif
  </div>
</div>
