@php
    /** @var array $data Normalised by App\Content\Sections\FinancialPlanningWorksheetSection */
    $rows = $data['rows'];
@endphp
@push('section-assets')
    @vite(['resources/css/sections/financial-planning-worksheet.css', 'resources/js/sections/financial-planning-worksheet.js'])
@endpush
{{--
    FINANCIAL PLANNING SECTION 04 · INTERACTIVE BLANK PAPER-LEDGER WORKSHEET
--}}
<section class="fp-sheet fluid-canvas paper-texture" aria-labelledby="fp-sheet-heading" id="paper-ledger-worksheet" data-fp-sheet>
    <div class="fp-sheet__inner">
        {{-- Section Top Header & Mode Switcher --}}
        <div class="fp-sheet__header">
            <div class="fp-sheet__header-copy">
                <span class="fp-sheet__kicker font-script">{{ $data['eyebrow'] }}</span>
                <h2 id="fp-sheet-heading" class="fp-sheet__title">
                    {!! $data['heading'] !!}
                </h2>
                <div class="fp-sheet__intro">
                    {!! $data['intro'] !!}
                </div>
            </div>

            {{-- Mode Switcher & Clear Controls --}}
            <div class="fp-sheet__controls">
                <div class="fp-sheet__mode-group" role="group" aria-label="Paper ledger display mode">
                    <button
                        type="button"
                        class="fp-sheet__mode-btn fp-sheet__mode-btn--active"
                        data-ledger-mode="worksheet"
                    >
                        Editable Blank Worksheet
                    </button>
                    <button
                        type="button"
                        class="fp-sheet__mode-btn"
                        data-ledger-mode="checklist"
                    >
                        Text-Only Checklist View
                    </button>
                </div>

                <div class="fp-sheet__action-buttons">
                    <button
                        type="button"
                        class="fp-sheet__ctrl-btn"
                        data-ledger-action="print"
                    >
                        <svg class="fp-sheet__ctrl-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <polyline points="6 9 6 2 18 2 18 9"/>
                            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                            <rect x="6" y="14" width="12" height="8"/>
                        </svg>
                        <span>Print Worksheet</span>
                    </button>

                    <button
                        type="button"
                        class="fp-sheet__ctrl-btn"
                        data-ledger-action="clear"
                    >
                        <svg class="fp-sheet__ctrl-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <polyline points="1 4 1 10 7 10"/>
                            <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/>
                        </svg>
                        <span>Clear Worksheet</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Archival Paper-Ledger Sheet --}}
        <div class="fp-sheet__ledger herbarium-mount">
            {{-- Top Archival Header Band --}}
            <div class="fp-sheet__band">
                <div class="fp-sheet__band-title-wrap">
                    <span class="fp-sheet__band-sub">Mission Villa Senior Living · Family Expense Comparison Ledger</span>
                    <h3 class="fp-sheet__band-title">Side-by-Side Monthly Expense Category Ledger</h3>
                </div>

                <div class="fp-sheet__band-stats">
                    <div class="fp-sheet__band-stat-copy">
                        <span class="fp-sheet__band-line">
                            Checked: <strong data-ledger-checked-count>0</strong>/{{ count($rows) }} Categories · Your Subtotal: <strong data-ledger-subtotal-display>$0/mo</strong>
                        </span>
                        <span class="fp-sheet__band-note">Zero pre-filled prices · Figures you type stay in your browser only</span>
                    </div>

                    <button
                        type="button"
                        class="fp-sheet__band-btn"
                        data-inquiry="request_pricing"
                        data-inquiry-source="fp-worksheet"
                        data-care="memory_care"
                        data-note="Inquiry with Paper-Ledger comparison worksheet review"
                        data-ledger-attach-btn
                    >
                        Attach to Inquiry ↓
                    </button>
                </div>
            </div>

            {{-- Column Header Row (Desktop) --}}
            <div class="fp-sheet__col-headers">
                <div class="fp-sheet__col-h fp-sheet__col-h--cat">01 · Household &amp; Care Expense Category</div>
                <div class="fp-sheet__col-h fp-sheet__col-h--cost">02 · Your Current Monthly Cost (Blank Field)</div>
                <div class="fp-sheet__col-h fp-sheet__col-h--context">03 · How Mission Villa Approaches This Category</div>
            </div>

            {{-- Ruled Rows --}}
            <div class="fp-sheet__rows">
                @foreach ($rows as $row)
                    <div class="fp-sheet__row" data-ledger-row="{{ $row['id'] }}">
                        {{-- Col 1: Category & Prompt --}}
                        <div class="fp-sheet__cell fp-sheet__cell--cat">
                            <button
                                type="button"
                                class="fp-sheet__check-btn"
                                aria-pressed="false"
                                aria-label="Include {{ $row['expense_label'] }} in comparison"
                                data-ledger-check="{{ $row['id'] }}"
                            >
                                <svg class="fp-sheet__square-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                </svg>
                                <svg class="fp-sheet__checked-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                    <polyline points="9 11 12 14 22 4"/>
                                </svg>
                            </button>

                            <div class="fp-sheet__cat-copy">
                                <div class="fp-sheet__line-badge">
                                    <span class="tabular-nums">Line {{ $row['line_number'] }}</span>
                                    <span aria-hidden="true">·</span>
                                    <span>{{ $row['category_group'] }}</span>
                                </div>
                                <label for="ledger-input-{{ $row['id'] }}" class="fp-sheet__label">
                                    {{ $row['expense_label'] }}
                                </label>
                                <p class="fp-sheet__prompt">{{ $row['home_living_prompt'] }}</p>
                            </div>
                        </div>

                        {{-- Col 2: Input Field / Checklist View --}}
                        <div class="fp-sheet__cell fp-sheet__cell--cost">
                            <div class="fp-sheet__input-wrap" data-mode-view="worksheet">
                                <label for="ledger-input-{{ $row['id'] }}" class="sr-only">
                                    Your current monthly cost for {{ $row['expense_label'] }}
                                </label>
                                <div class="fp-sheet__field">
                                    <span class="fp-sheet__curr" aria-hidden="true">$</span>
                                    <input
                                        id="ledger-input-{{ $row['id'] }}"
                                        type="number"
                                        min="0"
                                        step="1"
                                        placeholder="Blank — enter your figure"
                                        class="fp-sheet__input"
                                        data-ledger-input="{{ $row['id'] }}"
                                    >
                                    <span class="fp-sheet__unit" aria-hidden="true">/mo</span>
                                </div>
                                <span class="fp-sheet__recorded-hint" data-ledger-hint="{{ $row['id'] }}" hidden></span>
                            </div>

                            <div class="fp-sheet__checklist-view" data-mode-view="checklist" hidden>
                                <span class="fp-sheet__chk-status" data-chk-status="{{ $row['id'] }}">Unchecked Category</span>
                                <span class="fp-sheet__chk-sub">Bring your household bills for this line item to your visit.</span>
                            </div>
                        </div>

                        {{-- Col 3: Mission Villa Context & Tour Question --}}
                        <div class="fp-sheet__cell fp-sheet__cell--context">
                            <p class="fp-sheet__context-text">{{ $row['mission_villa_consolidated_context'] }}</p>
                            <p class="fp-sheet__tour-q">Ask on tour: “{{ $row['question_to_verify_on_tour'] }}”</p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Summary & Action Footer --}}
            <div class="fp-sheet__footer">
                <div class="fp-sheet__footer-copy">
                    <div class="fp-sheet__footer-meta">
                        <span>Categories Checked: <strong data-footer-checked-count>0</strong> of {{ count($rows) }}</span>
                        <span aria-hidden="true">·</span>
                        <span>Blank Fields Filled by You: <strong data-footer-entered-count>0</strong></span>
                    </div>

                    <div class="fp-sheet__subtotal-row">
                        <span class="fp-sheet__subtotal-label">Your Entered Current-Home Subtotal:</span>
                        <span class="fp-sheet__subtotal-val" data-footer-subtotal-val>— (Enter your own figures above if helpful)</span>
                    </div>

                    <p class="fp-sheet__footer-note">
                        <strong>Mission Villa Personalized Comparison:</strong> Because monthly Memory Care and Respite Care rates depend on your loved one’s assessment and suite choice (Private, Companion Unit, or Jack &amp; Jill), we review our current rates side-by-side with your worksheet during a personal conversation.
                    </p>
                </div>

                <div class="fp-sheet__footer-action">
                    <button
                        type="button"
                        class="fp-sheet__inquiry-btn"
                        data-inquiry="request_pricing"
                        data-inquiry-source="fp-worksheet"
                        data-care="memory_care"
                        data-note="Inquiry with Paper-Ledger comparison worksheet review"
                        data-ledger-submit-btn
                    >
                        <svg class="fp-sheet__btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
                            <rect x="8" y="2" width="8" height="4" rx="1" ry="1"/>
                            <path d="m9 14 2 2 4-4"/>
                        </svg>
                        <span>Add Ledger Summary to My Inquiry →</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Print & Legal Disclaimer --}}
        <p class="fp-sheet__disclaimer">
            {{ $data['print_disclaimer'] }}
        </p>
    </div>
</section>
