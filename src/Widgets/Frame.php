<?php declare(strict_types=1);

namespace TclTk\Widgets;

/**
 * Implementation of Tk frame widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/frame.htm
 */
class Frame extends TkWidget
{
    public function __construct(Widget $parent, array $options = [])
    {
        parent::__construct($parent, 'frame', 'fr', $options);
    }
}