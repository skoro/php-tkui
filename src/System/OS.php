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

    /**
     * Ttk theme name.
     *
     * A list of available themes can be found from the tcl command:
     * `ttk::style theme names`
     * 
     * "default" theme the most safest option as it's always available in
     * Tk distribution.
     */
    public function defaultThemeName(): string
    {
        return 'default';
    }

    /**
     * File name or path of Tcl shared library.
     *
     * It can be a file name when the library is available in the system path
     * and OS can find it. Otherwise it must be a file path.
     */
    abstract public function tclSharedLib(): string;

    /**
     * File name or path of Tk shared library.
     *
     * It can be a file name when the library is available in the system path
     * and OS can find it. Otherwise it must be a file path.
     */
    abstract public function tkSharedLib(): string;
}
