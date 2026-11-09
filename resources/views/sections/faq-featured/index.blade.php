@php
    /** @var array $data  Normalised by App\Content\Sections\FaqFeaturedSection */
    $leaf = asset('images/decor/botanical-leaf-shadow.svg');
@endphp
@push('section-assets')
    @vite(['resources/css/sections/faq-featured.css', 'resources/js/sections/faq-featured.js'])
@endpush
{{--
    HOMEPAGE SECTION 06 · QUESTIONS FAMILIES OFTEN ASK
    Approved mockup "Mission Villa Suites, FAQ & Visit CTA" (middle band, 2026-11-09).
    Accordion: one item open at a time. Without JavaScript every answer is shown.
--}}
<section class="faq-featured" id="faq" aria-labelledby="faq-title" data-faq>
  <img src="{{ $leaf }}" alt="" class="faq__leaf" aria-hidden="true" loading="lazy" decoding="async">
  <div class="faq__inner">
    <div class="faq__intro">
      <p class="mv-eyebrow">
        <span class="mv-eyebrow__rule" aria-hidden="true"></span>
        <span>{{ $data['eyebrow'] }}</span>
      </p>
      <h2 id="faq-title" class="mv-title faq__title">{{ $data['heading'] }}</h2>
      <p class="faq__lede">{{ $data['intro'] }}</p>
      @if ($data['all_link'])
        <a href="{{ url($data['all_link']['href']) }}" class="faq__all">
          <span>{{ $data['all_link']['label'] }}</span>
          @include('partials.icon', ['name' => 'arrow', 'class' => 'faq__all-arrow', 'stroke' => 2])
        </a>
      @endif
    </div>

    <div class="faq__list">
      @foreach ($data['items'] as $i => $item)
        @php $open = $i === 0; @endphp
        <div class="faq-item" data-faq-item data-open="{{ $open ? 'true' : 'false' }}">
          <h3 class="faq-item__heading">
            <button
              type="button"
              class="faq-item__trigger"
              id="faq-q-{{ $item['id'] }}"
              aria-expanded="{{ $open ? 'true' : 'false' }}"
              aria-controls="faq-a-{{ $item['id'] }}"
              data-faq-trigger
            >
              @include('partials.icon', ['name' => $item['icon'], 'class' => 'faq-item__icon', 'stroke' => 1.4])
              <span class="faq-item__question">{{ $item['question'] }}</span>
              <span class="faq-item__toggle" aria-hidden="true">
                @include('partials.icon', ['name' => 'plus', 'class' => 'faq-item__plus', 'stroke' => 1.6])
                @include('partials.icon', ['name' => 'minus', 'class' => 'faq-item__minus', 'stroke' => 1.6])
              </span>
            </button>
          </h3>
          <div class="faq-item__panel" id="faq-a-{{ $item['id'] }}" role="region" aria-labelledby="faq-q-{{ $item['id'] }}" data-faq-panel>
            <div class="faq-item__clip">
              <p class="faq-item__answer">{{ $item['answer'] }}</p>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
