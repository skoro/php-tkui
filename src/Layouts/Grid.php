<?php declare(strict_types=1);

namespace TclTk\Layouts;

use TclTk\Options;
use TclTk\Widgets\TkWidget;

/**
 * grid geometry manager.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/grid.htm
 */
class Grid extends Manager
{
    protected function initOptions(): Options
    {
        return new Options([
            'column' => null,
            'columnspan' => null,
            'ipadx' => null,
            'ipady' => null,
            'padx' => null,
            'pady' => null,
            'row' => null,
            'rowspan' => null,
            'sticky' => null,
        ]);
    }

    public function manage(): TkWidget
    {
        $this->call('grid');
        return parent::manage();
    }
}