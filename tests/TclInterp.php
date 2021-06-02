<?php declare(strict_types=1);

namespace PhpGui\Tests;

use PhpGui\FFILoader;
use PhpGui\TclTk\Interp;
use PhpGui\TclTk\Tcl;

trait TclInterp
{
    protected Tcl $tcl;
    protected Interp $interp;

    protected function setUp(): void
    {
        parent::setUp();

        $loader = new FFILoader();
        $this->tcl = new Tcl($loader->loadTcl());
        $this->interp = $this->tcl->createInterp();
    }
}