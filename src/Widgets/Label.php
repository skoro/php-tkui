<?php declare(strict_types=1);

namespace TclTk\Widgets;

use TclTk\Options;
use TclTk\Variable;
use TclTk\Widgets\Consts\Anchor;
use TclTk\Widgets\Consts\Justify;
use TclTk\Widgets\Consts\Relief;

/**
 * Implementation of Tk label widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_label.htm
 *
 * @property string $text
 * @property Variable $textVariable
 * @property int $underline
 * @property int $width
 * @property string $anchor
 * @property string $frameColor
 * @property string $textColor
 * @property string $justify
 * @property string $relief
 * @property int $wrapLength
 */
class Label extends TtkWidget implements Justify, Relief, Anchor
{

    protected string $widget = 'ttk::label';
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
            'compound' => null,
            'image' => null,
            'padding' => null,
            'state' => null,
            'text' => null,
            'textVariable' => null,
            'underline' => null,
            'width' => null,
            'anchor' => null,
            'frameColor' => null,
            'font' => null,
            'textColor' => null,
            'justify' => null,
            'relief' => null,
            'wrapLength' => null,
        ]);
    }
}