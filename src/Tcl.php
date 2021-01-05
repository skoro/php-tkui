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

    /**
     * @link https://www.tcl.tk/man/tcl8.6/TclLib/SetVar.htm#M5
     */
    const TCL_GLOBAL_ONLY = 1;
    const TCL_NAMESPACE_ONLY = 2;
    const TCL_APPEND_VALUE = 4;
    const TCL_LEAVE_ERR_MSG = 0x200;
    const TCL_LIST_ELEMENT = 8;

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

    /**
     * Converts a PHP string to the Tcl object.
     */
    public function newStringObj(string $str)
    {
        return $this->ffi->Tcl_NewStringObj($str, strlen($str));
    }

    /**
     * Converts a PHP integer value to the Tcl object.
     */
    public function newIntObj(int $i)
    {
        return $this->ffi->Tcl_NewIntObj($i);
    }

    /**
     * Converts a PHP boolean value to the Tcl object.
     */
    public function newBoolObj(bool $b)
    {
        return $this->ffi->Tcl_NewBooleanObj($b);
    }

    /**
     * Converts a PHP float value to the Tcl object.
     */
    public function newFloatObj(float $f)
    {
        return $this->ffi->Tcl_NewDoubleObj($f);
    }

    /**
     * @param string $varName The Tcl variable name.
     * @param string|NULL $arrIndex When the variable is an array that will be the array index.
     * @param mixed $value
     *
     * @throws TclException When value cannot be converted to the Tcl object.
     * @throws TclException When FFI api call is failed.
     */
    public function setVar(Interp $interp, string $varName, ?string $arrIndex, $value)
    {
        if (is_string($value)) {
            $obj = $this->newStringObj($value);
        } elseif (is_int($value)) {
            $obj = $this->newIntObj($value);
        } elseif (is_float($value)) {
            $obj = $this->newFloatObj($value);
        } elseif (is_bool($value)) {
            $obj = $this->newBoolObj($value);
        } else {
            throw new TclException(sprintf('Failed to convert PHP value type "%s" to Tcl object value.', gettype($value)));
        }

        $part1 = $this->newStringObj($varName);
        $part2 = $arrIndex ? $this->newStringObj($arrIndex) : NULL;
        $result = $this->ffi->Tcl_ObjSetVar2($interp->cdata(), $part1, $part2, $obj, self::TCL_LEAVE_ERR_MSG);
        if ($result === NULL) {
            throw new TclException('SetVar: ' . $this->getStringResult($interp));
        }
    }

    public function getVar(Interp $interp, string $varName, string $arrIndex = '')
    {
        $part1 = $this->newStringObj($varName);
        $part2 = $arrIndex ? $this->newStringObj($arrIndex) : NULL;
        $result = $this->ffi->Tcl_ObjGetVar2($interp->cdata(), $part1, $part2, self::TCL_LEAVE_ERR_MSG);
        if ($result === NULL) {
            throw new TclException('GetVar: ' . $this->getStringResult($interp));
        }
        return $result;
    }

    public function unsetVar(Interp $interp, string $var)
    {

    }
}