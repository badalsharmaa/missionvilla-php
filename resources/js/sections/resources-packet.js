/**
 * RESOURCES SECTION 03: TOUR RESOURCE PACKET BUILDER (resources-packet.js)
 * Interactive checklist with dynamic count and inquiry modal binding.
 */

document.addEventListener('DOMContentLoaded', () => {
    const section = document.querySelector('[data-res-packet]');
    if (!section) return;

    const items = section.querySelectorAll('[data-packet-item]');
    const countDisplay = section.querySelector('[data-packet-count]');
    const selectAllBtn = section.querySelector('[data-packet-select-all]');
    const clearBtn = section.querySelector('[data-packet-clear]');
    const attachBtn = section.querySelector('[data-packet-attach-btn]');
    const attachLabel = section.querySelector('[data-packet-attach-label]');
    const notice = section.querySelector('[data-packet-notice]');

    function updateState() {
        const checkedItems = Array.from(items).filter((it) => it.classList.contains('res-packet__item--checked'));
        const count = checkedItems.length;

        if (countDisplay) {
            countDisplay.textContent = count;
        }

        if (attachLabel) {
            attachLabel.textContent = `Attach ${count} Packet Item${count === 1 ? '' : 's'} to Visit Inquiry ↓`;
        }

        if (attachBtn) {
            if (count === 0) {
                attachBtn.setAttribute('data-note', 'Exploring Resources Overview (/resources): Would like to request community brochure materials and discuss care options with the Daly City team.');
            } else {
                const labels = checkedItems.map((it) => {
                    const code = it.getAttribute('data-packet-code') || '';
                    const title = it.getAttribute('data-packet-title') || '';
                    return `(${code}) ${title}`;
                }).join('; ');
                attachBtn.setAttribute('data-note', `Requesting ${count} family resource packet item(s) from /resources: ${labels}.`);
            }
        }
    }

    function toggleItem(item) {
        if (notice) notice.hidden = true;
        const isChecked = item.classList.contains('res-packet__item--checked');
        item.classList.toggle('res-packet__item--checked', !isChecked);
        item.setAttribute('aria-checked', !isChecked ? 'true' : 'false');
        updateState();
    }

    items.forEach((item) => {
        item.addEventListener('click', () => toggleItem(item));
        item.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                toggleItem(item);
            }
        });
    });

    if (selectAllBtn) {
        selectAllBtn.addEventListener('click', () => {
            if (notice) notice.hidden = true;
            items.forEach((it) => {
                it.classList.add('res-packet__item--checked');
                it.setAttribute('aria-checked', 'true');
            });
            updateState();
        });
    }

    if (clearBtn) {
        clearBtn.addEventListener('click', () => {
            if (notice) notice.hidden = true;
            items.forEach((it) => {
                it.classList.remove('res-packet__item--checked');
                it.setAttribute('aria-checked', 'false');
            });
            updateState();
        });
    }

    if (attachBtn) {
        attachBtn.addEventListener('click', () => {
            if (notice) notice.hidden = false;
        });
    }

    // Initial state calculation
    updateState();
});
