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
class Label extends Widget
{
    // TODO: states as in the Button widget.

    public function __construct(TkWidget $parent, string $title, array $options = [])
    {
        $options['text'] = $title;
        parent::__construct($parent, 'label', 'lb', $options);
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