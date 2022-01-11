<?php declare(strict_types=1);

namespace Tkui\Layouts;

use Tkui\Options;

/**
 * Geometry manager allows fixed placement.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/place.html
 *
 * @property string $anchor
 * @property string $borderMode
 * @property int $height
 * @property string $in
 * @property float $relheight
 * @property float $relwidth
 * @property float $relx
 * @property float $rely
 * @property int $width
 * @property int $x
 * @property int $y
 */
class Place extends BaseManager
{
    const BORDER_MODE_INSIDE = 'inside';
    const BORDER_MODE_OUTSIDE = 'outside';
    const BORDER_MODE_IGNORE = 'ignore';

    /**
     * @inheritdoc
     */
    protected function createLayoutOptions(): Options
    {
        return new Options([
            'anchor' => null,
            'borderMode' => null,
            'height' => null,
            'in' => null,
            'relheight' => null,
            'relwidth' => null,
            'relx' => null,
            'rely' => null,
            'width' => null,
            'x' => null,
            'y' => null,
        ]);
    }

    /**
     * @inheritdoc
     */
    protected function command(): string
    {
        return 'place';
    }
}
