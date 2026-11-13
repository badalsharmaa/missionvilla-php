@php
    /** @var array $data Normalised by App\Content\Sections\ResourcesPacketSection */
    $brochure = $data['brochure_card'];
    $packetItems = $data['packet_items'];
    $defaultSelectedCount = count(array_filter($packetItems, fn($it) => $it['defaultSelected']));
@endphp
@push('section-assets')
    @vite(['resources/css/sections/resources-packet.css', 'resources/js/sections/resources-packet.js'])
@endpush
{{--
    RESOURCES SECTION 03 · COMMUNITY BROCHURE STATUS & TOUR RESOURCE PACKET BUILDER
--}}
<section class="res-packet fluid-canvas" aria-labelledby="brochure-packet-heading" id="brochure-and-packet" data-res-packet>
    <div class="res-packet__inner">
        <div class="res-packet__grid">
            {{-- Left 5 Columns: Brochure Status Card --}}
            <div class="res-packet__story">
                <div class="res-packet__header">
                    <span class="res-packet__kicker">{{ $data['eyebrow'] }}</span>
                    <h2 id="brochure-packet-heading" class="res-packet__title">
                        {!! $data['heading'] !!}
                    </h2>
                    <div class="res-packet__intro">
                        {!! $data['intro'] !!}
                    </div>
                </div>

                {{-- Brochure Asset Vault --}}
                <div class="res-packet__brochure-box">
                    <div class="res-packet__brochure-head">
                        <span class="res-packet__brochure-badge">
                            <svg class="res-packet__doc-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                                <line x1="16" y1="13" x2="8" y2="13"/>
                                <line x1="16" y1="17" x2="8" y2="17"/>
                                <polyline points="10 9 9 9 8 9"/>
                            </svg>
                            <span>{{ $brochure['badge'] }}</span>
                        </span>
                        <span class="res-packet__brochure-status">{{ $brochure['status'] }}</span>
                    </div>

                    <h3 class="res-packet__brochure-title">{{ $brochure['title'] }}</h3>
                    <div class="res-packet__brochure-body">
                        {!! $brochure['body'] !!}
                    </div>

                    <div class="res-packet__brochure-contact">
                        <span class="res-packet__contact-prompt">Need community information right away?</span>
                        <p class="res-packet__contact-copy">
                            Call our Daly City desk at
                            <a href="tel:16507561995" class="res-packet__contact-link">{{ $brochure['phone_label'] }}</a>
                            or email
                            <a href="mailto:{{ $brochure['email_label'] }}" class="res-packet__contact-link">{{ $brochure['email_label'] }}</a>,
                            or use the Packet Builder on the right to request printed materials for your visit.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Right 7 Columns: Interactive Packet Assembler --}}
            <div class="res-packet__builder">
                <div class="res-packet__builder-card herbarium-mount">
                    <div class="res-packet__builder-head">
                        <div>
                            <span class="res-packet__builder-kicker">Interactive Tour Preparation Tool</span>
                            <h3 class="res-packet__builder-title">Assemble Your Family Resource Packet</h3>
                            <p class="res-packet__builder-sub">
                                Select the guides and worksheets you would like our team to prepare for your visit or phone consultation, then attach them to your inquiry with one click.
                            </p>
                        </div>
                        <span class="res-packet__builder-count">
                            <strong data-packet-count>{{ $defaultSelectedCount }}</strong> of {{ count($packetItems) }} Selected
                        </span>
                    </div>

                    {{-- Selectable Items List --}}
                    <div class="res-packet__items" data-packet-list>
                        @foreach ($packetItems as $doc)
                            <div
                                class="res-packet__item {{ $doc['defaultSelected'] ? 'res-packet__item--checked' : '' }}"
                                role="checkbox"
                                aria-checked="{{ $doc['defaultSelected'] ? 'true' : 'false' }}"
                                tabindex="0"
                                data-packet-item="{{ $doc['id'] }}"
                                data-packet-code="{{ $doc['code'] }}"
                                data-packet-title="{{ $doc['title'] }}"
                            >
                                <div class="res-packet__item-box" aria-hidden="true">
                                    <svg class="res-packet__check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <polyline points="20 6 9 17 4 12"/>
                                    </svg>
                                </div>

                                <div class="res-packet__item-copy">
                                    <div class="res-packet__item-meta">
                                        <span class="res-packet__item-code">{{ $doc['code'] }}</span>
                                        <span aria-hidden="true">·</span>
                                        <span>{{ $doc['category'] }}</span>
                                    </div>
                                    <h4 class="res-packet__item-title">{{ $doc['title'] }}</h4>
                                    <p class="res-packet__item-desc">{{ $doc['description'] }}</p>
                                    <p class="res-packet__item-avail">Status: {{ $doc['availabilityStatus'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Builder Footer & Submit --}}
                    <div class="res-packet__builder-footer">
                        <div class="res-packet__builder-ctrls">
                            <button type="button" class="res-packet__link-btn" data-packet-select-all>
                                Select All 5 Items
                            </button>
                            <span aria-hidden="true" class="res-packet__ctrl-sep">·</span>
                            <button type="button" class="res-packet__link-btn res-packet__link-btn--clear" data-packet-clear>
                                Clear Selection
                            </button>
                        </div>

                        <button
                            type="button"
                            class="res-packet__attach-btn"
                            data-inquiry="schedule_visit"
                            data-inquiry-source="res-packet"
                            data-care="exploring"
                            data-note="Requesting family resource packet items from /resources"
                            data-packet-attach-btn
                        >
                            <svg class="res-packet__clip-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
                                <rect x="8" y="2" width="8" height="4" rx="1" ry="1"/>
                            </svg>
                            <span data-packet-attach-label>
                                Attach {{ $defaultSelectedCount }} Packet Item{{ $defaultSelectedCount === 1 ? '' : 's' }} to Visit Inquiry ↓
                            </span>
                        </button>
                    </div>

                    <div class="res-packet__attached-notice" data-packet-notice hidden>
                        Your selected resource packet items have been added to the Visit &amp; Information Request form below.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
