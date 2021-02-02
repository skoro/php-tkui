<?php declare(strict_types=1);

namespace TclTk\Widgets;

use TclTk\Options;
use TclTk\Tcl;
use TclTk\Variable;
use TclTk\Widgets\Consts\Justify;

/**
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_combobox.htm
 * 
 * @property bool $exportSelection
 * @property string $justify
 * @property int $height
 * @property callable $postCommand TODO
 * @property string $state
 * @property Variable $textVariable
 * @property array $values TODO
 * @property int $width
 */
class Combobox extends TtkWidget implements Valuable, Justify
{
    protected string $widget = 'ttk::combobox';
    protected string $name = 'cb';

    public function __construct(Widget $parent, array $values = [], array $options = [])
    {
        if (! empty($values)) {
            $options['values'] = Tcl::arrayToList($values);
        }
        parent::__construct($parent, $options);
    }

    /**
     * @inheritdoc
     */
    protected function initWidgetOptions(): Options
    {
        return new Options([
            'exportSelection' => null,
            'justify' => null,
            'height' => null,
            'postCommand' => null,
            'state' => null,
            'textVariable' => null,
            'values' => null,
            'width' => null,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function setValue($value): self
    {
        $this->call('set', $value);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getValue()
    {
        return $this->call('get');
    }

    /**
     * Returns the index of the current value in the list or -1.
     */
    public function curselection(): int
    {
        return (int) $this->call('current');
    }

    public function setSelection(int $index): self
    {
        $this->call('current', $index);
        return $this;
    }

    public function onSelect(callable $callback): self
    {
        $this->bind('<<ComboboxSelected>>', fn () => $callback($this->curselection(), $this));
        return $this;
    }
}