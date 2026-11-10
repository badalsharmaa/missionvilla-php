/**
 * Respite Care Section 07: Questions Families Often Ask.
 *
 * Accessible accordion with single-open policy and keyboard navigation.
 */
function initFaqAccordion(section) {
  const items = Array.from(section.querySelectorAll('[data-faq-item]'));
  if (!items.length) return;

  function toggleItem(targetItem) {
    const isCurrentlyOpen = targetItem.classList.contains('is-open');

    // Close all items
    items.forEach((item) => {
      const trigger = item.querySelector('[data-faq-trigger]');
      const body = item.querySelector('[data-faq-body]');
      item.classList.remove('is-open');
      if (trigger) trigger.setAttribute('aria-expanded', 'false');
      if (body) body.hidden = true;
    });

    // If it was not open, open it
    if (!isCurrentlyOpen) {
      const trigger = targetItem.querySelector('[data-faq-trigger]');
      const body = targetItem.querySelector('[data-faq-body]');
      targetItem.classList.add('is-open');
      if (trigger) trigger.setAttribute('aria-expanded', 'true');
      if (body) body.hidden = false;
    }
  }

  items.forEach((item, index) => {
    const trigger = item.querySelector('[data-faq-trigger]');
    if (!trigger) return;

    trigger.addEventListener('click', () => {
      toggleItem(item);
    });

    trigger.addEventListener('keydown', (e) => {
      let targetIndex = null;
      if (e.key === 'ArrowDown') {
        targetIndex = (index + 1) % items.length;
      } else if (e.key === 'ArrowUp') {
        targetIndex = (index - 1 + items.length) % items.length;
      } else if (e.key === 'Home') {
        targetIndex = 0;
      } else if (e.key === 'End') {
        targetIndex = items.length - 1;
      }

      if (targetIndex !== null) {
        e.preventDefault();
        const nextTrigger = items[targetIndex].querySelector('[data-faq-trigger]');
        if (nextTrigger) nextTrigger.focus();
      }
    });
  });
}

function boot() {
  document.querySelectorAll('[data-rc-faq]').forEach(initFaqAccordion);
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', boot, { once: true });
} else {
  boot();
}
