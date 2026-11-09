<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaAsset extends Model
{
    public const PROVENANCE_FACILITY = 'facility';

    public const PROVENANCE_ILLUSTRATIVE = 'illustrative';

    protected $fillable = ['disk', 'path', 'mime_type', 'size_bytes', 'width', 'height', 'checksum_sha256', 'alt_text', 'provenance', 'source_url', 'credit', 'uploaded_by'];
}
