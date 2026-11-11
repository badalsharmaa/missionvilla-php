@php
    /** @var array $data Normalised by App\Content\Sections\ResourcesFaqSection */
    $categories = $data['categories'];
    $items = $data['items'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/resources-faq.css', 'resources/js/sections/resources-faq.js'])
@endpush
{{--
    RESOURCES SECTION 05 · SEARCHABLE RESOURCES, BROCHURE & BLOG FAQS
--}}
<section class="res-faq fluid-canvas" aria-labelledby="resources-faqs-heading" id="resources-faqs" data-res-faq>
    <div class="res-faq__inner">
        <div class="res-faq__grid">
            {{-- Left 4 Columns: Header, Search & Filter --}}
            <div class="res-faq__sidebar">
                <div class="res-faq__header">
                    <span class="res-faq__kicker font-script">{{ $data['eyebrow'] }}</span>
                    <h2 id="resources-faqs-heading" class="res-faq__title">
                        {!! $data['heading'] !!}
                    </h2>
                    <div class="res-faq__intro">
                        {!! $data['intro'] !!}
                    </div>
                </div>

                {{-- Search Box --}}
                <div class="res-faq__search-wrap">
                    <label for="res-faq-search-input" class="res-faq__search-label">Search Resource FAQs</label>
                    <div class="res-faq__search-field">
                        <svg class="res-faq__search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <circle cx="11" cy="11" r="8"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input
                            id="res-faq-search-input"
                            type="search"
                            placeholder="Filter questions..."
                            class="res-faq__search-input"
                            data-faq-search
                        >
                    </div>
                </div>

                {{-- Category Filter Stack --}}
                <div class="res-faq__categories" role="group" aria-label="FAQ topic categories">
                    @foreach ($categories as $idx => $cat)
                        <button
                            type="button"
                            class="res-faq__cat-btn {{ $idx === 0 ? 'res-faq__cat-btn--active' : '' }}"
                            data-faq-filter="{{ $cat }}"
                        >
                            <span>{{ $cat }}</span>
                            <span aria-hidden="true">→</span>
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Right 8 Columns: Accordion Items --}}
            <div class="res-faq__content">
                {{-- Empty Search Fallback --}}
                <div class="res-faq__empty" data-faq-empty hidden>
                    <p class="res-faq__empty-title">No resource FAQs matched your current filter.</p>
                    <button type="button" class="res-faq__empty-btn" data-faq-reset>
                        Show All 6 Resource FAQs
                    </button>
                </div>

                <div class="res-faq__list" data-faq-list>
                    @foreach ($items as $idx => $faq)
                        @php
                            $isDefaultOpen = ($idx === 0 || $idx === 2 || $idx === 3);
                            $isAnchor = str_starts_with($faq['relatedHref'], '#');
                        @endphp
                        <div
                            class="res-faq__item"
                            data-faq-item="{{ $faq['id'] }}"
                            data-faq-category="{{ $faq['category'] }}"
                            data-faq-haystack="{{ strtolower($faq['code'].' '.$faq['category'].' '.$faq['question'].' '.$faq['answer'].' '.($faq['confirmationNote'] ?? '')) }}"
                        >
                            <button
                                type="button"
                                aria-expanded="{{ $isDefaultOpen ? 'true' : 'false' }}"
                                aria-controls="res-faq-ans-{{ $faq['id'] }}"
                                class="res-faq__question-btn"
                                data-faq-toggle
                            >
                                <div class="res-faq__q-wrap">
                                    <div class="res-faq__q-meta">
                                        <span class="res-faq__q-code">{{ $faq['code'] }}</span>
                                        <span aria-hidden="true">·</span>
                                        <span class="res-faq__q-cat">{{ $faq['category'] }}</span>
                                    </div>
                                    <h3 class="res-faq__q-text">{{ $faq['question'] }}</h3>
                                </div>

                                <svg class="res-faq__chevron {{ $isDefaultOpen ? 'res-faq__chevron--open' : '' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                    <polyline points="6 9 12 15 18 9"/>
                                </svg>
                            </button>

                            <div
                                id="res-faq-ans-{{ $faq['id'] }}"
                                class="res-faq__answer-box"
                                {{ $isDefaultOpen ? '' : 'hidden' }}
                                data-faq-answer
                            >
                                <div class="res-faq__answer-inner">
                                    <div class="res-faq__answer-text">
                                        {!! $faq['answer'] !!}
                                    </div>

                                    @if (!empty($faq['confirmationNote']))
                                        <div class="res-faq__confirm-box">
                                            {{ $faq['confirmationNote'] }}
                                        </div>
                                    @endif

                                    <div class="res-faq__link-wrap">
                                        @if ($isAnchor)
                                            <a href="{{ $faq['relatedHref'] }}" class="res-faq__link">
                                                <span>{{ $faq['relatedLabel'] }}</span>
                                                <svg class="res-faq__link-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                    <line x1="7" y1="17" x2="17" y2="7"/>
                                                    <polyline points="7 7 17 7 17 17"/>
                                                </svg>
                                            </a>
                                        @else
                                            <a href="{{ url($faq['relatedHref']) }}" class="res-faq__link">
                                                <span>{{ $faq['relatedLabel'] }}</span>
                                                <svg class="res-faq__link-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                    <line x1="7" y1="17" x2="17" y2="7"/>
                                                    <polyline points="7 7 17 7 17 17"/>
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
