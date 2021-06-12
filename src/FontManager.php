<?php declare(strict_types=1);

namespace PhpGui;

/**
 * Font manager.
 */
interface FontManager
{
    /**
     * Returns the default application font.
     */
    public function getDefaultFont(): Font;

    /**
     * Returns the default fixed font.
     */
    public function getFixedFont(): Font;

    /**
     * Registers a new font specification.
     */
    // public function register(string $alias, Font $font): self;

    /**
     * Unregisters the font specification.
     */
    // public function unregister(string $alias): self;

    /**
     * Returns a value of the total width in pixel of the text.
     *
     * @return int The width in pixels.
     */
    // public function getTextWidth(string $text, Font $font): int;

    /**
     * Returns a list of all available font names.
     *
     * @return string[]
     */
    public function getFontNames(): array;
}