<?php declare(strict_types=1);

namespace Tkui\Widgets;

use Tkui\Options;
use Tkui\TclTk\Variable;
use Tkui\Widgets\Common\ValueInVariable;

/**
 * Implementation of Ttk spinbox widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_spinbox.html
 *
 * @property callable $command
 * @property string $format
 * @property float $from
 * @property float $increment
 * @property float $to
 * @property array $values
 * @property bool $wrap
 * @property Variable $textVariable
 */
class Spinbox extends TtkWidget implements ValueInVariable
{
    protected string $widget = 'ttk::spinbox';
    protected string $name = 'spnb';

    /**
     * @param string|int|float $value
     */
    public function __construct(Container $parent, $value, array $options = [])
    {
        parent::__construct($parent, $options);
        $this->setValue($value);
    }

    /**
     * @inheritdoc
     */
    protected function initWidgetOptions(): Options
    {
        return new Options([
            'command' => null,
            'format' => null,
            'from' => null,
            'increment' => null,
            'to' => null,
            'values' => null,
            'wrap' => null,
            'textVariable' => null,
        ]);
    }

    /**
     * Fires when the value is incremented.
     */
    public function onIncrement(callable $callback): self
    {
        $this->bind('<<Increment>>', $callback);
        return $this;
    }

    /**
     * Fires when the value is decremented.
     */
    public function onDecrement(callable $callback): self
    {
        $this->bind('<<Decrement>>', $callback);
        return $this;
    }

    /**
     * @return int|float|string
     */
    public function getValue()
    {
        return $this->call('get');
    }

    /**
     * @param int|float|string $value
     */
    public function setValue($value): self
    {
        $this->call('set', $value);
        return $this;
    }
}