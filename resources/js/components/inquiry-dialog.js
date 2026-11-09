/**
 * Shared inquiry dialog (Schedule a Visit · Request Pricing · Request a Call).
 *
 * Any element with data-inquiry="<intent>" opens ONE native <dialog> with that
 * intent preselected (optional data-inquiry-suite preselects a suite). Schedule a
 * Visit reuses the hero's existing visit dialog when the page has one
 * (window.MissionVilla.openVisit), as the brief requires.
 *
 * Submission: fetch POST with the Laravel CSRF token. The success view shows the
 * server's own message, so the visitor only ever sees what really happened
 * (saved locally / received / failed). In "preview" mode nothing is posted.
 * One idempotency key per opening protects against double submits.
 */
const INTENTS = ['schedule_visit', 'request_pricing', 'request_callback'];
const SUITES = { private: 'private', shared: 'shared' };

function uuid() {
  if (window.crypto?.randomUUID) return window.crypto.randomUUID();
  // RFC 4122 v4 fallback for older browsers.
  const b = window.crypto.getRandomValues(new Uint8Array(16));
  b[6] = (b[6] & 0x0f) | 0x40;
  b[8] = (b[8] & 0x3f) | 0x80;
  const h = [...b].map((x) => x.toString(16).padStart(2, '0')).join('');
  return `${h.slice(0, 8)}-${h.slice(8, 12)}-${h.slice(12, 16)}-${h.slice(16, 20)}-${h.slice(20)}`;
}

function initInquiry(dialog) {
  const $ = (sel) => dialog.querySelector(sel);
  const form = $('[data-inquiry-form]');
  const formView = $('[data-inquiry-form-view]');
  const done = $('[data-inquiry-done]');
  const alertBox = $('[data-inquiry-alert]');
  const submit = $('[data-inquiry-submit]');
  const mode = dialog.dataset.mode;
  let copy = {};
  try { copy = JSON.parse(dialog.dataset.copy || '{}'); } catch { copy = {}; }

  let opener = null;
  let pending = false;

  function currentIntent() {
    return form.querySelector('[data-inquiry-intent]:checked')?.value || INTENTS[0];
  }

  function applyIntent(intent) {
    const c = copy[intent] || {};
    $('[data-inquiry-title]').textContent = c.title || '';
    $('[data-inquiry-lede]').textContent = c.lede || '';
    $('[data-inquiry-submit-label]').textContent = c.submit || 'Send';
    $('[data-inquiry-time-label]').textContent = c.time || '';
    $('[data-phone-hint]').textContent = intent === 'request_callback' ? '(required)' : '(or email)';
    dialog.querySelectorAll('[data-show-for]').forEach((el) => {
      const show = el.dataset.showFor.split(' ').includes(intent);
      el.hidden = !show;
      el.querySelectorAll('input, select').forEach((f) => { f.disabled = !show; });
    });
  }

  function clearErrors() {
    alertBox.hidden = true;
    alertBox.textContent = '';
    dialog.querySelectorAll('[data-error-for]').forEach((p) => { p.hidden = true; p.textContent = ''; });
    dialog.querySelectorAll('[aria-invalid]').forEach((f) => f.removeAttribute('aria-invalid'));
  }

  function showErrors(errors) {
    let first = null;
    Object.entries(errors).forEach(([field, messages]) => {
      const slot = dialog.querySelector(`[data-error-for="${field}"]`);
      const input = form.elements[field];
      if (slot && input && !input.disabled) {
        slot.textContent = messages[0];
        slot.hidden = false;
        input.setAttribute('aria-invalid', 'true');
        first ||= input;
      } else {
        alertBox.textContent = messages[0];
        alertBox.hidden = false;
      }
    });
    (first || alertBox).focus?.();
  }

  function reset() {
    form.reset();
    clearErrors();
    formView.hidden = false;
    done.hidden = true;
    submit.disabled = false;
    pending = false;
    form.querySelector('[data-inquiry-key]').value = uuid();
    form.querySelector('[data-inquiry-page]').value = window.location.href.split('#')[0].slice(0, 255);
    const params = new URLSearchParams(window.location.search);
    form.querySelectorAll('[data-inquiry-attr]').forEach((input) => {
      input.value = (params.get(input.dataset.inquiryAttr) || '').slice(0, 100);
    });
  }

  function open(intent = INTENTS[0], { suite } = {}) {
    if (!INTENTS.includes(intent)) intent = INTENTS[0];
    opener = document.activeElement;
    reset();
    form.querySelector(`[data-inquiry-intent][value="${intent}"]`).checked = true;
    applyIntent(intent);
    if (suite && SUITES[suite]) form.elements.suite_preference.value = SUITES[suite];
    dialog.showModal();
    document.body.classList.add('is-scroll-locked');
    form.elements.name.focus();
  }

  function close() {
    if (dialog.open) dialog.close();
  }

  dialog.addEventListener('close', () => {
    document.body.classList.remove('is-scroll-locked');
    if (opener && typeof opener.focus === 'function') opener.focus();
    opener = null;
  });

  // Click on the backdrop (outside the card) closes, like the hero dialogs.
  dialog.addEventListener('click', (e) => { if (e.target === dialog) close(); });
  dialog.querySelectorAll('[data-inquiry-close]').forEach((b) => b.addEventListener('click', close));
  form.querySelectorAll('[data-inquiry-intent]').forEach((r) => r.addEventListener('change', () => { clearErrors(); applyIntent(currentIntent()); }));

  function showDone(title, message, reference) {
    $('[data-inquiry-done-title]').textContent = title;
    $('[data-inquiry-done-text]').textContent = message;
    const ref = $('[data-inquiry-done-ref]');
    ref.hidden = !reference;
    ref.textContent = reference ? `Reference: ${reference}` : '';
    formView.hidden = true;
    done.hidden = false;
    done.focus();
  }

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    if (pending) return;
    clearErrors();

    if (mode === 'preview') {
      showDone('This is a design preview: nothing was sent.', 'This form is not connected to Mission Villa. To reach the team, please call (650) 756-1995.', null);
      return;
    }

    pending = true;
    submit.disabled = true;
    try {
      const res = await fetch(form.action, {
        method: 'POST',
        headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        body: new FormData(form),
        credentials: 'same-origin',
      });
      const body = await res.json().catch(() => ({}));

      if (res.status === 201 && body.status === 'received') {
        const saved = body.delivery === 'not_connected';
        showDone(saved ? 'Request saved, not yet sent' : 'Thank you, request received', body.message || '', body.reference);
        return;
      }
      if (res.status === 422 && body.errors) {
        showErrors(body.errors);
      } else if (res.status === 419) {
        showErrors({ form: ['This page has been open for a while. Please reload it and try again, or call (650) 756-1995.'] });
      } else if (res.status === 429) {
        showErrors({ form: ['Too many requests from this connection. Please wait a little, or call (650) 756-1995.'] });
      } else {
        showErrors({ form: [body.message || 'We couldn’t save your request. Please call (650) 756-1995.'] });
      }
    } catch {
      showErrors({ form: ['We couldn’t reach the website. Please check your connection, or call (650) 756-1995.'] });
    }
    pending = false;
    submit.disabled = false;
  });

  return open;
}

function boot() {
  const dialog = document.querySelector('[data-inquiry-dialog]');
  if (!dialog || typeof dialog.showModal !== 'function') return; // tel: links remain as the fallback
  const openInquiry = initInquiry(dialog);
  window.MissionVilla = Object.assign(window.MissionVilla || {}, { openInquiry });

  document.addEventListener('click', (e) => {
    const trigger = e.target.closest('[data-inquiry]');
    if (!trigger) return;
    const intent = trigger.dataset.inquiry;
    if (!INTENTS.includes(intent)) return;
    e.preventDefault();
    // Reuse the approved hero visit flow where the page has it.
    if (intent === 'schedule_visit' && typeof window.MissionVilla.openVisit === 'function') {
      window.MissionVilla.openVisit();
      return;
    }
    openInquiry(intent, { suite: trigger.dataset.inquirySuite });
  });
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', boot, { once: true });
} else {
  boot();
}
