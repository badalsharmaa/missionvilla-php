@php
    /** @var array $data Normalised by App\Content\Sections\FinancialPlanningInclusionsSection */
    $categories = $data['categories'];
    $items = $data['items'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/financial-planning-inclusions.css', 'resources/js/sections/financial-planning-inclusions.js'])
@endpush
{{--
    FINANCIAL PLANNING SECTION 03 · GROUPED INCLUSIONS LEDGER
--}}
<section class="fp-inc fluid-canvas paper-texture" aria-labelledby="fp-inc-heading" id="grouped-cost-inclusions" data-fp-inc>
    <div class="fp-inc__inner">
        {{-- Header & Total Count --}}
        <div class="fp-inc__header">
            <div class="fp-inc__header-copy">
                <span class="fp-inc__kicker">{{ $data['eyebrow'] }}</span>
                <h2 id="fp-inc-heading" class="fp-inc__title">
                    {!! $data['heading'] !!}
                </h2>
                <div class="fp-inc__intro">
                    {!! $data['intro'] !!}
                </div>
            </div>

            <div class="fp-inc__count-badge">
                <span class="fp-inc__count-num" data-inc-visible-count>{{ count($items) }}</span>
                <span class="fp-inc__count-label">Typical Community Inclusions</span>
            </div>
        </div>

        {{-- Category Filter Tabs --}}
        <div role="tablist" aria-label="Filter cost inclusions by category" class="fp-inc__category-tabs">
            @foreach ($categories as $idx => $cat)
                @php
                    $count = $cat === 'All Categories'
                        ? count($items)
                        : count(array_filter($items, fn($it) => $it['group'] === $cat));
                @endphp
                <button
                    type="button"
                    role="tab"
                    aria-selected="{{ $idx === 0 ? 'true' : 'false' }}"
                    class="fp-inc__cat-btn {{ $idx === 0 ? 'fp-inc__cat-btn--active' : '' }}"
                    data-inc-filter="{{ $cat }}"
                >
                    <span>{{ $cat }}</span>
                    <span class="fp-inc__cat-count">({{ $count }})</span>
                </button>
            @endforeach
        </div>

        {{-- 2-Column Cards Grid --}}
        <div class="fp-inc__grid">
            @foreach ($items as $item)
                @php
                    $isConfirmed = $item['confirmation_status'] === 'Standard Community Offering';
                @endphp
                <div
                    class="fp-inc__card herbarium-mount"
                    data-inc-card="{{ $item['id'] }}"
                    data-inc-group="{{ $item['group'] }}"
                >
                    <div class="fp-inc__card-header">
                        <div class="fp-inc__card-meta">
                            <span class="fp-inc__card-code">{{ $item['code'] }}</span>
                            <span aria-hidden="true">·</span>
                            <span class="fp-inc__card-group">{{ $item['group'] }}</span>
                        </div>
                        <span class="fp-inc__status-pill {{ $isConfirmed ? 'fp-inc__status-pill--standard' : 'fp-inc__status-pill--verify' }}">
                            {{ $item['confirmation_status'] }}
                        </span>
                    </div>

                    <div class="fp-inc__card-body">
                        <h3 class="fp-inc__card-title">{{ $item['title'] }}</h3>
                        <p class="fp-inc__card-summary">{{ $item['summary'] }}</p>

                        <div class="fp-inc__impact-box">
                            <strong class="fp-inc__impact-label">How It Helps Family Budgeting:</strong>
                            <p class="fp-inc__impact-text">{{ $item['how_it_helps_families'] }}</p>
                        </div>
                    </div>

                    <div class="fp-inc__card-footer">
                        <span class="fp-inc__verification-note">
                            <strong>Tour Verification:</strong> {{ $item['verification_note'] }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
