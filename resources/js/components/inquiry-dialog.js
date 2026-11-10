/**
 * Shared inquiry forms + THE inquiry modal.
 *
 * WEBSITE-WIDE RULE: a CTA whose destination is a form opens the modal; it
 * never scrolls to a form. Any element with data-inquiry="<intent>" opens the
 * one native <dialog> (components/inquiry/dialog) with that intent preselected:
 *   data-inquiry          canonical key or alias (visit | pricing | availability | callback | general)
 *   data-inquiry-source   optional section name (otherwise derived from the enclosing section)
 *   data-inquiry-suite    optional suite preselect (private | shared)
 *   data-inquiry-care     optional care preselect (memory_care | respite_care | exploring)
 *
 * Every form (the modal's and the inline card in Section 07) is the same Blade
 * partial (components/inquiry/form) and is driven by bindForm() below: same
 * fields, same endpoint (POST /inquiries), same error and success handling.
 *
 * Submission: fetch POST with the Laravel CSRF token. The outcome view shows
 * the server's own message, so the visitor only ever sees what really happened
 * (saved locally / received / failed). On failure the entered values stay.
 * In "preview" mode nothing is posted. One idempotency key per opening.
 */
const PHONE = '(650) 756-1995';
const SUITES = ['private', 'shared', 'undecided'];
const CARES = ['memory_care', 'respite_care', 'exploring'];
const TIME_LABELS = { schedule_visit: 'Preferred visit time', request_callback: 'Best time to call' };

// Enclosing section id → inquiry source (config inquiries.sources).
const SECTION_SOURCES = {
  heroSection: 'hero',
  'care-options': 'care-options',
  'life-at-mission-villa': 'life-gallery',
  'why-families': 'why-families',
  suites: 'suites',
  faq: 'faq',
  visit: 'visit-cta',
};

function uuid() {
  if (window.crypto?.randomUUID) return window.crypto.randomUUID();
  // RFC 4122 v4 fallback for older browsers.
  const b = window.crypto.getRandomValues(new Uint8Array(16));
  b[6] = (b[6] & 0x0f) | 0x40;
  b[8] = (b[8] & 0x3f) | 0x80;
  const h = [...b].map((x) => x.toString(16).padStart(2, '0')).join('');
  return `${h.slice(0, 8)}-${h.slice(8, 12)}-${h.slice(12, 16)}-${h.slice(16, 20)}-${h.slice(20)}`;
}

/**
 * Wire one form instance. `scope` contains [data-inquiry-form] and its
 * [data-inquiry-done] outcome view. Returns { reset, setIntent, intent }.
 */
function bindForm(scope, { onIntent, onDone } = {}) {
  const form = scope.querySelector('[data-inquiry-form]');
  const done = scope.querySelector('[data-inquiry-done]');
  const alertBox = form.querySelector('[data-inquiry-alert]');
  const submit = form.querySelector('[data-inquiry-submit]');
  const intentField = form.querySelector('[data-inquiry-intent]');
  const mode = form.dataset.mode;
  let pending = false;

  const q = (sel) => form.querySelector(sel);

  function applyIntent(intent) {
    form.querySelectorAll('[data-show-for]').forEach((el) => {
      const show = !!intent && el.dataset.showFor.split(' ').includes(intent);
      el.hidden = !show;
      el.querySelectorAll('input, select').forEach((f) => { f.disabled = !show; });
    });
    const callback = intent === 'request_callback';
    q('[data-phone-req]').hidden = !callback;
    form.elements.phone.required = callback;
    q('[data-contact-hint]').textContent = callback
      ? 'A phone number so we can call you back.'
      : 'A phone number or email address, whichever you prefer.';
    const timeLabel = q('[data-time-label]');
    if (timeLabel) timeLabel.textContent = TIME_LABELS[intent] || 'Best time';
    onIntent?.(intent);
  }

  function clearErrors() {
    alertBox.hidden = true;
    alertBox.textContent = '';
    form.querySelectorAll('[data-error-for]').forEach((p) => { p.hidden = true; p.textContent = ''; });
    form.querySelectorAll('[aria-invalid]').forEach((f) => f.removeAttribute('aria-invalid'));
  }

  function showErrors(errors) {
    let first = null;
    Object.entries(errors).forEach(([field, messages]) => {
      const slot = form.querySelector(`[data-error-for="${field}"]`);
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

  function showDone(title, message, reference) {
    done.querySelector('[data-inquiry-done-title]').textContent = title;
    done.querySelector('[data-inquiry-done-text]').textContent = message;
    const ref = done.querySelector('[data-inquiry-done-ref]');
    ref.hidden = !reference;
    ref.textContent = reference ? `Reference: ${reference}` : '';
    form.hidden = true;
    done.hidden = false;
    onDone?.();
    done.focus();
  }

  function reset({ intent = '', source = null, suite = null, care = null } = {}) {
    form.reset();
    clearErrors();
    form.hidden = false;
    done.hidden = true;
    submit.disabled = false;
    pending = false;
    q('[data-inquiry-key]').value = uuid();
    q('[data-inquiry-page]').value = window.location.href.split('#')[0].slice(0, 255);
    if (source !== null) q('[data-inquiry-source]').value = source;
    const params = new URLSearchParams(window.location.search);
    form.querySelectorAll('[data-inquiry-attr]').forEach((input) => {
      input.value = (params.get(input.dataset.inquiryAttr) || '').slice(0, 100);
    });
    if (intent) intentField.value = intent;
    applyIntent(intentField.value);
    if (suite && SUITES.includes(suite) && form.elements.suite_preference) form.elements.suite_preference.value = suite;
    if (care && CARES.includes(care) && form.elements.care_interest) form.elements.care_interest.value = care;
  }

  intentField.addEventListener('change', () => { clearErrors(); applyIntent(intentField.value); });
  scope.querySelector('[data-inquiry-again]')?.addEventListener('click', () => {
    reset();
    form.elements.first_name.focus();
  });

  // Page values that only the browser knows (URL, attribution).
  q('[data-inquiry-page]').value = window.location.href.split('#')[0].slice(0, 255);
  applyIntent(intentField.value);

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    if (pending) return;
    clearErrors();

    if (mode === 'preview') {
      showDone('This is a design preview: nothing was sent.', `This form is not connected to Mission Villa. To reach the team, please call ${PHONE}.`, null);
      return;
    }

    pending = true;
    submit.disabled = true;
    submit.setAttribute('aria-busy', 'true');
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
        showErrors({ form: [`This page has been open for a while. Please reload it and try again, or call ${PHONE}.`] });
      } else if (res.status === 429) {
        showErrors({ form: [`Too many requests from this connection. Please wait a little, or call ${PHONE}.`] });
      } else {
        showErrors({ form: [body.message || `We couldn’t save your request. Please call ${PHONE}.`] });
      }
    } catch {
      showErrors({ form: [`We couldn’t reach the website. Please check your connection, or call ${PHONE}.`] });
    } finally {
      submit.removeAttribute('aria-busy');
    }
    pending = false;
    submit.disabled = false;
  });

  return { reset, form, intent: () => intentField.value };
}

function initDialog(dialog) {
  const card = dialog.querySelector('[data-inquiry-scope]');
  const title = dialog.querySelector('[data-inquiry-title]');
  const lede = dialog.querySelector('[data-inquiry-lede]');
  let copy = {};
  try { copy = JSON.parse(dialog.dataset.copy || '{}'); } catch { copy = {}; }
  const intents = Object.keys(copy);
  let opener = null;

  const ctl = bindForm(card, {
    onIntent(intent) {
      const c = copy[intent] || {};
      title.textContent = c.title || '';
      lede.textContent = c.lede || '';
      lede.hidden = false;
      dialog.querySelector('[data-inquiry-submit-label]').textContent = c.submit || 'Send Request';
    },
    onDone() { lede.hidden = true; },
  });

  function open(intent, opts = {}) {
    if (!intents.includes(intent)) intent = intents[0];
    opener = document.activeElement;
    ctl.reset({ intent, source: opts.source ?? '', suite: opts.suite, care: opts.care });
    dialog.showModal();
    document.body.classList.add('is-scroll-locked');
    dialog.querySelector('.inquiry__body').scrollTop = 0;
    ctl.form.elements.first_name.focus();
  }

  dialog.addEventListener('close', () => {
    document.body.classList.remove('is-scroll-locked');
    // Return focus to the opener, unless it has disappeared (e.g. the closed mobile drawer).
    if (opener && typeof opener.focus === 'function' && opener.isConnected && opener.getClientRects().length) opener.focus();
    opener = null;
  });

  // Click on the backdrop (outside the card) closes; Escape is native <dialog> behaviour.
  dialog.addEventListener('click', (e) => { if (e.target === dialog) dialog.close(); });
  dialog.querySelectorAll('[data-inquiry-close]').forEach((b) => b.addEventListener('click', () => dialog.close()));

  return open;
}

function boot() {
  // Inline forms (Section 07 card) work with or without the modal.
  document.querySelectorAll('[data-inquiry-inline]').forEach((scope) => bindForm(scope));

  const dialog = document.querySelector('[data-inquiry-dialog]');
  if (!dialog || typeof dialog.showModal !== 'function') return; // tel: links remain as the fallback
  let aliases = {};
  try { aliases = JSON.parse(dialog.dataset.aliases || '{}'); } catch { aliases = {}; }
  const openModal = initDialog(dialog);

  const openInquiry = (intent, opts = {}) => openModal(aliases[intent] || intent, opts);
  window.MissionVilla = Object.assign(window.MissionVilla || {}, {
    openInquiry,
    openVisit: (opts = {}) => openInquiry('schedule_visit', opts),
  });

  document.addEventListener('click', (e) => {
    const trigger = e.target.closest('[data-inquiry]');
    if (!trigger || e.defaultPrevented) return;
    if (e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return; // let modified clicks follow the tel: fallback
    e.preventDefault();
    const d = trigger.dataset;
    const section = trigger.closest('section[id]');
    const source = d.inquirySource
      || (trigger.closest('.site-header, .site-mobile-nav') && 'header')
      || (trigger.closest('footer') && 'footer')
      || (section && SECTION_SOURCES[section.id])
      || '';
    openInquiry(d.inquiry, { source, suite: d.inquirySuite, care: d.inquiryCare });
  });
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', boot, { once: true });
} else {
  boot();
}
