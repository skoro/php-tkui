<?php declare(strict_types=1);

namespace TclTk\Widgets;

use TclTk\Options;

/**
 * Implementation of Tk labelframe widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/labelframe.htm
 */
class LabelFrame extends TkWidget
{
    public function __construct(Widget $parent, string $title, array $options = [])
    {
        $options['text'] = $title;
        parent::__construct($parent, 'labelframe', 'lbf', $options);
    }

    /**
     * @inheritdoc
     */
    protected function initWidgetOptions(): Options
    {
        return new Options([
            'background' => null,
            'class' => null,
            'colormap' => null,
            'height' => null,
            'labelAnchor' => null,
            'labelWidget' => null,
            'visual' => null,
            'width' => null,
        ]);
    }
}