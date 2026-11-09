<?php

use App\Content\Media\LifeGalleryManifest;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Read-only check for the Section 03 media hand-off (docs/SECTION_03_VIDEO_CONTRACT.md).
Artisan::command('missionvilla:life-media {manifest=/media/mission-villa/life-at-mission-villa/media-manifest.json}', function (string $manifest) {
    $report = (new LifeGalleryManifest(public_path()))->inspect($manifest);

    if ($report['status'] === 'missing') {
        $this->warn("No manifest at public{$manifest}. Every chapter shows its fallback still (\"film in production\").");

        return 0;
    }
    if ($report['status'] === 'invalid') {
        $this->error('Manifest is INVALID and will be ignored by the website:');
        foreach ($report['errors'] as $field => $messages) {
            foreach ($messages as $message) {
                $this->line("  - {$field}: {$message}");
            }
        }

        return 1;
    }

    $expected = ['living-spaces', 'dining-daily-life', 'meaningful-connection'];
    $rows = [];
    foreach ($expected as $id) {
        $c = $report['chapters'][$id] ?? null;
        $rows[] = [
            $id,
            $c && $c['sources'] ? 'yes' : 'NO (file missing or not listed)',
            $c && $c['poster'] ? 'yes' : 'fallback still',
            $c ? count($c['captions']) : 0,
            $c['duration_seconds'] ?? '-',
            $c['provenance'] ?? '-',
        ];
    }
    $this->table(['chapter', 'playable', 'poster', 'captions', 'duration (s)', 'provenance'], $rows);
    foreach (array_diff(array_keys($report['chapters']), $expected) as $extra) {
        $this->warn("Manifest chapter [{$extra}] is not used by the homepage section.");
    }

    return 0;
})->purpose('Validate the Life at Mission Villa media manifest and files');
