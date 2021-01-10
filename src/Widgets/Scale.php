<?php declare(strict_types=1);

namespace TclTk\Widgets;

use TclTk\Options;
use TclTk\Variable;

/**
 * Implementation of Tk scale widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/scale.htm
 *
 * @property int $bigIncrement
 * @property callable $command
 * @property int $digits
 * @property float $from
 * @property string $label
 * @property string $length
 * @property float $resolution
 * @property bool $showValue
 * @property string $sliderLength
 * @property string $sliderRelief
 * @property string $state
 * @property float $tickInterval
 * @property float $to
 * @property Variable $variable
 * @property string $width
 */
class Scale extends Widget implements Valuable
{
    const SLIDER_RELIEF_RAISED = 'raised';
    const SLIDER_RELIEF_SUNKEN = 'sunken';

    /**
     * States for the 'state' option.
     */
    const STATE_NORMAL = 'normal';
    const STATE_ACTIVE = 'active';
    const STATE_DISABLED = 'disabled';

    public function __construct(TkWidget $parent, array $options = [])
    {
        parent::__construct($parent, 'scale', 'sc', $options);
    }

    /**
     * @inheritdoc
     */
    protected function initWidgetOptions(): Options
    {
        return new Options([
            'bigIncrement' => null,
            'command' => null,
            'digits' => null,
            'from' => null,
            'label' => null,
            'length' => null,
            'resolution' => null,
            'showValue' => null,
            'sliderLength' => null,
            'sliderRelief' => null,
            'state' => null,
            'tickInterval' => null,
            'to' => null,
            'variable' => null,
            'width' => null,
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