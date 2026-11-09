<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AuditLog extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = ['user_id', 'action', 'subject_type', 'subject_id', 'context', 'ip_address', 'user_agent'];

    protected function casts(): array
    {
        return ['context' => 'array'];
    }

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    /** Record an administrative action. Never pass secrets or full PII payloads in $context. */
    public static function record(string $action, ?Model $subject = null, array $context = []): self
    {
        $request = request();

        return self::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'subject_type' => $subject?->getMorphClass(),
            'subject_id' => $subject?->getKey(),
            'context' => $context ?: null,
            'ip_address' => $request?->ip(),
            'user_agent' => substr((string) $request?->userAgent(), 0, 255) ?: null,
        ]);
    }
}
