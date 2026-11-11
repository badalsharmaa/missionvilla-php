@php
    /** @var array $data Normalised by App\Content\Sections\LifeAtMissionVillaEngagementSection */
    $activities = $data['activities'];
    $action = $data['action'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/life-at-mission-villa-engagement.css'])
@endpush
{{--
    LIFE AT MISSION VILLA SECTION 04 · PROGRAMS & ACTIVITIES
--}}
<section class="lmv-engagement" id="engagement-activities" aria-labelledby="lmv-engagement-title" data-lmv-engagement>
    <div class="lmv-engagement__inner">
        <div class="lmv-engagement__head">
            <p class="mv-eyebrow lmv-engagement__eyebrow">
                <span class="mv-eyebrow__rule lmv-engagement__rule" aria-hidden="true"></span>
                <span>{{ $data['eyebrow'] }}</span>
            </p>
            <h2 id="lmv-engagement-title" class="mv-title lmv-engagement__title">
                {!! $data['heading'] !!}
            </h2>
            <p class="lmv-engagement__intro">
                {{ $data['intro'] }}
            </p>
        </div>

        <div class="lmv-engagement__grid">
            @foreach ($activities as $act)
                <div class="lmv-engagement__card">
                    <div class="lmv-engagement__header">
                        <div class="lmv-engagement__icon-box" aria-hidden="true">
                            @if ($act['icon'] === 'music')
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/>
                                </svg>
                            @elseif ($act['icon'] === 'palette')
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="13.5" cy="6.5" r=".5" fill="currentColor"/>
                                    <circle cx="17.5" cy="10.5" r=".5" fill="currentColor"/>
                                    <circle cx="8.5" cy="7.5" r=".5" fill="currentColor"/>
                                    <circle cx="6.5" cy="12.5" r=".5" fill="currentColor"/>
                                    <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/>
                                </svg>
                            @elseif ($act['icon'] === 'bus')
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M8 6v6"/><path d="M15 6v6"/><path d="M2 12h19.6"/><path d="M18 18h3s.5-1.7.8-2.8c.1-.4.2-.8.2-1.2 0-.6-.3-1.2-.8-1.5L19 11V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12h4"/><circle cx="7" cy="18" r="2"/><circle cx="15" cy="18" r="2"/>
                                </svg>
                            @else
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 2v8"/><path d="m4.93 10.93 1.41 1.41"/><path d="M2 18h2"/><path d="M20 18h2"/><path d="m19.07 10.93-1.41 1.41"/><path d="M22 22H2"/><path d="m16 6-4 4-4-4"/>
                                </svg>
                            @endif
                        </div>
                        <span class="lmv-engagement__kicker">{{ $act['kicker'] }}</span>
                    </div>

                    <div class="lmv-engagement__body">
                        <h3 class="lmv-engagement__card-title">{{ $act['title'] }}</h3>
                        <p class="lmv-engagement__card-desc">{{ $act['desc'] }}</p>

                        <ul class="lmv-engagement__bullets">
                            @foreach ($act['bullets'] as $bullet)
                                <li class="lmv-engagement__bullet-item">
                                    <svg class="lmv-engagement__check" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <polyline points="20 6 9 17 4 12"/>
                                    </svg>
                                    <span>{{ $bullet }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="lmv-engagement__foot">
            <button
                type="button"
                class="lmv-engagement__foot-btn"
                data-inquiry="{{ $action['intent'] }}"
                data-inquiry-source="lmv-engagement-foot"
                data-inquiry-care="exploring"
            >
                <span>{{ $action['label'] }}</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </button>
            <p class="lmv-engagement__foot-note">{{ $action['note'] }}</p>
        </div>
    </div>
</section>
