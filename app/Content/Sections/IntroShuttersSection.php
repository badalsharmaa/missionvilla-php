<?php

namespace App\Content\Sections;

use App\Content\Contracts\SectionSchema;
use App\Content\InlineText;
use App\Content\InvalidSectionData;
use Illuminate\Support\Facades\Validator;

/**
 * Opening scene: two-panel French conservatory shutters that part from the
 * centre seam to reveal the page (React reference: components/ConservatoryShutters.tsx).
 *
 * Page-level overlay placed before the hero. Editors may change the panel
 * copy or disable the intro entirely; motion and layout are fixed.
 */
final class IntroShuttersSection implements SectionSchema
{
    public static function type(): string
    {
        return 'intro.shutters';
    }

    public static function label(): string
    {
        return 'Opening scene (conservatory shutters)';
    }

    public static function view(): string
    {
        return 'sections.intro-shutters.index';
    }

    public function normalize(array $data): array
    {
        $fields = ['left_script', 'left_kicker', 'left_tagline', 'left_footer', 'right_top', 'right_kicker', 'right_tagline', 'right_footer', 'skip_label'];

        $validator = Validator::make($data, array_fill_keys($fields, ['required', 'string', 'max:60']));

        if ($validator->fails()) {
            throw new InvalidSectionData(self::type(), $validator->errors()->toArray());
        }

        return array_map(fn (string $v) => InlineText::plain($v), $validator->validated());
    }
}
