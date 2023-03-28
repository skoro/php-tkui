<?php

declare(strict_types=1);

namespace Tkui\System;

class Windows extends OS
{
    public function defaultThemeName(): string
    {
        return 'vista';
    }

    public function tclSharedLib(): string
    {
        return 'tcl86t.dll';
    }

    public function tkSharedLib(): string
    {
        return 'tk86t.dll';
    }
}