<?php declare(strict_types=1);

namespace Tkui\Widgets\Text;

/**
 * A range of text content.
 */
class Range
{
    private TextIndex $from;
    private TextIndex $to;

    /**
     * @param TextIndex $from The starting position.
     * @param TextIndex $to   The ending position.
     */
    final public function __construct(TextIndex $from, TextIndex $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function from(): TextIndex
    {
        return $this->from;
    }

    public function to(): TextIndex
    {
        return $this->to;
    }

    public function __toString(): string
    {
        return (string) $this->from . ' ' . (string) $this->to;
    }

    public static function create(int $startLine, int $startChar, int $endLine = null, int $endChar = null): self
    {
        return new static(new TextIndex($startLine, $startChar), new TextIndex($endLine, $endChar));
    }

    public static function createFromStrings(string $start, string $end): self
    {
        return new static(TextIndex::parse($start), TextIndex::parse($end));
    }
}
