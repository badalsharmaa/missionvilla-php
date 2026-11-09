<?php

namespace App\Http\Controllers;

use App\Http\Requests\InquiryRequest;
use App\Integrations\Leads\LeadDestination;
use App\Integrations\Leads\LeadIntake;
use App\Integrations\Leads\UnconfiguredLeadDestination;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * POST /inquiries: the single endpoint behind Schedule a Visit, Request
 * Pricing and Request a Call.
 *
 * Order of operations follows docs/INTEGRATION_PLAN.md: validate, store in
 * the lead_submissions outbox, then (once a real destination exists) deliver.
 * The response only ever says what actually happened: "saved" is reported
 * after the database write succeeds, and "not sent" is reported while no
 * lead destination is connected. No email is sent from here.
 */
class InquiryController extends Controller
{
    public function __construct(
        private readonly LeadIntake $intake,
        private readonly LeadDestination $destination,
    ) {}

    public function store(InquiryRequest $request): JsonResponse|RedirectResponse
    {
        $cfg = config('missionvilla.inquiries');
        $phone = config('missionvilla.phone.display');

        if (! $cfg['store']) {
            return $this->respond($request, 503, [
                'status' => 'disabled',
                'message' => "Online requests are switched off on this site. Please call {$phone}.",
            ]);
        }

        $v = $request->validated();
        $intent = $v['intent'];

        try {
            $lead = $this->intake->accept([
                'kind' => $cfg['intents'][$intent]['kind'],
                'care_interest' => isset($v['care_interest']) ? $cfg['care_interests'][$v['care_interest']] : null,
                'contact' => array_filter([
                    'name' => $v['name'],
                    'phone' => $v['phone'] ?? null,
                    'email' => $v['email'] ?? null,
                ]),
                'details' => array_filter([
                    'intent' => $intent,
                    'suite_preference' => $intent === 'request_pricing' ? ($v['suite_preference'] ?? null) : null,
                    'contact_time' => $intent !== 'request_pricing' ? ($v['contact_time'] ?? null) : null,
                ]),
                'consent' => [
                    'transactional' => true,
                    'marketing' => (bool) ($v['marketing_opt_in'] ?? false),
                    'text_version' => $cfg['consent_version'],
                    'recorded_at' => now()->toIso8601String(),
                    'page_url' => $v['page_url'] ?? null,
                ],
                'attribution' => array_filter([
                    'utm_source' => $v['utm_source'] ?? null,
                    'utm_medium' => $v['utm_medium'] ?? null,
                    'utm_campaign' => $v['utm_campaign'] ?? null,
                    'utm_term' => $v['utm_term'] ?? null,
                    'utm_content' => $v['utm_content'] ?? null,
                    'gclid' => $v['gclid'] ?? null,
                    'fbclid' => $v['fbclid'] ?? null,
                    'referrer' => substr((string) $request->headers->get('referer'), 0, 255) ?: null,
                    'landing_page' => $v['page_url'] ?? null,
                ]),
            ], $v['idempotency_key']);
        } catch (Throwable $e) {
            // Log the failure without any contact details.
            Log::error('Inquiry could not be stored', ['intent' => $intent, 'exception' => $e::class]);

            return $this->respond($request, 503, [
                'status' => 'error',
                'message' => "We couldn’t save your request just now. Please call us at {$phone}.",
            ]);
        }

        $connected = ! $this->destination instanceof UnconfiguredLeadDestination;
        Log::info('Inquiry stored', ['lead' => $lead->uuid, 'kind' => $lead->kind]);

        return $this->respond($request, 201, [
            'status' => 'received',
            'intent' => $intent,
            'reference' => strtoupper(substr($lead->uuid, 0, 8)),
            'delivered' => false,
            'delivery' => $connected ? 'pending' : 'not_connected',
            'message' => $connected
                ? 'Thank you. Your request has been received and will be passed to our Daly City team.'
                : "Your request was saved on this website, but it has not been sent to Mission Villa’s team yet: online requests are not connected while the site is in development. To arrange this now, please call {$phone}.",
        ]);
    }

    private function respond(InquiryRequest $request, int $status, array $payload): JsonResponse|RedirectResponse
    {
        if ($request->expectsJson()) {
            return response()->json($payload, $status);
        }

        // No-JavaScript fallback: back to the closing section with the same honest message.
        return redirect()->to(url('/').'#visit')->with('inquiry_notice', $payload);
    }
}
