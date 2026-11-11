@php
    /** @var array $data Normalised by App\Content\Sections\ForFamiliesBridgeSection */
    $site = config('missionvilla');
    $cards = $data['cards'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/for-families-bridge.css'])
@endpush
{{--
    FOR FAMILIES SECTION 06 · CONTEXTUAL PLANNING BRIDGE
--}}
<section class="ff-bridge fluid-canvas" aria-labelledby="ff-bridge-heading" id="contextual-planning-bridge">
    <h2 id="ff-bridge-heading" class="sr-only">Next Steps for Families</h2>

    <div class="ff-bridge__inner">
        <div class="ff-bridge__grid">
            @foreach ($cards as $card)
                @php
                    $isDark = $card['id'] === 'bridge-direct-conversation';
                @endphp
                <div class="ff-bridge__card {{ $isDark ? 'ff-bridge__card--dark' : 'ff-bridge__card--light' }} herbarium-mount">
                    <div class="ff-bridge__card-content">
                        <div class="ff-bridge__meta">
                            <span class="ff-bridge__kicker {{ $isDark ? 'ff-bridge__kicker--gold' : ($card['icon'] === 'care' ? 'ff-bridge__kicker--sage' : 'ff-bridge__kicker--terracotta') }}">
                                {{ $card['kicker'] }}
                            </span>
                            @if ($card['icon'] === 'worksheet')
                                <svg class="ff-bridge__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                    <line x1="8" y1="13" x2="16" y2="13"/>
                                    <line x1="8" y1="17" x2="16" y2="17"/>
                                    <polyline points="10 9 9 9 8 9"/>
                                </svg>
                            @elseif ($card['icon'] === 'care')
                                <svg class="ff-bridge__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
                                </svg>
                            @else
                                <svg class="ff-bridge__icon ff-bridge__icon--phone" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                </svg>
                            @endif
                        </div>

                        <h3 class="ff-bridge__card-title {{ $isDark ? 'ff-bridge__card-title--dark' : '' }}">
                            {{ $card['title'] }}
                        </h3>

                        <p class="ff-bridge__card-desc {{ $isDark ? 'ff-bridge__card-desc--dark' : '' }}">
                            {{ $card['description'] }}
                        </p>
                    </div>

                    <div class="ff-bridge__actions">
                        @if ($isDark)
                            <button
                                type="button"
                                class="ff-bridge__btn ff-bridge__btn--gold"
                                data-inquiry="schedule_visit"
                                data-inquiry-source="ff-bridge"
                                data-care="memory_care"
                                data-note="Interested in unhurried walkthrough of Mission Villa suites and community"
                            >
                                <span>Schedule a Visit or Request Call</span>
                                <span aria-hidden="true">↓</span>
                            </button>
                        @elseif (count($card['links']) === 1)
                            @php $link = $card['links'][0]; @endphp
                            <a
                                href="{{ $link['href'] }}"
                                class="ff-bridge__btn ff-bridge__btn--primary"
                            >
                                <span>{{ $link['label'] }}</span>
                                <svg class="ff-bridge__arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                    <line x1="7" y1="17" x2="17" y2="7"/>
                                    <polyline points="7 7 17 7 17 17"/>
                                </svg>
                            </a>
                        @else
                            <div class="ff-bridge__btn-group">
                                @foreach ($card['links'] as $link)
                                    <a
                                        href="{{ $link['href'] }}"
                                        class="ff-bridge__btn {{ $link['style'] === 'primary' ? 'ff-bridge__btn--primary' : 'ff-bridge__btn--secondary' }}"
                                    >
                                        <span>{{ $link['label'] }}</span>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
