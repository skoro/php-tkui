<?php declare(strict_types=1);

namespace Tkui\Layouts;

use Tkui\Options;

/**
 * pack geometry manager.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/pack.htm
 *
 */
class Pack extends BaseManager
{
    const SIDE_LEFT = 'left';
    const SIDE_RIGHT = 'right';
    const SIDE_TOP = 'top';
    const SIDE_BOTTOM = 'bottom';

    const FILL_X = 'x';
    const FILL_Y = 'y';
    const FILL_BOTH = 'both';

    /**
     * @inheritdoc
     */
    protected function createLayoutOptions(): Options
    {
        return new Options([
            'side' => null,
            'fill' => null,
            'expand' => null,
            'ipadx' => null,
            'ipady' => null,
            'padx' => null,
            'pady' => null,
            'anchor' => null,
            'after' => null,
            'before' => null,
        ]);
    }

    /**
     * @inheritdoc
     */
    protected function command(): string
    {
        return 'pack';
    }
}