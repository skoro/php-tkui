<?php declare(strict_types=1);

namespace TclTk;

use FFI;
use TclTk\Exceptions\EvalException;
use TclTk\Exceptions\TclException;

/**
 * Low-level interface to Tcl FFI.
 */
class Tcl
{
    /**
     * Command status codes.
     */
    public const TCL_OK = 0;
    public const TCL_ERROR = 1;
    public const TCL_RETURN = 2;
    public const TCL_BREAK = 3;
    public const TCL_CONTINUE = 4;

    private FFI $ffi;

    public function __construct(FFI $ffi)
    {
        $this->ffi = $ffi;
    }

    public function createInterp(): Interp
    {
        return new Interp($this, $this->ffi->Tcl_CreateInterp());
    }

    public function init(Interp $interp)
    {
        if ($this->ffi->Tcl_Init($interp->cdata()) != self::TCL_OK) {
            throw new TclException("Couldn't initialize Tcl interpretator.");
        }
    }

    /**
     * @param Interp $interp
     * @param string $script Tcl script.
     *
     * @return int Command status code.
     */
    public function eval(Interp $interp, string $script): int
    {
        $status = $this->ffi->Tcl_Eval($interp->cdata(), $script);
        if ($status != self::TCL_OK) {
            throw new EvalException($script, $this->getStringResult($interp));
        }
        return $status;
    }

    /**
     * Quote a string.
     *
     * When the string has [] characters it must be quoted otherwise
     * it the data inside square brackets will be substituted by Tcl interp.
     */
    public static function quoteString(string $str): string
    {
        return '{' . $str . '}';
    }

    /**
     * Returns a string representation from Tcl_Obj structure.
     *
     * @link https://www.tcl.tk/man/tcl8.6/TclLib/StringObj.htm
     */
    public function getString($tclObj): string
    {
        return $this->ffi->Tcl_GetString($tclObj);
    }

    /**
     * Converts the Tcl Obj to a string.
     */
    public function getStringResult(Interp $interp): string
    {
        return $this->ffi->Tcl_GetString($this->ffi->Tcl_GetObjResult($interp->cdata()));
    }

    /**
     * Creates a new Tcl command for the specified interpreter.
     *
     * @param Interp $interp     The TCL interpreter.
     * @param string $command    The command name.
     * @param callable $callback The command callback.
     *
     * @link https://www.tcl.tk/man/tcl8.6/TclLib/CrtObjCmd.htm
     */
    public function createCommand(Interp $interp, string $command, callable $callback)
    {
        $this->ffi->Tcl_CreateObjCommand($interp->cdata(), $command, $callback, NULL, NULL);
    }
}