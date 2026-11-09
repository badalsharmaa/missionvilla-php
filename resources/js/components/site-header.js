/**
 * Global site header: scroll surface, desktop disclosure menus, mobile drawer.
 */
export function initSiteHeader() {
  const header = document.querySelector('[data-site-header]');
  if (!header || header.dataset.initialized) return;
  header.dataset.initialized = 'true';

  // Solid surface once the page scrolls (future sections below the hero).
  const onScroll = () => header.classList.toggle('is-scrolled', window.scrollY > 24);
  onScroll();
  window.addEventListener('scroll', onScroll, { passive: true });

  // Desktop dropdowns ---------------------------------------------------------
  const toggles = [...header.querySelectorAll('[data-nav-toggle]')];
  const finePointer = window.matchMedia('(hover: hover) and (pointer: fine)');

  const setMenu = (toggle, open) => {
    const menu = document.getElementById(toggle.getAttribute('aria-controls'));
    toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    if (menu) menu.hidden = !open;
  };
  const closeAllMenus = (except) => toggles.forEach((t) => t !== except && setMenu(t, false));

  toggles.forEach((toggle) => {
    const item = toggle.closest('.site-nav__item');
    toggle.addEventListener('click', () => {
      const open = toggle.getAttribute('aria-expanded') !== 'true';
      closeAllMenus(toggle);
      setMenu(toggle, open);
    });
    item.addEventListener('mouseenter', () => {
      if (!finePointer.matches) return;
      closeAllMenus(toggle);
      setMenu(toggle, true);
    });
    item.addEventListener('mouseleave', () => finePointer.matches && setMenu(toggle, false));
    item.addEventListener('focusout', (e) => {
      if (!item.contains(e.relatedTarget)) setMenu(toggle, false);
    });
  });

  document.addEventListener('click', (e) => {
    if (!e.target.closest('.site-nav__item')) closeAllMenus();
  });

  // Mobile drawer -------------------------------------------------------------
  const drawerBtn = header.querySelector('[data-mobile-nav-toggle]');
  const drawer = document.getElementById('site-mobile-nav');
  const drawerLabel = header.querySelector('[data-mobile-nav-label]');

  const setDrawer = (open) => {
    if (!drawerBtn || !drawer) return;
    drawerBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
    if (drawerLabel) drawerLabel.textContent = open ? 'Close navigation menu' : 'Open navigation menu';
    drawer.hidden = !open;
    header.classList.toggle('is-open', open);
    document.body.classList.toggle('is-scroll-locked', open);
  };

  drawerBtn?.addEventListener('click', () => setDrawer(drawerBtn.getAttribute('aria-expanded') !== 'true'));
  window.matchMedia('(min-width: 1280px)').addEventListener('change', (e) => e.matches && setDrawer(false));

  document.addEventListener('keydown', (e) => {
    if (e.key !== 'Escape') return;
    const openToggle = toggles.find((t) => t.getAttribute('aria-expanded') === 'true');
    if (openToggle) {
      setMenu(openToggle, false);
      openToggle.focus();
    }
    if (drawerBtn?.getAttribute('aria-expanded') === 'true') {
      setDrawer(false);
      drawerBtn.focus();
    }
  });

  // "Schedule a Visit": open the on-page visit dialog when a section provides
  // one (the hero registers window.MissionVilla.openVisit); otherwise follow the link.
  header.querySelectorAll('[data-open-visit]').forEach((link) => {
    link.addEventListener('click', (e) => {
      const openVisit = window.MissionVilla?.openVisit;
      if (typeof openVisit !== 'function') return;
      e.preventDefault();
      setDrawer(false);
      openVisit();
    });
  });
}
