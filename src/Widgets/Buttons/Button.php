<?php declare(strict_types=1);

namespace TclTk\Widgets\Buttons;

use TclTk\Options;
use TclTk\Widgets\Widget;

/**
 * Implementation of Tk button widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/button.htm
 *
 * @property string $text
 * @property string $default
 */
class Button extends GenericButton
{
    protected string $widget = 'button';
    protected string $name = 'b';

    public function __construct(Widget $parent, string $title, array $options = [])
    {
        $options['text'] = $title;
        parent::__construct($parent, $options);
    }

    /**
     * @inheritdoc
     */
    protected function initWidgetOptions(): Options
    {
        return new Options([
            'default' => null,
        ]);
    }
}