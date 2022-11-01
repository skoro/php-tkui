<?php

declare(strict_types=1);

namespace Tkui\System;

abstract class OS
{
    final public function family(): string
    {
        return strtoupper(PHP_OS_FAMILY);
    }

    final public function name(): string
    {
        return strtoupper(PHP_OS);
    }

    abstract public function defaultThemeName(): string;

    abstract public function tclSharedLib(): string;
    abstract public function tkSharedLib(): string;
}
