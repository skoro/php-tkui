<?php declare(strict_types=1);

namespace PhpGui;

use Stringable;

/**
 * Contract for graphic images.
 */
interface Image extends Stringable
{
    public function width(): int;

    public function height(): int;
}
