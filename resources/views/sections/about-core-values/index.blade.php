@php
    /** @var array $data Normalised by App\Content\Sections\AboutCoreValuesSection */
    $values = $data['values'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/about-core-values.css'])
@endpush
{{--
    ABOUT SECTION 04 · CORE VALUES & ACTIVITIES
--}}
<section class="about-vals" aria-labelledby="about-vals-heading" id="values-and-activities" data-about-vals>
    <div class="about-vals__inner">
        {{-- Header --}}
        <div class="about-vals__header">
            <div class="about-vals__header-lead">
                <span class="about-vals__kicker font-script">{{ $data['eyebrow'] }}</span>
                <h2 id="about-vals-heading" class="about-vals__title">
                    {!! $data['heading'] !!}
                </h2>
            </div>
            <div class="about-vals__header-intro">
                <p>{{ $data['intro'] }}</p>
            </div>
        </div>

        {{-- 4-Pillar Editorial Grid --}}
        <div class="about-vals__grid">
            @foreach ($values as $val)
                <div class="about-vals__card" data-val-id="{{ $val['id'] }}">
                    <div class="about-vals__card-top">
                        <div class="about-vals__card-meta">
                            <span class="about-vals__card-index">Core Value {{ $val['index'] }}</span>
                            <span class="about-vals__card-script font-script">{{ $val['script_accent'] }}</span>
                        </div>
                        <h3 class="about-vals__card-title">{{ $val['title'] }}</h3>
                        <p class="about-vals__card-summary">{{ $val['summary'] }}</p>
                    </div>

                    <div class="about-vals__card-bottom">
                        <span class="about-vals__activities-kicker">
                            Connected Community Activities &amp; Experiences:
                        </span>
                        <ul class="about-vals__activities-list">
                            @foreach ($val['connected_activities'] as $act)
                                <li class="about-vals__activity-item">
                                    <svg class="about-vals__check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                        <polyline points="20 6 9 17 4 12"/>
                                    </svg>
                                    <span>{{ $act }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <div class="about-vals__card-action">
                            <a href="{{ $val['related_route']['href'] }}" class="about-vals__card-link">
                                <span>{{ $val['related_route']['label'] }}</span>
                                <svg class="about-vals__link-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <line x1="7" y1="17" x2="17" y2="7"/>
                                    <polyline points="7 7 17 7 17 17"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
