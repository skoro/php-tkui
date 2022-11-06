<?php

declare(strict_types=1);

namespace Tkui\Widgets;

use Tkui\Options;
use Tkui\TclTk\Variable;
use Tkui\Widgets\Common\ValueInVariable;
use Tkui\Widgets\Consts\Orient;
use Tkui\Widgets\Consts\ProgressMode;

/**
 * Implementation of Ttk progressbar widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_progressbar.html
 *
 * @property int $length
 * @property float $maximum
 * @property string $mode
 * @property string $orient
 * @property float $value
 * @property Variable $variable
 */
class Progressbar extends TtkWidget implements ValueInVariable, Orient, ProgressMode
{
    protected string $widget = 'ttk::progressbar';
    protected string $name = 'prbr';

    /**
     * @inheritdoc
     */
    protected function initWidgetOptions(): Options
    {
        return new Options([
            'length' => null,
            'maximum' => null,
            'mode' => null,
            'orient' => Orient::ORIENT_HORIZONTAL,
            'phase' => null,
            'value' => null,
            'variable' => null,
        ]);
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value): self
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Begins autoincrement mode.
     *
     * @param int $interval Interval milliseconds.
     */
    public function start(int $interval = 50): self
    {
        $this->call('start', $interval);
        return $this;
    }

    /**
     * Stops autoincrement mode.
     */
    public function stop(): self
    {
        $this->call('stop');
        return $this;
    }

    /**
     * Increments a progressbar value by amount.
     */
    public function step(float $amount = 1.0): self
    {
        $this->call('step', $amount);
        return $this;
    }
}
