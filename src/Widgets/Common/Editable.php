<?php declare(strict_types=1);

namespace TclTk\Widgets\Common;

/**
 * Widgets that can edit their content.
 */
interface Editable
{
    /**
     * Clears the contents.
     */
    public function clear(): self;

    /**
     * Appends a text to the end of the contents.
     */
    public function append(string $text): self;

    /**
     * Gets the widget content.
     */
    public function getContent(): string;
}