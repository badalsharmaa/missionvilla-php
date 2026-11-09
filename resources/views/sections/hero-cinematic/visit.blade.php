<div
  id="visitModalBackdrop"
  class="fixed inset-0 z-50 bg-[#140B13]/75 backdrop-blur-sm hidden items-center justify-center p-4"
>
  <div
    class="modal-card w-full max-w-md p-6 sm:p-7 relative"
    role="dialog"
    aria-modal="true"
    aria-labelledby="visitModalTitle"
  >
    <div class="flex items-center justify-between pb-3.5 mb-4 border-b border-[#241522]/12">
      <div>
        <span class="text-[10.5px] font-semibold uppercase tracking-[0.14em] text-[#C86D51]">
          Mission Villa Senior Living · Interactive Demo
        </span>
        <h2 id="visitModalTitle" class="font-serif-editorial text-2xl font-semibold text-[#241522]">
          Schedule a Visit in Daly City
        </h2>
      </div>
      <button
        type="button"
        data-hero-action="close-visit"
        class="w-8 h-8 rounded-[8px] border border-[#241522]/15 flex items-center justify-center text-[#665C54] hover:text-[#241522] hover:bg-[#241522]/5"
        aria-label="Close schedule visit modal"
      >
        &times;
      </button>
    </div>

    {{-- Direct Phone Strip --}}
    <div class="p-3 rounded-[10px] bg-[#EFE8DD] border border-[#241522]/10 mb-4 flex items-center justify-between gap-2">
      <div class="text-xs">
        <div class="font-semibold text-[#241522]">995 East Market Street, Daly City, CA 94014</div>
        <div class="text-[#665C54]">CA RCFE License #415601046</div>
      </div>
      <a
        href="{{ config('missionvilla.phone.href') }}"
        class="shrink-0 text-xs font-semibold text-[#241522] bg-white px-3 py-1.5 rounded-[8px] border border-[#241522]/15 hover:border-[#241522]"
      >
        (650) 756-1995
      </a>
    </div>

    <form id="visitRequestForm" class="space-y-3.5">
      <div>
        <label for="careInterestSelect" class="block text-xs font-semibold text-[#241522] mb-1">
          Care Option of Interest
        </label>
        <select
          id="careInterestSelect"
          class="w-full rounded-[9px] border border-[#241522]/20 bg-white px-3 py-2 text-sm text-[#241522]"
        >
          <option value="Legacies Memory Care">Legacies™ Memory Care</option>
          <option value="Short-Term Respite Care">Short-Term Respite Care</option>
          <option value="Exploring Options / General Tour">Exploring Options — General Walkthrough</option>
        </select>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
          <label for="familyInputName" class="block text-xs font-semibold text-[#241522] mb-1">
            Your Name
          </label>
          <input
            id="familyInputName"
            type="text"
            required
            placeholder="e.g., Elena Vance"
            class="w-full rounded-[9px] border border-[#241522]/20 bg-white px-3 py-2 text-sm text-[#241522]"
          />
        </div>
        <div>
          <label for="familyInputContact" class="block text-xs font-semibold text-[#241522] mb-1">
            Phone or Email
          </label>
          <input
            id="familyInputContact"
            type="text"
            required
            placeholder="(650) 555-0192"
            class="w-full rounded-[9px] border border-[#241522]/20 bg-white px-3 py-2 text-sm text-[#241522]"
          />
        </div>
      </div>

      <div>
        <label for="visitTimeSelect" class="block text-xs font-semibold text-[#241522] mb-1">
          Preferred Time to Visit or Talk
        </label>
        <select
          id="visitTimeSelect"
          class="w-full rounded-[9px] border border-[#241522]/20 bg-white px-3 py-2 text-sm text-[#241522]"
        >
          <option>Weekday Morning (9:30am – 12:00pm)</option>
          <option>Weekday Afternoon (1:00pm – 4:30pm)</option>
          <option>Weekend Visit</option>
          <option>Quiet 10-minute phone introduction first</option>
        </select>
      </div>

      <button type="submit" class="w-full btn-primary-visit justify-center !mt-4">
        <span>Request Private Visit (Demo)</span>
        <span>&rarr;</span>
      </button>
    </form>

    <div id="visitSuccessState" class="hidden text-center py-5">
      <div class="w-10 h-10 rounded-full bg-[#486355] text-white flex items-center justify-center mx-auto mb-3 text-lg">
        &#10003;
      </div>
      <h3 class="font-serif-editorial text-2xl font-semibold text-[#241522] mb-1">
        This is a design preview — nothing was sent.
      </h3>
      <p class="text-xs sm:text-sm text-[#665C54] leading-relaxed mb-4">
        This demo form is not connected to Mission Villa. To request a real visit, call (650) 756-1995 or connect the form to the approved website backend.
      </p>
      <button
        type="button"
        data-hero-action="close-visit"
        class="px-4 py-2 rounded-[9px] bg-[#241522] text-white text-xs font-semibold"
      >
        Return to Mission Villa
      </button>
    </div>
  </div>
</div>
