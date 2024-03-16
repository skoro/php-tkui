<?php declare(strict_types=1);

namespace Tkui\System;

use FFI;
use RuntimeException;

readonly class FFILoader
{
    /**
     * @param string $header    The C header file.
     * @param string $sharedLib System shared library.
     */
    public function __construct(
        public string $header,
        public string $sharedLib,
    ) {
    }

    /**
     * @throws RuntimeException When the header file cannot be read.
     */
    public function load(): FFI
    {
        if (! file_exists($this->header)) {
            throw new RuntimeException("Header file \"{$this->header}\" doesn't exist.");
        }

        if (($code = file_get_contents($this->header)) === false) {
            throw new RuntimeException("Couldn't read file \"{$this->header}\"");
        }

        return FFI::cdef($code, $this->sharedLib);
    }
}