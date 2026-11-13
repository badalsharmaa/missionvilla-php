@php
    /** @var array $data Normalised by App\Content\Sections\FinancialPlanningFaqSection */
    $items = $data['items'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/financial-planning-faq.css', 'resources/js/sections/financial-planning-faq.js'])
@endpush
{{--
    FINANCIAL PLANNING SECTION 06 · COST & ASSESSMENT FAQS
--}}
<section class="fp-faq fluid-canvas paper-texture" aria-labelledby="fp-faq-heading" id="financial-planning-faqs" data-fp-faq>
    <div class="fp-faq__inner">
        {{-- Section Header --}}
        <div class="fp-faq__header">
            <div class="fp-faq__header-copy">
                <span class="fp-faq__kicker">{{ $data['eyebrow'] }}</span>
                <h2 id="fp-faq-heading" class="fp-faq__title">
                    {!! $data['heading'] !!}
                </h2>
                <div class="fp-faq__intro">
                    {!! $data['intro'] !!}
                </div>
            </div>

            <div class="fp-faq__controls">
                <button
                    type="button"
                    class="fp-faq__ctrl-btn"
                    data-faq-action="expand-all"
                >
                    Expand All
                </button>
                <button
                    type="button"
                    class="fp-faq__ctrl-btn"
                    data-faq-action="collapse-all"
                >
                    Collapse All
                </button>
            </div>
        </div>

        {{-- FAQ Accordion Items --}}
        <div class="fp-faq__list">
            @foreach ($items as $idx => $faq)
                <div class="fp-faq__item" data-faq-item="{{ $faq['id'] }}">
                    <button
                        type="button"
                        class="fp-faq__question-btn"
                        aria-expanded="false"
                        aria-controls="fp-faq-ans-{{ $faq['id'] }}"
                        data-faq-toggle="{{ $faq['id'] }}"
                    >
                        <div class="fp-faq__question-meta">
                            <span class="fp-faq__category-tag">{{ $faq['category'] }}</span>
                            <span class="fp-faq__question-text">{{ $faq['question'] }}</span>
                        </div>
                        <svg class="fp-faq__chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </button>

                    <div
                        id="fp-faq-ans-{{ $faq['id'] }}"
                        class="fp-faq__answer-panel"
                        hidden
                    >
                        <div class="fp-faq__answer-content">
                            <p class="fp-faq__answer-text">{{ $faq['answer'] }}</p>

                            <div class="fp-faq__answer-footer">
                                <button
                                    type="button"
                                    class="fp-faq__inquiry-prompt"
                                    data-inquiry="request_pricing"
                                    data-inquiry-source="fp-faq"
                                    data-care="memory_care"
                                    data-note="Question regarding: &quot;{{ $faq['question'] }}&quot;"
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
</section>
