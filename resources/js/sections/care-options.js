/**
 * Homepage section 02 · Care Options: flip cards.
 *
 * - Fine pointers (mouse/trackpad): hovering a card flips it after a short
 *   intent delay; leaving flips it back.
 * - Everyone: the corner toggle (keyboard, mouse, touch) pins a card open or
 *   closed. On touch devices, tapping the card body also toggles it.
 * - Escape returns a flipped card to its front face.
 * - The hidden face is `inert`, so it can never take focus or clicks.
 * Each card keeps its own state, so both can be open independently.
 * No scroll-triggered or automatic motion.
 */
const HOVER_INTENT_MS = 90;

function initCard(card, finePointer) {
  const toggle = card.querySelector('[data-care-toggle]');
  const front = card.querySelector('[data-face="front"]');
  const back = card.querySelector('[data-face="back"]');
  if (!toggle || !front || !back) return;

  let pinned = false;    // opened via toggle/tap/keyboard
  let hovered = false;   // pointer currently over the card (fine pointers only)
  let suppress = false;  // user closed it while hovering; stay closed until the pointer leaves
  let hoverTimer = 0;

  const isFlipped = () => card.dataset.flipped === 'true';

  function render() {
    const keepForFocus = isFlipped() && back.contains(document.activeElement);
    const flipped = pinned || keepForFocus || (hovered && !suppress && finePointer.matches);
    if (flipped === isFlipped()) return;
    card.dataset.flipped = String(flipped);
    front.inert = flipped;
    back.inert = !flipped;
    toggle.setAttribute('aria-pressed', String(flipped));
    toggle.setAttribute('aria-label', flipped ? toggle.dataset.labelHide : toggle.dataset.labelShow);
  }

  function setOpen(open) {
    pinned = open;
    suppress = !open && hovered;
    render();
  }

  toggle.hidden = false;
  toggle.addEventListener('click', () => setOpen(!isFlipped()));

  card.addEventListener('pointerenter', (e) => {
    if (e.pointerType !== 'mouse') return;
    clearTimeout(hoverTimer);
    hoverTimer = setTimeout(() => { hovered = true; render(); }, HOVER_INTENT_MS);
  });
  card.addEventListener('pointerleave', (e) => {
    if (e.pointerType !== 'mouse') return;
    clearTimeout(hoverTimer);
    hovered = false;
    suppress = false;
    render();
  });

  // Touch / coarse pointers: tap anywhere on the card that is not a link or button.
  card.addEventListener('click', (e) => {
    if (finePointer.matches || e.target.closest('a, button')) return;
    setOpen(!isFlipped());
  });

  card.addEventListener('keydown', (e) => {
    if (e.key !== 'Escape' || !isFlipped()) return;
    toggle.focus(); // move focus off the face before it turns inert
    pinned = false;
    suppress = hovered;
    render();
  });
}

function initCareOptions() {
  const root = document.querySelector('[data-care-options]');
  if (!root) return;

  const finePointer = window.matchMedia('(hover: hover) and (pointer: fine)');
  root.querySelectorAll('[data-care-card]').forEach((card) => initCard(card, finePointer));

  // Schedule a Visit is a [data-inquiry] link: the shared inquiry modal handles it.

  // Care Guide: the hero's delegated [data-hero-action] handler opens the
  // dialog. Only reveal the link when that dialog exists on the page.
  const guide = root.querySelector('[data-care-guide]');
  if (guide && document.getElementById('careChatBackdrop')) guide.hidden = false;
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initCareOptions);
} else {
  initCareOptions();
}
