<?php declare(strict_types=1);

namespace TclTk;

use FFI;
use FFI\CData;
use RuntimeException;

/**
 * Low-level interface to Tk FFI.
 */
class Tk
{
    private FFI $ffi;
    private CData $tkInterp;
    private Interp $tclInterp;

    /**
     * @param FFI    $ffi    FFI to Tk library.
     * @param Interp $interp Tcl interpreter.
     */
    public function __construct(FFI $ffi, Interp $interp)
    {
        $this->ffi = $ffi;
        $this->tclInterp = $interp;
        $this->tkInterp = $ffi->cast($ffi->type('Tcl_Interp*'), $interp->cdata());
    }

    public function init(): void
    {
        if ($this->ffi->Tk_Init($this->tkInterp) !== Tcl::TCL_OK) {
            throw new RuntimeException("Couldn't init Tk library.");
        }
    }

    public function mainLoop(): void
    {
        $this->ffi->Tk_MainLoop();
    }

    public function interp(): Interp
    {
        return $this->tclInterp;
    }
}