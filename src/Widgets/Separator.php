<?php declare(strict_types=1);

namespace TclTk\Widgets;

use TclTk\Options;
use TclTk\Widgets\Consts\Orient;

/**
 * Implementation of Tk separator widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_separator.htm
 *
 * @property string $orient
 */
class Separator extends TtkWidget implements Orient
{
    protected string $widget = 'ttk::separator';
    protected string $name = 'sep';

    /**
     * @inheritdoc
     */
    protected function initWidgetOptions(): Options
    {
        return new Options([
            'orient' => null,
        ]);
    }
}