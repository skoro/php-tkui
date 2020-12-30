<?php declare(strict_types=1);

namespace TclTk\Layouts;

use TclTk\Options;
use TclTk\Widgets\TkWidget;

/**
 * grid geometry manager.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/grid.htm
 *
 * @property int $column
 * @property int $columnSpan
 * @property int $row
 * @property int $rowSpan
 */
class Grid extends Manager
{
    protected function initOptions(): Options
    {
        return new Options([
            'column' => null,
            'columnSpan' => null,
            'ipadx' => null,
            'ipady' => null,
            'padx' => null,
            'pady' => null,
            'row' => null,
            'rowSpan' => null,
            'sticky' => null,
        ]);
    }

    public function manage(): TkWidget
    {
        $this->call('grid');
        return parent::manage();
    }

    public function column(int $col): self
    {
        $this->column = $col;
        return $this;
    }

    public function columnSpan(int $span): self
    {
        $this->columnSpan = $span;
        return $this;
    }

    public function row(int $row): self
    {
        $this->row = $row;
        return $this;
    }

    public function rowSpan(int $span): self
    {
        $this->rowSpan = $span;
        return $this;
    }
}