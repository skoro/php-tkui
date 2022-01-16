<?php declare(strict_types=1);

namespace Tkui\Widgets\Text;

use InvalidArgumentException;

/**
 * The text search options.
 */
class SearchOptions
{
    const FORWARD = 1;
    const BACKWARD = 2;

    private int $direction;
    private bool $regexp;
    private bool $ignoreCase;
    private bool $allMatches;

    public function __construct()
    {
        $this->direction = self::FORWARD;
        $this->regexp = false;
        $this->ignoreCase = true;
        $this->allMatches = false;
    }

    public function setDirection(int $value): self
    {
        switch ($value) {
            case self::FORWARD:
            case self::BACKWARD:
                $this->direction = $value;
                break;
            
            default:
                throw new InvalidArgumentException(sprintf('Invalid direction value "%d"', $value));
        }

        return $this;
    }

    public function getDirection(): int
    {
        return $this->direction;
    }

    public function setRegexp(bool $value): self
    {
        $this->regexp = $value;
        return $this;
    }

    public function isRegexp(): bool
    {
        return $this->regexp;
    }

    public function setIgnoreCase(bool $value): self
    {
        $this->ignoreCase = $value;
        return $this;
    }

    public function isIgnoreCase(): bool
    {
        return $this->ignoreCase;
    }

    public function setAllMatches(bool $value): self
    {
        $this->allMatches = $value;
        return $this;
    }

    public function isAllMatches(): bool
    {
        return $this->allMatches;
    }
}
