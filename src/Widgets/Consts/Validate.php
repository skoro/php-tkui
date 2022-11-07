<?php declare(strict_types=1);

namespace Tkui\Widgets\Consts;

/**
 * Values for 'validate' property.
 */
enum Validate: string
{
    case NONE       = 'none';
    case FOCUS      = 'focus';
    case FOCUS_IN   = 'focusin';
    case FOCUS_OUT  = 'focusout';
    case KEY        = 'key';
    case ALL        = 'all';
}
