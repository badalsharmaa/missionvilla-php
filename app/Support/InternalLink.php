<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Throwable;

/**
 * Answers "is this destination built yet?" for CMS-authored links.
 *
 * Internal pages are added to the PHP site one at a time, so a link to a
 * page that only exists in the React reference would 404. Sections use this
 * to fall back to a safe action (e.g. the visit dialog) until the page ships.
 */
final class InternalLink
{
    public static function isAvailable(string $href): bool
    {
        if (str_starts_with($href, 'https://')) {
            return true;
        }
        if (! str_starts_with($href, '/') || str_starts_with($href, '//')) {
            return false;
        }

        $path = parse_url($href, PHP_URL_PATH) ?: '/';

        try {
            app(Router::class)->getRoutes()->match(Request::create($path, 'GET'));

            return true;
        } catch (Throwable) {
            return false;
        }
    }
}
