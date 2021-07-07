<?php declare(strict_types=1);

namespace PhpGui\Widgets\Menu;

use PhpGui\TclTk\Variable;

/**
 * Allows to create a group of menu radio items.
 */
class MenuRadioGroup extends CommonGroup
{
    /**
     * The group variable.
     *
     * It's shared between all radio item instances.
     */
    private Variable $variable;

    /**
     * @inheritdoc
     */
    public function attach(Menu $menu): void
    {
        $this->variable = $menu->getEval()->registerVar($this->id());
        foreach ($this->items() as $item) {
            if ($item instanceof MenuRadioItem) {
                $item->variable = $this->variable;
            }
        }
    }
}