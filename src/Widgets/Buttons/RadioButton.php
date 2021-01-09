<?php declare(strict_types=1);

namespace TclTk\Widgets\Buttons;

use TclTk\Options;
use TclTk\Widgets\TkWidget;

/**
 * Implementation of Tk radiobutton widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/radiobutton.htm
 *
 * @property string|int|bool|float $value
 */
class RadioButton extends SwitchableButton
{
    /**
     * @param int|string|float|bool $value
     */
    public function __construct(TkWidget $parent, string $title, $value, array $options = [])
    {
        $options['text'] = $title;
        $options['value'] = $value;
        parent::__construct($parent, 'radiobutton', 'rb', $options);
    }

    protected function initWidgetOptions(): Options
    {
        return new Options([
            'value' => null,
        ]);
    }
}