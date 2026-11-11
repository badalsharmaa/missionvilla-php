@php
    /** @var array $data Normalised by App\Content\Sections\GalleryPathwaysSection */
    $cards = $data['cards'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/gallery-pathways.css'])
@endpush
{{--
    GALLERY SECTION 04 · PATHWAYS ROUTING BRIDGE
--}}
<section class="gp-bridge" id="gallery-visit-bridge" aria-labelledby="gp-bridge-title" data-gp-bridge>
    <div class="gp-bridge__inner">
        {{-- Section Head --}}
        <div class="gp-bridge__head">
            <div class="gp-bridge__head-copy">
                <p class="mv-eyebrow gp-bridge__eyebrow">
                    <span class="mv-eyebrow__rule gp-bridge__rule" aria-hidden="true"></span>
                    <span>{{ $data['eyebrow'] }}</span>
                </p>
                <h2 id="gp-bridge-title" class="mv-title gp-bridge__title">
                    {!! $data['heading'] !!}
                </h2>
            </div>
            <p class="gp-bridge__intro">
                {{ $data['intro'] }}
            </p>
        </div>

        {{-- 3 Pathways Cards Grid --}}
        <div class="gp-bridge__grid">
            @foreach ($cards as $card)
                <article class="gp-card">
                    <div class="gp-card__top">
                        <div class="gp-card__meta">
                            <span class="gp-card__step">{{ $card['step'] }}</span>
                            <span class="gp-card__sep" aria-hidden="true">·</span>
                            <span class="gp-card__kicker">{{ $card['kicker'] }}</span>
                        </div>
                        <h3 class="gp-card__title">{{ $card['title'] }}</h3>
                        <p class="gp-card__summary">{{ $card['summary'] }}</p>
                    </div>

                    <div class="gp-card__bottom">
                        <a href="{{ $card['link_href'] }}" class="gp-card__btn">
                            <span>{{ $card['link_label'] }}</span>
                            <svg class="mv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
