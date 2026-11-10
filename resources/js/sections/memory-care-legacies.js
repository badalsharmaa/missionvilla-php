/**
 * Memory Care Section 02: The Legacies™ Difference.
 *
 * ARIA tabs with roving tabindex, keyboard support (arrows, Home, End),
 * and inert state on inactive panels.
 */
function initLegaciesSelector(section) {
  const tabs = Array.from(section.querySelectorAll('[data-mc-tab]'));
  const panels = Array.from(section.querySelectorAll('[data-mc-panel]'));

  if (!tabs.length || !panels.length) return;

  function selectTab(targetId, moveFocus = false) {
    tabs.forEach((tab) => {
      const isSelected = tab.dataset.mcTab === targetId;
      tab.setAttribute('aria-selected', isSelected ? 'true' : 'false');
      tab.setAttribute('tabindex', isSelected ? '0' : '-1');
      tab.classList.toggle('is-active', isSelected);
      if (isSelected && moveFocus) {
        tab.focus();
      }
    });

    panels.forEach((panel) => {
      const isActive = panel.dataset.mcPanel === targetId;
      panel.classList.toggle('is-active', isActive);
      if (isActive) {
        panel.removeAttribute('inert');
      } else {
        panel.setAttribute('inert', '');
      }
    });
  }

  tabs.forEach((tab, index) => {
    tab.addEventListener('click', () => {
      selectTab(tab.dataset.mcTab);
    });

    tab.addEventListener('keydown', (e) => {
      let targetIndex = null;
      if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
        targetIndex = (index + 1) % tabs.length;
      } else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
        targetIndex = (index - 1 + tabs.length) % tabs.length;
      } else if (e.key === 'Home') {
        targetIndex = 0;
      } else if (e.key === 'End') {
        targetIndex = tabs.length - 1;
      }

      if (targetIndex !== null) {
        e.preventDefault();
        selectTab(tabs[targetIndex].dataset.mcTab, true);
      }
    });
  });
}

function boot() {
  document.querySelectorAll('[data-mc-legacies]').forEach(initLegaciesSelector);
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', boot, { once: true });
} else {
  boot();
}
