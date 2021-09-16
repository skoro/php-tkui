<?php declare(strict_types=1);

namespace PhpGui\Widgets\Text;

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
    public function __construct(TextIndex $from, TextIndex $to)
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
}