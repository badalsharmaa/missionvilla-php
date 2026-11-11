@php
    /** @var array $data Normalised by App\Content\Sections\ForFamiliesChecklistSection */
    $themes = $data['themes'];
    $questions = $data['questions'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/for-families-checklist.css', 'resources/js/sections/for-families-checklist.js'])
@endpush
{{--
    FOR FAMILIES SECTION 03 · TOUR NOTEBOOK CHECKLIST
--}}
<section class="ff-check" aria-labelledby="ff-check-heading" id="questions-for-your-visit" data-ff-check>
    <div class="ff-check__inner">
        {{-- Header & Selected Actions --}}
        <div class="ff-check__header">
            <div class="ff-check__header-copy">
                <span class="ff-check__kicker font-script">{{ $data['eyebrow'] }}</span>
                <h2 id="ff-check-heading" class="ff-check__title">
                    {!! $data['heading'] !!}
                </h2>
                <div class="ff-check__intro">
                    {!! $data['intro'] !!}
                </div>
            </div>

            <div class="ff-check__counter-dock">
                <span class="ff-check__counter-label">
                    <span data-selected-count>3</span> of {{ count($questions) }} questions selected
                </span>
                <button
                    type="button"
                    class="ff-check__submit-btn"
                    data-inquiry="schedule_visit"
                    data-inquiry-source="ff-checklist"
                    data-care="memory_care"
                    data-check-submit
                >
                    <svg class="ff-check__btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
                        <rect x="8" y="2" width="8" height="4" rx="1" ry="1"/>
                        <path d="m9 14 2 2 4-4"/>
                    </svg>
                    <span>Bring Selected to Visit Form (<span data-selected-count-btn>3</span>)</span>
                </button>
            </div>
        </div>

        {{-- Theme Filters & Quick Controls --}}
        <div class="ff-check__toolbar">
            <div role="group" aria-label="Filter tour questions by theme" class="ff-check__filters">
                @foreach ($themes as $idx => $t)
                    <button
                        type="button"
                        class="ff-check__theme-btn {{ $idx === 0 ? 'ff-check__theme-btn--active' : '' }}"
                        data-check-filter="{{ $t }}"
                    >
                        <span>{{ $t }}</span>
                    </button>
                @endforeach
            </div>

            <div class="ff-check__quick-actions">
                <button type="button" class="ff-check__quick-btn" data-check-select-all>
                    Select All {{ count($questions) }}
                </button>
                <button type="button" class="ff-check__quick-btn" data-check-clear>
                    <svg class="ff-check__clear-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <polyline points="1 4 1 10 7 10"/>
                        <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/>
                    </svg>
                    <span>Clear</span>
                </button>
            </div>
        </div>

        {{-- 2-Column Question Cards Grid --}}
        <div class="ff-check__grid">
            @foreach ($questions as $idx => $q)
                @php
                    $isDefaultSelected = in_array($idx, [0, 2, 6]);
                @endphp
                <div
                    class="ff-check__card {{ $isDefaultSelected ? 'ff-check__card--selected' : '' }}"
                    data-q-card="{{ $q['id'] }}"
                    data-q-theme="{{ $q['theme'] }}"
                >
                    <div class="ff-check__card-top">
                        <div class="ff-check__card-meta">
                            <span class="ff-check__card-code">{{ $q['code'] }}</span>
                            <span aria-hidden="true">·</span>
                            <span class="ff-check__card-theme">{{ $q['theme'] }}</span>
                        </div>

                        <button
                            type="button"
                            class="ff-check__toggle-btn"
                            data-q-toggle="{{ $q['id'] }}"
                            aria-pressed="{{ $isDefaultSelected ? 'true' : 'false' }}"
                            aria-label="Include question {{ $q['code'] }} in your visit checklist"
                        >
                            <svg class="ff-check__box-icon ff-check__box-icon--checked" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <polyline points="9 11 12 14 22 4"/>
                                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                            </svg>
                            <svg class="ff-check__box-icon ff-check__box-icon--empty" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                            </svg>
                            <span class="ff-check__toggle-label">{{ $isDefaultSelected ? 'In Your Tour List' : 'Add to Tour List' }}</span>
                        </button>
                    </div>

                    <h3 class="ff-check__card-question">
                        “{{ $q['question'] }}”
                    </h3>

                    <p class="ff-check__card-why">
                        <strong>Why It Matters:</strong> {{ $q['why_it_matters'] }}
                    </p>

                    <div class="ff-check__card-listen">
                        <strong>What to Listen For on Tour:</strong> {{ $q['what_to_listen_for'] }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
