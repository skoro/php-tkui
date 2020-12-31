<?php declare(strict_types=1);

namespace TclTk\Widgets\Buttons;

use TclTk\Widgets\TkWidget;

/**
 * Implementation of Tk radiobutton widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/radiobutton.htm
 */
class RadioButton extends SwitchableButton
{
    public function __construct(TkWidget $parent, array $options = [])
    {
        parent::__construct($parent, 'radiobutton', 'rb', $options);
    }
}