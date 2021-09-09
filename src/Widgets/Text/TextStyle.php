<?php declare(strict_types=1);

namespace PhpGui\Widgets\Text;

use PhpGui\Color;
use PhpGui\Font;
use PhpGui\Options;
use PhpGui\Widgets\Consts\Justify;
use PhpGui\Widgets\Consts\Relief;

/**
 * Text style.
 *
 * Style controls the way information is displayed on the text widget.
 * The display options may include font size, style, text justification, etc.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/text.htm#M43
 *
 * @property Color|string $background
 * @property int $borderWidth
 * @property bool $elide
 * @property Font $font
 * @property Color|string $foreground
 * @property string $justify
 * @property int $lmargin1
 * @property int $lmargin2
 * @property Color|string $lmarginColor
 * @property int $offset
 * @property bool $overstrike
 * @property Color|string $overstrikeFg
 * @property string $relief
 * @property int $rmargin
 * @property Color|string $rmarginColor
 * @property Color|string $selectBackground
 * @property Color|string $selectForeground
 * @property int $spacing1
 * @property int $spacing2
 * @property int $spacing3
 * @property string[] $tabs
 * @property string $tabStyle
 * @property bool $underline
 * @property Color|string $underlineFg
 * @property string $wrap
 */
class TextStyle implements Justify, Relief
{
    /**
     * Values for "wrap" property.
     */
    const WRAP_NONE = 'none';
    const WRAP_CHAR = 'char';
    const WRAP_WORD = 'word';

    private Options $options;

    public function __construct(array $options = [])
    {
        $this->options = $this->createOptions()->mergeAsArray($options);
    }

    /**
     * Tag options.
     */
    protected function createOptions(): Options
    {
        return new Options([
            'background' => null,
            'borderWidth' => null,
            'elide' => null,
            'font' => null,
            'foreground' => null,
            'justify' => null,
            'lmargin1' => null,
            'lmargin2' => null,
            'lmarginColor' => null,
            'offset' => null,
            'overstrike' => null,
            'overstrikeFg' => null,
            'relief' => null,
            'rmargin' => null,
            'rmarginColor' => null,
            'selectBackground' => null,
            'selectForeground' => null,
            'spacing1' => null,
            'spacing2' => null,
            'spacing3' => null,
            'tabs' => null,
            'tabStyle' => null,
            'underline' => null,
            'underlineFg' => null,
            'wrap' => null, 
        ]);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->options->$name;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $this->options->$name = $value;
    }

    public function options(): Options
    {
        return $this->options;
    }
}
