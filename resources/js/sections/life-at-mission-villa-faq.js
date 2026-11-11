/**
 * Life at Mission Villa FAQ Accordion Controller
 */
document.addEventListener('DOMContentLoaded', () => {
    const faqSection = document.querySelector('[data-lmv-faq]');
    if (!faqSection) return;

    const items = faqSection.querySelectorAll('[data-faq-item]');

    items.forEach((item) => {
        const trigger = item.querySelector('.lmv-faq__trigger');
        const panel = item.querySelector('.lmv-faq__panel');
        if (!trigger || !panel) return;

        trigger.addEventListener('click', () => {
            const isExpanded = trigger.getAttribute('aria-expanded') === 'true';

            items.forEach((otherItem) => {
                const otherTrigger = otherItem.querySelector('.lmv-faq__trigger');
                const otherPanel = otherItem.querySelector('.lmv-faq__panel');
                if (otherTrigger && otherPanel && otherItem !== item) {
                    otherTrigger.setAttribute('aria-expanded', 'false');
                    otherPanel.setAttribute('hidden', '');
                    otherPanel.classList.remove('is-open');
                }
            });

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
