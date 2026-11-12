@php
    /** @var array $data Normalised by App\Content\Sections\AboutPhilosophySection */
    $chapters = $data['chapters'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/about-philosophy.css', 'resources/js/sections/about-philosophy.js'])
@endpush
{{--
    ABOUT SECTION 02 · CARE PHILOSOPHY NARRATIVE
--}}
<section class="about-phil" aria-labelledby="about-phil-heading" id="care-philosophy-narrative" data-about-phil>
    <div class="about-phil__inner">
        {{-- Section Header --}}
        <div class="about-phil__header">
            <div class="about-phil__header-lead">
                <span class="about-phil__kicker font-script">{{ $data['eyebrow'] }}</span>
                <h2 id="about-phil-heading" class="about-phil__title">
                    {!! $data['heading'] !!}
                </h2>
            </div>
            <div class="about-phil__header-intro">
                <p>{{ $data['intro'] }}</p>
            </div>
        </div>

        {{-- 4-Chapter Tablist --}}
        <div role="tablist" aria-label="Care Philosophy Chapters" class="about-phil__tabs">
            @foreach ($chapters as $idx => $chapter)
                <button
                    type="button"
                    role="tab"
                    id="phil-tab-{{ $chapter['id'] }}"
                    aria-controls="phil-panel-{{ $chapter['id'] }}"
                    aria-selected="{{ $idx === 0 ? 'true' : 'false' }}"
                    tabindex="{{ $idx === 0 ? '0' : '-1' }}"
                    class="about-phil__tab {{ $idx === 0 ? 'about-phil__tab--active' : '' }}"
                    data-phil-tab="{{ $chapter['id'] }}"
                >
                    <div class="about-phil__tab-header">
                        <span class="about-phil__tab-num">{{ $chapter['chapter_number'] }}</span>
                        <span class="about-phil__tab-tag">{{ $chapter['kicker'] }}</span>
                    </div>
                    <span class="about-phil__tab-title">{{ $chapter['title'] }}</span>
                </button>
            @endforeach
        </div>

        {{-- Chapter Tabpanels --}}
        <div class="about-phil__panels">
            @foreach ($chapters as $idx => $chapter)
                <div
                    role="tabpanel"
                    id="phil-panel-{{ $chapter['id'] }}"
                    aria-labelledby="phil-tab-{{ $chapter['id'] }}"
                    class="about-phil__panel {{ $idx === 0 ? 'about-phil__panel--active' : '' }}"
                    data-phil-panel="{{ $chapter['id'] }}"
                    {{ $idx !== 0 ? 'hidden' : '' }}
                >
                    <div class="about-phil__card">
                        {{-- Left 7 Columns: Narrative --}}
                        <div class="about-phil__narrative">
                            <div class="about-phil__chapter-top">
                                <span class="about-phil__chapter-meta">
                                    {{ $chapter['chapter_number'] }} · {{ $chapter['kicker'] }}
                                </span>
                                <h3 class="about-phil__chapter-title">
                                    {{ $chapter['title'] }}
                                </h3>
                                <p class="about-phil__chapter-lead">
                                    {{ $chapter['editorial_lead'] }}
                                </p>
                                <p class="about-phil__chapter-body">
                                    {{ $chapter['narrative_body'] }}
                                </p>
                            </div>

                            {{-- In Everyday Life checklist --}}
                            <div class="about-phil__daily">
                                <h4 class="about-phil__daily-title">
                                    How Families See This in Daily Life at Mission Villa:
                                </h4>
                                <ul class="about-phil__daily-list">
                                    @foreach ($chapter['in_everyday_life'] as $point)
                                        <li class="about-phil__daily-item">
                                            <svg class="about-phil__check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                                <polyline points="20 6 9 17 4 12"/>
                                            </svg>
                                            <span>{{ $point }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            {{-- Family Promise & Action Buttons --}}
                            <div class="about-phil__promise-row">
                                <div class="about-phil__promise">
                                    <span class="about-phil__promise-kicker">Our Commitment to Your Family</span>
                                    <p class="about-phil__promise-quote">“{{ $chapter['family_promise'] }}”</p>
                                </div>

                                <div class="about-phil__actions">
                                    <button
                                        type="button"
                                        class="about-phil__btn about-phil__btn--primary"
                                        data-inquiry="schedule_visit"
                                        data-inquiry-source="about-philosophy"
                                        data-care="memory_care"
                                        data-note="{{ $chapter['inquiry_note'] }}"
                                    >
                                        <svg class="about-phil__btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                            <line x1="16" y1="2" x2="16" y2="6"/>
                                            <line x1="8" y1="2" x2="8" y2="6"/>
                                            <line x1="3" y1="10" x2="21" y2="10"/>
                                        </svg>
                                        <span>Ask on Your Tour</span>
                                    </button>

                                    <a
                                        href="{{ $chapter['related_route']['href'] }}"
                                        class="about-phil__btn about-phil__btn--secondary"
                                    >
                                        <span>{{ $chapter['related_route']['label'] }}</span>
                                        <svg class="about-phil__btn-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <line x1="7" y1="17" x2="17" y2="7"/>
                                            <polyline points="7 7 17 7 17 17"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Right 5 Columns: Visual Plate --}}
                        <div class="about-phil__visual">
                            <div class="about-phil__visual-box">
                                <img
                                    src="{{ $chapter['image']['src'] }}"
                                    width="{{ $chapter['image']['width'] }}"
                                    height="{{ $chapter['image']['height'] }}"
                                    alt="{{ $chapter['image']['alt'] }}"
                                    loading="lazy"
                                    class="about-phil__visual-img"
                                >
                                <div class="about-phil__visual-scrim" aria-hidden="true"></div>

                                <div class="about-phil__visual-top">
                                    <span class="about-phil__visual-badge">
                                        {{ $chapter['chapter_number'] }} · {{ $chapter['kicker'] }}
                                    </span>
                                    <div class="about-phil__prov-pill">
                                        <span class="about-phil__prov-dot about-phil__prov-dot--{{ $chapter['image']['provenance'] === 'facility' ? 'facility' : 'illustrative' }}" aria-hidden="true"></span>
                                        <span>{{ $chapter['image']['provenance'] === 'facility' ? 'Facility photo' : 'Illustrative' }}</span>
                                    </div>
                                </div>

                                <div class="about-phil__visual-bottom">
                                    <p class="about-phil__visual-caption">{{ $chapter['image']['caption'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
