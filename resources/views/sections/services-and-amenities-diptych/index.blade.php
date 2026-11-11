@php
    /** @var array $data Normalised by App\Content\Sections\ServicesAmenitiesDiptychSection */
    $feature = $data['feature'];
    $img = $feature['image'];
    $notes = $data['field_notes'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/services-and-amenities-diptych.css'])
@endpush
{{--
    SERVICES & AMENITIES SECTION 03 · PANORAMIC DIPTYCH FEATURE
--}}
<section class="sa-diptych" id="photographic-feature" aria-labelledby="sa-diptych-title" data-sa-diptych>
    <div class="sa-diptych__inner">
        {{-- Section Head --}}
        <div class="sa-diptych__head">
            <div class="sa-diptych__head-copy">
                <p class="mv-eyebrow sa-diptych__eyebrow">
                    <span class="mv-eyebrow__rule sa-diptych__rule" aria-hidden="true"></span>
                    <span>{{ $data['eyebrow'] }}</span>
                </p>
                <h2 id="sa-diptych-title" class="mv-title sa-diptych__title">
                    {!! $data['heading'] !!}
                </h2>
            </div>
            <p class="sa-diptych__intro">
                {{ $data['intro'] }}
            </p>
        </div>

        {{-- 12-Column Asymmetric Layout --}}
        <div class="sa-diptych__grid">
            {{-- Left 8 Columns: Panoramic Feature Plate --}}
            <div class="sa-diptych__plate">
                <div class="sa-diptych__frame">
                    <img
                        src="{{ asset(ltrim($img['src'], '/')) }}"
                        alt="{{ $img['alt'] }}"
                        width="{{ $img['width'] }}"
                        height="{{ $img['height'] }}"
                        class="sa-diptych__img"
                        loading="lazy"
                        decoding="async"
                    >
                    <div class="sa-diptych__overlay" aria-hidden="true"></div>

                    {{-- Top Left Cutout Badge --}}
                    <div class="sa-diptych__badge">
                        <span>{{ $feature['cutout_label'] }}</span>
                    </div>

                    {{-- Bottom Caption Overlay --}}
                    <div class="sa-diptych__caption">
                        <h3 class="sa-diptych__plate-title">{{ $feature['title'] }}</h3>
                        <p class="sa-diptych__plate-subtitle">{{ $feature['subtitle'] }}</p>
                        <blockquote class="sa-diptych__quote">
                            “{{ $feature['quote'] }}”
                        </blockquote>
                    </div>
                </div>

                <div class="sa-diptych__plate-footer">
                    <span>{{ $img['label'] }}</span>
                    <span class="sa-diptych__provenance">Mission Villa facility photography · Daly City, CA</span>
                </div>
            </div>

            {{-- Right 4 Columns: Archival Field Notes --}}
            <div class="sa-diptych__sidebar">
                <div class="sa-diptych__sidebar-header">
                    <span class="sa-diptych__sidebar-kicker">HOSPITALITY PROTOCOLS</span>
                    <h3 class="sa-diptych__sidebar-title">Everyday Flow in Motion</h3>
                </div>

                <div class="sa-diptych__notes">
                    @foreach ($notes as $note)
                        <div class="sa-diptych__note">
                            <div class="sa-diptych__note-icon-wrap" aria-hidden="true">
                                @if ($note['icon'] === 'utensils')
                                    <svg class="mv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2v6a3 3 0 0 1-3 3 3 3 0 0 1-3-3V2"/><path d="M15 2v10"/><path d="M12 2v8"/><path d="M18 22v-9"/><path d="M6 2v12a2 2 0 0 0 2 2h0a2 2 0 0 0 2-2V2"/><path d="M8 22v-6"/></svg>
                                @elseif ($note['icon'] === 'trees')
                                    <svg class="mv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 10v.2A3 3 0 0 1 8.9 16H5a3 3 0 0 1-1-5.8V10a3 3 0 0 1 6 0Z"/><path d="M7 16v6"/><path d="M13 19v3"/><path d="M12 19h8.3a1 1 0 0 0 .7-1.7L18 14h.3a1 1 0 0 0 .7-1.7L16 9h.2a1 1 0 0 0 .8-1.7L13 3l-1.4 1.4"/></svg>
                                @else
                                    <svg class="mv-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/></svg>
                                @endif
                            </div>
                            <div class="sa-diptych__note-body">
                                <h4 class="sa-diptych__note-title">{{ $note['title'] }}</h4>
                                <p class="sa-diptych__note-desc">{{ $note['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
