@php
    /** @var array $data Normalised by App\Content\Sections\ForFamiliesInvolvementSection */
    $chapters = $data['chapters'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/for-families-involvement.css', 'resources/js/sections/for-families-involvement.js'])
@endpush
{{--
    FOR FAMILIES SECTION 04 · FAMILY INVOLVEMENT & PERSONALIZATION
--}}
<section class="ff-inv" aria-labelledby="ff-inv-heading" id="family-involvement-and-personalization" data-ff-inv>
    <div class="ff-inv__inner">
        {{-- Header & Chapter Tabs --}}
        <div class="ff-inv__header">
            <div class="ff-inv__header-copy">
                <span class="ff-inv__kicker font-script">{{ $data['eyebrow'] }}</span>
                <h2 id="ff-inv-heading" class="ff-inv__title">
                    {!! $data['heading'] !!}
                </h2>
                <div class="ff-inv__intro">
                    {!! $data['intro'] !!}
                </div>
            </div>

            {{-- 4-Chapter Tabs --}}
            <div role="tablist" aria-label="Family involvement chapters" class="ff-inv__tabs">
                @foreach ($chapters as $idx => $chap)
                    <button
                        type="button"
                        role="tab"
                        id="inv-tab-{{ $chap['id'] }}"
                        aria-controls="inv-panel-{{ $chap['id'] }}"
                        aria-selected="{{ $idx === 0 ? 'true' : 'false' }}"
                        class="ff-inv__tab {{ $idx === 0 ? 'ff-inv__tab--active' : '' }}"
                        data-inv-tab="{{ $chap['id'] }}"
                    >
                        <span>{{ $chap['step_number'] }} · {{ $chap['kicker'] }}</span>
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Panels --}}
        <div class="ff-inv__panels">
            @foreach ($chapters as $idx => $chap)
                <div
                    role="tabpanel"
                    id="inv-panel-{{ $chap['id'] }}"
                    aria-labelledby="inv-tab-{{ $chap['id'] }}"
                    class="ff-inv__panel {{ $idx === 0 ? 'ff-inv__panel--active' : '' }}"
                    data-inv-panel="{{ $chap['id'] }}"
                    {{ $idx !== 0 ? 'hidden' : '' }}
                >
                    <div class="ff-inv__showcase">
                        {{-- Left 7 Columns: Image with Inverted Cutout --}}
                        <div class="ff-inv__media">
                            <img
                                src="{{ $chap['image']['src'] }}"
                                width="{{ $chap['image']['width'] }}"
                                height="{{ $chap['image']['height'] }}"
                                alt="{{ $chap['image']['alt'] }}"
                                loading="lazy"
                                class="ff-inv__media-img"
                            >
                            <div class="ff-inv__media-scrim" aria-hidden="true"></div>

                            <div class="ff-inv__media-top">
                                <div class="ff-inv__media-cutout">
                                    <span>{{ $chap['step_number'] }} · {{ $chap['kicker'] }}</span>
                                </div>

                                @if (!empty($chap['image']['provenance']))
                                    <div class="ff-inv__prov-pill">
                                        <span class="ff-inv__prov-dot ff-inv__prov-dot--{{ $chap['image']['provenance'] === 'facility' ? 'facility' : 'illustrative' }}" aria-hidden="true"></span>
                                        <span>{{ $chap['image']['provenance'] === 'facility' ? 'Mission Villa facility photograph · Daly City, CA' : 'Illustrative photograph' }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="ff-inv__media-caption-box">
                                <span class="ff-inv__media-status">{{ $chap['image']['status'] }}</span>
                                <h3 class="ff-inv__media-title">{{ $chap['title'] }}</h3>
                                <p class="ff-inv__media-caption">{{ $chap['image']['caption'] }}</p>
                            </div>
                        </div>

                        {{-- Right 5 Columns: Narrative Card --}}
                        <div class="ff-inv__narrative herbarium-mount">
                            <div class="ff-inv__narrative-top">
                                <div class="ff-inv__narrative-meta">
                                    <span class="ff-inv__narrative-sub">{{ $chap['subtitle'] }}</span>
                                    <h4 class="ff-inv__narrative-heading">{{ $chap['title'] }}</h4>
                                </div>

                                <p class="ff-inv__narrative-body">{{ $chap['narrative'] }}</p>

                                <div class="ff-inv__ways">
                                    <span class="ff-inv__ways-title">Ways Your Family Participates</span>
                                    <ul class="ff-inv__ways-list">
                                        @foreach ($chap['practical_ways'] as $way)
                                            <li class="ff-inv__way-item">
                                                <svg class="ff-inv__check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                                    <polyline points="20 6 9 17 4 12"/>
                                                </svg>
                                                <span>{{ $way }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="ff-inv__narrative-footer">
                                <p class="ff-inv__reassurance">
                                    “{{ $chap['reassurance_note'] }}”
                                </p>

                                <div class="ff-inv__actions">
                                    <a href="/suites-and-floor-plans" class="ff-inv__btn ff-inv__btn--primary">
                                        <span>Suites &amp; Personalization →</span>
                                    </a>
                                    <a href="/life-at-mission-villa" class="ff-inv__btn ff-inv__btn--secondary">
                                        <span>Life at Mission Villa</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
