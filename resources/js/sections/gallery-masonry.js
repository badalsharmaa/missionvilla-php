/**
 * Gallery Masonry Category Filtering and Accessible Carousel Lightbox Controller.
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

    // Lightbox modal functionality with cycling
    const dialog = masonry.querySelector('[data-gm-dialog]');
    const dialogImg = masonry.querySelector('[data-gm-dialog-img]');
    const dialogTitle = masonry.querySelector('[data-gm-dialog-title]');
    const dialogCaption = masonry.querySelector('[data-gm-dialog-caption]');
    const dialogProv = masonry.querySelector('[data-gm-dialog-prov]');
    const dialogCounter = masonry.querySelector('[data-gm-dialog-counter]');
    const prevBtn = masonry.querySelector('[data-gm-prev]');
    const nextBtn = masonry.querySelector('[data-gm-next]');
    const triggers = Array.from(masonry.querySelectorAll('[data-gm-trigger]'));
    const closeBtns = masonry.querySelectorAll('[data-gm-close]');

    let currentIndex = -1;

    function renderActivePlate(idx) {
        if (idx < 0 || idx >= triggers.length) return;
        currentIndex = idx;
        const trigger = triggers[idx];

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
        if (dialogCounter) {
            dialogCounter.textContent = `Plate ${String(idx + 1).padStart(2, '0')} of ${String(triggers.length).padStart(2, '0')}`;
        }
    }

    function stepNext() {
        if (currentIndex < 0) return;
        const nextIdx = (currentIndex + 1) % triggers.length;
        renderActivePlate(nextIdx);
    }

    function stepPrev() {
        if (currentIndex < 0) return;
        const prevIdx = (currentIndex - 1 + triggers.length) % triggers.length;
        renderActivePlate(prevIdx);
    }

    if (dialog) {
        triggers.forEach((trigger, idx) => {
            trigger.addEventListener('click', () => {
                renderActivePlate(idx);
                dialog.showModal();
                document.body.style.overflow = 'hidden';
            });
        });

        if (prevBtn) {
            prevBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                stepPrev();
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                stepNext();
            });
        }

        window.addEventListener('keydown', (e) => {
            if (!dialog.open) return;
            if (e.key === 'ArrowRight') {
                stepNext();
            } else if (e.key === 'ArrowLeft') {
                stepPrev();
            }
        });

        function closeDialog() {
            dialog.close();
            document.body.style.overflow = '';
            currentIndex = -1;
        }

        closeBtns.forEach(btn => {
            btn.addEventListener('click', closeDialog);
        });

        dialog.addEventListener('cancel', () => {
            document.body.style.overflow = '';
            currentIndex = -1;
        });
    }
});
