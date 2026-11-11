/**
 * Contact Section 05: Referral Interest Pathways.
 *
 * Implements pathway tab switching and pre-filling the guided inquiry form
 * with referral context.
 */

document.addEventListener('DOMContentLoaded', () => {
    initContactReferral();
});

function initContactReferral() {
    const section = document.querySelector('[data-contact-referral]');
    if (!section) return;

    const tabs = section.querySelectorAll('[data-referral-tab]');
    const panels = section.querySelectorAll('[data-referral-panel]');
    const prefillBtns = section.querySelectorAll('[data-referral-prefill]');

    // Pathway Tabs
    tabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            const pathwayId = tab.getAttribute('data-referral-tab');

            tabs.forEach((t) => {
                t.classList.remove('contact-referral__tab--active');
                t.setAttribute('aria-selected', 'false');
            });
            tab.classList.add('contact-referral__tab--active');
            tab.setAttribute('aria-selected', 'true');

            panels.forEach((panel) => {
                const match = panel.getAttribute('data-referral-panel') === pathwayId;
                panel.hidden = !match;
            });
        });
    });

    // Pre-fill button
    prefillBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
            const intent = btn.getAttribute('data-preset-intent');
            const care = btn.getAttribute('data-preset-care');
            const suite = btn.getAttribute('data-preset-suite');
            const message = btn.getAttribute('data-preset-message');
            const referral = btn.getAttribute('data-preset-referral');

            const form = document.querySelector('[data-contact-form]');
            const confirmation = document.querySelector('#contact-demo-confirmation');

            if (!form) return;

            // Intent radio
            const radio = form.querySelector(`input[name="inquiry_intent"][value="${intent}"]`);
            if (radio) radio.checked = true;

            // Care select
            const careSelect = form.querySelector('#contact-care-interest');
            if (careSelect && care) careSelect.value = care;

            // Suite select
            const suiteSelect = form.querySelector('#contact-suite-preference');
            if (suiteSelect && suite) suiteSelect.value = suite;

            // Message
            const msgArea = form.querySelector('#contact-message');
            if (msgArea && message) msgArea.value = message;

            // Referral note
            const refInput = form.querySelector('#contact-referral-note');
            if (refInput && referral) refInput.value = referral;

            // Reset demo confirmation
            if (confirmation && !confirmation.hidden) {
                confirmation.hidden = true;
                form.hidden = false;
            }

            // Scroll to schedule visit studio
            const studio = document.getElementById('schedule-visit');
            if (studio) {
                studio.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
}
