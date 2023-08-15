<?php declare(strict_types=1);

namespace Tkui\Widgets;

use Tkui\Options;
use Tkui\TclTk\Tcl;
use Tkui\TclTk\TclOptions;
use Tkui\TclTk\Variable;
use Tkui\Widgets\Common\ValueInVariable;
use Tkui\Widgets\Common\WithCallbacks;
use Tkui\Widgets\Consts\Justify;

/**
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_combobox.htm
 * 
 * @property bool $exportSelection
 * @property Justify $justify
 * @property int $height
 * @property callable|null $postCommand
 * @property string $state
 * @property Variable $textVariable
 * @property array $values TODO
 * @property int $width
 */
class Combobox extends TtkWidget implements ValueInVariable
{
    use WithCallbacks;

    protected string $widget = 'ttk::combobox';
    protected string $name = 'cb';

    /** @var callable|null */
    private $postCommandCallback = null;

    public function __construct(Container $parent, array $values = [], array|Options $options = [])
    {
        if (! empty($values)) {
            $options['values'] = Tcl::arrayToList($values);
        }
        parent::__construct($parent, $options);
    }

    /**
     * @inheritdoc
     */
    protected function createOptions(): Options
    {
        return new TclOptions([
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