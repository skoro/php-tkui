<?php declare(strict_types=1);

namespace Tkui;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionClassConstant;
use SplObserver;
use SplSubject;
use Stringable;

class Font implements SplSubject, Stringable
{
    const STYLE_REGULAR     = 0x0000;
    const STYLE_BOLD        = 0x0001;
    const STYLE_ITALIC      = 0x0002;
    const STYLE_UNDERLINE   = 0x0004;
    const STYLE_OVERSTRIKE  = 0x0008;

    private string $name;
    private int $size;

    /** @var SplObserver[] */
    private array $observers;

    private int $styles = self::STYLE_REGULAR;

    /**
     * @throws InvalidArgumentException When name or size is invalid.
     */
    public function __construct(string $name, int $size, int $styles = self::STYLE_REGULAR)
    {
        $this->observers = [];
        $this->setName($name);
        $this->setSize($size);
        $this->styles = $styles;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @throws InvalidArgumentException When the font name is empty.
     */
    public function setName(string $name): static
    {
        if (! $name) {
            throw new InvalidArgumentException('Font name cannot be empty.');
        }
        $this->name = $name;
        $this->notify();
        return $this;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size The font size. Must be a positive value.
     *
     * @throws InvalidArgumentException When the font size is negative.
     */
    public function setSize(int $size): static
    {
        if ($size <= 0) {
            throw new InvalidArgumentException('Font size cannot be zero or negative.');
        }
        $this->size = $size;
        $this->notify();
        return $this;
    }

    /**
     * @return array<int, bool>
     */
    public function getStyles(): array
    {
        return [
            self::STYLE_REGULAR     => $this->isRegular(),
            self::STYLE_BOLD        => $this->isBold(),
            self::STYLE_ITALIC      => $this->isItalic(),
            self::STYLE_OVERSTRIKE  => $this->isOverstrike(),
            self::STYLE_UNDERLINE   => $this->isUnderline(),
        ];
    }

    public function isRegular(): bool
    {
        return $this->styles === self::STYLE_REGULAR;
    }

    public function setRegular(): static
    {
        $this->styles = self::STYLE_REGULAR;
        return $this;
    }

    public function isBold(): bool
    {
        return ($this->styles & self::STYLE_BOLD) === self::STYLE_BOLD;
    }

    public function setBold(bool $bold = true): static
    {
        return $this->setStyle(self::STYLE_BOLD, $bold);
    }

    public function isItalic(): bool
    {
        return ($this->styles & self::STYLE_ITALIC) === self::STYLE_ITALIC;
    }

    public function setItalic(bool $italic = true): static
    {
        return $this->setStyle(self::STYLE_ITALIC, $italic);
    }

    public function isUnderline(): bool
    {
        return ($this->styles & self::STYLE_UNDERLINE) === self::STYLE_UNDERLINE;
    }

    public function setUnderline(bool $underline = true): static
    {
        return $this->setStyle(self::STYLE_UNDERLINE, $underline);
    }

    public function isOverstrike(): bool
    {
        return ($this->styles & self::STYLE_OVERSTRIKE) === self::STYLE_OVERSTRIKE;
    }

    public function setOverstrike(bool $overstrike = true): static
    {
        return $this->setStyle(self::STYLE_OVERSTRIKE, $overstrike);
    }

    public function setStyle(int $style, bool $setOrUnset): static
    {
        $this->styles = match ($setOrUnset) {
            true    => $this->styles | $style,
            false   => $this->styles ^ ($this->styles & $style),
        };
        $this->notify();
        return $this;
    }

    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    public function attach(SplObserver $observer): void
    {
        $this->observers[] = $observer;
    }

    public function detach(SplObserver $observer): void
    {
        $index = array_search($observer, $this->observers, true);
        if ($index !== false) {
            unset($this->observers[$index]);
        }
    }

    public function __toString(): string
    {
        return $this->asString();
    }

    protected function asString(): string
    {
        return sprintf('%s %d %s',
            $this->name,
            $this->size,
            implode(',', $this->getEnabledStyleNames())
        );
    }

    protected function getEnabledStyleNames(): array
    {
        return array_intersect_key(
            $this->getStyleNames(),
            array_filter($this->getStyles())
        );
    }

    /**
     * @return array<int, string>
     */
    public function getStyleNames(): array
    {
        $rc = new ReflectionClass(static::class);

        $styles = array_filter(
            $rc->getConstants(ReflectionClassConstant::IS_PUBLIC),
            fn ($key) => str_starts_with($key, 'STYLE_'),
            ARRAY_FILTER_USE_KEY
        );

        return array_map(
            fn ($v) => strtolower(str_replace('STYLE_', '', $v)),
            array_flip($styles),
        );
    }
}
