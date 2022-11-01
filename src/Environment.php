<?php declare(strict_types=1);

namespace Tkui;

interface Environment
{
    /**
     * Reads the environment value.
     */
    public function getValue(string $param, mixed $default = null): mixed;
}
