<?php

declare(strict_types=1);

namespace Tkui\Widgets\Consts;

/**
 * Specifies how to display the image relative to the text.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_widget.htm#M-compound
 */
enum Compound: string
{
    case ACTIVE     = 'active';
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
