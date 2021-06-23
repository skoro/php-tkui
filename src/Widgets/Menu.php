<?php declare(strict_types=1);

namespace PhpGui\Widgets;

use PhpGui\Color;
use PhpGui\Options;

/**
 * Menu implementation.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/menu.html
 *
 * @property callable $postCommand
 * @property Color|string $selectColor
 * @property bool $tearOff
 * @property callable $tearOffCommand
 * @property string $title
 * @property string $type
 */
class Menu extends TkWidget
{
    /**
     * Menu type.
     */
    const TYPE_MENUBAR = 'menubar';
    const TYPE_TEAROFF = 'tearoff';
    const TYPE_NORMAL = 'normal';

    protected string $widget = 'menu';
    protected string $name = 'm';

    /**
     * @inheritdoc
     */
    protected function initWidgetOptions(): Options
    {
        return new Options([
            'postCommand' => null,
            'selectColor' => null,
            'tearOff' => null,
            'tearOffCommand' => null,
            'title' => null,
            'type' => null,
        ]);
    }
}