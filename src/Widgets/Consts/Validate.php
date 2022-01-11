<?php declare(strict_types=1);

namespace Tkui\Widgets\Consts;

/**
 * Values for 'validate' property.
 */
interface Validate
{
    const VALIDATE_NONE = 'none';
    const VALIDATE_FOCUS = 'focus';
    const VALIDATE_FOCUS_IN = 'focusin';
    const VALIDATE_FOCUS_OUT = 'focusout';
    const VALIDATE_KEY = 'key';
    const VALIDATE_ALL = 'all';
}