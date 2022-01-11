<?php declare(strict_types=1);

namespace Tkui;

use InvalidArgumentException;
use SplObserver;
use SplSubject;

class Font implements SplSubject
{
    public const REGULAR = 'normal';
    public const BOLD = 'bold';
    public const ITALIC = 'italic';
    public const UNDERLINE = 'underline';
    public const OVERSTRIKE = 'overstrike';

    private string $name;
    private int $size;

    /** @var SplObserver[] */
    private array $observers;

    /** @var array<string, bool> */
    private array $styles;

    public function __construct(string $name, int $size, ...$styles)
    {
        $this->observers = [];
        $this->setName($name);
        $this->setSize($size);
        $this->styles = $this->defaultStyles();
        foreach ($styles as $style) {
            $this->setStyle($style, true);
        }
    }

    /**
     * @return array<string, bool>
     */
    protected function defaultStyles(): array
    {
        return [
            self::REGULAR => true,
            self::BOLD => false,
            self::ITALIC => false,
            self::UNDERLINE => false,
            self::OVERSTRIKE => false,
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @throws InvalidArgumentException When the font name is empty.
     */
    public function setName(string $name): self
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
    public function setSize(int $size): self
    {
        if ($size <= 0) {
            throw new InvalidArgumentException('Font size cannot be zero or negative.');
        }
        $this->size = $size;
        $this->notify();
        return $this;
    }

    /**
     * @return array<string, bool>
     */
    public function getStyles(): array
    {
        return $this->styles;
    }

    public function isRegular(): bool
    {
        return $this->styles[self::REGULAR];
    }

    public function setRegular(): self
    {
        return $this->setStyle(self::REGULAR, true);
    }

    public function isBold(): bool
    {
        return $this->styles[self::BOLD];
    }

    public function setBold(bool $bold): self
    {
        return $this->setStyle(self::BOLD, $bold);
    }

    public function isItalic(): bool
    {
        return $this->styles[self::ITALIC];
    }

    public function setItalic(bool $italic): self
    {
        return $this->setStyle(self::ITALIC, $italic);
    }

    public function isUnderline(): bool
    {
        return $this->styles[self::UNDERLINE];
    }

    public function setUnderline(bool $underline): self
    {
        return $this->setStyle(self::UNDERLINE, $underline);
    }

    public function isOverstrike(): bool
    {
        return $this->styles[self::OVERSTRIKE];
    }

    public function setOverstrike(bool $overstrike): self
    {
        return $this->setStyle(self::OVERSTRIKE, $overstrike);
    }

    public function setStyle(string $style, bool $value = true): self
    {
        $this->validateStyle($style);
        if ($style === self::REGULAR && $value) {
            $this->styles[self::BOLD] = false;
            $this->styles[self::ITALIC] = false;
        }
        $this->styles[$style] = $value;
        if (array_reduce($this->styles, fn ($carry, $val) => $carry || $val, false) === false) {
            throw new InvalidArgumentException('Font must have at least one style.');
        }
        $this->notify();
        return $this;
    }

    protected function validateStyle(string $style): void
    {
        switch ($style) {
            case self::REGULAR:
            case self::BOLD:
            case self::ITALIC:
            case self::UNDERLINE:
            case self::OVERSTRIKE:
                break;

            default:
                throw new InvalidArgumentException("Invalid font style: $style");
        }
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

    // TODO: php8 Stringable interface
    public function __toString(): string
    {
        return sprintf('%s %d', $this->name, $this->size);
    }
}