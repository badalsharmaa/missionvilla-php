@php
    /** @var array $data Normalised by App\Content\Sections\ContactWorkflowSection */
    $steps = $data['steps'];
    $activeStep = $steps[0];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/contact-workflow.css', 'resources/js/sections/contact-workflow.js'])
@endpush
{{--
    CONTACT SECTION 04 · WHAT HAPPENS AFTER SUBMITTING (#what-happens-next)
--}}
<section class="contact-workflow fluid-canvas" aria-labelledby="contact-workflow-heading" id="what-happens-next" data-contact-workflow>
    <div class="contact-workflow__inner">
        {{-- Section Header --}}
        <div class="contact-workflow__header">
            <div class="contact-workflow__header-left">
                <span class="contact-workflow__script font-script">{{ $data['script_title'] }}</span>
                <h2 id="contact-workflow-heading" class="contact-workflow__title">
                    {!! $data['heading'] !!}
                </h2>
            </div>
            <div class="contact-workflow__header-right">
                <p class="contact-workflow__lead">
                    {!! $data['intro'] !!}
                </p>
            </div>
        </div>

        {{-- 4-Step Interactive Selector Tabs --}}
        <div class="contact-workflow__tabs-grid">
            @foreach ($steps as $step)
                <button
                    type="button"
                    class="contact-workflow__tab-btn {{ $loop->first ? 'contact-workflow__tab-btn--active' : '' }}"
                    data-workflow-tab="{{ $step['id'] }}"
                >
                    <div class="contact-workflow__tab-top">
                        <span class="contact-workflow__tab-number">{{ $step['step_number'] }}</span>
                        <svg class="contact-workflow__tab-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="contact-workflow__tab-title">{{ $step['title'] }}</h3>
                        <p class="contact-workflow__tab-timing">{{ $step['timing_badge'] }}</p>
                    </div>
                </button>
            @endforeach
        </div>

        {{-- Active Step Detail Panels --}}
        <div class="contact-workflow__panels">
            @foreach ($steps as $step)
                <div
                    class="contact-workflow__panel herbarium-mount"
                    data-workflow-panel="{{ $step['id'] }}"
                    {{ $loop->first ? '' : 'hidden' }}
                >
                    <div class="contact-workflow__panel-grid">
                        {{-- Left 5 Columns: Step Identity & Family Reassurance --}}
                        <div class="contact-workflow__panel-left">
                            <div class="contact-workflow__panel-header">
                                <span class="contact-workflow__panel-badge">{{ $step['step_number'] }} · {{ $step['timing_badge'] }}</span>
                                <h3 class="contact-workflow__panel-title">{{ $step['title'] }}</h3>
                                <p class="contact-workflow__panel-sub">{{ $step['subtitle'] }}</p>
                            </div>

                            <div class="contact-workflow__reassurance-card">
                                <span class="contact-workflow__reassurance-label">Our Commitment to Families</span>
                                <p class="contact-workflow__reassurance-text">{{ $step['family_reassurance'] }}</p>
                            </div>
                        </div>

                        {{-- Right 7 Columns: Production vs Prototype Comparison Cards --}}
                        <div class="contact-workflow__panel-right">
                            <div class="contact-workflow__compare-grid">
                                {{-- Production Card --}}
                                <div class="contact-workflow__compare-card contact-workflow__compare-card--prod">
                                    <div>
                                        <span class="contact-workflow__compare-tag contact-workflow__compare-tag--prod">Once Live Backend Is Connected</span>
                                        <h4 class="contact-workflow__compare-title">Production Handoff Behavior</h4>
                                        <p class="contact-workflow__compare-text">{{ $step['what_happens_in_production'] }}</p>
                                    </div>
                                    <span class="contact-workflow__compare-note">Planned for production CRM/email phase</span>
                                </div>

                                {{-- Prototype Card --}}
                                <div class="contact-workflow__compare-card contact-workflow__compare-card--proto">
                                    <div>
                                        <span class="contact-workflow__compare-tag contact-workflow__compare-tag--proto">Current Prototype Stage (Today)</span>
                                        <h4 class="contact-workflow__compare-title">Demo Only — No Inquiry Sent</h4>
                                        <p class="contact-workflow__compare-text">{{ $step['current_prototype_behavior'] }}</p>
                                    </div>
                                    <a href="tel:16507561995" class="contact-workflow__live-link">
                                        <svg class="contact-workflow__phone-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                        </svg>
                                        <span>Call 650-756-1995 for live help →</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
