<?php declare(strict_types=1);

namespace PhpGui\Widgets\Text;

use PhpGui\Font;
use PhpGui\Options;
use PhpGui\Widgets\Common\Editable;
use PhpGui\Widgets\Consts\WrapModes;
use PhpGui\Widgets\Container;
use PhpGui\Widgets\Exceptions\TextStyleNotRegisteredException;
use PhpGui\Widgets\ScrollableWidget;

/**
 * Implementation of Tk text widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/text.htm
 *
 * @property Scrollbar $xScrollCommand
 * @property Scrollbar $yScrollCommand
 * @property Font $font
 * @property string $wrap
 */
class Text extends ScrollableWidget implements Editable, WrapModes
{
    /**
     * States for the 'state' option.
     */
    const STATE_NORMAL = 'normal';
    const STATE_DISABLED = 'disabled';

    protected string $widget = 'text';
    protected string $name = 't';

    /**
     * @var TextStyle[string]
     */
    private array $styles;

    public function __construct(Container $parent, array $options = [])
    {
        parent::__construct($parent, $options);
        $this->styles = $this->createStyles();
    }

    /**
     * @inheritdoc
     */
    protected function initWidgetOptions(): Options
    {
        return new Options([
            'autoSeparators' => null,
            'blockCursor' => null,
            'endLine' => null,
            'height' => null,
            'inactiveSelectBackground' => null,
            'insertUnfocussed' => null,
            'font' => null,
            'maxUndo' => null,
            'spacing1' => null,
            'spacing2' => null,
            'spacing3' => null,
            'startLine' => null,
            'state' => null,
            'tabs' => null,
            'tabStyle' => null,
            'undo' => null,
            'width' => null,
            'wrap' => null,
        ]);
    }

    /**
     * Initializes the default text widget styles.
     *
     * @return TextStyle[string]
     */
    protected function createStyles(): array
    {
        return [];
    }

    /**
     * Sets the text style.
     */
    public function setStyle(string $styleName, TextStyle $style): self
    {
        $this->registerStyle($styleName, $style);
        $this->styles[$styleName] = $style;
        return $this;
    }

    /**
     * Registers the text style inside the text widget.
     */
    protected function registerStyle(string $styleName, TextStyle $style)
    {
        $this->call('tag', 'configure', $styleName, ...$style->options()->asStringArray());
    }

    /**
     * @return TextStyle[string]
     */
    public function getStyles(): array
    {
        return $this->styles;
    }

    /**
     * @throws TextStyleNotRegisteredException When the text style is not registered.
     */
    public function getStyle(string $styleName): TextStyle
    {
        if (! isset($this->styles[$styleName])) {
            throw new TextStyleNotRegisteredException($this, $styleName);
        }
        return $this->styles[$styleName];
    }

    /**
     * @inheritdoc
     */
    public function append(string $text): self
    {
        $this->call('insert', 'end', $text);
        return $this;
    }

    /**
     * Appends a text using the registered text style.
     *
     * @throws TextStyleNotRegisteredException When the text style is not registered.
     */
    public function appendWithStyle(string $text, string ...$styleNames): self
    {
        foreach ($styleNames as $styleName) {
            $this->getStyle($styleName);
        }
        $this->call('insert', 'end', $text, $styleNames);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function clear(): self
    {
        $this->call('delete', '0.0', 'end');
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getContent(): string
    {
        return $this->call('get', '0.0');
    }

    /**
     * @inheritdoc
     */
    public function setContent(string $text): self
    {
        $this->clear()->append($text);
        return $this;
    }

    /**
     * Gets the cursor position.
     */
    public function getCursorPos(): TextIndex
    {
        return TextIndex::parse($this->call('index', 'insert'));
    }

    /**
     * Sets the cursor position.
     */
    public function setCursorPos(TextIndex $index): self
    {
        $this->call('mark', 'set', 'insert', (string) $index);
        return $this;
    }
}