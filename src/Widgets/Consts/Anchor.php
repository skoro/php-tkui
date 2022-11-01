<?php declare(strict_types=1);

namespace Tkui\Widgets\Consts;

/**
 * Values for 'anchor' property.
 */
enum Anchor: string
{
    case ANCHOR_N = 'n';
    case ANCHOR_NE = 'ne';
    case ANCHOR_E = 'e';
    case ANCHOR_SE = 'se';
    case ANCHOR_S = 's';
    case ANCHOR_SW = 'sw';
    case ANCHOR_W = 'w';
    case ANCHOR_NW = 'nw';
    case ANCHOR_CENTER = 'center';
}
