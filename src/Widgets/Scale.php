<?php declare(strict_types=1);

namespace TclTk\Widgets;

use TclTk\Options;
use TclTk\Variable;
use TclTk\Widgets\Common\Valuable;
use TclTk\Widgets\Consts\Orient;

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
class Scale extends TtkWidget implements Valuable, Orient
{
    protected string $widget = 'ttk::scale';
    protected string $name = 'sc';

    public function __construct(Widget $parent, array $options = [])
    {
        parent::__construct($parent, $options);
    }

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
    public function setValue($value): Valuable
    {
        $this->call('set', $value);
        return $this;
    }
}