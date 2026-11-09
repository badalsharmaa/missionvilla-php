<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Durable lead outbox. Every website submission is stored locally first,
 * then delivered to the configured destination (Synergy Hub, later) with
 * retries. A lead is only "delivered" when the receiver confirms it.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lead_submissions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('idempotency_key', 80)->unique(); // duplicate-submit protection
            $table->string('kind', 30);                       // visit_request | callback_request
            $table->string('care_interest', 60)->nullable();
            $table->text('contact');                          // encrypted at rest (APP_KEY); minimum needed: name, phone/email
            $table->json('details')->nullable();              // e.g. preferred time
            $table->json('consent');                          // transactional + marketing flags, text version, timestamp
            $table->json('attribution')->nullable();          // utm_*, referrer, landing page
            $table->string('status', 20)->default('received')->index(); // received|queued|delivered|failed|abandoned
            $table->unsignedSmallInteger('delivery_attempts')->default(0);
            $table->string('destination', 40)->nullable();
            $table->string('external_reference')->nullable(); // receiver-confirmed id
            $table->text('last_error')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lead_submissions');
    }
};
