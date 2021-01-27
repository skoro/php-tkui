<?php declare(strict_types=1);

namespace TclTk\Widgets;

use TclTk\Options;
use TclTk\Tcl;
use TclTk\Variable;

/**
 * Implementation of Tk entry widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/entry.htm
 *
 * @property Variable $textVariable
 * @property string $validate
 * @property bool $show
 */
class Entry extends TkWidget implements Valuable
{
    /**
     * States for the 'state' option.
     */
    const STATE_NORMAL = 'normal';
    const STATE_READONLY = 'readonly';
    const STATE_DISABLED = 'disabled';

    /**
     * Validate modes for 'validate' option.
     * Defaults 'none'.
     */
    const VALIDATE_NONE = 'none';
    const VALIDATE_FOCUS = 'focus';
    const VALIDATE_FOCUS_IN = 'focusin';
    const VALIDATE_FOCUS_OUT = 'focusout';
    const VALIDATE_KEY = 'key';
    const VALIDATE_ALL = 'all';

    public function __construct(Widget $parent, string $value = '', array $options = [])
    {
        $var = isset($options['textVariable']);

        parent::__construct($parent, 'entry', 'e', $options);

        if (! $var) {
            $this->textVariable = $this->window()->registerVar($this);
        }

        if ($value !== '') {
            $this->setValue($value);
        }
    }

    /**
     * @inheritdoc
     */
    protected function initWidgetOptions(): Options
    {
        return new Options([
            'disabledBackground' => null,
            'disabledForeground' => null,
            'invalidCommand' => null,
            'readonlyBackground' => null,
            'show' => null,
            'state' => null,
            'validate' => null,
            'validateCommand' => null,
            'width' => null,
        ]);
    }

    /**
     * Returns the entry's string.
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/entry.htm#M45
     */
    public function getValue(): string
    {
        return $this->textVariable->asString();
    }

    /**
     * Delete one or more elements of the entry.
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/entry.htm#M44
     */
    public function delete(int $first, int $last = 0): self
    {
        if ($last > 0) {
            $this->call('delete', $first, $last);
        } else {
            $this->call('delete', $first);
        }
        return $this;
    }

    /**
     * Clears the current entry string.
     */
    public function clear(): self
    {
        $this->textVariable->set('');
        return $this;
    }

    /**
     * Insert a string just before the specified index.
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/entry.htm#M48
     */
    public function insert(int $index, string $str): self
    {
        $this->call('insert', $index, Tcl::quoteString($str));
        return $this;
    }

    /**
     * Sets the new entry's string.
     *
     * @param string $value
     */
    public function setValue($value): self
    {
        $this->textVariable->set($value);
        return $this;
    }

    /**
     * Arrange for the insertion cursor to be displayed just before the character given by index.
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/entry.htm#M46
     */
    public function insertCursor(int $index): self
    {
        $this->call('icursor', $index);
        return $this;
    }
}