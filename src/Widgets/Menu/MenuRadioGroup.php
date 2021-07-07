<?php declare(strict_types=1);

namespace PhpGui\Widgets\Menu;

use PhpGui\Exceptions\UninitializedVariableException;
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
    private ?Variable $variable = null;

    /**
     * @var mixed
     */
    private $selected;

    /**
     * @param MenuRadioItem[] $items    The list of menu radio items.
     * @param mixed          $selected The selected value of radio item.
     */
    public function __construct(array $items, $selected = null)
    {
        parent::__construct($items);
        $this->select($selected);
    }

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
        $this->select($this->selected);
    }

    /**
     * Selects the radio item.
     *
     * @param mixed $value
     */
    public function select($value): void
    {
        if ($this->variable) {
            $this->variable->set($value);
        }
        $this->selected = $value;
    }

    /**
     * Gets the selected value of radio item.
     *
     * @return string
     */
    public function selected()
    {
        if (! $this->variable) {
            throw new UninitializedVariableException();
        }
        return $this->variable->asString();
    }
}