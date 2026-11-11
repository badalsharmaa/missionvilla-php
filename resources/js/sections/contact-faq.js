/**
 * Contact Section 06: Contact, Visit & Accessibility FAQs.
 *
 * Implements searchable, filterable accordions with expand/collapse-all controls
 * and zero-results reset state.
 */

document.addEventListener('DOMContentLoaded', () => {
    initContactFaq();
});

function initContactFaq() {
    const section = document.querySelector('[data-contact-faq]');
    if (!section) return;

    const searchInput = section.querySelector('[data-faq-search]');
    const categoryPills = section.querySelectorAll('[data-faq-category]');
    const items = section.querySelectorAll('[data-faq-item]');
    const countEl = section.querySelector('[data-faq-count]');
    const emptyState = section.querySelector('[data-faq-empty]');
    const resetBtn = section.querySelector('[data-faq-reset]');
    const expandAllBtn = section.querySelector('[data-faq-expand-all]');
    const collapseAllBtn = section.querySelector('[data-faq-collapse-all]');

    let activeCategory = 'All Questions';
    let searchQuery = '';

    function filterItems() {
        const query = searchQuery.toLowerCase().trim();
        let visibleCount = 0;

        items.forEach((item) => {
            const itemCat = item.getAttribute('data-faq-cat');
            const searchable = item.getAttribute('data-faq-searchable') || '';

            const matchesCategory = activeCategory === 'All Questions' || itemCat === activeCategory;
            const matchesSearch = !query || searchable.includes(query);

            const isVisible = matchesCategory && matchesSearch;
            item.hidden = !isVisible;

            if (isVisible) {
                visibleCount++;
            }
        });

        if (countEl) {
            countEl.textContent = visibleCount.toString();
        }

        if (emptyState) {
            emptyState.hidden = visibleCount > 0;
        }
    }

    // Category pills
    categoryPills.forEach((pill) => {
        pill.addEventListener('click', () => {
            activeCategory = pill.getAttribute('data-faq-category') || 'All Questions';
            categoryPills.forEach((p) => p.classList.remove('contact-faq__pill--active'));
            pill.classList.add('contact-faq__pill--active');
            filterItems();
        });
    });

    // Search input
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            searchQuery = searchInput.value;
            filterItems();
        });
    }

    // Reset button
    if (resetBtn) {
        resetBtn.addEventListener('click', () => {
            activeCategory = 'All Questions';
            searchQuery = '';
            if (searchInput) searchInput.value = '';

            categoryPills.forEach((p) => {
                p.classList.toggle('contact-faq__pill--active', p.getAttribute('data-faq-category') === 'All Questions');
            });
            filterItems();
        });
    }

    // Individual accordion triggers
    items.forEach((item) => {
        const trigger = item.querySelector('[data-faq-trigger]');
        const panel = item.querySelector('.contact-faq__answer-panel');
        const chevron = item.querySelector('.contact-faq__chevron');

        if (trigger && panel) {
            trigger.addEventListener('click', () => {
                const isOpen = trigger.getAttribute('aria-expanded') === 'true';
                trigger.setAttribute('aria-expanded', isOpen ? 'false' : 'true');
                panel.hidden = isOpen;
                if (chevron) {
                    chevron.classList.toggle('contact-faq__chevron--open', !isOpen);
                }
            });
        }
    });

    // Expand All
    if (expandAllBtn) {
        expandAllBtn.addEventListener('click', () => {
            items.forEach((item) => {
                if (!item.hidden) {
                    const trigger = item.querySelector('[data-faq-trigger]');
                    const panel = item.querySelector('.contact-faq__answer-panel');
                    const chevron = item.querySelector('.contact-faq__chevron');
                    if (trigger && panel) {
                        trigger.setAttribute('aria-expanded', 'true');
                        panel.hidden = false;
                        if (chevron) chevron.classList.add('contact-faq__chevron--open');
                    }
                }
            });
        });
    }

    // Collapse All
    if (collapseAllBtn) {
        collapseAllBtn.addEventListener('click', () => {
            items.forEach((item) => {
                const trigger = item.querySelector('[data-faq-trigger]');
                const panel = item.querySelector('.contact-faq__answer-panel');
                const chevron = item.querySelector('.contact-faq__chevron');
                if (trigger && panel) {
                    trigger.setAttribute('aria-expanded', 'false');
                    panel.hidden = true;
                    if (chevron) chevron.classList.remove('contact-faq__chevron--open');
                }
            });
        });
    }
}
