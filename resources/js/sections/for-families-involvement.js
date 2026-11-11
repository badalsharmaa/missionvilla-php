/**
 * For Families · Section 04: Family Involvement & Personalization
 * Handles chapter tab switching with accessible keyboard navigation
 */
document.addEventListener('DOMContentLoaded', () => {
    const section = document.querySelector('[data-ff-inv]');
    if (!section) return;

    const tabs = Array.from(section.querySelectorAll('[data-inv-tab]'));
    const panels = Array.from(section.querySelectorAll('[data-inv-panel]'));

    function selectTab(id) {
        tabs.forEach((tab) => {
            const matches = tab.getAttribute('data-inv-tab') === id;
            tab.setAttribute('aria-selected', matches ? 'true' : 'false');
            tab.classList.toggle('ff-inv__tab--active', matches);
        });

        panels.forEach((panel) => {
            const matches = panel.getAttribute('data-inv-panel') === id;
            panel.classList.toggle('ff-inv__panel--active', matches);
            if (matches) {
                panel.removeAttribute('hidden');
            } else {
                panel.setAttribute('hidden', '');
            }
        });
    }

    tabs.forEach((tab, index) => {
        tab.addEventListener('click', () => {
            const targetId = tab.getAttribute('data-inv-tab');
            if (targetId) selectTab(targetId);
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
                tabs[nextIndex].focus();
                const targetId = tabs[nextIndex].getAttribute('data-inv-tab');
                if (targetId) selectTab(targetId);
            }
        });
    });
});
