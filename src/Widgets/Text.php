<?php declare(strict_types=1);

namespace PhpGui\Widgets;

use PhpGui\Font;
use PhpGui\Options;
use PhpGui\Widgets\Common\Editable;

/**
 * Implementation of Tk text widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/text.htm
 *
 * @property Scrollbar $xScrollCommand
 * @property Scrollbar $yScrollCommand
 * @property Font $font
 */
class Text extends ScrollableWidget implements Editable
{
    /**
     * States for the 'state' option.
     */
    const STATE_NORMAL = 'normal';
    const STATE_DISABLED = 'disabled';

    protected string $widget = 'text';
    protected string $name = 't';

    public function __construct(Container $parent, array $options = [])
    {
        parent::__construct($parent, $options);
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
            'font' => null,
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

    /**
     * @inheritdoc
     */
    public function append(string $text): self
    {
        $this->call('insert', 'end', $text);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function clear(): self
    {
        $this->call('delete', '0.0', 'end');
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getContent(): string
    {
        return $this->call('get', '0.0');
    }
}