/**
 * RESOURCES SECTION 02: FAMILY RESOURCE DESK (resources-desk.js)
 * Synchronized filtering, searching, and spotlight reader switching.
 */

document.addEventListener('DOMContentLoaded', () => {
    const section = document.querySelector('[data-res-desk]');
    if (!section) return;

    const searchInput = section.querySelector('[data-desk-search]');
    const filterBtns = section.querySelectorAll('[data-desk-filter]');
    const resetBtn = section.querySelector('[data-desk-reset]');
    const showAllBtn = section.querySelector('[data-desk-show-all]');
    const emptyState = section.querySelector('[data-desk-empty]');
    const contentGrid = section.querySelector('[data-desk-content]');
    const cards = section.querySelectorAll('[data-desk-item]');
    const readers = section.querySelectorAll('[data-desk-reader]');

    let currentCategory = 'All Resources';
    let searchQuery = '';

    function filterItems() {
        let visibleCount = 0;
        let firstVisibleCard = null;

        cards.forEach((card) => {
            const cat = card.getAttribute('data-desk-category');
            const haystack = card.getAttribute('data-desk-haystack') || '';

            const matchesCat = (currentCategory === 'All Resources' || cat === currentCategory);
            const matchesSearch = !searchQuery || haystack.includes(searchQuery);

            if (matchesCat && matchesSearch) {
                card.hidden = false;
                visibleCount++;
                if (!firstVisibleCard) {
                    firstVisibleCard = card;
                }
            } else {
                card.hidden = true;
            }
        });

        // Show/hide reset button
        if (resetBtn) {
            resetBtn.hidden = (currentCategory === 'All Resources' && searchQuery === '');
        }

        // Show empty state or activate reader
        if (visibleCount === 0) {
            if (emptyState) emptyState.hidden = false;
            if (contentGrid) contentGrid.hidden = true;
        } else {
            if (emptyState) emptyState.hidden = true;
            if (contentGrid) contentGrid.hidden = false;

            // Check if current active card is still visible
            const currentSelected = Array.from(cards).find((c) => c.classList.contains('res-desk__card--selected') && !c.hidden);
            if (!currentSelected && firstVisibleCard) {
                activateItem(firstVisibleCard.getAttribute('data-desk-item'));
            }
        }
    }

    function activateItem(id) {
        cards.forEach((c) => {
            const isMatch = (c.getAttribute('data-desk-item') === id);
            c.classList.toggle('res-desk__card--selected', isMatch);
        });

        readers.forEach((r) => {
            const isMatch = (r.getAttribute('data-desk-reader') === id);
            r.hidden = !isMatch;
            r.classList.toggle('res-desk__reader--active', isMatch);
        });
    }

    // Card click
    cards.forEach((card) => {
        card.addEventListener('click', () => {
            const id = card.getAttribute('data-desk-item');
            activateItem(id);
        });
    });

    // Category button click
    filterBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
            currentCategory = btn.getAttribute('data-desk-filter');
            filterBtns.forEach((b) => {
                const isActive = (b === btn);
                b.classList.toggle('res-desk__tab-btn--active', isActive);
                b.setAttribute('aria-selected', isActive ? 'true' : 'false');
            });
            filterItems();
        });
    });

    // Search input
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            searchQuery = (e.target.value || '').trim().toLowerCase();
            filterItems();
        });
    }

    // Reset buttons
    function resetAll() {
        currentCategory = 'All Resources';
        searchQuery = '';
        if (searchInput) searchInput.value = '';

        filterBtns.forEach((b, idx) => {
            const isActive = (idx === 0);
            b.classList.toggle('res-desk__tab-btn--active', isActive);
            b.setAttribute('aria-selected', isActive ? 'true' : 'false');
        });

        filterItems();
        if (cards[0]) {
            activateItem(cards[0].getAttribute('data-desk-item'));
        }
    }

    if (resetBtn) resetBtn.addEventListener('click', resetAll);
    if (showAllBtn) showAllBtn.addEventListener('click', resetAll);
});
