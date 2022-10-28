<?php

declare(strict_types=1);

namespace Tkui\Widgets\TreeView;

use Tkui\Options;
use Tkui\Widgets\Container;
use Tkui\Widgets\ScrollableTtkWidget;
use Tkui\Widgets\Scrollbar;

/**
 * @link https://www.tcl-lang.org/man/tcl/TkCmd/ttk_treeview.htm
 *
 * @todo Not all methods implemented
 * 
 * @property int $height
 * @property string $selectMode
 * @property string[] $columns
 * @property int[]|string[] $displayColumns
 * @property string[] $show
 * @property Scrollbar $xScrollCommand
 * @property Scrollbar $yScrollCommand
 */
class TreeView extends ScrollableTtkWidget
{
    /**
     * Values for 'show' property.
     */
    public const SHOW_HEADINGS = 'headings';
    public const SHOW_TREE = 'tree';

    protected string $widget = 'ttk::treeview';
    protected string $name = 'tv';

    /** @var array<Column> */
    private array $columns;

    /**
     * @param array<Column> $columns
     */
    public function __construct(Container $parent, array $columns = [], array $options = [])
    {
        parent::__construct($parent, $options + [
            'columns' => array_map(fn (Column $column) => $column->id, $columns),
        ]);

        $this->columns = $columns;
        $this->setColumnHeaders();
    }

    protected function initWidgetOptions(): Options
    {
        return new Options([
            'columns' => null,
            'displayColumns' => null,
            'height' => null,
            'selectMode' => null,
            'show' => [self::SHOW_HEADINGS],
            // these are default options in TkWidget but not in TtkWidget:
            'xScrollCommand' => null,
            'yScrollCommand' => null,
        ]);
    }

    public function onSelect(callable $callback): self
    {
        $this->bind('<<TreeviewSelect>>', fn () => $callback($this->selected(), $this));
        return $this;
    }

    public function onOpen(callable $callback): self
    {
        $this->bind('<<TreeviewOpen>>', fn () => $callback($this));
        return $this;
    }

    public function onClose(callable $callback): self
    {
        $this->bind('<<TreeviewClose>>', fn () => $callback($this));
        return $this;
    }

    /**
     * @return array<Column>
     */
    public function columns(): array
    {
        return $this->columns;
    }

    private function setColumnHeaders(): void
    {
        foreach ($this->columns() as $column) {
            $this->setColumnHeader($column);
        }
    }

    private function setColumnHeader(Column $column): void
    {
        $this->call('heading', $column->id, '-text', $column->header()->text);
    }

    public function add(Item $item, string $parentId = ''): self
    {
        $args = $item->options()->asStringArray();
        $this->call('insert', $parentId ?: '{}', 'end', ...$args);
        return $this;
    }

    public function delete(Item ...$items): self
    {
        $ids = array_map(fn (Item $item) => $item->id, $items);
        $this->call('delete', ...$ids);
        return $this;
    }

    public function focusItem(Item $item): self
    {
        $this->call('focus', $item->id);
        return $this;
    }

    /**
     * @return string[]
     */
    public function selected(): array
    {
        $result = $this->call('selection');
        if ($result === '') {
            return [];
        }
        return explode(' ', $result);
    }

    /**
     * Returns the ID of the parent of item.
     *
     * @return string The ID or empty string.
     */
    public function getParentItemId(string $itemId): string
    {
        return $this->call('parent', $itemId);
    }

    public function isRootItem(string $itemId): bool
    {
        return $this->getParentItemId($itemId) === '';
    }

    /**
     * Returns the ID of item's next sibling.
     *
     * @return string the ID or empty string.
     */
    public function getNextItemId(string $itemId): string
    {
        return $this->call('next', $itemId);
    }

    /**
     * Returns the ID of item's previous sibling.
     *
     * @return string the ID or empty string.
     */
    public function getPrevItemId(string $itemId): string
    {
        return $this->call('prev', $itemId);
    }

    /**
     * Sets the viewport to the specified item.
     */
    public function seeItemId(string $itemId): self
    {
        $this->call('see', $itemId);
        return $this;
    }
}
