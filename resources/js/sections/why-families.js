/**
 * Homepage section 04 · Why Families Choose Mission Villa.
 *
 * The section is static. Schedule a Visit is a [data-inquiry] link handled by
 * the shared inquiry modal. "Take a Quick Tour" is a plain on-page anchor to
 * the Section 03 gallery (not a form, so it may scroll).
 */
function initWhyFamilies() {
  const root = document.querySelector('[data-why-families]');
  if (!root) return;

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
