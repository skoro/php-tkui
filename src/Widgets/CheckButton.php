<?php declare(strict_types=1);

namespace TclTk\Widgets;

use TclTk\Options;

/**
 * Implementation of Tk checkbutton widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/checkbutton.htm
 */
class CheckButton extends Widget
{
    /**
     * States for the 'state' option.
     */
    const STATE_NORMAL = 'normal';
    const STATE_ACTIVE = 'active';
    const STATE_DISABLED = 'disabled';

    public function __construct(TkWidget $parent, bool $initialState = false, array $options = [])
    {
        parent::__construct($parent, 'checkbutton', 'chk', $options);
    }

    /**
     * @inheritdoc
     */
    protected function initWidgetOptions(): Options
    {
        return new Options([
            'command' => null,
            'height' => null,
            'indicatorOn' => null,
            'offRelief' => null,
            'overRelief' => null,
            'selectColor' => null,
            'selectImage' => null,
            'state' => null,
            'tristateImage' => null,
            'tristateValue' => null,
            'width' => null,
        ]);
    }

    /**
     * Selects the checkbutton.
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/checkbutton.htm#M27
     */
    public function select(): self
    {
        $this->call('select');
        return $this;
    }

    /**
     * Deselects the checkbutton.
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/checkbutton.htm#M24
     */
    public function deselect(): self
    {
        $this->call('deselect');
        return $this;
    }

    /**
     * Flashes the checkbutton.
     *
     * This operation is ignored if the checkbutton's state is disabled. 
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/checkbutton.htm#M25
     */
    public function flash(): self
    {
        $this->call('flash');
        return $this;
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

    /**
     * Emulates the mouse click on the button.
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/checkbutton.htm#M26
     */
    public function invoke(): self
    {
        $this->call('invoke');
        return $this;
    }
}