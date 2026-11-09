<?php

namespace App\Content;

/**
 * Restricted inline rich text for editor-managed copy.
 *
 * Editors may emphasise words with <em> and <strong> only. Every other tag
 * and every attribute is stripped, so CMS content can never inject markup
 * that breaks the approved design or introduces scripts.
 */
final class InlineText
{
    private const ALLOWED = '<em><strong>';

    public static function sanitize(string $value): string
    {
        $value = strip_tags($value, self::ALLOWED);
        // Drop any attributes left on allowed tags: <strong class="x"> -> <strong>
        $value = preg_replace('/<(em|strong)\b[^>]*>/i', '<$1>', $value) ?? '';
        $value = preg_replace('/<\/(em|strong)\s*>/i', '</$1>', $value) ?? '';

        return trim($value);
    }

    /**
     * Render sanitized inline text, applying presentation classes that belong
     * to the section component rather than to stored content.
     *
     * @param  array<string, string>  $classes  e.g. ['strong' => 'font-semibold text-white']
     */
    public static function render(string $value, array $classes = []): string
    {
        $value = self::sanitize($value);

        // Escape text content while keeping the allowed tags intact.
        $parts = preg_split('/(<\/?(?:em|strong)>)/i', $value, -1, PREG_SPLIT_DELIM_CAPTURE) ?: [];
        $html = '';
        foreach ($parts as $part) {
            if (preg_match('/^<(\/?)(em|strong)>$/i', $part, $m)) {
                $tag = strtolower($m[2]);
                if ($m[1] === '' && isset($classes[$tag])) {
                    $html .= '<'.$tag.' class="'.e($classes[$tag]).'">';
                } else {
                    $html .= '<'.$m[1].$tag.'>';
                }
            } else {
                $html .= e(html_entity_decode($part, ENT_QUOTES | ENT_HTML5, 'UTF-8'), false);
            }
        }

        return $html;
    }

    public static function plain(string $value): string
    {
        return trim(html_entity_decode(strip_tags($value), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    }
}
