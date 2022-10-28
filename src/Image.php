<?php declare(strict_types=1);

namespace Tkui;

/**
 * Contract for graphic images.
 *
 * TODO: extends Stringable
 */
interface Image
{
    public function width(): int;

    public function height(): int;
}
