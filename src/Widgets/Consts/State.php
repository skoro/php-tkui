<?php

declare(strict_types=1);

namespace Tkui\Widgets\Consts;

/**
 * Widget states.
 *
 * Not all widgets support states.
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_widget.htm#M-state
 */
enum State: string
{
    case NORMAL     = 'normal';
    case DISABLED   = 'disabled';
    case FOCUS      = 'focus';
    case PRESSED    = 'pressed';
    case SELECTED   = 'selected';
    case BACKGROUND = 'background';
    case READONLY   = 'readonly';
    case ALTERNATE  = 'alternate';
    case INVALID    = 'invalid';
    case HOVER      = 'hover';
}
