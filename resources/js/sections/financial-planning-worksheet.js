/**
 * Financial Planning Section 04: Interactive Paper-Ledger Worksheet
 * Handles mode switching, live subtotal calculations, checkbox state, and print.
 */
document.addEventListener('DOMContentLoaded', () => {
    const section = document.querySelector('[data-fp-sheet]');
    if (!section) return;

    const modeBtns = Array.from(section.querySelectorAll('[data-ledger-mode]'));
    const rows = Array.from(section.querySelectorAll('[data-ledger-row]'));
    const clearBtn = section.querySelector('[data-ledger-action="clear"]');
    const printBtn = section.querySelector('[data-ledger-action="print"]');

    // Counters and display elements
    const topCheckedCount = section.querySelector('[data-ledger-checked-count]');
    const footerCheckedCount = section.querySelector('[data-footer-checked-count]');
    const topSubtotalDisplay = section.querySelector('[data-ledger-subtotal-display]');
    const footerSubtotalDisplay = section.querySelector('[data-footer-subtotal-val]');
    const footerEnteredCount = section.querySelector('[data-footer-entered-count]');
    const attachBtns = Array.from(section.querySelectorAll('[data-ledger-attach-btn], [data-ledger-submit-btn]'));

    // Mode Switcher (Worksheet vs Checklist)
    modeBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
            const mode = btn.getAttribute('data-ledger-mode');
            if (!mode) return;

            modeBtns.forEach((b) => {
                const isActive = b === btn;
                b.classList.toggle('fp-sheet__mode-btn--active', isActive);
            });

            const worksheetViews = section.querySelectorAll('[data-mode-view="worksheet"]');
            const checklistViews = section.querySelectorAll('[data-mode-view="checklist"]');

            if (mode === 'worksheet') {
                worksheetViews.forEach((el) => el.removeAttribute('hidden'));
                checklistViews.forEach((el) => el.setAttribute('hidden', ''));
            } else {
                worksheetViews.forEach((el) => el.setAttribute('hidden', ''));
                checklistViews.forEach((el) => el.removeAttribute('hidden'));
            }
        });
    });

    // Print Action
    if (printBtn) {
        printBtn.addEventListener('click', () => {
            window.print();
        });
    }

    // Calculations & State Update
    function updateLedgerState() {
        let checkedCount = 0;
        let enteredCount = 0;
        let subtotal = 0;

        rows.forEach((row) => {
            const checkBtn = row.querySelector('[data-ledger-check]');
            const isChecked = checkBtn && checkBtn.getAttribute('aria-pressed') === 'true';
            if (isChecked) checkedCount++;

            const input = row.querySelector('[data-ledger-input]');
            const hint = row.querySelector('[data-ledger-hint]');
            const chkStatus = row.querySelector('[data-chk-status]');

            if (chkStatus) {
                chkStatus.textContent = isChecked ? '✓ Checked for Family Review' : 'Unchecked Category';
                chkStatus.classList.toggle('fp-sheet__chk-status--checked', isChecked);
            }

            if (input) {
                const rawVal = input.value.trim();
                const num = parseFloat(rawVal);
                if (!isNaN(num) && num > 0) {
                    enteredCount++;
                    subtotal += num;
                    if (hint) {
                        hint.textContent = `Recorded on worksheet: $${num.toLocaleString('en-US')}/mo`;
                        hint.removeAttribute('hidden');
                    }
                } else {
                    if (hint) {
                        hint.textContent = '';
                        hint.setAttribute('hidden', '');
                    }
                }
            }
        });

        // Update displays
        if (topCheckedCount) topCheckedCount.textContent = String(checkedCount);
        if (footerCheckedCount) footerCheckedCount.textContent = String(checkedCount);
        if (footerEnteredCount) footerEnteredCount.textContent = String(enteredCount);

        const formattedSubtotal = `$${subtotal.toLocaleString('en-US')}/mo`;
        if (topSubtotalDisplay) topSubtotalDisplay.textContent = formattedSubtotal;

        if (footerSubtotalDisplay) {
            footerSubtotalDisplay.textContent = subtotal > 0
                ? `$${subtotal.toLocaleString('en-US')} / month`
                : '— (Enter your own figures above if helpful)';
        }

        // Update note on attach buttons
        const noteText = `Paper-Ledger comparison worksheet: ${checkedCount} categories checked, ${enteredCount} home expenses entered (subtotal: $${subtotal.toLocaleString('en-US')}/mo).`;
        attachBtns.forEach((btn) => {
            btn.setAttribute('data-note', noteText);
        });
    }

    // Row Checkbox Handlers
    rows.forEach((row) => {
        const checkBtn = row.querySelector('[data-ledger-check]');
        if (!checkBtn) return;

        checkBtn.addEventListener('click', () => {
            const currentlyPressed = checkBtn.getAttribute('aria-pressed') === 'true';
            const nextPressed = !currentlyPressed;
            checkBtn.setAttribute('aria-pressed', nextPressed ? 'true' : 'false');
            row.classList.toggle('fp-sheet__row--checked', nextPressed);
            updateLedgerState();
        });
    });

    // Row Input Handlers
    rows.forEach((row) => {
        const input = row.querySelector('[data-ledger-input]');
        const checkBtn = row.querySelector('[data-ledger-check]');
        if (!input) return;

        input.addEventListener('input', () => {
            const rawVal = input.value.trim();
            const num = parseFloat(rawVal);
            // Automatically check row if user enters a number
            if (!isNaN(num) && num > 0 && checkBtn && checkBtn.getAttribute('aria-pressed') !== 'true') {
                checkBtn.setAttribute('aria-pressed', 'true');
                row.classList.toggle('fp-sheet__row--checked', true);
            }
            updateLedgerState();
        });
    });

    // Clear Action
    if (clearBtn) {
        clearBtn.addEventListener('click', () => {
            rows.forEach((row) => {
                const checkBtn = row.querySelector('[data-ledger-check]');
                if (checkBtn) {
                    checkBtn.setAttribute('aria-pressed', 'false');
                    row.classList.remove('fp-sheet__row--checked');
                }
                const input = row.querySelector('[data-ledger-input]');
                if (input) input.value = '';
                const hint = row.querySelector('[data-ledger-hint]');
                if (hint) {
                    hint.textContent = '';
                    hint.setAttribute('hidden', '');
                }
            });
            updateLedgerState();
        });
    }

    // Initial calculation
    updateLedgerState();
});
