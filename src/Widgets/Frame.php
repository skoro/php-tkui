<?php declare(strict_types=1);

namespace Tkui\Widgets;

use Tkui\Options;
use Tkui\TclTk\TclOptions;
use Tkui\Widgets\Consts\Relief;

/**
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_frame.htm
 *
 * @property string $padding
 * @property int $borderWidth
 * @property Relief $relief
 * @property int $width
 * @property int $height
 * 
 * @todo Implement padding property.
 */
class Frame extends TtkContainer
{
    protected string $widget = 'ttk::frame';
    protected string $name = 'fr';

    /**
     * @inheritdoc
     */
    protected function createOptions(): Options
    {
        return new TclOptions([
            'padding' => null,
            'borderWidth' => null,
            'relief' => null,
            'width' => null,
            'height' => null,
        ]);
    }
}