<?php declare(strict_types=1);

namespace Tkui;

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
    public function getTextWidth(string $text, Font $font): int;

    /**
     * Returns a list of all available font names.
     *
     * @return string[]
     */
    public function getFontNames(): array;

    /**
     * Creates a new font from the string specification.
     *
     * Not all implementations can support that.
     *
     * @param string $fontSpec The string that describes a font.
     */
    public function createFontFromString(string $fontSpec): Font;
}