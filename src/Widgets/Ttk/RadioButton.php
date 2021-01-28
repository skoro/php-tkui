<?php declare(strict_types=1);

namespace TclTk\Widgets\Ttk;

use TclTk\Options;
use TclTk\Variable;
use TclTk\Widgets\Widget;

/**
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_radiobutton.htm
 *
 * @property string $text
 * @property string $value
 * @property Variable $variable
 */
class RadioButton extends SwitchableButton
{
    /**
     * @param int|string|float|bool $value
     */
    public function __construct(Widget $parent, string $title, $value, array $options = [])
    {
        $options['text'] = $title;
        $options['value'] = $value;
        parent::__construct($parent, 'ttk::radiobutton', 'rb', $options);
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
     */
    public function getValue()
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