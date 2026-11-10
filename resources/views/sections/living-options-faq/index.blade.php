@php
    /** @var array $data  Normalised by App\Content\Sections\LivingOptionsFaqSection */
    $site = config('missionvilla');
    $help = $data['help_card'];
    $faqs = $data['faqs'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/living-options-faq.css', 'resources/js/sections/living-options-faq.js'])
@endpush
{{--
    LIVING OPTIONS SECTION 05 · QUESTIONS FAMILIES OFTEN ASK
    Balanced 2-column composition:
    - Left column (~45%): Eyebrow, Heading, Intro paragraph, and Care Team Assistance Card
    - Right column (~55%): FAQ Accordion card
    - Upper-right background: Delicate botanical branch accent
--}}
<section class="lo-faq" id="living-options-faq" aria-labelledby="lo-faq-title" data-lo-faq>
    {{-- Delicate botanical branch accent in background --}}
    <span class="lo-faq__leaf" aria-hidden="true"></span>

    <div class="lo-faq__inner">
        <div class="lo-faq__layout">
            {{-- Left: Head & Help Contact Card --}}
            <div class="lo-faq__left">
                <div class="lo-faq__head">
                    <p class="mv-eyebrow">
                        <span class="mv-eyebrow__rule" aria-hidden="true"></span>
                        <span>{{ $data['eyebrow'] }}</span>
                    </p>
                    <h2 id="lo-faq-title" class="mv-title lo-faq__title">
                        {!! $data['heading'] !!}
                    </h2>
                    <p class="lo-faq__intro">
                        {{ $data['intro'] }}
                    </p>
                </div>

                {{-- Care Team Assistance Card --}}
                <aside class="lo-faq__help" aria-label="Assistance with living options">
                    <div class="lo-faq__help-header">
                        <span class="lo-faq__help-icon" aria-hidden="true">
                            @include('partials.icon', ['name' => 'phone', 'class' => 'mv-icon', 'stroke' => 1.5])
                        </span>
                        <div>
                            <span class="lo-faq__help-kicker">Daly City Care Team</span>
                            <h3 class="lo-faq__help-title">{{ $help['title'] }}</h3>
                        </div>
                    </div>

                    <p class="lo-faq__help-text">{{ $help['text'] }}</p>

                    <div class="lo-faq__help-actions">
                        <a href="{{ $site['phone']['href'] }}" class="mv-btn mv-btn--primary lo-faq__help-btn">
                            @include('partials.icon', ['name' => 'phone', 'class' => 'mv-icon', 'stroke' => 1.5])
                            <span>{{ $help['phone_label'] }}</span>
                        </a>

                        <a
                            href="{{ $site['phone']['href'] }}"
                            class="mv-btn mv-btn--plum lo-faq__help-btn"
                            data-inquiry="{{ $help['cta_intent'] }}"
                            data-inquiry-care="exploring"
                            data-inquiry-source="lo-faq"
                        >
                            <span>{{ $help['cta_label'] }}</span>
                            @include('partials.icon', ['name' => 'arrow', 'class' => 'mv-icon mv-btn__arrow', 'stroke' => 2])
                        </a>
                    </div>
                </aside>
            </div>

            {{-- Right: Accordion Card --}}
            <div class="lo-faq__right">
                <div class="lo-faq__card">
                    <ul class="lo-faq__list" data-faq-list>
                        @foreach ($faqs as $i => $faq)
                            @php $open = $i === 0; @endphp
                            <li class="lo-faq__item {{ $open ? 'is-open' : '' }}" data-faq-item>
                                <button
                                    type="button"
                                    class="lo-faq__trigger"
                                    id="lo-faq-trigger-{{ $i }}"
                                    aria-expanded="{{ $open ? 'true' : 'false' }}"
                                    aria-controls="lo-faq-body-{{ $i }}"
                                    data-faq-trigger
                                >
                                    <span class="lo-faq__question">{{ $faq['question'] }}</span>
                                    <span class="lo-faq__icon-wrap" aria-hidden="true">
                                        <svg class="lo-faq__chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="6 9 12 15 18 9"></polyline>
                                        </svg>
                                    </span>
                                </button>

                                <div
                                    class="lo-faq__body"
                                    id="lo-faq-body-{{ $i }}"
                                    role="region"
                                    aria-labelledby="lo-faq-trigger-{{ $i }}"
                                    @if (! $open) hidden @endif
                                    data-faq-body
                                >
                                    <div class="lo-faq__answer">
                                        <p>{{ $faq['answer'] }}</p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Schema.org FAQPage structured data --}}
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "FAQPage",
        "mainEntity": [
            @foreach ($faqs as $i => $faq)
                {
                    "@@type": "Question",
                    "name": {{ json_encode($faq['question']) }},
                    "acceptedAnswer": {
                        "@@type": "Answer",
                        "text": {{ json_encode($faq['answer']) }}
                    }
                }{{ $loop->last ? '' : ',' }}
            @endforeach
        ]
    }
    </script>
</section>
