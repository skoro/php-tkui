<?php declare(strict_types=1);

namespace TclTk\Widgets\Buttons;

use TclTk\Widgets\Common\ValueInVariable;

/**
 * Contract for buttons which can be selected or deselected.
 */
interface SelectableButton extends ValueInVariable
{
    /**
     * Sets the button's value.
     */
    public function select(): self;

    /**
     * Removes the button's value.
     */
    public function deselect(): self;
}