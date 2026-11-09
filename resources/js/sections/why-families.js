/**
 * Homepage section 04 · Why Families Choose Mission Villa.
 *
 * The section is static. The only script reuses the hero's existing
 * Schedule a Visit dialog (window.MissionVilla.openVisit) when the page has
 * one; otherwise the link follows its href. "Take a Quick Tour" is a plain
 * on-page anchor to the Section 03 gallery.
 */
function initWhyFamilies() {
  const root = document.querySelector('[data-why-families]');
  if (!root) return;

  root.querySelector('[data-wf-visit]')?.addEventListener('click', (e) => {
    const openVisit = window.MissionVilla?.openVisit;
    if (typeof openVisit !== 'function') return;
    e.preventDefault();
    openVisit();
  });

  // If the tour points at an on-page section that is disabled, hide the link rather than leave a dead anchor.
  const tour = root.querySelector('[data-wf-tour]');
  const target = tour?.getAttribute('href') || '';
  if (tour && target.startsWith('#') && !document.getElementById(target.slice(1))) tour.hidden = true;
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initWhyFamilies, { once: true });
} else {
  initWhyFamilies();
}
