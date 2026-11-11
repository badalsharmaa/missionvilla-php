@php
    /** @var array $data Normalised by App\Content\Sections\SuitesFloorPlansFaqSection */
    $site = config('missionvilla');
    $faqs = $data['faqs'];
    $help = $data['help_card'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/suites-floor-plans-faq.css', 'resources/js/sections/suites-floor-plans-faq.js'])
@endpush
{{--
    SUITES & FLOOR PLANS SECTION 05 · FAQ ACCORDION (BALANCED 2-COLUMN)
    - Left column: Section title, description, and direct contact card.
    - Right column: Accessible, keyboard-friendly FAQ accordion with Schema.org JSON-LD.
--}}
<section class="sfp-faq" id="suite-faq" aria-labelledby="sfp-faq-title" data-sfp-faq>
    <div class="sfp-faq__inner">
        {{-- Left column: Header & Assistance Card --}}
        <div class="sfp-faq__side">
            <p class="mv-eyebrow sfp-faq__eyebrow">
                <span class="mv-eyebrow__rule sfp-faq__rule" aria-hidden="true"></span>
                <span>{{ $data['eyebrow'] }}</span>
            </p>
            <h2 id="sfp-faq-title" class="mv-title sfp-faq__title">
                {!! $data['heading'] !!}
            </h2>
            <p class="sfp-faq__intro">
                {{ $data['intro'] }}
            </p>

            <div class="sfp-faq__card">
                <h3 class="sfp-faq__card-title">{{ $help['title'] }}</h3>
                <p class="sfp-faq__card-text">{{ $help['text'] }}</p>
                <div class="sfp-faq__card-actions">
                    <a href="{{ $site['phone']['href'] }}" class="sfp-faq__card-phone">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                        <span>{{ $help['phone_label'] }}</span>
                    </a>
                    <button
                        type="button"
                        class="sfp-faq__card-btn"
                        data-inquiry="{{ $help['cta_intent'] }}"
                        data-inquiry-source="sfp-faq-card"
                        data-inquiry-care="exploring"
                    >
                        <span>{{ $help['cta_label'] }}</span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Right column: Accordion List --}}
        <div class="sfp-faq__list" role="region" aria-label="Suite Frequently Asked Questions">
            @foreach ($faqs as $index => $faq)
                <div class="sfp-faq__item" data-faq-item>
                    <h3>
                        <button
                            type="button"
                            class="sfp-faq__trigger"
                            id="sfp-faq-trigger-{{ $faq['id'] }}"
                            aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                            aria-controls="sfp-faq-panel-{{ $faq['id'] }}"
                        >
                            <span class="sfp-faq__q-text">{{ $faq['question'] }}</span>
                            <span class="sfp-faq__icon" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </span>
                        </button>
                    </h3>
                    <div
                        id="sfp-faq-panel-{{ $faq['id'] }}"
                        class="sfp-faq__panel {{ $index === 0 ? 'is-open' : '' }}"
                        role="region"
                        aria-labelledby="sfp-faq-trigger-{{ $faq['id'] }}"
                        @if ($index !== 0) hidden @endif
                    >
                        <div class="sfp-faq__panel-inner">
                            <p class="sfp-faq__answer">{{ $faq['answer'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Schema.org FAQPage structured data --}}
        <script type=application/ld+json>
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => array_map(fn ($f) => [
            '@type' => 'Question',
            'name' => $f['question'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $f['answer'],
            ],
        ], $faqs),
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
</section>
