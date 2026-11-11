/**
 * Care Team Role Explorer Controller.
 * Handles role button tabs and active panel display.
 */
document.addEventListener('DOMContentLoaded', () => {
    const teamSection = document.querySelector('[data-about-team]');
    if (!teamSection) return;

    const roleBtns = Array.from(teamSection.querySelectorAll('[data-role-tab]'));
    const rolePanels = Array.from(teamSection.querySelectorAll('[data-role-panel]'));

    function selectRole(roleId) {
        roleBtns.forEach(btn => {
            const isMatch = btn.getAttribute('data-role-tab') === roleId;
            btn.classList.toggle('about-team__role-btn--active', isMatch);
            btn.setAttribute('aria-selected', isMatch ? 'true' : 'false');
        });

        rolePanels.forEach(panel => {
            const isMatch = panel.getAttribute('data-role-panel') === roleId;
            panel.classList.toggle('about-team__role-detail--active', isMatch);
            if (isMatch) {
                panel.removeAttribute('hidden');
            } else {
                panel.setAttribute('hidden', '');
            }
        });
    }

    roleBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-role-tab');
            selectRole(id);
        });
    });
});
