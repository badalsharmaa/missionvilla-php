/**
 * RESOURCES SECTION 04: BLOG INVENTORY PROTOCOL (resources-blog.js)
 * Tab switcher for the 4-stage blog migration & verification protocol.
 */

document.addEventListener('DOMContentLoaded', () => {
    const section = document.querySelector('[data-res-blog]');
    if (!section) return;

    const tabs = section.querySelectorAll('[data-blog-tab]');
    const panels = section.querySelectorAll('[data-blog-panel]');

    tabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            const targetId = tab.getAttribute('data-blog-tab');

            tabs.forEach((t) => {
                const isActive = (t === tab);
                t.classList.toggle('res-blog__stage-tab--active', isActive);
                t.setAttribute('aria-selected', isActive ? 'true' : 'false');
            });

            panels.forEach((p) => {
                const isMatch = (p.getAttribute('data-blog-panel') === targetId);
                p.hidden = !isMatch;
                p.classList.toggle('res-blog__stage-panel--active', isMatch);
            });
        });
    });
});
