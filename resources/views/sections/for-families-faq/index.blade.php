@php
    /** @var array $data Normalised by App\Content\Sections\ForFamiliesFaqSection */
    $site = config('missionvilla');
    $categories = $data['categories'];
    $items = $data['items'];
    $groups = ['Care', 'Suites', 'Cost', 'Visits'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/for-families-faq.css', 'resources/js/sections/for-families-faq.js'])
@endpush
{{--
    FOR FAMILIES SECTION 05 · GROUPED FAQS (CARE, SUITES, COST & VISITS)
--}}
<section class="ff-faq fluid-canvas paper-texture" aria-labelledby="ff-faq-heading" id="grouped-family-faqs" data-ff-faq>
    <div class="ff-faq__inner">
        {{-- Header & Expand/Collapse Controls --}}
        <div class="ff-faq__header">
            <div class="ff-faq__header-copy">
                <span class="ff-faq__kicker font-script">{{ $data['eyebrow'] }}</span>
                <h2 id="ff-faq-heading" class="ff-faq__title">
                    {!! $data['heading'] !!}
                </h2>
                <div class="ff-faq__intro">
                    {!! $data['intro'] !!}
                </div>
            </div>

            <div class="ff-faq__controls">
                <button
                    type="button"
                    class="ff-faq__ctrl-btn"
                    data-faq-action="expand-all"
                >
                    Expand Visible (<span data-faq-visible-count>{{ count($items) }}</span>)
                </button>
                <button
                    type="button"
                    class="ff-faq__ctrl-btn"
                    data-faq-action="collapse-all"
                >
                    Collapse All
                </button>
            </div>
        </div>

        {{-- Filter Tabs & Search Bar --}}
        <div class="ff-faq__toolbar">
            <div role="tablist" aria-label="Filter FAQs by category" class="ff-faq__category-tabs">
                @foreach ($categories as $idx => $cat)
                    @php
                        $count = $cat === 'All Topics'
                            ? count($items)
                            : count(array_filter($items, fn($f) => $f['category'] === $cat));
                    @endphp
                    <button
                        type="button"
                        role="tab"
                        aria-selected="{{ $idx === 0 ? 'true' : 'false' }}"
                        class="ff-faq__cat-btn {{ $idx === 0 ? 'ff-faq__cat-btn--active' : '' }}"
                        data-faq-filter="{{ $cat }}"
                    >
                        <span>{{ $cat }}</span>
                        <span class="ff-faq__cat-count">({{ $count }})</span>
                    </button>
                @endforeach
            </div>

            <div class="ff-faq__search-wrapper">
                <label for="family-faq-search" class="sr-only">Search Family FAQs</label>
                <svg class="ff-faq__search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input
                    id="family-faq-search"
                    type="search"
                    placeholder="Search care, suites, cost, visits..."
                    class="ff-faq__search-input"
                    data-faq-search-input
                >
                <button
                    type="button"
                    aria-label="Clear FAQ search"
                    class="ff-faq__search-clear"
                    data-faq-search-clear
                    hidden
                >
                    ✕
                </button>
            </div>
        </div>

        {{-- Empty Search Results Notice --}}
        <div class="ff-faq__empty-state" data-faq-empty hidden>
            <p class="ff-faq__empty-title">
                No FAQ items matched <span data-faq-empty-query>“”</span> in <span data-faq-empty-cat>All Topics</span>.
            </p>
            <p class="ff-faq__empty-text">
                Try clearing your search filter or call our Daly City team directly at {{ $site['phone']['display'] }}.
            </p>
            <button
                type="button"
                class="ff-faq__empty-reset"
                data-faq-action="reset-filters"
            >
                Reset FAQ Filters
            </button>
        </div>

        {{-- Grouped FAQ Display --}}
        <div class="ff-faq__groups" data-faq-groups>
            @foreach ($groups as $group)
                @php
                    $groupItems = array_filter($items, fn($f) => $f['category'] === $group);
                    $groupSubtitle = match($group) {
                        'Care' => 'Legacies™ Memory Care, 24-hour staff support & short-term Respite Care',
                        'Suites' => 'Private Suites, Companion Units, Jack & Jill layouts & personal touches',
                        'Cost' => 'Assessment-informed pricing, consolidated inclusions & planning pathways',
                        default => 'Scheduling a Daly City walkthrough, first conversations & family visits',
                    };
                @endphp
                <div class="ff-faq__group" data-faq-group="{{ $group }}">
                    <div class="ff-faq__group-header">
                        <div class="ff-faq__group-title-wrap">
                            <h3 class="ff-faq__group-heading">{{ $group }} FAQs</h3>
                            <span class="ff-faq__group-sub">· {{ $groupSubtitle }}</span>
                        </div>
                        <span class="ff-faq__group-count">
                            <span data-faq-group-num="{{ $group }}">{{ count($groupItems) }}</span>
                            Questions
                        </span>
                    </div>

                    <div class="ff-faq__group-items">
                        @foreach ($groupItems as $faq)
                            <div
                                class="ff-faq__item"
                                data-faq-item="{{ $faq['id'] }}"
                                data-faq-category="{{ $faq['category'] }}"
                                data-faq-question="{{ strtolower($faq['question']) }}"
                                data-faq-answer="{{ strtolower($faq['answer']) }}"
                                data-faq-code="{{ strtolower($faq['code']) }}"
                            >
                                <button
                                    type="button"
                                    class="ff-faq__question-btn"
                                    aria-expanded="false"
                                    aria-controls="faq-ans-{{ $faq['id'] }}"
                                    data-faq-toggle="{{ $faq['id'] }}"
                                >
                                    <div class="ff-faq__question-meta">
                                        <div class="ff-faq__code-badge">
                                            <span class="tabular-nums">{{ $faq['code'] }}</span>
                                            <span aria-hidden="true">·</span>
                                            <span class="ff-faq__cat-tag">{{ $faq['category'] }}</span>
                                        </div>
                                        <span class="ff-faq__question-text">{{ $faq['question'] }}</span>
                                    </div>
                                    <svg class="ff-faq__chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                        <polyline points="6 9 12 15 18 9"/>
                                    </svg>
                                </button>

                                <div
                                    id="faq-ans-{{ $faq['id'] }}"
                                    class="ff-faq__answer-panel"
                                    hidden
                                >
                                    <div class="ff-faq__answer-content">
                                        <p class="ff-faq__answer-text">{{ $faq['answer'] }}</p>

                                        @if (!empty($faq['confirmation_note']))
                                            <p class="ff-faq__confirmation-note">
                                                <strong>Tour Confirmation Note:</strong> {{ $faq['confirmation_note'] }}
                                            </p>
                                        @endif

                                        <div class="ff-faq__answer-footer">
                                            @if (str_starts_with($faq['related_route_href'], '#'))
                                                <button
                                                    type="button"
                                                    class="ff-faq__related-link"
                                                    data-inquiry="schedule_visit"
                                                    data-inquiry-source="ff-faq"
                                                    data-care="{{ $faq['category'] === 'Care' && str_contains($faq['id'], 'respite') ? 'respite_care' : 'memory_care' }}"
                                                    data-note="FAQ ({{ $faq['code'] }}): {{ $faq['question'] }}"
                                                >
                                                    <span>{{ $faq['related_route_label'] }}</span>
                                                </button>
                                            @else
                                                <a
                                                    href="{{ $faq['related_route_href'] }}"
                                                    class="ff-faq__related-link"
                                                >
                                                    <span>{{ $faq['related_route_label'] }}</span>
                                                    <svg class="ff-faq__link-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                                        <line x1="7" y1="17" x2="17" y2="7"/>
                                                        <polyline points="7 7 17 7 17 17"/>
                                                    </svg>
                                                </a>
                                            @endif

                                            <button
                                                type="button"
                                                class="ff-faq__inquiry-prompt"
                                                data-inquiry="schedule_visit"
                                                data-inquiry-source="ff-faq"
                                                data-care="{{ $faq['category'] === 'Care' && str_contains($faq['id'], 'respite') ? 'respite_care' : 'memory_care' }}"
                                                data-note="Follow-up on FAQ ({{ $faq['code'] }}): &quot;{{ $faq['question'] }}&quot;"
                                            >
                                                Ask Our Team About This Question →
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
