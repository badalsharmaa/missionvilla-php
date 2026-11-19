/**
 * Homepage section 02 · Care Options: flip cards.
 *
 * - User-initiated flip only (no auto-flip on hover per design standard & user preference).
 * - Clicking the corner toggle or card body toggles between front and detail face.
 * - Escape returns a flipped card to its front face.
 * - The hidden face is `inert`, so it can never take focus or clicks.
 * Each card keeps its own state, so both can be open independently.
 */
function initCard(card) {
  const toggle = card.querySelector('[data-care-toggle]');
  const front = card.querySelector('[data-face="front"]');
  const back = card.querySelector('[data-face="back"]');
  if (!toggle || !front || !back) return;

  let pinned = false; // opened via toggle/click

  const isFlipped = () => card.dataset.flipped === 'true';

  function render() {
    const keepForFocus = isFlipped() && back.contains(document.activeElement);
    const flipped = pinned || keepForFocus;
    if (flipped === isFlipped()) return;
    card.dataset.flipped = String(flipped);
    front.inert = flipped;
    back.inert = !flipped;
    toggle.setAttribute('aria-pressed', String(flipped));
    toggle.setAttribute('aria-label', flipped ? toggle.dataset.labelHide : toggle.dataset.labelShow);
  }

  function setOpen(open) {
    pinned = open;
    render();
  }

  toggle.hidden = false;
  toggle.addEventListener('click', (e) => {
    e.stopPropagation();
    setOpen(!isFlipped());
  });

  // User-initiated click on card body (outside direct link clicks)
  card.addEventListener('click', (e) => {
    if (e.target.closest('a, button')) return;
    setOpen(!isFlipped());
  });

  card.addEventListener('keydown', (e) => {
    if (e.key !== 'Escape' || !isFlipped()) return;
    toggle.focus(); // move focus off the face before it turns inert
    pinned = false;
    render();
  });
}

function initCareOptions() {
  const root = document.querySelector('[data-care-options]');
  if (!root) return;

  root.querySelectorAll('[data-care-card]').forEach(initCard);

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
