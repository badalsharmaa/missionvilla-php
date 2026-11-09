/**
 * Homepage section 06 · Questions Families Often Ask.
 *
 * Accordion: at most one answer open. Each trigger is a real <button> with
 * aria-expanded / aria-controls; closed panels are `inert` and collapsed via
 * CSS (instant with reduced motion). Enter/Space toggle natively; ↑/↓, Home
 * and End move focus between questions. Without JavaScript the section is
 * never enhanced, so every answer stays visible.
 */
function initFaq(root) {
  const items = [...root.querySelectorAll('[data-faq-item]')];
  const triggers = items.map((item) => item.querySelector('[data-faq-trigger]'));
  const panels = items.map((item) => item.querySelector('[data-faq-panel]'));
  if (!items.length || triggers.some((t) => !t) || panels.some((p) => !p)) return;

  function setOpen(index) {
    items.forEach((item, i) => {
      const on = i === index;
      item.dataset.open = on ? 'true' : 'false';
      triggers[i].setAttribute('aria-expanded', on ? 'true' : 'false');
      panels[i].inert = !on;
    });
  }

  const initial = items.findIndex((item) => item.dataset.open === 'true');
  setOpen(initial);
  root.dataset.enhanced = 'true';

  triggers.forEach((trigger, i) => {
    trigger.addEventListener('click', () => {
      setOpen(items[i].dataset.open === 'true' ? -1 : i);
    });
    trigger.addEventListener('keydown', (e) => {
      const last = triggers.length - 1;
      const next = { ArrowDown: i + 1, ArrowUp: i - 1, Home: 0, End: last }[e.key];
      if (next === undefined) return;
      e.preventDefault();
      triggers[(next + triggers.length) % triggers.length].focus();
    });
  });
}

function boot() {
  document.querySelectorAll('[data-faq]').forEach(initFaq);
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', boot, { once: true });
} else {
  boot();
}
