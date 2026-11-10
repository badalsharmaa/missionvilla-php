/**
 * APPROVED CINEMATIC HERO — slider engine, Care Guide preview and dialogs.
 *
 * Ported from mission_villa_cinematic_hero_final.html. Timings, eases,
 * choreography and scripted Care Guide replies are unchanged. Refactors:
 *  - GSAP is bundled locally (no CDN dependency, so the CDN "lite" fallback is gone)
 *  - inline onclick globals replaced by data-hero-action delegation
 *  - slide copy comes from server-rendered JSON (CMS-managed content)
 *  - single-initialisation guard; developer safe-zone overlay not shipped
 *
 * CARE GUIDE: interactive scripted demo — no AI, network, data storage or
 * medical advice. Future Hiraya Bridge integration replaces getCareGuideReply
 * via a server endpoint (see app/Integrations/Concierge/CareGuideResponder.php).
 */
import { gsap } from 'gsap';

function initHeroCinematic(heroEl) {
  if (!heroEl || heroEl.dataset.initialized) return;
  heroEl.dataset.initialized = 'true';

  const $ = (id) => document.getElementById(id);

  let slidesData = [];
  try {
    slidesData = JSON.parse($('heroSlidesData')?.textContent || '[]');
  } catch {
    slidesData = [];
  }
  if (!slidesData.length) return;

  // Offline-friendly placeholder when an illustrative photograph cannot load.
  function handleImageFallback(imgEl, index) {
    if (imgEl.dataset.fallbackApplied) return;
    imgEl.dataset.fallbackApplied = 'true';
    const title = slidesData[index]?.fallbackLabel || 'Mission Villa Senior Living';
    const safeText = title.replace(/&/g, '&amp;').replace(/</g, '&lt;');
    const svg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1600 900">
      <defs><linearGradient id="g" x1="0" x2="1" y1="0" y2="1"><stop stop-color="#271927"/><stop offset="1" stop-color="#674C50"/></linearGradient></defs>
      <rect width="1600" height="900" fill="url(#g)"/>
      <circle cx="1210" cy="440" r="380" fill="#E8BDA8" opacity=".11"/>
      <text x="1100" y="805" font-family="Georgia,serif" text-anchor="middle" fill="#F6E7DC" font-size="35">${safeText}</text>
      <text x="1100" y="855" font-family="Arial,sans-serif" text-anchor="middle" fill="#E5B293" font-size="18">Illustrative image unavailable</text>
    </svg>`;
    // Drop <source> siblings so the browser uses the fallback src.
    imgEl.closest('picture')?.querySelectorAll('source').forEach((s) => s.remove());
    imgEl.src = 'data:image/svg+xml;charset=utf-8,' + encodeURIComponent(svg);
  }

  heroEl.querySelectorAll('img[data-fallback-index]').forEach((img) => {
    const index = Number(img.dataset.fallbackIndex);
    img.addEventListener('error', () => handleImageFallback(img, index));
    if (img.complete && img.naturalWidth === 0 && img.currentSrc) handleImageFallback(img, index);
  });

  let currentSlide = 0;
  let isAnimating = false;
  let autoplayEnabled = !window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const AUTOPLAY_SECONDS = Number(heroEl.dataset.autoplaySeconds) || 6.0; // 6-second viewing interval per scene
  let progressTween = null;

  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  function initSlider() {
    if (!autoplayEnabled) {
      $('autoplayStatusText').textContent = 'Paused';
      $('autoplayStatusDot').className = 'w-1.5 h-1.5 rounded-full bg-[#F3C6B6]';
    }
    const bgSlides = heroEl.querySelectorAll('.bg-slide');

    bgSlides.forEach((el, idx) => {
      el.style.zIndex = idx === 0 ? 3 : 1;
      el.style.clipPath = 'inset(0% 0% 0% 0%)';
    });

    // If the opening shutters are playing, start chapter 1's timer only once they
    // part, so the first chapter still gets its full viewing interval.
    const introPlaying = document.documentElement.classList.contains('mv-intro-active') && !window.__mvIntroOpen;
    if (introPlaying) {
      $('progressFill0') && gsap.set($('progressFill0'), { scaleX: autoplayEnabled ? 0 : 1 });
      let started = false;
      const begin = () => {
        if (started) return;
        started = true;
        if (currentSlide === 0 && !isAnimating) startChapterProgress(0);
      };
      window.addEventListener('missionvilla:intro-open', begin, { once: true });
      setTimeout(begin, 5000); // safety net if the intro script never reports
    } else {
      startChapterProgress(0);
    }
    setupSubtleParallax();
  }

  function startChapterProgress(index) {
    if (progressTween) progressTween.kill();

    slidesData.forEach((_, i) => {
      const fill = $(`progressFill${i}`);
      const btn = $(`chapterBtn${i}`);
      if (btn) btn.setAttribute('aria-selected', i === index ? 'true' : 'false');
      if (fill) {
        gsap.set(fill, { scaleX: i === index && !autoplayEnabled ? 1 : 0 });
      }
    });

    if (!autoplayEnabled || prefersReducedMotion) {
      const activeFill = $(`progressFill${index}`);
      if (activeFill) gsap.set(activeFill, { scaleX: 1 });
      return;
    }

    const activeFill = $(`progressFill${index}`);
    if (activeFill) {
      progressTween = gsap.fromTo(
        activeFill,
        { scaleX: 0 },
        {
          scaleX: 1,
          duration: AUTOPLAY_SECONDS,
          ease: 'none',
          onComplete: () => {
            if (autoplayEnabled && !isAnimating) {
              goToSlide((currentSlide + 1) % slidesData.length, false);
            }
          },
        }
      );
    }
  }

  function goToSlide(nextIndex, userInitiated = false) {
    if (isAnimating || nextIndex === currentSlide) return;
    isAnimating = true;

    if (userInitiated && autoplayEnabled) {
      // Keep user control predictable by resetting the timer cleanly
      if (progressTween) progressTween.kill();
    }

    const prevIndex = currentSlide;
    currentSlide = nextIndex;
    const data = slidesData[nextIndex];

    const bgSlides = heroEl.querySelectorAll('.bg-slide');
    const currentBg = bgSlides[prevIndex];
    const nextBg = bgSlides[nextIndex];
    const nextBgImg = nextBg.querySelector('img');

    // Stack order inside .bg-stage (all stay below .editorial-scrim at z-index: 5)
    bgSlides.forEach((s) => (s.style.zIndex = 1));
    currentBg.style.zIndex = 2;
    nextBg.style.zIndex = 3;

    startChapterProgress(nextIndex);

    if (prefersReducedMotion) {
      updateSlideCopyDOM(data);
      nextBg.style.clipPath = 'inset(0% 0% 0% 0%)';
      isAnimating = false;
      return;
    }

    const tl = gsap.timeline({
      onComplete: () => {
        isAnimating = false;
      },
    });

    // 1. Horizontal Curtain Reveal on Full-Bleed Background
    tl.fromTo(
      nextBg,
      { clipPath: 'inset(0% 0% 0% 100%)' },
      { clipPath: 'inset(0% 0% 0% 0%)', duration: 1.15, ease: 'power3.inOut' },
      0
    );

    tl.fromTo(nextBgImg, { scale: 1.08 }, { scale: 1.0, duration: 1.45, ease: 'power2.out' }, 0);

    // 2. Choreographed Exit & Entrance of Foreground Typography
    const lines = ['#headlineLine1', '#headlineLine2', '#headlineLine3'];
    const fadeTargets = ['#slideChapterPill', '#slideBodyCopy'];

    tl.to(lines, { yPercent: -105, opacity: 0, duration: 0.36, stagger: 0.04, ease: 'power2.in' }, 0);

    tl.to(fadeTargets, { opacity: 0, y: -6, duration: 0.3, ease: 'power2.in' }, 0.04);

    tl.add(() => {
      updateSlideCopyDOM(data);
    }, 0.42);

    tl.fromTo(
      lines,
      { yPercent: 105, opacity: 0 },
      { yPercent: 0, opacity: 1, duration: 0.68, stagger: 0.06, ease: 'power3.out' },
      0.44
    );

    tl.fromTo(
      fadeTargets,
      { opacity: 0, y: 8 },
      { opacity: 1, y: 0, duration: 0.55, stagger: 0.04, ease: 'power2.out' },
      0.48
    );
  }

  // Slide HTML is sanitized server-side (App\Content\InlineText: <em>/<strong> only).
  function updateSlideCopyDOM(data) {
    $('slideEyebrowText').textContent = data.eyebrow;
    $('headlineLine1').innerHTML = data.line1;
    $('headlineLine2').innerHTML = data.line2;
    $('headlineLine3').innerHTML = data.line3;
    $('slideBodyCopy').innerHTML = data.body;
    $('primaryCtaLabel').textContent = data.cta;
  }

  function nextSlide() {
    goToSlide((currentSlide + 1) % slidesData.length, true);
  }

  function prevSlide() {
    goToSlide((currentSlide - 1 + slidesData.length) % slidesData.length, true);
  }

  function toggleAutoplay() {
    autoplayEnabled = !autoplayEnabled;
    const dot = $('autoplayStatusDot');
    const txt = $('autoplayStatusText');
    if (autoplayEnabled) {
      dot.className = 'w-1.5 h-1.5 rounded-full bg-[#6E8F7D]';
      txt.textContent = 'Auto';
      startChapterProgress(currentSlide);
    } else {
      if (progressTween) progressTween.kill();
      dot.className = 'w-1.5 h-1.5 rounded-full bg-[#F3C6B6]';
      txt.textContent = 'Paused';
      const activeFill = $(`progressFill${currentSlide}`);
      if (activeFill) gsap.set(activeFill, { scaleX: 1 });
    }
  }

  // Restrained Depth Parallax on Desktop Pointer Move
  function setupSubtleParallax() {
    if (prefersReducedMotion) return;
    const card = $('careGuidePreview');
    if (!card) return;

    heroEl.addEventListener('mousemove', (e) => {
      if (window.innerWidth < 1024 || e.target.closest('#careGuidePreview')) return;
      const xNorm = (e.clientX / window.innerWidth - 0.5) * 2;
      const yNorm = (e.clientY / window.innerHeight - 0.5) * 2;
      gsap.to(card, {
        x: xNorm * -6,
        y: yNorm * -5,
        duration: 0.9,
        ease: 'power2.out',
        overwrite: 'auto',
      });
    });
  }

  // Touch Swipe Support on Mobile/Tablet
  let touchStartX = 0;
  heroEl.addEventListener('touchstart', (e) => {
    touchStartX = e.changedTouches[0].screenX;
  }, { passive: true });

  heroEl.addEventListener('touchend', (e) => {
    const diff = e.changedTouches[0].screenX - touchStartX;
    if (Math.abs(diff) > 50) {
      if (diff < 0) nextSlide();
      else prevSlide();
    }
  }, { passive: true });

  // ==========================================================================
  // CARE GUIDE: INTERACTIVE DEMO
  // ==========================================================================
  let careChatStarted = false;
  let careChatPreviousFocus = null;

  function openCareChat(initialQuestion = '') {
    const backdrop = $('careChatBackdrop');
    const dialog = $('careChatDialog');
    if (autoplayEnabled) toggleAutoplay();
    careChatPreviousFocus = document.activeElement;
    backdrop.classList.remove('hidden');
    backdrop.classList.add('is-open');
    backdrop.setAttribute('aria-hidden', 'false');
    if (!careChatStarted) {
      addCareChatMessage('assistant', "Welcome. I'm the Mission Villa Care Guide preview. I can help you explore Memory Care, Respite Care, and the next steps for visiting. What would be most helpful today?");
      careChatStarted = true;
    }
    if (initialQuestion) sendCareChatQuestion(initialQuestion);
    dialog.focus();
  }

  function closeCareChat() {
    const backdrop = $('careChatBackdrop');
    if (backdrop.classList.contains('hidden')) return;
    backdrop.classList.remove('is-open');
    backdrop.classList.add('hidden');
    backdrop.setAttribute('aria-hidden', 'true');
    if (careChatPreviousFocus && typeof careChatPreviousFocus.focus === 'function') careChatPreviousFocus.focus();
  }

  function addCareChatMessage(speaker, message) {
    const log = $('careChatMessages');
    const bubble = document.createElement('div');
    bubble.className = `care-chat-bubble ${speaker}`;
    const who = document.createElement('span');
    who.className = 'care-chat-speaker';
    who.textContent = speaker === 'visitor' ? 'You' : 'Care Guide · Preview';
    const body = document.createElement('span');
    body.textContent = message; // textContent avoids treating visitors' text as HTML.
    bubble.append(who, body);
    log.appendChild(bubble);
    log.scrollTop = log.scrollHeight;
    return bubble;
  }

  function getCareGuideReply(question) {
    const q = question.toLowerCase();
    if (/price|pricing|cost|fee|rate|insurance|medicare|medicaid|payment/.test(q)) {
      return 'Pricing and payment details need to be confirmed directly with Mission Villa. For accurate information about a specific stay or care need, please call the Daly City team at (650) 756-1995. You can also request a visit.';
    }
    if (/respite|short.term|temporary|short stay|break|caregiver|travel/.test(q)) {
      return 'Mission Villa offers Short-Term Respite Care for families seeking a temporary residential stay for a loved one. It may help when a caregiver needs time to rest, travel, or recover. The community can explain availability, appropriate care needs, and stay arrangements by phone at (650) 756-1995.';
    }
    if (/memory|legacies|alzheimer|dementia|forget|confus|cognit/.test(q)) {
      return 'Legacies™ Memory Care is Mission Villa’s specialized care offering for older adults living with memory-related changes. The emphasis is on familiar routines, personal history, dignity, and supportive daily life. For an individual care assessment, speak with the Mission Villa team directly.';
    }
    if (/visit|tour|schedule|appointment|meet|see the place/.test(q)) {
      return 'You can request a visit to Mission Villa Senior Living at 995 East Market Street, Daly City, CA 94014, or call the community directly at (650) 756-1995. The Schedule a Visit button in this prototype opens a demo form; it does not submit a real request.';
    }
    if (/where|address|location|daly|phone|call|contact|license/.test(q)) {
      return 'Mission Villa Senior Living is located at 995 East Market Street, Daly City, CA 94014. Phone: (650) 756-1995. California RCFE License #415601046.';
    }
    if (/begin|unsure|not sure|don't know|do not know|options|help|start/.test(q)) {
      return 'A good first step is to consider whether you are exploring ongoing Memory Care or a short-term Respite stay. It is also completely fine not to know yet. Mission Villa’s care team can discuss the situation with you and help you determine which questions to ask next.';
    }
    return 'Thank you for sharing that. This preview can answer general questions about Memory Care, Respite Care, visiting, and contacting Mission Villa. For your specific situation, please speak directly with the care team at (650) 756-1995. What would you like to explore first?';
  }

  function sendCareChatQuestion(question) {
    const cleaned = String(question || '').trim().slice(0, 500);
    if (!cleaned) return;
    addCareChatMessage('visitor', cleaned);
    addCareChatMessage('assistant', getCareGuideReply(cleaned));
  }

  $('carePreviewForm')?.addEventListener('submit', (event) => {
    event.preventDefault();
    const field = $('carePreviewQuestion');
    const question = field.value.trim();
    if (!question) return;
    openCareChat(question);
    field.value = '';
  });

  document.querySelector('#careChatDialog .care-chat-compose')?.addEventListener('submit', (event) => {
    event.preventDefault();
    const input = $('careChatInput');
    const question = input.value.trim();
    if (!question) return;
    input.value = '';
    sendCareChatQuestion(question);
    input.focus();
  });

  function openVisitFromCareChat() {
    closeCareChat();
    openVisitModal();
  }

  // ==========================================================================
  // 2-STEP GUIDED CARE CONCIERGE CONTROLLER
  // (ported intact; the approved prototype has no visible trigger for it yet)
  // ==========================================================================
  let selectedPerson = 'My mother or father';
  let conciergeCare = null; // preselects "Care of interest" in the visit form after a concierge outcome

  function closeConciergeModal() {
    const modal = $('conciergeBackdrop');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }

  function resetConcierge() {
    $('conciergeStepBadge').textContent = 'Mission Villa Care Guide · Step 1 of 2';
    $('conciergeStep1').classList.remove('hidden');
    $('conciergeStep2').classList.add('hidden');
    $('conciergeStep3').classList.add('hidden');
  }

  function chooseConciergePerson(person) {
    selectedPerson = person;
    $('chosenPersonLabel').textContent = person;
    $('conciergeStepBadge').textContent = 'Mission Villa Care Guide · Step 2 of 2';
    $('conciergeStep1').classList.add('hidden');
    $('conciergeStep2').classList.remove('hidden');
    $('conciergeStep3').classList.add('hidden');
  }

  function showConciergeOutcome(type) {
    $('conciergeStepBadge').textContent = 'Personal Care Recommendation · Daly City';
    $('conciergeStep1').classList.add('hidden');
    $('conciergeStep2').classList.add('hidden');
    $('conciergeStep3').classList.remove('hidden');

    const badge = $('conciergeOutcomeBadge');
    const title = $('conciergeOutcomeTitle');
    const desc = $('conciergeOutcomeDesc');

    if (type === 'memory') {
      goToSlide(1, true);
      badge.textContent = `${selectedPerson} · Legacies™ Memory Care`;
      title.textContent = 'Legacies™ Memory Care at Mission Villa';
      desc.textContent = 'When memory changes affect daily life, familiar routines matter deeply. Our Daly City team takes time to learn your loved one’s personal story and habits so every day feels calm, dignified, and secure.';
      conciergeCare = 'memory_care';
    } else if (type === 'respite') {
      goToSlide(2, true);
      badge.textContent = `${selectedPerson} · Short-Term Respite Care`;
      title.textContent = 'Trusted Short-Term Respite Stays';
      desc.textContent = 'Supporting someone you love requires moments to rest and recharge. Our Short-Term Respite Care at 995 East Market Street provides attentive daily support and warm companionship in a residential setting.';
      conciergeCare = 'respite_care';
    } else {
      goToSlide(0, true);
      badge.textContent = `${selectedPerson} · Unhurried First Visit`;
      title.textContent = 'An Unhurried Walkthrough in Daly City';
      desc.textContent = 'You don’t need to have every answer before visiting. Come experience the atmosphere at Mission Villa in person and talk privately with our care team about what your family is navigating.';
      conciergeCare = 'exploring';
    }
  }

  // ==========================================================================
  // SCHEDULE A VISIT: opens the site's shared inquiry modal
  // (components/inquiry/dialog, resources/js/components/inquiry-dialog.js).
  // The hero's former "design preview, nothing was sent" dialog is retired so
  // every visit request uses one real form (website-wide modal rule, 2026-11-10).
  // ==========================================================================
  function openVisitModal() {
    if (autoplayEnabled) toggleAutoplay();
    // Care of interest: the concierge's outcome, else the chapter on screen (01 welcome · 02 memory · 03 respite).
    const care = conciergeCare || [null, 'memory_care', 'respite_care'][currentSlide] || null;
    window.MissionVilla?.openInquiry?.('schedule_visit', { source: 'hero', care });
  }

  // ==========================================================================
  // ACTION DELEGATION (replaces the prototype's inline onclick handlers)
  // ==========================================================================
  const actions = {
    'open-visit': () => openVisitModal(),
    'open-care-chat': (el) => openCareChat(el.dataset.question || ''),
    'go-to-slide': (el) => goToSlide(Number(el.dataset.slide), true),
    'prev-slide': () => prevSlide(),
    'next-slide': () => nextSlide(),
    'toggle-autoplay': () => toggleAutoplay(),
    'close-care-chat': () => closeCareChat(),
    'care-chat-suggest': (el) => sendCareChatQuestion(el.dataset.question),
    'visit-from-chat': () => openVisitFromCareChat(),
    'close-concierge': () => closeConciergeModal(),
    'concierge-to-visit': () => { closeConciergeModal(); openVisitModal(); },
    'concierge-person': (el) => chooseConciergePerson(el.dataset.person),
    'concierge-outcome': (el) => showConciergeOutcome(el.dataset.outcome),
    'concierge-reset': () => resetConcierge(),
  };

  document.addEventListener('click', (e) => {
    const trigger = e.target.closest('[data-hero-action]');
    if (trigger && actions[trigger.dataset.heroAction]) {
      actions[trigger.dataset.heroAction](trigger);
      return;
    }
    // Backdrop clicks close; clicks inside a dialog do not.
    if (e.target === $('careChatBackdrop')) closeCareChat();
    if (e.target === $('conciergeBackdrop')) closeConciergeModal();
  });

  // ==========================================================================
  // KEYBOARD NAVIGATION
  // ==========================================================================
  window.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      closeCareChat();
      closeConciergeModal();
    }
    if (e.key === 'Tab' && !$('careChatBackdrop').classList.contains('hidden')) {
      const elements = [...$('careChatDialog').querySelectorAll('button:not([disabled]), a[href], input:not([disabled])')];
      if (elements.length) {
        const first = elements[0], last = elements[elements.length - 1];
        if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
        else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
        else if (!elements.includes(document.activeElement)) { e.preventDefault(); first.focus(); }
      }
    }
    // Left/Right Arrow Slide Control when no modal or menu is open
    const modalOpen = !$('careChatBackdrop').classList.contains('hidden') ||
                      !$('conciergeBackdrop').classList.contains('hidden') ||
                      !!document.querySelector('dialog[open]');
    const tag = document.activeElement?.tagName;
    const inHeaderNav = document.activeElement?.closest?.('[data-site-header]');
    if (!modalOpen && !inHeaderNav && tag !== 'INPUT' && tag !== 'SELECT') {
      if (e.key === 'ArrowRight') nextSlide();
      if (e.key === 'ArrowLeft') prevSlide();
    }
  });

  initSlider();
}

const start = () => initHeroCinematic(document.querySelector('[data-hero-cinematic]'));
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', start, { once: true });
} else {
  start();
}
