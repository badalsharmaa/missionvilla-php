@php
    /** @var array $data  Normalised by App\Content\Sections\RespiteCareTimelineSection */
    $steps = $data['steps'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/respite-care-timeline.css', 'resources/js/sections/respite-care-timeline.js'])
@endpush
{{--
    RESPITE CARE SECTION 06 · A SIMPLE STAY-PLANNING TIMELINE
    5-step interactive sequence explaining how families arrange and plan a stay.
--}}
<section class="rc-timeline" id="respite-planning" aria-labelledby="timeline-title" data-rc-timeline>
    <span class="mv-leaf rc-timeline__leaf" aria-hidden="true"></span>

    <div class="rc-timeline__inner">
        {{-- Section Head --}}
        <div class="rc-timeline__head">
            <p class="mv-eyebrow">
                <span class="mv-eyebrow__rule" aria-hidden="true"></span>
                <span>{{ $data['eyebrow'] }}</span>
            </p>
            <h2 id="timeline-title" class="mv-title rc-timeline__title">
                {!! $data['heading'] !!}
            </h2>
            <p class="rc-timeline__intro">
                {{ $data['intro'] }}
            </p>
        </div>

        {{-- 5-Step Sequence --}}
        <div class="rc-timeline__track" role="list" aria-label="Stay-planning sequence">
            @foreach ($steps as $i => $step)
                @php $active = $i === 0; @endphp
                <div
                    class="rc-timeline__step {{ $active ? 'is-active' : '' }}"
                    role="listitem"
                    data-rc-step="{{ $step['index'] }}"
                    tabindex="0"
                    aria-expanded="{{ $active ? 'true' : 'false' }}"
                >
                    {{-- Step Header / Node --}}
                    <div class="rc-timeline__node">
                        <span class="rc-timeline__badge">Step {{ $step['step'] }}</span>
                        <div class="rc-timeline__icon-wrap">
                            <span class="rc-timeline__icon" aria-hidden="true">
                                @include('partials.icon', ['name' => $step['icon'], 'class' => 'mv-icon', 'stroke' => 1.5])
                            </span>
                        </div>
                    </div>

                    {{-- Step Content --}}
                    <div class="rc-timeline__content">
                        <h3 class="rc-timeline__step-title">{{ $step['step'] }}. {{ $step['title'] }}</h3>
                        <p class="rc-timeline__summary">{{ $step['summary'] }}</p>
                        <p class="rc-timeline__detail">{{ $step['detail'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Verification note --}}
        <div class="rc-timeline__note">
            <svg class="rc-timeline__note-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
            <span>{{ $data['note'] }}</span>
        </div>
    </div>
</section>
