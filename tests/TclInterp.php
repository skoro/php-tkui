<?php declare(strict_types=1);

namespace TclTk\Tests;

use TclTk\FFILoader;
use TclTk\Interp;
use TclTk\Tcl;

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