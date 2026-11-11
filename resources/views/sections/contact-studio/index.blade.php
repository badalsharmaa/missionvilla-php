@php
    /** @var array $data Normalised by App\Content\Sections\ContactStudioSection */
    $contact = $data['primary_contact'];
    $presets = $data['presets'];
    $guardrail = $data['privacy_guardrail'];
    $form = $data['form_config'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/contact-studio.css', 'resources/js/sections/contact-studio.js'])
@endpush
{{--
    CONTACT SECTION 02 · SPLIT EDITORIAL CONTACT STUDIO & GUIDED INQUIRY FORM (#schedule-visit)
--}}
<section class="contact-studio fluid-canvas" aria-labelledby="contact-studio-heading" id="schedule-visit" data-contact-studio>
    <div class="contact-studio__inner">
        <div class="contact-studio__grid">
            {{-- Left 5 Columns: Split Editorial Contact Directory & Quick Presets --}}
            <div class="contact-studio__left">
                <div class="contact-studio__intro-block">
                    <div class="contact-studio__eyebrow">
                        <span>{{ $data['eyebrow'] }}</span>
                    </div>

                    <h2 id="contact-studio-heading" class="contact-studio__heading">
                        {!! $data['heading'] !!}
                    </h2>

                    <p class="contact-studio__lead">
                        {!! $data['intro'] !!}
                    </p>
                </div>

                {{-- Verified Contact Card with Prominent Call Button --}}
                <div class="contact-studio__card">
                    <div class="contact-studio__card-header">
                        <div>
                            <span class="contact-studio__card-badge">{{ $contact['badge'] }}</span>
                            <h3 class="contact-studio__card-title">{{ $contact['community_name'] }}</h3>
                        </div>
                        <span class="contact-studio__card-license tabular-nums">{{ $contact['license_label'] }}</span>
                    </div>

                    <div class="contact-studio__card-body">
                        {{-- Phone --}}
                        <div class="contact-studio__fact-row">
                            <svg class="contact-studio__fact-icon contact-studio__fact-icon--phone" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                            </svg>
                            <div class="contact-studio__fact-content">
                                <span class="contact-studio__fact-label">{{ $contact['phone_label'] }}</span>
                                <a href="{{ $contact['phone_href'] }}" class="contact-studio__phone-link tabular-nums">
                                    {{ $contact['phone_raw'] }}
                                </a>
                                <p class="contact-studio__fact-note">
                                    {{ $contact['phone_note'] }}
                                </p>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="contact-studio__fact-row">
                            <svg class="contact-studio__fact-icon contact-studio__fact-icon--email" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <rect width="20" height="16" x="2" y="4" rx="2"/>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                            </svg>
                            <div class="contact-studio__fact-content">
                                <span class="contact-studio__fact-label">{{ $contact['email_label'] }}</span>
                                <a href="{{ $contact['email_href'] }}" class="contact-studio__email-link">
                                    {{ $contact['email_address'] }}
                                </a>
                            </div>
                        </div>

                        {{-- Address --}}
                        <div class="contact-studio__fact-row">
                            <svg class="contact-studio__fact-icon contact-studio__fact-icon--address" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                            <div class="contact-studio__fact-content">
                                <span class="contact-studio__fact-label">{{ $contact['address_label'] }}</span>
                                <span class="contact-studio__address-val">{{ $contact['address_full'] }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Card Buttons --}}
                    <div class="contact-studio__card-actions">
                        <a href="{{ $contact['phone_href'] }}" class="contact-studio__call-btn">
                            <svg class="contact-studio__btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                            </svg>
                            <span>Call {{ $contact['phone_raw'] }}</span>
                        </a>
                        <a href="{{ $contact['maps_url'] }}" target="_blank" rel="noopener noreferrer" class="contact-studio__maps-btn">
                            <span>Google Maps Directions</span>
                            <svg class="contact-studio__btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M7 17L17 7"/>
                                <path d="M7 7h10v10"/>
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Quick Conversation Presets --}}
                <div class="contact-studio__presets-card">
                    <div class="contact-studio__presets-header">
                        <span class="contact-studio__presets-label">Quick Inquiry Presets</span>
                        <span class="contact-studio__presets-hint">Click to pre-fill form →</span>
                    </div>

                    <div class="contact-studio__presets-grid">
                        @foreach ($presets as $preset)
                            <button
                                type="button"
                                class="contact-studio__preset-btn"
                                data-preset-intent="{{ $preset['inquiry_intent'] }}"
                                data-preset-care="{{ $preset['care_interest'] }}"
                                data-preset-suite="{{ $preset['suite_preference'] }}"
                                data-preset-message="{{ $preset['message'] }}"
                                data-preset-referral="{{ $preset['referral_note'] ?? '' }}"
                            >
                                <span class="contact-studio__preset-title">{{ $preset['label'] }}</span>
                                <span aria-hidden="true" class="contact-studio__preset-arrow">→</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Non-Medical Privacy Guardrail Notice --}}
                <div class="contact-studio__guardrail">
                    <svg class="contact-studio__guardrail-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        <path d="m9 12 2 2 4-4"/>
                    </svg>
                    <div>
                        <strong class="contact-studio__guardrail-title">{{ $guardrail['title'] }}</strong>
                        <p class="contact-studio__guardrail-text">{{ $guardrail['text'] }}</p>
                    </div>
                </div>
            </div>

            {{-- Right 7 Columns: Guided Inquiry / Request-Visit Prototype Form --}}
            <div class="contact-studio__right">
                <div class="contact-studio__form-wrapper herbarium-mount">
                    {{-- Form Header --}}
                    <div class="contact-studio__form-header">
                        <div>
                            <span class="contact-studio__form-badge">{{ $form['badge'] }}</span>
                            <h3 class="contact-studio__form-title">{{ $form['title'] }}</h3>
                        </div>
                        <div>
                            <span class="contact-studio__demo-badge">{{ $form['demo_pill'] }}</span>
                        </div>
                    </div>

                    {{-- Form Itself --}}
                    <form id="contact-prototype-form" class="contact-studio__form" novalidate data-contact-form>
                        {{-- 1. Intent Selector --}}
                        <div class="contact-studio__field-group">
                            <label class="contact-studio__field-label">{{ $form['intent_label'] }}</label>
                            <div class="contact-studio__intent-grid">
                                @foreach ($form['intents'] as $intent)
                                    <label class="contact-studio__intent-option">
                                        <input
                                            type="radio"
                                            name="inquiry_intent"
                                            value="{{ $intent }}"
                                            class="contact-studio__intent-radio sr-only"
                                            {{ $loop->first ? 'checked' : '' }}
                                        />
                                        <span class="contact-studio__intent-card">
                                            <span class="contact-studio__intent-text">{{ $intent }}</span>
                                            <svg class="contact-studio__check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true">
                                                <polyline points="20 6 9 17 4 12"/>
                                            </svg>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- 2. Name & Preferred Contact Method --}}
                        <div class="contact-studio__fields-row">
                            <div class="contact-studio__field">
                                <label for="contact-full-name" class="contact-studio__field-label">{{ $form['name_label'] }}</label>
                                <input
                                    id="contact-full-name"
                                    name="full_name"
                                    type="text"
                                    required
                                    placeholder="e.g., Elena Martinez"
                                    class="contact-studio__input"
                                />
                                <p class="contact-studio__error-msg" data-error-for="full_name" hidden role="alert"></p>
                            </div>

                            <div class="contact-studio__field">
                                <label for="contact-preferred-method" class="contact-studio__field-label">{{ $form['method_label'] }}</label>
                                <select id="contact-preferred-method" name="preferred_method" class="contact-studio__select">
                                    @foreach ($form['methods'] as $method)
                                        <option value="{{ $method }}">{{ $method }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- 3. Phone & Email --}}
                        <div class="contact-studio__fields-row">
                            <div class="contact-studio__field">
                                <label for="contact-phone" class="contact-studio__field-label" data-phone-label>
                                    {{ $form['phone_label'] }} <span class="contact-studio__req-mark">*</span>
                                </label>
                                <input
                                    id="contact-phone"
                                    name="phone"
                                    type="tel"
                                    placeholder="(650) 555-0199"
                                    class="contact-studio__input"
                                />
                                <p class="contact-studio__error-msg" data-error-for="phone" hidden role="alert"></p>
                            </div>

                            <div class="contact-studio__field">
                                <label for="contact-email" class="contact-studio__field-label" data-email-label>
                                    {{ $form['email_label'] }} <span class="contact-studio__req-mark">*</span>
                                </label>
                                <input
                                    id="contact-email"
                                    name="email"
                                    type="email"
                                    placeholder="you@example.com"
                                    class="contact-studio__input"
                                />
                                <p class="contact-studio__error-msg" data-error-for="email" hidden role="alert"></p>
                            </div>
                        </div>

                        {{-- 4. Care Interest & Suite Format --}}
                        <div class="contact-studio__fields-row">
                            <div class="contact-studio__field">
                                <label for="contact-care-interest" class="contact-studio__field-label">{{ $form['care_label'] }}</label>
                                <select id="contact-care-interest" name="care_interest" class="contact-studio__select">
                                    @foreach ($form['care_options'] as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                                <p class="contact-studio__error-msg" data-error-for="care_interest" hidden role="alert"></p>
                            </div>

                            <div class="contact-studio__field">
                                <label for="contact-suite-preference" class="contact-studio__field-label">{{ $form['suite_label'] }}</label>
                                <select id="contact-suite-preference" name="suite_preference" class="contact-studio__select">
                                    @foreach ($form['suite_options'] as $suite)
                                        <option value="{{ $suite }}">{{ $suite }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- 5. Preferred Window & Timing --}}
                        <div class="contact-studio__fields-row">
                            <div class="contact-studio__field">
                                <label for="contact-preferred-window" class="contact-studio__field-label">{{ $form['window_label'] }}</label>
                                <select id="contact-preferred-window" name="preferred_window" class="contact-studio__select">
                                    @foreach ($form['windows'] as $window)
                                        <option value="{{ $window }}">{{ $window }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="contact-studio__field">
                                <label for="contact-visit-timing" class="contact-studio__field-label">{{ $form['timing_label'] }}</label>
                                <input
                                    id="contact-visit-timing"
                                    name="visit_timing"
                                    type="text"
                                    placeholder="{{ $form['timing_placeholder'] }}"
                                    class="contact-studio__input"
                                />
                            </div>
                        </div>

                        {{-- 6. Message (Non-Clinical) --}}
                        <div class="contact-studio__field">
                            <div class="contact-studio__field-header">
                                <label for="contact-message" class="contact-studio__field-label">{{ $form['message_label'] }}</label>
                                <span class="contact-studio__disclaimer-note">{{ $form['message_disclaimer'] }}</span>
                            </div>
                            <textarea
                                id="contact-message"
                                name="message"
                                rows="3"
                                placeholder="{{ $form['message_placeholder'] }}"
                                class="contact-studio__textarea"
                            ></textarea>
                            <input type="hidden" name="referral_note" id="contact-referral-note" value="" />
                        </div>

                        {{-- 7. Consent Notice --}}
                        <div class="contact-studio__consent-box">
                            <label for="contact-consent-checkbox" class="contact-studio__consent-label">
                                <input
                                    id="contact-consent-checkbox"
                                    name="consent_accepted"
                                    type="checkbox"
                                    class="contact-studio__checkbox"
                                />
                                <span>{!! $form['consent_text'] !!}</span>
                            </label>
                            <p class="contact-studio__error-msg contact-studio__error-msg--consent" data-error-for="consent_accepted" hidden role="alert"></p>
                        </div>

                        {{-- Submit Button & Notice --}}
                        <div class="contact-studio__submit-row">
                            <button type="submit" class="contact-studio__submit-btn">
                                <svg class="contact-studio__btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                                    <line x1="16" x2="16" y1="2" y2="6"/>
                                    <line x1="8" x2="8" y1="2" y2="6"/>
                                    <line x1="3" x2="21" y1="10" y2="10"/>
                                </svg>
                                <span>{{ $form['submit_label'] }}</span>
                            </button>

                            <p class="contact-studio__demo-note">
                                <svg class="contact-studio__info-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" x2="12" y1="16" y2="12"/>
                                    <line x1="12" x2="12.01" y1="8" y2="8"/>
                                </svg>
                                <span>{{ $form['demo_explainer'] }}</span>
                            </p>
                        </div>
                    </form>

                    {{-- Demo Confirmation Box (rendered upon valid local submission) --}}
                    <div id="contact-demo-confirmation" class="contact-studio__confirmation" role="status" aria-live="polite" data-testid="contact-demo-confirmation" hidden>
                        <div class="contact-studio__confirm-header">
                            <div class="contact-studio__confirm-title-row">
                                <svg class="contact-studio__confirm-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                    <polyline points="22 4 12 14.01 9 11.01"/>
                                </svg>
                                <h4 class="contact-studio__confirm-title">Demo only — no inquiry sent</h4>
                            </div>
                            <span class="contact-studio__prototype-badge">Frontend Design Prototype</span>
                        </div>

                        <p class="contact-studio__confirm-desc">
                            This website is currently in its frontend design prototype phase. Your inputs passed local client-side validation, but <strong>no visit has been booked and no personal data or email was transmitted to any external server or CRM</strong>. Below is the structured inquiry preview prepared for future backend handoff:
                        </p>

                        <dl class="contact-studio__confirm-dl" data-confirm-summary>
                            {{-- Dynamically populated by JS --}}
                        </dl>

                        <div class="contact-studio__live-box">
                            <strong>To reach Mission Villa Senior Living right now:</strong> Call
                            <a href="{{ $contact['phone_href'] }}" class="contact-studio__inline-phone tabular-nums">{{ $contact['phone_raw'] }}</a>
                            or email
                            <a href="{{ $contact['email_href'] }}" class="contact-studio__inline-email">{{ $contact['email_address'] }}</a>.
                        </div>

                        <div class="contact-studio__confirm-footer">
                            <button type="button" class="contact-studio__reset-btn" data-reset-demo-form>
                                <svg class="contact-studio__reset-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                                    <path d="M3 3v5h5"/>
                                </svg>
                                <span>Return to Form / Edit Demo Inquiry</span>
                            </button>

                            <a href="#what-happens-next" class="contact-studio__next-link">
                                See What Happens Once Backend Is Connected ↓
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
