<?php declare(strict_types=1);

namespace PhpGui\TclTk;

use FFI;
use FFI\CData;
use PhpGui\TclTk\Exceptions\TclException;

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
        /** @phpstan-ignore-next-line */
        if ($this->ffi->Tk_Init($this->tkInterp) !== Tcl::TCL_OK) {
            throw new TclException("Couldn't init Tk library.");
        }
    }

    public function mainLoop(): void
    {
        /** @phpstan-ignore-next-line */
        $this->ffi->Tk_MainLoop();
    }

    public function interp(): Interp
    {
        return $this->tclInterp;
    }

    public function mainWindow()
    {
        /** @phpstan-ignore-next-line */
        $tkWin = $this->ffi->Tk_MainWindow($this->tkInterp);
        return $tkWin;
    }

    public function destroy($win)
    {
        /** @phpstan-ignore-next-line */
        $this->ffi->Tk_DestroyWindow($win);
    }

    public function nameToWindow(string $pathName, $win)
    {
        /** @phpstan-ignore-next-line */
        $this->ffi->Tk_NameToWindow($this->tkInterp, $pathName, $win);
    }
}