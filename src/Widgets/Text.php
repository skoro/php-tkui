<?php declare(strict_types=1);

namespace TclTk\Widgets;

use TclTk\Options;

/**
 * Implementation of Tk text widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/text.htm
 *
 * @property Scrollbar $xScrollCommand
 * @property Scrollbar $yScrollCommand
 */
class Text extends ScrollableWidget
{
    /**
     * States for the 'state' option.
     */
    const STATE_NORMAL = 'normal';
    const STATE_DISABLED = 'disabled';

    public function __construct(Widget $parent, array $options = [])
    {
        parent::__construct($parent, 'text', 't', $options);
    }

    /**
     * @inheritdoc
     */
    protected function initWidgetOptions(): Options
    {
        return new Options([
            'autoSeparators' => null,
            'blockCursor' => null,
            'endLine' => null,
            'height' => null,
            'inactiveSelectBackground' => null,
            'insertUnfocussed' => null,
            'maxUndo' => null,
            'spacing1' => null,
            'spacing2' => null,
            'spacing3' => null,
            'startLine' => null,
            'state' => null,
            'tabs' => null,
            'tabStyle' => null,
            'undo' => null,
            'width' => null,
            'wrap' => null,
        ]);
    }
}