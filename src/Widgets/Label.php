<?php declare(strict_types=1);

namespace Tkui\Widgets;

use Tkui\Color;
use Tkui\Font;
use Tkui\Image;
use Tkui\Options;
use Tkui\TclTk\Variable;
use Tkui\Widgets\Common\DetectUnderline;
use Tkui\Widgets\Consts\Anchor;
use Tkui\Widgets\Consts\Justify;
use Tkui\Widgets\Consts\Relief;

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
 * @property Color|string $background
 * @property Color|string $foreground
 * @property string $justify
 * @property string $relief
 * @property int $wrapLength
 * @property Font|null $font
 * @property Image $image
 * @property string $compound
 */
class Label extends TtkWidget implements Justify, Relief, Anchor
{
    use DetectUnderline;

    protected string $widget = 'ttk::label';
    protected string $name = 'lb';

    public function __construct(Container $parent, string $title, array $options = [])
    {
        $options['text'] = $this->removeUnderlineChar($title);
        $options['underline'] = $this->detectUnderlineIndex($title);
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
            'background' => null,
            'font' => null,
            'foreground' => null,
            'justify' => null,
            'relief' => null,
            'wrapLength' => null,
        ]);
    }
}