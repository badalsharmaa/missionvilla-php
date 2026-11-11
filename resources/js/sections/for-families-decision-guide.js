/**
 * For Families Decision Guide Controller.
 * Handles reflection pathway tab switching.
 */
document.addEventListener('DOMContentLoaded', () => {
    const guideSection = document.querySelector('[data-ff-guide]');
    if (!guideSection) return;

    const tabs = Array.from(guideSection.querySelectorAll('[data-pathway-tab]'));
    const panels = Array.from(guideSection.querySelectorAll('[data-pathway-panel]'));

    function selectPathway(pathwayId) {
        tabs.forEach(tab => {
            const isMatch = tab.getAttribute('data-pathway-tab') === pathwayId;
            tab.classList.toggle('ff-guide__pathway-btn--active', isMatch);
            tab.setAttribute('aria-selected', isMatch ? 'true' : 'false');
        });

        panels.forEach(panel => {
            const isMatch = panel.getAttribute('data-pathway-panel') === pathwayId;
            panel.classList.toggle('ff-guide__panel--active', isMatch);
            if (isMatch) {
                panel.removeAttribute('hidden');
            } else {
                panel.setAttribute('hidden', '');
            }
        });
    }

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const id = tab.getAttribute('data-pathway-tab');
            selectPathway(id);
        });
    });
});
