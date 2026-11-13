@php
    /** @var array $data Normalised by App\Content\Sections\FinancialPlanningFactorsSection */
    $factors = $data['factors'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/financial-planning-factors.css'])
@endpush
{{--
    FINANCIAL PLANNING SECTION 02 · 4 CORE FACTORS SHAPING SENIOR LIVING COSTS
--}}
<section class="fp-factors fluid-canvas" aria-labelledby="fp-factors-heading" id="factors-affecting-cost" data-fp-factors>
    <div class="fp-factors__inner">
        {{-- Section Header --}}
        <div class="fp-factors__header">
            <span class="fp-factors__kicker">{{ $data['eyebrow'] }}</span>
            <h2 id="fp-factors-heading" class="fp-factors__title">
                {!! $data['heading'] !!}
            </h2>
            <div class="fp-factors__intro">
                {!! $data['intro'] !!}
            </div>
        </div>

        {{-- 2x2 Grid of 4 Factors --}}
        <div class="fp-factors__grid">
            @foreach ($factors as $factor)
                <div class="fp-factors__card herbarium-mount" data-factor-card="{{ $factor['id'] }}">
                    <div class="fp-factors__card-top">
                        <div class="fp-factors__card-meta">
                            <span class="fp-factors__card-index">{{ $factor['index'] }}</span>
                            <span aria-hidden="true">·</span>
                            <span class="fp-factors__card-kicker">{{ $factor['kicker'] }}</span>
                        </div>
                        <h3 class="fp-factors__card-title">{{ $factor['title'] }}</h3>
                        <span class="fp-factors__card-sub">{{ $factor['subtitle'] }}</span>
                        <p class="fp-factors__card-explanation">{{ $factor['explanation'] }}</p>
                    </div>

                    <div class="fp-factors__review-box">
                        <span class="fp-factors__review-title">What We Review With Your Family</span>
                        <ul class="fp-factors__review-list">
                            @foreach ($factor['what_we_review_together'] as $item)
                                <li class="fp-factors__review-item">
                                    <svg class="fp-factors__check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                        <polyline points="20 6 9 17 4 12"/>
                                    </svg>
                                    <span>{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="fp-factors__card-footer">
                        <div class="fp-factors__question-callout">
                            <strong class="fp-factors__question-lead">Question for Your Visit:</strong>
                            <p class="fp-factors__question-text">“{{ $factor['questions_for_your_visit'] }}”</p>
                        </div>

                        <div class="fp-factors__card-actions">
                            <a href="{{ $factor['related_route_href'] }}" class="fp-factors__link">
                                <span>{{ $factor['related_route_label'] }}</span>
                                <svg class="fp-factors__link-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                    <line x1="7" y1="17" x2="17" y2="7"/>
                                    <polyline points="7 7 17 7 17 17"/>
                                </svg>
                            </a>

                            <button
                                type="button"
                                class="fp-factors__prompt-btn"
                                data-inquiry="request_pricing"
                                data-inquiry-source="fp-factors"
                                data-care="memory_care"
                                data-note="Question about {{ $factor['title'] }}: {{ $factor['questions_for_your_visit'] }}"
                            >
                                Ask About This Factor →
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
