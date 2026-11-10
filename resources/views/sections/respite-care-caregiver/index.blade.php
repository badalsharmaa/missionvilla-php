@php
    /** @var array $data  Normalised by App\Content\Sections\RespiteCareCaregiverSection */
    $site = config('missionvilla');
    $leaf = asset('images/decor/botanical-leaf-shadow.svg');
@endphp
@push('section-assets')
    @vite(['resources/css/sections/respite-care-caregiver.css'])
@endpush
{{--
    RESPITE CARE SECTION 05 · CARING FOR THE CAREGIVER
    Deep-plum emotional centerpiece with wave edge, caregiver narrative, and 3 reassurance concepts.
--}}
<section class="rc-caregiver" id="respite-caregiver" aria-labelledby="caregiver-title" data-rc-caregiver>
    {{-- Wave transition from the cream section above --}}
    <svg class="rc-caregiver__wave" viewBox="0 0 1440 80" preserveAspectRatio="none" aria-hidden="true" focusable="false">
        <path class="rc-caregiver__wave-fill" d="M0 52 C 260 30, 560 22, 860 40 C 1110 55, 1290 30, 1440 6 L 1440 80 L 0 80 Z"/>
    </svg>

    <div class="rc-caregiver__inner">
        <span class="mv-leaf rc-caregiver__leaf" aria-hidden="true"></span>

        <div class="rc-caregiver__content">
            {{-- Left: Narrative & Actions --}}
            <div class="rc-caregiver__story">
                <p class="mv-eyebrow rc-caregiver__eyebrow">
                    <span class="mv-eyebrow__rule rc-caregiver__rule" aria-hidden="true"></span>
                    <span>{{ $data['eyebrow'] }}</span>
                </p>

                <h2 id="caregiver-title" class="mv-title rc-caregiver__title">
                    {!! $data['heading'] !!}
                    <em>{!! $data['subtitle'] !!}</em>
                </h2>

                <p class="rc-caregiver__narrative">
                    {{ $data['narrative'] }}
                </p>

                <div class="rc-caregiver__actions">
                    @foreach ($data['actions'] as $action)
                        @if ($action['style'] === 'primary')
                            <a
                                href="{{ $site['phone']['href'] }}"
                                class="mv-btn mv-btn--primary rc-caregiver__btn-primary"
                                data-inquiry="{{ $action['intent'] ?? 'request_availability' }}"
                                data-inquiry-care="{{ $action['care'] ?? 'respite_care' }}"
                                data-inquiry-source="rc-caregiver"
                            >
                                @include('partials.icon', ['name' => $action['icon'] ?? 'calendar', 'class' => 'mv-icon', 'stroke' => 1.6])
                                <span>{{ $action['label'] }}</span>
                                @include('partials.icon', ['name' => 'arrow', 'class' => 'mv-icon mv-btn__arrow', 'stroke' => 2])
                            </a>
                        @else
                            <a
                                href="{{ $action['href'] ?? '/memory-care' }}"
                                class="mv-btn mv-btn--ghost-light rc-caregiver__btn-ghost"
                            >
                                <span>{{ $action['label'] }}</span>
                                @include('partials.icon', ['name' => 'arrow', 'class' => 'mv-icon mv-btn__arrow', 'stroke' => 2])
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Right: 3 Reassurance Concept Cards --}}
            <div class="rc-caregiver__concepts" role="region" aria-label="Reassurance for Caregivers">
                @foreach ($data['concepts'] as $concept)
                    <div class="rc-caregiver__concept-card">
                        <span class="rc-caregiver__concept-icon" aria-hidden="true">
                            @include('partials.icon', ['name' => $concept['icon'], 'class' => 'mv-icon', 'stroke' => 1.5])
                        </span>
                        <div class="rc-caregiver__concept-body">
                            <h3 class="rc-caregiver__concept-title">{{ $concept['title'] }}</h3>
                            <p class="rc-caregiver__concept-desc">{{ $concept['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
