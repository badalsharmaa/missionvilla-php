<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Server-side validation for the shared inquiry form
 * (Schedule a Visit · Request Pricing · Request a Call).
 *
 * Collects only what the selected intent needs: a name plus a way to reply.
 * A callback needs a phone number; the other intents need a phone number or
 * an email address. There is deliberately no free-text field, so visitors are
 * never invited to type medical details into the website.
 */
class InquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $trim = fn ($v) => is_string($v) ? trim(preg_replace('/\s+/u', ' ', $v)) : $v;

        $this->merge([
            'name' => $trim($this->input('name')),
            'phone' => $trim($this->input('phone')) ?: null,
            'email' => $trim($this->input('email')) ?: null,
            'marketing_opt_in' => $this->boolean('marketing_opt_in'),
        ]);
    }

    public function rules(): array
    {
        $cfg = config('missionvilla.inquiries');
        $in = fn (string $key) => 'in:'.implode(',', array_keys($cfg[$key]));
        $isCallback = $this->input('intent') === 'request_callback';

        return [
            'intent' => ['required', 'string', $in('intents')],
            'name' => ['required', 'string', 'min:2', 'max:80'],
            'phone' => [
                $isCallback ? 'required' : 'required_without:email',
                'nullable', 'string', 'max:30', 'regex:/^[0-9+().\-\s]+$/',
                function (string $attr, $value, $fail) {
                    $digits = strlen(preg_replace('/\D/', '', (string) $value));
                    if ($digits < 10 || $digits > 15) {
                        $fail('Please enter a phone number with area code.');
                    }
                },
            ],
            'email' => ['required_without:phone', 'nullable', 'string', 'max:120', 'email:rfc'],
            'care_interest' => ['nullable', 'string', $in('care_interests')],
            'suite_preference' => ['nullable', 'string', $in('suite_preferences')],
            'contact_time' => ['nullable', 'string', $in('contact_times')],
            // Marketing consent is separate from the service request and off by default.
            'marketing_opt_in' => ['boolean'],
            // One key per opened form: double clicks and retries store a single lead.
            'idempotency_key' => ['required', 'uuid'],
            // Honeypot: real visitors never see or fill this field.
            'company_website' => ['prohibited'],
            'page_url' => ['nullable', 'string', 'max:255', 'url:https,http'],
            'utm_source' => ['nullable', 'string', 'max:100'],
            'utm_medium' => ['nullable', 'string', 'max:100'],
            'utm_campaign' => ['nullable', 'string', 'max:100'],
            'utm_term' => ['nullable', 'string', 'max:100'],
            'utm_content' => ['nullable', 'string', 'max:100'],
            'gclid' => ['nullable', 'string', 'max:200'],
            'fbclid' => ['nullable', 'string', 'max:200'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please tell us your name.',
            'name.min' => 'Please tell us your name.',
            'phone.required' => 'Please add a phone number so we can call you back.',
            'phone.required_without' => 'Please add a phone number or an email address.',
            'phone.regex' => 'Please enter a phone number with area code.',
            'email.required_without' => 'Please add a phone number or an email address.',
            'email.email' => 'Please check the email address.',
            'company_website.prohibited' => 'We could not accept this request.',
            'intent.*' => 'Please choose what you would like to do.',
        ];
    }
}
