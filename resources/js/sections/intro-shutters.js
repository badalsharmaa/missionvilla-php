/**
 * OPENING SCENE — two-panel French conservatory shutters.
 *
 * Ported from React components/ConservatoryShutters.tsx: identical timeline
 * positions, durations and eases. The React hero choreography (.hero-line
 * rise, .hero-fade lift, arch-portal scale) is mapped onto the cinematic hero:
 *   .hero-line         -> #headlineLine1..3 (inside the existing headline masks)
 *   .hero-fade         -> [data-intro-fade]
 *   #hero-arch-portal  -> [data-intro-portal] (Care Guide column)
 *
 * Emits `missionvilla:intro-open` when the shutters have parted, so the hero
 * slider starts its 6-second autoplay only once the page is visible.
 */
import { gsap } from 'gsap';

const root = document.documentElement;
const overlay = document.getElementById('conservatory-shutters');
const skipBtn = document.getElementById('skip-intro-btn');

function announceOpen() {
  if (window.__mvIntroOpen) return;
  window.__mvIntroOpen = true;
  window.dispatchEvent(new CustomEvent('missionvilla:intro-open'));
}

function runIntro() {
  if (!overlay || window.__mvIntroStarted) return;
  window.__mvIntroStarted = true;

  const leftEl = document.getElementById('shutter-left');
  const rightEl = document.getElementById('shutter-right');
  const lines = ['#headlineLine1', '#headlineLine2', '#headlineLine3'].filter((s) => document.querySelector(s));
  const fades = [...document.querySelectorAll('[data-intro-fade]')];
  const portal = document.querySelector('[data-intro-portal]');

  let timeline = null;

  // Shutters open: release pointer events, hide Skip, start the hero slider.
  // The overlay stays mounted until the panels have fully left the viewport.
  const open = () => {
    overlay.dataset.shutterPhase = 'open';
    if (skipBtn) skipBtn.style.display = 'none';
    window.removeEventListener('keydown', onKey);
    announceOpen();
  };

  const teardown = () => {
    root.classList.remove('mv-intro-active');
  };

  const finishIntroImmediately = () => {
    if (timeline) {
      timeline.kill();
      timeline = null;
    }
    gsap.set(leftEl, { xPercent: -100 });
    gsap.set(rightEl, { xPercent: 100 });
    gsap.set('.shutter-fade', { opacity: 0, y: -12 });
    if (lines.length) gsap.set(lines, { yPercent: 0, rotateZ: 0 });
    if (fades.length) gsap.set(fades, { y: 0, opacity: 1 });
    if (portal) gsap.set(portal, { scale: 1, opacity: 1 });
    open();
    teardown();
  };

  function onKey(e) {
    if (e.key === 'Escape') finishIntroImmediately();
  }

  skipBtn?.addEventListener('click', finishIntroImmediately);
  window.addEventListener('keydown', onKey);

  // 1. Lock both conservatory shutters together at the centre seam.
  gsap.set(leftEl, { xPercent: 0 });
  gsap.set(rightEl, { xPercent: 0 });
  gsap.set('.shutter-fade', { opacity: 1, y: 0 });

  // 2. Pre-stage the hero underneath so it rises into view as the seam parts.
  if (lines.length) gsap.set(lines, { yPercent: 115, rotateZ: 2 });
  if (fades.length) gsap.set(fades, { y: 22, opacity: 0 });
  if (portal) gsap.set(portal, { scale: 0.9, opacity: 0 });

  // 3. Opening timeline (positions/durations/eases from the React reference).
  timeline = gsap.timeline({
    defaults: { ease: 'expo.inOut' },
    onComplete: () => {
      timeline = null;
    },
  });

  timeline
    // Readable beat on the split tagline at the centre seam, then fade/rise panel text
    .to('.shutter-fade', { opacity: 0, y: -12, duration: 0.45, delay: 1.05, ease: 'power2.inOut' })
    // Part Left (-100%) and Right (+100%) panels from the centre seam
    .call(() => { overlay.dataset.shutterPhase = 'parting'; }, [], 1.35)
    .to(leftEl, { xPercent: -100, duration: 1.35, ease: 'expo.inOut' }, 1.35)
    .to(rightEl, { xPercent: 100, duration: 1.35, ease: 'expo.inOut' }, 1.35);

  if (portal) timeline.to(portal, { scale: 1, opacity: 1, duration: 1.4, ease: 'expo.out' }, 1.65);
  if (lines.length) timeline.to(lines, { yPercent: 0, rotateZ: 0, duration: 1.15, stagger: 0.12, ease: 'power4.out' }, 1.7);
  if (fades.length) timeline.to(fades, { y: 0, opacity: 1, duration: 0.9, stagger: 0.09, ease: 'power3.out' }, 1.85);

  timeline.call(open, [], 2.35);
  timeline.call(teardown, [], 2.75);
}

if (root.classList.contains('mv-intro-active')) {
  runIntro();
} else {
  // Intro skipped (reduced motion, ?skipIntro=1, or safety timeout).
  announceOpen();
}
