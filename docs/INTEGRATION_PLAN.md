# Integration Plan — Synergy Hub, Hiraya Bridge, Email

_Status 2026-11-09: a public inquiry endpoint now **stores** leads locally. **No integration is implemented,
and no lead, message or email is sent anywhere.**_

The Synergy Hub codebase and APIs were **not inspected** in this session. Nothing below assumes
any Synergy Hub endpoint, payload or auth scheme. These must be read from Synergy Hub's own
repository and docs before an adapter is written.

## 1. Principles

1. The website stores first, delivers second. A lead is never lost because a downstream system is down.
2. A lead is "delivered" **only** when the receiver confirms it and returns a reference.
3. Credentials stay server-side (`.env`), never in browser JavaScript.
4. Share the minimum personal data needed. Never collect health or medical history on the website.
5. Transactional communication (confirmations, staff alerts) is separate from marketing.
   Marketing requires explicit, recorded opt-in.
6. The website does not duplicate marketing automation that Synergy Hub owns.

## 2. Lead flow (target)

```
Browser form ──POST (CSRF, rate-limited, honeypot)──▶ LeadController (server validation)
   ▶ LeadIntake::accept()        store in lead_submissions (status=received, idempotency key)
   ▶ queue DeliverLeadSubmission job
        ▶ LeadIntake::attemptDelivery() ▶ LeadDestination::deliver()
              confirmed(ref)  → status=delivered, external_reference saved
              retryLater(err) → status=queued, retried with backoff
              rejected(err)   → status=failed, staff alerted, record kept
   ▶ Browser receives "request received" (not "delivered") with phone fallback
```

### Implemented now (`app/Integrations/Leads`)

| Piece | State |
|---|---|
| `lead_submissions` table (outbox, encrypted contact, consent, attribution, status, attempts) | Migrated |
| `LeadIntake` (idempotent accept + single delivery attempt + status rules) | Built, unit-tested |
| `LeadDestination` interface + `DeliveryResult` (confirmed / retryLater / rejected) | Built |
| `UnconfiguredLeadDestination` (default binding, never claims delivery) | Built, tested |
| Public lead route `POST /inquiries` + `InquiryRequest` + `InquiryController` | **Built 2026-11-09.** Shared by every inquiry path: the site-wide inquiry modal (all form CTAs, five intents) and the inline card in Section 07 (same form partial, same rules). CSRF, per-intent validation, honeypot, throttle 5/min + 20/day per IP, uuid idempotency key, attribution capture. Stores via `LeadIntake::accept()` and tells the visitor "saved, not sent" while the destination is unconfigured |
| Queue job / delivery attempt | **Not built.** Nothing calls `attemptDelivery()` yet |
| Hero visit dialog | **Retired 2026-11-10.** Every Schedule a Visit (hero included) opens the shared inquiry modal and posts to `/inquiries` |

### To build (after Synergy Hub inspection)

- `SynergyHubLeadDestination` that maps `LeadSubmission` to the verified Synergy Hub contract.
  Timeouts, retry classification (5xx/timeout = retry, 4xx = reject), and the idempotency key
  forwarded if supported.
- `DeliverLeadSubmission` queued job with exponential backoff. Hostinger cron runs
  `php artisan schedule:run` → `queue:work --stop-when-empty`.
- Staff notification on `failed`, plus an admin "Leads" view (gate `view-leads`).
- Operational logging: status transitions logged with the lead UUID, never with contact details.
- Retention policy: purge or anonymise contact data after the agreed period.

## 3. Lead payload (website side, minimum)

| Field | Notes |
|---|---|
| `kind` | `visit_request`, `pricing_request`, `availability_request`, `callback_request`, `general_inquiry` (from intents `schedule_visit`, `request_pricing`, `request_availability`, `request_callback`, `general_inquiry`; added availability + general 2026-11-10) |
| `care_interest` | `Legacies Memory Care`, `Short-Term Respite Care`, `Exploring Options` |
| `contact` | `name` (first + last), `first_name`, `last_name` (optional), plus phone and/or email (encrypted at rest) |
| `details` | `intent`, `source` (site area that opened the form: header, hero, suites, faq, visit-cta, visit-form, footer, …), `suite_preference` (pricing/availability), `contact_time` (visit/callback). No free-text field. **No medical information** |
| `consent` | `transactional: true`, `marketing: bool` (separate unchecked box), `text_version` (`missionvilla.inquiries.consent_version`), `recorded_at`, `page_url` |
| `attribution` | `utm_source/medium/campaign/term/content`, `gclid`/`fbclid` if present, referrer, landing page, first/last touch |

## 4. Care Guide / Hiraya Bridge

- **Now:** the hero ships the approved scripted preview (`getCareGuideReply` in
  `resources/js/sections/hero-cinematic.js`). It is labelled "Guided demo, not live chat" and
  "not a live AI". No network calls, no storage.
- **Boundary:** `App\Integrations\Concierge\CareGuideResponder` (interface only).
- **Target:** the browser calls a rate-limited, CSRF-protected Laravel endpoint, which calls
  Hiraya Bridge server-side. Requirements:
  - Answers come only from approved Mission Villa content. No diagnosis, no clinical claims.
  - Every conversation offers human handoff (call or visit request).
  - Conversation context is retained only with explicit visitor consent.
  - A lead event goes to Synergy Hub only after the visitor submits contact details with consent,
    through the same `LeadIntake` outbox.
  - Labelling changes from "preview" to live only once the live service is connected and approved.

## 5. Email

| Type | Owner | Notes |
|---|---|---|
| Visitor confirmation after a stored submission | Website (Laravel Mail) or Synergy Hub | Transactional. Must not claim staff have received it unless delivery is confirmed |
| Internal staff notification | Website or Synergy Hub | Transactional |
| Follow-up / nurture sequences (visit, Memory Care, Respite) | **Synergy Hub** | Requires marketing consent |
| Unsubscribe, suppression, re-engagement | **Synergy Hub** | Website only records the opt-in |

No mail transport is configured (`MAIL_MAILER=log` locally). No email is sent in this phase.

## 6. Open questions for the Synergy Hub owner

1. Lead intake API: endpoint, auth (token or HMAC), payload schema, idempotency support, response contract.
2. Is lead assignment and status managed entirely in Synergy Hub, or should status be pushed back via webhook?
3. Which side sends the visitor confirmation email?
4. Consent text versions: does Synergy Hub store them, or only the opt-in flag?
5. Attribution model: which UTM and click-ID fields does reporting need?
