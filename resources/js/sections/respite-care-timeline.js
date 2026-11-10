/**
 * Respite Care Section 06: A Simple Stay-Planning Timeline.
 *
 * Click and keyboard activation to expand/highlight steps.
 */
function initTimeline(section) {
  const steps = Array.from(section.querySelectorAll('[data-rc-step]'));
  if (!steps.length) return;

  function activateStep(targetStep, moveFocus = false) {
    steps.forEach((step) => {
      const isActive = step === targetStep;
      step.classList.toggle('is-active', isActive);
      step.setAttribute('aria-expanded', isActive ? 'true' : 'false');
      if (isActive && moveFocus) {
        step.focus();
      }
    });
  }

  steps.forEach((step, index) => {
    step.addEventListener('click', () => {
      activateStep(step);
    });

    step.addEventListener('keydown', (e) => {
      let targetIndex = null;
      if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
        targetIndex = (index + 1) % steps.length;
      } else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
        targetIndex = (index - 1 + steps.length) % steps.length;
      } else if (e.key === 'Home') {
        targetIndex = 0;
      } else if (e.key === 'End') {
        targetIndex = steps.length - 1;
      } else if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        activateStep(step);
        return;
      }

      if (targetIndex !== null) {
        e.preventDefault();
        activateStep(steps[targetIndex], true);
      }
    });
  });
}

function boot() {
  document.querySelectorAll('[data-rc-timeline]').forEach(initTimeline);
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', boot, { once: true });
} else {
  boot();
}
