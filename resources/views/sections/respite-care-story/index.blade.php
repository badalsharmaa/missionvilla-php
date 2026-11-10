@php
    /** @var array $data  Normalised by App\Content\Sections\RespiteCareStorySection */
    $moments = $data['moments'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/respite-care-story.css'])
@endpush
{{--
    RESPITE CARE SECTION 04 · A WELCOMING STAY, FROM START TO FINISH
    Three visual editorial cards telling the story of a respite stay experience.
--}}
<section class="rc-story" id="respite-story" aria-labelledby="story-title" data-rc-story>
    <div class="rc-story__inner">
        {{-- Section Head --}}
        <div class="rc-story__head">
            <p class="mv-eyebrow">
                <span class="mv-eyebrow__rule" aria-hidden="true"></span>
                <span>{{ $data['eyebrow'] }}</span>
            </p>
            <h2 id="story-title" class="mv-title rc-story__title">
                {!! $data['heading'] !!}
            </h2>
            <p class="rc-story__intro">
                {{ $data['intro'] }}
            </p>
        </div>

        {{-- 3-Moment Cards Grid --}}
        <div class="rc-story__grid">
            @foreach ($moments as $moment)
                <article class="rc-story__card" id="moment-{{ $moment['id'] }}">
                    {{-- Moment Media --}}
                    <div class="rc-story__media">
                        <picture>
                            @if ($moment['image']['src_mobile'])
                                <source media="(max-width: 639px)" srcset="{{ asset(ltrim($moment['image']['src_mobile'], '/')) }}">
                            @endif
                            <img
                                src="{{ asset(ltrim($moment['image']['src'], '/')) }}"
                                alt="{{ $moment['image']['alt'] }}"
                                width="{{ $moment['image']['width'] }}"
                                height="{{ $moment['image']['height'] }}"
                                class="rc-story__img"
                                loading="lazy"
                                decoding="async"
                                data-provenance="{{ $moment['image']['provenance'] }}"
                                data-rights="{{ $moment['image']['rights'] }}"
                            >
                        </picture>
                        <span class="rc-story__provenance">{{ $moment['image']['label'] }}</span>
                    </div>

                    {{-- Moment Body --}}
                    <div class="rc-story__body">
                        <div class="rc-story__header">
                            <span class="rc-story__icon" aria-hidden="true">
                                @include('partials.icon', ['name' => $moment['icon'], 'class' => 'mv-icon', 'stroke' => 1.5])
                            </span>
                            <h3 class="rc-story__card-title">{{ $moment['title'] }}</h3>
                        </div>
                        <p class="rc-story__card-desc">{{ $moment['description'] }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
