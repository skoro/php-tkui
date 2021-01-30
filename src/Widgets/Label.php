<?php declare(strict_types=1);

namespace TclTk\Widgets;

use TclTk\Options;

/**
 * Implementation of Tk label widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/label.htm
 *
 * @property string $state
 * @property int $height
 * @property int $width
 * @property string $text
 */
class Label extends TkWidget
{
    /**
     * States for the 'state' option.
     */
    const STATE_NORMAL = 'normal';
    const STATE_ACTIVE = 'active';
    const STATE_DISABLED = 'disabled';

    protected string $widget = 'label';
    protected string $name = 'lb';

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
            'height' => null,
            'state' => null,
            'width' => null,
        ]);
    }
}