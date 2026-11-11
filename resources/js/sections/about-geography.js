/**
 * Daly City & Peninsula Geography Interactive Controller.
 * Handles category filtering and active spotlight selection.
 */
document.addEventListener('DOMContentLoaded', () => {
    const geoSection = document.querySelector('[data-about-geo]');
    if (!geoSection) return;

    const filterBtns = Array.from(geoSection.querySelectorAll('[data-geo-filter]'));
    const items = Array.from(geoSection.querySelectorAll('[data-geo-item]'));
    const cards = Array.from(geoSection.querySelectorAll('[data-geo-card]'));

    function selectLandmark(landmarkId) {
        items.forEach(item => {
            const isMatch = item.getAttribute('data-geo-item') === landmarkId;
            item.classList.toggle('about-geo__item--active', isMatch);
            item.setAttribute('aria-pressed', isMatch ? 'true' : 'false');
        });

        cards.forEach(card => {
            const isMatch = card.getAttribute('data-geo-card') === landmarkId;
            card.classList.toggle('about-geo__card--active', isMatch);
            if (isMatch) {
                card.removeAttribute('hidden');
            } else {
                card.setAttribute('hidden', '');
            }
        });
    }

    function filterCategory(categoryName) {
        filterBtns.forEach(btn => {
            const isMatch = btn.getAttribute('data-geo-filter') === categoryName;
            btn.classList.toggle('about-geo__filter-btn--active', isMatch);
        });

        let firstVisibleId = null;

        items.forEach(item => {
            const itemCat = item.getAttribute('data-geo-category');
            const visible = categoryName === 'All Landmarks' || itemCat === categoryName;

            if (visible) {
                item.removeAttribute('data-hidden');
                if (!firstVisibleId) {
                    firstVisibleId = item.getAttribute('data-geo-item');
                }
            } else {
                item.setAttribute('data-hidden', 'true');
            }
        });

        if (firstVisibleId) {
            selectLandmark(firstVisibleId);
        }
    }

    // Filter clicks
    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const cat = btn.getAttribute('data-geo-filter');
            filterCategory(cat);
        });
    });

    // Item clicks
    items.forEach(item => {
        item.addEventListener('click', () => {
            const id = item.getAttribute('data-geo-item');
            selectLandmark(id);
        });
    });
});
