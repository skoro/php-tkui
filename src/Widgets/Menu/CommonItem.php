<?php declare(strict_types=1);

namespace Tkui\Widgets\Menu;

use Tkui\Options;
use Tkui\Widgets\Common\SubjectItem;

/**
 * Base for a menu item.
 */
abstract class CommonItem extends SubjectItem
{
    private int $id;

    // TODO: id generator ?
    private static int $idIterator = 0;

    public function __construct(array|Options $options = [])
    {
        parent::__construct($options);
        $this->id = self::generateId();
    }

    private static function generateId(): int
    {
        return ++self::$idIterator;
    }

    abstract public function type(): string;

    // TODO: identificable interface
    public function id(): int
    {
        return $this->id;
    }
}
