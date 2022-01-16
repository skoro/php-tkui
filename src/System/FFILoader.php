<?php declare(strict_types=1);

namespace Tkui\System;

use FFI;
use RuntimeException;

class FFILoader
{
    private string $hFile;
    private string $sharedLib;

    /**
     * @param string $hFile     The C header file.
     * @param string $sharedLib System shared library.
     */
    public function __construct(
        string $hFile,
        string $sharedLib
    ) {
        $this->hFile = $hFile;
        $this->sharedLib = $sharedLib;
    }

    /**
     * @throws RuntimeException When the header file cannot be read.
     */
    public function load(): FFI
    {
        if (! file_exists($this->hFile)) {
            throw new RuntimeException(sprintf('Header file "%s" doesn\'t exist.', $this->hFile));
        }

        if (($code = file_get_contents($this->hFile)) === false) {
            throw new RuntimeException(sprintf('Couldn\'t read file "%s"', $this->hFile));
        }

        return FFI::cdef($code, $this->sharedLib);
    }

    public function sharedLib(): string
    {
        return $this->sharedLib;
    }

    public function header(): string
    {
        return $this->hFile;
    }
}