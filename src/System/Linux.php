<?php

declare(strict_types=1);

namespace Tkui\System;

class Linux extends OS
{
    public function defaultThemeName(): string
    {
        return 'clam';
    }

    public function tclSharedLib(): string
    {
        return 'libtcl8.6.so';
    }

    public function tkSharedLib(): string
    {
        return 'libtk8.6.so';
    }
}