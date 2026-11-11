/**
 * Services & Amenities Category Explorer & Live Filter.
 * Handles tab switching, search filtering, and URL hash routing.
 */
document.addEventListener('DOMContentLoaded', () => {
    const explorer = document.querySelector('[data-sa-explorer]');
    if (!explorer) return;

    const tabs = explorer.querySelectorAll('[data-sa-tab]');
    const categories = explorer.querySelectorAll('[data-sa-category]');
    const searchInput = explorer.querySelector('[data-sa-search]');
    const items = explorer.querySelectorAll('[data-sa-item]');

    function setActiveCategory(catId) {
        tabs.forEach(tab => {
            const isActive = tab.getAttribute('data-sa-tab') === catId;
            tab.classList.toggle('sa-explorer__tab--active', isActive);
            tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
        });

        if (catId === 'all') {
            explorer.setAttribute('data-show-all', 'true');
            categories.forEach(cat => cat.classList.add('sa-category--active'));
        } else {
            explorer.removeAttribute('data-show-all');
            categories.forEach(cat => {
                const isActive = cat.getAttribute('data-sa-category') === catId;
                cat.classList.toggle('sa-category--active', isActive);
            });
        }
    }

    // Tab click listeners
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const catId = tab.getAttribute('data-sa-tab');
            setActiveCategory(catId);
        });
    });

    // Hash listener (e.g. from hero dock links #category-dining)
    function checkHash() {
        const hash = window.location.hash;
        if (hash && hash.startsWith('#category-')) {
            const catId = hash.replace('#category-', '');
            setActiveCategory(catId);
            const target = document.getElementById(hash.substring(1));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        }
    }

    window.addEventListener('hashchange', checkHash);
    checkHash();

    // Live search filter
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.trim().toLowerCase();

            if (query.length > 0) {
                // When searching, show all categories so results are visible across all
                setActiveCategory('all');

                items.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    const matches = text.includes(query);
                    item.style.display = matches ? '' : 'none';
                });
            } else {
                items.forEach(item => {
                    item.style.display = '';
                });
            }
        });
    }
});
