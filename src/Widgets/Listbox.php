<?php declare(strict_types=1);

namespace TclTk\Widgets;

use InvalidArgumentException;
use SplObserver;
use SplSubject;
use TclTk\Options;

/**
 * Implementation of Tk listbox widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/listbox.htm
 *
 * @property string $state
 * @property string $selectMode
 * @property string $activeStyle
 * @property int $height
 * @property int $width
 * @property Scrollbar $xScrollCommand
 * @property Scrollbar $yScrollCommand
 */
class Listbox extends Widget implements SplObserver
{
    /**
     * States for the 'state' option.
     */
    const STATE_NORMAL = 'normal';
    const STATE_DISABLED = 'disabled';

    /**
     * Selection modes for 'selectMode' option.
     */
    const SELECTMODE_SINGLE = 'single';
    const SELECTMODE_BROWSE = 'browse';
    const SELECTMODE_MULTIPLE = 'multiple';
    const SELECTMODE_EXTENDED = 'extended';

    /**
     * Active element draw styles for 'activeStyle' option.
     *
     * The default is "underline" on Windows, and "dotbox" elsewhere.
     */
    const ACTIVESTYLE_DOTBOX = 'dotbox';
    const ACTIVESTYLE_NONE = 'none';
    const ACTIVESTYLE_UNDERLINE = 'underline';

    /**
     * Listbox items.
     *
     * @var ListboxItem[]
     */
    protected array $items;

    protected Scrollbar $xScroll;
    protected Scrollbar $yScroll;

    /**
     * @inheritdoc
     *
     * @param ListboxItem[] $items Listbox items.
     */
    public function __construct(TkWidget $parent, array $items = [], array $options = [])
    {
        parent::__construct($parent, 'listbox', 'lb', $options);
        foreach ($items as $item) {
            $this->append($item);
        }
    }

    /**
     * @inheritdoc
     */
    protected function initWidgetOptions(): Options
    {
        return new Options([
            'activeStyle' => null,
            'height' => null,
            'listVariable' => null,
            'selectMode' => null,
            'state' => null,
            'width' => null,
        ]);
    }

    /**
     * @return ListboxItem[]
     */
    public function items(): array
    {
        return $this->items;
    }

    public function size(): int
    {
        return count($this->items);
    }

    /**
     * Sets the active item.
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/listbox.htm#M20
     *
     * @param int|ListboxItem $index
     * 
     * @todo Use union types.
     */
    public function activate($index): self
    {
        if ($index instanceof ListboxItem) {
            $index = $this->index($index);
        }
        $this->call('activate', $index);
        return $this;
    }

    /**
     * Deletes one or more elements of the listbox.
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/listbox.htm#M25
     */
    public function delete(int $first, int $last = 0): self
    {
        $this->validateRanges($first, $last);

        if ($last === 0) {
            $this->call('delete', $first);
            $items = array_splice($this->items, $first, 1);
        } else {
            $this->call('delete', $first, $last);
            $items = array_splice($this->items, $first, $last - $first);
        }

        array_walk($items, fn (ListboxItem $item) => $item->detach($this));

        return $this;
    }

    /**
     * @return ListboxItem[]
     */
    public function get(int $first, int $last = 0): array
    {
        $this->validateRanges($first, $last);
        return array_slice($this->items, $first, $last === 0 ? 1 : $last - $first);
    }

    /**
     * Adjust the view in the listbox to the specified index.
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/listbox.htm#M39
     *
     * @param int|ListboxItem $index
     *
     * @todo Use union types.
     */
    public function see(int $index): self
    {
        if ($index instanceof ListboxItem) {
            $index = $this->index($index);
        }
        $this->call('see', $index);
        return $this;
    }

    /**
     * Insert new items at the specified index.
     *
     * @param int $index
     * @param ListboxItem|ListboxItem[] $items
     */
    public function insert(int $index, $items): self
    {
        $this->validateRanges($index);
        if (!is_array($items)) {
            $items = array($items);
        }
        $values = array_map(fn (ListboxItem $item) => $this->quoteValue($item), $items);
        $this->call('insert', $index, ...$values);
        array_splice($this->items, $index, 0, $items);
        array_walk($items, fn (ListboxItem $item) => $item->attach($this));
        return $this;
    }

    /**
     * @throws InvalidArgumentException When the first or last index is out of range.
     *
     * @return int[] A list of first and last indexes.
     */
    protected function validateRanges(int $first, int $last = 0): array
    {
        if ($last === 0) {
            if ($first >= 0 && $first < $this->size()) {
                return array($first);
            }
        } else {
            if ($first >= 0 && $first <= $last && $last < $this->size()) {
                return array($first, $last);
            }
        }
        throw new InvalidArgumentException('Index is out of range.');
    }

    /**
     * Appends the item to end end of the listbox.
     *
     * @return int Index of the appended item.
     */
    public function append(ListboxItem $item): int
    {
        $this->call('insert', 'end', $this->quoteValue($item));
        $this->items[] = $item;
        $item->attach($this);
        return $this->size() - 1;
    }

    /**
     * Returns currently selected items.
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/listbox.htm#M24
     *
     * @return ListboxItem[] The list indexes are indexes in the listbox widget.
     */
    public function curselection(): array
    {
        $result = $this->call('curselection');
        if (empty($result)) {
            return [];
        }
        $indexes = explode(' ', $result);
        return array_map(fn ($index) => $this->items[$index], array_combine($indexes, $indexes));
    }

    /**
     * @inheritdoc
     */
    public function __get($name)
    {
        switch ($name) {
            case 'xScrollCommand':
                return $this->xScroll;
            case 'yScrollCommand':
                return $this->yScroll;
        }
        return parent::__get($name);
    }

    /**
     * @inheritdoc
     */
    public function __set($name, $value)
    {
        switch ($name) {
            case 'xScrollCommand':
            case 'yScrollCommand':
                if (!($value instanceof Scrollbar)) {
                    throw new InvalidArgumentException("$name must be an instance of " . Scrollbar::class);
                }
                /** @var Scrollbar $value */
                $value = $value->path() . ' set';
                break;
        }
        parent::__set($name, $value);
    }

    /**
     * Quote item's value.
     *
     * Quoting should improve performance for insert items by avoiding
     * detection of the value in the tcl eval().
     */
    protected function quoteValue(ListboxItem $item): string
    {
        return '"' . $item->value() . '"';
    }

    /**
     * Clears the listbox.
     */
    public function clear(): self
    {
        $this->delete(0, $this->size() - 1);
        return $this;
    }

    /**
     * Selects the item or range of items.
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/listbox.htm#M44
     */
    public function select(int $first, int $last = 0): self
    {
        $this->call('selection', 'set', ...$this->validateRanges($first, $last));
        return $this;
    }

    /**
     * Selects the item.
     */
    public function selectItem(ListboxItem $item): self
    {
        return $this->select($this->index($item));
    }

    /**
     * Unselects the item or range of items.
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/listbox.htm#M42
     */
    public function unselect(int $first, int $last = 0): self
    {
        $this->call('selection', 'clear', ...$this->validateRanges($first, $last));
        return $this;
    }

    /**
     * Unselects the item.
     */
    public function unselectItem(ListboxItem $item): self
    {
        return $this->unselect($this->index($item));
    }

    /**
     * Whether the item is selected ?
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/listbox.htm#M43
     */
    public function isSelected(int $index): bool
    {
        return (bool) $this->call('selection', 'includes', $index);
    }

    /**
     * Sets the selection anchor.
     *
     * @link https://www.tcl.tk/man/tcl8.6/TkCmd/listbox.htm#M41
     */
    public function anchor(int $index): self
    {
        $this->call('selection', 'anchor', $index);
        return $this;
    }

    /**
     * Get the item by the index.
     */
    public function item(int $index): ListboxItem
    {
        if (isset($this->items[$index])) {
            return $this->items[$index];
        }
        throw new InvalidArgumentException('Item by index not found.');
    }

    /**
     * Get the item's index.
     */
    public function index(ListboxItem $item): int
    {
        $index = array_search($item, $this->items, true);
        if ($index === false) {
            throw new InvalidArgumentException('Item not found.');
        }
        return $index;
    }

    /**
     * Updates the item options.
     */
    public function update(SplSubject $subject): void
    {
        if (($index = array_search($subject, $this->items, true)) === false) {
            return;
        }
        $item = $this->items[$index];
        $this->call('itemconfigure', $index, ...$item->options()->asStringArray());
    }
}