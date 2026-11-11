@php
    /** @var array $data Normalised by App\Content\Sections\LifeAtMissionVillaRhythmSection */
    $moments = $data['moments'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/life-at-mission-villa-rhythm.css'])
@endpush
{{--
    LIFE AT MISSION VILLA SECTION 03 · DAILY RHYTHM
--}}
<section class="lmv-rhythm" id="daily-rhythm" aria-labelledby="lmv-rhythm-title" data-lmv-rhythm>
    <div class="lmv-rhythm__inner">
        <div class="lmv-rhythm__head">
            <p class="mv-eyebrow lmv-rhythm__eyebrow">
                <span class="mv-eyebrow__rule lmv-rhythm__rule" aria-hidden="true"></span>
                <span>{{ $data['eyebrow'] }}</span>
            </p>
            <h2 id="lmv-rhythm-title" class="mv-title lmv-rhythm__title">
                {!! $data['heading'] !!}
            </h2>
            <p class="lmv-rhythm__intro">
                {{ $data['intro'] }}
            </p>
        </div>

        <div class="lmv-rhythm__timeline">
            @foreach ($moments as $moment)
                <div class="lmv-rhythm__step">
                    <div class="lmv-rhythm__time-col">
                        <span class="lmv-rhythm__time-badge">{{ $moment['time'] }}</span>
                    </div>

                    <div class="lmv-rhythm__card">
                        <div class="lmv-rhythm__card-header">
                            <div class="lmv-rhythm__icon" aria-hidden="true">
                                @if ($moment['icon'] === 'sun')
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="4"/>
                                        <path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/>
                                    </svg>
                                @elseif ($moment['icon'] === 'utensils')
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M18 2v6a3 3 0 0 1-3 3 3 3 0 0 1-3-3V2"/><path d="M15 2v19"/><path d="M6 2v7a3 3 0 0 0 6 0V2"/>
                                    </svg>
                                @elseif ($moment['icon'] === 'sparkles')
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/>
                                    </svg>
                                @else
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>
                                    </svg>
                                @endif
                            </div>
                            <h3 class="lmv-rhythm__card-title">{{ $moment['title'] }}</h3>
                        </div>

                        <p class="lmv-rhythm__card-lead">{{ $moment['lead'] }}</p>
                        <p class="lmv-rhythm__card-body">{{ $moment['body'] }}</p>

                        <div class="lmv-rhythm__touchpoint">
                            <span class="lmv-rhythm__touchpoint-label">Sensory Touchpoint:</span>
                            <span class="lmv-rhythm__touchpoint-text">{{ $moment['touchpoint'] }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="lmv-rhythm__disclaimer">
            <p>{{ $data['disclaimer'] }}</p>
        </div>
    </div>
</section>
