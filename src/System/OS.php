<?php declare(strict_types=1);

namespace Tkui\System;

class OS
{
    public static function name(): string
    {
        return strtoupper(PHP_OS);
    }

    public static function family(): string
    {
        return strtoupper(PHP_OS_FAMILY);
    }
}
