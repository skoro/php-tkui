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

    public function onSelect(callable $callback): static
    {
        return $this;
    }

    public function onOpen(callable $callback): static
    {
        return $this;
    }

    public function onClose(callable $callback): static
    {
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
}
