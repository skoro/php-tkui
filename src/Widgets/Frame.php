<?php declare(strict_types=1);

namespace Tkui\Widgets;

use Tkui\Options;
use Tkui\Widgets\Consts\Relief;

/**
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_frame.htm
 *
 * @property string $padding
 * @property int $borderWidth
 * @property string $relief
 * @property int $width
 * @property int $height
 * 
 * @todo Implement padding property.
 */
class Frame extends TtkContainer implements Relief
{
    protected string $widget = 'ttk::frame';
    protected string $name = 'fr';

    /**
     * @inheritdoc
     */
    protected function initWidgetOptions(): Options
    {
        return new Options([
            'padding' => null,
            'borderWidth' => null,
            'relief' => null,
            'width' => null,
            'height' => null,
        ]);
    }
}