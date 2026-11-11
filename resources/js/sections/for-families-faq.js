/**
 * For Families Section 05: Grouped FAQs Interactivity
 * Handles category filtering, live keyword search, expand/collapse all, and accordion toggling.
 */
document.addEventListener('DOMContentLoaded', () => {
    const section = document.querySelector('[data-ff-faq]');
    if (!section) return;

    let activeCategory = 'All Topics';
    let searchQuery = '';

    const filterBtns = Array.from(section.querySelectorAll('[data-faq-filter]'));
    const searchInput = section.querySelector('[data-faq-search-input]');
    const searchClearBtn = section.querySelector('[data-faq-search-clear]');
    const visibleCountSpan = section.querySelector('[data-faq-visible-count]');
    const emptyState = section.querySelector('[data-faq-empty]');
    const emptyQuerySpan = section.querySelector('[data-faq-empty-query]');
    const emptyCatSpan = section.querySelector('[data-faq-empty-cat]');
    const groupsContainer = section.querySelector('[data-faq-groups]');
    const groupElements = Array.from(section.querySelectorAll('[data-faq-group]'));
    const items = Array.from(section.querySelectorAll('[data-faq-item]'));

    // Accordion toggle handler
    items.forEach((item) => {
        const toggleBtn = item.querySelector('[data-faq-toggle]');
        const panel = item.querySelector('.ff-faq__answer-panel');
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

    // Expand visible / Collapse all
    const expandAllBtn = section.querySelector('[data-faq-action="expand-all"]');
    const collapseAllBtn = section.querySelector('[data-faq-action="collapse-all"]');
    const resetBtn = section.querySelector('[data-faq-action="reset-filters"]');

    if (expandAllBtn) {
        expandAllBtn.addEventListener('click', () => {
            items.forEach((item) => {
                if (!item.hasAttribute('hidden')) {
                    const btn = item.querySelector('[data-faq-toggle]');
                    const panel = item.querySelector('.ff-faq__answer-panel');
                    if (btn && panel) {
                        btn.setAttribute('aria-expanded', 'true');
                        panel.removeAttribute('hidden');
                    }
                }
            });
        });
    }

    if (collapseAllBtn) {
        collapseAllBtn.addEventListener('click', () => {
            items.forEach((item) => {
                const btn = item.querySelector('[data-faq-toggle]');
                const panel = item.querySelector('.ff-faq__answer-panel');
                if (btn && panel) {
                    btn.setAttribute('aria-expanded', 'false');
                    panel.setAttribute('hidden', '');
                }
            });
        });
    }

    function applyFilters() {
        const query = searchQuery.trim().toLowerCase();
        let totalVisible = 0;

        const groupCounts = { Care: 0, Suites: 0, Cost: 0, Visits: 0 };

        items.forEach((item) => {
            const cat = item.getAttribute('data-faq-category') || '';
            const qText = item.getAttribute('data-faq-question') || '';
            const aText = item.getAttribute('data-faq-answer') || '';
            const cText = item.getAttribute('data-faq-code') || '';

            const matchesCategory = activeCategory === 'All Topics' || activeCategory === cat;
            const matchesQuery = !query || qText.includes(query) || aText.includes(query) || cText.includes(query);

            if (matchesCategory && matchesQuery) {
                item.removeAttribute('hidden');
                totalVisible++;
                if (groupCounts[cat] !== undefined) {
                    groupCounts[cat]++;
                }
            } else {
                item.setAttribute('hidden', '');
            }
        });

        // Update group visibility & counters
        groupElements.forEach((groupEl) => {
            const groupName = groupEl.getAttribute('data-faq-group');
            const count = groupCounts[groupName] || 0;
            const numSpan = groupEl.querySelector(`[data-faq-group-num="${groupName}"]`);
            if (numSpan) numSpan.textContent = String(count);

            const isGroupSelected = activeCategory === 'All Topics' || activeCategory === groupName;
            if (isGroupSelected && count > 0) {
                groupEl.removeAttribute('hidden');
            } else {
                groupEl.setAttribute('hidden', '');
            }
        });

        if (visibleCountSpan) {
            visibleCountSpan.textContent = String(totalVisible);
        }

        // Empty state
        if (totalVisible === 0) {
            if (groupsContainer) groupsContainer.setAttribute('hidden', '');
            if (emptyState) {
                emptyState.removeAttribute('hidden');
                if (emptyQuerySpan) emptyQuerySpan.textContent = query ? `“${searchQuery}”` : '';
                if (emptyCatSpan) emptyCatSpan.textContent = activeCategory;
            }
        } else {
            if (groupsContainer) groupsContainer.removeAttribute('hidden');
            if (emptyState) emptyState.setAttribute('hidden', '');
        }
    }

    // Category filter tabs
    filterBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
            const category = btn.getAttribute('data-faq-filter');
            if (!category) return;
            activeCategory = category;

            filterBtns.forEach((b) => {
                const matches = b === btn;
                b.setAttribute('aria-selected', matches ? 'true' : 'false');
                b.classList.toggle('ff-faq__cat-btn--active', matches);
            });

            applyFilters();
        });
    });

    // Search input
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            searchQuery = e.target.value;
            if (searchClearBtn) {
                if (searchQuery.length > 0) {
                    searchClearBtn.removeAttribute('hidden');
                } else {
                    searchClearBtn.setAttribute('hidden', '');
                }
            }
            applyFilters();
        });
    }

    if (searchClearBtn) {
        searchClearBtn.addEventListener('click', () => {
            searchQuery = '';
            if (searchInput) {
                searchInput.value = '';
                searchInput.focus();
            }
            searchClearBtn.setAttribute('hidden', '');
            applyFilters();
        });
    }

    if (resetBtn) {
        resetBtn.addEventListener('click', () => {
            activeCategory = 'All Topics';
            searchQuery = '';
            if (searchInput) searchInput.value = '';
            if (searchClearBtn) searchClearBtn.setAttribute('hidden', '');

            filterBtns.forEach((b) => {
                const isAll = b.getAttribute('data-faq-filter') === 'All Topics';
                b.setAttribute('aria-selected', isAll ? 'true' : 'false');
                b.classList.toggle('ff-faq__cat-btn--active', isAll);
            });

            applyFilters();
        });
    }
});
