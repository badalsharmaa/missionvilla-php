@php
    /** @var array $data  Normalised by App\Content\Sections\RespiteCareInclusionsSection */
    $items = collect($data['items'])->keyBy('id');
    $leaf = asset('images/decor/botanical-leaf-shadow.svg');
@endphp
@push('section-assets')
    @vite(['resources/css/sections/respite-care-inclusions.css'])
@endpush
{{--
    RESPITE CARE SECTION 03 · COMFORT, CARE & EVERYDAY SUPPORT
    Editorial, asymmetrical composition of 6 stay inclusions with photography and cards.
--}}
<section class="rc-inclusions" id="respite-inclusions" aria-labelledby="inclusions-title" data-rc-inclusions>
    <span class="mv-leaf rc-inclusions__leaf" aria-hidden="true"></span>

    <div class="rc-inclusions__inner">
        {{-- Section Head --}}
        <div class="rc-inclusions__head">
            <p class="mv-eyebrow">
                <span class="mv-eyebrow__rule" aria-hidden="true"></span>
                <span>{{ $data['eyebrow'] }}</span>
            </p>
            <h2 id="inclusions-title" class="mv-title rc-inclusions__title">
                {!! $data['heading'] !!}
            </h2>
            <p class="rc-inclusions__intro">
                {{ $data['intro'] }}
            </p>
        </div>

        {{-- Asymmetrical Composition Grid --}}
        <div class="rc-inclusions__grid">
            {{-- Column 1: Chef-Prepared Meals (Tall photo lead card) --}}
            @if ($meals = $items->get('meals'))
                <article class="rc-inc-card rc-inc-card--meals" id="inc-{{ $meals['id'] }}">
                    <div class="rc-inc-card__media">
                        @if ($meals['image'])
                            <img
                                src="{{ asset(ltrim($meals['image']['src'], '/')) }}"
                                alt="{{ $meals['image']['alt'] }}"
                                width="{{ $meals['image']['width'] }}"
                                height="{{ $meals['image']['height'] }}"
                                class="rc-inc-card__img"
                                loading="lazy"
                                decoding="async"
                                data-provenance="{{ $meals['image']['provenance'] }}"
                                data-rights="{{ $meals['image']['rights'] }}"
                            >
                            <span class="rc-inc-card__provenance">{{ $meals['image']['label'] }}</span>
                        @endif
                    </div>
                    <div class="rc-inc-card__body rc-inc-card__body--plum">
                        <span class="rc-inc-card__icon rc-inc-card__icon--peach" aria-hidden="true">
                            @include('partials.icon', ['name' => $meals['icon'], 'class' => 'mv-icon', 'stroke' => 1.5])
                        </span>
                        <h3 class="rc-inc-card__title rc-inc-card__title--light">{{ $meals['title'] }}</h3>
                        <p class="rc-inc-card__desc rc-inc-card__desc--light">{{ $meals['description'] }}</p>
                    </div>
                </article>
            @endif

            {{-- Center Group: Accommodations + 3 Service Cards --}}
            <div class="rc-inclusions__center">
                {{-- Furnished Accommodations (Media card with photo and text) --}}
                @if ($acc = $items->get('accommodations'))
                    <article class="rc-inc-card rc-inc-card--acc" id="inc-{{ $acc['id'] }}">
                        <div class="rc-inc-card__acc-text">
                            <span class="rc-inc-card__icon rc-inc-card__icon--terracotta" aria-hidden="true">
                                @include('partials.icon', ['name' => $acc['icon'], 'class' => 'mv-icon', 'stroke' => 1.5])
                            </span>
                            <h3 class="rc-inc-card__title">{{ $acc['title'] }}</h3>
                            <p class="rc-inc-card__desc">{{ $acc['description'] }}</p>
                        </div>
                        @if ($acc['image'])
                            <div class="rc-inc-card__acc-media">
                                <img
                                    src="{{ asset(ltrim($acc['image']['src'], '/')) }}"
                                    alt="{{ $acc['image']['alt'] }}"
                                    width="{{ $acc['image']['width'] }}"
                                    height="{{ $acc['image']['height'] }}"
                                    class="rc-inc-card__acc-img"
                                    loading="lazy"
                                    decoding="async"
                                    data-provenance="{{ $acc['image']['provenance'] }}"
                                    data-rights="{{ $acc['image']['rights'] }}"
                                >
                                <span class="rc-inc-card__provenance">{{ $acc['image']['label'] }}</span>
                            </div>
                        @endif
                    </article>
                @endif

                {{-- Row of 3 concise service cards: Daily Assistance, Engaging Daily Life, Housekeeping --}}
                <div class="rc-inclusions__trio">
                    @foreach (['assistance', 'daily_life', 'hospitality'] as $serviceId)
                        @if ($service = $items->get($serviceId))
                            <article class="rc-inc-card rc-inc-card--cream" id="inc-{{ $service['id'] }}">
                                <span class="rc-inc-card__icon rc-inc-card__icon--terracotta" aria-hidden="true">
                                    @include('partials.icon', ['name' => $service['icon'], 'class' => 'mv-icon', 'stroke' => 1.5])
                                </span>
                                <h3 class="rc-inc-card__title">{{ $service['title'] }}</h3>
                                <p class="rc-inc-card__desc">{{ $service['description'] }}</p>
                            </article>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Column 3: Care Coordination & Assessment (Deep plum accent card) --}}
            @if ($coord = $items->get('coordination'))
                <article class="rc-inc-card rc-inc-card--coord" id="inc-{{ $coord['id'] }}">
                    <span class="rc-inc-card__icon rc-inc-card__icon--peach" aria-hidden="true">
                        @include('partials.icon', ['name' => $coord['icon'], 'class' => 'mv-icon', 'stroke' => 1.5])
                    </span>
                    <h3 class="rc-inc-card__title rc-inc-card__title--light">{{ $coord['title'] }}</h3>
                    <p class="rc-inc-card__desc rc-inc-card__desc--light">{{ $coord['description'] }}</p>
                </article>
            @endif
        </div>

        {{-- Verification note --}}
        <div class="rc-inclusions__note">
            <svg class="rc-inclusions__note-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
            <span>{{ $data['note'] }}</span>
        </div>
    </div>
</section>
