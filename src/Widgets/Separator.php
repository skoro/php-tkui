<?php declare(strict_types=1);

namespace Tkui\Widgets;

use Tkui\Options;
use Tkui\TclTk\TclOptions;
use Tkui\Widgets\Consts\Orient;

/**
 * Implementation of Tk separator widget.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_separator.htm
 *
 * @property Orient $orient By default, vertical orientation.
 */
class Separator extends TtkWidget
{
    protected string $widget = 'ttk::separator';
    protected string $name = 'sep';

    /**
     * @inheritdoc
     */
    protected function createOptions(): Options
    {
        return new TclOptions([
            'orient' => Orient::VERTICAL,
        ]);
    }
}
