/**
 * Global site header: two states (initial / compact sticky), desktop disclosure menus, mobile drawer.
 */

// Scroll distance after which the header becomes the compact sticky bar.
const COMPACT_AFTER_PX = 88;

/**
 * State 2 (compact sticky) once the page has scrolled past COMPACT_AFTER_PX.
 * An IntersectionObserver watches an invisible sentinel covering the top of the document, so there
 * is no scroll listener and no layout reads. Its first callback also fires after a refresh at a
 * restored scroll position. The header is position:fixed, so changing state never shifts content.
 * `is-scrolled` (solid plum surface) and `is-compact` (smaller bar + logo) always move together.
 */
function initCompactState(header) {
  const set = (compact) => {
    header.classList.toggle('is-scrolled', compact);
    header.classList.toggle('is-compact', compact);
  };

  if (!('IntersectionObserver' in window)) {
    let queued = false;
    const check = () => { queued = false; set(window.scrollY > COMPACT_AFTER_PX); };
    check();
    window.addEventListener('scroll', () => { if (!queued) { queued = true; requestAnimationFrame(check); } }, { passive: true });
    return;
  }

  const sentinel = document.createElement('div');
  sentinel.setAttribute('aria-hidden', 'true');
  sentinel.dataset.headerSentinel = '';
  sentinel.style.cssText = `position:absolute;top:0;left:0;width:1px;height:${COMPACT_AFTER_PX}px;pointer-events:none;opacity:0;`;
  document.body.prepend(sentinel);

  new IntersectionObserver(([entry]) => set(!entry.isIntersecting)).observe(sentinel);
}
export function initSiteHeader() {
  const header = document.querySelector('[data-site-header]');
  if (!header || header.dataset.initialized) return;
  header.dataset.initialized = 'true';

  initCompactState(header);

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

  // "Schedule a Visit" is a [data-inquiry] link: the shared inquiry modal opens it.
  // Close the mobile drawer first so the modal is not stacked over it.
  header.querySelectorAll('[data-inquiry]').forEach((link) => {
    link.addEventListener('click', () => setDrawer(false));
  });
}
