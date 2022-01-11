<?php declare(strict_types=1);

namespace Tkui\Widgets;

/**
 * Implementation of Ttk sizegrip widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_sizegrip.htm
 */
class Sizegrip extends TtkWidget
{
    protected string $widget = 'ttk::sizegrip';
    protected string $name = 'szg';
}