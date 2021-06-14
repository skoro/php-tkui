<?php declare(strict_types=1);

namespace PhpGui\Widgets;

use PhpGui\Font;
use PhpGui\Options;
use PhpGui\TclTk\Variable;
use PhpGui\Widgets\Consts\Anchor;
use PhpGui\Widgets\Consts\Justify;
use PhpGui\Widgets\Consts\Relief;
use SplObserver;
use SplSubject;

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
 * @property string $background
 * @property string $foreground
 * @property string $justify
 * @property string $relief
 * @property int $wrapLength
 * @property Font $font
 */
class Label extends TtkWidget implements Justify, Relief, Anchor, SplObserver
{

    protected string $widget = 'ttk::label';
    protected string $name = 'lb';

    public function __construct(Container $parent, string $title, array $options = [])
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
            'background' => null,
            'font' => null,
            'foreground' => null,
            'justify' => null,
            'relief' => null,
            'wrapLength' => null,
        ]);
    }

    public function __set($name, $value)
    {
        parent::__set($name, $value);
        if ($name === 'font' && $value instanceof Font) {
            // TODO: PHP8 $this->font?->detach($this)
            if ($this->font) {
                $this->font->detach($this);
            }
            $value->attach($this);
        }
    }

    public function update(SplSubject $subject): void
    {
        if ($subject === $this->font) {
            $this->call('configure', '-font', $subject);
        }
    }
}