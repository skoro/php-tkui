<?php declare(strict_types=1);

namespace Tkui\Widgets\Text;

use Tkui\Font;
use Tkui\Image;
use Tkui\Options;
use Tkui\Widgets\Common\Editable;
use Tkui\Widgets\Consts\WrapModes;
use Tkui\Widgets\Container;
use Tkui\Widgets\Exceptions\TextStyleNotRegisteredException;
use Tkui\Widgets\Exceptions\WidgetException;
use Tkui\Widgets\ScrollableWidget;

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
     * @var array<string, TextStyle>
     */
    private array $styles;

    private Selection $selection;

    public function __construct(Container $parent, array $options = [])
    {
        parent::__construct($parent, $options);
        $this->selection = $this->createSelection();
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

    protected function createSelection(): Selection
    {
        return new Selection($this->getStyleCallback());
    }

    /**
     * Returns the low-level styles API bridge.
     */
    protected function getStyleCallback(): TextApiMethodBridge
    {
        return $this->getApiMethodBridge(fn (...$args) => $this->call('tag', ...$args));
    }

    /**
     * Creates an image at the specified text index.
     */
    public function createImage(TextIndex $index, Image $image, array $options = []): EmbeddedImage
    {
        return new EmbeddedImage($this->getEmbeddedImageCallback(), $index, $image, $options);
    }

    protected function getEmbeddedImageCallback(): TextApiMethodBridge
    {
        return $this->getApiMethodBridge(fn (...$args) => $this->call('image', ...$args));
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
     * Returns the edit stack manager which provides undo/redo operations and helpers.
     */
    public function getEditStack(): EditStack
    {
        return new EditStack(
            $this->getApiMethodBridge(fn (...$args) => $this->call('edit', ...$args))
        );
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
        $style->unregister();
        unset($this->styles[$style->name()]);
        return $this;
    }

    /**
     * @return array<string, TextStyle>
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
        return $this->call('get', '0.0', 'end');
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
     * Returns a range of characters from the text.
     */
    public function getCharRange(Range $range): string
    {
        return (string) $this->call('get', (string) $range->from(), (string) $range->to());
    }

    /**
     * Returns only a single character at the specified index.
     */
    public function getCharAt(TextIndex $index): string
    {
        return (string) $this->call('get', (string) $index);
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
    public function delete(Range $range): self
    {
        $this->call('delete', (string) $range->from(), (string) $range->to());
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

    public function getSelection(): Selection
    {
        return $this->selection;
    }

    /**
     * Searches the text pattern.
     *
     * @return TextIndex[]
     */
    public function search(string $pattern, SearchOptions $searchOptions, TextIndex $index, ?TextIndex $stop = null): array
    {
        $switches = [];

        switch ($searchOptions->getDirection()) {
            case SearchOptions::FORWARD:
                $switches[] = '-forwards';
                break;

            case SearchOptions::BACKWARD:
                $switches[] = '-backwards';
                break;
        }

        if ($searchOptions->isRegexp()) {
            $switches[] = '-regexp';
        }
        if ($searchOptions->isIgnoreCase()) {
            $switches[] = '-nocase';
        }
        if ($searchOptions->isAllMatches()) {
            $switches[] = '-all';
        }

        $args = [...$switches, '--', $pattern, (string) $index];
        if ($stop !== null) {
            $args[] = (string) $stop;
        }

        $results = $this->call('search', ...$args);

        return empty($results) ? [] : array_map(fn (string $pos) => TextIndex::parse($pos), explode(' ', $results));
    }
}
