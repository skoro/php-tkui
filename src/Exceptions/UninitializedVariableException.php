<?php declare(strict_types=1);

namespace Tkui\Exceptions;

use RuntimeException;

class UninitializedVariableException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Variable is uninitialized.');
    }
}