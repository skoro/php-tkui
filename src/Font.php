<?php declare(strict_types=1);

namespace PhpGui;

class Font
{
    public const REGULAR = 'regular';
    public const BOLD = 'bold';
    public const ITALIC = 'italic';
    public const UNDERLINE = 'underline';
    public const OVERSTRIKE = 'overstrike';

    private string $name;
    private int $size;

    /** @var string[] */
    private array $styles;

    /**
     * @param string[] $styles;
     */
    public function __construct(string $name, int $size, array $styles = [])
    {
        $this->name = $name;
        // TODO: validate styles.
        $this->styles = $styles;
        // TODO: validate size.
        $this->size = $size;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function size(): int
    {
        return $this->size;
    }

    public function isRegular(): bool
    {
        return empty($this->styles) || in_array(self::REGULAR, $this->styles);
    }

    public function isBold(): bool
    {
        return in_array(self::BOLD, $this->styles);
    }

    public function isItalic(): bool
    {
        return in_array(self::ITALIC, $this->styles);
    }

    public function isUnderline(): bool
    {
        return in_array(self::UNDERLINE, $this->styles);
    }

    public function isOverstrike(): bool
    {
        return in_array(self::OVERSTRIKE, $this->styles);
    }

    /**
     * @return string[]
     */
    public function styles(): array
    {
        return $this->styles;
    }
}