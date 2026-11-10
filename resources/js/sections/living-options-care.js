/**
 * Living Options Section 02: Choose the Care That Fits Your Needs.
 *
 * Accessible ARIA tabs with roving tabindex, keyboard support (arrows, Home, End),
 * and inert state on inactive panels.
 */
function initCareSelector(section) {
  const tabs = Array.from(section.querySelectorAll('[data-care-tab]'));
  const panels = Array.from(section.querySelectorAll('[data-care-panel]'));

  if (!tabs.length || !panels.length) return;

  function selectTab(targetId, moveFocus = false) {
    tabs.forEach((tab) => {
      const isSelected = tab.dataset.careTab === targetId;
      tab.setAttribute('aria-selected', isSelected ? 'true' : 'false');
      tab.setAttribute('tabindex', isSelected ? '0' : '-1');
      tab.classList.toggle('is-active', isSelected);
      if (isSelected && moveFocus) {
        tab.focus();
      }
    });

    panels.forEach((panel) => {
      const isActive = panel.dataset.carePanel === targetId;
      panel.classList.toggle('is-active', isActive);
      if (isActive) {
        panel.removeAttribute('hidden');
        panel.removeAttribute('inert');
      } else {
        panel.setAttribute('hidden', '');
        panel.setAttribute('inert', '');
      }
    });
  }

  tabs.forEach((tab, index) => {
    tab.addEventListener('click', () => {
      selectTab(tab.dataset.careTab);
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
        selectTab(tabs[targetIndex].dataset.careTab, true);
      }
    });
  });
}

function boot() {
  document.querySelectorAll('[data-lo-care]').forEach(initCareSelector);
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', boot, { once: true });
} else {
  boot();
}
