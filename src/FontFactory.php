<?php

declare(strict_types=1);

namespace Tkui;

interface FontFactory
{
    /**
     * Creates a new font from the string specification.
     *
     * Not all implementations can support that.
     *
     * @param string $fontSpec The string that describes a font.
     */
    public function createFontFromString(string $fontSpec): Font;
}
