<?php declare(strict_types=1);

namespace Tkui\Widgets\Consts;

/**
 * Values for 'validate' property.
 */
enum Validate: string
{
    case VALIDATE_NONE = 'none';
    case VALIDATE_FOCUS = 'focus';
    case VALIDATE_FOCUS_IN = 'focusin';
    case VALIDATE_FOCUS_OUT = 'focusout';
    case VALIDATE_KEY = 'key';
    case VALIDATE_ALL = 'all';
}