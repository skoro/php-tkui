<?php declare(strict_types=1);

namespace PhpGui\TclTk;

use PhpGui\Font;

class TkFont extends Font
{
    public function __toString(): string
    {
        return $this->asString();
    }

    public function asString(): string
    {
        $size = $this->getSize();

        return sprintf('{%s %s %s}',
            $this->asTclName(),
            $size > 0 ? $size : '',
            implode(' ', $this->getStyleNames())
        );
    }

    protected function asTclName(): string
    {
        return '{' . $this->getName() . '}';
    }

    protected function getStyleNames(): array
    {
        return array_keys(array_filter($this->getStyles()));
    }
}