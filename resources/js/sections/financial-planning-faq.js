/**
 * Financial Planning Section 06: FAQs Interactivity
 * Handles accordion item expand/collapse and expand all/collapse all.
 */
document.addEventListener('DOMContentLoaded', () => {
    const section = document.querySelector('[data-fp-faq]');
    if (!section) return;

    const items = Array.from(section.querySelectorAll('[data-faq-item]'));
    const expandAllBtn = section.querySelector('[data-faq-action="expand-all"]');
    const collapseAllBtn = section.querySelector('[data-faq-action="collapse-all"]');

    // Individual item toggle
    items.forEach((item) => {
        const toggleBtn = item.querySelector('[data-faq-toggle]');
        const panel = item.querySelector('.fp-faq__answer-panel');
        if (!toggleBtn || !panel) return;

        toggleBtn.addEventListener('click', () => {
            const isExpanded = toggleBtn.getAttribute('aria-expanded') === 'true';
            toggleBtn.setAttribute('aria-expanded', isExpanded ? 'false' : 'true');
            if (isExpanded) {
                panel.setAttribute('hidden', '');
            } else {
                panel.removeAttribute('hidden');
            }
        });
    });

    // Expand all
    if (expandAllBtn) {
        expandAllBtn.addEventListener('click', () => {
            items.forEach((item) => {
                const toggleBtn = item.querySelector('[data-faq-toggle]');
                const panel = item.querySelector('.fp-faq__answer-panel');
                if (toggleBtn && panel) {
                    toggleBtn.setAttribute('aria-expanded', 'true');
                    panel.removeAttribute('hidden');
                }
            });
        });
    }

    // Collapse all
    if (collapseAllBtn) {
        collapseAllBtn.addEventListener('click', () => {
            items.forEach((item) => {
                const toggleBtn = item.querySelector('[data-faq-toggle]');
                const panel = item.querySelector('.fp-faq__answer-panel');
                if (toggleBtn && panel) {
                    toggleBtn.setAttribute('aria-expanded', 'false');
                    panel.setAttribute('hidden', '');
                }
            });
        });
    }
});
