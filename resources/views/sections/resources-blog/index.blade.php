@php
    /** @var array $data Normalised by App\Content\Sections\ResourcesBlogSection */
    $guardrails = $data['guardrails'];
    $stages = $data['stages'];
    $bridges = $data['bridges'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/resources-blog.css', 'resources/js/sections/resources-blog.js'])
@endpush
{{--
    RESOURCES SECTION 04 · BLOG INVENTORY STATUS & VERIFIED TOPIC ROUTER
--}}
<section class="res-blog fluid-canvas" aria-labelledby="blog-inventory-heading" id="blog-inventory-status" data-res-blog>
    <div class="res-blog__inner">
        <div class="res-blog__grid">
            {{-- Left 5 Columns: Explanation & Guardrails --}}
            <div class="res-blog__story">
                <div class="res-blog__header">
                    <span class="res-blog__kicker font-script">{{ $data['eyebrow'] }}</span>
                    <h2 id="blog-inventory-heading" class="res-blog__title">
                        {!! $data['heading'] !!}
                    </h2>
                    <div class="res-blog__intro">
                        {!! $data['intro'] !!}
                    </div>
                </div>

                {{-- Guardrail Box --}}
                <div class="res-blog__guardrails">
                    <div class="res-blog__guardrails-head">
                        <span class="res-blog__guardrails-tag">Sitemap Status: /blog</span>
                        <span class="res-blog__guardrails-status">Inventory Pending</span>
                    </div>

                    <ul class="res-blog__guardrails-list">
                        @foreach ($guardrails as $g)
                            <li class="res-blog__guardrails-item">
                                <svg class="res-blog__shield-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                                <div>
                                    <strong class="res-blog__guardrails-strong">{{ $g['title'] }}:</strong>
                                    <span>{!! $g['text'] !!}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Right 7 Columns: 4-Stage Editorial Protocol --}}
            <div class="res-blog__protocol">
                <div class="res-blog__protocol-card">
                    <div class="res-blog__protocol-head">
                        <span class="res-blog__protocol-kicker">4-Stage Editorial Verification Protocol</span>
                        <h3 class="res-blog__protocol-title">How Original Blog Articles Will Be Audited Before /blog Activation</h3>
                    </div>

                    {{-- Stage Selector Tabs --}}
                    <div class="res-blog__stage-tabs" role="tablist" aria-label="Blog verification stages">
                        @foreach ($stages as $idx => $stage)
                            @php
                                $isSelected = ($idx === 1); // Stage 02 is active in prototype
                            @endphp
                            <button
                                type="button"
                                role="tab"
                                aria-selected="{{ $isSelected ? 'true' : 'false' }}"
                                class="res-blog__stage-tab {{ $isSelected ? 'res-blog__stage-tab--active' : '' }}"
                                data-blog-tab="{{ $stage['id'] }}"
                            >
                                <span class="res-blog__stage-num">{{ $stage['stepNumber'] }}</span>
                                <span class="res-blog__stage-name">{{ $stage['stageTitle'] }}</span>
                            </button>
                        @endforeach
                    </div>

                    {{-- Active Stage Detail Panels --}}
                    <div class="res-blog__stage-panels">
                        @foreach ($stages as $idx => $stage)
                            @php
                                $isActive = ($idx === 1);
                            @endphp
                            <div
                                class="res-blog__stage-panel {{ $isActive ? 'res-blog__stage-panel--active' : '' }}"
                                data-blog-panel="{{ $stage['id'] }}"
                                {{ $isActive ? '' : 'hidden' }}
                            >
                                <div class="res-blog__panel-head">
                                    <span class="res-blog__panel-step">{{ $stage['stepNumber'] }} · {{ $stage['stageTitle'] }}</span>
                                    <span class="res-blog__panel-status">Status: {{ $stage['statusLabel'] }}</span>
                                </div>

                                <p class="res-blog__panel-summary">{{ $stage['summary'] }}</p>

                                <div class="res-blog__panel-guardrail">
                                    <strong class="res-blog__guardrail-title">Content &amp; Accuracy Guardrail:</strong>
                                    <p class="res-blog__guardrail-detail">{{ $stage['guardrailDetail'] }}</p>
                                    <p class="res-blog__guardrail-deliverable">
                                        Deliverable: {{ $stage['deliverableNote'] }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Sub-Section: Verified Topic Router --}}
        <div id="verified-topic-router" class="res-blog__router" data-topic-router>
            <div class="res-blog__router-head">
                <div>
                    <span class="res-blog__router-kicker">{{ $data['router_eyebrow'] }}</span>
                    <h3 class="res-blog__router-title">{!! $data['router_heading'] !!}</h3>
                </div>
                <p class="res-blog__router-intro">{{ $data['router_intro'] }}</p>
            </div>

            <div class="res-blog__bridges-grid">
                @foreach ($bridges as $b)
                    <article class="res-blog__bridge-card" data-bridge-card="{{ $b['id'] }}">
                        <div class="res-blog__bridge-top">
                            <span class="res-blog__bridge-tag">{{ $b['topicTag'] }}</span>
                            <h4 class="res-blog__bridge-q">“{{ $b['commonFamilyQuestion'] }}”</h4>
                            <p class="res-blog__bridge-find">{{ $b['whatYouWillFind'] }}</p>
                        </div>

                        <div class="res-blog__bridge-action">
                            <span class="res-blog__bridge-dest">{{ $b['verifiedDestinationTitle'] }}</span>
                            <a href="{{ url($b['href']) }}" class="res-blog__bridge-btn">
                                <span>{{ $b['ctaLabel'] }}</span>
                                <svg class="res-blog__bridge-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <line x1="7" y1="17" x2="17" y2="7"/>
                                    <polyline points="7 7 17 7 17 17"/>
                                </svg>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>
