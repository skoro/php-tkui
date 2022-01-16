<?php declare(strict_types=1);

namespace Tkui\Widgets\Menu;

/**
 * Separator menu item.
 *
 * A horizontal line which separates menu items from each other.
 */
class MenuSeparatorItem extends CommonItem
{
    public function type(): string
    {
        return 'separator';
    }
}