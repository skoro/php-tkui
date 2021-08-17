<?php declare(strict_types=1);

namespace PhpGui\Exceptions;

use PhpGui\System\OS;

class UnsupportedOSException extends Exception
{
    public function __construct()
    {
        parent::__construct(sprintf('Unsupported OS: "%s"', OS::family()));
    }
}