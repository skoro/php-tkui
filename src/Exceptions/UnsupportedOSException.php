<?php declare(strict_types=1);

namespace Tkui\Exceptions;

class UnsupportedOSException extends Exception
{
    public function __construct()
    {
        parent::__construct(sprintf('Unsupported OS: "%s"', PHP_OS_FAMILY));
    }
}
