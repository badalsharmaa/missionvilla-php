/**
 * Contact Section 04: What Happens After Submitting.
 *
 * Implements interactive 4-step workflow tab switching between the post-submission phases.
 */

document.addEventListener('DOMContentLoaded', () => {
    initContactWorkflow();
});

function initContactWorkflow() {
    const section = document.querySelector('[data-contact-workflow]');
    if (!section) return;

    const tabs = section.querySelectorAll('[data-workflow-tab]');
    const panels = section.querySelectorAll('[data-workflow-panel]');

    tabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            const stepId = tab.getAttribute('data-workflow-tab');

            tabs.forEach((t) => t.classList.remove('contact-workflow__tab-btn--active'));
            tab.classList.add('contact-workflow__tab-btn--active');

            panels.forEach((panel) => {
                const match = panel.getAttribute('data-workflow-panel') === stepId;
                panel.hidden = !match;
            });
        });
    });
}
