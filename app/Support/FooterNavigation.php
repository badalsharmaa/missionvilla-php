<?php

namespace App\Support;

/**
 * Resolves the configured footer (config/navigation.php → footer) into links
 * that are safe to render today.
 *
 * Internal pages ship one at a time, so each link names its real destination
 * and an optional fallback that already exists (a homepage section anchor):
 *
 *   - `href` is routed           → link to the real page
 *   - otherwise `fallback` given → link to the fallback (e.g. "/#suites"),
 *                                  labelled `fallback_label` when given
 *   - otherwise                  → the link is left out
 *
 * Groups with no remaining links are dropped. Only site-relative paths and
 * https URLs are accepted; anything else (javascript:, data:, //host) is
 * discarded, so a bad CMS value can never render.
 */
final class FooterNavigation
{
    /**
     * @param  array<int, array{title?: string, links?: array}>  $groups
     * @return array<int, array{title: string, links: array<int, array{label: string, href: string, pending: bool}>}>
     */
    public static function groups(array $groups): array
    {
        $out = [];
        foreach ($groups as $group) {
            $links = self::links($group['links'] ?? []);
            if ($links !== [] && trim((string) ($group['title'] ?? '')) !== '') {
                $out[] = ['title' => (string) $group['title'], 'links' => $links];
            }
        }

        return $out;
    }

    /**
     * @param  array<int, array{label?: string, href?: string, fallback?: string, fallback_label?: string}>  $links
     * @return array<int, array{label: string, href: string, pending: bool}>
     */
    public static function links(array $links): array
    {
        $out = [];
        foreach ($links as $link) {
            $label = trim((string) ($link['label'] ?? ''));
            $href = (string) ($link['href'] ?? '');
            $fallback = isset($link['fallback']) ? (string) $link['fallback'] : null;

            if ($label === '') {
                continue;
            }
            if (self::isSafe($href) && InternalLink::isAvailable($href)) {
                $out[] = ['label' => $label, 'href' => $href, 'pending' => false];
            } elseif ($fallback !== null && self::isSafe($fallback) && InternalLink::isAvailable($fallback)) {
                // `pending` marks "real page not built yet" for tests and future styling.
                $fallbackLabel = trim((string) ($link['fallback_label'] ?? ''));
                $out[] = ['label' => $fallbackLabel !== '' ? $fallbackLabel : $label, 'href' => $fallback, 'pending' => true];
            }
        }

        return $out;
    }

    private static function isSafe(string $href): bool
    {
        return (bool) preg_match('~^(/(?!/)[^\s]*|https://[^\s]+)$~', $href);
    }
}
