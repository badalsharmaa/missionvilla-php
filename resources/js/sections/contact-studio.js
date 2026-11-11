/**
 * Contact Section 02: Split Editorial Contact Studio & Guided Inquiry Prototype Form.
 *
 * Implements client-side validation, quick inquiry preset buttons, dynamic
 * telephone/email requirement toggling, and honest "Demo only — no inquiry sent"
 * preview feedback state.
 */

document.addEventListener('DOMContentLoaded', () => {
    initCopyAddress();
    initContactForm();
});

function initCopyAddress() {
    document.querySelectorAll('[data-copy-address]').forEach((button) => {
        button.addEventListener('click', async () => {
            const address = button.getAttribute('data-copy-address');
            if (!address) return;

            try {
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    await navigator.clipboard.writeText(address);
                }
            } catch (err) {
                // Clipboard fallback if blocked
            }

            const label = button.querySelector('.contact-hero__copy-label') || button.querySelector('span:last-child');
            if (label) {
                const originalText = label.textContent;
                label.textContent = 'Address copied!';
                setTimeout(() => {
                    label.textContent = originalText;
                }, 2500);
            }
        });
    });
}

function initContactForm() {
    const studio = document.querySelector('[data-contact-studio]');
    if (!studio) return;

    const form = studio.querySelector('[data-contact-form]');
    const confirmation = studio.querySelector('#contact-demo-confirmation');
    const summaryDl = studio.querySelector('[data-confirm-summary]');
    const resetBtn = studio.querySelector('[data-reset-demo-form]');

    const methodSelect = form?.querySelector('#contact-preferred-method');
    const phoneLabel = form?.querySelector('[data-phone-label]');
    const emailLabel = form?.querySelector('[data-email-label]');

    // Preset Buttons
    studio.querySelectorAll('[data-preset-intent]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const intent = btn.getAttribute('data-preset-intent');
            const care = btn.getAttribute('data-preset-care');
            const suite = btn.getAttribute('data-preset-suite');
            const message = btn.getAttribute('data-preset-message');
            const referral = btn.getAttribute('data-preset-referral');

            if (!form) return;

            // Select radio intent
            const radio = form.querySelector(`input[name="inquiry_intent"][value="${intent}"]`);
            if (radio) radio.checked = true;

            // Care interest
            const careSelect = form.querySelector('#contact-care-interest');
            if (careSelect && care) careSelect.value = care;

            // Suite format
            const suiteSelect = form.querySelector('#contact-suite-preference');
            if (suiteSelect && suite) suiteSelect.value = suite;

            // Message
            const msgArea = form.querySelector('#contact-message');
            if (msgArea && message) msgArea.value = message;

            // Referral note
            const refInput = form.querySelector('#contact-referral-note');
            if (refInput && referral) refInput.value = referral;

            // Reset demo confirmation if open
            if (confirmation && !confirmation.hidden) {
                confirmation.hidden = true;
                form.hidden = false;
            }

            // Clear errors
            clearErrors(form);

            // Scroll to form
            studio.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });

    // Method selection toggles required marks
    if (methodSelect && phoneLabel && emailLabel) {
        methodSelect.addEventListener('change', () => {
            updateMethodLabels(methodSelect.value, phoneLabel, emailLabel);
        });
        updateMethodLabels(methodSelect.value, phoneLabel, emailLabel);
    }

    // Form submission
    if (form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            clearErrors(form);

            const formData = new FormData(form);
            const fullName = (formData.get('full_name') || '').toString().trim();
            const preferredMethod = (formData.get('preferred_method') || 'Either Phone or Email').toString();
            const phone = (formData.get('phone') || '').toString().trim();
            const email = (formData.get('email') || '').toString().trim();
            const careInterest = (formData.get('care_interest') || '').toString();
            const suitePreference = (formData.get('suite_preference') || '').toString();
            const inquiryIntent = (formData.get('inquiry_intent') || '').toString();
            const preferredWindow = (formData.get('preferred_window') || '').toString();
            const visitTiming = (formData.get('visit_timing') || '').toString().trim();
            const message = (formData.get('message') || '').toString().trim();
            const referralNote = (formData.get('referral_note') || '').toString().trim();
            const consentAccepted = form.querySelector('#contact-consent-checkbox')?.checked;

            const errors = {};

            if (fullName.length < 2) {
                errors.full_name = 'Please enter your full name so our team knows how to address you.';
            }

            const digitsOnly = phone.replace(/\D/g, '');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const hasValidPhone = digitsOnly.length >= 10;
            const hasValidEmail = emailRegex.test(email);

            if (preferredMethod === 'Phone Call') {
                if (!hasValidPhone) {
                    errors.phone = 'Please enter a valid 10-digit telephone number for a phone call.';
                }
                if (email.length > 0 && !hasValidEmail) {
                    errors.email = 'Please enter a valid email address or leave blank if preferring phone only.';
                }
            } else if (preferredMethod === 'Email') {
                if (!hasValidEmail) {
                    errors.email = 'Please enter a valid email address so we can reply by email.';
                }
                if (phone.length > 0 && !hasValidPhone) {
                    errors.phone = 'Please enter a valid 10-digit phone number or leave blank if preferring email only.';
                }
            } else {
                if (!hasValidPhone) {
                    errors.phone = 'Please enter a valid 10-digit phone number.';
                }
                if (!hasValidEmail) {
                    errors.email = 'Please enter a valid email address.';
                }
            }

            if (!careInterest) {
                errors.care_interest = 'Please select the care program you are exploring.';
            }

            if (!consentAccepted) {
                errors.consent_accepted = 'Please acknowledge the contact and privacy consent note before previewing submission.';
            }

            if (Object.keys(errors).length > 0) {
                showErrors(form, errors);
                return;
            }

            // Valid Demo Submission: Render summary DL
            if (summaryDl) {
                summaryDl.innerHTML = `
                    <div class="contact-studio__confirm-item">
                        <dt class="contact-studio__confirm-dt">Full Name</dt>
                        <dd class="contact-studio__confirm-dd">${escapeHtml(fullName)}</dd>
                    </div>
                    <div class="contact-studio__confirm-item">
                        <dt class="contact-studio__confirm-dt">Preferred Contact Method</dt>
                        <dd class="contact-studio__confirm-dd">${escapeHtml(preferredMethod)}</dd>
                    </div>
                    <div class="contact-studio__confirm-item">
                        <dt class="contact-studio__confirm-dt">Telephone</dt>
                        <dd class="contact-studio__confirm-dd tabular-nums">${escapeHtml(phone || 'Not provided (Email preferred)')}</dd>
                    </div>
                    <div class="contact-studio__confirm-item">
                        <dt class="contact-studio__confirm-dt">Email Address</dt>
                        <dd class="contact-studio__confirm-dd">${escapeHtml(email || 'Not provided (Phone preferred)')}</dd>
                    </div>
                    <div class="contact-studio__confirm-item">
                        <dt class="contact-studio__confirm-dt">Inquiry Purpose</dt>
                        <dd class="contact-studio__confirm-dd">${escapeHtml(inquiryIntent)}</dd>
                    </div>
                    <div class="contact-studio__confirm-item">
                        <dt class="contact-studio__confirm-dt">Preferred Contact Window</dt>
                        <dd class="contact-studio__confirm-dd">${escapeHtml(preferredWindow)}</dd>
                    </div>
                    <div class="contact-studio__confirm-item">
                        <dt class="contact-studio__confirm-dt">Care Program Interest</dt>
                        <dd class="contact-studio__confirm-dd">${escapeHtml(careInterest)}</dd>
                    </div>
                    <div class="contact-studio__confirm-item">
                        <dt class="contact-studio__confirm-dt">Suite Format Interest</dt>
                        <dd class="contact-studio__confirm-dd">${escapeHtml(suitePreference)}</dd>
                    </div>
                    ${visitTiming ? `
                        <div class="contact-studio__confirm-item contact-studio__confirm-item--full">
                            <dt class="contact-studio__confirm-dt">Preferred Visit Day / Timing</dt>
                            <dd class="contact-studio__confirm-dd">${escapeHtml(visitTiming)}</dd>
                        </div>
                    ` : ''}
                    ${message ? `
                        <div class="contact-studio__confirm-item contact-studio__confirm-item--full">
                            <dt class="contact-studio__confirm-dt">Family Questions / Notes</dt>
                            <dd class="contact-studio__confirm-dd">${escapeHtml(message)}</dd>
                        </div>
                    ` : ''}
                    ${referralNote ? `
                        <div class="contact-studio__confirm-item contact-studio__confirm-item--full">
                            <dt class="contact-studio__confirm-dt">Referral Context</dt>
                            <dd class="contact-studio__confirm-dd">${escapeHtml(referralNote)}</dd>
                        </div>
                    ` : ''}
                `;
            }

            form.hidden = true;
            if (confirmation) {
                confirmation.hidden = false;
                confirmation.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    }

    // Reset button
    if (resetBtn && form && confirmation) {
        resetBtn.addEventListener('click', () => {
            confirmation.hidden = true;
            form.hidden = false;
            clearErrors(form);
            form.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    }
}

function updateMethodLabels(method, phoneLabel, emailLabel) {
    if (method === 'Phone Call') {
        phoneLabel.innerHTML = 'Telephone Number <span class="contact-studio__req-mark">*</span>';
        emailLabel.innerHTML = 'Email Address <span class="contact-studio__disclaimer-note">(Optional)</span>';
    } else if (method === 'Email') {
        phoneLabel.innerHTML = 'Telephone Number <span class="contact-studio__disclaimer-note">(Optional)</span>';
        emailLabel.innerHTML = 'Email Address <span class="contact-studio__req-mark">*</span>';
    } else {
        phoneLabel.innerHTML = 'Telephone Number <span class="contact-studio__req-mark">*</span>';
        emailLabel.innerHTML = 'Email Address <span class="contact-studio__req-mark">*</span>';
    }
}

function clearErrors(form) {
    form.querySelectorAll('[data-error-for]').forEach((el) => {
        el.hidden = true;
        el.textContent = '';
    });
}

function showErrors(form, errors) {
    for (const [field, msg] of Object.entries(errors)) {
        const errorEl = form.querySelector(`[data-error-for="${field}"]`);
        if (errorEl) {
            errorEl.textContent = msg;
            errorEl.hidden = false;
        }
    }
}

function escapeHtml(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
}
