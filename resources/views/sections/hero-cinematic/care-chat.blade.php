<div id="careChatBackdrop" class="care-chat-backdrop hidden" aria-hidden="true">
  <section id="careChatDialog" class="care-chat-dialog" role="dialog" aria-modal="true" aria-labelledby="careChatTitle" tabindex="-1">
    <header class="care-chat-header">
      <div class="flex items-center gap-3">
        <div class="guide-mark" aria-hidden="true">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20 11.5a7.5 7.5 0 0 1-7.5 7.5H8l-4 2v-5a7.5 7.5 0 1 1 16-4.5Z"/><path d="M8.4 11.7h.01M12 11.7h.01M15.6 11.7h.01" stroke-width="2.4"/></svg>
        </div>
        <div><p class="guide-kicker">MISSION VILLA SENIOR LIVING</p><h2 id="careChatTitle" class="font-serif-editorial text-[1.35rem] font-semibold text-[#241522]">Let's find a good place to start.</h2></div>
      </div>
      <button type="button" class="care-chat-close" data-hero-action="close-care-chat" aria-label="Close care guide">×</button>
    </header>

    <div class="care-chat-note">This is an interactive design preview with prepared guidance, not a live AI or care specialist. For individual advice, call <a href="{{ config('missionvilla.phone.href') }}">(650) 756-1995</a>.</div>
    <div id="careChatMessages" class="care-chat-messages" role="log" aria-live="polite" aria-relevant="additions"></div>
    <div class="care-chat-suggestions" aria-label="Quick questions">
      <button type="button" data-hero-action="care-chat-suggest" data-question="Tell me about Memory Care">Memory Care</button>
      <button type="button" data-hero-action="care-chat-suggest" data-question="Tell me about Respite Care">Respite Care</button>
      <button type="button" data-hero-action="care-chat-suggest" data-question="How do I arrange a visit?">Plan a visit</button>
    </div>
    <div class="care-chat-bottom">
      <form class="care-chat-compose">
        <label for="careChatInput" class="sr-only">Your question for the care guide</label>
        <input id="careChatInput" type="text" maxlength="500" required autocomplete="off" placeholder="Ask about care, visits, or next steps…" />
        <button type="submit" aria-label="Send question"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-6-6 6 6-6 6"/></svg></button>
      </form>
      <div class="flex items-center justify-between flex-wrap gap-2 text-[11px] text-[#665C54] mt-3">
        <span>No information is sent or saved in this prototype.</span>
        <div class="flex items-center gap-3"><a href="{{ config('missionvilla.phone.href') }}" class="underline underline-offset-2">Call the community</a><button type="button" data-hero-action="visit-from-chat" class="font-semibold text-[#9D503A] underline underline-offset-2">Schedule a visit →</button></div>
      </div>
    </div>
  </section>
</div>
