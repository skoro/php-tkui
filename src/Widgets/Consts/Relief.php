<?php declare(strict_types=1);

namespace Tkui\Widgets\Consts;

/**
 * Values for 'relief' property.
 */
enum Relief: string
{
    case RELIEF_FLAT = 'flat';
    case RELIEF_GROOVE = 'groove';
    case RELIEF_RAISED = 'raised';
    case RELIEF_RIDGE = 'ridge';
    case RELIEF_SOLID = 'solid';
    case RELIEF_SUNKEN = 'sunken';
}