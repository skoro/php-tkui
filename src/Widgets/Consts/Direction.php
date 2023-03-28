<?php

declare(strict_types=1);

namespace Tkui\Widgets\Consts;

/**
 * Values for 'direction' property.
 */
enum Direction: string
{
    case ABOVE  = 'above';
    case BELOW  = 'below';
    case LEFT   = 'left';
    case RIGHT  = 'right';
    case FLUSH  = 'flush';
}
