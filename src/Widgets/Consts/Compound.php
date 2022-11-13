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
    case NONE   = 'none';
    case TEXT   = 'text';
    case IMAGE  = 'image';
    case CENTER = 'center';
    case TOP    = 'top';
    case BOTTOM = 'bottom';
    case LEFT   = 'left';
    case RIGHT  = 'right';
}
