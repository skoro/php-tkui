<?php declare(strict_types=1);

namespace TclTk\Widgets;

use TclTk\Options;

/**
 * Implementation of Tk listbox widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/listbox.htm
 */
class Listbox extends Widget
{
    /**
     * States for the 'state' option.
     */
    const STATE_NORMAL = 'normal';
    const STATE_DISABLED = 'disabled';

    /**
     * Selection mode.
     */
    const SELECTMODE_SINGLE = 'single';
    const SELECTMODE_BROWSE = 'browse';
    const SELECTMODE_MULTIPLE = 'multiple';
    const SELECTMODE_EXTENDED = 'extended';

    /**
     * Active element draw styles.
     *
     * The default is "underline" on Windows, and "dotbox" elsewhere.
     */
    const ACTIVESTYLE_DOTBOX = 'dotbox';
    const ACTIVESTYLE_NONE = 'none';
    const ACTIVESTYLE_UNDERLINE = 'underline';

    public function __construct(TkWidget $parent, array $options = [])
    {
        parent::__construct($parent, 'listbox', 'lb', $options);
    }

    /**
     * @inheritdoc
     */
    protected function initWidgetOptions(): Options
    {
        return new Options([
            'activeStyle' => null,
            'height' => null,
            'listVariable' => null,
            'selectMode' => null,
            'state' => null,
            'width' => null,
        ]);
    }
}