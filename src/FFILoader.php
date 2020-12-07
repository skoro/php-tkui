<?php declare(strict_types=1);

namespace TclTk;

use FFI;

class FFILoader
{
    protected function load(string $header): FFI
    {
        return FFI::load(__DIR__ . '/headers/' . $header);
    }

    public function loadTcl(): FFI
    {
        return $this->load('tcl86.h');
    }

    public function loadTk(): FFI
    {
        return $this->load('tk86.h');
    }
}