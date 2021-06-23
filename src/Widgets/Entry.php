<?php declare(strict_types=1);

namespace PhpGui\Widgets;

use PhpGui\Color;
use PhpGui\Font;
use PhpGui\Options;
use PhpGui\TclTk\Tcl;
use PhpGui\TclTk\Variable;
use PhpGui\Widgets\Common\Editable;
use PhpGui\Widgets\Common\ValueInVariable;
use PhpGui\Widgets\Consts\Justify;
use PhpGui\Widgets\Consts\Validate;

/**
 * Implementation of Tk entry widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_entry.htm
 *
 * @property Font $font
 * @property Color|string $textColor
 * @property callable $xScrollCommand TODO
 * @property bool $exportSelection
 * @property callable $invalidCommand TODO
 * @property string $justify
 * @property bool $show
 * @property string $state
 * @property Variable $textVariable
 * @property string $validate
 * @property callable $validateCommand TODO
 * @property int $width
 */
class Entry extends TtkWidget implements ValueInVariable, Justify, Validate, Editable
{
    protected string $widget = 'ttk::entry';
    protected string $name = 'e';

    public function __construct(Container $parent, string $value = '', array $options = [])
    {
        $var = isset($options['textVariable']);

        parent::__construct($parent, $options);

        if (! $var) {
            $this->textVariable = $this->getEval()->registerVar($this);
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
            'font' => null,
            'textColor' => null,
            'xScrollCommand' => null,
            'exportSelection' => null,
            'invalidCommand' => null,
            'justify' => null,
            'show' => null,
            'state' => null,
            'textVariable' => null,
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
     *
     * @param string|int $first
     * @param string|int $last
     */
    public function delete($first, $last = null): self
    {
        if ($last) {
            $this->call('delete', $first, $last);
        } else {
            $this->call('delete', $first);
        }
        return $this;
    }

    /**
     * @inheritdoc
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
     *
     * @param string|int $index
     */
    public function insert($index, string $str): self
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
     *
     * @param string|int $index
     */
    public function insertCursor($index): self
    {
        $this->call('icursor', $index);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function append(string $text): self
    {
        $this->insert('end', $text);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getContent(): string
    {
        return $this->getValue();
    }
}