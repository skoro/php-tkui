<?php declare(strict_types=1);

namespace Tkui\Widgets\Common;

/**
 * Widgets that contains their value in the variable.
 */
interface ValueInVariable
{
    /**
     * Sets the widget value.
     *
     * @param mixed $value
     */
    public function setValue($value): self;

    /**
     * Gets the widget value.
     *
     * @return mixed
     */
    public function getValue();
}