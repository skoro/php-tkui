<?php declare(strict_types=1);

namespace Tkui\Widgets\Consts;

/**
 * Values for 'relief' property.
 */
enum Relief: string
{
    case FLAT   = 'flat';
    case GROOVE = 'groove';
    case RAISED = 'raised';
    case RIDGE  = 'ridge';
    case SOLID  = 'solid';
    case SUNKEN = 'sunken';
}
