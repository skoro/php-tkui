<?php declare(strict_types=1);

namespace Tkui\Widgets\Buttons;

use Tkui\Options;
use Tkui\TclTk\TclOptions;
use Tkui\Widgets\Container;
use Tkui\Widgets\Consts\Direction;
use Tkui\Widgets\Menu\Menu;

/**
 * Implementation of menubutton.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/ttk_menubutton.html
 *
 * @property string $text
 * @property int $underline
 * @property Menu $menu
 * @property Direction $direction
 */
class MenuButton extends GenericButton
{
    protected string $widget = 'ttk::menubutton';
    protected string $name = 'mbtn';

    public function __construct(Container $parent, string $title, Menu $menu, array|Options $options = [])
    {
        $options['text'] = $title;
        $options['menu'] = $menu;
        parent::__construct($parent, $options);
    }

    /**
     * @inheritdoc
     */
    protected function createOptions(): Options
    {
        return new TclOptions([
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
    public function invoke(): static
    {
        // Does nothing for menubutton widget.
        return $this;
    }
}