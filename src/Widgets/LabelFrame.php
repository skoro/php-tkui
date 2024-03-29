<?php declare(strict_types=1);

namespace Tkui\Widgets;

use Tkui\Options;
use Tkui\TclTk\TclOptions;
use Tkui\Widgets\Common\WithUnderlinedLabel;
use Tkui\Widgets\Consts\Anchor;

/**
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_labelframe.htm
 *
 * @property string $padding
 * @property int $width
 * @property int $height
 * @property string $text
 * @property Anchor $labelAnchor
 * @property int $underline
 * @property string $labelWidget
 * 
 * @todo Implement padding property.
 */
class LabelFrame extends Frame
{
    use WithUnderlinedLabel;

    protected string $widget = 'ttk::labelframe';
    protected string $name = 'lbf';

    public function __construct(Container $parent, string $text, array|Options $options = [])
    {
        $options['text'] = $this->removeUnderlineChar($text);
        $options['underline'] = $this->detectUnderlineIndex($text);
        parent::__construct($parent, $options);
    }

    /**
     * @inheritdoc
     */
    protected function createOptions(): Options
    {
        return new TclOptions([
            'padding' => null,
            'width' => null,
            'height' => null,
            'text' => null,
            'labelAnchor' => null,
            'underline' => null,
            'labelWidget' => null,
        ]);
    }
}