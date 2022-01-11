<?php declare(strict_types=1);

namespace Tkui\Widgets\Menu;

use Tkui\Color;
use Tkui\Options;
use Tkui\Widgets\Common\DetectUnderline;
use Tkui\Widgets\Container;
use Tkui\Widgets\TtkContainer;
use Tkui\Widgets\Widget;
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
    use DetectUnderline;

    protected string $widget = 'menu';
    protected string $name = 'm';

    protected const MENU_ITEM_METHOD_ADD = 'add';
    protected const MENU_ITEM_METHOD_CONFIGURE = 'entryconfig';

    /**
     * @var array<int, CommonItem>
     */
    private array $items = [];

    /**
     * Tcl callback command name.
     */
    private string $callbackCommand;

    final public function __construct(Container $parent, array $options = [])
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
            if ($item instanceof MenuItem) {
                call_user_func($item->command, $item, $widget);
            }
        }
    }

    /**
     * Adds a submenu to the menu.
     */
    public function addMenu(string $title): self
    {
        $menuTitle = $this->removeUnderlineChar($title);

        $submenu = new static($this, [
            'title' => $menuTitle,
        ]);

        $options = new Options([
            'label' => $menuTitle,
            'menu' => $submenu->path(),
            'underline' => $this->detectUnderlineIndex($title),
        ]);

        $this->call('add', 'cascade', ...$options->asStringArray());

        return $submenu;
    }

    /**
     * Adds a single menu item to the menu.
     */
    public function addItem(CommonItem $item): self
    {
        $item->attach($this);

        $this->items[$item->id()] = $item;

        $this->callMenuItemMethod(self::MENU_ITEM_METHOD_ADD, $item);

        return $this;
    }

    /**
     * Adds a separator between menu items.
     */
    public function addSeparator(): self
    {
        return $this->addItem(new MenuSeparatorItem());
    }

    /**
     * Adds a group of menu items.
     */
    public function addGroup(CommonGroup $group): self
    {
        $group->attach($this);
        foreach ($group as $item) {
            $this->addItem($item);
        }
        return $this;
    }

    protected function callMenuItemMethod(string $method, CommonItem $item)
    {
        $options = clone $item->options();

        // Redirect menu item's callback to menu's one.
        // Due to items don't have an access to underlying gui engine
        // all events will be handled by menu itself.
        if ($options->has('command') && $options->command) { /** @phpstan-ignore-line */
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