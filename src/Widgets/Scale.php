<?php declare(strict_types=1);

namespace Tkui\Widgets;

use Tkui\Options;
use Tkui\TclTk\Variable;
use Tkui\Widgets\Common\ValueInVariable;
use Tkui\Widgets\Consts\Orient;

/**
 * Implementation of Tk scale widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_scale.htm
 *
 * @property callable $command
 * @property float $from
 * @property string $length
 * @property string $orient
 * @property float $to
 * @property float $value
 * @property Variable $variable
 */
class Scale extends TtkWidget implements ValueInVariable, Orient
{
    protected string $widget = 'ttk::scale';
    protected string $name = 'sc';

    /**
     * @inheritdoc
     */
    protected function initWidgetOptions(): Options
    {
        return new Options([
            'command' => null,
            'from' => null,
            'length' => null,
            'orient' => null,
            'to' => null,
            'value' => null,
            'variable' => null,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getValue()
    {
        return $this->call('get');
    }

    /**
     * @inheritdoc
     */
    public function setValue($value): ValueInVariable
    {
        $this->call('set', $value);
        return $this;
    }
}