<?php declare(strict_types=1);

namespace Tkui;

use Stringable;

/**
 * Contract for graphic images.
 */
interface Image extends Stringable
{
    public function width(): int;

    public function height(): int;
}
