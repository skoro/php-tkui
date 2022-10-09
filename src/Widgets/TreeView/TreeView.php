<?php

declare(strict_types=1);

namespace Tkui\Widgets\TreeView;

use Tkui\Options;
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
    protected string $widget = 'ttk::treeview';
    protected string $name = 'tv';

    protected function initWidgetOptions(): Options
    {
        return new Options([
            'columns' => null,
            'displayColumns' => null,
            'height' => null,
            'selectMode' => null,
            'show' => null,
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
}
