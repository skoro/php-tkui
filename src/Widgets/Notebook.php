<?php declare(strict_types=1);

namespace TclTk\Widgets;

use TclTk\Options;

/**
 * Implementation of Ttk notebook widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_notebook.htm
 *
 * @property int $height
 * @property string $padding TODO: must be list of integers ?
 * @property int $width
 */
class Notebook extends TtkWidget
{
    protected string $widget = 'ttk::notebook';
    protected string $name = 'nbk';

    /**
     * @inheritdoc
     */
    protected function initWidgetOptions(): Options
    {
        return new Options([
            'height' => null,
            'padding' => null,
            'width' => null,
        ]);
    }
}