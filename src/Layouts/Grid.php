<?php declare(strict_types=1);

namespace PhpGui\Layouts;

use PhpGui\Options;

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
    /**
     * @inheritdoc
     */
    protected function createLayoutOptions(): Options
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

    /**
     * @inheritdoc
     */
    protected function command(): string
    {
        return 'grid';
    }
}