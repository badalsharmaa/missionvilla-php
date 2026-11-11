/**
 * RESOURCES SECTION 05: FAQS (resources-faq.js)
 * Accordion expansion, category filtering, and keyword search.
 */

document.addEventListener('DOMContentLoaded', () => {
    const section = document.querySelector('[data-res-faq]');
    if (!section) return;

    const searchInput = section.querySelector('[data-faq-search]');
    const filterBtns = section.querySelectorAll('[data-faq-filter]');
    const resetBtn = section.querySelector('[data-faq-reset]');
    const emptyState = section.querySelector('[data-faq-empty]');
    const list = section.querySelector('[data-faq-list]');
    const items = section.querySelectorAll('[data-faq-item]');

    let currentCategory = 'All Questions';
    let searchQuery = '';

    function filterFaqs() {
        let visibleCount = 0;

        items.forEach((item) => {
            const cat = item.getAttribute('data-faq-category');
            const haystack = item.getAttribute('data-faq-haystack') || '';

            const matchesCat = (currentCategory === 'All Questions' || cat === currentCategory);
            const matchesSearch = !searchQuery || haystack.includes(searchQuery);

            if (matchesCat && matchesSearch) {
                item.hidden = false;
                visibleCount++;
            } else {
                item.hidden = true;
            }
        });

        if (visibleCount === 0) {
            if (emptyState) emptyState.hidden = false;
            if (list) list.hidden = true;
        } else {
            if (emptyState) emptyState.hidden = true;
            if (list) list.hidden = false;
        }
    }

    // Accordion Toggle
    items.forEach((item) => {
        const toggleBtn = item.querySelector('[data-faq-toggle]');
        const answerBox = item.querySelector('[data-faq-answer]');
        const chevron = item.querySelector('.res-faq__chevron');

        if (toggleBtn && answerBox) {
            toggleBtn.addEventListener('click', () => {
                const isOpen = !answerBox.hidden;
                answerBox.hidden = isOpen;
                toggleBtn.setAttribute('aria-expanded', !isOpen ? 'true' : 'false');
                if (chevron) {
                    chevron.classList.toggle('res-faq__chevron--open', !isOpen);
                }
            });
        }
    });

    // Category button click
    filterBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
            currentCategory = btn.getAttribute('data-faq-filter');
            filterBtns.forEach((b) => {
                const isActive = (b === btn);
                b.classList.toggle('res-faq__cat-btn--active', isActive);
            });
            filterFaqs();
        });
    });

    // Search input
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            searchQuery = (e.target.value || '').trim().toLowerCase();
            filterFaqs();
        });
    }

    // Reset button
    if (resetBtn) {
        resetBtn.addEventListener('click', () => {
            currentCategory = 'All Questions';
            searchQuery = '';
            if (searchInput) searchInput.value = '';

            filterBtns.forEach((b, idx) => {
                b.classList.toggle('res-faq__cat-btn--active', idx === 0);
            });

            filterFaqs();
        });
    }
});
