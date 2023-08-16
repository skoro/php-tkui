<?php

declare(strict_types=1);

namespace Tkui\System;

class Darwin extends OS
{
    public function defaultThemeName(): string
    {
        return 'aqua';
    }

    public function tclSharedLib(): string
    {
        return 'libtcl8.6.dylib';
    }

    public function tkSharedLib(): string
    {
        return 'libtk8.6.dylib';
    }
}
