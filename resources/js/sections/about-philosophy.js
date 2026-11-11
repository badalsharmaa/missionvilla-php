/**
 * Care Philosophy Tab Controller.
 * WAI-ARIA tab pattern with keyboard navigation (ArrowLeft/ArrowRight/Home/End).
 */
document.addEventListener('DOMContentLoaded', () => {
    const philSection = document.querySelector('[data-about-phil]');
    if (!philSection) return;

    const tabs = Array.from(philSection.querySelectorAll('[data-phil-tab]'));
    const panels = Array.from(philSection.querySelectorAll('[data-phil-panel]'));

    function activateTab(tab, setFocus = true) {
        const targetId = tab.getAttribute('data-phil-tab');

        tabs.forEach(t => {
            const isMatch = t === tab;
            t.classList.toggle('about-phil__tab--active', isMatch);
            t.setAttribute('aria-selected', isMatch ? 'true' : 'false');
            t.setAttribute('tabindex', isMatch ? '0' : '-1');
            if (isMatch && setFocus) {
                t.focus();
            }
        });

        panels.forEach(p => {
            const isMatch = p.getAttribute('data-phil-panel') === targetId;
            p.classList.toggle('about-phil__panel--active', isMatch);
            if (isMatch) {
                p.removeAttribute('hidden');
            } else {
                p.setAttribute('hidden', '');
            }
        });
    }

    tabs.forEach((tab, index) => {
        tab.addEventListener('click', () => {
            activateTab(tab, false);
        });

        tab.addEventListener('keydown', (e) => {
            let nextIndex = null;
            if (e.key === 'ArrowRight') {
                nextIndex = (index + 1) % tabs.length;
            } else if (e.key === 'ArrowLeft') {
                nextIndex = (index - 1 + tabs.length) % tabs.length;
            } else if (e.key === 'Home') {
                nextIndex = 0;
            } else if (e.key === 'End') {
                nextIndex = tabs.length - 1;
            }

            if (nextIndex !== null) {
                e.preventDefault();
                activateTab(tabs[nextIndex], true);
            }
        });
    });
});
