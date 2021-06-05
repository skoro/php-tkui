<?php declare(strict_types=1);

namespace PhpGui;

use InvalidArgumentException;

/**
 * The color specification.
 */
class Color
{
    private int $red;
    private int $green;
    private int $blue;

    public function __construct(string $hex)
    {
        $this->extractColors($hex);
    }

    protected function extractColors(string $hex)
    {
        list ($red, $green, $blue) = sscanf($hex, '#%02x%02x%02x');
        if ($red !== null && $green !== null && $blue !== null) {
            $this->red = $red;
            $this->green = $green;
            $this->blue = $blue;
        }
        throw new InvalidArgumentException('Invalid color hex value: ' . $hex);
    }

    public static function fromRgb(int $red, int $green, int $blue): self
    {
        return new static(sprintf('%02x%02x%02x', $red, $green, $blue));
    }

    public static function fromHex(string $hex): self
    {
        return new static($hex);
    }

    public static function fromName(string $name): self
    {
        $lname = strtolower($name);
        if (! isset(ColorNames::$color[$lname])) {
            throw new InvalidArgumentException('Invalid color name: ' . $name);
        }
        return static::fromRgb(...ColorNames::$color[$lname]);
    }

    public function red(): int
    {
        return $this->red;
    }

    public function green(): int
    {
        return $this->green;
    }

    public function blue(): int
    {
        return $this->blue;
    }

    public function __toString()
    {
        return $this->toHexString();
    }

    public function toHexString(): string
    {
        return sprintf('#%02x%02x%02x', $this->red, $this->green, $this->blue);
    }

    public function toRgbString(): string
    {
        return sprintf('rgb(%d, %d, %d)', $this->red, $this->green, $this->blue);
    }
}