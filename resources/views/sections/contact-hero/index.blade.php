@php
    /** @var array $data Normalised by App\Content\Sections\ContactHeroSection */
    $phone = $data['phone'];
    $email = $data['email'];
    $address = $data['address'];
    $plate = $data['arrival_plate'];
    $directory = $data['directory_card'];
    $quickSections = $data['quick_sections'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/contact-hero.css'])
@endpush
{{--
    CONTACT SECTION 01 · FULL-BLEED CINEMATIC HERO
    Authentic courtyard-patio.webp backdrop with scrim overlay, Newsreader title,
    Plus Jakarta Sans eyebrow with terracotta dot, primary visit CTA, phone call link,
    docked verified contact trio strip, arrival monograph & 4-section quick jump bar.
--}}
<section class="contact-hero" aria-labelledby="contact-hero-heading" id="contact-hero">
    <div class="contact-hero__backdrop" aria-hidden="true">
        <picture>
            <img
                src="{{ asset('images/property/courtyard-patio.webp') }}"
                alt=""
                width="1600"
                height="1067"
                class="contact-hero__bg-img"
                loading="eager"
                fetchpriority="high"
                decoding="async"
            >
        </picture>
        <div class="contact-hero__scrim"></div>
    </div>

    <div class="contact-hero__content">
        <div class="contact-hero__badge">
            <span class="contact-hero__badge-dot" aria-hidden="true"></span>
            <span>{{ $data['eyebrow'] }} · {{ $data['license'] }}</span>
        </div>

        <h1 id="contact-hero-heading" class="contact-hero__title">
            {!! $data['heading'] !!}
        </h1>

        <p class="contact-hero__editorial">
            Direct Daly City hospitality desk, unhurried tour scheduling &amp; Peninsula arrival guide.
        </p>

        <div class="contact-hero__lead">
            {!! $data['lead'] !!}
        </div>

        {{-- Primary Action Buttons --}}
        <div class="contact-hero__actions">
            <a
                href="#schedule-visit"
                class="contact-hero__btn contact-hero__btn--primary"
                data-inquiry="schedule_visit"
                data-care="exploring"
                data-inquiry-source="contact-hero"
            >
                <svg class="contact-hero__btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                <span>Schedule a Visit</span>
                <span aria-hidden="true" class="contact-hero__btn-arrow">→</span>
            </a>

            <a
                href="{{ $phone['href'] }}"
                class="contact-hero__btn contact-hero__btn--phone"
                aria-label="Call Mission Villa at {{ $phone['raw'] }}"
            >
                <svg class="contact-hero__btn-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                </svg>
                <span>Call {{ $phone['raw'] }}</span>
            </a>

            <a
                href="#map-and-directions"
                class="contact-hero__btn contact-hero__btn--secondary"
            >
                <svg class="contact-hero__btn-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="10"/>
                    <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/>
                </svg>
                <span>Map &amp; Directions</span>
            </a>
        </div>

        {{-- Verified Contact Trio Ribbon (Docked 3-Card Strip) --}}
        <div class="contact-hero__trio" role="list">
            {{-- Phone Card --}}
            <a href="{{ $phone['href'] }}" class="contact-hero__trio-card contact-hero__trio-card--phone" role="listitem">
                <div class="contact-hero__trio-top">
                    <span class="contact-hero__trio-label">Main Community Telephone</span>
                    <svg class="contact-hero__trio-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                    </svg>
                </div>
                <span class="contact-hero__trio-value tabular-nums">{{ $phone['raw'] }}</span>
                <span class="contact-hero__trio-hint">Tap to call our Daly City team →</span>
            </a>

            {{-- Email Card --}}
            <a href="{{ $email['href'] }}" class="contact-hero__trio-card contact-hero__trio-card--email" role="listitem">
                <div class="contact-hero__trio-top">
                    <span class="contact-hero__trio-label contact-hero__trio-label--email">Marketing &amp; Tour Inquiries</span>
                    <svg class="contact-hero__trio-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <rect width="20" height="16" x="2" y="4" rx="2"/>
                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                    </svg>
                </div>
                <span class="contact-hero__trio-email-text">{{ $email['address'] }}</span>
                <span class="contact-hero__trio-hint">Send a direct message →</span>
            </a>

            {{-- Address Card --}}
            <div class="contact-hero__trio-card contact-hero__trio-card--address" role="listitem">
                <div class="contact-hero__trio-top">
                    <span class="contact-hero__trio-label contact-hero__trio-label--address">Community Location</span>
                    <svg class="contact-hero__trio-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                </div>
                <span class="contact-hero__trio-address-text">{{ $address['full'] }}</span>
                <button type="button" class="contact-hero__copy-btn" data-copy-address="{{ $address['full'] }}">
                    <svg class="contact-hero__copy-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <rect width="14" height="14" x="8" y="8" rx="2" ry="2"/>
                        <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/>
                    </svg>
                    <span class="contact-hero__copy-label">Copy street address</span>
                </button>
            </div>
        </div>

        {{-- Verified Directory Monograph Card --}}
        <div class="contact-hero__directory-block herbarium-mount">
            <div class="contact-hero__directory-grid">
                <div class="contact-hero__arch-col">
                    <div class="contact-hero__arch-frame botanical-arch">
                        <img
                            src="{{ asset($plate['image']) }}"
                            alt="{{ $plate['alt'] }}"
                            class="contact-hero__arch-img"
                            loading="eager"
                        />
                        <div class="contact-hero__arch-badge">{{ $plate['badge'] }}</div>
                        <div class="contact-hero__arch-caption">
                            <span class="contact-hero__arch-tag">{{ $plate['caption_tag'] }}</span>
                            <p class="contact-hero__arch-text">{{ $plate['caption_text'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="contact-hero__ledger-col">
                    <div class="contact-hero__ledger-header">
                        <span class="contact-hero__ledger-badge">{{ $directory['badge'] }}</span>
                        <h2 class="contact-hero__ledger-title">{{ $directory['title'] }}</h2>
                        <p class="contact-hero__ledger-desc">{{ $directory['description'] }}</p>
                    </div>

                    <dl class="contact-hero__ledger-dl">
                        <div class="contact-hero__ledger-item">
                            <dt class="contact-hero__ledger-dt">Dedicated Care Programs</dt>
                            <dd class="contact-hero__ledger-dd">{{ $directory['care_programs'] }}</dd>
                        </div>
                        <div class="contact-hero__ledger-item">
                            <dt class="contact-hero__ledger-dt">Suite Formats Available to Tour</dt>
                            <dd class="contact-hero__ledger-dd">{{ $directory['suite_formats'] }}</dd>
                        </div>
                        <div class="contact-hero__ledger-item">
                            <dt class="contact-hero__ledger-dt">Licensing &amp; Location</dt>
                            <dd class="contact-hero__ledger-dd tabular-nums">{{ $directory['licensing_info'] }}</dd>
                        </div>
                    </dl>

                    <a href="{{ $directory['maps_url'] }}" target="_blank" rel="noopener noreferrer" class="contact-hero__maps-link">
                        <span>{{ $directory['maps_label'] }}</span>
                        <svg class="contact-hero__arrow-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M7 17L17 7"/>
                            <path d="M7 7h10v10"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- 4-Section Quick Jump Navigation Bar --}}
        <div class="contact-hero__quick-bar" aria-label="Quick jump to sections">
            @foreach ($quickSections as $item)
                <a href="#{{ $item['id'] }}" class="contact-hero__quick-item group">
                    <div class="contact-hero__quick-text">
                        <span class="contact-hero__quick-index">Section {{ $item['index'] }}</span>
                        <span class="contact-hero__quick-title">{{ $item['title'] }}</span>
                    </div>
                    <span class="contact-hero__quick-arrow" aria-hidden="true">↓</span>
                </a>
            @endforeach
        </div>
    </div>

    {{-- Authentic Photo Provenance Badge --}}
    <div class="contact-hero__provenance" aria-hidden="true">
        <span class="contact-hero__provenance-badge">● Mission Villa Courtyard Patio · 995 E Market St, Daly City</span>
    </div>
</section>
