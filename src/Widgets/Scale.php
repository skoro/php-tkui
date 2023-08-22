<?php declare(strict_types=1);

namespace Tkui\Widgets;

use Tkui\Options;
use Tkui\TclTk\TclOptions;
use Tkui\TclTk\Variable;
use Tkui\Widgets\Common\ValueInVariable;
use Tkui\Widgets\Common\WithCallbacks;
use Tkui\Widgets\Consts\Orient;

/**
 * Implementation of Tk scale widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_scale.htm
 *
 * @property callable|null $command
 * @property float $from
 * @property string $length
 * @property Orient $orient
 * @property float $to
 * @property float $value
 * @property Variable $variable
 */
class Scale extends TtkWidget implements ValueInVariable
{
    use WithCallbacks;

    protected string $widget = 'ttk::scale';
    protected string $name = 'sc';

    /** @var callable|null */
    private $commandCallback = null;

    /**
     * @inheritdoc
     */
    protected function createOptions(): Options
    {
        return new TclOptions([
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