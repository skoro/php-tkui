<?php

declare(strict_types=1);

namespace Tkui\Exceptions;

class InvalidValueTypeException extends Exception
{
    public function __construct(string $expectedType, mixed $actual)
    {
        parent::__construct(
            sprintf('Expected value of type "%s" but got "%s".', $expectedType, $this->typeToString($actual))
        );
    }

    private function typeToString(mixed $type): string
    {
        return is_object($type) ? get_class($type) : gettype($type);
    }
}
