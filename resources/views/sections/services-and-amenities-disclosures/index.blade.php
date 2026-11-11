@php
    /** @var array $data Normalised by App\Content\Sections\ServicesAmenitiesDisclosuresSection */
    $site = config('missionvilla');
    $disclosures = $data['disclosures'];
    $actionCard = $data['action_card'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/services-and-amenities-disclosures.css'])
@endpush
{{--
    SERVICES & AMENITIES SECTION 04 · TRANSPARENT GUIDANCE DISCLOSURES
--}}
<section class="sa-disclosures" id="ask-us-about" aria-labelledby="sa-disclosures-title" data-sa-disclosures>
    <div class="sa-disclosures__inner">
        {{-- Section Head --}}
        <div class="sa-disclosures__head">
            <p class="mv-eyebrow sa-disclosures__eyebrow">
                <span class="mv-eyebrow__rule sa-disclosures__rule" aria-hidden="true"></span>
                <span>{{ $data['eyebrow'] }}</span>
            </p>
            <h2 id="sa-disclosures-title" class="mv-title sa-disclosures__title">
                {!! $data['heading'] !!}
            </h2>
            <p class="sa-disclosures__intro">
                {{ $data['intro'] }}
            </p>
        </div>

        {{-- 12-Column Grid: 8 Columns Disclosures Grid + 4 Columns Tour Prep Card --}}
        <div class="sa-disclosures__grid">
            {{-- Left 8 Columns: 4 Disclosure Cards --}}
            <div class="sa-disclosures__cards">
                @foreach ($disclosures as $disc)
                    <article class="sa-disc-card" id="{{ $disc['id'] }}">
                        <div class="sa-disc-card__header">
                            <span class="sa-disc-card__idx">TOPIC {{ $disc['index'] }}</span>
                            <h3 class="sa-disc-card__title">{{ $disc['title'] }}</h3>
                        </div>
                        <p class="sa-disc-card__summary">
                            {{ $disc['summary'] }}
                        </p>

                        <div class="sa-disc-card__points">
                            <span class="sa-disc-card__points-kicker">KEY QUESTIONS &amp; CLINICAL TERMS:</span>
                            <ul class="sa-disc-card__list">
                                @foreach ($disc['key_points'] as $pt)
                                    <li class="sa-disc-card__list-item">
                                        <svg class="mv-icon sa-disc-card__check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                                        <span>{{ $pt }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="sa-disc-card__flag">
                            <svg class="mv-icon sa-disc-card__flag-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                            <span>{{ $disc['confirmation_flag'] }}</span>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Right 4 Columns: Interactive Tour Preparation Card --}}
            <aside class="sa-disclosures__action-box">
                <div class="sa-disclosures__action-inner">
                    <div class="sa-disclosures__action-badge">
                        <svg class="mv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>
                        <span>VISIT PREPARATION</span>
                    </div>

                    <h3 class="sa-disclosures__action-title">{{ $actionCard['title'] }}</h3>
                    <p class="sa-disclosures__action-text">{{ $actionCard['text'] }}</p>

                    <div class="sa-disclosures__action-btns">
                        <a
                            href="{{ $site['phone']['href'] }}"
                            class="sa-disclosures__btn sa-disclosures__btn--primary"
                            data-inquiry="{{ $actionCard['cta_intent'] }}"
                            data-care="exploring"
                        >
                            <span>{{ $actionCard['cta_label'] }}</span>
                            <svg class="mv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>

                        <a
                            href="{{ $site['phone']['href'] }}"
                            class="sa-disclosures__btn sa-disclosures__btn--call"
                        >
                            <svg class="mv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            <span>{{ $actionCard['phone_label'] }}</span>
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>
