/**
 * Financial Planning Section 03: Grouped Inclusions Filter
 * Handles category filtering with live visible counting.
 */
document.addEventListener('DOMContentLoaded', () => {
    const section = document.querySelector('[data-fp-inc]');
    if (!section) return;

    const filterBtns = Array.from(section.querySelectorAll('[data-inc-filter]'));
    const cards = Array.from(section.querySelectorAll('[data-inc-card]'));
    const visibleCountSpan = section.querySelector('[data-inc-visible-count]');

    filterBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
            const selectedGroup = btn.getAttribute('data-inc-filter');
            if (!selectedGroup) return;

            filterBtns.forEach((b) => {
                const isCurrent = b === btn;
                b.setAttribute('aria-selected', isCurrent ? 'true' : 'false');
                b.classList.toggle('fp-inc__cat-btn--active', isCurrent);
            });

            let visibleCount = 0;
            cards.forEach((card) => {
                const cardGroup = card.getAttribute('data-inc-group');
                const matches = selectedGroup === 'All Categories' || selectedGroup === cardGroup;

                if (matches) {
                    card.removeAttribute('hidden');
                    visibleCount++;
                } else {
                    card.setAttribute('hidden', '');
                }
            });

            if (visibleCountSpan) {
                visibleCountSpan.textContent = String(visibleCount);
            }
        });
    });
});
