<?php declare(strict_types=1);

namespace Tkui\Widgets\Text;

use Exception;

/**
 * Indicates an index inside the text widget.
 */
class TextIndex
{
    private int $line;
    private int $char;

    /**
     * @param int $line The line, starting from 1, otherwise it will be treated as the end of the text.
     * @param int $char The characted inside the line, starting from 0.
     */
    final public function __construct(int $line = 1, int $char = 0)
    {
        $this->line = $line;
        $this->char = $char;
    }

    public function line(): int
    {
        return $this->line;
    }

    public function char(): int
    {
        return $this->char;
    }

    public function addChars(int $chars): self
    {
        return new static($this->line, $this->char + $chars);
    }

    public function addLines(int $lines): self
    {
        return new static($this->line + $lines, $this->char);
    }

    public function __toString(): string
    {
        return $this->line < 0 ? 'end' : sprintf('%d.%d', $this->line, $this->char);
    }

    /**
     * Creates the index of the end of the text.
     */
    public static function end(): self
    {
        return new static(-1, 0);
    }

    /**
     * Creates the index of the start of the text.
     */
    public static function start(): self
    {
        return new static(1, 0);
    }

    /**
     * Parses an index from the string value.
     *
     * @param string $value The value could be "end", "start" or formatted like this "11.24".
     */
    public static function parse(string $value): self
    {
        if ($value === 'end') {
            return static::end();
        }
        if ($value === 'start') {
            return static::start();
        }
        [$line, $char] = sscanf($value, '%i.%i');
        if ($line !== NULL && $char !== NULL) {
            return new static($line, $char);
        }
        throw new Exception(sprintf('Invalid text index: "%s"', $value));
    }
}
