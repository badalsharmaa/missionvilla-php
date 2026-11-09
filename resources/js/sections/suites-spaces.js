/**
 * Homepage section 05 · Suites & Living Spaces.
 *
 * WAI-ARIA tabs: click / Enter / Space select an option; ←/→ (and ↑/↓),
 * Home and End move between options and select them. Selecting swaps which
 * panel is visible (CSS cross-fade; instant with reduced motion). All panels
 * share one grid cell, so the frame keeps its size. Inactive panels are
 * `inert`. No automatic cycling and no scroll-driven behaviour.
 */
function initSuites(root) {
  const tabs = [...root.querySelectorAll('[data-ss-tab]')];
  const panels = tabs.map((t) => document.getElementById(t.getAttribute('aria-controls')));
  if (!tabs.length || panels.some((p) => !p)) return;

  function select(index, { focus = false } = {}) {
    tabs.forEach((tab, i) => {
      const on = i === index;
      tab.setAttribute('aria-selected', on ? 'true' : 'false');
      tab.tabIndex = on ? 0 : -1;
      panels[i].dataset.active = on ? 'true' : 'false';
      panels[i].inert = !on;
    });
    if (focus) tabs[index].focus();
  }

  tabs.forEach((tab, i) => {
    tab.addEventListener('click', () => select(i));
    tab.addEventListener('keydown', (e) => {
      const last = tabs.length - 1;
      const next = { ArrowRight: i + 1, ArrowDown: i + 1, ArrowLeft: i - 1, ArrowUp: i - 1, Home: 0, End: last }[e.key];
      if (next === undefined) return;
      e.preventDefault();
      select((next + tabs.length) % tabs.length, { focus: true });
    });
  });
}

function boot() {
  document.querySelectorAll('[data-suites]').forEach(initSuites);
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', boot, { once: true });
} else {
  boot();
}
