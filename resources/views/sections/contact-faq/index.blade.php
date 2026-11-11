@php
    /** @var array $data Normalised by App\Content\Sections\ContactFaqSection */
    $categories = $data['categories'];
    $faqs = $data['faqs'];
    $bridges = $data['bridges'];
    $defaultOpenIds = ['contact-faq-schedule-tour', 'contact-faq-parking-and-mobility', 'contact-faq-no-medical-history'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/contact-faq.css', 'resources/js/sections/contact-faq.js'])
@endpush
{{--
    CONTACT SECTION 06 · CONTACT, VISIT & ACCESSIBILITY FAQS (#contact-faqs)
--}}
<section class="contact-faq fluid-canvas" aria-labelledby="contact-faq-heading" id="contact-faqs" data-contact-faq>
    <div class="contact-faq__inner">
        {{-- Section Header --}}
        <div class="contact-faq__header">
            <div class="contact-faq__header-left">
                <span class="contact-faq__script font-script">{{ $data['script_title'] }}</span>
                <h2 id="contact-faq-heading" class="contact-faq__title">
                    {!! $data['heading'] !!}
                </h2>
            </div>
            <div class="contact-faq__header-right">
                <div class="contact-faq__search-wrapper">
                    <svg class="contact-faq__search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" x2="16.65" y1="21" y2="16.65"/>
                    </svg>
                    <input
                        type="search"
                        aria-label="Search contact and accessibility FAQs"
                        placeholder="{{ $data['search_placeholder'] }}"
                        class="contact-faq__search-input"
                        data-faq-search
                    />
                </div>
            </div>
        </div>

        {{-- Filter Bar & Expand/Collapse Controls --}}
        <div class="contact-faq__filter-bar">
            <div class="contact-faq__category-pills">
                @foreach ($categories as $cat)
                    <button
                        type="button"
                        class="contact-faq__pill {{ $loop->first ? 'contact-faq__pill--active' : '' }}"
                        data-faq-category="{{ $cat }}"
                    >
                        {{ $cat }}
                    </button>
                @endforeach
            </div>

            <div class="contact-faq__expand-controls">
                <button type="button" class="contact-faq__ctrl-btn" data-faq-expand-all>
                    Expand All (<span data-faq-count>{{ count($faqs) }}</span>)
                </button>
                <span aria-hidden="true" class="contact-faq__ctrl-dot">·</span>
                <button type="button" class="contact-faq__ctrl-btn contact-faq__ctrl-btn--dim" data-faq-collapse-all>
                    Collapse All
                </button>
            </div>
        </div>

        {{-- FAQ Accordion Grid --}}
        <div class="contact-faq__grid" data-faq-grid>
            @foreach ($faqs as $faq)
                @php $isOpen = in_array($faq['id'], $defaultOpenIds, true); @endphp
                <div
                    class="contact-faq__item"
                    data-faq-item="{{ $faq['id'] }}"
                    data-faq-cat="{{ $faq['category'] }}"
                    data-faq-searchable="{{ strtolower($faq['code'].' '.$faq['category'].' '.$faq['question'].' '.$faq['answer'].' '.($faq['confirmation_note'] ?? '')) }}"
                >
                    <button
                        type="button"
                        class="contact-faq__trigger"
                        aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
                        data-faq-trigger
                    >
                        <div class="contact-faq__trigger-text">
                            <span class="contact-faq__item-badge">{{ $faq['code'] }} · {{ $faq['category'] }}</span>
                            <h3 class="contact-faq__item-question">{{ $faq['question'] }}</h3>
                        </div>
                        <svg class="contact-faq__chevron {{ $isOpen ? 'contact-faq__chevron--open' : '' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </button>

                    <div class="contact-faq__answer-panel" {{ $isOpen ? '' : 'hidden' }}>
                        <div class="contact-faq__answer-body">
                            <p class="contact-faq__answer-text">{{ $faq['answer'] }}</p>
                            @if (!empty($faq['confirmation_note']))
                                <p class="contact-faq__confirmation-note">
                                    {{ $faq['confirmation_note'] }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Zero Results Message --}}
        <div class="contact-faq__empty-state" data-faq-empty hidden>
            <p class="contact-faq__empty-text">No contact FAQs matched your search.</p>
            <button type="button" class="contact-faq__reset-btn" data-faq-reset>
                Reset FAQ Filters
            </button>
        </div>

        {{-- Contextual Planning Bridges --}}
        <div class="contact-faq__bridges-grid">
            @foreach ($bridges as $bridge)
                <div class="contact-faq__bridge-card herbarium-mount">
                    <div class="contact-faq__bridge-header">
                        <div class="contact-faq__bridge-meta">
                            <span class="contact-faq__bridge-eyebrow">{{ $bridge['eyebrow'] }}</span>
                            @if ($bridge['icon'] === 'heart-handshake')
                                <svg class="contact-faq__bridge-icon contact-faq__bridge-icon--green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
                                </svg>
                            @elseif ($bridge['icon'] === 'file-spreadsheet')
                                <svg class="contact-faq__bridge-icon contact-faq__bridge-icon--terracotta" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/>
                                    <path d="M14 2v4a2 2 0 0 0 2 2h4"/>
                                    <path d="M8 13h2"/>
                                    <path d="M14 13h2"/>
                                    <path d="M8 17h2"/>
                                    <path d="M14 17h2"/>
                                </svg>
                            @else
                                <svg class="contact-faq__bridge-icon contact-faq__bridge-icon--purple" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/>
                                </svg>
                            @endif
                        </div>

                        <h3 class="contact-faq__bridge-title">{{ $bridge['title'] }}</h3>
                        <p class="contact-faq__bridge-desc">{{ $bridge['description'] }}</p>
                    </div>

                    <div class="contact-faq__bridge-actions">
                        @foreach ($bridge['links'] as $link)
                            <a
                                href="{{ url($link['href']) }}"
                                class="contact-faq__bridge-link {{ $link['style'] === 'primary' ? 'contact-faq__bridge-link--primary' : 'contact-faq__bridge-link--outline' }}"
                            >
                                <span>{{ $link['label'] }}</span>
                                @if (count($bridge['links']) === 1)
                                    <svg class="contact-faq__bridge-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path d="M7 17L17 7"/>
                                        <path d="M7 7h10v10"/>
                                    </svg>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
