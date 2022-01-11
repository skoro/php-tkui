<?php declare(strict_types=1);

namespace Tkui\Widgets\Common;

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

    /**
     * Clears the current content and sets new one.
     */
    public function setContent(string $text): self;
}