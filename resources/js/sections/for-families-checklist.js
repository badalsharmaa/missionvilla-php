/**
 * For Families Tour Notebook Checklist Controller.
 * Manages question selection, theme filtering, counters, and inquiry form note integration.
 */
document.addEventListener('DOMContentLoaded', () => {
    const checkSection = document.querySelector('[data-ff-check]');
    if (!checkSection) return;

    const cards = Array.from(checkSection.querySelectorAll('[data-q-card]'));
    const filterBtns = Array.from(checkSection.querySelectorAll('[data-check-filter]'));
    const countDisplay = checkSection.querySelector('[data-selected-count]');
    const countBtnDisplay = checkSection.querySelector('[data-selected-count-btn]');
    const selectAllBtn = checkSection.querySelector('[data-check-select-all]');
    const clearBtn = checkSection.querySelector('[data-check-clear]');
    const submitBtn = checkSection.querySelector('[data-check-submit]');

    let selectedIds = ['vq-legacies-story', 'vq-suite-formats', 'vq-cost-inclusions'];

    function updateState() {
        cards.forEach(card => {
            const id = card.getAttribute('data-q-card');
            const isSelected = selectedIds.includes(id);
            card.classList.toggle('ff-check__card--selected', isSelected);

            const toggleBtn = card.querySelector('[data-q-toggle]');
            if (toggleBtn) {
                toggleBtn.setAttribute('aria-pressed', isSelected ? 'true' : 'false');
                const label = toggleBtn.querySelector('.ff-check__toggle-label');
                if (label) {
                    label.textContent = isSelected ? 'In Your Tour List' : 'Add to Tour List';
                }
            }
        });

        const count = selectedIds.length;
        if (countDisplay) countDisplay.textContent = count;
        if (countBtnDisplay) countBtnDisplay.textContent = count;

        if (submitBtn) {
            const selectedCards = cards.filter(c => selectedIds.includes(c.getAttribute('data-q-card')));
            const questionSummaries = selectedCards.map(c => {
                const code = c.querySelector('.ff-check__card-code')?.textContent.trim() || '';
                const q = c.querySelector('.ff-check__card-question')?.textContent.trim() || '';
                return `${code}: ${q}`;
            }).join(' | ');

            const noteText = count > 0
                ? `Questions selected for our visit: ${questionSummaries}`
                : 'Would like to schedule a visit and review questions on care and suites.';

            submitBtn.setAttribute('data-note', noteText);
        }
    }

    // Toggle card selection
    cards.forEach(card => {
        const toggleBtn = card.querySelector('[data-q-toggle]');
        if (toggleBtn) {
            toggleBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                const id = card.getAttribute('data-q-card');
                if (selectedIds.includes(id)) {
                    selectedIds = selectedIds.filter(item => item !== id);
                } else {
                    selectedIds.push(id);
                }
                updateState();
            });
        }
    });

    // Theme filtering
    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const theme = btn.getAttribute('data-check-filter');

            filterBtns.forEach(b => {
                const isMatch = b === btn;
                b.classList.toggle('ff-check__theme-btn--active', isMatch);
            });

            cards.forEach(card => {
                const cardTheme = card.getAttribute('data-q-theme');
                const isVisible = theme === 'All Themes' || cardTheme === theme;
                if (isVisible) {
                    card.removeAttribute('data-hidden');
                } else {
                    card.setAttribute('data-hidden', 'true');
                }
            });
        });
    });

    // Select All
    if (selectAllBtn) {
        selectAllBtn.addEventListener('click', () => {
            selectedIds = cards.map(c => c.getAttribute('data-q-card'));
            updateState();
        });
    }

    // Clear
    if (clearBtn) {
        clearBtn.addEventListener('click', () => {
            selectedIds = [];
            updateState();
        });
    }

    // Initial state setup
    updateState();
});
