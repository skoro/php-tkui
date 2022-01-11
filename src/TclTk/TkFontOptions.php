<?php declare(strict_types=1);

namespace Tkui\TclTk;

use Tkui\Options;

/**
 * @property string $family
 * @property int $size
 * @property string $weight
 * @property string $slant
 * @property bool $underline
 * @property bool $overstrike
 */
class TkFontOptions extends Options
{
    /**
     * @inheritdoc
     */
    protected function defaults(): array
    {
        return [
            'family' => null,
            'size' => null,
            'weight' => null,
            'slant' => null,
            'underline' => null,
            'overstrike' => null,
        ];
    }
}