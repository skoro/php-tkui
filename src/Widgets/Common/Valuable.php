<?php declare(strict_types=1);

namespace TclTk\Widgets\Common;

/**
 * Widgets that can set or return their value.
 */
interface Valuable
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