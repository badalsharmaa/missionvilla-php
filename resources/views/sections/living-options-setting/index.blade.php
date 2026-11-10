@php
    /** @var array $data  Normalised by App\Content\Sections\LivingOptionsSettingSection */
    $features = $data['features'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/living-options-setting.css'])
@endpush
{{--
    LIVING OPTIONS SECTION 04 · A WELCOMING, HOMELIKE SETTING
    Light cream background with 4 compact, sophisticated feature cards
    summarizing community dining, engagement, outdoor spaces, and everyday care.
--}}
<section class="lo-setting" id="homelike-setting" aria-labelledby="lo-setting-title" data-lo-setting>
    <div class="lo-setting__inner">
        {{-- Section Header --}}
        <div class="lo-setting__head">
            <p class="mv-eyebrow">
                <span class="mv-eyebrow__rule" aria-hidden="true"></span>
                <span>{{ $data['eyebrow'] }}</span>
            </p>
            <h2 id="lo-setting-title" class="mv-title lo-setting__title">
                {!! $data['heading'] !!}
            </h2>
            <p class="lo-setting__intro">
                {{ $data['intro'] }}
            </p>
        </div>

        {{-- 4 Feature Cards Grid --}}
        <div class="lo-setting__grid">
            @foreach ($features as $feature)
                <div class="lo-setting__card">
                    <div class="lo-setting__icon-box" aria-hidden="true">
                        @include('partials.icon', ['name' => $feature['icon'], 'class' => 'lo-setting__icon', 'stroke' => 1.6])
                    </div>
                    <div class="lo-setting__card-head">
                        <span class="lo-setting__card-lead">{{ $feature['lead'] }}</span>
                        <h3 class="lo-setting__card-title">{{ $feature['title'] }}</h3>
                    </div>
                    <p class="lo-setting__card-body">{{ $feature['body'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
