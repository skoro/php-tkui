<?php declare(strict_types=1);

namespace TclTk\Widgets\Buttons;

use TclTk\Widgets\TkWidget;

/**
 * Implementation of Tk checkbutton widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/checkbutton.htm
 *
 * @property string $text
 */
class CheckButton extends SwitchableButton
{
    public function __construct(TkWidget $parent, string $title, bool $initialState = false, array $options = [])
    {
        $options['text'] = $title;
        parent::__construct($parent, 'checkbutton', 'chk', $options);
        $this->variable->set($initialState);
    }

    /**
     * Toggles the selection state of the button.
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/checkbutton.htm#M28
     */
    public function toggle(): self
    {
        $this->call('toggle');
        return $this;
    }
}