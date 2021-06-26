<?php declare(strict_types=1);

namespace PhpGui\Widgets\Menu;

interface Clickable
{
    public function onClick(callable $callback): self;

    public function callback(): ?callable;

    public function hasCallback(): bool;
}