<?php declare(strict_types=1);

namespace Tkui\Widgets\Menu;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * Makes a group of menu items.
 */
abstract class CommonGroup implements IteratorAggregate
{
    private int $id;

    // TODO: id generator ?
    private static int $idIterator = 0;

    /**
     * @var CommonItem[]
     */
    private array $items;

    /**
     * @param CommonItem[] $items The list of menu items.
     */
    public function __construct(array $items)
    {
        $this->id = self::generateId();
        $this->items = $items;
    }

    private static function generateId(): int
    {
        return ++self::$idIterator;
    }

    /**
     * Invoked when the group is attached to the menu.
     */
    abstract public function attach(Menu $menu): void;

    /**
     * @return CommonItem[]
     */
    public function items(): array
    {
        return $this->items;
    }

    // TODO: identificable interface
    public function id(): string
    {
        return 'menu-group-' . $this->id;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }
}