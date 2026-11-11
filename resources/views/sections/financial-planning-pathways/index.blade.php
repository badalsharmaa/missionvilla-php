@php
    /** @var array $data Normalised by App\Content\Sections\FinancialPlanningPathwaysSection */
    $pathways = $data['pathways'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/financial-planning-pathways.css'])
@endpush
{{--
    FINANCIAL PLANNING SECTION 05 · WAYS TO PLAN & BENEFIT PATHWAYS
--}}
<section class="fp-pathways fluid-canvas" aria-labelledby="fp-pathways-heading" id="planning-pathways-and-benefits" data-fp-pathways>
    <div class="fp-pathways__inner">
        {{-- Section Header --}}
        <div class="fp-pathways__header">
            <span class="fp-pathways__kicker font-script">{{ $data['eyebrow'] }}</span>
            <h2 id="fp-pathways-heading" class="fp-pathways__title">
                {!! $data['heading'] !!}
            </h2>
            <div class="fp-pathways__intro">
                {!! $data['intro'] !!}
            </div>
        </div>

        {{-- 4 Pathways Grid (2x2) --}}
        <div class="fp-pathways__grid">
            @foreach ($pathways as $p)
                @php
                    $isConfirmed = $p['verification_status'] === 'Standard Planning Guidance';
                @endphp
                <div class="fp-pathways__card herbarium-mount" data-pathway-card="{{ $p['id'] }}">
                    <div class="fp-pathways__card-top">
                        <div class="fp-pathways__card-meta">
                            <span class="fp-pathways__badge">{{ $p['badge'] }}</span>
                            <span class="fp-pathways__status-pill {{ $isConfirmed ? 'fp-pathways__status-pill--standard' : 'fp-pathways__status-pill--verify' }}">
                                {{ $p['verification_status'] }}
                            </span>
                        </div>

                        <h3 class="fp-pathways__card-title">{{ $p['title'] }}</h3>
                        <span class="fp-pathways__card-sub">{{ $p['subtitle'] }}</span>
                        <p class="fp-pathways__card-desc">{{ $p['description'] }}</p>
                    </div>

                    <div class="fp-pathways__questions-box">
                        <span class="fp-pathways__questions-title">Questions to Explore for Your Family:</span>
                        <ul class="fp-pathways__questions-list">
                            @foreach ($p['questions_to_ask'] as $q)
                                <li class="fp-pathways__question-item">
                                    <svg class="fp-pathways__bullet-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <circle cx="12" cy="12" r="4"/>
                                    </svg>
                                    <span>{{ $q }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="fp-pathways__card-footer">
                        <p class="fp-pathways__disclaimer">
                            <strong>Note:</strong> {{ $p['disclaimer_note'] }}
                        </p>

                        <div class="fp-pathways__action-row">
                            <button
                                type="button"
                                class="fp-pathways__btn"
                                data-inquiry="request_pricing"
                                data-inquiry-source="fp-pathways"
                                data-care="memory_care"
                                data-note="{{ $p['inquiry_preset_note'] }}"
                            >
                                <span>Discuss This Pathway With Our Team →</span>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
