<?php

declare(strict_types=1);

namespace Tkui\Exceptions;

class OptionNotFoundException extends Exception
{
    public function __construct(
        public readonly string $option,
    ) {
        parent::__construct("\"$option\" not found.");
    }
}
