<?php declare(strict_types=1);

namespace TclTk\Widgets;

use InvalidArgumentException;
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
class Listbox extends Widget
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
     */
    public function activate(int $index): self
    {
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
            array_splice($this->items, $first, 1);
        } else {
            $this->call('delete', $first, $last);
            array_splice($this->items, $first, $last - $first);
        }

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
     */
    public function see(int $index): self
    {
        $this->validateRanges($index);
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
        return $this;
    }

    /**
     * @throws InvalidArgumentException When the first or last index is out of range.
     */
    protected function validateRanges(int $first, int $last = 0): void
    {
        if ($last === 0) {
            if ($first >= 0 && $first < $this->size()) {
                return;
            }
        } else {
            if ($first >= 0 && $first <= $last && $last < $this->size()) {
                return;
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
}