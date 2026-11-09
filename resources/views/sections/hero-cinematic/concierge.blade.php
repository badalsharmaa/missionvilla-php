<div
  id="conciergeBackdrop"
  class="fixed inset-0 z-50 bg-[#140B13]/75 backdrop-blur-sm hidden items-center justify-center p-4"
>
  <div
    class="modal-card w-full max-w-lg p-6 sm:p-7 relative"
    role="dialog"
    aria-modal="true"
    aria-labelledby="conciergeTitle"
  >
    {{-- Top Bar --}}
    <div class="flex items-center justify-between pb-3.5 mb-4 border-b border-[#241522]/12">
      <div class="flex items-center gap-2">
        <span class="w-2 h-2 rounded-full bg-[#6E8F7D]"></span>
        <span id="conciergeStepBadge" class="text-[11px] font-semibold uppercase tracking-[0.14em] text-[#665C54]">
          Mission Villa Care Guide · Step 1 of 2
        </span>
      </div>
      <button
        type="button"
        data-hero-action="close-concierge"
        class="w-8 h-8 rounded-[8px] border border-[#241522]/15 flex items-center justify-center text-[#665C54] hover:text-[#241522] hover:bg-[#241522]/5"
        aria-label="Close care guide"
      >
        &times;
      </button>
    </div>

    {{-- STEP 1 --}}
    <div id="conciergeStep1">
      <h2 id="conciergeTitle" class="font-serif-editorial text-2xl font-semibold text-[#241522] mb-1.5">
        Who are you exploring care for today?
      </h2>
      <p class="text-xs sm:text-sm text-[#665C54] mb-4">
        Take a quiet moment—no contact form required. We’ll point you toward the most relevant care option at Mission Villa.
      </p>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
        <button type="button" data-hero-action="concierge-person" data-person="My mother or father" class="concierge-option-btn">
          <span class="text-sm font-medium">My mother or father</span>
          <span class="text-[#C86D51]">&rarr;</span>
        </button>
        <button type="button" data-hero-action="concierge-person" data-person="My spouse or partner" class="concierge-option-btn">
          <span class="text-sm font-medium">My spouse or partner</span>
          <span class="text-[#C86D51]">&rarr;</span>
        </button>
        <button type="button" data-hero-action="concierge-person" data-person="A family member or friend" class="concierge-option-btn">
          <span class="text-sm font-medium">Another relative or friend</span>
          <span class="text-[#C86D51]">&rarr;</span>
        </button>
        <button type="button" data-hero-action="concierge-person" data-person="Planning ahead" class="concierge-option-btn">
          <span class="text-sm font-medium">Planning ahead</span>
          <span class="text-[#C86D51]">&rarr;</span>
        </button>
      </div>
    </div>

    {{-- STEP 2 --}}
    <div id="conciergeStep2" class="hidden">
      <button
        type="button"
        data-hero-action="concierge-reset"
        class="text-xs font-medium text-[#C86D51] hover:underline mb-1 inline-block"
      >
        &larr; For: <span id="chosenPersonLabel">My mother or father</span>
      </button>
      <h2 class="font-serif-editorial text-2xl font-semibold text-[#241522] mb-1.5">
        What feels most important right now?
      </h2>
      <p class="text-xs sm:text-sm text-[#665C54] mb-4">
        Choose the situation that best matches what your family is navigating.
      </p>

      <div class="space-y-2.5">
        <button type="button" data-hero-action="concierge-outcome" data-outcome="memory" class="concierge-option-btn">
          <div>
            <div class="text-sm font-semibold text-[#241522]">Memory changes or Alzheimer’s / dementia support</div>
            <div class="text-xs text-[#665C54]">Learning how Legacies™ Memory Care honors daily routines and safety</div>
          </div>
          <span class="text-[#C86D51] shrink-0">&rarr;</span>
        </button>

        <button type="button" data-hero-action="concierge-outcome" data-outcome="respite" class="concierge-option-btn">
          <div>
            <div class="text-sm font-semibold text-[#241522]">A trusted Short-Term Respite stay</div>
            <div class="text-xs text-[#665C54]">Temporary residential care while family caregivers rest, travel, or recover</div>
          </div>
          <span class="text-[#C86D51] shrink-0">&rarr;</span>
        </button>

        <button type="button" data-hero-action="concierge-outcome" data-outcome="unsure" class="concierge-option-btn">
          <div>
            <div class="text-sm font-semibold text-[#241522]">We’re just beginning and need honest guidance</div>
            <div class="text-xs text-[#665C54]">Understanding what a quiet visit to our Daly City community looks like</div>
          </div>
          <span class="text-[#C86D51] shrink-0">&rarr;</span>
        </button>
      </div>
    </div>

    {{-- STEP 3: OUTCOME --}}
    <div id="conciergeStep3" class="hidden">
      <div class="inline-flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-wider text-[#486355] bg-[#486355]/12 px-2.5 py-1 rounded-md mb-2.5">
        <span id="conciergeOutcomeBadge">Recommended Path</span>
      </div>
      <h3 id="conciergeOutcomeTitle" class="font-serif-editorial text-2xl font-semibold text-[#241522] mb-2">
        Legacies™ Memory Care in Daly City
      </h3>
      <p id="conciergeOutcomeDesc" class="text-sm leading-relaxed text-[#3A2E37] mb-5">
        In our Legacies™ Memory Care program at 995 East Market Street, we begin by learning your loved one’s personal history, familiar habits, and sources of comfort.
      </p>

      <div class="flex flex-wrap items-center gap-3 pt-3 border-t border-[#241522]/12">
        <button
          type="button"
          data-hero-action="concierge-to-visit"
          class="btn-primary-visit !py-2.5 !px-4 !text-xs"
        >
          <span>Schedule a Private Visit</span>
          <span>&rarr;</span>
        </button>
        <a
          href="{{ config('missionvilla.phone.href') }}"
          class="px-3.5 py-2.5 rounded-[9px] border border-[#241522]/20 text-xs font-semibold text-[#241522] hover:bg-[#241522]/5"
        >
          Call (650) 756-1995
        </a>
        <button
          type="button"
          data-hero-action="concierge-reset"
          class="text-xs text-[#665C54] hover:text-[#241522] underline ml-auto"
        >
          Start over
        </button>
      </div>
    </div>
  </div>
</div>
