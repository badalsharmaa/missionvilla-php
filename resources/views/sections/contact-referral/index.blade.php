@php
    /** @var array $data Normalised by App\Content\Sections\ContactReferralSection */
    $pathways = $data['pathways'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/contact-referral.css', 'resources/js/sections/contact-referral.js'])
@endpush
{{--
    CONTACT SECTION 05 · OPTIONAL REFERRAL INTEREST PATHWAYS (#referral-interest)
--}}
<section class="contact-referral fluid-canvas" aria-labelledby="contact-referral-heading" id="referral-interest" data-contact-referral>
    <div class="contact-referral__inner">
        {{-- Section Header --}}
        <div class="contact-referral__header">
            <div class="contact-referral__header-left">
                <span class="contact-referral__script">{{ $data['script_title'] }}</span>
                <h2 id="contact-referral-heading" class="contact-referral__title">
                    {!! $data['heading'] !!}
                </h2>
            </div>
            <div class="contact-referral__header-right">
                <div class="contact-referral__tabs" role="tablist" aria-label="Select referral interest pathway">
                    @foreach ($pathways as $pathway)
                        <button
                            type="button"
                            role="tab"
                            aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                            class="contact-referral__tab {{ $loop->first ? 'contact-referral__tab--active' : '' }}"
                            data-referral-tab="{{ $pathway['id'] }}"
                        >
                            {{ $pathway['id'] === 'family-friend-referral' ? 'Family & Friend Referral' : 'Care Professionals & Advisors' }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Active Referral Pathway Cards --}}
        <div class="contact-referral__panels">
            @foreach ($pathways as $pathway)
                <div
                    class="contact-referral__card herbarium-mount"
                    data-referral-panel="{{ $pathway['id'] }}"
                    {{ $loop->first ? '' : 'hidden' }}
                >
                    <div class="contact-referral__grid">
                        {{-- Left 7 Columns: Details & Highlights --}}
                        <div class="contact-referral__col-left">
                            <div class="contact-referral__meta">
                                <span class="contact-referral__badge">{{ $pathway['badge'] }}</span>
                                <span aria-hidden="true" class="contact-referral__dot">·</span>
                                <span class="contact-referral__status">{{ $pathway['verification_status'] }}</span>
                            </div>

                            <h3 class="contact-referral__panel-title">{{ $pathway['title'] }}</h3>
                            <p class="contact-referral__panel-desc">{{ $pathway['description'] }}</p>

                            <ul class="contact-referral__highlights-list">
                                @foreach ($pathway['highlights'] as $highlight)
                                    <li class="contact-referral__highlight-item">
                                        <svg class="contact-referral__highlight-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                            <circle cx="9" cy="7" r="4"/>
                                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                        </svg>
                                        <span>{{ $highlight }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- Right 5 Columns: Transparency Note & Actions --}}
                        <div class="contact-referral__col-right">
                            <div class="contact-referral__disclosure-card">
                                <span class="contact-referral__disclosure-label">Transparency &amp; Pre-Launch Verification Note</span>
                                <p class="contact-referral__disclosure-text">{{ $pathway['verification_disclosure'] }}</p>
                            </div>

                            <div class="contact-referral__actions-col">
                                <button
                                    type="button"
                                    class="contact-referral__prefill-btn"
                                    data-referral-prefill
                                    data-preset-intent="Referral or Professional Introduction"
                                    data-preset-care="Both / Exploring Options"
                                    data-preset-suite="Open / Compare on Tour"
                                    data-preset-message="{{ $pathway['preset_inquiry_note'] }}"
                                    data-preset-referral="{{ $pathway['title'] }}"
                                >
                                    <svg class="contact-referral__msg-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                    </svg>
                                    <span>Pre-Fill Guided Form With Referral Inquiry ↑</span>
                                </button>

                                <a href="tel:16507561995" class="contact-referral__call-link">
                                    <svg class="contact-referral__call-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                    </svg>
                                    <span>Or Call Desk Directly: 650-756-1995</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
