<?php declare(strict_types=1);

namespace Tkui\Widgets\Buttons;

use Tkui\Options;
use Tkui\TclTk\Variable;
use Tkui\Widgets\Container;

/**
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_radiobutton.htm
 *
 * @property string $text
 * @property string $value
 * @property Variable $variable
 */
class RadioButton extends SwitchableButton
{
    protected string $widget = 'ttk::radiobutton';
    protected string $name = 'rb';

    /**
     * @param int|string|float|bool $value
     */
    public function __construct(Container $parent, string $title, $value, array $options = [])
    {
        $options['text'] = $title;
        $options['value'] = $value;
        parent::__construct($parent, $options);
    }

    /**
     * @inheritdoc
     */
    protected function initWidgetOptions(): Options
    {
        return parent::initWidgetOptions()->mergeAsArray([
            'value' => null,
        ]);
    }

    /**
     * @inheritdoc
     * @return string
     */
    public function getValue(): string
    {
        return $this->variable->asString();
    }

    /**
     * @inheritdoc
     */
    public function select(): self
    {
        $this->setValue($this->value);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function deselect(): self
    {
        $this->setValue('');
        return $this;
    }
}