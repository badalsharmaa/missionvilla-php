/**
 * Suites & Floor Plans FAQ Accordion Controller
 * Handles accessible keyboard navigation and single-panel toggle.
 */
document.addEventListener('DOMContentLoaded', () => {
    const faqSection = document.querySelector('[data-sfp-faq]');
    if (!faqSection) return;

    const items = faqSection.querySelectorAll('[data-faq-item]');

    items.forEach((item) => {
        const trigger = item.querySelector('.sfp-faq__trigger');
        const panel = item.querySelector('.sfp-faq__panel');
        if (!trigger || !panel) return;

        trigger.addEventListener('click', () => {
            const isExpanded = trigger.getAttribute('aria-expanded') === 'true';

            // Close other panels (single open accordion)
            items.forEach((otherItem) => {
                const otherTrigger = otherItem.querySelector('.sfp-faq__trigger');
                const otherPanel = otherItem.querySelector('.sfp-faq__panel');
                if (otherTrigger && otherPanel && otherItem !== item) {
                    otherTrigger.setAttribute('aria-expanded', 'false');
                    otherPanel.setAttribute('hidden', '');
                    otherPanel.classList.remove('is-open');
                }
            });

            // Toggle current panel
            if (isExpanded) {
                trigger.setAttribute('aria-expanded', 'false');
                panel.setAttribute('hidden', '');
                panel.classList.remove('is-open');
            } else {
                trigger.setAttribute('aria-expanded', 'true');
                panel.removeAttribute('hidden');
                panel.classList.add('is-open');
            }
        });
    });
});
