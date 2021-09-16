<?php declare(strict_types=1);

namespace PhpGui\Widgets\Text;

use PhpGui\Font;
use PhpGui\Options;
use PhpGui\Widgets\Common\Editable;
use PhpGui\Widgets\Consts\WrapModes;
use PhpGui\Widgets\Container;
use PhpGui\Widgets\Exceptions\TextStyleNotRegisteredException;
use PhpGui\Widgets\Exceptions\WidgetException;
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
     * Creates a new text style.
     */
    public function createStyle(string $styleName, array $options = []): TextStyle
    {
        $style = new TextStyle($this->getStyleCallback(), $styleName, $options);
        $this->styles[$styleName] = $style;
        return $style;
    }

    /**
     * Returns the low-level styles API bridge.
     */
    protected function getStyleCallback(): TextApiMethodBridge
    {
        return $this->getApiMethodBridge(fn (...$args) => $this->call('tag', ...$args));
    }

    /**
     * Gets the api bridge for the text api.
     */
    protected function getApiMethodBridge(callable $callback): TextApiMethodBridge
    {
        return new class($callback) implements TextApiMethodBridge {
            
            private $callback;

            public function __construct($callback)
            {
                $this->callback = $callback;
            }

            public function callMethod(...$args)
            {
                return call_user_func_array($this->callback, $args);
            }
        };
    }

    /**
     * Unregisters the text style.
     *
     * @param TextStyle|string $style
     */
    public function unregisterStyle($style): self
    {
        if (is_string($style)) {
            $style = $this->getStyle($style);
        } elseif ($style instanceof TextStyle) {
            // Just checking the style belongs to the widget.
            $this->getStyle($style->name());
        } else {
            throw new WidgetException($this, 'Style must be instance of TextStyle.');
        }
        $style->delete();
        unset($this->styles[$style->name()]);
        return $this;
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

    /**
     * Deletes the text in range of characters.
     */
    public function delete(TextIndex $from, TextIndex $to): self
    {
        $this->call('delete', (string) $from, (string) $to);
        return $this;
    }

    /**
     * Inserts the text in the specified position.
     */
    public function insert(TextIndex $index, string $text, string ...$styleNames): self
    {
        $this->call('insert', (string) $index, $text, $styleNames);
        return $this;
    }

    /**
     * Adjusts the view in the widget.
     */
    public function view(TextIndex $index): self
    {
        $this->call('see', (string) $index);
        return $this;
    }

    public function onSelection(callable $callback): self
    {
        $this->bind('<<Selection>>', fn () => $callback($this));
        return $this;
    }
}