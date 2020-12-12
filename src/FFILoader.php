<?php declare(strict_types=1);

namespace TclTk;

use FFI;
use RuntimeException;

class FFILoader
{
    private string $dirHeaders;

    /**
     * @param string $dirHeader The base directory for header files.
     */
    public function __construct(string $dirHeaders = '')
    {
        if (empty($dirHeaders)) {
            $dirHeaders = __DIR__ . '/headers';
        }
        $this->dirHeaders = rtrim($dirHeaders, '/') . '/';
    }

    /**
     * @throws RuntimeException When the header file cannot be read.
     */
    protected function load(string $header): FFI
    {
        $file = $this->dirHeaders . $header;
        if (!file_exists($file)) {
            throw new RuntimeException("Couldn't read header file: " . $file);
        }
        return FFI::load($file);
    }

    public function loadTcl(string $tcl = 'tcl86.h'): FFI
    {
        return $this->load($tcl);
    }

    public function loadTk(string $tk = 'tk86.h'): FFI
    {
        return $this->load($tk);
    }
}