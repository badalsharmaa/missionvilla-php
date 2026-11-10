@php
    /** @var array $data  Normalised by App\Content\Sections\RespiteCareFaqSection */
    $site = config('missionvilla');
    $guide = $data['guide'];
    $faqs = $data['faqs'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/respite-care-faq.css', 'resources/js/sections/respite-care-faq.js'])
@endpush
{{--
    RESPITE CARE SECTION 07 · QUESTIONS FAMILIES OFTEN ASK
    2-column composition with Planning Guide card on the left and accordion card on the right.
--}}
<section class="rc-faq" id="respite-faq" aria-labelledby="faq-title" data-rc-faq>
    <span class="mv-leaf rc-faq__leaf" aria-hidden="true"></span>

    <div class="rc-faq__inner">
        {{-- Section Head --}}
        <div class="rc-faq__head">
            <p class="mv-eyebrow">
                <span class="mv-eyebrow__rule" aria-hidden="true"></span>
                <span>{{ $data['eyebrow'] }}</span>
            </p>
            <h2 id="faq-title" class="mv-title rc-faq__title">
                {!! $data['heading'] !!}
            </h2>
            <p class="rc-faq__intro">
                {{ $data['intro'] }}
            </p>
        </div>

        {{-- 2-Column Content Grid --}}
        <div class="rc-faq__grid">
            {{-- Left: Planning Guide Informational Card --}}
            <aside class="rc-faq__guide" aria-label="Planning Guide">
                <div class="rc-faq__guide-header">
                    <span class="rc-faq__guide-icon" aria-hidden="true">
                        @include('partials.icon', ['name' => 'calendar', 'class' => 'mv-icon', 'stroke' => 1.5])
                    </span>
                    <div>
                        <span class="rc-faq__guide-kicker">{{ $guide['kicker'] }}</span>
                        <h3 class="rc-faq__guide-title">{{ $guide['title'] }}</h3>
                    </div>
                </div>

                <p class="rc-faq__guide-intro">A few helpful questions to consider as you plan:</p>

                <ul class="rc-faq__guide-list">
                    @foreach ($guide['checklist'] as $point)
                        <li class="rc-faq__guide-item">
                            @include('partials.icon', ['name' => 'check', 'class' => 'rc-faq__guide-check', 'stroke' => 2])
                            <span>{{ $point }}</span>
                        </li>
                    @endforeach
                </ul>

                <div class="rc-faq__guide-action">
                    <a
                        href="{{ $site['phone']['href'] }}"
                        class="mv-btn mv-btn--primary rc-faq__guide-btn"
                        data-inquiry="{{ $guide['action']['intent'] }}"
                        data-inquiry-care="{{ $guide['action']['care'] }}"
                        data-inquiry-source="rc-faq"
                    >
                        <span>{{ $guide['action']['label'] }}</span>
                        @include('partials.icon', ['name' => 'arrow', 'class' => 'mv-icon mv-btn__arrow', 'stroke' => 2])
                    </a>
                </div>
            </aside>

            {{-- Right: Accordion Card --}}
            <div class="rc-faq__card">
                <ul class="rc-faq__list" data-faq-list>
                    @foreach ($faqs as $i => $faq)
                        @php $open = $i === 0; @endphp
                        <li class="rc-faq__item {{ $open ? 'is-open' : '' }}" data-faq-item>
                            <button
                                type="button"
                                class="rc-faq__trigger"
                                id="rc-faq-trigger-{{ $i }}"
                                aria-expanded="{{ $open ? 'true' : 'false' }}"
                                aria-controls="rc-faq-body-{{ $i }}"
                                data-faq-trigger
                            >
                                <span class="rc-faq__question">{{ $faq['question'] }}</span>
                                <span class="rc-faq__icon-wrap" aria-hidden="true">
                                    <svg class="rc-faq__chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </span>
                            </button>

                            <div
                                class="rc-faq__body"
                                id="rc-faq-body-{{ $i }}"
                                role="region"
                                aria-labelledby="rc-faq-trigger-{{ $i }}"
                                @if (! $open) hidden @endif
                                data-faq-body
                            >
                                <div class="rc-faq__answer">
                                    <p>{{ $faq['answer'] }}</p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>
