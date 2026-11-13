@php
    /** @var array $data Normalised by App\Content\Sections\ForFamiliesDecisionGuideSection */
    $pathways = $data['pathways'];
    $dimensions = $data['comparison_dimensions'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/for-families-decision-guide.css', 'resources/js/sections/for-families-decision-guide.js'])
@endpush
{{--
    FOR FAMILIES SECTION 02 · FAMILY DECISION GUIDE & COMPARISON LEDGER
--}}
<section class="ff-guide" aria-labelledby="ff-guide-heading" id="family-decision-guide" data-ff-guide>
    <div class="ff-guide__inner">
        {{-- Header --}}
        <div class="ff-guide__header">
            <div class="ff-guide__header-lead">
                <span class="ff-guide__kicker">{{ $data['eyebrow'] }}</span>
                <h2 id="ff-guide-heading" class="ff-guide__title">
                    {!! $data['heading'] !!}
                </h2>
            </div>
            <div class="ff-guide__header-intro">
                <p>{!! $data['intro'] !!}</p>
            </div>
        </div>

        {{-- Part A: Interactive 4-Pathway Explorer --}}
        <div class="ff-guide__pathways-grid">
            {{-- Left 5 Columns: Pathway Buttons --}}
            <div class="ff-guide__pathways-nav" role="tablist" aria-label="Family situation reflection pathways">
                @foreach ($pathways as $idx => $p)
                    <button
                        type="button"
                        role="tab"
                        id="pathway-tab-{{ $p['id'] }}"
                        aria-controls="pathway-panel-{{ $p['id'] }}"
                        aria-selected="{{ $idx === 0 ? 'true' : 'false' }}"
                        class="ff-guide__pathway-btn {{ $idx === 0 ? 'ff-guide__pathway-btn--active' : '' }}"
                        data-pathway-tab="{{ $p['id'] }}"
                    >
                        <div class="ff-guide__pathway-top">
                            <span class="ff-guide__pathway-idx">{{ $p['index'] }}</span>
                            <span aria-hidden="true">·</span>
                            <span class="ff-guide__pathway-tag">{{ $p['kicker'] }}</span>
                        </div>
                        <h3 class="ff-guide__pathway-title">{{ $p['title'] }}</h3>
                        <p class="ff-guide__pathway-quote">{{ $p['family_situation'] }}</p>
                        <span class="ff-guide__pathway-arrow" aria-hidden="true">→</span>
                    </button>
                @endforeach
            </div>

            {{-- Right 7 Columns: Active Pathway Guidance Card --}}
            <div class="ff-guide__pathways-panels">
                @foreach ($pathways as $idx => $p)
                    <div
                        role="tabpanel"
                        id="pathway-panel-{{ $p['id'] }}"
                        aria-labelledby="pathway-tab-{{ $p['id'] }}"
                        class="ff-guide__panel {{ $idx === 0 ? 'ff-guide__panel--active' : '' }}"
                        data-pathway-panel="{{ $p['id'] }}"
                        {{ $idx !== 0 ? 'hidden' : '' }}
                    >
                        <div class="ff-guide__panel-card">
                            <div class="ff-guide__panel-header">
                                <span class="ff-guide__panel-meta">
                                    {{ $p['index'] }} · Relevant Focus: {{ $p['primary_option'] }}
                                </span>
                                <a href="{{ $p['recommended_route_href'] }}" class="ff-guide__panel-route-link">
                                    <span>{{ $p['recommended_route_label'] }}</span>
                                    <svg class="ff-guide__link-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <line x1="7" y1="17" x2="17" y2="7"/>
                                        <polyline points="7 7 17 7 17 17"/>
                                    </svg>
                                </a>
                            </div>

                            <blockquote class="ff-guide__panel-quote">
                                {{ $p['family_situation'] }}
                            </blockquote>

                            <h3 class="ff-guide__panel-title">{{ $p['title'] }}</h3>

                            <p class="ff-guide__panel-body">{{ $p['how_to_think_about_it'] }}</p>

                            {{-- Practical Considerations Box --}}
                            <div class="ff-guide__considerations">
                                <span class="ff-guide__considerations-title">
                                    Practical Considerations for Your Family Conversation
                                </span>
                                <ul class="ff-guide__considerations-list">
                                    @foreach ($p['key_signs_of_fit'] as $sign)
                                        <li class="ff-guide__consideration-item">
                                            <svg class="ff-guide__check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                                <polyline points="20 6 9 17 4 12"/>
                                            </svg>
                                            <span>{{ $sign }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            {{-- How Both Programs Connect & Suggested Question --}}
                            <div class="ff-guide__panel-footer">
                                <p class="ff-guide__connect-text">
                                    <strong>How Our Programs Connect:</strong> {{ $p['how_both_programs_connect'] }}
                                </p>

                                <div class="ff-guide__panel-action-row">
                                    <div class="ff-guide__question-box">
                                        <span class="ff-guide__question-kicker">Suggested First Question for Our Team</span>
                                        <p class="ff-guide__question-quote">“{{ $p['suggested_first_question'] }}”</p>
                                    </div>

                                    <button
                                        type="button"
                                        class="ff-guide__panel-cta"
                                        data-inquiry="schedule_visit"
                                        data-inquiry-source="ff-guide"
                                        data-care="{{ $p['preset_care_option'] === 'Respite Care' ? 'respite_care' : 'memory_care' }}"
                                        data-note="Exploring {{ $p['primary_option'] }}: {{ $p['suggested_first_question'] }}"
                                    >
                                        <span>Discuss This Situation With Us →</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Part B: Side-by-Side Comparison Ledger --}}
        <div class="ff-guide__ledger">
            <div class="ff-guide__ledger-header">
                <div class="ff-guide__ledger-title-group">
                    <span class="ff-guide__ledger-kicker">Side-by-Side Program Reference · Mission Villa Senior Living</span>
                    <h3 class="ff-guide__ledger-title">Comparing Legacies™ Memory Care &amp; Short-Term Respite Care</h3>
                </div>
                <div class="ff-guide__ledger-links">
                    <a href="/memory-care" class="ff-guide__ledger-link">Memory Care Page →</a>
                    <a href="/respite-care" class="ff-guide__ledger-link">Respite Care Page →</a>
                </div>
            </div>

            {{-- Column Headers on Desktop --}}
            <div class="ff-guide__ledger-cols" aria-hidden="true">
                <div class="ff-guide__ledger-col-1">01 · Comparison Dimension</div>
                <div class="ff-guide__ledger-col-2">02 · Legacies™ Memory Care (Ongoing)</div>
                <div class="ff-guide__ledger-col-3">03 · Short-Term Respite Care &amp; Family Takeaway</div>
            </div>

            {{-- Comparison Rows --}}
            <div class="ff-guide__ledger-rows">
                @foreach ($dimensions as $idx => $dim)
                    <div class="ff-guide__ledger-row">
                        <div class="ff-guide__ledger-dim">
                            <span class="ff-guide__dim-num">Dimension 0{{ $idx + 1 }}</span>
                            <h4 class="ff-guide__dim-name">{{ $dim['dimension'] }}</h4>
                        </div>

                        <div class="ff-guide__ledger-mc">
                            <span class="ff-guide__mobile-label">Legacies™ Memory Care:</span>
                            <p class="ff-guide__ledger-text">{{ $dim['memory_care_approach'] }}</p>
                        </div>

                        <div class="ff-guide__ledger-rc">
                            <span class="ff-guide__mobile-label">Short-Term Respite Care:</span>
                            <p class="ff-guide__ledger-text">{{ $dim['respite_care_approach'] }}</p>
                            <p class="ff-guide__ledger-takeaway">
                                <strong>Family Note:</strong> {{ $dim['family_takeaway'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
