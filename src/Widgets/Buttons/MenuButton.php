<?php declare(strict_types=1);

namespace Tkui\Widgets\Buttons;

use Tkui\Options;
use Tkui\Widgets\Container;
use Tkui\Widgets\Menu\Menu;

/**
 * Implementation of menubutton.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_menubutton.html
 *
 * @property string $text
 * @property int $underline
 * @property Menu $menu
 * @property string $direction
 */
class MenuButton extends GenericButton
{
    const DIRECTION_ABOVE = 'above';
    const DIRECTION_BELOW = 'below';
    const DIRECTION_LEFT = 'left';
    const DIRECTION_RIGHT = 'right';
    const DIRECTION_FLUSH = 'flush';

    protected string $widget = 'ttk::menubutton';
    protected string $name = 'mbtn';

    public function __construct(Container $parent, string $title, Menu $menu, array $options = [])
    {
        $options['text'] = $title;
        $options['menu'] = $menu;
        parent::__construct($parent, $options);
    }

    /**
     * @inheritdoc
     */
    protected function initWidgetOptions(): Options
    {
        return new Options([
            'text' => null,
            'compound' => null,
            'image' => null,
            'textVariable' => null,
            'width' => null,
            'state' => null,
            'underline' => null,
            'menu' => null,
            'direction' => null,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function invoke(): self
    {
        // Does nothing for menubutton widget.
        return $this;
    }
}