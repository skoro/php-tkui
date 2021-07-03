<?php declare(strict_types=1);

namespace PhpGui\Widgets\Menu;

use PhpGui\Color;
use PhpGui\Options;
use PhpGui\Widgets\Container;
use PhpGui\Widgets\TtkContainer;
use PhpGui\Widgets\Widget;
use SplSubject;

/**
 * Menu implementation.
 *
 * @link https://www.tcl.tk/man/tcl8.6/TkCmd/menu.html
 *
 * @property callable $postCommand
 * @property Color|string $selectColor
 * @property string $title
 */
class Menu extends TtkContainer
{
    protected string $widget = 'menu';
    protected string $name = 'm';

    protected const MENU_ITEM_METHOD_ADD = 'add';
    protected const MENU_ITEM_METHOD_CONFIGURE = 'entryconfig';

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
        // TearOff menus isn't supported.
        $options['tearoff'] = 0;

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
            'title' => null,
        ]);
    }

    public function handleItemCallback(Widget $widget, $itemId)
    {
        if (isset($this->items[$itemId])) {
            $item = $this->items[$itemId];
            call_user_func($item->command, $item, $widget);
        }
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
        $item->attach($this);

        $this->items[$item->id()] = $item;

        $this->callMenuItemMethod(self::MENU_ITEM_METHOD_ADD, $item);

        return $this;
    }

    public function addSeparator(): self
    {
        return $this->addItem(new MenuSeparatorItem());
    }

    protected function callMenuItemMethod(string $method, CommonItem $item)
    {
        $options = clone $item->options();

        // Redirect menu item's callback to menu's one.
        // Due to items don't have an access to underlying gui engine
        // all events will be handled by menu itself.
        if ($options->has('command') && $options->command) {
            $options->command = $this->callbackCommand . ' ' . $item->id();
        }

        switch ($method) {
            case self::MENU_ITEM_METHOD_ADD:
                $this->callAddMenuItem($item->type(), $options);
                break;

            case self::MENU_ITEM_METHOD_CONFIGURE:
                $this->callConfigMenuItem($item->id(), $options);
                break;
        }
    }

    protected function callAddMenuItem(string $type, Options $options): void
    {
        $this->call('add', $type, ...$options->asStringArray());
    }

    protected function callConfigMenuItem(int $id, Options $options): void
    {
        $index = 0;
        $found = null;
        foreach ($this->items as $k => $item) {
            if ($k === $id) {
                $found = $item;
                break;
            }
            $index++;
        }
        if ($found) {
            $this->call('entryconfigure', $index, ...$options->asStringArray());
        }
    }

    /**
     * @inheritdoc
     */
    public function update(SplSubject $subject): void
    {
        parent::update($subject);
        if ($subject instanceof CommonItem) {
            $this->callMenuItemMethod(self::MENU_ITEM_METHOD_CONFIGURE, $subject);
        }
    }
}