<?php declare(strict_types=1);

namespace Tkui\Widgets\Menu;

/**
 * Aggregates menu items into the group.
 */
class MenuItemGroup extends CommonGroup
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * @param MenuItem[] $items
     * @param callable $callback The callback for the items.
     */
    // TODO: accept items as string also and convert them into MenuItem.
    // And you could use the group as simple as:
    //new MenuGroupItem(['item1', 'item2', '...'], $callback)
    public function __construct(array $items, $callback)
    {
        parent::__construct($items);
        $this->callback = $callback;
    }

    /**
     * @inheritdoc
     */
    public function attach(Menu $menu): void
    {
        /** @var MenuItem $item */
        foreach ($this->items() as $item) {
            if ($item->options()->has('command')) {
                $item->command = $this->callback;
            }
        }
    }
}