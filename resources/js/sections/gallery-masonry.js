/**
 * Gallery Masonry Category Filtering and Accessible Lightbox Controller.
 */
document.addEventListener('DOMContentLoaded', () => {
    const masonry = document.querySelector('[data-gm-masonry]');
    if (!masonry) return;

    const filterBtns = masonry.querySelectorAll('[data-gm-filter]');
    const plates = masonry.querySelectorAll('[data-gm-plate]');

    // Filter functionality
    function filterCategory(cat) {
        filterBtns.forEach(btn => {
            const isActive = btn.getAttribute('data-gm-filter').toLowerCase() === cat.toLowerCase();
            btn.classList.toggle('gm-masonry__filter-btn--active', isActive);
            btn.setAttribute('aria-selected', isActive ? 'true' : 'false');
        });

        plates.forEach(plate => {
            const plateCat = plate.getAttribute('data-category');
            if (cat === 'all' || plateCat.toLowerCase() === cat.toLowerCase()) {
                plate.style.display = '';
            } else {
                plate.style.display = 'none';
            }
        });
    }

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const cat = btn.getAttribute('data-gm-filter');
            filterCategory(cat);
        });
    });

    // Hash change handler
    function checkHash() {
        const hash = window.location.hash;
        if (hash && hash.startsWith('#gallery-category-')) {
            const catSlug = hash.replace('#gallery-category-', '');
            const matchingBtn = Array.from(filterBtns).find(b =>
                b.getAttribute('data-gm-filter').toLowerCase().replace(/\s+/g, '-') === catSlug.toLowerCase()
            );
            if (matchingBtn) {
                matchingBtn.click();
                const target = document.getElementById('editorial-masonry-gallery');
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            }
        }
    }

    window.addEventListener('hashchange', checkHash);
    checkHash();

    // Lightbox modal functionality
    const dialog = masonry.querySelector('[data-gm-dialog]');
    const dialogImg = masonry.querySelector('[data-gm-dialog-img]');
    const dialogTitle = masonry.querySelector('[data-gm-dialog-title]');
    const dialogCaption = masonry.querySelector('[data-gm-dialog-caption]');
    const dialogProv = masonry.querySelector('[data-gm-dialog-prov]');
    const triggers = masonry.querySelectorAll('[data-gm-trigger]');
    const closeBtns = masonry.querySelectorAll('[data-gm-close]');

    if (dialog) {
        triggers.forEach(trigger => {
            trigger.addEventListener('click', () => {
                const src = trigger.getAttribute('data-img-src');
                const alt = trigger.getAttribute('data-img-alt');
                const title = trigger.getAttribute('data-img-title');
                const caption = trigger.getAttribute('data-img-caption');
                const prov = trigger.getAttribute('data-img-prov');

                if (dialogImg) {
                    dialogImg.src = src;
                    dialogImg.alt = alt;
                }
                if (dialogTitle) dialogTitle.textContent = title;
                if (dialogCaption) dialogCaption.textContent = caption;
                if (dialogProv) dialogProv.textContent = prov;

                dialog.showModal();
                document.body.style.overflow = 'hidden';
            });
        });

        function closeDialog() {
            dialog.close();
            document.body.style.overflow = '';
        }

        closeBtns.forEach(btn => {
            btn.addEventListener('click', closeDialog);
        });

        dialog.addEventListener('cancel', () => {
            document.body.style.overflow = '';
        });
    }
});
