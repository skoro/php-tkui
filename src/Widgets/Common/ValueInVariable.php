<?php declare(strict_types=1);

namespace TclTk\Widgets\Common;

/**
 * Widgets that contains their value in the variable.
 */
interface ValueInVariable
{
    /**
     * Sets the widget value.
     */
    public function setValue($value): self;

    /**
     * Gets the widget value.
     */
    public function getValue();
}