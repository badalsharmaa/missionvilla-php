/**
 * Contact Section 03: Grounded Map, Peninsula Directions & Accessible Arrival.
 *
 * Implements corridor category filtering, active corridor selection, dynamic
 * route focus updating, and editorial vs embed map mode switching.
 */

document.addEventListener('DOMContentLoaded', () => {
    initContactDirections();
});

function initContactDirections() {
    const section = document.querySelector('[data-contact-directions]');
    if (!section) return;

    const tabs = section.querySelectorAll('[data-category-filter]');
    const corridorCards = section.querySelectorAll('[data-corridor-id]');
    const modeBtns = section.querySelectorAll('[data-map-mode]');
    const editorialCanvas = section.querySelector('[data-canvas-editorial]');
    const embedCanvas = section.querySelector('[data-canvas-embed]');
    const routeFocusLabel = section.querySelector('[data-active-route-label]');
    const routeFocusTip = section.querySelector('[data-active-route-tip]');

    // Category Tabs Filtering
    tabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            const cat = tab.getAttribute('data-category-filter');
            tabs.forEach((t) => {
                t.classList.remove('contact-directions__tab--active');
                t.setAttribute('aria-selected', 'false');
            });
            tab.classList.add('contact-directions__tab--active');
            tab.setAttribute('aria-selected', 'true');

            let firstVisible = null;

            corridorCards.forEach((card) => {
                const cardCat = card.getAttribute('data-corridor-category');
                const isMatch = cat === 'All Routes' || cardCat === cat;
                card.hidden = !isMatch;

                if (isMatch && !firstVisible) {
                    firstVisible = card;
                }
            });

            // If selected card is hidden, select first visible
            const currentSelected = section.querySelector('.contact-directions__corridor-card--selected');
            if (currentSelected && currentSelected.hidden && firstVisible) {
                selectCorridor(firstVisible);
            }
        });
    });

    // Corridor Card Selection
    corridorCards.forEach((card) => {
        card.addEventListener('click', () => {
            selectCorridor(card);
        });

        const inspectBtn = card.querySelector('[data-corridor-inspect]');
        if (inspectBtn) {
            inspectBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                selectCorridor(card);
            });
        }
    });

    function selectCorridor(activeCard) {
        corridorCards.forEach((card) => {
            const isMatch = card === activeCard;
            card.classList.toggle('contact-directions__corridor-card--selected', isMatch);

            const details = card.querySelector('.contact-directions__corridor-details');
            if (details) {
                details.hidden = !isMatch;
            }

            const inspectText = card.querySelector('.contact-directions__inspect-text');
            if (inspectText) {
                inspectText.textContent = isMatch ? 'Selected Route Context' : 'Inspect Route Details →';
            }
        });

        // Update right column route focus
        const title = activeCard.getAttribute('data-corridor-title');
        const tip = activeCard.getAttribute('data-corridor-tip');

        if (routeFocusLabel && title) {
            routeFocusLabel.textContent = `Selected Route Focus: ${title}`;
        }
        if (routeFocusTip && tip) {
            routeFocusTip.textContent = tip;
        }
    }

    // Map Mode Switcher
    modeBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
            const mode = btn.getAttribute('data-map-mode');
            modeBtns.forEach((b) => b.classList.remove('contact-directions__mode-btn--active'));
            btn.classList.add('contact-directions__mode-btn--active');

            if (mode === 'editorial') {
                if (editorialCanvas) editorialCanvas.hidden = false;
                if (embedCanvas) embedCanvas.hidden = true;
            } else {
                if (editorialCanvas) editorialCanvas.hidden = true;
                if (embedCanvas) embedCanvas.hidden = false;
            }
        });
    });
}
