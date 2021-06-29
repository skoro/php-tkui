<?php declare(strict_types=1);

namespace PhpGui\Widgets\Menu;

use PhpGui\Color;
use PhpGui\Options;
use PhpGui\Widgets\Container;
use PhpGui\Widgets\TtkContainer;
use PhpGui\Widgets\Widget;

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
class Menu extends TtkContainer
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
     * @var MenuItem[]
     */
    private array $items = [];

    /**
     * Tcl callback command name.
     */
    private string $callbackCommand;

    public function __construct(Container $parent, array $options = [])
    {
        parent::__construct($parent, $options);
        $this->callbackCommand = $this->getEval()->registerCallback($this, [$this, 'handleItemCallback']);
    }

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

    public function addMenu(string $title): self
    {
        $submenu = new static($this, [
            'title' => $title
        ]);

        $this->call('add', 'cascade', '-label', $title, '-menu', $submenu->path());

        return $submenu;
    }

    public function addItem(CommonItem $item): self
    {
        $this->items[$item->id()] = $item;

        $options = clone $item->options();

        if ($options->has('command')) {
            $options->command = $this->callbackCommand . ' ' . $item->id();
        }

        return $this->addMenuType($item->type(), $options);
    }

    public function addSeparator(): self
    {
        $this->call('add', 'separator');
        return $this;
    }

    public function handleItemCallback(Widget $widget, $itemId)
    {
        if (isset($this->items[$itemId])) {
            $item = $this->items[$itemId];
            call_user_func($item->command, $item, $widget);
        }
    }

    protected function addMenuType(string $type, Options $options): self
    {
        $this->call('add', $type, ...$options->asStringArray());
        return $this;
    }
}