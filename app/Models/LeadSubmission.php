<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadSubmission extends Model
{
    public const STATUS_RECEIVED = 'received';

    public const STATUS_QUEUED = 'queued';

    public const STATUS_DELIVERED = 'delivered';

    public const STATUS_FAILED = 'failed';

    public const STATUS_ABANDONED = 'abandoned';

    protected $fillable = ['uuid', 'idempotency_key', 'kind', 'care_interest', 'contact', 'details', 'consent', 'attribution', 'status', 'delivery_attempts', 'destination', 'external_reference', 'last_error', 'delivered_at'];

    // Contact data is personal information: keep it out of serialisation by default.
    protected $hidden = ['contact'];

    protected function casts(): array
    {
        return [
            'contact' => 'encrypted:array',
            'details' => 'array',
            'consent' => 'array',
            'attribution' => 'array',
            'delivered_at' => 'datetime',
        ];
    }
}
