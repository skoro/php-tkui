<?php declare(strict_types=1);

namespace TclTk\Widgets;

/**
 * Implementation of Tk label widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/label.htm
 */
class Label extends Widget
{
    public function __construct(TkWidget $parent, string $title, array $options = [])
    {
        $options['text'] = $title;
        parent::__construct($parent, 'label', 'lb', $options);
    }
}